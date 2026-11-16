<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_update.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_insert.php"); ?>
<?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__user_u = new user_update($__db); ?>
<?php $__user_i = new user_insert($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php
    $_playlist = $__video_h->fetch_playlist_rid($_GET['v']);

if(!$_playlist) { header("Location: /?error=This playlist doesn't exist!"); die(); }

        if($_playlist['visibility'] == "v" && @$_SESSION['siteusername'] != $_playlist['author'] && (!$__user_h->if_moderator(@$_SESSION['siteusername']) && !$__user_h->if_admin(@$_SESSION['siteusername']))) {
                die(header("Location: /?error=This playlist is private!"));
        }

    if(!$__user_h->user_exists($_playlist['author']))
        header("Location: /?userdoesntexist");    

    $_user = $__user_h->fetch_user_username($_playlist['author']);

    $stmt = $__db->prepare("SELECT * FROM bans WHERE username = :username LIMIT 1");
        $stmt->bindParam(":username", $_user['username']);
        $stmt->execute();

        while($ban = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $banned = $ban['reason'];
        }
        $stmt = null;

    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

	function addhttp($url) {
		if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
			$url = "http://" . $url;
		}
		return $url;
	}

    function check_valid_colorhex($colorCode) {
        if (
              (startsWith($colorCode,'#') || startsWith($colorCode,'rgb(') || startsWith($colorCode,'rgba(')) &&
              (strlen($colorCode) >= 4 && strlen($colorCode) <= 30))
                   return true;

        else return false;
    }

    $_user['subscribers'] = $__user_h->fetch_subs_count($_user['username']);
    $_user['videos'] = $__user_h->fetch_user_videos($_user['username']);
    $_user['favorites'] = $__user_h->fetch_user_favorites($_user['username']);
    $_user['subscriptions'] = $__user_h->fetch_subscriptions($_user['username']);
    $_user['views'] = $__video_h->fetch_views_from_user($_user['username']);
    $_user['friends'] = $__user_h->fetch_friends_accepted($_user['username']);

    $_user['s_2009_user_left'] = $_user['2009_user_left'];
    $_user['s_2009_user_right'] = $_user['2009_user_right'];
    $_user['2009_user_left'] = explode(";", $_user['2009_user_left']);
    $_user['2009_user_right'] = explode(";", $_user['2009_user_right']);

    $_user['primary_color'] = strip_tags($_user['primary_color']);
    $_user['secondary_color'] = strip_tags($_user['secondary_color']);
    $_user['third_color'] = strip_tags($_user['third_color']);
    $_user['text_color'] = strip_tags($_user['text_color']);
    $_user['primary_color_text'] = strip_tags($_user['primary_color_text']);
    $_user['2012_bgcolor'] = strip_tags($_user['2012_bgcolor']);
    $_user['custom_header'] = $_user['custom_header']?$_user['custom_header']:$_user['username'];
    $_user['blocked'] = $__user_h->if_blocked(@$_SESSION['siteusername'], $_user['username']);

    $_user['genre'] = strtolower($_user['genre']);
        $_user['subscribed'] = $__user_h->if_subscribed(@$_SESSION['siteusername'], $_user['username']);

    if(!check_valid_colorhex($_user['primary_color'])) { $_user['primary_color'] = ""; }
    if(!check_valid_colorhex($_user['secondary_color'])) { $_user['secondary_color'] = ""; }
    if(!check_valid_colorhex($_user['third_color'])) { $_user['third_color'] = ""; }
    if(!check_valid_colorhex($_user['text_color'])) { $_user['text_color'] = ""; }
    if(!check_valid_colorhex($_user['primary_color_text'])) { $_user['primary_color_text'] = ""; }
    if(!check_valid_colorhex($_user['2012_bgcolor'])) { $_user['2012_bgcolor'] = ""; }

	if(isset($_SESSION['siteusername']))
    	$__user_i->check_view_channel($_user['username'], @$_SESSION['siteusername']);

?>
<?php
	$__server->page_embeds->page_title = "WrapperTube - " . htmlspecialchars($_playlist['title']);
	$__server->page_embeds->page_description = htmlspecialchars($_playlist['description']);
	$__server->page_embeds->page_image = "/yt/imgbin/full-size-logo.png";
	$__server->page_embeds->page_url = "http://wrappertube.org/";
?>	
<!DOCTYPE html>
<html dir="ltr" xmlns:og="http://opengraphprotocol.org/schema/" lang="en">
	<!-- machid: sNW5tN3Z2SWdXaDRqNGxuNEF5MFBxM1BxWXd0VGo0Rkg3UXNTTTNCUGRDWjR0WGpHR3R1YzFR -->
	<head>
        <title><?php echo $__server->page_embeds->page_title; ?></title>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="content-script-type" content="text/javascript">
<meta http-equiv="content-style-type" content="text/css">
<meta name="description" content="<?php echo $__server->page_embeds->page_description; ?>">
<meta name="theme-color" content="<?php echo $_user['primary_color']; ?>">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
		<meta property="og:title" content="<?php echo $__server->page_embeds->page_title; ?>" />
		<meta property="og:url" content="<?php echo $__server->page_embeds->page_url; ?>" />
		<meta property="og:description" content="<?php echo $__server->page_embeds->page_description; ?>" />
		<meta property="og:image" content="<?php echo $__server->page_embeds->page_image; ?>" />
        <script src="/static/js/core-js.js"></script>
<?php if ($_playlist['visibility'] != "n") { ?>
<meta name="robots" content="noindex, nofollow, noarchive">
<?php } ?>
<link rel="alternate" type="application/atom+xml" title="Playlist RSS Feed" href="/feed/playlist?v=<?php echo htmlspecialchars($_playlist['rid']); ?>">
		<script>
			var yt = yt || {};yt.timing = yt.timing || {};yt.timing.tick = function(label, opt_time) {var timer = yt.timing['timer'] || {};if(opt_time) {timer[label] = opt_time;}else {timer[label] = new Date().getTime();}yt.timing['timer'] = timer;};yt.timing.info = function(label, value) {var info_args = yt.timing['info_args'] || {};info_args[label] = value;yt.timing['info_args'] = info_args;};yt.timing.info('e', "904821,919006,922401,920704,912806,913419,913546,913556,919349,919351,925109,919003,920201,912706");if (document.webkitVisibilityState == 'prerender') {document.addEventListener('webkitvisibilitychange', function() {yt.timing.tick('start');}, false);}yt.timing.tick('start');yt.timing.info('li','0');try {yt.timing['srt'] = window.gtbExternal && window.gtbExternal.pageT() ||window.external && window.external.pageT;} catch(e) {}if (window.chrome && window.chrome.csi) {yt.timing['srt'] = Math.floor(window.chrome.csi().pageT);}if (window.msPerformance && window.msPerformance.timing) {yt.timing['srt'] = window.msPerformance.timing.responseStart - window.msPerformance.timing.navigationStart;}    
		</script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src='/static/spectrum/spectrum.js'></script>
        <link rel='stylesheet' href='/static/spectrum/spectrum.css' />
		<link id="www-core-css" rel="stylesheet" href="/yt/cssbin/www-core-vfluMRDnk.css">
        <link id="www-playlist-css" rel="stylesheet" href="/yt/cssbin/www-playlist-vflmE481L.css">
		<script src="/s/js/alert.js"></script>
		<link rel="stylesheet" href="/yt/cssbin/www-guide-vflx0V5Tq.css">
        <link rel="stylesheet" href="/yt/cssbin/www-channels3-vfl-wJB5W.css">
        <link rel="stylesheet" href="/yt/cssbin/www-the-rest-vflNb6rAI.css">
		<link rel="stylesheet" href="/yt/cssbin/www-extra.css">
		<style>
			#content-container {
				background-color: <?php echo $_user['primary_color'];  ?>;
				background-image: url(/dynamic/banners/<?php echo $_user['2012_bg']; ?>);
				background-repeat: repeat;
				<?php
					switch($_user['2012_bgoption']) {
						case "stretch":
						echo "background-size: cover;";
						break;
						case "solid":
						echo "";
						break;
						case "norepeat":
						echo "background-repeat: no-repeat !important;";
						break;
						case "repeatxy":
						echo "background-repeat: repeat;";
						break;
						case "repeaty":
						echo "background-repeat: repeat-y;";
						break;
						case "repeatx":
						echo "background-repeat: repeat-x;";
						break;
					}
				?>
			}
            <?php if (!empty($_user['font'])) { ?>
            #content {
                font-family: <?php echo strip_tags($_user['font']); ?> !important;
            }
            <?php } ?>
   		</style>
