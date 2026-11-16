<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_update.php"); ?>
<?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__user_u = new user_update($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php if(!isset($_SESSION['siteusername'])) { die(header("Location: /sign_in")); } ?>
<?php
	$__server->page_embeds->page_title = "WrapperTube - Overview";
	$__server->page_embeds->page_description = "WrapperTube is a site where you can upload your videos, animations, Scratch Projects, Artwork, music, and anything.";
	$__server->page_embeds->page_image = "/yt/imgbin/full-size-logo.png";
	$__server->page_embeds->page_url = "http://wrappertube.org/";
?>
<!DOCTYPE html>
<html dir="ltr">
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
		<script>
			var yt = yt || {};yt.timing = yt.timing || {};yt.timing.tick = function(label, opt_time) {var timer = yt.timing['timer'] || {};if(opt_time) {timer[label] = opt_time;}else {timer[label] = new Date().getTime();}yt.timing['timer'] = timer;};yt.timing.info = function(label, value) {var info_args = yt.timing['info_args'] || {};info_args[label] = value;yt.timing['info_args'] = info_args;};yt.timing.info('e', "904821,919006,922401,920704,912806,913419,913546,913556,919349,919351,925109,919003,920201,912706");if (document.webkitVisibilityState == 'prerender') {document.addEventListener('webkitvisibilitychange', function() {yt.timing.tick('start');}, false);}yt.timing.tick('start');yt.timing.info('li','0');try {yt.timing['srt'] = window.gtbExternal && window.gtbExternal.pageT() ||window.external && window.external.pageT;} catch(e) {}if (window.chrome && window.chrome.csi) {yt.timing['srt'] = Math.floor(window.chrome.csi().pageT);}if (window.msPerformance && window.msPerformance.timing) {yt.timing['srt'] = window.msPerformance.timing.responseStart - window.msPerformance.timing.navigationStart;}    
		</script>
		<link id="www-core-css" rel="stylesheet" href="/yt/cssbin/www-core-vfluMRDnk.css">
		<link rel="stylesheet" href="/yt/cssbin/www-guide-vflx0V5Tq.css">
		<link rel="stylesheet" href="/yt/cssbin/www-videos-nav-vflYGt27y.css">
        <link rel="stylesheet" href="/yt/cssbin/www-extra.css">
		<script src="//s.ytimg.com/yt/jsbin/www-browse-vflu1nggJ.js" data-loaded="true"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script>
			if (window.yt.timing) {yt.timing.tick("ct");}    
		</script>
        <style>
			.box-gray {
				position: relative;
				padding: 15px;
				border: 1px solid #c5c5c5;
				background-color: #f7f7f7;
				border-radius: 10px;
				-moz-border-radius: 10px;
				-webkit-border-radius: 10px;
				width:300px;
			}

            .master-myaccount-top {
                border-bottom: 1px solid #CACACA;
            }

            .www-home-left a {
                padding-bottom: 3px;
                padding-top: 4px;
                font-weight: 700;
                text-align: left;
                color: black;
                padding-left: 2px;
                width: 193px;
                display: inline-block;
            }

            .www-home-left {
                width: 200px;
                border-right: 1px solid #aaa;
            }

            .www-home-right {
                width: 754px;
                padding: 5px;
            }

            .www-home-left a:hover {
                background-color: rgb(239, 239, 239);
                background: -moz-linear-gradient(0deg,rgb(192,192,192,1)0%,rgb(239,239,239,1)115%);
                background: -webkit-linear-gradient(0deg,rgb(192,192,192,1)0%,rgb(239,239,239,1)115%);
                background: linear-gradient(0deg,rgb(192,192,192)0%, rgb(239,239,239)115%);
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#efefef",endColorstr="#c0c0c0",GradientType=0);
            }

            a[href="/inbox/send"] {
                margin: 0px !important;
                padding: 0px !important;
                position: relative;
                top: 0px !important;
            }

            #search-button {
                margin: 0px;
                margin-bottom: 7px;
                margin-top: 4px;
            }

            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            td, th {
                text-align: left;
                padding: 3px;
            }

            th {
                border: 1px solid #dddddd;
                background: rgb(215,215,215);
                background: -moz-linear-gradient(0deg, rgba(215,215,215,1) 0%, rgba(255,255,255,1) 100%);
                background: -webkit-linear-gradient(0deg, rgba(215,215,215,1) 0%, rgba(255,255,255,1) 100%);
                background: linear-gradient(0deg, rgba(215,215,215,1) 0%, rgba(255,255,255,1) 100%);
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#ffffff",endColorstr="#d7d7d7",GradientType=0); 
                height: 14px;
                font-weight: lighter;
            }

            tr:nth-child(even) {
                background-color: #f9f9f9;
            }

            .video-manager-info {
                width: 462px;
            }

            .video-filter-options a {
                margin-left: 5px;
                margin-right: 5px;
            }

            .selected {
                font-weight: bold;
                color: black;
            }
        </style>
	</head>
	<body id="" class="date-20120930 en_US ltr   ytg-old-clearfix guide-feed-v2 " dir="ltr">
		<form name="logoutForm" method="POST" action="/logout">
			<input type="hidden" name="action_logout" value="1">
		</form>
		<!-- begin page -->
		<div id="page" class="browse-base">
			<!-- begin pagetop -->
			<div id="masthead-container"><?php require($_SERVER['DOCUMENT_ROOT'] . "/s/mod/header.php"); ?></div>
			<!-- end pagetop -->
			<!-- begin pagemiddle -->
			<div id="content-container">
				<div id="baseDiv" class="date-20120930 video-info   browse-base browse-videos">
					<div id="alerts"></div>
					<div id="masthead-subnav" class="yt-nav yt-nav-dark ">
						<ul>
                            <a href="/my_videos">
							<li>
								<span class="yt-nav-item">
								My Channel
								</span>
							</li>
                            </a>
                            <a href="/inbox/">
                            <li>
								<span class="yt-nav-item">
								Inbox
								</span>
							</li>
                            </a>
                            <li class=" selected">
								<span class="yt-nav-item">
								Settings
								</span>
							</li>
						</ul>
					</div>
					<div class="browse-container ytg-wide ytg-box no-stage browse-bg-gradient">
						<div class="ytg-fl browse-content">
                            <?php require($_SERVER['DOCUMENT_ROOT'] . "/s/mod/sidebar_account.php"); ?>
							<div id="browse-main-column" style="float: right;margin: 0px 0 0 14px;" class="ytg-4col">
								<div class="browse-collection  has-box-ad">
									<div class="box-gray" style="width: 95%;margin-bottom: 8px;">
										<h3><?php echo htmlspecialchars($_SESSION['siteusername']); ?></h3>
										<?php 
											$stmt = $__db->prepare("SELECT count(*) FROM videos WHERE author = :username");
											$stmt->bindParam(":username", $_SESSION['siteusername']);
											$stmt->execute();
											$videos = (int)$stmt->fetchColumn();
                                                                                        $stmt = null;

                                                                                        $stmt = $__db->prepare("SELECT count(*) FROM user_groups WHERE group_author = :username");
                                                                                        $stmt->bindParam(":username", $_SESSION['siteusername']);
                                                                                        $stmt->execute();
                                                                                        $groups = (int)$stmt->fetchColumn();
                                                                                        $stmt = null;

                                                                                        $stmt = $__db->prepare("SELECT count(*) FROM playlists WHERE author = :username");
                                                                                        $stmt->bindParam(":username", $_SESSION['siteusername']);
                                                                                        $stmt->execute();
                                                                                        $playlists = (int)$stmt->fetchColumn();
                                                                                        $stmt = null;

											$stmt = $__db->prepare("SELECT count(*) FROM comments WHERE author = :username");
                                                                                        $stmt->bindParam(":username", $_SESSION['siteusername']);
											$stmt->execute();
											$comments = (int)$stmt->fetchColumn();
                                                                                        $stmt = null;

                                                                                        $stmt = $__db->prepare("SELECT count(*) FROM comment_reply WHERE author = :username");
                                                                                        $stmt->bindParam(":username", $_SESSION['siteusername']);
                                                                                        $stmt->execute();
                                                                                        $replies = (int)$stmt->fetchColumn();
                                                                                        $stmt = null;

											$views = $__video_h->fetch_views_from_user($_SESSION['siteusername']);

											$stmt = $__db->prepare("SELECT count(*) FROM pms WHERE touser = :username");
                                                                                        $stmt->bindParam(":username", $_SESSION['siteusername']);
											$stmt->execute();
											$pms = (int)$stmt->fetchColumn();
                                                                                        $stmt = null;

											$stmt = $__db->prepare("SELECT count(*) FROM playlists WHERE author = :username");
                                                                                        $stmt->bindParam(":username", $_SESSION['siteusername']);
											$stmt->execute();
											$playlists = (int)$stmt->fetchColumn();
                                                                                        $stmt = null;

                                                                                        $stmt = $__db->prepare("SELECT count(*) FROM video_response WHERE author = :username");
                                                                                        $stmt->bindParam(":username", $_SESSION['siteusername']);
                                                                                        $stmt->execute();
                                                                                        $responses = (int)$stmt->fetchColumn();
                                                                                        $stmt = null;

                                                                                        $stmt = $__db->prepare("SELECT count(*) FROM forum_thread WHERE author = :username");
                                                                                        $stmt->bindParam(":username", $_SESSION['siteusername']);
                                                                                        $stmt->execute();
                                                                                        $threads = (int)$stmt->fetchColumn();
                                                                                        $stmt = null;

                                                                                        $stmt = $__db->prepare("SELECT count(*) FROM forum_replies WHERE author = :username");
                                                                                        $stmt->bindParam(":username", $_SESSION['siteusername']);
                                                                                        $stmt->execute();
                                                                                        $forum_replies = (int)$stmt->fetchColumn();
                                                                                        $stmt = null;

                                                                                        $stmt = $__db->prepare("SELECT count(*) FROM likes WHERE sender = :username");
                                                                                        $stmt->bindParam(":username", $_SESSION['siteusername']);
                                                                                        $stmt->execute();
                                                                                        $ratings = (int)$stmt->fetchColumn();
                                                                                        $stmt = null;

                                                                                        $stmt = $__db->prepare("SELECT count(*) FROM stars WHERE sender = :username");
                                                                                        $stmt->bindParam(":username", $_SESSION['siteusername']);
                                                                                        $stmt->execute();
                                                                                        $ratings += (int)$stmt->fetchColumn();
                                                                                        $stmt = null;

                                                                                        $stmt = $__db->prepare("SELECT count(*) FROM favorite_video WHERE sender = :username");
                                                                                        $stmt->bindParam(":username", $_SESSION['siteusername']);
                                                                                        $stmt->execute();
                                                                                        $favourites = (int)$stmt->fetchColumn();
                                                                                        $stmt = null;

                                                                                        $stmt = $__db->prepare("SELECT count(*) FROM subscribers WHERE reciever = :username");
                                                                                        $stmt->bindParam(":username", $_SESSION['siteusername']);
                                                                                        $stmt->execute();
                                                                                        $subscribers = (int)$stmt->fetchColumn();
                                                                                        $stmt = null;

                                                                                        $stmt = $__db->prepare("SELECT count(*) FROM subscribers WHERE sender = :username");
                                                                                        $stmt->bindParam(":username", $_SESSION['siteusername']);
                                                                                        $stmt->execute();
                                                                                        $subscriptions = (int)$stmt->fetchColumn();
                                                                                        $stmt = null;

											$videos_watched = $__video_h->fetch_history_ammount($_SESSION['siteusername']);

											$channels_views = $__user_h->get_channel_views($_SESSION['siteusername']);

											$friends = $__user_h->fetch_friends_accepted($_SESSION['siteusername']);

                                                                                        $stmt = $__db->prepare("SELECT count(*) FROM group_members WHERE username = :username");
                                                                                        $stmt->bindParam(":username", $_SESSION['siteusername']);
                                                                                        $stmt->execute();
                                                                                        $groups_joined = (int)$stmt->fetchColumn();
                                                                                        $stmt = null;

											$joined = $__user_h->fetch_user_username($_SESSION['siteusername'])['created'];

                                                                                        $stmt = $__db->prepare("SELECT count(*) FROM profile_comments WHERE toid = :username");
                                                                                        $stmt->bindParam(":username", $_SESSION['siteusername']);
                                                                                        $stmt->execute();
                                                                                        $profile_comments = (int)$stmt->fetchColumn();
                                                                                        $stmt = null;

                                                                                        $stmt = $__db->prepare("SELECT count(*) FROM profile_comments WHERE author = :username");
                                                                                        $stmt->bindParam(":username", $_SESSION['siteusername']);
                                                                                        $stmt->execute();
                                                                                        $profile_comments_written = (int)$stmt->fetchColumn();
                                                                                        $stmt = null;

                                                                                        $stmt = $__db->prepare("SELECT count(*) FROM group_discussion WHERE author = :username");
                                                                                        $stmt->bindParam(":username", $_SESSION['siteusername']);
                                                                                        $stmt->execute();
                                                                                        $group_comments = (int)$stmt->fetchColumn();
                                                                                        $stmt = null;

                                                                                        $stmt = $__db->prepare("SELECT count(*) FROM quicklist_videos WHERE author = :username");
                                                                                        $stmt->bindParam(":username", $_SESSION['siteusername']);
                                                                                        $stmt->execute();
                                                                                        $quicklist_videos = (int)$stmt->fetchColumn();
                                                                                        $stmt = null;

                                                                                        $stmt = $__db->prepare("SELECT count(*) FROM pms WHERE owner = :username");
                                                                                        $stmt->bindParam(":username", $_SESSION['siteusername']);
                                                                                        $stmt->execute();
                                                                                        $pms_sent = (int)$stmt->fetchColumn();
                                                                                        $stmt = null;

                                                                                        $stmt = $__db->prepare("SELECT count(*) FROM block WHERE sender = :username");
                                                                                        $stmt->bindParam(":username", $_SESSION['siteusername']);
                                                                                        $stmt->execute();
                                                                                        $users_blocked = (int)$stmt->fetchColumn();
                                                                                        $stmt = null;

                                                                                        $genre = ucfirst($__user_h->fetch_user_username($_SESSION['siteusername'])['genre']);
                                                                                        $status = ucfirst($__user_h->fetch_user_username($_SESSION['siteusername'])['status']);
                                                                                        $partner = $__user_h->if_partner($_SESSION['siteusername']);
                                                                                        $country = $__user_h->fetch_user_username($_SESSION['siteusername'])['country'];
										?>
										<div style="width: 200px;display:inline-block;">
											Videos uploaded: <b style="float:right;"><?php echo $videos; ?></b><br>
                                                                                        Playlists created: <b style="float:right;"><?php echo $playlists; ?></b><br>
                                                                                        Groups created: <b style="float:right;"><?php echo $groups; ?></b><br>
                                                                                        Favourited Videos: <b style="float:right;"><?php echo $favourites; ?></b><br>
                                                                                        Subscriptions: <b style="float:right;"><?php echo $subscriptions; ?></b><br>
                                                                                        Subscribers: <b style="float:right;"><?php echo $subscribers; ?></b><br>
                                                                                        Videos watched: <b style="float:right;"><?php echo $videos_watched; ?></b><br>
                                                                                        Channels Views: <b style="float:right;"><?php echo $channels_views; ?></b><br>
                                                                                        Friends: <b style="float:right;"><?php echo $friends; ?></b><br>
                                                                                        Status: <b style="float:right;"><?php echo $status; ?></b><br>
										</div>
										<div style="width: 200px;display:inline-block;margin-right:20px;vertical-align: top;margin-left: 22px;">
											Comments Written: <b style="float:right;"><?php echo $comments; ?></b><br>
                                                                                        Replies Written: <b style="float:right;"><?php echo $replies; ?></b><br>
                                                                                        Videos Rated: <b style="float:right;"><?php echo $ratings; ?></b><br>
											Total Private messages: <b style="float:right;"><?php echo $pms; ?></b><br>
                                                                                        Total Private messages sent: <b style="float:right;"><?php echo $pms_sent; ?></b><br>
											Playlists Created: <b style="float:right;"><?php echo $playlists; ?></b><br>
											Total Video views: <b style="float:right;"><?php echo $views; ?></b><br>
                                                                                        Videos responded: <b style="float:right;"><?php echo $responses; ?></b><br>
                                                                                        Forum threads written: <b style="float:right;"><?php echo $threads; ?></b><br>
                                                                                        Users blocked: <b style="float:right;"><?php echo $users_blocked; ?></b><br>
										</div>
                                                                                <div style="width: 200px;display:inline-block;margin-right:20px;vertical-align: top;margin-left: 22px;">
                                                                                        Groups Joined: <b style="float:right;"><?php echo $groups_joined; ?></b><br>
                                                                                        Joined: <b style="float:right;"><?php echo date("M d, Y, h:i A", strtotime($joined)); ?></b><br>
                                                                                        Quicklist Videos: <b style="float:right;"><?php echo $quicklist_videos; ?></b><br>
                                                                                        Channel Type: <b style="float:right;"><?php echo $genre; ?></b><br>
                                                                                        Forum replies written: <b style="float:right;"><?php echo $forum_replies; ?></b><br>
                                                                                        Total Profile Comments: <b style="float:right;"><?php echo $profile_comments; ?></b><br>
                                                                                        Profile Comments Written: <b style="float:right;"><?php echo $profile_comments_written; ?></b><br>
                                                                                        Group Comments Written: <b style="float:right;"><?php echo $group_comments; ?></b><br>
                                                                                        Country: <b style="float:right;"><?php echo $country; ?></b><br>
                                                                                        Trusted: <b style="float:right;"><input type="checkbox" disabled<?php if($partner){echo " checked";} ?>></b><br>
                                                                                </div><br><br>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<!-- end pagemiddle -->
			<!-- begin pagebottom -->
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
									<li class="empty playlist-bar-help-message">Your queue is empty. Add videos to your queue using this button: <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="addto-button-help"><br> or <a href="https://accounts.google.com/ServiceLogin?passive=true&amp;continue=http%3A%2F%2Fwww.youtube.com%2Fsignin%3Faction_handle_signin%3Dtrue%26feature%3Dplaylist%26nomobiletemp%3D1%26hl%3Den_US%26next%3D%252Fvideos%253Ffeature%253Dmh&amp;uilel=3&amp;hl=en_US&amp;service=youtube">sign in</a> to load a different list.</li>
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
						<!--<li class="playlist-bar-item yt-uix-slider-slide-unit __classes__" data-video-id="__video_encrypted_id__"><a href="__video_url__" title="__video_title__" class="yt-uix-sessionlink" data-sessionlink="ei=CPjwu5ji3bICFS4RIQod9j-M-A%3D%3D&amp;feature=BFa"><span class="video-thumb ux-thumb yt-thumb-default-106 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="__video_title__" data-thumb-manual="true" data-thumb="__video_thumb_url__" width="106" ><span class="vertical-align"></span></span></span></span><span class="screen"></span><span class="count"><strong>__list_position__</strong></span><span class="play"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif"></span><span class="yt-uix-button yt-uix-button-default delete"><img class="yt-uix-button-icon-playlist-bar-delete" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Delete"></span><span class="now-playing">Now playing</span><span dir="ltr" class="title"><span>__video_title__  <span class="uploader">by __video_display_name__</span>
							</span></span><span class="dragger"></span></a></li>-->
					</div>
					<div id="playlist-bar-next-up-template" style="display: none;">
						<!--<div class="playlist-bar-next-thumb"><span class="video-thumb ux-thumb yt-thumb-default-74 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="//i4.ytimg.com/vi/__video_encrypted_id__/default.jpg" alt="Thumbnail" width="74" ><span class="vertical-align"></span></span></span></span></div>-->
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
				<a href="https://accounts.google.com/ServiceLogin?passive=true&amp;continue=http%3A%2F%2Fwww.youtube.com%2Fsignin%3Faction_handle_signin%3Dtrue%26feature%3Dplaylist%26nomobiletemp%3D1%26hl%3Den_US%26next%3D%252Fvideos%253Ffeature%253Dmh&amp;uilel=3&amp;hl=en_US&amp;service=youtube" class="sign-in-link">Sign in</a> to add this to a playlist
			</div>
			<div id="shared-addto-menu" style="display: none;" class="hid sign-in">
				<div class="addto-menu">
					<div id="addto-list-panel" class="menu-panel active-panel">
						<span class="yt-uix-button-menu-item yt-uix-tooltip sign-in" data-possible-tooltip="" data-tooltip-show-delay="750"><a href="https://accounts.google.com/ServiceLogin?passive=true&amp;continue=http%3A%2F%2Fwww.youtube.com%2Fsignin%3Faction_handle_signin%3Dtrue%26feature%3Dplaylist%26nomobiletemp%3D1%26hl%3Den_US%26next%3D%252Fvideos%253Ffeature%253Dmh&amp;uilel=3&amp;hl=en_US&amp;service=youtube" class="sign-in-link">Sign in</a> to add this to a playlist
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
			<!-- end pagebottom -->
		</div>
		<!-- end page -->
