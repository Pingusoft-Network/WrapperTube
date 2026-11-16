<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>

<?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ob_start(); ?>
<?php if(!isset($_SESSION['siteusername'])) { die(header("Location: /sign_in")); } ?>
<?php
    $search = $_SESSION['siteusername'];

    $stmt = $__db->prepare("SELECT count(*) FROM favorite_video WHERE sender = :username");
    $stmt->bindParam(":username", $_SESSION['siteusername']);
    $stmt->execute();
    $number_of_result = (int)$stmt->fetchColumn();
    $stmt = null;

    $results_per_page = 12;
    $number_of_page = ceil ($number_of_result / $results_per_page);  

    if (!isset ($_GET['page']) ) {  
        $page = 1;  
    } else {  
        $page = (int)$_GET['page'];  
    }  

    $page_first_result = ($page - 1) * $results_per_page;

    if($_GET['filter'] == "time") {
        $stmt6 = $__db->prepare("SELECT * FROM favorite_video WHERE sender = :search ORDER BY id DESC LIMIT :pfirst, :pper");
        $stmt6->bindParam(":search", $search);
        $stmt6->bindParam(":pfirst", $page_first_result);
        $stmt6->bindParam(":pper", $results_per_page);
        $stmt6->execute();
    } else if($_GET['filter'] == "title") {
        $stmt6 = $__db->prepare("SELECT * FROM favorite_video WHERE sender = :search ORDER BY title LIMIT :pfirst, :pper");
        $stmt6->bindParam(":search", $search);
        $stmt6->bindParam(":pfirst", $page_first_result);
        $stmt6->bindParam(":pper", $results_per_page);
        $stmt6->execute();
    }