<style>
.share-service-button .share-service-icon {
background-image:url(/yt/imgbin/www-sharing-vflIBlxAE.png);
background-repeat:no-repeat;
width:32px;
height:32px;
vertical-align:middle
}
</style>
<style type="text/css">
<?php echo htmlspecialchars($_user['css']); ?>
</style>
<?php if ($_user["snow"] == "y") { ?>
<script src="/static/js/snowstorm-min.js"></script>
<script>
snowStorm.targetElement = 'content';
</script>
<?php } ?>
<link rel="stylesheet" href="/static/css/bbcode.css?v2">
	</head>
	<body id="" class="date-20120614 en_US ltr   ytg-old-clearfix " dir="ltr">
		<form name="logoutForm" method="POST" action="/logout">
			<input type="hidden" name="action_logout" value="1">
		</form>
		<!-- begin page -->
		<div id="page" class="  branded-page channel ">
			<div id="masthead-container"><?php require($_SERVER['DOCUMENT_ROOT'] . "/s/mod/header.php"); ?></div>
			<div id="content-container">
				<!-- begin content -->
				<?php
					if(empty(trim($_user['bio'])))
						$_user['bio'] = "This user has no description.";
				?>
				<div id="content">
					<div class="subscription-menu-expandable subscription-menu-expandable-channels3 yt-rounded ytg-wide hid">
						<div class="content" id="recommended-channels-list"></div>
						<button class="close" type="button">close</button>
					</div>
					<div class="hid">
						<div class="yt-alert yt-alert-default yt-alert-success  " id="success-template">
							<div class="yt-alert-icon"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon"></div>
							<div class="yt-alert-buttons">  <button type="button" class="close yt-uix-close yt-uix-button yt-uix-button-close" onclick=";return false;" data-close-parent-class="yt-alert" role="button"><span class="yt-uix-button-content">Close </span></button></div>
							<div class="yt-alert-content" role="alert"></div>
						</div>
						<div class="yt-alert yt-alert-default yt-alert-error  " id="error-template">
							<div class="yt-alert-icon"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon"></div>
							<div class="yt-alert-buttons">  <button type="button" class="close yt-uix-close yt-uix-button yt-uix-button-close" onclick=";return false;" data-close-parent-class="yt-alert" role="button"><span class="yt-uix-button-content">Close </span></button></div>
							<div class="yt-alert-content" role="alert"></div>
						</div>
						<div class="yt-alert yt-alert-default yt-alert-warn  " id="warn-template">
							<div class="yt-alert-icon"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon"></div>
							<div class="yt-alert-buttons">  <button type="button" class="close yt-uix-close yt-uix-button yt-uix-button-close" onclick=";return false;" data-close-parent-class="yt-alert" role="button"><span class="yt-uix-button-content">Close </span></button></div>
							<div class="yt-alert-content" role="alert"></div>
						</div>
						<div class="yt-alert yt-alert-default yt-alert-info  " id="info-template">
							<div class="yt-alert-icon"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon"></div>
							<div class="yt-alert-buttons">  <button type="button" class="close yt-uix-close yt-uix-button yt-uix-button-close" onclick=";return false;" data-close-parent-class="yt-alert" role="button"><span class="yt-uix-button-content">Close </span></button></div>
							<div class="yt-alert-content" role="alert"></div>
						</div>
						<div class="yt-alert yt-alert-default yt-alert-status  " id="status-template">
							<div class="yt-alert-icon"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon"></div>
							<div class="yt-alert-buttons">  <button type="button" class="close yt-uix-close yt-uix-button yt-uix-button-close" onclick=";return false;" data-close-parent-class="yt-alert" role="button"><span class="yt-uix-button-content">Close </span></button></div>
							<div class="yt-alert-content" role="alert"></div>
						</div>
					</div>
					<div class="hid">
						<div id="message-container-template" class="message-container"></div>
					</div>
					<div id="branded-page-default-bg" class="ytg-base">
                                                <?php if ($_user['banner_image_map'] != "") { echo $_user['banner_image_map']; } ?>
                                                <?php if ($_user['banner'] != "") { ?><img usemap="#imgmap" class="ytg-wide branded-banner-image" src="/dynamic/banners/<?php echo htmlspecialchars($_user['banner']); ?>" width="970"><?php } ?>
						<div id="branded-page-body-container" class="ytg-base clearfix">
							<div id="branded-page-header-container" class="ytg-wide banner-displayed-mode">
								<div id="branded-page-header" class="ytg-wide" style="padding: 0px;">
									<div id="channel-header-main">
										<div class="upper-section clearfix">
											<a href="/user/<?php echo htmlspecialchars($_user['username']); ?>">
											<span class="profile-thumb">
											<span class="centering-wrap">
											<img src="/dynamic/pfp/<?php echo htmlspecialchars($_user['pfp']); ?>" title="<?php echo htmlspecialchars($_user['username']); ?>" alt="<?php echo htmlspecialchars($_user['username']); ?>">
											</span>
											</span>
											</a>
											<div class="upper-left-section " style="padding: 0px;">
												<div class="playlist-reference">
												<h1 title="<?php echo htmlspecialchars($_playlist['title']); ?>"><?php echo htmlspecialchars($_playlist['title']); ?></h1>
													<p class="channel-author-attribution">
														by <a href="/user/<?php echo htmlspecialchars($_playlist['author']); ?>"<?php if (isset($banned)) { ?> style="text-decoration:line-through;color:grey;"<?php } ?>><?php echo htmlspecialchars($_user['custom_header']); ?></a>
													</p>
												</div>
											</div>
											<div class="upper-left-section enable-fancy-subscribe-button">
												<?php if($_user['username'] != @$_SESSION['siteusername']) { ?>
													<div class="yt-subscription-button-hovercard yt-uix-hovercard">
														<button 
															href="#" 
															onclick=";subscribe();return false;" 
															title="" 
															id="subscribe-button"
															type="button" 
															class="yt-subscription-button <?php if($_user['subscribed']) { echo "subscribed "; } ?>  yt-uix-button yt-uix-button-subscription yt-uix-tooltip" 
															role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-subscribe" 
															src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></span><span class="yt-uix-button-content">  <span class="subscribe-label">Subscribe</span>
														<span class="subscribed-label">Subscribed</span>
														<span class="unsubscribe-label">Unsubscribe</span>
														</span></button>
														<div class="yt-uix-hovercard-content hid">
															<p class="loading-spinner">
																<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
																Loading...
															</p>
														</div>
													</div>
												<?php } else { ?>

												<?php } ?>
											</div>
											<div class="upper-right-section">
												<div class="header-stats">
                                                                                                        <div class="stat-entry">
                                                                                                                <?php $user_videos_watched = $__video_h->fetch_history_ammount($_user['username']); ?>
                                                                                                                <span class="stat-value"><?php echo $user_videos_watched; ?></span>
                                                                                                                <span class="stat-name"><?php if($user_videos_watched == 1){ ?>video watched<?php }else{ ?>videos watched<?php } ?></span>
                                                                                                        </div>
                                                                                                        <div class="stat-entry">
<a href="/user/<?php echo htmlspecialchars($_user['username']); ?>/friends">
                                                                                                                <span class="stat-value"><?php echo $_user['friends']; ?></span>
                                                                                                                <span class="stat-name"><?php if($_user['friends'] == 1){ ?>friend<?php }else{ ?>friends<?php } ?> &gt;</span>
</a>
                                                                                                        </div>
                                                                                                        <div class="stat-entry">
<a href="/user/<?php echo htmlspecialchars($_user['username']); ?>/subscribers">
                                                                                                                <span class="stat-value"><?php echo $_user['subscribers']; ?></span>
                                                                                                                <span class="stat-name"><?php if($_user['subscribers'] == 1){ ?>subscriber<?php }else{ ?>subscribers<?php } ?> &gt;</span>
</a>
                                                                                                        </div>
                                                                                                        <div class="stat-entry">
<a href="/user/<?php echo htmlspecialchars($_user['username']); ?>/subscriptions">
                                                                                                                <span class="stat-value"><?php echo $_user['subscriptions']; ?></span>
                                                                                                                <span class="stat-name"><?php if($_user['subscriptions'] == 1){ ?>subscription<?php }else{ ?>subscriptions<?php } ?> &gt;</span>
</a>
                                                                                                        </div>
                                                                                                        <div class="stat-entry">
                                                                                                                <span class="stat-value"><?php echo $_user['views']; ?></span>
                                                                                                                <span class="stat-name">video views</span>
                                                                                                        </div>
                                                                                                        <div class="stat-entry">
                                                                                                                <?php $user_channel_views = $__user_h->get_channel_views($_user['username']); ?>
                                                                                                                <span class="stat-value"><?php echo $user_channel_views; ?></span>
                                                                                                                <span class="stat-name">channels views</span>
                                                                                                        </div>
												</div>
												<span class="valign-shim"></span>
											</div>
										</div>
									</div>
								</div>
							</div>
                            <?php if($_user['featured'] != "None") { $video = $__video_h->fetch_video_rid($_user['featured']); } else { $_user['featured'] = false; } ?>
							<div id="branded-page-body">
								<div class="channel-tab-content channel-layout-two-column selected blogger-template">
									<div class="tab-content-body">
										<div class="primary-pane">
											<div class="single-playlist channel-module yt-uix-c3-module-container">
												<div class="module-view single-playlist-view-module">


                                                    <div class="playlist-landing ypc-list-container">
                                                                        <?php if($_playlist['visibility'] == "u") { ?>
                                                                                <div id="masthead_child_div"><div class="yt-alert yt-alert-default yt-alert-warn">  <div class="yt-alert-icon">
                                                                                        <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
                                                                                </div>
                                                                                <div class="yt-alert-buttons"></div><div class="yt-alert-content" role="alert">    <span class="yt-alert-vertical-trick"></span>
                                                                                        <div class="yt-alert-message">
                                                                                                This playlist is unlisted. Only people who have the link can view this playlist.
                                                                                        </div>
                                                                                </div></div></div>
                                                                        <?php } else if($_playlist['visibility'] == "v") { ?>
                                                                                <div id="masthead_child_div"><div class="yt-alert yt-alert-default yt-alert-error">  <div class="yt-alert-icon">
                                                                                        <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
                                                                                </div>
                                                                                <div class="yt-alert-buttons"></div><div class="yt-alert-content" role="alert">    <span class="yt-alert-vertical-trick"></span>
                                                                                        <div class="yt-alert-message">
                                                                                                This playlist is private. Only you can view this playlist.
                                                                                        </div>
                                                                                </div></div></div>
                                                                        <?php } ?>
                                                        <div id="playlist-actions">
                                                            <div id="playlist-action-buttons">
                                                                <button type="button" class="playlist-share yt-uix-button yt-uix-button-default yt-uix-tooltip" onclick=";return false;" title="Share this playlist" data-button-toggle="true" data-button-action="yt.www.playlist.share" role="button"><span class="yt-uix-button-content">Share </span></button>
                                                            </div>
                                                            <div id="playlist-share-container" class="playlist-share-area hid">
                                                            </div>
                                                            <div id="playlist-share-loading" class="playlist-share-area hid" style="
