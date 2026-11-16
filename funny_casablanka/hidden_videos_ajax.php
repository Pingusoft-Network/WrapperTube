<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php if(!isset($_SESSION['siteusername'])) { header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found"); include $_SERVER['DOCUMENT_ROOT'] . '/404.php'; die(); } ?>
<?php if(!$__user_h->if_admin($_SESSION['siteusername'])) { header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found"); include $_SERVER['DOCUMENT_ROOT'] . '/404.php'; die(); } ?>
<?php $__time_h = new time_helper(); ob_start(); ?>
<?php
    $search = $_SESSION['siteusername'];

    $stmt = $__db->prepare("SELECT count(*) FROM videos WHERE visibility <> 'n'");
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
        $stmt6 = $__db->prepare("SELECT * FROM videos WHERE visibility <> 'n' ORDER BY id DESC LIMIT :pfirst, :pper");
        $stmt6->bindParam(":pfirst", $page_first_result);
        $stmt6->bindParam(":pper", $results_per_page);
        $stmt6->execute();
    } else if($_GET['filter'] == "title") {
        $stmt6 = $__db->prepare("SELECT * FROM videos WHERE visibility <> 'n' ORDER BY title LIMIT :pfirst, :pper");
        $stmt6->bindParam(":pfirst", $page_first_result);
        $stmt6->bindParam(":pper", $results_per_page);
        $stmt6->execute();
    }
?>              
                                <table style="width: 100%;">
                                    <tr>
                                        <!-- <th style="margin: 5px; width: 5%;"></th> -->
                                        <th style="width: 80%;">
                                            <small class="video-filter-options">
                                                Sort by:
                                                    <a id="selector-title" onclick="changeFilter_Title();" <?php if($_GET['filter'] == "title") { ?>class="selected"<?php } ?>>Title</a> |
                                                    <a id="selector-time" onclick="changeFilter_Time();" <?php if($_GET['filter'] == "time") { ?>class="selected"<?php } ?>>Time</a>
                                            </small>
                                        </th>
                                        <th style="margin: 5px; width: 20%;"></th>
                                    </tr>

                                    <?php
                                        while($video = $stmt6->fetch(PDO::FETCH_ASSOC)) {
    $video['stars'] = $__video_h->get_video_stars($video['rid']) + $__video_h->get_video_likes($video['rid'], true) + $__video_h->get_video_likes($video['rid'], false);
    $video['star_1'] = $__video_h->get_video_stars_level($video['rid'], 1) + $__video_h->get_video_likes($video['rid'], false);
    $video['star_2'] = $__video_h->get_video_stars_level($video['rid'], 2);
    $video['star_3'] = $__video_h->get_video_stars_level($video['rid'], 3);
    $video['star_4'] = $__video_h->get_video_stars_level($video['rid'], 4);
    $video['star_5'] = $__video_h->get_video_stars_level($video['rid'], 5) + $__video_h->get_video_likes($video['rid'], true);
                    //@$video['star_ratio'] = ($video['star_1'] + $video['star_2'] + $video['star_3'] + $video['star_4'] + $video['star_5']) / $video['stars'];

                    /*
                        5 star - 252
                        4 star - 124
                        3 star - 40
                        2 star - 29
                        1 star - 33

                        totally 478

                        (252*5 + 124*4 + 40*3 + 29*2 + 33*1) / (252 + 124 + 40 + 29 + 33)
                    */

                    if($video['stars'] != 0) {
                        @$video['star_ratio'] = (
                            $video['star_5'] * 5 +
                            $video['star_4'] * 4 +
                            $video['star_3'] * 3 +
                            $video['star_2'] * 2 +
                            $video['star_1'] * 1
                        ) / (
                            $video['star_5'] +
                            $video['star_4'] +
                            $video['star_3'] +
                            $video['star_2'] +
                            $video['star_1']
                        );

                        $video['star_ratio'] = floor($video['star_ratio'] * 2) / 2;
                    } else {
                        $video['star_ratio'] = 0;
                    }
                                            $video['video_responses'] = $__video_h->get_video_responses($video['rid']);
                                            $video['age'] = $__time_h->time_elapsed_string($video['publish']);
                                            $video['duration'] = $__time_h->timestamp($video['duration']);
                                            $video['views'] = $__video_h->fetch_video_views($video['rid']);
                                            $video['author'] = htmlspecialchars($video['author']);
                                            $video['title'] = htmlspecialchars($video['title']);
                                            $video['description'] = $__video_h->shorten_description($video['description'], 999999);

                                            if($video['thumbnail'] == ".png" && $video['filename'] == ".mp4") {
                                                $status = "Corrupted";
                                            } else if($video['visibility'] == "v") {
                                                $status = "Approved";
                                            } else if($video['visibility'] == "n") {
                                                $status = "Approved";
                                            } else if($video['visibility'] == "o") {
                                                $status = "Disapproved";
                                            } else {
                                                $status = "Unknown";
                                            }

                                            if($video['commenting'] == "a")
                                                $video['commentstatus'] = "Commenting allowed";
                                            else
                                                $video['commentstatus'] = "Commenting disallowed";
                                    ?>
                                    <tr style="margin-top: 5px;" id="videoslist">
                                        <td class="video-manager-left">
                                            <ul>
                                                <li class="video-list-item "><a href="/watch?v=<?php echo $video['rid']; ?>" class="video-list-item-link yt-uix-sessionlink" data-sessionlink="ei=CNLr3rbS3rICFSwSIQodSW397Q%3D%3D&amp;feature=g-sptl%26cid%3Dinp-hs-ytg"><span class="ux-thumb-wrap contains-addto "><span class="video-thumb ux-thumb yt-thumb-default-120 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img onerror=";this.src='/dynamic/thumbs/default.jpg';" src="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" alt="<?php echo $video['title']; ?>" data-thumb="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" width="120"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $video['duration']; ?></span>
                                                    <button onclick=";return false;" title="Watch Later" type="button" class="addto-button video-actions spf-nolink addto-watch-later-button yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" data-video-ids="<?php echo $video['rid']; ?>" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
                                                    </span><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></button>
                                                    </span><span dir="ltr" class="title" title="<?php echo $video['title']; ?>"><?php echo $video['title']; ?></span>
                                                    <span class="stat">by <span class="yt-user-name " dir="ltr"><?php echo $video['author']; ?></span></span>
                                                    <span class="stat view-count">  <span class="viewcount"><?php echo $video['views']; ?> views</span>
                                                    <span class="stat"><img src="/static/img/<?php echo ($video['star_ratio']>=1)?'full':(($video['star_ratio']>=0.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($video['star_ratio']>=2)?'full':(($video['star_ratio']>=1.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($video['star_ratio']>=3)?'full':(($video['star_ratio']>=2.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($video['star_ratio']>=4)?'full':(($video['star_ratio']>=3.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($video['star_ratio']>=5)?'full':(($video['star_ratio']>=4.5)?'half':'empty'); ?>_star_s.png"></span>
                                                    </span></a>
<span class="stat" style="width: 580px;white-space: normal;height: 100px;">
<?php echo $video['description']; ?>
</span>
                                                </li>
                                            </ul>
                                                <a href="/funny_casablanka/delete_video_admin?v=<?php echo $video['rid']; ?>" onclick="return confirm('Are you sure you want to delete this video?');" style="display:inline-block;">
                                                    <button type="button" class="yt-uix-button yt-uix-button-default" role="button">
                                                        Delete
                                                    </button>
                                                </a>

                                                <span style="margin-left:10px">
                                                    <?php switch ($video['visibility']) {
                                                    case 'n': ?>
                                                    <img src="/s/img/public.png"> <span style="font-size: 11px;position: relative;bottom: 2px;left: 5px;">Public</span>
                                                    <?php break;
                                                    case 'u': ?>
                                                    <img src="/s/img/unlisted.png"> <span style="font-size: 11px;position: relative;bottom: 2px;left: 5px;">Unlisted</span>
                                                    <?php break;
                                                    case 'v': ?>
                                                    <img src="/s/img/private.png"> <span style="font-size: 11px;position: relative;bottom: 2px;left: 5px;">Private</span>
                                                    <?php break;
                                                    } ?>
                                                </span>
                                        </div>
                                        </td>
                                        <td class="video-manager-stats" style="background: none;padding-left: 8px;">
                                            <span class="video-manager-span" style="width:140px;display: inline-block;margin-bottom: 4px;">
                                            <span class="small-text">Views: </span><span style="float:right;"><?php echo $__video_h->fetch_video_views($video['rid']); ?></span>
                                            </span><br>

                                            <span class="video-manager-span" style="width:140px;display: inline-block;margin-bottom: 4px;">
                                            <span class="small-text">Comments: </span><span style="float:right;"><?php echo $__video_h->get_comments_from_video($video['rid']); ?></span>
                                            </span><br>

                                            <span class="video-manager-span" style="width:140px;display: inline-block;margin-bottom: 4px;">
                                            <span class="small-text">Video Responses: </span><span style="float:right;"><?php echo $video['video_responses']; ?></span>
                                            </span><br>

                                            <span class="video-manager-span" style="width:140px;display: inline-block;margin-bottom: 4px;">
                                            <span class="small-text">Ratings: </span><span style="float:right;"><?php echo $video['stars']; ?></span>
                                            </span><br>

                                            <span class="video-manager-span" style="width:140px;display: inline-block;margin-bottom: 4px;">
                                            <span class="small-text">File Name: </span><span style="float:right;"><?php echo $video['filename']; ?></span>
                                            </span><br>
                                        </td>
                                    </tr>
                                    <?php } $stmt = null; ?>
                                </table>
<?php
$content = ob_get_clean();
header('Content-Type: application/json');
echo '{"content_html": ' . json_encode($content) . '}';
exit();