<script id="www-core-js" src="/yt/jsbin/www-core-vfl1pq97W.js" data-loaded="true"></script>
        <script id="www-core-js" src="/yt/jsbin/www-core-vfl1pq97W.js" data-loaded="true"></script>
		<script>yt.www.thumbnaildelayload.init(0);</script>
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
			
			  yt.setAjaxToken('addto_ajax_logged_out', "rmWO31ZGdmAjKQm23MH57ZskA6Z8MTM0OTExMDQ0NkAxMzQ5MDI0MDQ2");
			
			  yt.pubsub.subscribe('init', yt.www.lists.init);
			
			
			
			
			
			
			
			
			
			  yt.setConfig({'SBOX_JS_URL': "\/\/s.ytimg.com\/yt\/jsbin\/www-searchbox-vflsHyn9f.js",'SBOX_SETTINGS': {"CLOSE_ICON_URL": "\/\/s.ytimg.com\/yt\/img\/icons\/close-vflrEJzIW.png", "SHOW_CHIP": false, "PSUGGEST_TOKEN": null, "REQUEST_DOMAIN": "us", "EXPERIMENT_ID": -1, "SESSION_INDEX": null, "HAS_ON_SCREEN_KEYBOARD": false, "CHIP_PARAMETERS": {}, "REQUEST_LANGUAGE": "en"},'SBOX_LABELS': {"SUGGESTION_DISMISS_LABEL": "Dismiss", "SUGGESTION_DISMISSED_LABEL": "Suggestion dismissed"}});
			
			
			
			
			
		</script>
		<script>
			yt.setMsg({
			  'ADDTO_WATCH_LATER_ADDED': "Added",
			  'ADDTO_WATCH_LATER_ERROR': "Error"
			});
		</script>
        <script src="/static/js/prefixfree.min.js"></script>
	</body>
</html>