background: #fff;
padding: 10px 0 0 0;
margin: 15px 0;
-moz-box-shadow: 0 1px 1px #ccc;
-ms-box-shadow: 0 1px 1px #ccc;
-webkit-box-shadow: 0 1px 1px #ccc;
box-shadow: 0 1px 1px #ccc;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;
border-radius: 3px;
font-size: 100%;
color: #999;
">
<div id="watch-actions-share-panel2">
                                                                                                        <div class="share-panel">
                                                                                                                <div class="share-option-container ytg-box">
                                                                                                                        <div class="share-panel-url-container">
                                                                                                                                <span class=" yt-uix-form-input-container "><input class="yt-uix-form-input-text share-panel-url" name="share_url" value="http://wrappertube.org/view_playlist?v=<?php echo $_playlist['rid']; ?>" data-video-id="<?php echo $_playlist['rid']; ?>" readonly onclick="this.focus();this.select();"></span>
                                                                                                                        </div>
                                                                                                                        <div class="share-panel-buttons yt-uix-expander yt-uix-expander-collapsed">
                                                                                                                                <span class="share-panel-main-buttons">
                                                                                                                                <button type="button" class="share-panel-email yt-uix-button yt-uix-button-default" href="mailto:?subject=<?php echo rawurlencode($_playlist['title']); ?>&body=http%3A%2F%2Fwrappertube.org%2Fview_playlist%3Fv%3D<?php echo rawurlencode($_playlist['rid']); ?>" role="button" onclick=";window.location.href=this.getAttribute('href');return false;"><span class="yt-uix-button-content">Email </span></button></span>
                                                                                                                        </div>
                                                                                                                        <div class="share-panel-services yt-uix-expander yt-uix-expander-collapsed clearfix">
                                                                                                                                <ul class="share-group ytg-box">
                                                                                                                                        <li>
                                                                                                                                                <button onclick="yt.tracking.shareVideo(&quot;FACEBOOK&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/www.facebook.com\/sharer.php?u=http%3A%2F%2Fwrappertube.org%2Fview_playlist%3Fv%3D<?php echo urlencode($_playlist['rid']); ?>%26feature%3Dshare\u0026t=<?php echo urlencode($_playlist['title']); ?>&quot;, {'height': 440,'width': 620,'scrollbars': true});return false;" data-service-name="FACEBOOK" title="Share to Facebook" class="yt-uix-tooltip share-service-button">
                                                                                                                                                <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Facebook" class="share-service-icon share-service-icon-facebook">
                                                                                                                                                <span>Facebook</span>
                                                                                                                                                </button>
                                                                                                                                        </li>
                                                                                                                                        <li>
                                                                                                                                                <button onclick="yt.tracking.shareVideo(&quot;TWITTER&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/twitter.com\/share?url=http%3A%2F%2Fwrappertube.org%2Fview_playlist%3Fv%3D<?php echo urlencode($_playlist['rid']); ?>\u0026text=<?php echo urlencode($_playlist['title']); ?>%3A\u0026via=wrappertube&quot;, {'height': 650,'width': 1024,'scrollbars': true});return false;" data-service-name="TWITTER" title="Share to Twitter" class="yt-uix-tooltip share-service-button" data-tooltip-text="Share to Twitter">
                                                                                                                                                <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Twitter" class="share-service-icon share-service-icon-twitter">
                                                                                                                                                <span>Twitter</span>
                                                                                                                                                </button>
                                                                                                                                        </li>
                                                                                                                                        <li>
                                                                                                                                                <button onclick="yt.tracking.shareVideo(&quot;GOOGLEPLUS&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;https:\/\/plus.google.com\/u\/0\/share?url=http%3A%2F%2Fwrappertube.org%2Fview_playlist%3Fv%3D<?php echo urlencode($_playlist['rid']); ?>%26feature%3Dshare\u0026source=yt&quot;, {'height': 620,'width': 620,'scrollbars': true});return false;" data-service-name="GOOGLEPLUS" title="Share to Google+" class="yt-uix-tooltip share-service-button" data-tooltip-text="Share to Google+">
                                                                                                                                                <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Google+" class="share-service-icon share-service-icon-googleplus">
                                                                                                                                                <span>Google+</span>
                                                                                                                                                </button>
                                                                                                                                        </li>
                                                                                                                                </ul>
                                                                                                                                <div class="yt-uix-expander-head">
                                                                                                                                        <a class="share-panel-show-more">
                                                                                                                                        <span class="collapsed-message">
                                                                                                                                        More
                                                                                                                                        <img class="arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
                                                                                                                                        </span>
                                                                                                                                        <span class="expanded-message">
                                                                                                                                        Less
                                                                                                                                        <img class="arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
                                                                                                                                        </span>
                                                                                                                                        </a>
                                                                                                                                </div>
                                                                                                                                <div class="yt-uix-expander-body share-options-secondary">
                                                                                                                                        <div class="secondary">
                                                                                                                                                <div class="share-groups">
                                                                                                                                                        <ul>
                                                                                                                                                                <li>
                                                                                                                                                                        <button onclick="yt.tracking.shareVideo(&quot;REDDIT&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/reddit.com\/submit?url=http%3A%2F%2Fwrappertube.org%2Fview_playlist%3Fv%3D<?php echo urlencode($_playlist['rid']); ?>%26feature%3Dshare\u0026title=<?php echo urlencode($_playlist['title']); ?>&quot;, {'height': 650,'width': 1024,'scrollbars': true});return false;" data-service-name="REDDIT" class="share-service-button">
                                                                                                                                                                        <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Reddit" class="share-service-icon share-service-icon-reddit">
                                                                                                                                                                        <span>Reddit</span>
                                                                                                                                                                        </button>
                                                                                                                                                                        <span>Reddit</span>
                                                                                                                                                                </li>
                                                                                                                                                                <li>
                                                                                                                                                                        <button onclick="yt.tracking.shareVideo(&quot;TUMBLR&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/www.tumblr.com\/share?v=3\u0026u=http%3A%2F%2Fwrappertube.org%2Fview_playlist%3Fv%3D<?php echo urlencode($_playlist['rid']); ?>%26feature%3Dshare&quot;, {'height': 650,'width': 1024,'scrollbars': true});return false;" data-service-name="TUMBLR" class="share-service-button">
                                                                                                                                                                        <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="tumblr." class="share-service-icon share-service-icon-tumblr">
                                                                                                                                                                        <span>tumblr.</span>
                                                                                                                                                                        </button>
                                                                                                                                                                        <span>tumblr.</span>
                                                                                                                                                                </li>
                                                                                                                                                                <li>
                                                                                                                                                                        <button onclick="yt.tracking.shareVideo(&quot;BLOGGER&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/www.blogger.com\/blog-this.g?n=<?php echo urlencode($_playlist['title']); ?>\u0026source=youtube\u0026b=%3Ciframe+width%3D%22480%22+height%3D%22270%22+src%3D%22http%3A%2F%2Fwrappertube.org%2Fembed%2F<?php echo urlencode($_playlist['rid']); ?>%3Ffs%3D1%22+frameborder%3D%220%22+allowfullscreen%3E%3C%2Fiframe%3E\u0026eurl=http%3A%2F%2Fi3.ytimg.com%2Fvi%2FngzCpd94AwA%2Fhqdefault.jpg&quot;, {'height': 468,'width': 768,'scrollbars': true});return false;" data-service-name="BLOGGER" class="share-service-button">
                                                                                                                                                                        <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Blogger" class="share-service-icon share-service-icon-blogger">
                                                                                                                                                                        <span>Blogger</span>
                                                                                                                                                                        </button>
                                                                                                                                                                        <span>Blogger</span>
                                                                                                                                                                </li>
                                                                                                                                                                <li>
                                                                                                                                                                        <button onclick="yt.tracking.shareVideo(&quot;MYSPACE&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/www.myspace.com\/Modules\/PostTo\/Pages\/?t=<?php echo urlencode($_playlist['title']); ?>\u0026u=http%3A%2F%2Fwrappertube.org%2Fview_playlist%3Fv%3D<?php echo urlencode($_playlist['rid']); ?>%26feature%3Dshare\u0026l=1&quot;, {'height': 650,'width': 1024,'scrollbars': true});return false;" data-service-name="MYSPACE" class="share-service-button">
                                                                                                                                                                        <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Myspace" class="share-service-icon share-service-icon-myspace">
                                                                                                                                                                        <span>Myspace</span>
                                                                                                                                                                        </button>
                                                                                                                                                                        <span>Myspace</span>
                                                                                                                                                                </li>
                                                                                                                                                                <li>
                                                                                                                                                                        <button onclick="yt.tracking.shareVideo(&quot;VKONTAKTE&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/vk.com\/share.php?title=<?php echo urlencode($_playlist['title']); ?>\u0026url=http%3A%2F%2Fwrappertube.org%2Fview_playlist%3Fv%3D<?php echo urlencode($_playlist['rid']); ?>%26feature%3Dshare\u0026comment=<?php echo urlencode($_playlist['description']); ?>&quot;, {'height': 650,'width': 1024,'scrollbars': true});return false;" data-service-name="VKONTAKTE" class="share-service-button">
                                                                                                                                                                        <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="VKontakte" class="share-service-icon share-service-icon-vkontakte">
                                                                                                                                                                        <span>VKontakte</span>
                                                                                                                                                                        </button>
                                                                                                                                                                        <span>VKontakte</span>
                                                                                                                                                                </li>
                                                                                                                                                                <li>
                                                                                                                                                                        <button onclick="yt.tracking.shareVideo(&quot;ODNOKLASSNIKI&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/connect.ok.ru\/dk?st.cmd=WidgetSharePreview\u0026st.shareUrl=http%3A%2F%2Fwrappertube.org%2Fview_playlist%3Fv%3D<?php echo urlencode($_playlist['rid']); ?>%26feature%3Dshare&quot;, {'height': 650,'width': 1024,'scrollbars': true});return false;" data-service-name="ODNOKLASSNIKI" class="share-service-button">
                                                                                                                                                                        <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Odnoklassiki" class="share-service-icon share-service-icon-odnoklassniki">
                                                                                                                                                                        <span>Odnoklassniki</span>
                                                                                                                                                                        </button>
                                                                                                                                                                        <span>Odnoklassniki</span>
                                                                                                                                                                </li>
                                                                                                                                                                <li>
                                                                                                                                                                        <button onclick="yt.tracking.shareVideo(&quot;TELEGRAM&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/t.me\/share\/url\/?text=<?php echo urlencode($_playlist['title']); ?>\u0026url=http%3A%2F%2Fwrappertube.org%2Fview_playlist%3Fv%3D<?php echo urlencode($_playlist['rid']); ?>%26feature%3Dshare&quot;, {'height': 650,'width': 1024,'scrollbars': true});return false;" data-service-name="TELEGRAM" class="share-service-button">
                                                                                                                                                                        <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Telegram" class="share-service-icon share-service-icon-orkut">
                                                                                                                                                                        <span>Telegram</span>
                                                                                                                                                                        </button>
                                                                                                                                                                        <span>Telegram</span>
                                                                                                                                                                </li>
                                                                                                                                                        </ul>
                                                                                                                                                        <ul>
                                                                                                                                                                <li>
                                                                                                                                                                        <button onclick="yt.tracking.shareVideo(&quot;HI5&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/www.hi5.com\/friend\/checkViewedVideo.do?t=<?php echo urlencode($_playlist['title']); ?>\u0026url=http%3A%2F%2Fwrappertube.org%2Fview_playlist%3Fv%3D<?php echo urlencode($_playlist['rid']); ?>%26feature%3Dshare\u0026embeddable=true\u0026simple=true&quot;, {'height': 475,'width': 800,'scrollbars': true});return false;" data-service-name="HI5" class="share-service-button">
                                                                                                                                                                        <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="hi5" class="share-service-icon share-service-icon-hi5">
                                                                                                                                                                        <span>hi5</span>
                                                                                                                                                                        </button>
                                                                                                                                                                        <span>hi5</span>
                                                                                                                                                                </li>
                                                                                                                                                                <li>
                                                                                                                                                                        <button onclick="yt.tracking.shareVideo(&quot;LINKEDIN&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/www.linkedin.com\/shareArticle?url=http%3A%2F%2Fwrappertube.org%2Fview_playlist%3Fv%3D<?php echo urlencode($_playlist['rid']); ?>%26feature%3Dshare\u0026title=<?php echo urlencode($_playlist['title']); ?>\u0026summary=<?php echo urlencode($_playlist['description']); ?>\u0026source=Wrappertube&quot;, {'height': 650,'width': 1024,'scrollbars': true});return false;" data-service-name="LINKEDIN" class="share-service-button">
                                                                                                                                                                        <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="LinkedIn" class="share-service-icon share-service-icon-linkedin">
                                                                                                                                                                        <span>LinkedIn</span>
                                                                                                                                                                        </button>
                                                                                                                                                                        <span>LinkedIn</span>
                                                                                                                                                                </li>
                                                                                                                                                                <li>
                                                                                                                                                                        <button onclick="yt.tracking.shareVideo(&quot;STUMBLEUPON&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/www.stumbleupon.com\/submit?url=http%3A%2F%2Fwrappertube.org%2Fview_playlist%3Fv%3D<?php echo urlencode($_playlist['rid']); ?>%26feature%3Dshare\u0026title=<?php echo urlencode($_playlist['title']); ?>&quot;, {'height': 650,'width': 1024,'scrollbars': true});return false;" data-service-name="STUMBLEUPON" class="share-service-button">
                                                                                                                                                                        <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="StumbleUpon" class="share-service-icon share-service-icon-stumbleupon">
                                                                                                                                                                        <span>StumbleUpon</span>
                                                                                                                                                                        </button>
                                                                                                                                                                        <span>StumbleUpon</span>
                                                                                                                                                                </li>
                                                                                                                                                                <li>
                                                                                                                                                                        <button onclick="yt.tracking.shareVideo(&quot;HACKERNEWS&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/news.ycombinator.com\/submitlink?t=<?php echo urlencode($_playlist['title']); ?>\u0026u=http%3A%2F%2Fwrappertube.org%2Fview_playlist%3Fv%3D<?php echo urlencode($_playlist['rid']); ?>%26feature%3Dshare&quot;, {'height': 650,'width': 1024,'scrollbars': true});return false;" data-service-name="HACKERNEWS" class="share-service-button">
                                                                                                                                                                        <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Hacker News" class="share-service-icon share-service-icon-yahoo">
                                                                                                                                                                        <span>Hacker News</span>
                                                                                                                                                                        </button>
                                                                                                                                                                        <span>Hacker News</span>
                                                                                                                                                                </li>
                                                                                                                                                                <li>
                                                                                                                                                                        <button onclick="yt.tracking.shareVideo(&quot;LIVEJOURNAL&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/www.livejournal.com\/update.bml?subject=<?php echo urlencode($_playlist['title']); ?>\u0026event=http%3A%2F%2Fwrappertube.org%2Fview_playlist%3Fv%3D<?php echo urlencode($_playlist['rid']); ?>%26feature%3Dshare&quot;, {'height': 650,'width': 1024,'scrollbars': true});return false;" data-service-name="LIVEJOURNAL" class="share-service-button">
                                                                                                                                                                        <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="LiveJournal" class="share-service-icon share-service-icon-livejournal">
                                                                                                                                                                        <span>LiveJournal</span>
                                                                                                                                                                        </button>
                                                                                                                                                                        <span>LiveJournal</span>
                                                                                                                                                                </li>
                                                                                                                                                                <li>
                                                                                                                                                                        <button onclick="yt.tracking.shareVideo(&quot;PINTEREST&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/pinterest.com\/pin\/create\/button\/?url=http%3A%2F%2Fwrappertube.org%2Fview_playlist%3Fv%3D<?php echo urlencode($_playlist['rid']); ?>%26feature%3Dshare&quot;, {'height': 650,'width': 1024,'scrollbars': true});return false;" data-service-name="PINTEREST" class="share-service-button">
                                                                                                                                                                        <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Pinterest" class="share-service-icon share-service-icon-digg">
                                                                                                                                                                        <span>Pinterest</span>
                                                                                                                                                                        </button>
                                                                                                                                                                        <span>Pinterest</span>
                                                                                                                                                                </li>
                                                                                                                                                        </ul>
                                                                                                                                                </div>
                                                                                                                                        </div>
                                                                                                                                </div>
                                                                                                                        </div>

                                                                                                                        <div class="share-panel-email-container hid">
                                                                                                                                <div>
                                                                                                                                        <img src="/static/img/loadingg.gif"> Loading...
                                                                                                                                </div>
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                                <span class="share-panel-hangout">
                                                                                                                </span>
                                                                                                        </div>
