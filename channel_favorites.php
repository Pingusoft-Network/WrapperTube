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
if (!startsWith($_SERVER['REQUEST_URI'], "/user/")) {
die(header("Location: /user/" . $_GET['n'] . "/favorites"));
}

	if(isset($_SESSION['siteusername']))
	    $_user_hp = $__user_h->fetch_user_username($_SESSION['siteusername']);

    if(!$__user_h->user_exists($_GET['n']))
        die(header("Location: /?userdoesntexist"));

    $_user = $__user_h->fetch_user_username($_GET['n']);

	$stmt = $__db->prepare("SELECT * FROM bans WHERE username = :username LIMIT 1");
	$stmt->bindParam(":username", $_user['username']);
	$stmt->execute();

	while($ban = $stmt->fetch(PDO::FETCH_ASSOC)) { 
                $banned = $ban['reason'];
                $_GET['error'] = "This user has been banned until " . ( $ban['real_expire'] ? date("D, M d, Y, h:i A", $ban['real_expire']) : "the end of time" ) . " because of " . $ban['reason'];
	}
	$stmt = null;

if ($__user_h->if_2009($_user['username'])) {
include($_SERVER['DOCUMENT_ROOT'] . "/channel2009_favorites.php");
die();
}

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
        if (preg_match('/(#(?:[0-9a-f]{2}){2,4}$|(#[0-9a-f]{3}$)|(rgb|hsl)a?\((-?\d+%?[,\s]+){2,3}\s*[\d\.]+%?\)$|black$|silver$|gray$|whitesmoke$|maroon$|red$|purple$|fuchsia$|green$|lime$|olivedrab$|yellow$|navy$|blue$|teal$|aquamarine$|orange$|aliceblue$|antiquewhite$|aqua$|azure$|beige$|bisque$|blanchedalmond$|blueviolet$|brown$|burlywood$|cadetblue$|chartreuse$|chocolate$|coral$|cornflowerblue$|cornsilk$|crimson$|currentcolor$|darkblue$|darkcyan$|darkgoldenrod$|darkgray$|darkgreen$|darkgrey$|darkkhaki$|darkmagenta$|darkolivegreen$|darkorange$|darkorchid$|darkred$|darksalmon$|darkseagreen$|darkslateblue$|darkslategray$|darkslategrey$|darkturquoise$|darkviolet$|deeppink$|deepskyblue$|dimgray$|dimgrey$|dodgerblue$|firebrick$|floralwhite$|forestgreen$|gainsboro$|ghostwhite$|goldenrod$|gold$|greenyellow$|grey$|honeydew$|hotpink$|indianred$|indigo$|ivory$|khaki$|lavenderblush$|lavender$|lawngreen$|lemonchiffon$|lightblue$|lightcoral$|lightcyan$|lightgoldenrodyellow$|lightgray$|lightgreen$|lightgrey$|lightpink$|lightsalmon$|lightseagreen$|lightskyblue$|lightslategray$|lightslategrey$|lightsteelblue$|lightyellow$|limegreen$|linen$|mediumaquamarine$|mediumblue$|mediumorchid$|mediumpurple$|mediumseagreen$|mediumslateblue$|mediumspringgreen$|mediumturquoise$|mediumvioletred$|midnightblue$|mintcream$|mistyrose$|moccasin$|navajowhite$|oldlace$|olive$|orangered$|orchid$|palegoldenrod$|palegreen$|paleturquoise$|palevioletred$|papayawhip$|peachpuff$|peru$|pink$|plum$|powderblue$|rosybrown$|royalblue$|saddlebrown$|salmon$|sandybrown$|seagreen$|seashell$|sienna$|skyblue$|slateblue$|slategray$|slategrey$|snow$|springgreen$|steelblue$|tan$|thistle$|tomato$|transparent$|turquoise$|violet$|wheat$|white$|yellowgreen$|rebeccapurple$)/i',$colorCode))
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
	$__server->page_embeds->page_title = "WrapperTube - " . htmlspecialchars($_user['custom_header']);
	$__server->page_embeds->page_description = htmlspecialchars($_user['bio']);
	$__server->page_embeds->page_image = "/dynamic/pfp/" . htmlspecialchars($_user['pfp']);
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
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
		<meta property="og:title" content="<?php echo $__server->page_embeds->page_title; ?>" />
		<meta property="og:url" content="<?php echo $__server->page_embeds->page_url; ?>" />
		<meta property="og:description" content="<?php echo $__server->page_embeds->page_description; ?>" />
		<meta property="og:image" content="<?php echo $__server->page_embeds->page_image; ?>" />
        <script src="/static/js/core-js.js"></script>