?>              
<table style="width: 100%;">
    <tr>
        <th style="width: 80%;">

        </th>
        <th style="margin: 5px; width: 20%;"></th>
    </tr>
    
    <?php
        while($video = $stmt6->fetch(PDO::FETCH_ASSOC)) { 
            if($__video_h->video_exists($video['reciever'])) {
                $_video = $__video_h->fetch_video_rid($video['reciever']);
    $_video['stars'] = $__video_h->get_video_stars($_video['rid']) + $__video_h->get_video_likes($_video['rid'], true) + $__video_h->get_video_likes($_video['rid'], false);
    $_video['star_1'] = $__video_h->get_video_stars_level($_video['rid'], 1) + $__video_h->get_video_likes($_video['rid'], false);
    $_video['star_2'] = $__video_h->get_video_stars_level($_video['rid'], 2);
    $_video['star_3'] = $__video_h->get_video_stars_level($_video['rid'], 3);
    $_video['star_4'] = $__video_h->get_video_stars_level($_video['rid'], 4);
    $_video['star_5'] = $__video_h->get_video_stars_level($_video['rid'], 5) + $__video_h->get_video_likes($_video['rid'], true);
                    //@$_video['star_ratio'] = ($_video['star_1'] + $_video['star_2'] + $_video['star_3'] + $_video['star_4'] + $_video['star_5']) / $_video['stars'];

                    /*
                        5 star - 252
                        4 star - 124
                        3 star - 40
                        2 star - 29
                        1 star - 33

                        totally 478

                        (252*5 + 124*4 + 40*3 + 29*2 + 33*1) / (252 + 124 + 40 + 29 + 33)
                    */

                    if($_video['stars'] != 0) {
                        @$_video['star_ratio'] = (
                            $_video['star_5'] * 5 +
                            $_video['star_4'] * 4 +
                            $_video['star_3'] * 3 +
                            $_video['star_2'] * 2 +
                            $_video['star_1'] * 1
                        ) / (
                            $_video['star_5'] +
                            $_video['star_4'] +
                            $_video['star_3'] +
                            $_video['star_2'] +
                            $_video['star_1']
                        );

                        $_video['star_ratio'] = floor($_video['star_ratio'] * 2) / 2;
                    } else {
                        $_video['star_ratio'] = 0;
                    }
                $_video['video_responses'] = $__video_h->get_video_responses($_video['rid']);
                $_video['age'] = $__time_h->time_elapsed_string($_video['publish']);		
                $_video['duration'] = $__time_h->timestamp($_video['duration']);
                $_video['views'] = $__video_h->fetch_video_views($_video['rid']);
                $_video['author'] = htmlspecialchars($_video['author']);		
                $_video['title'] = htmlspecialchars($_video['title']);
                $_video['description'] = $__video_h->shorten_description($_video['description'], 50);

                if($_video['thumbnail'] == ".png" && $_video['filename'] == ".mp4") {
                    $status = "Corrupted";
                } else if($_video['visibility'] == "v") {
                    $status = "Approved";
                } else if($_video['visibility'] == "n") {
                    $status = "Approved";
                } else if($_video['visibility'] == "o") {
                    $status = "Disapproved";
                } else {
                    $status = "Unknown";
                }                      
                
                if($_video['commenting'] == "a") 
                    $_video['commentstatus'] = "Commenting allowed";
                else 
                    $_video['commentstatus'] = "Commenting disallowed";
    ?> 
    <tr style="margin-top: 5px;" id="videoslist">
        <td class="video-manager-left">
            <ul>
                <li class="video-list-item "><a href="/watch?v=<?php echo $_video['rid']; ?>" class="video-list-item-link yt-uix-sessionlink" data-sessionlink="ei=CNLr3rbS3rICFSwSIQodSW397Q%3D%3D&amp;feature=g-sptl%26cid%3Dinp-hs-ytg"><span class="ux-thumb-wrap contains-addto "><span class="video-thumb ux-thumb yt-thumb-default-120 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="/dynamic/thumbs/<?php echo $_video['thumbnail']; ?>" alt="<?php echo $_video['title']; ?>" data-thumb="/dynamic/thumbs/<?php echo $_video['thumbnail']; ?>" width="120"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $_video['duration']; ?></span>
                    <button onclick=";return false;" title="Watch Later" type="button" class="addto-button video-actions spf-nolink addto-watch-later-button yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip"  data-video-ids="<?php echo $_video['rid']; ?>" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
                    </span><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></button>
                    </span><span dir="ltr" class="title" title="<?php echo $_video['title']; ?>"><?php echo $_video['title']; ?></span><span class="stat">by <span class="yt-user-name " dir="ltr"><?php echo $_video['author']; ?></span></span><span class="stat view-count">  <span class="viewcount"><?php echo $_video['views']; ?> views</span>
                    </span>
<span class="stat">
<img src="/static/img/<?php echo ($_video['star_ratio']>=1)?'full':(($_video['star_ratio']>=0.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($_video['star_ratio']>=2)?'full':(($_video['star_ratio']>=1.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($_video['star_ratio']>=3)?'full':(($_video['star_ratio']>=2.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($_video['star_ratio']>=4)?'full':(($_video['star_ratio']>=3.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($_video['star_ratio']>=5)?'full':(($_video['star_ratio']>=4.5)?'half':'empty'); ?>_star_s.png">
</span></a>
                    <a href="javascript:void(0);" onclick="remove_it('<?php echo $_video['rid']; ?>',$(this));return false;">
                        <button type="button" class=" yt-uix-button yt-uix-button-default" role="button">
                            Remove
                        </button>
                    </a>
                </li>
            </ul>
        </div>
        </td>
        <td class="video-manager-stats">
            <span class="video-manager-span" style="width:140px;display: inline-block;margin-bottom: 4px;">
            <span class="small-text">Views: </span><span style="float:right;"><?php echo $__video_h->fetch_video_views($_video['rid']); ?></span>
            </span><br>

            <span class="video-manager-span" style="width:140px;display: inline-block;margin-bottom: 4px;">
            <span class="small-text">Comments: </span><span style="float:right;"><?php echo $__video_h->get_comments_from_video($_video['rid']); ?></span>
            </span><br>

            <span class="video-manager-span" style="width:140px;display: inline-block;margin-bottom: 4px;">
            <span class="small-text">Video Responses: </span><span style="float:right;"><?php echo $_video['video_responses']; ?></span>
            </span><br>

            <span class="video-manager-span" style="width:140px;display: inline-block;margin-bottom: 4px;">
            <span class="small-text">Ratings: </span><span style="float:right;"><?php echo $_video['stars']; ?></span>
            </span><br>
        </td>
    </tr>
    <?php } } $stmt6 = null; ?>
</table> 
<?php
$content = ob_get_clean();
header('Content-Type: application/json');
echo '{"content_html": ' . json_encode($content) . '}';
exit();