</div>
                                                            </div>
<?php if ($_user['username'] == $_SESSION['siteusername']) { ?>
<br>
<form method="GET" action="/get/add_to_playlist_page">
	<input class="yt-uix-form-input-text" name="id" placeholder="Video ID">
	<input type="hidden" name="playlist" value="<?php echo $_playlist['rid']; ?>">
	<input type="submit" value="Add to Playlist" class="yt-uix-button yt-uix-button-default">
</form>
<?php } ?>
                                                        </div>
                                                        <ol>
															<?php
																$_playlist['videos'] = json_decode($_playlist['videos']);
																$_playlist['count'] = 1;
																$i = 0;
																foreach($_playlist['videos'] as $video) {
																	if($__video_h->video_exists($video)) {
																		$_video = $__video_h->fetch_video_rid($video);
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
																		$_playlist['title'] = htmlspecialchars($_playlist['title']);
																	?>
																	<li class="playlist-video-item
																		odd
																		"> 
																		<a href="/watch?v=<?php echo $_video['rid']; ?>" class="tile-link-block video-tile">
																		<span class="playlist-video-item-base-content">
																		<span class="video-index"><?php echo $_playlist['count']; ?></span>
																		<span class="thumb-container">
																		<span class="ux-thumb-wrap">
																		<span class="video-thumb ux-thumb yt-thumb-default-124 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img  onerror=";this.src='/dynamic/thumbs/default.jpg';" src="/dynamic/thumbs/<?php echo $_video['thumbnail']; ?>" alt="Thumbnail" width="124"><span class="vertical-align"></span></span></span></span>
																		<span class="video-time"><?php echo $_video['duration']; ?></span>
																		<button onclick=";return false;" title="Watch Later" type="button" class="addto-button video-actions spf-nolink addto-watch-later-button yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" data-video-ids="<?php echo $_video['rid']; ?>" role="button"><span class="yt-uix-button-content">  <span class="addto-label">
																		Watch Later
																		</span>
																		<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif">
																		</span><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></button>
																		</span>
																		</span>
																		<span class="video-info ">
																		<span class="video-buttons">
																		</span>
																		<span class="video-overview" style="position: relative;left: 11px;">
																		<span class="title video-title " dir="ltr"><?php echo $_video['title']; ?></span>
																		<span class="video-details" style="font-size: 12px;">
																		<span class="video-owner">
																		by <span class="yt-user-name " dir="ltr"><?php echo $_video['author']; ?></span>
																		</span>
																		<span class="video-view-count">
																		<?php echo $_video['views']; ?> views
																		</span>
                                                                                                                                                <span class="video-view-count">
<img src="/static/img/<?php echo ($_video['star_ratio']>=1)?'full':(($_video['star_ratio']>=0.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($_video['star_ratio']>=2)?'full':(($_video['star_ratio']>=1.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($_video['star_ratio']>=3)?'full':(($_video['star_ratio']>=2.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($_video['star_ratio']>=4)?'full':(($_video['star_ratio']>=3.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($_video['star_ratio']>=5)?'full':(($_video['star_ratio']>=4.5)?'half':'empty'); ?>_star_s.png">
                                                                                                                                                </span>
																		</span>
																		</span>
																		</span>
																		</span>
																		</a>
																		<?php if ($_user['username'] == $_SESSION['siteusername']) { ?><button class="yt-uix-button yt-uix-button-default" onclick="if(confirm('Are you sure you want to remove this video from the playlist?')){window.location.href=this.getAttribute('href');}return false;" href="/get/remove_from_playlist?ordinal=<?php echo $i; ?>&playlist=<?php echo $_playlist['rid']; ?>">Remove</button><?php } ?>
																	</li>
																	<?php $_playlist['count']++; ?>
															<?php }
																$i++;
															} ?>
															<?php if(count($_playlist['videos']) == 0) { ?>
																<h4>This playlist has no videos yet.</h4>
															<?php } ?>
                                                        </ol>
                                                    </div>
												</div>
											</div>
										</div>
										<div class="secondary-pane">
											<div class="user-profile channel-module yt-uix-c3-module-container ">
												<div class="module-view profile-view-module" data-owner-external-id="IwFjwMjI0y7PDBVEO9-bkQ">
													<h2>About this playlist <a href="/feed/playlist?v=<?php echo htmlspecialchars($_playlist['rid']); ?>" title="Playlist RSS Feed"><img src="/static/img/feed-icon-small.png" alt="feed icon" width="14" height="14"></a></h2>
													<div class="section first">
														<div class="user-profile-item profile-description">
															<p><?php echo $__video_h->shorten_description($_playlist['description'], 999999); ?></p>
														</div>
														<div class="user-profile-item">
														</div>
														<div class="user-profile-item">
                                                            <!--
															<div class="yt-c3-profile-custom-url field-container ">
																<a href="http://smarturl.it/boyfriend?IQid=youtube" rel="me nofollow" target="_blank" title="Get &quot;Boyfriend&quot; on iTunes" class="yt-uix-redirect-link">
																<img src="//s2.googleusercontent.com/s2/favicons?domain=smarturl.it&amp;feature=youtube_channel" class="favicon" alt="">
																<span class="link-text">
																Get "Boyfriend" on iTunes
																</span>
																</a>
															</div>
															<div class="yt-c3-profile-custom-url field-container ">
																<a href="http://bieberfever.com/" rel="me nofollow" target="_blank" title="Bieber Fever" class="yt-uix-redirect-link">
																<img src="//s2.googleusercontent.com/s2/favicons?domain=bieberfever.com&amp;feature=youtube_channel" class="favicon" alt="">
																<span class="link-text">
																Bieber Fever
																</span>
																</a>
															</div>
                                                            -->
														</div>
														<hr class="yt-horizontal-rule ">
													</div>
													<?php if(!empty($_user['website'])) { ?>
														<div class="user-profile-item">
															<div class="yt-c3-profile-custom-url field-container ">
																<a href="<?php echo addhttp(htmlspecialchars($_user['website'])); ?>" rel="noopener noreferrer nofollow ugc" target="_blank" title="<?php echo htmlspecialchars($_user['website']); ?>" class="yt-uix-redirect-link">
																<img src="//www.google.com/s2/favicons?domain=<?php echo urlencode($_user['website']); ?>&sz=16" class="favicon" alt="">
																<span class="link-text">
																<?php echo htmlspecialchars($_user['website']); ?>
																</span>
																</a>
															</div>
														</div>
														<div class="user-profile-item">
															<!--
															<div class="yt-c3-profile-custom-url field-container ">
																<a href="http://smarturl.it/boyfriend?IQid=youtube" rel="me nofollow" target="_blank" title="Get &quot;Boyfriend&quot; on iTunes" class="yt-uix-redirect-link">
																<img src="//s2.googleusercontent.com/s2/favicons?domain=smarturl.it&amp;feature=youtube_channel" class="favicon" alt="">
																<span class="link-text">
																Get "Boyfriend" on iTunes
																</span>
																</a>
															</div>
															<div class="yt-c3-profile-custom-url field-container ">
																<a href="http://bieberfever.com/" rel="me nofollow" target="_blank" title="Bieber Fever" class="yt-uix-redirect-link">
																<img src="//s2.googleusercontent.com/s2/favicons?domain=bieberfever.com&amp;feature=youtube_channel" class="favicon" alt="">
																<span class="link-text">
																Bieber Fever
																</span>
																</a>
															</div>
															-->
														</div>
														<hr class="yt-horizontal-rule ">
														<?php } ?>
													<div class="section created-by-section">
                                                                                                                <div class="user-profile-item">
