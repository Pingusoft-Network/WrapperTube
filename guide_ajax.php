<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php header('Content-Type: application/json'); ?>
<?php
ob_start();
    if(!isset($_GET['action_load_user_feed'])) {
        switch(@$_GET['chart_name']) {
        case "trending":
            $category = 'Being Watched Now';
            $diviconn = 'trending';
            break;
        case "popular":
            $category = 'Popular';
            $diviconn = 'popular';
            break;
        case "feed":
            $category = 'Subscribed Channels';
            $diviconn = 'social-all';
            break;
        case "history":
            $category = 'History';
            $diviconn = 'education';
            break;
        case "music":
            $category = 'Music';
            $diviconn = 'music';
            break;
        case "entertainment":
            $category = 'Entertainment';
            $diviconn = 'entertainment';
            break;
        case "sports":
            $category = 'Sports';
            $diviconn = 'sports';
            break;
        case "comedy":
            $category = 'Comedy';
            $diviconn = 'comedy';
            break;
        case "film":
            $category = 'Film & Animation';
            $diviconn = 'film';
            break;
        case "gadgets":
            $category = 'Gaming';
            $diviconn = 'gadgets';
            break;
        }
        
        switch(@$_GET['feed_name']) {
        case "trending":
            $category = 'Being Watched Now';
            $diviconn = 'trending';
            break;
        case "popular":
            $category = 'Popular';
            $diviconn = 'popular';
            break;
        case "feed":
            $category = 'Subscribed Channels';
            $diviconn = 'social-all';
            break;
        case "history":
            $category = 'History';
            $diviconn = 'education';
            break;
        case "music":
            $category = 'Music';
            $diviconn = 'music';
            break;
        case "entertainment":
            $category = 'Entertainment';
            $diviconn = 'entertainment';
            break;
        case "sports":
            $category = 'Sports';
            $diviconn = 'sports';
            break;
        case "comedy":
            $category = 'Comedy';
            $diviconn = 'comedy';
            break;
        case "film":
            $category = 'Film & Animation';
            $diviconn = 'film';
            break;
        case "gadgets":
            $category = 'Gaming';
            $diviconn = 'gadgets';
            break;
        }
	if ($category == "Subscribed Channels") {
	$stmt = $__db->prepare("SELECT * FROM videos WHERE visibility = 'n' ORDER BY id DESC LIMIT 250");
        $stmt->execute();
	} else if ($category == "Being Watched Now") {
        $stmt = $__db->prepare("SELECT videoid FROM views ORDER BY id DESC LIMIT 20");
        $stmt->execute();
        } else if ($category == "History") {
        $stmt = $__db->prepare("SELECT video FROM history WHERE author = :author ORDER BY id DESC LIMIT 20");
        $stmt->bindParam(":author", $_SESSION['siteusername']);
        $stmt->execute();
        } else if ($category == "Popular") {
        $stmt = $__db->prepare("SELECT
                                v.*,
                                l.count AS viewcount
                                FROM
                                videos v
                                LEFT JOIN
                                (SELECT videoid, COUNT(*) AS count FROM views GROUP BY videoid)
                                AS l
                                ON v.rid = l.videoid
                                WHERE v.visibility = 'n'
                                AND v.publish >= DATE_SUB(CURDATE(), INTERVAL 1 DAY)
                                ORDER BY viewcount DESC LIMIT 20");
        $stmt->execute();
        } else {
        $stmt = $__db->prepare("SELECT * FROM videos WHERE category = :category AND visibility = 'n' ORDER BY id DESC LIMIT 20");
        $stmt->bindParam(":category", $category);
        $stmt->execute();
        }
    } else {
        $username = $_GET['user_id'];
        $category =  str_replace("'", "\\'", str_replace("\\", "\\\\", htmlspecialchars($_GET['user_id'])));
        $diviconn = "trending";
        $stmt = $__db->prepare("SELECT * FROM videos WHERE author = :username AND visibility = 'n' ORDER BY id DESC LIMIT 20");
        $stmt->bindParam(":username", $username);
        $stmt->execute();
    }
	?>
{'paging': null, 'feed_html': '
<div class=\'feed-header no-metadata\'>
	<div class=\'feed-header-thumb\'>
		<img class=\'feed-header-icon <?php echo $diviconn; ?>\' src=\'//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif\' alt=\'\'>
	</div>
	<div class=\'feed-header-details\'>
		<h2>    <?php echo $category; ?><?php if ($category == "Subscribed Channels") { ?> <a href="/feed/subscriptions" title="Your Subscriptions RSS Feed"><img src="/static/img/feed-icon-small.png" alt="feed icon" width="14" height="14"></a><?php } else if ($category == 'Being Watched Now') { ?> <a href="/feed/being_watched_now" title="Videos Being Watched Now"><img src="/static/img/feed-icon-small.png" alt="feed icon" width="14" height="14"></a><?php } else if ($category == 'Popular') { ?> <a href="/feed/popular_today" title="Popular Today"><img src="/static/img/feed-icon-small.png" alt="feed icon" width="14" height="14"></a><?php } else if ($username) { ?> <a href="/feed/channel?n=<?php echo $category; ?>" title="Videos RSS Feed"><img src="/static/img/feed-icon-small.png" alt="feed icon" width="14" height="14"></a><?php } else if ($category != "History") { ?> <a href="/feed/videos?c=<?php echo urlencode($category); ?>" title="Latest videos on <?php echo str_replace("'", "\\'", str_replace("\\", "\\\\", htmlspecialchars($category))); ?>"><img src="/static/img/feed-icon-small.png" alt="feed icon" width="14" height="14"></a><?php } ?></h2>
	</div>
</div>
<div class=\'feed-container\' data-filter-type=\'\' data-view-type=\'\'>
<div class=\'feed-page\'>
	<ul>
        <?php
            $i = 0;
            while($video = $stmt->fetch(PDO::FETCH_ASSOC)) {	
                if ($category == "Subscribed Channels") {
                    if (!$__user_h->if_subscribed(@$_SESSION['siteusername'], $video['author'])) {
                        continue;
                    }
                    if ($i > 20) {
                        break;
                    }
                    $i++;
                }
                if ($category == "Being Watched Now") {
                    $video = $__video_h->fetch_video_rid($video['videoid']);
                    if ($video['visibility'] != 'n') {
                        continue;
                    }
                }
                if ($category == "History") {
                    $video = $__video_h->fetch_video_rid($video['video']);
                }
                if (!$video) { continue; }
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
                $video['age'] = $__time_h->time_elapsed_string($video['publish']);		
                $video['duration'] = $__time_h->timestamp($video['duration']);
                $video['views'] = $__video_h->fetch_video_views($video['rid']);
                $video['author'] = str_replace("'", "\\'", str_replace("\\", "\\\\", htmlspecialchars($video['author'])));		
                $video['title'] = str_replace("'", "\\'", str_replace("\\", "\\\\", htmlspecialchars($video['title'])));
                $video['description'] = str_replace("'", "\\'", str_replace("\\", "\\\\", $__video_h->shorten_description($video['description'], 50)));
        ?>
        <li>
            <div class="feed-item-container first " data-channel-key="UCR2A9ZNliJfgC66IvIpe-Zw">
                <div class="feed-author-bubble-container">
                    <a href="/user/<?php echo $video['author']; ?>" class="feed-author-bubble   ">  <span class="feed-item-author">
                    <span class="video-thumb ux-thumb yt-thumb-square-28 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="<?php echo $video['author']; ?>" data-thumb="/dynamic/pfp/<?php echo $__user_h->fetch_pfp($video['author']); ?>" width="28"><span class="vertical-align"></span></span></span></span>
                    </span>
                    </a>  
                </div>
                <div class="feed-item-main">
                    <div class="feed-item-header">
                        <span class="feed-item-actions-line ">
                        <span class="feed-item-owner">    <a href="/user/<?php echo $video['author']; ?>" class="yt-uix-sessionlink yt-user-name " data-sessionlink="feature=g-logo-xit" dir="ltr"><?php echo $video['author']; ?></a>
                        </span>
                        uploaded a video
                        <span class="feed-item-time">
                        <?php echo $video['age']; ?>
                        </span>
                        </span>
                    </div>
                    <div class="feed-item-content-wrapper clearfix">
                        <div class="feed-item-thumb">
                            <a class="ux-thumb-wrap contains-addto  yt-uix-contextlink yt-uix-sessionlink" data-sessionlink="ei=CNLr3rbS3rICFSwSIQodSW397Q%3D%3D&amp;context=G266dc06FOAAAAAAAAAA" href="/watch?v=<?php echo $video['rid']; ?>">
                            <span class="video-thumb ux-thumb yt-thumb-default-185 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Thumbnail" onerror="this.onerror=null;this.src=\'/dynamic/thumbs/default.jpg\';" data-thumb="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" width="185"><span class="vertical-align"></span></span></span></span>
                            <span class="video-time"><?php echo $video['duration']; ?></span>
                            <button onclick=";return false;" title="Watch Later" type="button" class="addto-button video-actions spf-nolink addto-watch-later-button yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" data-video-ids="<?php echo $video['rid']; ?>" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
                            </span><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></button>
                            </a>
                        </div>
                        <div class="feed-item-content">
                            <h4>
                                <a class="feed-video-title title yt-uix-contextlink  yt-uix-sessionlink  secondary" href="/watch?v=<?php echo $video['rid']; ?>" data-sessionlink="ei=CNLr3rbS3rICFSwSIQodSW397Q%3D%3D&amp;feature=g-logo-xit&amp;context=G266dc06FOAAAAAAAAAA">
                                    <?php echo $video['title']; ?>
                                </a>
                            </h4>
                            <div class="metadata">
                                <a href="/user/<?php echo $video['author']; ?>" class="yt-user-photo ">
                                <span class="video-thumb ux-thumb yt-thumb-square-18 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="<?php echo $video['author']; ?>" data-thumb="/dynamic/pfp/<?php echo $__user_h->fetch_pfp($video['author']); ?>" width="18"><span class="vertical-align"></span></span></span></span>
                                </a>
                                <a href="/user/<?php echo $video['author']; ?>" class="yt-uix-sessionlink yt-user-name " data-sessionlink="ei=CNLr3rbS3rICFSwSIQodSW397Q%3D%3D&amp;feature=g-logo-xit" dir="ltr"><?php echo $video['author']; ?></a>
                                <span class="bull">•</span>
                                <span class="view-count">
                                <?php echo $video['views']; ?> views
                                </span>
                                <span class="bull">•</span>
                                <span class="view-count" style="white-space:nowrap;">
<img src="/static/img/<?php echo ($video['star_ratio']>=1)?'full':(($video['star_ratio']>=0.5)?'half':'empty'); ?>_star_s.png"> 
<img src="/static/img/<?php echo ($video['star_ratio']>=2)?'full':(($video['star_ratio']>=1.5)?'half':'empty'); ?>_star_s.png"> 
<img src="/static/img/<?php echo ($video['star_ratio']>=3)?'full':(($video['star_ratio']>=2.5)?'half':'empty'); ?>_star_s.png"> 
<img src="/static/img/<?php echo ($video['star_ratio']>=4)?'full':(($video['star_ratio']>=3.5)?'half':'empty'); ?>_star_s.png"> 
<img src="/static/img/<?php echo ($video['star_ratio']>=5)?'full':(($video['star_ratio']>=4.5)?'half':'empty'); ?>_star_s.png"> 
                                </span>
                                <div class="description">
                                    <p><?php echo $video['description']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="feed-item-dismissal-notices">
                <div class="feed-item-dismissal feed-item-dismissal-hide hid">This item has been hidden</div>
                <div class="feed-item-dismissal feed-item-dismissal-uploads hid">In the future you will only see uploads from   <span class="feed-item-owner">    <a href="/user/<?php echo $video['author']; ?>" class="yt-uix-sessionlink yt-user-name " data-sessionlink="feature=g-logo-xit" dir="ltr"><?php echo $video['author']; ?></a>
                    </span>
                </div>
                <div class="feed-item-dismissal feed-item-dismissal-all-activity hid">In the future you will see all activity from   <span class="feed-item-owner">    <a href="/user/<?php echo $video['author']; ?>" class="yt-uix-sessionlink yt-user-name " data-sessionlink="feature=g-logo-xit" dir="ltr"><?php echo $video['author']; ?></a>
                    </span>
                </div>
                <div class="feed-item-dismissal feed-item-dismissal-unsubscribe hid">You have been unsubscribed from   <span class="feed-item-owner">    <a href="/user/<?php echo $video['author']; ?>" class="yt-uix-sessionlink yt-user-name " data-sessionlink="feature=g-logo-xit" dir="ltr"><?php echo $video['author']; ?></a>
                    </span>
                </div>
            </div>
        </li>
        <?php } $stmt = null; ?>
	</ul>
</div>
'}
<?php
$the_output = ob_get_clean();
echo str_replace(array("\r", "\n"), '', $the_output);
?>
