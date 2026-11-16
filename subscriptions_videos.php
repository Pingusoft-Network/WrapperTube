<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/important/bbcode.php"); ?>
<?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php if(!isset($_SESSION['siteusername'])) { die(header("Location: /sign_in")); } ?>
<?php
	$__server->page_embeds->page_title = "WrapperTube - Subscriptions Videos";
	$__server->page_embeds->page_description = "WrapperTube is a site where you can upload your videos, animations, Scratch Projects, Artwork, music, and anything.";
	$__server->page_embeds->page_image = "/yt/imgbin/full-size-logo.png";
	$__server->page_embeds->page_url = "http://wrappertube.org/";
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $__server->page_embeds->page_title; ?></title>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="content-script-type" content="text/javascript">
<meta http-equiv="content-style-type" content="text/css">
<meta name="description" content="<?php echo $__server->page_embeds->page_description; ?>">
<meta name="theme-color" content="red">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
		<meta property="og:title" content="<?php echo $__server->page_embeds->page_title; ?>" />
		<meta property="og:url" content="<?php echo $__server->page_embeds->page_url; ?>" />
		<meta property="og:description" content="<?php echo $__server->page_embeds->page_description; ?>" />
		<meta property="og:image" content="<?php echo $__server->page_embeds->page_image; ?>" />
        <script src="/static/js/core-js.js"></script>
<link rel="alternate" type="application/atom+xml" title="Your Subscriptions RSS Feed" href="/feed/subscriptions">
<?php
$stmt = $__db->prepare("SELECT * FROM subscribers WHERE sender = :username ORDER BY id DESC");
$stmt->bindParam(":username", $_SESSION['siteusername']);
$stmt->execute();
while($channel = $stmt->fetch(PDO::FETCH_ASSOC)) { $channel = $channel['reciever']; ?>
<link rel="alternate" type="application/atom+xml" title="Latest videos from &quot;<?php echo htmlspecialchars($channel); ?>&quot; RSS feed" href="/feed/channel?n=<?php echo urlencode($channel); ?>">
<?php } $stmt = null; ?>
        <script>
            var yt = yt || {};yt.timing = yt.timing || {};yt.timing.tick = function(label, opt_time) {var timer = yt.timing['timer'] || {};if(opt_time) {timer[label] = opt_time;}else {timer[label] = new Date().getTime();}yt.timing['timer'] = timer;};yt.timing.info = function(label, value) {var info_args = yt.timing['info_args'] || {};info_args[label] = value;yt.timing['info_args'] = info_args;};yt.timing.info('e', "904821,919006,922401,920704,912806,913419,913546,913556,919349,919351,925109,919003,920201,912706");if (document.webkitVisibilityState == 'prerender') {document.addEventListener('webkitvisibilitychange', function() {yt.timing.tick('start');}, false);}yt.timing.tick('start');yt.timing.info('li','0');try {yt.timing['srt'] = window.gtbExternal && window.gtbExternal.pageT() ||window.external && window.external.pageT;} catch(e) {}if (window.chrome && window.chrome.csi) {yt.timing['srt'] = Math.floor(window.chrome.csi().pageT);}if (window.msPerformance && window.msPerformance.timing) {yt.timing['srt'] = window.msPerformance.timing.responseStart - window.msPerformance.timing.navigationStart;}    
        </script>
        <link id="www-core-css" rel="stylesheet" href="/yt/cssbin/www-core-vfluMRDnk.css">
        <link rel="stylesheet" href="/yt/cssbin/www-guide-vflx0V5Tq.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/static/js/scratchblocks.min.js"></script>
    <script type="text/javascript" src="/static/js/translations.js" charset="utf-8"></script>
    <script type="text/javascript">
    (function ($) {
        scratchblocks._currentLanguage = 'en';
        scratchblocks._currentLanguages = ['en'];
    })(jQuery);
    </script>
        <script>
            if (window.yt.timing) {yt.timing.tick("ct");}    
        </script>
<style type="text/css">
        .tag-cloud {
            padding: 4px;
            text-align: center;
            line-height: 1.2;
        }
        .tag-cloud a {
            margin: 0 6px;
            color: #0073aa;
            text-decoration: none;
            display: inline-block;
        }
        .tag-cloud a:hover {
            text-decoration: underline;
            color: #005177;
        }