<img src="/static/img/mail0.png"> <a href="/inbox/compose?to=<?php echo htmlspecialchars($_user['username']); ?>">Send Message</a><br>
<img src="/static/img/comm0.png"> <a href="/user/<?php echo htmlspecialchars($_user['username']); ?>/discussion">Add Comment</a><br>
<img src="/static/img/share0.png"> <a href="javascript:void(0);" onclick="copyToClipboard('http://wrappertube.org/user/<?php echo htmlspecialchars($_user['username']); ?>');alert('Link copied to your clipboard!');return false;">Share Channel</a><br>
<img src="/static/img/block0.png"> <a href="javascript:void(0);" onclick="toggle_block();return false;" id="block_text"><?php echo $_user['blocked']?'Unb':'B'; ?>lock</a><br>
<img src="/static/img/friend0.png"> <a href="javascript:void(0);" onclick="add_friend();return false;">Add Friend</a>
                                                                                                                </div>
														<div class="user-profile-item">
															by <span class="yt-user-name " dir="ltr"><?php echo htmlspecialchars($_user['username']); ?></span>
														</div>
														<div class="user-profile-item ">
															<h5>Latest Activity</h5>
															<span class="value"><?php echo $__time_h->time_elapsed_string($_user['lastlogin']); ?></span>
														</div>
														<div class="user-profile-item ">
															<h5>Date Joined</h5>
															<span class="value"><?php echo date("M d, Y", strtotime($_user['created'])); ?></span>
														</div>
														<div class="user-profile-item ">
															<h5>Country</h5>
															<span class="value"><?php echo htmlspecialchars($_user['country']); ?></span>
														</div>
														<?php if($_user['genre'] != "none") { ?>
															<div class="user-profile-item ">
																<h5>Channel Genre</h5>
																<span class="value"><?php echo htmlspecialchars(ucfirst($_user['genre'])); ?></span>
															</div>
														<?php } ?>
                                                                                                                <div class="user-profile-item ">
                                                                                                                    <h5>Status</h5>
                                                                                                                    <span class="value"><?php echo htmlspecialchars(ucfirst($_user['status'])); ?></span>
                                                                                                                </div>
													</div>
													<hr class="yt-horizontal-rule ">
												</div>
											</div>
											<div class="channel-module other-channels yt-uix-c3-module-container other-channels-compact">
												<?php $_user['featured_channels'] = explode(",", $_user['featured_channels']); ?>
												<?php if(count($_user['featured_channels']) != 0) { ?>
												<div class="module-view other-channels-view">
													<h2>Featured Channels</h2>
													<ul class="channel-summary-list ">
														<?php 
															foreach($_user['featured_channels'] as $user) {
																if($__user_h->user_exists($user)) {
                        $chuser = $__user_h->fetch_user_username($user);
                        $chtitle = $chuser['custom_header']?$chuser['custom_header']:$user;
														?>
															<li class="yt-tile-visible yt-uix-tile">
																<div class="channel-summary clearfix channel-summary-compact">
																	<div class="channel-summary-thumb">
																		<span class="video-thumb ux-thumb yt-thumb-square-46 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Thumbnail" onerror="this.onerror=null;this.src='/dynamic/thumbs/default.jpg';" data-thumb="/dynamic/pfp/<?php echo $__user_h->fetch_pfp($user); ?>" width="46"><span class="vertical-align"></span></span></span></span>
																	</div>
																	<div class="channel-summary-info">
																		<h3 class="channel-summary-title">
																			<a href="/user/<?php echo htmlspecialchars($user); ?>" class="yt-uix-tile-link"><?php echo htmlspecialchars($chtitle); ?></a>
																		</h3>
																		<span class="subscriber-count">
																		<strong><?php echo $__user_h->fetch_subs_count($user); ?></strong>
																		subscribers
																		</span>
																	</div>
																</div>
															</li>
														<?php } } ?>
													</ul>
												</div>
												<?php } ?>
											</div>

											<?php 
												$stmt = $__db->prepare("SELECT * FROM playlists WHERE author = :search AND visibility = 'n' ORDER BY id DESC LIMIT 10");
												$stmt->bindParam(":search", $_user['username']);
												$stmt->execute();

												if($stmt->rowCount() != 0) {
											?>
												<div class="playlists-narrow channel-module yt-uix-c3-module-container">
													<div class="module-view gh-featured">
														<h2>Featured Playlists</h2>     
														<?php
														while($playlist = $stmt->fetch(PDO::FETCH_ASSOC)) { 
															$playlist['videos'] = json_decode($playlist['videos']);
                                                                    $playlist['count'] = count($playlist['videos']);
                                                                    $playlist['videos'] = array_slice($playlist['videos'], 0, 5);
                                                                    $playlist_thumbs = [];
                                                                    foreach ($playlist['videos'] as $vid) {
                                                                     if($__video_h->video_exists($vid)) {
                                                                     $video = $__video_h->fetch_video_rid($vid);
                                                                     $playlist_thumbs[] = $video['thumbnail'];
                                                                     } else {
                                                                      $playlist_thumbs[] = "default.jpg";
                                                                     }
                                                                    }
														?> 
															<div class="playlist yt-tile-visible yt-uix-tile">
																<a href="/view_playlist?v=<?php echo $playlist['rid']; ?>">
																<span class="playlist-thumb-strip playlist-thumb-strip-252"><span class="videos videos-4 horizontal-cutoff"><span class="clip"><span class="centering-offset"><span class="centering">
																	<span class="ie7-vertical-align-hack">&nbsp;</span>
																	<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" data-thumb="/dynamic/thumbs/<?php echo $playlist_thumbs[0] ?? 'default.jpg'; ?>" alt="" class="thumb"></span></span></span>
																	<span class="clip"><span class="centering-offset"><span class="centering"><span class="ie7-vertical-align-hack">&nbsp;

																	</span><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" data-thumb="/dynamic/thumbs/<?php echo $playlist_thumbs[1] ?? 'default.jpg'; ?>" alt="" class="thumb"></span></span></span>
																	<span class="clip"><span class="centering-offset"><span class="centering"><span class="ie7-vertical-align-hack">&nbsp;</span>
																	<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" data-thumb="/dynamic/thumbs/<?php echo $playlist_thumbs[2] ?? 'default.jpg'; ?>" alt="" class="thumb"></span></span></span><span class="clip"><span class="centering-offset"><span class="centering"><span class="ie7-vertical-align-hack">&nbsp;</span><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" data-thumb="/dynamic/thumbs/<?php echo $playlist_thumbs[3] ?? 'default.jpg'; ?>" alt="" class="thumb"></span></span></span></span><span class="resting-overlay"><img src="//s.ytimg.com/yt/img/channels/play-icon-resting-vflXxuFB8.png" class="play-button" alt="Play all">  <span class="video-count-box">
																<?php echo $playlist['count']; ?> videos
																</span>
																</span><span class="hover-overlay"><span class="play-all-container"><strong><img src="//s.ytimg.com/yt/img/channels/mini-play-all-vflZu1SBs.png" alt="">Play all</strong></span></span></span>
																</a>
																<h3>
																	<a href="/view_playlist?v=<?php echo $playlist['rid']; ?>" title="See all videos in playlist." class="yt-uix-tile-link">
																		<?php echo htmlspecialchars($playlist['title']); ?>
																	</a>
																</h3>
																<span class="playlist-author-attribution">
																by <?php echo htmlspecialchars($_user['custom_header']); ?>
																</span>
															</div>
														<?php }  ?>
													</div>
												</div>
											<?php } $stmt = null; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- end content -->
			</div>
			<div id="footer-container">
				<!-- begin footer -->
				<script>
					if (window.yt.timing) {yt.timing.tick("foot_begin");}    
				</script>
				<div id="footer"><?php require($_SERVER['DOCUMENT_ROOT'] . "/s/mod/footer.php"); ?></div>
				<script>
					if (window.yt.timing) {yt.timing.tick("foot_end");}    
				</script>
				<!-- end footer -->
			</div>
			<div id="playlist-bar" class="hid passive editable" data-video-url="/watch?v=&amp;feature=BFql&amp;playnext=1&amp;list=QL" data-list-id="" data-list-type="QL">
				<div id="playlist-bar-bar-container">
					<div id="playlist-bar-bar">
						<div class="yt-alert yt-alert-naked yt-alert-success hid " id="playlist-bar-notifications">
							<div class="yt-alert-icon"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon"></div>
							<div class="yt-alert-content" role="alert"></div>
						</div>
						<span id="playlist-bar-info"><span class="playlist-bar-active playlist-bar-group"><button onclick=";return false;" title="Previous video" type="button" id="playlist-bar-prev-button" class="yt-uix-tooltip yt-uix-tooltip-masked  yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-playlist-bar-prev" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Previous video"></span></button><span class="playlist-bar-count"><span class="playing-index">0</span> / <span class="item-count">0</span></span><button type="button" class="yt-uix-tooltip yt-uix-tooltip-masked  yt-uix-button yt-uix-button-default yt-uix-button-empty" onclick=";return false;" id="playlist-bar-next-button" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-playlist-bar-next" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></span></button></span><span class="playlist-bar-active playlist-bar-group"><button type="button" class="yt-uix-tooltip yt-uix-tooltip-masked  yt-uix-button yt-uix-button-default yt-uix-button-empty" onclick=";return false;" id="playlist-bar-autoplay-button" data-button-toggle="true" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-playlist-bar-autoplay" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></span></button><button type="button" class="yt-uix-tooltip yt-uix-tooltip-masked  yt-uix-button yt-uix-button-default yt-uix-button-empty" onclick=";return false;" id="playlist-bar-shuffle-button" data-button-toggle="true" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-playlist-bar-shuffle" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></span></button></span><span class="playlist-bar-passive playlist-bar-group"><button onclick=";return false;" title="Play videos" type="button" id="playlist-bar-play-button" class="yt-uix-tooltip yt-uix-tooltip-masked  yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-playlist-bar-play" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Play videos"></span></button><span class="playlist-bar-count"><span class="item-count">0</span></span></span><span id="playlist-bar-title" class="yt-uix-button-group"><span class="playlist-title">Unsaved Playlist</span></span></span>
						<a id="playlist-bar-lists-back" href="#">
						Return to active list
						</a>
						<span id="playlist-bar-controls"><span class="playlist-bar-group"><button type="button" class="yt-uix-tooltip yt-uix-tooltip-masked  yt-uix-button yt-uix-button-text yt-uix-button-empty" onclick=";return false;" id="playlist-bar-toggle-button" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-playlist-bar-toggle" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></span></button></span><span class="playlist-bar-group"><button type="button" class="yt-uix-tooltip yt-uix-tooltip-masked yt-uix-button-reverse flip yt-uix-button yt-uix-button-text" onclick=";return false;" data-button-menu-id="playlist-bar-options-menu" data-button-has-sibling-menu="true" role="button"><span class="yt-uix-button-content">Options </span><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></button></span></span>      
					</div>
				</div>
				<div id="playlist-bar-tray-container">
					<div id="playlist-bar-tray" class="yt-uix-slider yt-uix-slider-fluid">
						<button class="yt-uix-button playlist-bar-tray-button yt-uix-button-default yt-uix-slider-prev" onclick="return false;"><img class="yt-uix-slider-prev-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Previous video"></button><button class="yt-uix-button playlist-bar-tray-button yt-uix-button-default yt-uix-slider-next" onclick="return false;"><img class="yt-uix-slider-next-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Next video"></button>
						<div class="yt-uix-slider-body">
							<div id="playlist-bar-tray-content" class="yt-uix-slider-slide">
								<ol class="video-list"></ol>
								<ol id="playlist-bar-help">
									<li class="empty playlist-bar-help-message">Your queue is empty. Add videos to your queue using this button: <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="addto-button-help"><br> or <a href="https://accounts.google.com/ServiceLogin?uilel=3&amp;service=youtube&amp;passive=true&amp;continue=http%3A%2F%2Fwww.youtube.com%2Fsignin%3Faction_handle_signin%3Dtrue%26feature%3Dplaylist%26nomobiletemp%3D1%26hl%3Den_US%26next%3D%252Fuser%252F<?php echo htmlspecialchars($_user['username']); ?>%253Ffeature%253Dg-logo-xit&amp;hl=en_US&amp;ltmpl=sso">sign in</a> to load a different list.</li>
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
						<!--<li class="playlist-bar-item yt-uix-slider-slide-unit __classes__" data-video-id="__video_encrypted_id__"><a href="__video_url__" title="__video_title__"><span class="video-thumb ux-thumb yt-thumb-default-106 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="__video_title__" data-thumb-manual="true" data-thumb="__video_thumb_url__" width="106" ><span class="vertical-align"></span></span></span></span><span class="screen"></span><span class="count"><strong>__list_position__</strong></span><span class="play"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif"></span><span class="yt-uix-button yt-uix-button-default delete"><img class="yt-uix-button-icon-playlist-bar-delete" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Delete"></span><span class="now-playing">Now playing</span><span dir="ltr" class="title"><span>__video_title__  <span class="uploader">by __video_display_name__</span>
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
				<a href="https://accounts.google.com/ServiceLogin?uilel=3&amp;service=youtube&amp;passive=true&amp;continue=http%3A%2F%2Fwww.youtube.com%2Fsignin%3Faction_handle_signin%3Dtrue%26feature%3Dplaylist%26nomobiletemp%3D1%26hl%3Den_US%26next%3D%252Fuser%252F<?php echo htmlspecialchars($_user['username']); ?>%253Ffeature%253Dg-logo-xit&amp;hl=en_US&amp;ltmpl=sso" class="sign-in-link">Sign in</a> to add this to a playlist
			</div>
			<div id="shared-addto-menu" style="display: none;" class="hid sign-in">
				<div class="addto-menu">
					<div id="addto-list-panel" class="menu-panel active-panel">
						<span class="yt-uix-button-menu-item yt-uix-tooltip sign-in" data-possible-tooltip="" data-tooltip-show-delay="750"><a href="https://accounts.google.com/ServiceLogin?uilel=3&amp;service=youtube&amp;passive=true&amp;continue=http%3A%2F%2Fwww.youtube.com%2Fsignin%3Faction_handle_signin%3Dtrue%26feature%3Dplaylist%26nomobiletemp%3D1%26hl%3Den_US%26next%3D%252Fuser%252F<?php echo htmlspecialchars($_user['username']); ?>%253Ffeature%253Dg-logo-xit&amp;hl=en_US&amp;ltmpl=sso" class="sign-in-link">Sign in</a> to add this to a playlist
						</span>
					</div>
					<div id="addto-list-saved-panel" class="menu-panel">
						<div class="panel-content">
							<div class="yt-alert yt-alert-naked yt-alert-success  ">
								<div class="yt-alert-icon"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon"></div>
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
								<div class="yt-alert-icon"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon"></div>
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
		<script id="www-core-js" src="//s.ytimg.com/yt/jsbin/www-core-vfl-1JTp7.js" data-loaded="true"></script>
		<script>
			yt.setConfig({
			'XSRF_TOKEN': 'HxVja_B7VM4N8Luf5v0rMCobR658MTMzOTgwODA4MkAxMzM5NzIxNjgy',
			'XSRF_FIELD_NAME': 'session_token'
			});
			yt.pubsub.subscribe('init', yt.www.xsrf.populateSessionToken);
			
			yt.setConfig('XSRF_REDIRECT_TOKEN', 'DsikobgaHVx4FiaLsFlCk4-dGCt8MTMzOTgwODA4MkAxMzM5NzIxNjgy');
			
			yt.setConfig('LOGGED_IN', false);
			yt.setConfig('SESSION_INDEX', null);
			
			yt.setConfig('FEEDBACK_LOCALE_LANGUAGE', "en");
			yt.setConfig('FEEDBACK_LOCALE_EXTRAS', {"experiments": "904001,907342,904824,910206,908620,907217,907335,921602,919306,922600,919316,920704,912804,913542,919324,912706", "accept_language": null});
		</script>
		<script>
			if (window.yt.timing) {yt.timing.tick("js_head");}    
		</script>
		<script src="//s.ytimg.com/yt/jsbin/www-channels3-vflCdEY9I.js" data-loaded="true"></script>
		<script>
			yt.setConfig('CHANNEL_ID', "IwFjwMjI0y7PDBVEO9-bkQ");
			yt.setAjaxToken('channel_ajax', "");
			
			yt.setMsg({
			'UNBLOCK_USER': "Are you sure you want to unblock this user?",
			'BLOCK_USER': "Are you sure you want to block this user?"
			});
			yt.setConfig('BLOCK_USER_AJAX_XSRF', '');
			
			
			yt.setMsg({
			'GENERIC_EDITOR_ERROR': "An error occurred. Please try again later."
			});
			yt.pubsub.subscribe('init', yt.www.channels3.channel.init);
			
		</script>
		<script  src="//s.ytimg.com/yt/jsbin/www-playlist-vfl4K5Qk_.js" data-loaded="true"></script>
		<script>
			yt.setAjaxToken('subscription_ajax', "");
			  yt.pubsub.subscribe('init', yt.www.subscriptions.SubscriptionButton.init);
		</script>
		<script src="//s.ytimg.com/yt/jsbin/www-watch-livestreaming-vfliBd-IQ.js" data-loaded="true"></script>
		<script>
			yt.setMsg('FLASH_UPGRADE', "\u003cdiv class=\"yt-alert yt-alert-default yt-alert-error  yt-alert-player\"\u003e\u003cdiv class=\"yt-alert-icon\"\u003e\u003cimg s\u0072c=\"\/\/s.ytimg.com\/yt\/img\/pixel-vfl3z5WfW.gif\" class=\"icon master-sprite\" alt=\"Alert icon\"\u003e\u003c\/div\u003e\u003cdiv class=\"yt-alert-buttons\"\u003e\u003c\/div\u003e\u003cdiv class=\"yt-alert-content\" role=\"alert\"\u003e    \u003cspan class=\"yt-alert-vertical-trick\"\u003e\u003c\/span\u003e\n    \u003cdiv class=\"yt-alert-message\"\u003e\n            You need to upgrade your Adobe Flash Player to watch this video. \u003cbr\u003e \u003ca href=\"http:\/\/get.adobe.com\/flashplayer\/\"\u003eDownload it from Adobe.\u003c\/a\u003e\n    \u003c\/div\u003e\n\u003c\/div\u003e\u003c\/div\u003e");
			yt.setConfig({
			'PLAYER_CONFIG': {"assets": {"html": "\/html5_player_template", "css": "http:\/\/s.ytimg.com\/yt\/cssbin\/www-player-vfllhw7HB.css", "js": "http:\/\/s.ytimg.com\/yt\/jsbin\/html5player-vflzTrRqK.js"}, "url": "http:\/\/s.ytimg.com\/yt\/swfbin\/watch_as3-vflbPspVE.swf", "min_version": "8.0.0", "args": {"ttsurl": "http:\/\/www.youtube.com\/api\/timedtext?sparams=asr_langs%2Ccaps%2Cv%2Cexpire\u0026asr_langs=en%2Cko%2Cja%2Ces\u0026v=/watch?v=<?php echo $video['rid']; ?>\u0026caps=asr\u0026expire=1339746882\u0026key=yttt1\u0026signature=A1B858FF427B45672676C7403417ED1F4091A806.C347A6021C0F843E46F2056AEBA38FC93A0A47B8\u0026hl=en_US", "el": "profilepage", "fexp": "904001,907342,904824,910206,908620,907217,907335,921602,919306,922600,919316,920704,912804,913542,919324,912706", "url_encoded_fmt_stream_map": "url=http%3A%2F%2Fo-o.preferred.nuq04s10.v1.lscache4.c.youtube.com%2Fvideoplayback%3Fupn%3D_7WL7XeDtjs%26sparams%3Dcp%252Cid%252Cip%252Cipbits%252Citag%252Cratebypass%252Csource%252Cupn%252Cexpire%26fexp%3D904001%252C907342%252C904824%252C910206%252C908620%252C907217%252C907335%252C921602%252C919306%252C922600%252C919316%252C920704%252C912804%252C913542%252C919324%252C912706%26ms%3Dau%26itag%3D44%26ip%3D207.0.0.0%26signature%3D9B9B5ECF02F2F66BDCCB0ACED26D3406F9F83241.1B2CC833461E3D2C4D081B7DFBC65B0948C61FB9%26sver%3D3%26mt%3D1339721111%26ratebypass%3Dyes%26source%3Dyoutube%26expire%3D1339743583%26key%3Dyt1%26ipbits%3D8%26cp%3DU0hSTldPUV9NTUNOMl9PSVVGOmdTcVlPRFNNTEdM%26id%3D56ffd0bfee85d71f\u0026quality=large\u0026fallback_host=tc.v1.cache4.c.youtube.com\u0026type=video%2Fwebm%3B+codecs%3D%22vp8.0%2C+vorbis%22\u0026itag=44,url=http%3A%2F%2Fo-o.preferred.nuq04s10.v14.lscache1.c.youtube.com%2Fvideoplayback%3Fupn%3D_7WL7XeDtjs%26sparams%3Dalgorithm%252Cburst%252Ccp%252Cfactor%252Cid%252Cip%252Cipbits%252Citag%252Csource%252Cupn%252Cexpire%26fexp%3D904001%252C907342%252C904824%252C910206%252C908620%252C907217%252C907335%252C921602%252C919306%252C922600%252C919316%252C920704%252C912804%252C913542%252C919324%252C912706%26mt%3D1339721111%26ms%3Dau%26algorithm%3Dthrottle-factor%26itag%3D35%26ip%3D207.0.0.0%26burst%3D40%26sver%3D3%26signature%3DB702D7CA72653169BDC2C945B5A35F4A23A3FEBF.ACC660CDAB11901FF8D3DA8D384D61F0AB0F0125%26source%3Dyoutube%26expire%3D1339743583%26key%3Dyt1%26ipbits%3D8%26factor%3D1.25%26cp%3DU0hSTldPUV9NTUNOMl9PSVVGOmdTcVlPRFNNTEdM%26id%3D56ffd0bfee85d71f\u0026quality=large\u0026fallback_host=tc.v14.cache1.c.youtube.com\u0026type=video%2Fx-flv\u0026itag=35,url=http%3A%2F%2Fo-o.preferred.nuq04s10.v24.lscache3.c.youtube.com%2Fvideoplayback%3Fupn%3D_7WL7XeDtjs%26sparams%3Dcp%252Cid%252Cip%252Cipbits%252Citag%252Cratebypass%252Csource%252Cupn%252Cexpire%26fexp%3D904001%252C907342%252C904824%252C910206%252C908620%252C907217%252C907335%252C921602%252C919306%252C922600%252C919316%252C920704%252C912804%252C913542%252C919324%252C912706%26ms%3Dau%26itag%3D43%26ip%3D207.0.0.0%26signature%3D9FABDD8C013AA137B87DF2D154D1B90E6827A2A3.880FECDEC066236D85FCF223CF472B62B8F9B3A4%26sver%3D3%26mt%3D1339721111%26ratebypass%3Dyes%26source%3Dyoutube%26expire%3D1339743583%26key%3Dyt1%26ipbits%3D8%26cp%3DU0hSTldPUV9NTUNOMl9PSVVGOmdTcVlPRFNNTEdM%26id%3D56ffd0bfee85d71f\u0026quality=medium\u0026fallback_host=tc.v24.cache3.c.youtube.com\u0026type=video%2Fwebm%3B+codecs%3D%22vp8.0%2C+vorbis%22\u0026itag=43,url=http%3A%2F%2Fo-o.preferred.nuq04s10.v3.lscache7.c.youtube.com%2Fvideoplayback%3Fupn%3D_7WL7XeDtjs%26sparams%3Dalgorithm%252Cburst%252Ccp%252Cfactor%252Cid%252Cip%252Cipbits%252Citag%252Csource%252Cupn%252Cexpire%26fexp%3D904001%252C907342%252C904824%252C910206%252C908620%252C907217%252C907335%252C921602%252C919306%252C922600%252C919316%252C920704%252C912804%252C913542%252C919324%252C912706%26mt%3D1339721111%26ms%3Dau%26algorithm%3Dthrottle-factor%26itag%3D34%26ip%3D207.0.0.0%26burst%3D40%26sver%3D3%26signature%3D1BA326B784DAA9F62FD789CBB5C2FABFCD5D351C.C4618E3AB2AB08C61C6A982A36F405DA886B5D5A%26source%3Dyoutube%26expire%3D1339743583%26key%3Dyt1%26ipbits%3D8%26factor%3D1.25%26cp%3DU0hSTldPUV9NTUNOMl9PSVVGOmdTcVlPRFNNTEdM%26id%3D56ffd0bfee85d71f\u0026quality=medium\u0026fallback_host=tc.v3.cache7.c.youtube.com\u0026type=video%2Fx-flv\u0026itag=34,url=http%3A%2F%2Fo-o.preferred.nuq04s10.v14.lscache1.c.youtube.com%2Fvideoplayback%3Fupn%3D_7WL7XeDtjs%26sparams%3Dcp%252Cid%252Cip%252Cipbits%252Citag%252Cratebypass%252Csource%252Cupn%252Cexpire%26fexp%3D904001%252C907342%252C904824%252C910206%252C908620%252C907217%252C907335%252C921602%252C919306%252C922600%252C919316%252C920704%252C912804%252C913542%252C919324%252C912706%26ms%3Dau%26itag%3D18%26ip%3D207.0.0.0%26signature%3D8806EA8FAE16557A2F9732068442133EA0A0760F.D91694A47E6B0BF627965CDA46010F36105A28FE%26sver%3D3%26mt%3D1339721111%26ratebypass%3Dyes%26source%3Dyoutube%26expire%3D1339743583%26key%3Dyt1%26ipbits%3D8%26cp%3DU0hSTldPUV9NTUNOMl9PSVVGOmdTcVlPRFNNTEdM%26id%3D56ffd0bfee85d71f\u0026quality=medium\u0026fallback_host=tc.v14.cache1.c.youtube.com\u0026type=video%2Fmp4%3B+codecs%3D%22avc1.42001E%2C+mp4a.40.2%22\u0026itag=18,url=http%3A%2F%2Fo-o.preferred.nuq04s10.v4.lscache1.c.youtube.com%2Fvideoplayback%3Fupn%3D_7WL7XeDtjs%26sparams%3Dalgorithm%252Cburst%252Ccp%252Cfactor%252Cid%252Cip%252Cipbits%252Citag%252Csource%252Cupn%252Cexpire%26fexp%3D904001%252C907342%252C904824%252C910206%252C908620%252C907217%252C907335%252C921602%252C919306%252C922600%252C919316%252C920704%252C912804%252C913542%252C919324%252C912706%26mt%3D1339721111%26ms%3Dau%26algorithm%3Dthrottle-factor%26itag%3D5%26ip%3D207.0.0.0%26burst%3D40%26sver%3D3%26signature%3D011CB6739AB60ED79D032DE2F62EB016D8A8E462.C2C0ABE42F26DBA18F2BC6E0D074EB99A95C0DF0%26source%3Dyoutube%26expire%3D1339743583%26key%3Dyt1%26ipbits%3D8%26factor%3D1.25%26cp%3DU0hSTldPUV9NTUNOMl9PSVVGOmdTcVlPRFNNTEdM%26id%3D56ffd0bfee85d71f\u0026quality=small\u0026fallback_host=tc.v4.cache1.c.youtube.com\u0026type=video%2Fx-flv\u0026itag=5,url=http%3A%2F%2Fo-o.preferred.nuq04s10.v12.lscache3.c.youtube.com%2Fvideoplayback%3Fupn%3D_7WL7XeDtjs%26sparams%3Dalgorithm%252Cburst%252Ccp%252Cfactor%252Cid%252Cip%252Cipbits%252Citag%252Csource%252Cupn%252Cexpire%26fexp%3D904001%252C907342%252C904824%252C910206%252C908620%252C907217%252C907335%252C921602%252C919306%252C922600%252C919316%252C920704%252C912804%252C913542%252C919324%252C912706%26mt%3D1339721111%26ms%3Dau%26algorithm%3Dthrottle-factor%26itag%3D36%26ip%3D207.0.0.0%26burst%3D40%26sver%3D3%26signature%3D988FDD37CBA8DB74C1148EE17921D8549434297C.A2C1796F2BA0427C9FE370BFB6B3B09BA1D81B07%26source%3Dyoutube%26expire%3D1339743583%26key%3Dyt1%26ipbits%3D8%26factor%3D1.25%26cp%3DU0hSTldPUV9NTUNOMl9PSVVGOmdTcVlPRFNNTEdM%26id%3D56ffd0bfee85d71f\u0026quality=small\u0026fallback_host=tc.v12.cache3.c.youtube.com\u0026type=video%2F3gpp\u0026itag=36", "allow_embed": 1, "vq": "auto", "account_playback_token": "", "allow_ratings": 1, "keywords": "Rehearsal,Dance,justin,bieber,believe,as,long,you,love,me,rodney,jerkins,pattie,mallette,jeremy,dad,mom,scooter,braun,island,def,jam,usher,rbmg,making,of,the,album,webisode,june,19th,19,new,amazing,song,big,sean,hit,record,<?php echo htmlspecialchars($_user['username']); ?>,always,still,studio,singing,kuk,harrell,producer,sing,boy,guy,man,smash,single,nick,demoura,dancers,sweat,beliebers,hard,work,tour,band", "cc3_module": "http:\/\/s.ytimg.com\/yt\/swfbin\/subtitles3_module-vflu_Qeod.swf", "track_embed": 0, "is_purchased": false, "ps": "default", "fmt_list": "44\/854x480\/99\/0\/0,35\/854x480\/9\/0\/115,43\/640x360\/99\/0\/0,34\/640x360\/9\/0\/115,18\/640x360\/9\/0\/115,5\/320x240\/7\/0\/0,36\/320x240\/99\/0\/0", "author": "<?php echo htmlspecialchars($_user['username']); ?>", "muted": "0", "cc_module": "http:\/\/s.ytimg.com\/yt\/swfbin\/subtitle_module-vflq8KnSi.swf", "length_seconds": 82, "feature": "g-logo-xit", "enablejsapi": 1, "rel": 0, "plid": "AATCeEL9eg3Ls9t-", "cc_font": "Arial Unicode MS, arial, verdana, _sans", "ftoken": "", "sdetail": "f:g-logo-xit,p:\/", "status": "ok", "cc_asr": 1, "watermark": ",http:\/\/s.ytimg.com\/yt\/img\/watermark\/youtube_watermark-vflHX6b6E.png,http:\/\/s.ytimg.com\/yt\/img\/watermark\/youtube_hd_watermark-vflAzLcD6.png", "sourceid": "y", "timestamp": 1339721682, "has_cc": true, "view_count": 2600, "quality_cap": "highres", "hl": "en_US", "tmi": "1", "no_get_video_log": "1", "eurl": "http:\/\/www.youtube.com\/user\/<?php echo htmlspecialchars($_user['username']); ?>", "iurl": "http:\/\/i3.ytimg.com\/vi\//watch?v=<?php echo $video['rid']; ?>\/hqdefault.jpg", "endscreen_module": "http:\/\/s.ytimg.com\/yt\/swfbin\/endscreen-vflJBKwqC.swf", "referrer": "http:\/\/www.youtube.com\/", "avg_rating": 4.97805486284, "video_id": "/watch?v=<?php echo $video['rid']; ?>", "sendtmp": "1", "sk": "bwv_lGOGF4u1g0p7puy7ERICN8NZ5cVFC", "is_video_preview": false, "token": "vjVQa1PpcFMSYb-unvOiIgSL8pW9tObJUMfrEc1mxfE=", "thumbnail_url": "http:\/\/i3.ytimg.com\/vi\//watch?v=<?php echo $video['rid']; ?>\/default.jpg", "iurlsd": "http:\/\/i3.ytimg.com\/vi\//watch?v=<?php echo $video['rid']; ?>\/sddefault.jpg", "autoplay": "1"}, "url_v9as2": "http:\/\/s.ytimg.com\/yt\/swfbin\/cps-vflhvG6F4.swf", "params": {"allowscriptaccess": "always", "allowfullscreen": "true", "bgcolor": "#000000"}, "attrs": {"width": "640", "id": "movie_player", "height": "390"}, "url_v8": "http:\/\/s.ytimg.com\/yt\/swfbin\/cps-vflhvG6F4.swf", "html5": false}
			});
			
		</script>
		<script>
			yt.pubsub.subscribe('init', function() {
			  yt.setAjaxToken('watch_actions_ajax', "");
			});
			yt.setMsg({
			    'CHANNELS3_FEATURED_PLAYER_GENERIC_ERROR': "This feature is not available right now. Please try again later."
			})
			  yt.pubsub.subscribe('init', function () {
			    yt.www.livestreaming.ConcurrentViewers(30000)
			  });
		</script>
		<script>
			yt.pubsub.subscribe('init', yt.www.channels3.channel.initBloggerLayout);
		</script>
		<script>
			var channel_customization_toggled = false;

			function open_channel_customization() {
				console.log("screw");
				if(channel_customization_toggled == false) {
					console.log("screw1");
					$("#masthead-customization").fadeIn(300);
					channel_customization_toggled = true;
				} else {
					console.log("screw2");
					$("#masthead-customization").fadeOut(300);
					channel_customization_toggled = false;	
				}
			}
		</script>
		<script>
			if (window.yt.timing) {yt.timing.tick("js_page");}    
		</script>
		<script>
			yt.setConfig('TIMING_ACTION', "channels3");    
		</script>
		<script>yt.www.thumbnaildelayload.init(0);</script>
		<script>
			var subscribed = <?php echo($_user['subscribed'] ? 'true' : 'false') ?>;
			var loggedIn = <?php echo(isset($_SESSION['siteusername']) ? 'true' : 'false') ?>;
                        var blocked = <?php echo($_user['blocked'] ? 'true' : 'false') ?>;
			var alerts = 0;
 
			function subscribe() {
				if(loggedIn == true) { 
					if(subscribed == false) { 
						$.ajax({
							url: "/get/subscribe?n=<?php echo urlencode($_user['username']); ?>",
							type: 'GET',
							success: function(res) {
								alerts++;
								$("#subscribe-button").addClass("subscribed");
								addAlert("editsuccess_" + alerts, "Successfully added <?php echo htmlspecialchars($_user['username']); ?> to your subscriptions!");
								showAlert("#editsuccess_" + alerts);
								console.log("DEBUG: " + res);
								subscribed = true;
							}
						});
					} else {
						$.ajax({
							url: "/get/unsubscribe?n=<?php echo urlencode($_user['username']); ?>",
							type: 'GET',
							success: function(res) {
								alerts++;
								$("#subscribe-button").removeClass("subscribed");
								addAlert("editsuccess_" + alerts, "Successfully removed <?php echo htmlspecialchars($_user['username']); ?> from your subscriptions!");
								showAlert("#editsuccess_" + alerts);
								console.log("DEBUG: " + res);
								subscribed = false;
							}
						});
					}
				} else {
					alerts++;
					addAlert("editsuccess_" + alerts, "You need to log in to add subscriptions!");
					showAlert("#editsuccess_" + alerts);
				}
			}

                        function toggle_block() {
                                    var did_i_block_already = blocked;
                                    $.ajax({
                                            url: did_i_block_already ? "/get/unblock?user=<?php echo urlencode($_user['username']); ?>" : "/get/block?user=<?php echo urlencode($_user['username']); ?>",
                                            type: 'GET',
                                            success: function(res) {
                                            if (res == "OK") {
                                                    $("#block_text").text((did_i_block_already ? "B" : "Unb") + "lock");
                                                    blocked = !blocked;
                                            } else {
                                                    alerts++;
                                                    addAlert("editsuccess_" + alerts, res);
                                                    showAlert("#editsuccess_" + alerts);
                                            }
                                            }
                                    });
                        }


                        function add_friend() {
                                    $.ajax({
                                            url: "/get/add_friend?sending=<?php echo urlencode($_user['username']); ?>",
                                            type: 'GET',
                                            success: function(res) {
                                            if (res == "OK") {
                                                    alerts++;
                                                    addAlert("editsuccess_" + alerts, "Successfully sent friend request.");
                                                    showAlert("#editsuccess_" + alerts);
                                            } else {
                                                    alerts++;
                                                    addAlert("editsuccess_" + alerts, res);
                                                    showAlert("#editsuccess_" + alerts);
                                            }
                                            }
                                    });
                        }
		</script>
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
			  'DRAGDROP_BINARY_URL': "\/\/s.ytimg.com\/yt\/jsbin\/www-dragdrop-vflM9ls_8.js",
			  'PLAYLIST_BAR_PLAYING_INDEX': -1,
			  'LIST_COPY_ON_EDIT_ENABLED': false  });
			
			  yt.setAjaxToken('addto_ajax_logged_out', "FFGgxx_wEgpAnRrnvI2vI_uxiJd8MEAxMzM5NzIxNjgy");
			
			  yt.pubsub.subscribe('init', yt.www.lists.init);
			
			
			
			
			
			
			
			
			    yt.pubsub.subscribe('init', function() {
			      yt.net.scriptloader.load("\/\/s.ytimg.com\/yt\/jsbin\/www-searchbox-vflVGQHuy.js", function() {
			        
			    if (_gel('masthead-search')) {
			      yt.setTimeout(function() {
			        searchbox.yt.install(_gel('masthead-search'),
			            _gel('masthead-search')["search_query"],
			            "en",
			            "us",
			            false,
			            '',
			            '',
			            null,
			            null,
			            "Suggestion dismissed",
			            "Dismiss",
			            -1,
			            {});
			      }, 100);
			    }
			
			      });
			    });
			
			
			
		</script>
		<script>
			yt.setMsg({
			  'ADDTO_WATCH_LATER_ADDED': "Added",
			  'ADDTO_WATCH_LATER_ERROR': "Error"
			});
			
			yt.pubsub.subscribe('init', yt.www.lists.addtowatchlater.init);
		</script>
		<script>
			if (window.yt.timing) {yt.timing.tick("js_foot");}    
		</script>