<link rel="alternate" type="application/atom+xml" title="Videos RSS Feed" href="/feed/channel?n=<?php echo htmlspecialchars($_user['username']); ?>">
		<script src="/s/js/alert.js"></script>
		<script>
			var yt = yt || {};yt.timing = yt.timing || {};yt.timing.tick = function(label, opt_time) {var timer = yt.timing['timer'] || {};if(opt_time) {timer[label] = opt_time;}else {timer[label] = new Date().getTime();}yt.timing['timer'] = timer;};yt.timing.info = function(label, value) {var info_args = yt.timing['info_args'] || {};info_args[label] = value;yt.timing['info_args'] = info_args;};yt.timing.info('e', "904821,919006,922401,920704,912806,913419,913546,913556,919349,919351,925109,919003,920201,912706");if (document.webkitVisibilityState == 'prerender') {document.addEventListener('webkitvisibilitychange', function() {yt.timing.tick('start');}, false);}yt.timing.tick('start');yt.timing.info('li','0');try {yt.timing['srt'] = window.gtbExternal && window.gtbExternal.pageT() ||window.external && window.external.pageT;} catch(e) {}if (window.chrome && window.chrome.csi) {yt.timing['srt'] = Math.floor(window.chrome.csi().pageT);}if (window.msPerformance && window.msPerformance.timing) {yt.timing['srt'] = window.msPerformance.timing.responseStart - window.msPerformance.timing.navigationStart;}    
		</script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="/yt/jsbin/plupload.full.min.js"></script>
        <script src='/static/spectrum/spectrum.js'></script>
        <link rel='stylesheet' href='/static/spectrum/spectrum.css' />
		<link id="www-core-css" rel="stylesheet" href="/yt/cssbin/www-core-vfluMRDnk.css">
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
<style type="text/css">
<?php echo strip_tags($_user['css']); ?>
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
				<?php if(isset($_SESSION['siteusername']) && $_user['username'] == $_SESSION['siteusername']) { ?>
					<div class="channel_customization"><?php require($_SERVER['DOCUMENT_ROOT'] . "/s/mod/channel_customization.php"); ?></div>
				<?php } ?> 
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
                                                <?php if ($_user['banner_image_map'] != "") { echo strip_tags($_user['banner_image_map'], "<map><area>"); } ?>
                                                <?php if ($_user['banner'] != "") { ?><img usemap="#imgmap" class="ytg-wide branded-banner-image" src="/dynamic/banners/<?php echo htmlspecialchars($_user['banner']); ?>" width="970"><?php } ?>
						<div id="branded-page-body-container" class="ytg-base clearfix">
							<div id="branded-page-header-container" class="ytg-wide banner-displayed-mode">
								<div id="branded-page-header" class="ytg-wide">
									<div id="channel-header-main">
										<div class="upper-section clearfix">
											<a href="/user/<?php echo htmlspecialchars($_user['username']); ?>">
											<span class="profile-thumb">
											<span class="centering-wrap">
											<img src="/dynamic/pfp/<?php echo htmlspecialchars($_user['pfp']); ?>" title="<?php echo htmlspecialchars($_user['username']); ?>" alt="<?php echo htmlspecialchars($_user['username']); ?>">
											</span>
											</span>
											</a>
											<div class="upper-left-section ">
												<h1<?php if (isset($banned)) { ?> style="text-decoration:line-through;color:grey;"<?php } ?>><?php echo htmlspecialchars($_user['custom_header']); ?>
                                                                                                <?php if($__user_h->if_admin($_user['username'])) { ?>
                                                                                                        <span style="color:red;"> ## Admin</span>
                                                                                                <?php } ?>
                                                                                                <?php if($__user_h->if_moderator($_user['username'])) { ?>
                                                                                                        <span style="color:red;"> ## Mod</span>
                                                                                                <?php } ?></h1>
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
												<?php if($__user_h->if_partner($_user['username'])) { ?>
													<img style="width: 29px;vertical-align: middle;margin-left: 10px;" title="This user is trusted" src="/yt/imgbin/RenderedImage.png">
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
												<?php if(isset($_SESSION['siteusername']) && $_user['username'] == $_SESSION['siteusername']) { ?>
												<a href="#" onclick="fadechannel()"><button class="yt-uix-button yt-uix-button-default ">Edit Channel</button></a>
												<?php } ?>
												<span class="valign-shim"></span>
											</div>
										</div>
										<div class="channel-horizontal-menu clearfix">
										<ul>
												<li>
													<a href="/user/<?php echo htmlspecialchars($_user['username']); ?>/featured" class="gh-tab-100">
													Featured
													</a>
												</li>
												<li>
													<a href="/user/<?php echo htmlspecialchars($_user['username']); ?>/feed" class="gh-tab-102">
													Feed
													</a>
												</li>
												<li>
													<a href="/user/<?php echo htmlspecialchars($_user['username']); ?>/discussion" class="gh-tab-101">
													Discussion
													</a>
												</li>
												<li class="selected">
													<a href="/user/<?php echo htmlspecialchars($_user['username']); ?>/videos" class="gh-tab-101">
													Videos
													</a>
												</li>
                                                                                                <li>
                                                                                                        <a href="/user/<?php echo htmlspecialchars($_user['username']); ?>/groups" class="gh-tab-101">
                                                                                                        Groups
                                                                                                        </a>
                                                                                                </li>
                                                                                                <?php if (!empty($_user['real_custom_header'])) { ?>
                                                                                                <li>
                                                                                                        <a href="/user/<?php echo htmlspecialchars($_user['username']); ?>/custom" class="gh-tab-101">
                                                                                                        <?php echo $_user['real_custom_header']; ?>
                                                                                                        </a>
                                                                                                </li>
                                                                                                <?php } ?>
											</ul>
											<form id="channel-search" action="/user/<?php echo htmlspecialchars($_user['username']); ?>/videos">
												<input name="query" type="text" maxlength="100" class="search-field" placeholder="Search Channel">
												<button class="search-btn" type="submit">
												<span class="search-btn-content">
												Search
												</span>
												</button>
												<a class="search-dismiss-btn" href="/user/<?php echo htmlspecialchars($_user['username']); ?>/videos?view=0">
												<span class="search-btn-content">
												Clear
												</span>
												</a>
											</form>
										</div>
									</div>
								</div>
							</div>
                            <?php if($_user['featured'] != "None") { $video = $__video_h->fetch_video_rid($_user['featured']); } else { $_user['featured'] = false; } ?>
							<div id="branded-page-body">
                                <div class="channel-tab-content channel-layout-full-width">
                                    <div class="tab-content-body">
                                        <div class="channel-filtered-page">
                                            <div class="channel-filtered-page-head">
                                                <h1 class="channel-section-heading">
                                                    Favourite Videos
                                                    <span class="item-count">(<?php
$stmt6 = $__db->prepare("SELECT count(*) FROM favorite_video WHERE sender = :username");
$stmt6->bindParam(":username", $_user['username']);
   $stmt6->execute();
   $number_of_result = (int)$stmt6->fetchColumn();
   $stmt6 = null;

 echo $number_of_result;
 ?>)</span>
                                                </h1>
                                                <div class="yt-horizontal-rule "><span class="first"></span><span class="second"></span><span class="third"></span></div>
                                            </div>
                                            <div class="left-pane">
                                                <ul class="primary-filter-menu">
                                                    <li>
                                                        <a class="filter-option" href="videos">
                                                        Uploaded Videos
                                                        </a>
                                                    </li>

							<li>
                                                        <a class="filter-option selected-filter" href="favorites">
                                                        Favourite Videos
                                                        </a>
                                                    </li>

													
														<li>
															<a class="filter-option " href="playlists">
															Playlists
															</a>
														</li>
													
                                                </ul>
                                            </div>
                                            <div class="channel-filtered-content">
                                                <ol class="channel-videos-list">
													<?php

$results_per_page = 24;
   $number_of_page = ceil ($number_of_result / $results_per_page);  
if (!isset ($_GET['page']) ) {  
       $page = 1;  
   } else {  
       $page = (int)$_GET['page'];  
   }  

$page_first_result = ($page - 1) * $results_per_page;  


														$stmt = $__db->prepare("SELECT * FROM favorite_video WHERE sender = :username ORDER BY id DESC LIMIT :pfirst, :pper");
														$stmt->bindParam(":username", $_user['username']);
   $stmt->bindParam(":pfirst", $page_first_result);
   $stmt->bindParam(":pper", $results_per_page);
														$stmt->execute();
														if($stmt->rowCount() == 0) { echo '<span style="font-size:11px;color:grey;">This user has no favourite videos.</span>'; }

														while($video = $stmt->fetch(PDO::FETCH_ASSOC)) {	
if ($__video_h->video_exists($video['reciever'])) {
$video = $__video_h->fetch_video_rid($video['reciever']);
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
													?>
                                                    <li class="yt-c3-grid-item">
                                                        <a href="/watch?v=<?php echo htmlspecialchars($video['rid']); ?>" class="ux-thumb-wrap yt-uix-sessionlink yt-uix-contextlink contains-addto " data-sessionlink="feature=plcp&amp;context=C4e80d7cVDvjVQa1PpcFPHxNkhfeSQg8_nJHnhVurQf82C2OenNiw%3D"><span class="video-thumb ux-thumb yt-thumb-default-234 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" alt="Thumbnail" onerror="this.onerror=null;this.src='/dynamic/thumbs/default.jpg';" width="234"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $video['duration']; ?></span>
                                                        <button onclick=";return false;" title="Watch Later" type="button" class="addto-button video-actions spf-nolink addto-watch-later-button yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" data-video-ids="<?php echo $video['rid']; ?>" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
                                                        </span><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></button>
                                                        </a>
                                                        <h3 class="yt-c3-grid-item-title">
                                                            <a href="/watch?v=<?php echo htmlspecialchars($video['rid']); ?>" class="yt-uix-sessionlink yt-uix-contextlink" data-sessionlink="context=C4e80d7cVDvjVQa1PpcFPHxNkhfeSQg8_nJHnhVurQf82C2OenNiw%3D" title="<?php echo htmlspecialchars($video['title']); ?>" dir="ltr">
                                                            <?php echo htmlspecialchars($video['title']); ?>
                                                            </a>
                                                        </h3>
                                                        <span class="yt-c3-grid-item-viewcount">
                                                        <?php echo $__video_h->fetch_video_views($video['rid']); ?> views
                                                        </span>
                                                        <span class="yt-c3-grid-item-created">
                                                        <?php echo $__time_h->time_elapsed_string($video['publish']); ?>
                                                        </span>
                                                        <span class="yt-c3-grid-item-created" style="white-space:nowrap;">
                                                        <img src="/static/img/<?php echo ($video['star_ratio']>=1)?'full':(($video['star_ratio']>=0.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($video['star_ratio']>=2)?'full':(($video['star_ratio']>=1.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($video['star_ratio']>=3)?'full':(($video['star_ratio']>=2.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($video['star_ratio']>=4)?'full':(($video['star_ratio']>=3.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($video['star_ratio']>=5)?'full':(($video['star_ratio']>=4.5)?'half':'empty'); ?>_star_s.png">
                                                        </span>
                                                        <span class="yt-c3-grid-item-created">
                                                        <?php echo $video['stars']; ?> ratings
                                                        </span>
                                                    </li>
													<?php } } $stmt = null; ?>
                                                </ol>
                                                <div class="yt-uix-pager" role="navigation">
                  <?php
                                                                                                                if (!isset ($_GET['page']) ) {
                                                                                                                        $curpage = 1;
                                                                                                                } else {
                                                                                                                        $curpage = (int)$_GET['page'];
                                                                                                                }
?>
<?php if ($curpage > 1) { ?>
<a href="favorites?page=<?php echo $curpage - 1; ?>"><button class="yt-uix-button yt-uix-button-default">« Prev</button></a>
<?php } ?>
<?php for($page = 1; $page<= $number_of_page; $page++) { ?>
<a href="favorites?page=<?php echo $page; ?>"><button class="yt-uix-button yt-uix-button-default <?php if($curpage==$page){ ?>yt-uix-button-toggled<?php } ?>"><?php echo $page; ?></button></a>
                  <?php } ?>
<?php if ($curpage < $number_of_page) { ?>
<a href="favorites?page=<?php echo $curpage + 1; ?>"><button class="yt-uix-button yt-uix-button-default">Next »</button></a>
<?php } ?>
                                                </div>
                                            </div>
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