</style>
    <script type="text/javascript">
    $(document).ready(function() {
      scratchblocks.renderMatching('pre.blocks', {
        languages: scratchblocks._currentLanguages,
        replace: function(el, svg, doc, options) {
          // add scratchblocks to `el`
          scratchblocks.replace(el, svg, doc, options);
        }
      });
    });
    </script>
<link rel="stylesheet" href="/static/css/bbcode.css?v2">
	</head>
	<body id="" class="date-20120930 en_US ltr   ytg-old-clearfix guide-feed-v2 " dir="ltr">
		<form name="logoutForm" method="POST" action="/logout">
			<input type="hidden" name="action_logout" value="1">
		</form>
		<!-- begin page -->
		<div id="page" class="">
			<div id="masthead-container"><?php require($_SERVER['DOCUMENT_ROOT'] . "/s/mod/header.php"); ?></div>
			<div id="content-container">
				<!-- begin content -->
				<div id="content">
					<h3><a href="/account/">My Account</a> / Subscriptions Videos</h3>
					<hr><br>
					<div class="guide-layout-container enable-fancy-subscribe-button">
						<div class="guide-container">
							<div class="guide">
								<div class="guide-section yt-uix-expander  first ">
									<h3 class="guide-item-container selected-child">
										<a class="guide-item selected" data-feed-name="feed" data-feed-type="system">
										<span class="thumb">
										<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="" class="system-icon system social">
										</span>
										<span class="display-name">
										Subscribed Channels
										</span>
										</a>
									</h3>
                                            <?php
                                                $stmt = $__db->prepare("SELECT * FROM subscribers WHERE sender = :username ORDER BY id DESC");
                                                $stmt->bindParam(":username", $_SESSION['siteusername']);
                                                $stmt->execute();
                                                while($channel = $stmt->fetch(PDO::FETCH_ASSOC)) { $channel = $channel['reciever']; ?>
                                                <li class="guide-item-container ">
                                                    <a class="guide-item" data-external-id="<?php echo htmlspecialchars($channel); ?>" data-feed-name="<?php echo htmlspecialchars($channel); ?>" data-feed-type="user">
                                                    <span class="thumb">  <span class="video-thumb ux-thumb yt-thumb-square-28 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Thumbnail" onerror="this.onerror=null;this.src='/dynamic/thumbs/default.jpg';" data-thumb="/dynamic/pfp/<?php echo $__user_h->fetch_pfp($channel); ?>" width="28"><span class="vertical-align"></span></span></span></span>
                                                    </span>
                                                    <span class="display-name">
                                                        <?php echo htmlspecialchars($channel); ?>
                                                    </span>
                                                    </a>
                                                </li> 
                                            <?php } $stmt = null; ?>
									</ul>
									<div class="guide-item-container">
										<span class="guide-item guide-item-action guide-item-fake">
										<a href="/subscriptions">see all<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="see-more-arrow" alt=""></a>        </span>
									</div>
								</div>
							</div>
						</div>
						<div class="guide-background"></div>
						<div id="feed" style="width: 770px;">
							<div id="feed-system-feed" class="individual-feed" data-loaded="true" data-feed-name="feed" data-feed-type="system">
								<div class="feed-header no-metadata">
									<div class="feed-header-thumb">
										<img class="feed-header-icon social-all" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
									</div>
									<div class="feed-header-details">
										<h2>    Subscribed Channels <a href="/feed/subscriptions" title="Your Subscriptions RSS Feed"><img src="/static/img/feed-icon-small.png" alt="feed icon" width="14" height="14"></a></h2>
									</div>
								</div>
								<div class="feed-container" data-filter-type="" data-view-type="">
									<div class="feed-page">
										<ul>
											<?php
        $stmt = $__db->prepare("SELECT * FROM videos WHERE visibility = 'n' ORDER BY id DESC LIMIT 250");
        $stmt->execute();
        $i = 0;
												while($video = $stmt->fetch(PDO::FETCH_ASSOC)) {	
		    if (!$__user_h->if_subscribed(@$_SESSION['siteusername'], $video['author'])) {
                        continue;
                    }
                    if ($i > 20) {
                        break;
                    }
                    $i++;
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
													$video['author'] = htmlspecialchars($video['author']);		
													$video['title'] = htmlspecialchars($video['title']);
													$video['description'] = $__video_h->shorten_description($video['description'], 50);
													$video['pfp'] = $__user_h->fetch_pfp($video['author']);
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
                            <span class="video-thumb ux-thumb yt-thumb-default-185 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Thumbnail" onerror="this.onerror=null;this.src='/dynamic/thumbs/default.jpg';" data-thumb="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" width="185"><span class="vertical-align"></span></span></span></span>
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
<?php

												} $stmt = null;
											?>
										</ul>
									</div>
								</div>
							</div>
							<div id="feed-error" class="individual-feed hid">
								<p class="feed-message">
									We were unable to complete the request, please try again later.
								</p>
							</div>
							<div id="feed-loading-template" class="hid">
								<div class="feed-message">
									<p class="loading-spinner">
										<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
										Loading...
									</p>
								</div>
							</div>
						</div>
						<div id="feed-background" style="width: 770px;"></div>
					</div>
				</div>
				<!-- end content -->
			</div>
			<div id="footer-container"><?php require($_SERVER['DOCUMENT_ROOT'] . "/s/mod/footer.php"); ?></div>
			<div id="playlist-bar" class="hid passive editable" data-video-url="/watch?v=&amp;feature=BFql&amp;playnext=1&amp;list=QL" data-list-id="" data-list-type="QL">
				<div id="playlist-bar-bar-container">
					<div id="playlist-bar-bar">
						<div class="yt-alert yt-alert-naked yt-alert-success hid " id="playlist-bar-notifications">
							<div class="yt-alert-icon">
								<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
							</div>
							<div class="yt-alert-content" role="alert"></div>
						</div>
						<span id="playlist-bar-info"><span class="playlist-bar-active playlist-bar-group"><button onclick=";return false;" title="Previous video" type="button" id="playlist-bar-prev-button" class="yt-uix-tooltip yt-uix-tooltip-masked  yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-playlist-bar-prev" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Previous video"><span class="yt-valign-trick"></span></span></button><span class="playlist-bar-count"><span class="playing-index">0</span> / <span class="item-count">0</span></span><button type="button" class="yt-uix-tooltip yt-uix-tooltip-masked  yt-uix-button yt-uix-button-default yt-uix-button-empty" onclick=";return false;" id="playlist-bar-next-button" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-playlist-bar-next" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""><span class="yt-valign-trick"></span></span></button></span><span class="playlist-bar-active playlist-bar-group"><button type="button" class="yt-uix-tooltip yt-uix-tooltip-masked  yt-uix-button yt-uix-button-default yt-uix-button-empty" onclick=";return false;" id="playlist-bar-autoplay-button" data-button-toggle="true" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-playlist-bar-autoplay" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""><span class="yt-valign-trick"></span></span></button><button type="button" class="yt-uix-tooltip yt-uix-tooltip-masked  yt-uix-button yt-uix-button-default yt-uix-button-empty" onclick=";return false;" id="playlist-bar-shuffle-button" data-button-toggle="true" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-playlist-bar-shuffle" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""><span class="yt-valign-trick"></span></span></button></span><span class="playlist-bar-passive playlist-bar-group"><button onclick=";return false;" title="Play videos" type="button" id="playlist-bar-play-button" class="yt-uix-tooltip yt-uix-tooltip-masked  yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-playlist-bar-play" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Play videos"><span class="yt-valign-trick"></span></span></button><span class="playlist-bar-count"><span class="item-count">0</span></span></span><span id="playlist-bar-title" class="yt-uix-button-group"><span class="playlist-title">Unsaved Playlist</span></span></span>
						<a id="playlist-bar-lists-back" href="#">
						Return to active list
						</a>
						<span id="playlist-bar-controls"><span class="playlist-bar-group"><button type="button" class="yt-uix-tooltip yt-uix-tooltip-masked  yt-uix-button yt-uix-button-text yt-uix-button-empty" onclick=";return false;" id="playlist-bar-toggle-button" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-playlist-bar-toggle" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""><span class="yt-valign-trick"></span></span></button></span><span class="playlist-bar-group"><button type="button" class="yt-uix-tooltip yt-uix-tooltip-masked yt-uix-button-reverse flip yt-uix-button yt-uix-button-text" onclick=";return false;" data-button-menu-id="playlist-bar-options-menu" data-button-has-sibling-menu="true" role="button"><span class="yt-uix-button-content">Options </span><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></button></span></span>      
					</div>
				</div>
				<div id="playlist-bar-tray-container">
					<div id="playlist-bar-tray" class="yt-uix-slider yt-uix-slider-fluid">
						<button class="yt-uix-button playlist-bar-tray-button yt-uix-button-default yt-uix-slider-prev" onclick="return false;"><img class="yt-uix-slider-prev-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Previous video"></button><button class="yt-uix-button playlist-bar-tray-button yt-uix-button-default yt-uix-slider-next" onclick="return false;"><img class="yt-uix-slider-next-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Next video"></button>
						<div class="yt-uix-slider-body">
							<div id="playlist-bar-tray-content" class="yt-uix-slider-slide">
								<ol class="video-list"></ol>
								<ol id="playlist-bar-help">
									<li class="empty playlist-bar-help-message">Your queue is empty. Add videos to your queue using this button: <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="addto-button-help"><br> or <a href="/sign_in">sign in</a> to load a different list.</li>
								</ol>
							</div>
							<div class="yt-uix-slider-shade-left"></div>
							<div class="yt-uix-slider-shade-right"></div>
						</div>
					</div>
					<div id="playlist-bar-save"></div>
					<div id="playlist-bar-lists" class="dark-lolz"></div>
					<div id="playlist-bar-loading"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Loading..."><span id="playlist-bar-loading-message">Loading...</span><span id="playlist-bar-saving-message" class="hid">Saving...</span></div>
					<div id="playlist-bar-template" style="display: none;" data-video-thumb-url="//i4.ytimg.com/vi/__video_encrypted_id__/default.jpg">
						<!--<li class="playlist-bar-item yt-uix-slider-slide-unit __classes__" data-video-id="__video_encrypted_id__"><a href="__video_url__" title="__video_title__" class="yt-uix-sessionlink" data-sessionlink="ei=CNLr3rbS3rICFSwSIQodSW397Q%3D%3D&amp;feature=BFa"><span class="video-thumb ux-thumb yt-thumb-default-106 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="__video_title__" data-thumb-manual="true" data-thumb="__video_thumb_url__" width="106" ><span class="vertical-align"></span></span></span></span><span class="screen"></span><span class="count"><strong>__list_position__</strong></span><span class="play"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif"></span><span class="yt-uix-button yt-uix-button-default delete"><img class="yt-uix-button-icon-playlist-bar-delete" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Delete"></span><span class="now-playing">Now playing</span><span dir="ltr" class="title"><span>__video_title__  <span class="uploader">by __video_display_name__</span>
							</span></span><span class="dragger"></span></a></li>-->
					</div>
					<div id="playlist-bar-next-up-template" style="display: none;">
						<!--<div class="playlist-bar-next-thumb"><span class="video-thumb ux-thumb yt-thumb-default-74 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="//i4.ytimg.com/vi/__video_encrypted_id__/default.jpg" alt="Thumbnail" onerror="this.onerror=null;this.src='/dynamic/thumbs/default.jpg';" width="74" ><span class="vertical-align"></span></span></span></span></div>-->
					</div>
				</div>
				<div id="playlist-bar-options-menu" class="hid">
					<div id="playlist-bar-extras-menu">
						<ul>
							<li><span class="yt-uix-button-menu-item" data-action="clear">
								Clear all videos from this list
								</span>
							</li>
						</ul>
					</div>
					<ul>
						<li><span class="yt-uix-button-menu-item" onclick="window.location.href='//support.google.com/youtube/bin/answer.py?answer=146749&amp;hl=en-US'">Learn more</span></li>
					</ul>
				</div>
			</div>
			<div id="shared-addto-watch-later-login" class="hid">
				<a href="/sign_in" class="sign-in-link">Sign in</a> to add this to a playlist
			</div>
			<div id="shared-addto-menu" style="display: none;" class="hid sign-in">
				<div class="addto-menu">
					<div id="addto-list-panel" class="menu-panel active-panel">
						<span class="yt-uix-button-menu-item yt-uix-tooltip sign-in" data-possible-tooltip="" data-tooltip-show-delay="750"><a href="/sign_in" class="sign-in-link">Sign in</a> to add this to a playlist
						</span>
					</div>
					<div id="addto-list-saved-panel" class="menu-panel">
						<div class="panel-content">
							<div class="yt-alert yt-alert-naked yt-alert-success  ">
								<div class="yt-alert-icon">
									<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
								</div>
								<div class="yt-alert-content" role="alert">
									<span class="yt-alert-vertical-trick"></span>
									<div class="yt-alert-message">
										<span class="message">Added to <span class="addto-title yt-uix-tooltip yt-uix-tooltip-reverse" title="More information about this playlist" data-tooltip-show-delay="750"></span></span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="addto-list-error-panel" class="menu-panel">
						<div class="panel-content">
							<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif">
							<span class="error-details"></span>
							<a class="show-menu-link">Back to list</a>
						</div>
					</div>
					<div id="addto-note-input-panel" class="menu-panel">
						<div class="panel-content">
							<div class="yt-alert yt-alert-naked yt-alert-success  ">
								<div class="yt-alert-icon">
									<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
								</div>
								<div class="yt-alert-content" role="alert">
									<span class="yt-alert-vertical-trick"></span>
									<div class="yt-alert-message">
										<span class="message">Added to playlist:</span>
										<span class="addto-title yt-uix-tooltip" title="More information about this playlist" data-tooltip-show-delay="750"></span>
									</div>
								</div>
							</div>
						</div>
						<div class="yt-uix-char-counter" data-char-limit="150">
							<div class="addto-note-box addto-text-box"><textarea id="addto-note" class="addto-note yt-uix-char-counter-input" maxlength="150"></textarea><label for="addto-note" class="addto-note-label">Add an optional note</label></div>
							<span class="yt-uix-char-counter-remaining">150</span>
						</div>
						<button disabled="disabled" type="button" class="playlist-save-note yt-uix-button yt-uix-button-default" onclick=";return false;" role="button"><span class="yt-uix-button-content">Add note </span></button>
					</div>
					<div id="addto-note-saving-panel" class="menu-panel">
						<div class="panel-content loading-content">
							<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif">
							<span>Saving note...</span>
						</div>
					</div>
					<div id="addto-note-saved-panel" class="menu-panel">
						<div class="panel-content">
							<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif">
							<span class="message">Note added to:</span>
						</div>
					</div>
					<div id="addto-note-error-panel" class="menu-panel">
						<div class="panel-content">
							<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif">
							<span class="message">Error adding note:</span>
							<ul class="error-details"></ul>
							<a class="add-note-link">Click to add a new note</a>
						</div>
					</div>
					<div class="close-note hid">
						<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="close-button">
					</div>
				</div>
			</div>
		</div>
		<!-- end page -->