<script type="text/javascript" language="JavaScript">
function copyToClipboard(e) {
    var t = document.createElement("input");
    document.body.appendChild(t);
    t.value = e;
    t.select();
    document.execCommand("copy");
    t.parentNode.removeChild(t);
}
function insertThisInThere(thisChar, thereId) {
	function theCursorPosition(ofThisInput) {
		// set a fallback cursor location
		var theCursorLocation = 0;
 
		// find the cursor location via IE method...
		if (document.selection) {
			ofThisInput.focus();
			var theSelectionRange = document.selection.createRange();
			theSelectionRange.moveStart('character', -ofThisInput.value.length);
			theCursorLocation = theSelectionRange.text.length;
		} else if (ofThisInput.selectionStart || ofThisInput.selectionStart == '0') {
			// or the FF way 
			theCursorLocation = ofThisInput.selectionStart;
		}
		return theCursorLocation;
	}
 
	// now get ready to place our new character(s)...
	var theIdElement = document.getElementById(thereId);
	var currentPos = theCursorPosition(theIdElement);
	var origValue = theIdElement.value;
	var newValue = origValue.substr(0, currentPos) + thisChar + origValue.substr(currentPos);
 
	theIdElement.value = newValue;
 
}
</script>
        <script src="/static/js/prefixfree.min.js"></script>
	</body>
</html>