<script id="www-core-js" src="/yt/jsbin/www-core-vfl1pq97W.js" data-loaded="true"></script>
		<script id="www-core-js" src="//s.ytimg.com/yt/jsbin/www-core-vfl1pq97W.js" data-loaded="true"></script>
		<script>
			yt.setConfig({
			'XSRF_TOKEN': 'iz8jtUnR4Eomusl012h4goGYKHl8MTM0OTE0MDU3NEAxMzQ5MDU0MTc0',
			'XSRF_FIELD_NAME': 'session_token'
			});
			yt.pubsub.subscribe('init', yt.www.xsrf.populateSessionToken);
			
			yt.setConfig('XSRF_REDIRECT_TOKEN', 'DKwX8BwPtPQ3NCknEYmL0VtXh6x8MTM0OTE0MDU3NEAxMzQ5MDU0MTc0');
			
			yt.setConfig({
			'EVENT_ID': "CNLr3rbS3rICFSwSIQodSW397Q==",
			'CURRENT_URL': "http:\/\/www.youtube.com\/",
			'LOGGED_IN': false,
			'SESSION_INDEX': null,
			
			'WATCH_CONTEXT_CLIENTSIDE': false,
			
			'FEEDBACK_LOCALE_LANGUAGE': "en",
			'FEEDBACK_LOCALE_EXTRAS': {"logged_in": false, "experiments": "904821,919006,922401,920704,912806,913419,913546,913556,919349,919351,925109,919003,920201,912706", "guide_subs": "NA", "accept_language": null}    });
		</script>
		<script>
			if (window.yt.timing) {yt.timing.tick("js_head");}    
		</script>
		<script>
			_gel('masthead-search-term').focus();
			yt.setConfig('GUIDE_VERSION', 1);
		</script>
		<script src="//s.ytimg.com/yt/jsbin/www-guide-vflO6qP5Q.js" data-loaded="true"></script>
		<script>
			yt.www.guide.init();
			
			
		</script>
		<script>
			if (window.yt.timing) {yt.timing.tick("js_page");}    
		</script>
		<script>
			yt.setConfig('TIMING_ACTION', "glo");    
		</script>
		<script>yt.www.thumbnaildelayload.init(300);</script>
		<script>
			yt.setMsg({
			  'LIST_CLEARED': "List cleared",
			  'PLAYLIST_VIDEO_DELETED': "Video deleted.",
			  'ERROR_OCCURRED': "Sorry, an error occurred.",
			  'NEXT_VIDEO_TOOLTIP': "Next video:\u003cbr\u003e \u0026#8220;${next_video_title}\u0026#8221;",
			  'NEXT_VIDEO_NOTHUMB_TOOLTIP': "Next video",
			  'SHOW_PLAYLIST_TOOLTIP': "Show playlist",
			  'HIDE_PLAYLIST_TOOLTIP': "Hide playlist",
			  'AUTOPLAY_ON_TOOLTIP': "Turn autoplay off",
			  'AUTOPLAY_OFF_TOOLTIP': "Turn autoplay on",
			  'SHUFFLE_ON_TOOLTIP': "Turn shuffle off",
			  'SHUFFLE_OFF_TOOLTIP': "Turn shuffle on",
			  'PLAYLIST_BAR_PLAYLIST_SAVED': "Playlist saved!",
			  'PLAYLIST_BAR_ADDED_TO_FAVORITES': "Added to favorites",
			  'PLAYLIST_BAR_ADDED_TO_PLAYLIST': "Added to playlist",
			  'PLAYLIST_BAR_ADDED_TO_QUEUE': "Added to queue",
			  'AUTOPLAY_WARNING1': "Next video starts in 1 second...",
			  'AUTOPLAY_WARNING2': "Next video starts in 2 seconds...",
			  'AUTOPLAY_WARNING3': "Next video starts in 3 seconds...",
			  'AUTOPLAY_WARNING4': "Next video starts in 4 seconds...",
			  'AUTOPLAY_WARNING5': "Next video starts in 5 seconds...",
			  'UNDO_LINK': "Undo"  });
			
			
			yt.setConfig({
			  'DRAGDROP_BINARY_URL': "\/\/s.ytimg.com\/yt\/jsbin\/www-dragdrop-vflWKaUyg.js",
			  'PLAYLIST_BAR_PLAYING_INDEX': -1  });
			
			  yt.setAjaxToken('addto_ajax_logged_out', "fp0KWJkOgzvoH_zrQWDO1rTnfkx8MTM0OTE0MDU3NEAxMzQ5MDU0MTc0");
			
			  yt.pubsub.subscribe('init', yt.www.lists.init);

			    yt.events.listen(_gel('masthead-search-term'), 'focus', yt.www.home.ads.workaroundReset);
			  yt.setConfig({'SBOX_JS_URL': "\/\/s.ytimg.com\/yt\/jsbin\/www-searchbox-vflsHyn9f.js",'SBOX_SETTINGS': {"CLOSE_ICON_URL": "\/\/s.ytimg.com\/yt\/img\/icons\/close-vflrEJzIW.png", "SHOW_CHIP": false, "PSUGGEST_TOKEN": null, "REQUEST_DOMAIN": "us", "EXPERIMENT_ID": -1, "SESSION_INDEX": null, "HAS_ON_SCREEN_KEYBOARD": false, "CHIP_PARAMETERS": {}, "REQUEST_LANGUAGE": "en"},'SBOX_LABELS': {"SUGGESTION_DISMISS_LABEL": "Dismiss", "SUGGESTION_DISMISSED_LABEL": "Suggestion dismissed"}});
		</script>
		<script>
			yt.setMsg({
			  'ADDTO_WATCH_LATER_ADDED': "Added",
			  'ADDTO_WATCH_LATER_ERROR': "Error"
			});
		</script>
		<script>
			if (window.yt.timing) {yt.timing.tick("js_foot");}    
		</script>
        <script src="/static/js/prefixfree.min.js"></script>
	</body>
</html>
