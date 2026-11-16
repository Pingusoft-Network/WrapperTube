<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_update.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_insert.php"); ?>
<?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__user_i = new user_insert($__db); ?>
<?php $__user_u = new user_update($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php if(!$__video_h->video_exists($_GET['v'])) { header("Location: /?error=This video doesn't exist!"); die(); } ?>
<?php $_video = $__video_h->fetch_video_rid($_GET['v']); ?>
<?php $_video['comments'] = $__video_h->get_comments_from_video($_video['rid']); ?>
<?php
	if($_video['visibility'] == "v" && @$_SESSION['siteusername'] != $_video['author'] && (!$__user_h->if_moderator(@$_SESSION['siteusername']) && !$__user_h->if_admin(@$_SESSION['siteusername'])))
		die(header("Location: /?error=This video is private!"));

	$__video_h->check_view($_GET['v'], @$_SERVER["HTTP_CF_CONNECTING_IP"]);

        if(isset($_SESSION['siteusername'])) {
        if(!isset($_SESSION['adminlogin'])) {
            $__user_i->add_to_history($_GET['v'], @$_SESSION['siteusername']);
        }
        }

$_user = $__user_h->fetch_user_username($_video['author']);

    $stmt = $__db->prepare("SELECT * FROM bans WHERE username = :username LIMIT 1");
        $stmt->bindParam(":username", $_user['username']);
        $stmt->execute();

        while($ban = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $banned = $ban['reason'];
        }
        $stmt = null;

	/* 
	PREPARE EMBEDS CLASS -- function(string $page_title, string $page_description...) 
	Returns a list of arrays for compatibility purposes & but downside is ugly for loop codes 
	Work on this tomorrow or some crap idk lol
	*/

	/* 
	USE THE GOD DAMN __CONFIG MORE -- idiot
	Work on this tomorrow or some crap
	*/

	$video_tags = explode(",", $_video['tags']);

	$__server->page_embeds->page_title = htmlspecialchars($_video['title']) . " - WrapperTube";
	$__server->page_embeds->page_description = htmlspecialchars($_video['description']);
	$__server->page_embeds->page_image = "/dynamic/thumbs/" . $_video['thumbnail'];
	$__server->page_embeds->page_url = "http://wrappertube.org/watch?v=" . htmlspecialchars($_video['rid']);
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
<meta name="keywords" content="<?php echo htmlspecialchars($_video['tags']); ?>"/>
<meta name="theme-color" content="red">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <script src="/static/js/core-js.js"></script>
      <script>
         var yt = yt || {};yt.timing = yt.timing || {};yt.timing.tick = function(label, opt_time) {var timer = yt.timing['timer'] || {};if(opt_time) {timer[label] = opt_time;}else {timer[label] = new Date().getTime();}yt.timing['timer'] = timer;};yt.timing.info = function(label, value) {var info_args = yt.timing['info_args'] || {};info_args[label] = value;yt.timing['info_args'] = info_args;};yt.timing.info('e', "907722,906062,910102,927104,922401,920704,912806,927201,913546,913556,925109,919003,920201,912706,900816");yt.timing.wff = true;yt.timing.info('an', "");if (document.webkitVisibilityState == 'prerender') {document.addEventListener('webkitvisibilitychange', function() {yt.timing.tick('start');}, false);}yt.timing.tick('start');yt.timing.info('li','0');try {yt.timing['srt'] = window.gtbExternal && window.gtbExternal.pageT() ||window.external && window.external.pageT;} catch(e) {}if (window.chrome && window.chrome.csi) {yt.timing['srt'] = Math.floor(window.chrome.csi().pageT);}if (window.msPerformance && window.msPerformance.timing) {yt.timing['srt'] = window.msPerformance.timing.responseStart - window.msPerformance.timing.navigationStart;}    
      </script>
      <script>var yt = yt || {};yt.preload = {};yt.preload.counter_ = 0;yt.preload.start = function(src) {var img = new Image();var counter = ++yt.preload.counter_;yt.preload[counter] = img;img.onload = img.onerror = function () {delete yt.preload[counter];};img.src = src;img = null;};yt.preload.start("\/\/o-o---preferred---sn-o097zne7---v18---lscache1.c.youtube.com\/crossdomain.xml");yt.preload.start("\/\/o-o---preferred---sn-o097zne7---v18---lscache1.c.youtube.com\/generate_204?ip=207.241.237.166\u0026upn=sWh0pzcodo0\u0026sparams=algorithm%2Cburst%2Ccp%2Cfactor%2Cgcr%2Cid%2Cip%2Cipbits%2Citag%2Csource%2Cupn%2Cexpire\u0026fexp=907722%2C906062%2C910102%2C927104%2C922401%2C920704%2C912806%2C927201%2C913546%2C913556%2C925109%2C919003%2C920201%2C912706%2C900816\u0026mt=1349916311\u0026key=yt1\u0026algorithm=throttle-factor\u0026burst=40\u0026ipbits=8\u0026itag=34\u0026sver=3\u0026signature=C397DCB00566E0FBB1551675B6108A4158C34557.CB3777882F05D65158C043C258FF8D4EBA90FA50\u0026mv=m\u0026source=youtube\u0026ms=au\u0026gcr=us\u0026expire=1349937946\u0026factor=1.25\u0026cp=U0hTTllOVV9JUENOM19RSFlKOmVLUWdkTXRmS0dX\u0026id=a078394896111c0d");</script>
<meta name="author" content="<?php echo htmlspecialchars($_video['author']); ?>">
      <meta property="og:title" content="<?php echo $__server->page_embeds->page_title; ?>" />
		<meta property="og:url" content="<?php echo $__server->page_embeds->page_url; ?>" />
		<meta property="og:description" content="<?php echo $__server->page_embeds->page_description; ?>" />
		<meta property="og:image" content="http://wrappertube.org<?php echo $__server->page_embeds->page_image; ?>" />
    <meta itemprop="datePublished" content="<?php echo date("c", strtotime($_video['publish'])); ?>">
    <meta property="og:type" content="video.other">
    <meta property="og:video:url" content="http://wrappertube.org/embed/<?php echo $_video['rid']; ?>">
    <meta property="og:video:secure_url" content="https://wrappertube.org/embed/<?php echo $_video['rid']; ?>">
    <meta property="og:video:type" content="text/html">
    <meta property="og:video:width" content="640">
    <meta property="og:video:height" content="360">
    <meta property="og:video:duration" content="<?php echo $_video['duration']; ?>">
    <meta property="og:video:release_date" content="<?php echo date("c", strtotime($_video['publish'])); ?>">
    <meta property="og:video:director" content="<?php echo htmlspecialchars($_video['author']); ?>">
    <?php
    foreach ($video_tags as $video_tag) {
    if (!empty(trim($video_tag))) {
    ?>
    <meta property="og:video:tag" content="<?php echo htmlspecialchars(trim($video_tag)); ?>">
    <?php
    }
    }
    ?>

    <meta name="twitter:card" content="player" />
    <meta name="twitter:title" content="<?php echo $__server->page_embeds->page_title; ?>" />
    <meta name="twitter:site" content="@WrapperTube" />
    <meta name="twitter:url" content="<?php echo $__server->page_embeds->page_url; ?>">
    <meta name="twitter:description" content="<?php echo $__server->page_embeds->page_description; ?>" />
    <meta name="twitter:player" content="http://wrappertube.org/embed/<?php echo $_video['rid']; ?>" />
    <meta name="twitter:player:width" content="640" />
    <meta name="twitter:player:height" content="360" />
    <meta name="twitter:image" content="http://wrappertube.org<?php echo $__server->page_embeds->page_image; ?>" />

<link rel="alternate" type="application/atom+xml" title="Videos RSS Feed" href="/feed/channel?n=<?php echo htmlspecialchars($_video['author']); ?>">

<script type="text/javascript">
function detectFlash(){
  // ie
  try {
    try {
      // avoid fp6 minor version lookup issues
      // see: http://blog.deconcept.com/2006/01/11/getvariable-setvariable-crash-internet-explorer-flash-6/
      var axo = new ActiveXObject('ShockwaveFlash.ShockwaveFlash.6');
      try { axo.AllowScriptAccess = 'always'; }
      catch(e) { return '6,0,0'; }
    } catch(e) {}
    return new ActiveXObject('ShockwaveFlash.ShockwaveFlash').GetVariable('$version').replace(/\D+/g, ',').match(/^,?(.+),?$/)[1];
  // other browsers
  } catch(e) {
    try {
      if(navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin){
        return (navigator.plugins["Shockwave Flash 2.0"] || navigator.plugins["Shockwave Flash"]).description.replace(/\D+/g, ",").match(/^,?(.+),?$/)[1];
      }
    } catch(e) {}
  }
  return false;
}

function detectRuffle(){
  if ("ActiveXObject" in window) { // check if activex is supported (in other words, check if the browser is IE), if so, return false.
    return false;
  }
  if(navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin){
    return (navigator.plugins["Shockwave Flash 2.0"] || navigator.plugins["Shockwave Flash"]).filename === 'ruffle.js'; // returns true when using ruffle.
  }
  return false;
}
</script>

<?php if ($_video['visibility'] != "n") { ?>
<meta name="robots" content="noindex, nofollow, noarchive">
<?php } ?>
<?php if (endsWith($_video['filename'],".swf") || endsWith($_video['filename'],".scratch") || endsWith($_video['filename'],".sb") || endsWith($_video['filename'],".sb2")) { ?>
		<script src="/static/ruffle/ruffle.js"></script>
<?php } ?>
<?php if (endsWith($_video['filename'],".dcr")) { ?>
                <script src="/static/dirplayer/dirplayer-polyfill.js"></script>
<?php } ?>
                <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
                <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
                <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
      <meta name=attribution content=youtube_multi/>
      <link id="www-core-css" rel="stylesheet" href="/yt/cssbin/www-core-vfluMRDnk.css">
      <script src="/s/js/alert.js"></script>
	  <script>
         var gYouTubePlayerReady = false;
         if (!window['onYouTubePlayerReady']) {
           window['onYouTubePlayerReady'] = function() {
             gYouTubePlayerReady = true;
           };
         }
      </script>
      <script>
         if (window.yt.timing) {yt.timing.tick("ct");}    
      </script>
<style type="text/css">
  .collapsible {
  color:#000;
  text-decoration:none;
  width:100%;
  border:none !important;
  text-align:left;
  outline:none !important;
  margin:0;
  padding:0;
  cursor:pointer;
  font:700 16px Arial;
  }
  .video-extras-likes-dislikes .dislikes,.collapsible:hover,.grey-text,td.tdstyle {
  color:#666;
  }
  .collapsible.active-dropdown img,.collapsible:nth-child(3) img,.watch-main-info #arrow_more {
  background-position:0 -343px;
  }
  
  .watch-main-info .collapsible.active-dropdown #arrow_more {
  background-position:0 -323px;
  }
  .active-dropdown:nth-child(3) img {
  background-position: 0 -323px !important;
  }
  .www-right-arrow {
  background:transparent url(/static/img/spritesheet_main.png) repeat-x scroll 0 0;
  background-position:0 -323px;
  height:0;
  width:0;
  padding-left:16px;
  padding-top:16px;
  vertical-align:top;
  }
  .collapsible.active-dropdown img,.collapsible:nth-child(3) img,.watch-main-info #arrow_more {
  background-position:0 -343px;
  }
  
  .watch-main-info .collapsible.active-dropdown #arrow_more {
  background-position:0 -323px;
  }
  .watch-sidebar-body {
  display:none;
  overflow:hidden;
  }
.share-service-button .share-service-icon {
background-image:url(/yt/imgbin/www-sharing-vflIBlxAE.png);
background-repeat:no-repeat;
width:32px;
height:32px;
vertical-align:middle;
}
.captcha {
display: none;
}
.has-focus .captcha {
display: inline-block;
}
.kaomoji {
display: none;
}
.has-focus .kaomoji {
display: inline-block;
}
#player-size-buttons {
float:right;
margin-right:330px;
}
.watch-wide #player-size-buttons {
margin-right:0px;
}
.master-sprite {
width: 27px;
height: 22px;
border: none !important;
cursor: pointer;
background-image: url('/static/img/master-vfl136487.png');
background-repeat: no-repeat;
padding: 0;
transition: opacity 0.2s ease;
outline: none !important;
-webkit-tap-highlight-color: transparent;
background-color: transparent;
}
#watch-longform-popup {
width: 27px;
height: 22px;
background-position: 0 -658px;
}
#watch-longform-popup:hover {
    background-position: -27px -658px;
}
#watch-longform-player {
    width: 27px;
    height: 22px;
	background-position: 0 -614px;
}

#watch-longform-player:hover {
    background-position: -27px -614px;
}

.watch-wide #watch-longform-player {
    background-position: 0 -636px;
}
.watch-wide #watch-longform-player:hover {
    background-position: -27px -636px;
}
</style>
<script type="text/javascript">
// preload star icons
(new Image()).src = "/static/img/full_star.png";
(new Image()).src = "/static/img/half_star.png";
(new Image()).src = "/static/img/empty_star.png";
</script>
		<?php
			$_video['dislikes'] =  $__video_h->get_video_stars_level($_video['rid'], 1);
			$_video['dislikes'] += $__video_h->get_video_stars_level($_video['rid'], 2);

			$_video['likes'] =     $__video_h->get_video_stars_level($_video['rid'], 4);
			$_video['likes'] +=    $__video_h->get_video_stars_level($_video['rid'], 5);

			$_video['dislikes'] += $__video_h->get_video_likes($_video['rid'], false);
			$_video['likes'] += $__video_h->get_video_likes($_video['rid'], true);

			if($_video['likes'] == 0 && $_video['dislikes'] == 0) {
				$_video['likeswidth'] = 0;
				$_video['dislikeswidth'] = 0;
			} else {
				$_video['likeswidth'] = $_video['likes'] / ($_video['likes'] + $_video['dislikes']) * 100;
				$_video['dislikeswidth'] = 100 - $_video['likeswidth'];
			}

    $_video['stars'] = $__video_h->get_video_stars($_GET['v']) + $__video_h->get_video_likes($_video['rid'], true) + $__video_h->get_video_likes($_video['rid'], false);
    $_video['star_1'] = $__video_h->get_video_stars_level($_GET['v'], 1) + $__video_h->get_video_likes($_video['rid'], false);
    $_video['star_2'] = $__video_h->get_video_stars_level($_GET['v'], 2);
    $_video['star_3'] = $__video_h->get_video_stars_level($_GET['v'], 3);
    $_video['star_4'] = $__video_h->get_video_stars_level($_GET['v'], 4);
    $_video['star_5'] = $__video_h->get_video_stars_level($_GET['v'], 5) + $__video_h->get_video_likes($_video['rid'], true);

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
    };

			$_video['liked'] = $__video_h->fetch_user_rating($_video['rid'], $_SESSION['siteusername'])==4 || $__video_h->fetch_user_rating($_video['rid'], $_SESSION['siteusername'])==5 || $__video_h->if_liked(@$_SESSION['siteusername'], $_video['rid'], true);
			$_video['disliked'] = $__video_h->fetch_user_rating($_video['rid'], $_SESSION['siteusername'])==1 || $__video_h->fetch_user_rating($_video['rid'], $_SESSION['siteusername'])==2 || $__video_h->if_liked(@$_SESSION['siteusername'], $_video['rid'], false);
			$_video['my_rating'] = $__video_h->fetch_user_rating($_video['rid'], $_SESSION['siteusername'])?$__video_h->fetch_user_rating($_video['rid'], $_SESSION['siteusername']):($_video['liked']?5:($_video['disliked']?1:0));
			$_video['author_videos'] = $__video_h->fetch_user_videos($_video['author']);
			$_video['subscribed'] = $__user_h->if_subscribed(@$_SESSION['siteusername'], $_video['author']);
			$_video['favorited'] = $__video_h->if_favorited(@$_SESSION['siteusername'], $_video['rid']);
		?>
<link rel="stylesheet" href="/static/css/bbcode.css?v2">
	</head>
	<body id="" class="date-20120927 en_US ltr   ytg-old-clearfix guide-feed-v2 gecko gecko-15" dir="ltr">
		<form name="logoutForm" method="POST" action="/logout">
			<input type="hidden" name="action_logout" value="1">
		</form>
		<!-- begin page -->
		<div id="page" class="  watch  ">
			<div id="masthead-container"><?php require($_SERVER['DOCUMENT_ROOT'] . "/s/mod/header.php") ?></div>
			<div id="content-container">
				<!-- begin content -->
				<div id="content">
					<div id="watch-container" itemscope="" itemtype="//schema.org/VideoObject">
						<!-- begin watch-headline-container -->
						<div id="watch-headline-container">
							<div id="watch-headline" class="watch-headline">
								<?php if(@$_SESSION['siteusername'] == $_video['author']) { ?>
									<div id="watch-owner-container">
										<div id="masthead-subnav" class="yt-nav yt-nav-dark ">
											<ul class="yt-nav-aside">
												<li>
													<a href="/my_videos" class="yt-uix-button yt-uix-sessionlink yt-uix-button-subnav  yt-uix-button-dark" data-sessionlink="ei=CMCA1_3robMCFSrJRAodqnnxKQ%3D%3D"><span class="yt-uix-button-content">Video Manager</span></a>
												</li>
											</ul>
											<ul>
												<li>
													<a href="/edit_video?id=<?php echo $_video['rid']; ?>" class="yt-uix-button yt-uix-sessionlink yt-uix-button-subnav yt-uix-button-dark" data-sessionlink="ei=CMCA1_3robMCFSrJRAodqnnxKQ%3D%3D"><span class="yt-uix-button-content">Edit</span></a>
												</li>
												<li>
													<a href="/get/delete_video?id=<?php echo $_video['rid']; ?>" onclick="return confirm('Are you sure you want to delete this video?');" class="yt-uix-button yt-uix-sessionlink yt-uix-button-subnav  yt-uix-button-dark" data-sessionlink="ei=CMCA1_3robMCFSrJRAodqnnxKQ%3D%3D"><span class="yt-uix-button-content">Delete Video</span></a>
												</li>
												<li>
													<a href="/get/toggle_comment?id=<?php echo $_video['rid']; ?>" class="yt-uix-button yt-uix-sessionlink yt-uix-button-subnav  yt-uix-button-dark" data-sessionlink="ei=CMCA1_3robMCFSrJRAodqnnxKQ%3D%3D"><span class="yt-uix-button-content">Toggle Commenting</span></a>
												</li>
											</ul>
										</div>
									</div><br>
								<?php } ?>
								<?php if($__user_h->if_admin(@$_SESSION['siteusername'])) { ?>
									<div id="watch-owner-container">
										<div id="masthead-subnav" class="yt-nav yt-nav-dark ">
											<ul>
												<li>
													<a href="/funny_casablanka/delete_video_admin?v=<?php echo $_video['rid']; ?>" onclick="return confirm('Are you sure you want to delete this video?');" class="yt-uix-button yt-uix-sessionlink yt-uix-button-subnav  yt-uix-button-dark" data-sessionlink="ei=CMCA1_3robMCFSrJRAodqnnxKQ%3D%3D"><span class="yt-uix-button-content">Delete Video</span></a>
												</li>
												<li>
													<a href="/funny_casablanka/<?php echo($_video['featured']=='v')?'un':''; ?>feature_video?v=<?php echo $_video['rid']; ?>" class="yt-uix-button yt-uix-sessionlink yt-uix-button-subnav  yt-uix-button-dark" data-sessionlink="ei=CMCA1_3robMCFSrJRAodqnnxKQ%3D%3D"><span class="yt-uix-button-content"><?php echo($_video['featured']=='v')?'Unf':'F'; ?>eature Video</span></a>
												</li>
											</ul>
										</div>
									</div><br>

									<?php
										$stmt = $__db->prepare("SELECT ip, username FROM users WHERE ip = :ip");
										$stmt->bindParam(":ip", $_user['ip']);
										$stmt->execute();
										$alts = $stmt->rowCount();

										if($alts != 0) { echo "<span style='font-size:11px;color:grey;'>Alts will pop up below here by IP...</span><br>"; }

										while($username = $stmt->fetch(PDO::FETCH_ASSOC)) { 
											if($username['username'] != $_video['author'] && $username['ip'] != "0.0.0.0")
												echo "
												  <a style='font-size:10px;' href='/user/" .  htmlspecialchars($username['username']) . "'>" . 
													htmlspecialchars($username['username']) 
												. "</a><br>";
										}
										$stmt = null;
									?>

                                                                        <?php
                                                                                $stmt = $__db->prepare("SELECT ip, username FROM users WHERE email = :email");
                                                                                $stmt->bindParam(":email", $_user['email']);
                                                                                $stmt->execute();
                                                                                $alts = $stmt->rowCount();

                                                                                if($alts != 0) { echo "<span style='font-size:11px;color:grey;'>Alts will pop up below here by E-Mail address...</span><br>"; }

                                                                                while($username = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                                        if($username['username'] != $_video['author'])
                                                                                                echo "
                                                                                                  <a style='font-size:10px;' href='/user/" .  htmlspecialchars($username['username']) . "'>" .
                                                                                                        htmlspecialchars($username['username'])
                                                                                                . "</a><br>";
                                                                                }
                                                                                $stmt = null;
                                                                        ?>
									<hr>
								<?php } ?>
								<?php if($__user_h->if_moderator(@$_SESSION['siteusername'])) { ?>
									<div id="watch-owner-container">
										<div id="masthead-subnav" class="yt-nav yt-nav-dark ">
											<ul>
												<li>
													<a href="/vivat_shuravi/delete_video_admin?v=<?php echo $_video['rid']; ?>" onclick="return confirm('Are you sure you want to delete this video?');" class="yt-uix-button yt-uix-sessionlink yt-uix-button-subnav  yt-uix-button-dark" data-sessionlink="ei=CMCA1_3robMCFSrJRAodqnnxKQ%3D%3D"><span class="yt-uix-button-content">Delete Video</span></a>
												</li>
												<li>
													<a href="/vivat_shuravi/<?php echo($_video['featured']=='v')?'un':''; ?>feature_video?v=<?php echo $_video['rid']; ?>" class="yt-uix-button yt-uix-sessionlink yt-uix-button-subnav  yt-uix-button-dark" data-sessionlink="ei=CMCA1_3robMCFSrJRAodqnnxKQ%3D%3D"><span class="yt-uix-button-content"><?php echo($_video['featured']=='v')?'Unf':'F'; ?>eature Video</span></a>
												</li>
											</ul>
										</div>
									</div><br>

									<?php
										$stmt = $__db->prepare("SELECT ip, username FROM users WHERE ip = :ip");
										$stmt->bindParam(":ip", $_user['ip']);
										$stmt->execute();
										$alts = $stmt->rowCount();

										if($alts != 0) { echo "<span style='font-size:11px;color:grey;'>Alts will pop up below here by IP...</span><br>"; }

										while($username = $stmt->fetch(PDO::FETCH_ASSOC)) { 
											if($username['username'] != $_video['author'] && $username['ip'] != "0.0.0.0")
												echo "
												  <a style='font-size:10px;' href='/user/" .  htmlspecialchars($username['username']) . "'>" . 
													htmlspecialchars($username['username']) 
												. "</a><br>";
										}
										$stmt = null;
									?>

                                                                        <?php
                                                                                $stmt = $__db->prepare("SELECT ip, username FROM users WHERE email = :email");
                                                                                $stmt->bindParam(":email", $_user['email']);
                                                                                $stmt->execute();
                                                                                $alts = $stmt->rowCount();

                                                                                if($alts != 0) { echo "<span style='font-size:11px;color:grey;'>Alts will pop up below here by E-Mail address...</span><br>"; }

                                                                                while($username = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                                        if($username['username'] != $_video['author'])
                                                                                                echo "
                                                                                                  <a style='font-size:10px;' href='/user/" .  htmlspecialchars($username['username']) . "'>" .
                                                                                                        htmlspecialchars($username['username'])
                                                                                                . "</a><br>";
                                                                                }
                                                                                $stmt = null;
                                                                        ?>
									<hr>
								<?php } ?>
								<div id="player-size-buttons">
									<button id="watch-longform-player" class="master-sprite yt-uix-tooltip" onclick="toggleLarge(); return false" title="Change Player Size" style="margin-right:2px;"></button> <button id="watch-longform-popup" class="master-sprite yt-uix-tooltip" onclick="window.open('/embed/<?php echo $_video['rid']; ?>?autoplay=1','aaa','height=505,width=640'); this.blur(); return false;" title="Watch this video in a new window"></button>
								</div>
								<h1 id="watch-headline-title" style="white-space: nowrap;text-overflow: ellipsis;">
									<span id="eow-title" class="long-title " dir="ltr" title="<?php echo htmlspecialchars($_video['title']); ?>">
									<?php echo htmlspecialchars($_video['title']); ?>
									</span>
								</h1>
								<div id="watch-headline-user-info">
<?php if ( $__user_h->fetch_user_username($_video['author'])['subbutton'] != '' ) { ?>
<a id="watch-userbanner" rel="author" href="/user/<?php echo htmlspecialchars($_video['author']); ?>" title="<?php echo htmlspecialchars($_video['author']); ?>"><strong><img src="/dynamic/subscribe/<?php echo $__user_h->fetch_user_username($_video['author'])['subbutton']; ?>" alt="<?php echo htmlspecialchars($_video['author']); ?>" height="25"></strong></a>
<?php } else { ?>
									<button style="margin-right: -5px;" href="/user/<?php echo htmlspecialchars($_video['author']); ?>" type="button" class="start yt-uix-button yt-uix-button-default" onclick=";window.location.href=this.getAttribute('href');return false;" role="button">
										<span class="yt-uix-button-content"<?php if(isset($banned)) { ?> style="text-decoration:line-through;color:grey;"<?php } ?>><?php echo htmlspecialchars($_video['author']); ?></span>
									</button>
<?php } ?>
									<div class="yt-subscription-button-hovercard yt-uix-hovercard">
										<span class="yt-uix-button-context-light yt-uix-button-subscription-container">
										<button 
											onclick=";subscribe();return false;" 
											title="" 
											id="subscribe-button"
											type="button" 
											class="<?php if($_video['subscribed']) { echo "subscribed "; } ?>yt-subscription-button  yt-uix-button yt-uix-button-subscription yt-uix-tooltip" 
											role="button">
											<span class="yt-uix-button-icon-wrapper">
												<img class="yt-uix-button-icon yt-uix-button-icon-subscribe" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
												<span class="yt-valign-trick"></span>
											</span>
											<span class="yt-uix-button-content">
												<span class="subscribe-label">Subscribe</span>
												<span class="subscribed-label">Subscribed</span>
												<span class="unsubscribe-label">Unsubscribe</span>
											</span>
										</button>
										<span class="yt-subscription-button-disabled-mask"></span></span>
										<div class="yt-uix-hovercard-content hid">
											<p class="loading-spinner">
												<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
												Loading...
											</p>
										</div>
									</div>
									<button onclick="_toggleclass(this,'yt-uix-expander-collapsed');return false;" type="button" id="watch-mfu-button" class="yt-uix-expander-collapsed yt-uix-button yt-uix-button-default" data-button-toggle="true" data-video-user-id="<?php echo htmlspecialchars($_video['author']); ?>" data-button-menu-id="some-nonexistent-menu" data-video-id="<?php echo htmlspecialchars($_video['rid']); ?>" data-button-action="yt.www.watch.watch5.handleToggleMoreFromUser" role="button"><span class="yt-uix-button-content"><?php echo $_video['author_videos']; ?> videos </span><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></button>
								</div>
								<div id="watch-more-from-user" class="collapsed">
									<div id="watch-channel-discoverbox" class="yt-rounded">
										<p class="yt-spinner">
											<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="yt-spinner-img" alt="">
											Loading...
										</p>
									</div>
								</div>
							</div>
						</div>
						<!-- end watch-headline-container -->
						<div id="watch-video-container">
							<div id="watch-video" >
          <script>
if (window.yt.timing) {yt.timing.tick("bf");}    </script>

<?php if ( !endsWith($_video['filename'],".mp4") ) {
if (endsWith($_video['filename'],".jpg") || endsWith($_video['filename'],".png") || endsWith($_video['filename'],".jpeg") || endsWith($_video['filename'],".jpe") || endsWith($_video['filename'],".gif") || endsWith($_video['filename'],".bmp") || endsWith($_video['filename'],".svg")) {  ?>
<div id="watch-player" class="flash-player" style="height:auto;background-color:transparent;">
<img id="theimg" class="img-upload" onclick="$('.imageModal').dialog('open');" style="max-width: 100%; cursor: zoom-in;" src="/dynamic/videos/<?php echo($_video['filename']); ?>" alt="<?php echo(htmlspecialchars($_video['title'])); ?>"><br>
<a href="#" onclick="launchFullscreen(document.getElementById('theimg'));return false;">Full Screen</a>
</div>
<div class="imageModal" style="display:none;margin:0;">
<img id="bigimg" style="
    display: block;
    text-align: center;
    position: absolute;
    right: 0;
    left: 0;
    top: 0;
    bottom: 0;
    margin-top: auto;
    margin-bottom: auto;
    margin-left: auto;
    margin-right: auto;
    cursor: zoom-in;
    " src="/dynamic/videos/<?php echo($_video['filename']); ?>" alt="<?php echo(htmlspecialchars($_video['title'])); ?>" onclick="toggleImgSize();">
</div>
<?php } elseif (endsWith($_video['filename'],".txt") || endsWith($_video['filename'],".htm") || endsWith($_video['filename'],".html")) { ?>
<div id="watch-player" class="flash-player" style="background-color:transparent;">
<iframe id="htmlcontainer" style="background-color:white;" frameborder="0" width="100%" height="95%" src="/dynamic/videos/<?php echo($_video['filename']); ?>" allowfullscreen="true"></iframe>
<a href="#" onclick="launchFullscreen(document.getElementById('htmlcontainer'));return false;">Full Screen</a> | <a href="/dynamic/videos/<?php echo($_video['filename']); ?>" target="_blank">Open in Browser</a> 
</div>
<?php } elseif (endsWith($_video['filename'],".pdf")) { ?>
<div id="watch-player" class="flash-player" style="background-color:transparent;">
<embed id="pdfc" src="/dynamic/videos/<?php echo($_video['filename']); ?>" width="100%" height="95%" style="width:100%!important;height:95%!important;" type="application/pdf"></embed>
<a href="#" onclick="launchFullscreen(document.getElementById('pdfc'));return false;">Full Screen</a> 
</div>
<?php } elseif (endsWith($_video['filename'],".swf")) { ?>
<div id="watch-player" class="flash-player" style="background-color:transparent;">
<div id="flashmovie" style="width:100%!important;height:95%!important;background-color:white!important;">
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="100%" height="100%" id="flashapplet">
        <param name="movie" value="/dynamic/videos/<?php echo($_video['filename']); ?>" />
        <param name="quality" value="best" />
        <param name="allowScriptAccess" value="always" />
        <param name="allowFullScreen" value="true" />
        <param name="swLiveConnect" value="true" />
        <param name="bgcolor" value="white" />
        <embed src="/dynamic/videos/<?php echo($_video['filename']); ?>" width="100%" height="100%" type="application/x-shockwave-flash" name="flashapplet" quality="best" allowScriptAccess="always" allowFullScreen="true" swLiveConnect="true" bgcolor="white" pluginspage="http://www.macromedia.com/go/getflashplayer/" />
      </object>
</div>
<a href="#" onclick="launchFullscreen(document.getElementById('flashmovie'));return false;">Full Screen</a>
</div>
<?php } elseif (endsWith($_video['filename'],".dcr")) { ?>
<div id="watch-player" class="flash-player" style="background-color:transparent;">
<div id="flashmovie" style="width:100%!important;height:95%!important;background-color:white!important;">
      <object classid="clsid:166B1BCA-3F9C-11CF-8075-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/director/sw.cab#version=8,5,0,0" width="100%" height="100%" id="flashapplet">
        <param name="src" value="/dynamic/videos/<?php echo($_video['filename']); ?>" />
        <param name="swRemote" value="swSaveEnabled='true' swVolume='true' swRestart='true' swPausePlay='true' swFastForward='true' swContextMenu='true' " />
        <param name="swLiveConnect" value="true" />
        <param name="bgcolor" value="white" />
        <param name="name" value="flashapplet" />
        <param name="swStretchStyle" value="meet" />
        <param name="swStretchHAlign" value="center" />
        <param name="swStretchVAlign" value="center" />
        <embed src="/dynamic/videos/<?php echo($_video['filename']); ?>" width="100%" height="100%" type="application/x-director" name="flashapplet" swLiveConnect="true" bgcolor="white" pluginspage="http://www.macromedia.com/shockwave/download/" swRemote="swSaveEnabled='true' swVolume='true' swRestart='true' swPausePlay='true' swFastForward='true' swContextMenu='true' " swStretchStyle="meet" swStretchHAlign="center" swStretchVAlign="center" />
      </object>
</div>
<a href="#" onclick="launchFullscreen(document.getElementById('flashmovie'));return false;">Full Screen</a>
</div>
<?php } elseif (endsWith($_video['filename'],".xap")) { ?>
<div id="watch-player" class="flash-player" style="background-color:transparent;">
<div id="flashmovie" style="width:100%!important;height:95%!important;background-color:white!important;color:black!important;">
      <object data="data:application/x-silverlight-2," type="application/x-silverlight-2" width="100%" height="100%">
        <param name="source" value="/dynamic/videos/<?php echo($_video['filename']); ?>" />
        <param name="background" value="white" />
        Microsoft Silverlight is required. <a href="/t/plugin_tutorial">Plugin Tutorial</a>.
      </object>
</div>
<a href="#" onclick="launchFullscreen(document.getElementById('flashmovie'));return false;">Full Screen</a>
</div>
<?php } elseif (endsWith($_video['filename'],".sb3")) { ?>
<div id="watch-player" class="flash-player" style="background-color:transparent;width:482px;height:440px;margin:0 79px;">
<iframe src="/scratchtw/embed.html?addons=pause,gamepad,mute-project,remove-curved-stage-border,drag-drop&settings-button&username=<?php echo urlencode($_SESSION['siteusername']); ?>&project_url=<?php echo(isset($_SERVER['HTTPS']) ? 'https' : 'http') ?>%3A%2F%2F<?php echo($_SERVER['SERVER_NAME']) ?>%2Fdynamic%2Fvideos%2F<?php echo(urlencode($_video['filename'])); ?>" id="scratchproject" width="482" height="412" allowtransparency="true" frameborder="0" scrolling="no" allowfullscreen></iframe>
<a href="/scratchtw/editor.html?username=<?php echo urlencode($_SESSION['siteusername']); ?>&project_url=<?php echo(isset($_SERVER['HTTPS']) ? 'https' : 'http') ?>%3A%2F%2F<?php echo($_SERVER['SERVER_NAME']) ?>%2Fdynamic%2Fvideos%2F<?php echo(urlencode($_video['filename'])); ?>">Open in editor</a> | <a href="/dynamic/videos/<?php echo($_video['filename']); ?>" target="_blank">Download this project</a>
</div>
<?php } elseif (endsWith($_video['filename'],".pmp")) { ?>
<div id="watch-player" class="flash-player" style="background-color:transparent;width:482px;height:440px;margin:0 79px;">
<iframe src="/scratchpm/embed.html?addons=pause,gamepad,mute-project,remove-curved-stage-border,drag-drop&settings-button&username=<?php echo urlencode($_SESSION['siteusername']); ?>&project_url=<?php echo(isset($_SERVER['HTTPS']) ? 'https' : 'http') ?>%3A%2F%2F<?php echo($_SERVER['SERVER_NAME']) ?>%2Fdynamic%2Fvideos%2F<?php echo(urlencode($_video['filename'])); ?>" id="scratchproject" width="482" height="412" allowtransparency="true" frameborder="0" scrolling="no" allowfullscreen></iframe>
<a href="/scratchpm/editor.html?username=<?php echo urlencode($_SESSION['siteusername']); ?>&project_url=<?php echo(isset($_SERVER['HTTPS']) ? 'https' : 'http') ?>%3A%2F%2F<?php echo($_SERVER['SERVER_NAME']) ?>%2Fdynamic%2Fvideos%2F<?php echo(urlencode($_video['filename'])); ?>">Open in editor</a> | <a href="/dynamic/videos/<?php echo($_video['filename']); ?>" target="_blank">Download this project</a>
</div>
<?php } elseif(endsWith($_video['filename'],".scratch") || endsWith($_video['filename'],".sb") || endsWith($_video['filename'],".sb2")) { ?>
<div id="watch-player" class="flash-player" style="background-color:transparent;width:482px;height:422px;margin:0 79px;">
<div id="scratchproject" style="visibility: visible; position: relative; z-index: 1000; width:100%!important;height:95%!important;background-color:white!important;">
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="100%" height="100%" id="scratchflash">
        <param name="movie" value="/static/swf/Scratch.swf" />
        <param name="quality" value="best" />
        <param name="allowScriptAccess" value="always" />
        <param name="allowFullScreen" value="true" />
        <param name="swLiveConnect" value="true" />
        <param name="menu" value="false" />
        <param name="bgcolor" value="white" />
        <param name="wmode" value="direct" />
        <param name="flashvars" value="project=/dynamic/videos/<?php echo($_video['filename']); ?>" />
        <embed src="/static/swf/Scratch.swf" width="100%" height="100%" type="application/x-shockwave-flash" name="scratchflash" quality="best" allowScriptAccess="always" allowFullScreen="true" swLiveConnect="true" pluginspage="http://www.macromedia.com/go/getflashplayer/" menu="false" bgcolor="white" wmode="direct" flashvars="project=/dynamic/videos/<?php echo($_video['filename']); ?>" />
      </object>
</div>
<a href="/scratch2/?project=/dynamic/videos/<?php echo(urlencode($_video['filename'])); ?>">Open in editor</a> | <a href="/dynamic/videos/<?php echo($_video['filename']); ?>" target="_blank">Download this project</a>
</div>
<?php } elseif (endsWith($_video['filename'],".xml") || endsWith($_video['filename'],".ypr")) { ?>
<div id="watch-player" class="flash-player" style="background-color:transparent;width:482px;height:382px;margin:0 79px;">
<iframe src="/snap/snap.html#run:<?php echo(isset($_SERVER['HTTPS']) ? 'https' : 'http') ?>://<?php echo($_SERVER['SERVER_NAME']) ?>/dynamic/videos/<?php echo(urlencode($_video['filename'])); ?>&embedMode&noExitWarning&noRun" id="scratchproject" width="482" height="362" allowtransparency="true" frameborder="0" scrolling="no" allowfullscreen></iframe>
<a href="#" onclick="launchFullscreen(document.getElementById('scratchproject'));return false;">Full Screen</a> | <a href="/snap/snap.html#open:<?php echo(isset($_SERVER['HTTPS']) ? 'https' : 'http') ?>://<?php echo($_SERVER['SERVER_NAME']) ?>/dynamic/videos/<?php echo(urlencode($_video['filename'])); ?>&editMode&noRun">Open in editor</a> | <a href="/dynamic/videos/<?php echo($_video['filename']); ?>" target="_blank">Download this project</a>
</div>
<?php } elseif (endsWith($_video['filename'],".mp3")) { ?>
<div id="watch-player" class="flash-player" style="height:auto;background-color:transparent;">
<audio controls autoplay>
      <source src="/dynamic/videos/<?php echo($_video['filename']); ?>" type="audio/mpeg">
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="240" height="20" style="width:240px!important;height:20px!important;" id="kekplayer">
        <param name="movie" value="/static/swf/dewplayer-vol.swf" />
        <param name="quality" value="best" />
        <param name="menu" value="false" />
        <param name="wmode" value="transparent" />
        <param name="flashvars" value="mp3=/dynamic/videos/<?php echo($_video['filename']); ?>&autostart=true" />
        <embed src="/static/swf/dewplayer-vol.swf" width="240" height="20" style="width:240px!important;height:20px!important;" type="application/x-shockwave-flash" name="kekplayer" quality="best" pluginspage="http://www.macromedia.com/go/getflashplayer/" menu="false" wmode="transparent" flashvars="mp3=/dynamic/videos/<?php echo($_video['filename']); ?>&autostart=true" />
      </object>
</audio>
</div>
<?php }
} else { ?>
<div id="watch-player" class="flash-player">
</div>
<script type="text/javascript">
$(function() {
if (detectFlash() && !detectRuffle()) {

document.getElementById("watch-player").innerHTML = '\
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="100%" height="100%" id="kekplayer">\
        <param name="movie" value="/static/swf/2008player.swf" />\
        <param name="quality" value="best" />\
        <param name="allowScriptAccess" value="always" />\
        <param name="allowFullScreen" value="true" />\
        <param name="swLiveConnect" value="true" />\
        <param name="menu" value="false" />\
        <param name="bgcolor" value="#B0B0B0" />\
        <param name="flashvars" value="video_id=/dynamic/videos/<?php echo($_video['filename']); ?>" />\
        <embed src="/static/swf/2008player.swf" width="100%" height="100%" type="application/x-shockwave-flash" name="kekplayer" quality="best" allowScriptAccess="always" allowFullScreen="true" swLiveConnect="true" pluginspage="http://www.macromedia.com/go/getflashplayer/" menu="false" bgcolor="#B0B0B0" flashvars="video_id=/dynamic/videos/<?php echo($_video['filename']); ?>" />\
      </object>\
';

}
});
</script>
<?php } ?>
<!--
<?php if ( endsWith($_video['filename'],".mp4") ) { ?>
    <script>
      (function() {
        var swf = "      \u003cembed type=\"application\/x-shockwave-flash\"     s\u0072c=\"\/\/s.ytimg.com\/yt\/swfbin\/watch_as3-vfloWhEvq.swf\"     id=\"movie_player\"    flashvars=\"fexp=907722%2C906062%2C910102%2C927104%2C922401%2C920704%2C912806%2C927201%2C913546%2C913556%2C925109%2C919003%2C920201%2C912706%2C900816\u0026amp;ptk=youtube_multi\u0026amp;enablecsi=1\u0026amp;allow_embed=1\u0026amp;rvs=view_count%3D24%252C209%252C324%26feature_type%3Dfvwp%26author%3DProtoOfSnagem%26title%3DHEYYEYAAEYAAAEYAEYAA%26length_seconds%3D127%26featured%3D1%26id%3DZZ5LpwO-An4%2Cview_count%3D13%252C121%252C773%26author%3Ddersiraresmc%26length_seconds%3D365%26id%3Dkv4RIhMpV40%26title%3DCritical%2BHits%2BVol.2%2Cview_count%3D9%252C033%252C824%26author%3Dayazkhatrier%26length_seconds%3D204%26id%3Dr6VCnYkNYLo%26title%3D100%2BGreatest%2BInternet%2BVideos%2BIn%2B3%2BMinutes%2Cview_count%3D642%252C634%26author%3DFa1lsp3cxD%26length_seconds%3D48%26id%3D8e47ianJYGg%26title%3DFamily%2BGuy-%2BStewie%2Bgets%2Brick%2Broll%2527d%2Cview_count%3D861%252C498%26author%3DThePrimeCronus%26length_seconds%3D3749%26id%3DS3P2iaWma-Y%26title%3D1-Hour%2BEpic%2BMusic%2B%257C%2BTwo%2BSteps%2BFrom%2BHell%2BVol.%2B2%2Cview_count%3D2%252C285%252C240%26author%3Dlilsportsplaya69%26length_seconds%3D197%26id%3DWYLvdLWkhk8%26title%3DChuck%2BNorris%2Bhears%2Bhis%2Bown%2Bfacts...%2Cview_count%3D2%252C010%252C479%26author%3Dbeeerent%26length_seconds%3D230%26id%3DLjur6v7-yoc%26title%3DHitler%2Bfinds%2Bout%2BPokemon%2Baren%2527t%2Breal%2Cview_count%3D79%252C447%252C461%26author%3Dakhilkhatri0608%26length_seconds%3D350%26id%3DVSrAJsWvEIc%26title%3DOne%2Bof%2Bthe%2Bbest%2Binspirational%2Bvideos%2Bever%2B-%2BSusan%2BBoyle%2B-%2BBritains%2BGot%2BTalent%2B2009%2Cview_count%3D299%252C142%26author%3Druigejoostnl%26length_seconds%3D52%26id%3DnAElQjPx7LQ%26title%3DBest%2Bninja%2Bdefuse%2Bever%2521%2521%2521%2BSND%2BMW3%2Cview_count%3D10%252C582%252C034%26author%3DTheSonicParadoxTeam%26length_seconds%3D471%26id%3DTCvMARhbBu8%26title%3DSonic%2BShorts%2B-%2BVolume%2B4%2Cview_count%3D10%252C345%252C179%26author%3DZeljko9NS5Serbia%26length_seconds%3D373%26id%3D1jre6_FBBc0%26title%3DKid%2BCudi%2B-%2BPursuit%2Bof%2BHappiness%2B%2528Steve%2BAoki%2BRemix%2529%2B-%2BProject%2BX%2B%2528Party%2BTrailer%2BScene%2529%2BHD%2Cview_count%3D1%252C593%252C982%26author%3DLipigl%26length_seconds%3D42%26id%3DoB6bk5S2_Zc%26title%3DThey%2Bsee%2Bme%2Btrollin%2527%2BThey%2Bhatin%2527\u0026amp;vq=auto\u0026amp;account_playback_token=\u0026amp;autohide=2\u0026amp;csi_page_type=watch5\u0026amp;keywords=Cotter548%2CShawn%2CCotter%2Clol%2Cgamefaqs%2CCE%2Creddit%2Crettocs%2Cno%2Cbrb%2Cafk%2Clawl%2Cpwnt%2CRickroll%2CRickroll%27d%2CRick%2CRoll%2CDuckroll%2CDuck%2Crick%2Croll%2Castley%2Cnever%2Cgonna%2Cgive%2Cyou%2Cup%2Clet%2Cdown%2Crun%2Caround%2Cand%2Churt\u0026amp;cr=US\u0026amp;iv3_module=http%3A%2F%2Fs.ytimg.com%2Fyt%2Fswfbin%2Fiv3_module-vflGCS_pr.swf\u0026amp;fmt_list=43%2F320x240%2F99%2F0%2F0%2C34%2F320x240%2F9%2F0%2F115%2C18%2F320x240%2F9%2F0%2F115%2C5%2F320x240%2F7%2F0%2F0%2C36%2F320x240%2F99%2F0%2F0%2C17%2F176x144%2F99%2F0%2F0\u0026amp;title=RickRoll%27D\u0026amp;length_seconds=212\u0026amp;enablejsapi=1\u0026amp;advideo=1\u0026amp;tk=o3_r7m6s_HAaFxeywi14S3qFcY4uSrEiWfZ8KVUoyEB_gj1rlrELuQ%3D%3D\u0026amp;iv_load_policy=1\u0026amp;iv_module=http%3A%2F%2Fs.ytimg.com%2Fyt%2Fswfbin%2Fiv_module-vflBJ5PLc.swf\u0026amp;sdetail=p%3Abit.ly%2FdwMq4b\u0026amp;url_encoded_fmt_stream_map=itag%3D43%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-nwj7knek---v3---lscache4.c.youtube.com%252Fvideoplayback%253Fupn%253DsWh0pzcodo0%2526sparams%253Dcp%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Cratebypass%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D907722%25252C906062%25252C910102%25252C927104%25252C922401%25252C920704%25252C912806%25252C927201%25252C913546%25252C913556%25252C925109%25252C919003%25252C920201%25252C912706%25252C900816%2526ms%253Dau%2526expire%253D1349937946%2526itag%253D43%2526ipbits%253D8%2526gcr%253Dus%2526sver%253D3%2526ratebypass%253Dyes%2526mt%253D1349916311%2526ip%253D207.241.237.166%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526cp%253DU0hTTllOVV9JUENOM19RSFlKOmVLUWdkTXRmS0dX%2526id%253Da078394896111c0d%26type%3Dvideo%252Fwebm%253B%2Bcodecs%253D%2522vp8.0%252C%2Bvorbis%2522%26fallback_host%3Dtc.v3.cache4.c.youtube.com%26sig%3DD879CD07A768B7D80A9C7D4E5DD16EDAC9DB4963.CDD2371FC76E7E959C559940842DC999573623D1%26quality%3Dmedium%2Citag%3D34%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-o097zne7---v18---lscache1.c.youtube.com%252Fvideoplayback%253Fupn%253DsWh0pzcodo0%2526sparams%253Dalgorithm%25252Cburst%25252Ccp%25252Cfactor%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D907722%25252C906062%25252C910102%25252C927104%25252C922401%25252C920704%25252C912806%25252C927201%25252C913546%25252C913556%25252C925109%25252C919003%25252C920201%25252C912706%25252C900816%2526ms%253Dau%2526algorithm%253Dthrottle-factor%2526burst%253D40%2526ip%253D207.241.237.166%2526itag%253D34%2526gcr%253Dus%2526sver%253D3%2526mt%253D1349916311%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526ipbits%253D8%2526factor%253D1.25%2526cp%253DU0hTTllOVV9JUENOM19RSFlKOmVLUWdkTXRmS0dX%2526expire%253D1349937946%2526id%253Da078394896111c0d%26type%3Dvideo%252Fx-flv%26fallback_host%3Dtc.v18.cache1.c.youtube.com%26sig%3DC397DCB00566E0FBB1551675B6108A4158C34557.CB3777882F05D65158C043C258FF8D4EBA90FA50%26quality%3Dmedium%2Citag%3D18%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-nwj7kned---v5---lscache6.c.youtube.com%252Fvideoplayback%253Fupn%253DsWh0pzcodo0%2526sparams%253Dcp%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Cratebypass%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D907722%25252C906062%25252C910102%25252C927104%25252C922401%25252C920704%25252C912806%25252C927201%25252C913546%25252C913556%25252C925109%25252C919003%25252C920201%25252C912706%25252C900816%2526ms%253Dau%2526expire%253D1349937946%2526itag%253D18%2526ipbits%253D8%2526gcr%253Dus%2526sver%253D3%2526ratebypass%253Dyes%2526mt%253D1349916311%2526ip%253D207.241.237.166%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526cp%253DU0hTTllOVV9JUENOM19RSFlKOmVLUWdkTXRmS0dX%2526id%253Da078394896111c0d%26type%3Dvideo%252Fmp4%253B%2Bcodecs%253D%2522avc1.42001E%252C%2Bmp4a.40.2%2522%26fallback_host%3Dtc.v5.cache6.c.youtube.com%26sig%3D2A6196BFA95A0E8887CECC345A153937D8599592.5160A930EF6FDFF466FA41BAB7E76AD5CFE766B0%26quality%3Dmedium%2Citag%3D5%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-nwj7knek---v19---lscache4.c.youtube.com%252Fvideoplayback%253Fupn%253DsWh0pzcodo0%2526sparams%253Dalgorithm%25252Cburst%25252Ccp%25252Cfactor%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D907722%25252C906062%25252C910102%25252C927104%25252C922401%25252C920704%25252C912806%25252C927201%25252C913546%25252C913556%25252C925109%25252C919003%25252C920201%25252C912706%25252C900816%2526ms%253Dau%2526algorithm%253Dthrottle-factor%2526burst%253D40%2526ip%253D207.241.237.166%2526itag%253D5%2526gcr%253Dus%2526sver%253D3%2526mt%253D1349916311%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526ipbits%253D8%2526factor%253D1.25%2526cp%253DU0hTTllOVV9JUENOM19RSFlKOmVLUWdkTXRmS0dX%2526expire%253D1349937946%2526id%253Da078394896111c0d%26type%3Dvideo%252Fx-flv%26fallback_host%3Dtc.v19.cache4.c.youtube.com%26sig%3DA43F1CE03CC729FD57D1211C61F21AAB7C5AF20D.854D2A74C6CBA3160762D9FA75903D35A67382ED%26quality%3Dsmall%2Citag%3D36%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-nwj7kner---v4---lscache8.c.youtube.com%252Fvideoplayback%253Fupn%253DsWh0pzcodo0%2526sparams%253Dalgorithm%25252Cburst%25252Ccp%25252Cfactor%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D907722%25252C906062%25252C910102%25252C927104%25252C922401%25252C920704%25252C912806%25252C927201%25252C913546%25252C913556%25252C925109%25252C919003%25252C920201%25252C912706%25252C900816%2526ms%253Dau%2526algorithm%253Dthrottle-factor%2526burst%253D40%2526ip%253D207.241.237.166%2526itag%253D36%2526gcr%253Dus%2526sver%253D3%2526mt%253D1349916311%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526ipbits%253D8%2526factor%253D1.25%2526cp%253DU0hTTllOVV9JUENOM19RSFlKOmVLUWdkTXRmS0dX%2526expire%253D1349937946%2526id%253Da078394896111c0d%26type%3Dvideo%252F3gpp%253B%2Bcodecs%253D%2522mp4v.20.3%252C%2Bmp4a.40.2%2522%26fallback_host%3Dtc.v4.cache8.c.youtube.com%26sig%3D719E70BF679A7B41474D05D3706358168E217890.90B1765E62D594BEDEE837BB3F26FA82C0AC2C93%26quality%3Dsmall%2Citag%3D17%26url%3Dhttp%253A%252F%252Fo-o---preferred---sn-o097znee---v9---lscache5.c.youtube.com%252Fvideoplayback%253Fupn%253DsWh0pzcodo0%2526sparams%253Dalgorithm%25252Cburst%25252Ccp%25252Cfactor%25252Cgcr%25252Cid%25252Cip%25252Cipbits%25252Citag%25252Csource%25252Cupn%25252Cexpire%2526fexp%253D907722%25252C906062%25252C910102%25252C927104%25252C922401%25252C920704%25252C912806%25252C927201%25252C913546%25252C913556%25252C925109%25252C919003%25252C920201%25252C912706%25252C900816%2526ms%253Dau%2526algorithm%253Dthrottle-factor%2526burst%253D40%2526ip%253D207.241.237.166%2526itag%253D17%2526gcr%253Dus%2526sver%253D3%2526mt%253D1349916311%2526mv%253Dm%2526source%253Dyoutube%2526key%253Dyt1%2526ipbits%253D8%2526factor%253D1.25%2526cp%253DU0hTTllOVV9JUENOM19RSFlKOmVLUWdkTXRmS0dX%2526expire%253D1349937946%2526id%253Da078394896111c0d%26type%3Dvideo%252F3gpp%253B%2Bcodecs%253D%2522mp4v.20.3%252C%2Bmp4a.40.2%2522%26fallback_host%3Dtc.v9.cache5.c.youtube.com%26sig%3D8F24ED9FCC2500D100D1AAC9CD5A614B0C0FA5AA.6155DD5967D990C9F24D4862F7D70BCAF0914DA0%26quality%3Dsmall\u0026amp;watermark=%2Chttp%3A%2F%2Fs.ytimg.com%2Fyt%2Fimg%2Fwatermark%2Fyoutube_watermark-vflHX6b6E.png%2Chttp%3A%2F%2Fs.ytimg.com%2Fyt%2Fimg%2Fwatermark%2Fyoutube_hd_watermark-vflAzLcD6.png\u0026amp;sourceid=r\u0026amp;timestamp=1349916364\u0026amp;storyboard_spec=http%3A%2F%2Fi4.ytimg.com%2Fsb%2FoHg5SJYRHA0%2Fstoryboard3_L%24L%2F%24N.jpg%7C48%2327%23100%2310%2310%230%23default%23kFKafDpxazQDzs-N0NAkdH-jy_E%7C60%2345%23108%2310%2310%232000%23M%24M%233QCcFMpSH_MACnGTmY_ha2J8UU0%7C120%2390%23108%235%235%232000%23M%24M%23YJotj-gSka-wkwz-SF4GUW_h1Kk\u0026amp;plid=AATLveVba5g8mPZ8\u0026amp;showpopout=1\u0026amp;hl=en_US\u0026amp;tmi=1\u0026amp;iv_logging_level=4\u0026amp;st_module=http%3A%2F%2Fs.ytimg.com%2Fyt%2Fswfbin%2Fst_module-vflCXoloO.swf\u0026amp;no_get_video_log=1\u0026amp;iv_close_button=0\u0026amp;endscreen_module=http%3A%2F%2Fs.ytimg.com%2Fyt%2Fswfbin%2Fendscreen-vflK6XzTZ.swf\u0026amp;iv_read_url=http%3A%2F%2Fwww.youtube.com%2Fannotations_iv%2Fread2%3Fsparams%3Dexpire%252Cvideo_id%26expire%3D1349959800%26key%3Da1%26signature%3D815C68436F1E8F95A9283A421D758B7A6452EFD9.5029A9CC9CFCF79F0B17A60238447CA0FE7CA991%26video_id%3DoHg5SJYRHA0%26feat%3DCS\u0026amp;iv_queue_log_level=0\u0026amp;referrer=http%3A%2F%2Fbit.ly%2FdwMq4b\u0026amp;video_id=oHg5SJYRHA0\u0026amp;sw=1.0\u0026amp;sk=4md16KjsgYmUvVHOsiBQxSFIkPbju0d8C\u0026amp;pltype=contentugc\u0026amp;t=vjVQa1PpcFN8E8yJ1Q1BJFTy1GYmGAMgRZUyNC4FMBY%3D\u0026amp;loudness=-23.6900005341\"     allowscriptaccess=\"always\" allowfullscreen=\"true\" bgcolor=\"#000000\"\u003e\n  \u003cnoembed\u003e\u003cdiv class=\"yt-alert yt-alert-default yt-alert-error  yt-alert-player\"\u003e  \u003cdiv class=\"yt-alert-icon\"\u003e\n    \u003cimg s\u0072c=\"\/\/s.ytimg.com\/yt\/img\/pixel-vfl3z5WfW.gif\" class=\"icon master-sprite\" alt=\"Alert icon\"\u003e\n  \u003c\/div\u003e\n\u003cdiv class=\"yt-alert-buttons\"\u003e\u003c\/div\u003e\u003cdiv class=\"yt-alert-content\" role=\"alert\"\u003e    \u003cspan class=\"yt-alert-vertical-trick\"\u003e\u003c\/span\u003e\n    \u003cdiv class=\"yt-alert-message\"\u003e\n            You need Adobe Flash Player to watch this video. \u003cbr\u003e \u003ca href=\"\/\/get.adobe.com\/flashplayer\/\"\u003eDownload it from Adobe.\u003c\/a\u003e\n    \u003c\/div\u003e\n\u003c\/div\u003e\u003c\/div\u003e\u003c\/noembed\u003e\n\n";
        document.getElementById('watch-player').innerHTML = swf;
      })()
    </script>
<?php } ?>
-->
      <!-- begin watch-video-extra -->
      <div id="watch-video-extra">
        
        
      </div>
      <!-- end watch-video-extra -->
    </div>
						</div>
						<!-- begin watch-main-container -->
						<div id="watch-main-container">
							<div id="watch-main">
								<div id="watch-panel">
									<?php if($_video['featured'] == "v") { ?>
										<div id="masthead_child_div"><div class="yt-alert yt-alert-default yt-alert-warn">  <div class="yt-alert-icon">
											<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
										</div>
										<div class="yt-alert-buttons"></div><div class="yt-alert-content" role="alert">    <span class="yt-alert-vertical-trick"></span>
											<div class="yt-alert-message">
												This video is featured. View more featured videos by WrapperTube on the front page.
											</div>
										</div></div></div>
									<?php }  ?>

	  								<?php if($_video['visibility'] == "u") { ?>
										<div id="masthead_child_div"><div class="yt-alert yt-alert-default yt-alert-warn">  <div class="yt-alert-icon">
											<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
										</div>
										<div class="yt-alert-buttons"></div><div class="yt-alert-content" role="alert">    <span class="yt-alert-vertical-trick"></span>
											<div class="yt-alert-message">
												This video is unlisted. Only people who have the link can view this video.
											</div>
										</div></div></div>
									<?php } else if($_video['visibility'] == "v") { ?>
										<div id="masthead_child_div"><div class="yt-alert yt-alert-default yt-alert-error">  <div class="yt-alert-icon">
											<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
										</div>
										<div class="yt-alert-buttons"></div><div class="yt-alert-content" role="alert">    <span class="yt-alert-vertical-trick"></span>
											<div class="yt-alert-message">
												This video is private. Only you can view this video.
											</div>
										</div></div></div>
									<?php } ?>

									<div class="yt-alert yt-alert-default yt-alert-warn hid " id="flash10-promo-div">
										<div class="yt-alert-icon">
											<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
										</div>
										<div class="yt-alert-buttons">  <button type="button" class="close yt-uix-close yt-uix-button yt-uix-button-close" onclick=";return false;" data-close-parent-class="yt-alert" role="button"><span class="yt-uix-button-content">Close </span></button></div>
										<div class="yt-alert-content" role="alert">
											<span class="yt-alert-vertical-trick"></span>
											<div class="yt-alert-message">
												Upgrade to the latest Flash Player for improved playback performance. <a href="//www.adobe.com/go/getflashplayer/" onmousedown="urchinTracker('/Events/VideoWatch/GetFlashUpgrade');">Upgrade now</a> or <a href="//support.google.com/youtube/bin/answer.py?answer=95402">more info</a>.
											</div>
										</div>
									</div>
									<div id="watch-actions">
										<div id="watch-actions-right">
											<span class="watch-view-count">
											<strong><?php echo $__video_h->fetch_video_views($_video['rid']); ?></strong>
											</span>
											<button onclick=";return false;" title="Show video statistics" type="button" id="watch-insight-button" class="yt-uix-tooltip yt-uix-tooltip-reverse yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" data-button-action="yt.www.watch.actions.stats" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-watch-insight" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Show video statistics"><span class="yt-valign-trick"></span></span></button>
										</div>
										<button type="button" class="yt-uix-tooltip-reverse  yt-uix-button yt-uix-button-default yt-uix-tooltip" onclick=";return false;" title="Add to favorites or playlist" data-upsell="playlist" data-button-action="yt.www.watch.actions.addto" role="button"><span class="yt-uix-button-content"><span class="addto-label">Add to</span> </span></button>
										<button onclick=";return false;" title="Share or embed this video" type="button" class="yt-uix-tooltip-reverse yt-uix-button yt-uix-button-default yt-uix-tooltip" id="watch-share" data-button-action="yt.www.watch.actions.share" role="button"><span class="yt-uix-button-content">Share </span></button>
										<button onclick=";<?php if(isset($_SESSION['siteusername'])) { ?>if(confirm('By reporting this video, you agree that this video is actually breaking the rules in our Terms of Service.')){window.location.href=this.getAttribute('href');}<?php } else { ?>alert('You have to be logged in to report videos.');<?php } ?>return false;" href="/report?v=<?php echo $_video['rid']; ?>" title="Flag as inappropriate" type="button" class="yt-uix-tooltip-reverse  yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" id="watch-flag" data-button-action="null" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-watch-flag" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Flag as inappropriate"><span class="yt-valign-trick"></span></span></button>
									</div>
									<div id="watch-actions-area-container" class="hid">
										<div id="watch-actions-area" class="yt-rounded">
											<div id="watch-actions-loading" class="watch-actions-panel hid">
												<img src="/static/img/loadingg.gif"> Loading...
											</div>
											<div id="watch-actions-logged-out" class="watch-actions-panel hid">
												<?php if(!isset($_SESSION['siteusername'])) { ?>
												<div class="yt-alert yt-alert-naked yt-alert-warn  ">
													<div class="yt-alert-icon">
														<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
													</div>
													<div class="yt-alert-content" role="alert">
														<span class="yt-alert-vertical-trick"></span>
														<div class="yt-alert-message">
															<strong><a href="/sign_in">Sign in</a> or <a href="/sign_up">sign up</a> now!
															</strong>
														</div>
													</div>
												</div>
												<?php } else { ?>
													<h3>Be friends with the creator</h3>

													<?php if($_SESSION['siteusername'] != $_video['author']) { ?>
														<img style="width: 50px;height:50px;" src="/dynamic/pfp/<?php echo $__user_h->fetch_pfp($_video['author']); ?>">
														<span style="display: inline-block; vertical-align:top;width: 100px;font-size:11px;">
															<b><a href="/user/<?php echo htmlspecialchars($_video['author']); ?>"><?php echo htmlspecialchars($_video['author']); ?></a></b><br>
															<?php echo $__user_h->fetch_subs_count($_video['author']); ?> subscribers<br>
															<?php echo $__user_h->fetch_user_videos($_video['author']); ?> videos published<br>
														</span><br><br>
													<?php } else { ?>
														<img style="width: 50px;height:50px;" src="/dynamic/pfp/<?php echo $__user_h->fetch_pfp($_video['author']); ?>">
														<span style="display: inline-block; vertical-align:top;width: 100px;font-size:11px;">
															This is you.
														</span><br><br>
													<?php } ?>

													<?php if($_SESSION['siteusername'] != $_video['author']) { ?>
													<span id="friend_text">
														<?php if($_video['friended'] == false) { ?>
															<a href="javascript:void(0);" onclick="add_friend();return false;">Send a friend request</a>
														<?php } else { ?>
															Your friend request is pending.
														<?php } ?>
													</span>
													<?php } else { ?>
														You can't friend yourself.
													<?php } ?>
													<hr><br>
													<h3>Add to Favorites</h3>
													<?php if($_video['favorited'] == false) { ?>
														<a href="javascript:void(0);" onclick="toggle_favourite();return false;" id="favourite_text">Favorite Video</a>
													<?php } else { ?>
														<a href="javascript:void(0);" onclick="toggle_favourite();return false;" id="favourite_text">Unfavorite Video</a>
													<?php } ?>
                                                                                                        <hr><br>
                                                                                                        <h3>Add to Quicklist</h3>
                                                                                                                <a href="javascript:void(0);" onclick="add_to_quicklist();return false;">Add to Quicklist</a>
													<hr><br>
													<h3>Add to a Playlist</h3>
													<?php
														$stmt = $__db->prepare("SELECT * FROM playlists WHERE author = :username ORDER BY id DESC LIMIT 20");
														$stmt->bindParam(":username", $_SESSION['siteusername']);
														$stmt->execute();
														while($playlist = $stmt->fetch(PDO::FETCH_ASSOC)) { 
															$buffer = json_decode($playlist['videos']);
															@$rid = $buffer[0];
															if(!empty($rid)) {
																@$video = $__video_h->fetch_video_rid($rid);
															} else {
																$video['thumbnail'] = "";
																$video['duration'] = 0;
															}

															$videos = count($buffer);
													?>
														<a href="javascript:void(0);" onclick="add_to_playlist('<?php echo $playlist['rid']; ?>');return false;">Add to <?php echo htmlspecialchars($playlist['title']); ?></a><br>
													<?php } $stmt = null; ?>
													<hr><br>
													<h3>Add to a Group</h3>
													<?php
														$stmt = $__db->prepare("SELECT * FROM group_members WHERE username = :username ORDER BY id DESC LIMIT 20");
														$stmt->bindParam(":username", $_SESSION['siteusername']);
														$stmt->execute();
														while($playlist = $stmt->fetch(PDO::FETCH_ASSOC)) { 
															$playlist = $__video_h->fetch_group_id($playlist['togroup']);
													?>
														<a href="javascript:void(0);" onclick="add_to_group('<?php echo $playlist['id']; ?>');return false;">Add to <?php echo htmlspecialchars($playlist['group_title']); ?></a><br>
													<?php } $stmt = null; ?>
												<?php } ?>
											</div>
											<div id="watch-actions-error" class="watch-actions-panel hid">
												<div class="yt-alert yt-alert-naked yt-alert-error  ">
													<div class="yt-alert-icon">
														<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
													</div>
													<div class="yt-alert-content" role="alert" id="watch-error-string"></div>
												</div>
											</div>
											<div id="watch-actions-addto" class="watch-actions-panel hid"></div>
											<div id="watch-actions-share" class="watch-actions-panel hid">
												<div id="watch-actions-share-panel2">
													<div class="share-panel">
														<div class="share-option-container ytg-box">
															<div class="share-panel-url-container">
																<span class=" yt-uix-form-input-container "><input class="yt-uix-form-input-text share-panel-url" name="share_url" value="http://wrappertube.org/watch?v=<?php echo $_video['rid']; ?>" data-video-id="<?php echo $_video['rid']; ?>" readonly onclick="this.focus();this.select();"></span>
																<div class="share-panel-url-options yt-uix-expander yt-uix-expander-collapsed">
																	<div class="yt-uix-expander-head">
																		<a class="share-panel-show-url-options">
																		<span class="collapsed-message">
																		Options
																		<img class="arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
																		</span> 
																		<span class="expanded-message">
																		Close
																		<img class="arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
																		</span>
																		</a>
																	</div>
																	<ul class="yt-uix-expander-body share-options">
																		<li>
																			<label>
																			<input class="share-panel-start-at" type="checkbox">
																			Start at:
																			</label>
																			<input type="text" value="0:00" class="yt-uix-form-input-text share-panel-start-at-time">
																		</li>
																		<li>
																			<label>
																			<input class="share-panel-long-url" type="checkbox">
																			Long link
																			</label>
																		</li>
																	</ul>
																</div>
															</div>
															<div class="share-panel-buttons yt-uix-expander yt-uix-expander-collapsed">
																<span class="share-panel-main-buttons">
																<button type="button" class="share-panel-embed yt-uix-button yt-uix-button-default" onclick=";return false;" role="button"><span class="yt-uix-button-content">Embed </span></button><button type="button" class="share-panel-email yt-uix-button yt-uix-button-default" href="mailto:?subject=<?php echo rawurlencode($_video['title']); ?>&body=http%3A%2F%2Fwrappertube.org%2Fwatch%3Fv%3D<?php echo rawurlencode($_video['rid']); ?>" role="button" onclick=";window.location.href=this.getAttribute('href');return false;"><span class="yt-uix-button-content">Email </span></button> <button type="button" class="share-panel-download yt-uix-button yt-uix-button-default" href="/dynamic/videos/<?php echo(htmlspecialchars($_video['filename'])); ?>" onclick=";window.location.href=this.getAttribute('href');return false;" role="button"><span class="yt-uix-button-content">Download</span></button>    </span>
															</div>
															<div class="share-panel-services yt-uix-expander yt-uix-expander-collapsed clearfix">
																<ul class="share-group ytg-box">
																	<li>
																		<button onclick="yt.tracking.shareVideo(&quot;FACEBOOK&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/www.facebook.com\/sharer.php?u=http%3A%2F%2Fwrappertube.org%2Fwatch%3Fv%3D<?php echo urlencode($_video['rid']); ?>%26feature%3Dshare\u0026t=<?php echo urlencode($_video['title']); ?>&quot;, {'height': 440,'width': 620,'scrollbars': true});return false;" data-service-name="FACEBOOK" title="Share to Facebook" class="yt-uix-tooltip share-service-button">
																		<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Facebook" class="share-service-icon share-service-icon-facebook">
																		<span>Facebook</span>
																		</button>
																	</li>
																	<li>
																		<button onclick="yt.tracking.shareVideo(&quot;TWITTER&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/twitter.com\/share?url=http%3A%2F%2Fwrappertube.org%2Fwatch%3Fv%3D<?php echo urlencode($_video['rid']); ?>\u0026text=<?php echo urlencode($_video['title']); ?>%3A\u0026via=wrappertube&quot;, {'height': 650,'width': 1024,'scrollbars': true});return false;" data-service-name="TWITTER" title="Share to Twitter" class="yt-uix-tooltip share-service-button" data-tooltip-text="Share to Twitter">
																		<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Twitter" class="share-service-icon share-service-icon-twitter">
																		<span>Twitter</span>
																		</button>
																	</li>
																	<li>
																		<button onclick="yt.tracking.shareVideo(&quot;GOOGLEPLUS&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;https:\/\/plus.google.com\/u\/0\/share?url=http%3A%2F%2Fwrappertube.org%2Fwatch%3Fv%3D<?php echo urlencode($_video['rid']); ?>%26feature%3Dshare\u0026source=yt&quot;, {'height': 620,'width': 620,'scrollbars': true});return false;" data-service-name="GOOGLEPLUS" title="Share to Google+" class="yt-uix-tooltip share-service-button" data-tooltip-text="Share to Google+">
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
																					<button onclick="yt.tracking.shareVideo(&quot;REDDIT&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/reddit.com\/submit?url=http%3A%2F%2Fwrappertube.org%2Fwatch%3Fv%3D<?php echo urlencode($_video['rid']); ?>%26feature%3Dshare\u0026title=<?php echo urlencode($_video['title']); ?>&quot;, {'height': 650,'width': 1024,'scrollbars': true});return false;" data-service-name="REDDIT" class="share-service-button">
																					<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Reddit" class="share-service-icon share-service-icon-reddit">
																					<span>Reddit</span>
																					</button>
																					<span>Reddit</span>
																				</li>
																				<li>
																					<button onclick="yt.tracking.shareVideo(&quot;TUMBLR&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/www.tumblr.com\/share?v=3\u0026u=http%3A%2F%2Fwrappertube.org%2Fwatch%3Fv%3D<?php echo urlencode($_video['rid']); ?>%26feature%3Dshare&quot;, {'height': 650,'width': 1024,'scrollbars': true});return false;" data-service-name="TUMBLR" class="share-service-button">
																					<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="tumblr." class="share-service-icon share-service-icon-tumblr">
																					<span>tumblr.</span>
																					</button>
																					<span>tumblr.</span>
																				</li>
																				<li>
																					<button onclick="yt.tracking.shareVideo(&quot;BLOGGER&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/www.blogger.com\/blog-this.g?n=<?php echo urlencode($_video['title']); ?>\u0026source=youtube\u0026b=%3Ciframe+width%3D%22480%22+height%3D%22270%22+src%3D%22http%3A%2F%2Fwrappertube.org%2Fembed%2F<?php echo urlencode($_video['rid']); ?>%3Ffs%3D1%22+frameborder%3D%220%22+allowfullscreen%3E%3C%2Fiframe%3E\u0026eurl=http%3A%2F%2Fi3.ytimg.com%2Fvi%2FngzCpd94AwA%2Fhqdefault.jpg&quot;, {'height': 468,'width': 768,'scrollbars': true});return false;" data-service-name="BLOGGER" class="share-service-button">
																					<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Blogger" class="share-service-icon share-service-icon-blogger">
																					<span>Blogger</span>
																					</button>
																					<span>Blogger</span>
																				</li>
																				<li>
																					<button onclick="yt.tracking.shareVideo(&quot;MYSPACE&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/www.myspace.com\/Modules\/PostTo\/Pages\/?t=<?php echo urlencode($_video['title']); ?>\u0026u=http%3A%2F%2Fwrappertube.org%2Fwatch%3Fv%3D<?php echo urlencode($_video['rid']); ?>%26feature%3Dshare\u0026l=1&quot;, {'height': 650,'width': 1024,'scrollbars': true});return false;" data-service-name="MYSPACE" class="share-service-button">
																					<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Myspace" class="share-service-icon share-service-icon-myspace">
																					<span>Myspace</span>
																					</button>
																					<span>Myspace</span>
																				</li>
																				<li>
																					<button onclick="yt.tracking.shareVideo(&quot;VKONTAKTE&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/vk.com\/share.php?title=<?php echo urlencode($_video['title']); ?>\u0026url=http%3A%2F%2Fwrappertube.org%2Fwatch%3Fv%3D<?php echo urlencode($_video['rid']); ?>%26feature%3Dshare\u0026comment=<?php echo urlencode($_video['description']); ?>&quot;, {'height': 650,'width': 1024,'scrollbars': true});return false;" data-service-name="VKONTAKTE" class="share-service-button">
																					<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="VKontakte" class="share-service-icon share-service-icon-vkontakte">
																					<span>VKontakte</span>
																					</button>
																					<span>VKontakte</span>
																				</li>
																				<li>
																					<button onclick="yt.tracking.shareVideo(&quot;ODNOKLASSNIKI&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/connect.ok.ru\/dk?st.cmd=WidgetSharePreview\u0026st.shareUrl=http%3A%2F%2Fwrappertube.org%2Fwatch%3Fv%3D<?php echo urlencode($_video['rid']); ?>%26feature%3Dshare&quot;, {'height': 650,'width': 1024,'scrollbars': true});return false;" data-service-name="ODNOKLASSNIKI" class="share-service-button">
																					<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Odnoklassiki" class="share-service-icon share-service-icon-odnoklassniki">
																					<span>Odnoklassniki</span>
																					</button>
																					<span>Odnoklassniki</span>
																				</li>
																				<li>
																					<button onclick="yt.tracking.shareVideo(&quot;TELEGRAM&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/t.me\/share\/url\/?text=<?php echo urlencode($_video['title']); ?>\u0026url=http%3A%2F%2Fwrappertube.org%2Fwatch%3Fv%3D<?php echo urlencode($_video['rid']); ?>%26feature%3Dshare&quot;, {'height': 650,'width': 1024,'scrollbars': true});return false;" data-service-name="TELEGRAM" class="share-service-button">
																					<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Telegram" class="share-service-icon share-service-icon-orkut">
																					<span>Telegram</span>
																					</button>
																					<span>Telegram</span>
																				</li>
																			</ul>
																			<ul>
																				<li>
																					<button onclick="yt.tracking.shareVideo(&quot;HI5&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/www.hi5.com\/friend\/checkViewedVideo.do?t=<?php echo urlencode($_video['title']); ?>\u0026url=http%3A%2F%2Fwrappertube.org%2Fwatch%3Fv%3D<?php echo urlencode($_video['rid']); ?>%26feature%3Dshare\u0026embeddable=true\u0026simple=true&quot;, {'height': 475,'width': 800,'scrollbars': true});return false;" data-service-name="HI5" class="share-service-button">
																					<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="hi5" class="share-service-icon share-service-icon-hi5">
																					<span>hi5</span>
																					</button>
																					<span>hi5</span>
																				</li>
																				<li>
																					<button onclick="yt.tracking.shareVideo(&quot;LINKEDIN&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/www.linkedin.com\/shareArticle?url=http%3A%2F%2Fwrappertube.org%2Fwatch%3Fv%3D<?php echo urlencode($_video['rid']); ?>%26feature%3Dshare\u0026title=<?php echo urlencode($_video['title']); ?>\u0026summary=<?php echo urlencode($_video['description']); ?>\u0026source=Wrappertube&quot;, {'height': 650,'width': 1024,'scrollbars': true});return false;" data-service-name="LINKEDIN" class="share-service-button">
																					<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="LinkedIn" class="share-service-icon share-service-icon-linkedin">
																					<span>LinkedIn</span>
																					</button>
																					<span>LinkedIn</span>
																				</li>
																				<li>
																					<button onclick="yt.tracking.shareVideo(&quot;STUMBLEUPON&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/www.stumbleupon.com\/submit?url=http%3A%2F%2Fwrappertube.org%2Fwatch%3Fv%3D<?php echo urlencode($_video['rid']); ?>%26feature%3Dshare\u0026title=<?php echo urlencode($_video['title']); ?>&quot;, {'height': 650,'width': 1024,'scrollbars': true});return false;" data-service-name="STUMBLEUPON" class="share-service-button">
																					<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="StumbleUpon" class="share-service-icon share-service-icon-stumbleupon">
																					<span>StumbleUpon</span>
																					</button>
																					<span>StumbleUpon</span>
																				</li>
																				<li>
																					<button onclick="yt.tracking.shareVideo(&quot;HACKERNEWS&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/news.ycombinator.com\/submitlink?t=<?php echo urlencode($_video['title']); ?>\u0026u=http%3A%2F%2Fwrappertube.org%2Fwatch%3Fv%3D<?php echo urlencode($_video['rid']); ?>%26feature%3Dshare&quot;, {'height': 650,'width': 1024,'scrollbars': true});return false;" data-service-name="HACKERNEWS" class="share-service-button">
																					<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Hacker News" class="share-service-icon share-service-icon-yahoo">
																					<span>Hacker News</span>
																					</button>
																					<span>Hacker News</span>
																				</li>
																				<li>
																					<button onclick="yt.tracking.shareVideo(&quot;LIVEJOURNAL&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/www.livejournal.com\/update.bml?subject=<?php echo urlencode($_video['title']); ?>\u0026event=http%3A%2F%2Fwrappertube.org%2Fwatch%3Fv%3D<?php echo urlencode($_video['rid']); ?>%26feature%3Dshare&quot;, {'height': 650,'width': 1024,'scrollbars': true});return false;" data-service-name="LIVEJOURNAL" class="share-service-button">
																					<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="LiveJournal" class="share-service-icon share-service-icon-livejournal">
																					<span>LiveJournal</span>
																					</button>
																					<span>LiveJournal</span>
																				</li>
																				<li>
																					<button onclick="yt.tracking.shareVideo(&quot;PINTEREST&quot;, &quot;ngzCpd94AwA&quot;,&quot;en_US&quot;, &quot;sharepanel&quot;);yt.window.popup(&quot;http:\/\/pinterest.com\/pin\/create\/button\/?url=http%3A%2F%2Fwrappertube.org%2Fwatch%3Fv%3D<?php echo urlencode($_video['rid']); ?>%26feature%3Dshare&quot;, {'height': 650,'width': 1024,'scrollbars': true});return false;" data-service-name="PINTEREST" class="share-service-button">
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
															<div class="share-panel-embed-container" style="">
																<textarea class="yt-uix-form-textarea share-embed-code" id="embedCode" onkeydown="if ((event.ctrlKey || event.metaKey) &amp;&amp; event.keyCode == 67) { yt.tracking.track('embedCodeCopied'); }" readonly onclick="this.focus();this.select();"></textarea>
																<p class="share-embed-code-description">
																	After making your selection, copy and paste the embed code above. The code changes based on your selection.
																</p>
																<hr>
																<ul class="share-embed-options">
																	<li>
																		<label>
																		<input type="checkbox" class="share-embed-option" name="show-related" checked="">
																		Show suggested videos when the video finishes
																		</label>
																	</li>
                                                                                                                                        <li>
                                                                                                                                                <label>
                                                                                                                                                <input type="checkbox" class="share-embed-option" name="auto-play">
                                                                                                                                                Automatically start
                                                                                                                                                </label>
                                                                                                                                        </li>
																	<li>
																		<label>
																		<input type="checkbox" class="share-embed-option" name="use-https">
																		Use HTTPS
																		
																		</label>
																	</li>
																	<li>
																		<label>
																		<input type="checkbox" class="share-embed-option" name="delayed-cookies">
																		Enable privacy-enhanced mode
																		
																		</label>
																	</li>
																	<li>
																		<label>
																		<input type="checkbox" class="share-embed-option" name="use-flash-code">
																		Use old embed code
																		
																		</label>
																	</li>
																</ul>
																<hr>
										<form>
										   <ul class="share-embed-size-list">
											  <li class="share-embed-size default wide selected">
												 <label>
												 <input type="radio" name="share-embed-size" value="default" class="share-embed-size-radio " data-width="560" data-height="315">
												 <span class="share-embed-size-name">560 × 315</span>
												 <span class="share-embed-size-box default"></span>
												 </label>
											  </li>
											  <li class="share-embed-size medium wide">
												 <label>
												 <input type="radio" name="share-embed-size" value="medium" class="share-embed-size-radio " data-width="640" data-height="360">
												 <span class="share-embed-size-name">640 × 360</span>
												 <span class="share-embed-size-box medium"></span>
												 </label>
											  </li>
											  <li class="share-embed-size large wide">
												 <label>
												 <input type="radio" name="share-embed-size" value="large" class="share-embed-size-radio " data-width="853" data-height="480">
												 <span class="share-embed-size-name">853 × 480</span>
												 <span class="share-embed-size-box large"></span>
												 </label>
											  </li>
											  <li class="share-embed-size hd720 wide">
												 <label>
												 <input type="radio" name="share-embed-size" value="hd720" class="share-embed-size-radio  hd" data-width="1280" data-height="720">
												 <span class="share-embed-size-name">1280 × 720</span>
												 <span class="share-embed-size-box hd720"></span>
												 </label>
											  </li>
											  <li class="share-embed-size custom">
												 <label>
												 <input type="radio" name="share-embed-size" value="custom" class="share-embed-size-radio share-embed-size-radio-custom" data-width="-1" data-height="-1">
												 <span class="share-embed-size-name">
												 Custom
												 </span>
												 </label>
												 <ul class="share-embed-customize">
													<li>
													   <label>
													   Width:
													   <input type="text" class="yt-uix-form-input-text share-embed-size-custom-width" maxlength="4"> px
													   </label>
													</li>
													<li>
													   <label>
													   Height:
													   <input type="text" class="yt-uix-form-input-text share-embed-size-custom-height" maxlength="4"> px
													   </label>
													</li>
												 </ul>
											  </li>
										   </ul>
										</form>
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
												<div id="watch-actions-share-panel" class="hid"></div>

							<script>
								function generateEmbedCode() {
									var protocol = $('input[name="use-https"]')[0].checked ? "https://" : "http://";
                                                                        var autoPlayVideo = $('input[name="auto-play"]')[0].checked ? "?autoplay=1" : "";
									var embedCode = '<iframe src="' + protocol + videoURL + autoPlayVideo + '" width="' + embedWidth + '" height="' + embedHeight + '" allowfullscreen="true" frameborder="0"></iframe>';
									
									document.getElementById('embedCode').value = embedCode;
								}

								var videoURL = "wrappertube.org/embed/<?php echo htmlspecialchars($_video['rid']); ?>";
								var embedWidth = 560;
								var embedHeight = 315;

										
										$('input[name="use-https"]').on('change', function () {
											generateEmbedCode();
										});

                                                                                $('input[name="auto-play"]').on('change', function () {
                                                                                        generateEmbedCode();
                                                                                });
										
										$('input[name="share-embed-size"]').on('change', function () {
										if (this.value === "custom") {
											embedWidth = parseInt($('.share-embed-size-custom-width')[0].value) || 0;
											embedHeight = parseInt($('.share-embed-size-custom-height')[0].value) || 0;
										} else {
											embedWidth = parseInt($(this).data('width')) || 0;
											embedHeight = parseInt($(this).data('height')) || 0;
										}
										generateEmbedCode();
										});
										
										$('.share-embed-size-list li').on('click', function () {
											$('.share-embed-size-list li').removeClass('selected');
											$(this).addClass('selected');
										});
										
										$('.share-embed-size-custom-width').on('input', function () {
											embedWidth = parseInt(this.value) || 0;
											generateEmbedCode();
										});
										$('.share-embed-size-custom-height').on('input', function () {
											embedHeight = parseInt(this.value) || 0;
											generateEmbedCode();
										});
										$(document).ready(function() {
											generateEmbedCode();
										});
							</script>
											</div>
											<div id="watch-actions-ajax" class="watch-actions-panel hid"></div>
											<div class="close">
												<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="close-button" onclick="yt.www.watch.actions.hide();">
											</div>
										</div>
									</div>
									<div id="watch-info">
										<div id="watch-description" class="yt-uix-expander  yt-uix-expander-collapsed" data-expander-action="yt.www.watch.watch5.handleToggleDescription">
											<div id="watch-description-clip">
												<p id="watch-uploader-info">
													Published on <span id="eow-date" class="watch-video-date"><?php echo date("M d, Y", strtotime($_video['publish'])); ?></span> by     <a href="/user/<?php echo htmlspecialchars($_video['author']); ?>" class="yt-uix-sessionlink yt-user-name author" rel="author" data-sessionlink="<?php echo htmlspecialchars($_video['author']); ?>" dir="ltr"<?php if(isset($banned)) { ?> style="text-decoration:line-through;color:grey;"<?php } ?>><?php echo htmlspecialchars($_video['author']); ?></a><?php if($__user_h->if_admin($_video['author'])) { ?><span style="color:red;"> ## Admin</span><?php } ?><?php if($__user_h->if_moderator($_video['author'])) { ?><span style="color:red;"> ## Mod</span><?php } ?><?php if($__user_h->if_partner($_video['author'])) { ?> <img height="16" title="This user is trusted" src="/yt/imgbin/RenderedImage.png"><?php } ?>
												</p>
                                                                                                <p id="watch-uploader-info">
                                                                                                        Last modified on <span id="eow-date" class="watch-video-date"><?php echo date("M d, Y", strtotime($_video['last_modified'])); ?></span>
                                                                                                </p>
												<div id="watch-description-text">
													<p id="eow-description"><?php echo $__video_h->shorten_description($_video['description'], 999999, true); ?></p>
												</div>
												<div id="watch-description-extras">
													<h4>
														Category:
													</h4>
													<p id="eow-category"><a href="/videos?c=<?php echo urlencode($_video['category']); ?>"><?php echo htmlspecialchars($_video['category']); ?></a></p>
													<h4>Tags:</h4>
													<p id="eow-tags">
														<?php
														    foreach ($video_tags as $video_tag) {
                                                                                                                    if (!empty(trim($video_tag))) {
														?>
														    <a href="/search_query?q=<?php echo urlencode(trim($video_tag)); ?>" style="margin-right:1.0em;"><?php echo htmlspecialchars(trim($video_tag)); ?></a>
														<?php
                                                                                                                    }
														    }
														 ?>
													</p>
												</div>
											</div>
											<ul id="watch-description-extra-info">
												<li>
<div style="background-color: white;padding: 1px;border-radius: 3px;display:inline-block;">
														                    <a href="javascript:void(0);" onclick="rate(1);return false;"><img id="star_1" src="/static/img/<?php echo ($_video['star_ratio']>=1)?'full':(($_video['star_ratio']>=0.5)?'half':'empty'); ?>_star.png"></a>
                    <a href="javascript:void(0);" onclick="rate(2);return false;"><img id="star_2" src="/static/img/<?php echo ($_video['star_ratio']>=2)?'full':(($_video['star_ratio']>=1.5)?'half':'empty'); ?>_star.png"></a>
                    <a href="javascript:void(0);" onclick="rate(3);return false;"><img id="star_3" src="/static/img/<?php echo ($_video['star_ratio']>=3)?'full':(($_video['star_ratio']>=2.5)?'half':'empty'); ?>_star.png"></a>
                    <a href="javascript:void(0);" onclick="rate(4);return false;"><img id="star_4" src="/static/img/<?php echo ($_video['star_ratio']>=4)?'full':(($_video['star_ratio']>=3.5)?'half':'empty'); ?>_star.png"></a>
                    <a href="javascript:void(0);" onclick="rate(5);return false;"><img id="star_5" src="/static/img/<?php echo ($_video['star_ratio']>=5)?'full':(($_video['star_ratio']>=4.5)?'half':'empty'); ?>_star.png"></a>
</div>
													<span id="ratetext"><?php echo $_video['stars']; ?> ratings</span>
												</li>
											</ul>
											<div class="yt-horizontal-rule "><span class="first"></span><span class="second"></span><span class="third"></span></div>
											<div id="watch-description-toggle" class="yt-uix-expander-head">
												<div id="watch-description-expand" class="expand">
													<button type="button" class="metadata-inline yt-uix-button yt-uix-button-text" onclick=";return false;" role="button"><span class="yt-uix-button-content">Show more <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Show more">
													</span></button>
												</div>
												<div id="watch-description-collapse" class="collapse">
													<button type="button" class="metadata-inline yt-uix-button yt-uix-button-text" onclick=";return false;" role="button"><span class="yt-uix-button-content">Show less <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Show less">
													</span></button>
												</div>
											</div>
										</div>
									</div>
									<div id="watch-discussion">
										<div style="display: none"><iframe src="//plus.google.com/_/s/c2?first_party_property=YOUTUBE&amp;href=http%3A%2F%2Fwww.youtube.com%2Fwatch%3Fv%3D<?php echo htmlspecialchars($_video['rid']); ?>&amp;yt_owner_id=<?php echo htmlspecialchars($_video['author']); ?>"></iframe></div>
										<div id="comments-view" data-type="highlights" class="">
											<div id="comment-share-area" class="comment-share-area yt-rounded hid">
												<div class="comment-share-content">
													<h4>Link to this comment:</h4>
													<div style="visibility: hidden;">
														<input type="text" value="http://wrappertube.org/watch?v=<?php echo $_GET['v']; ?>" class="comment-share-url yt-uix-form-input-text" readonly onclick="this.focus();this.select();">
													</div>
													<div>
														<input type="text" value="http://wrappertube.org/watch?v=<?php echo $_GET['v']; ?>" class="yt-uix-form-input-text" readonly onclick="this.focus();this.select();">
													</div>
													<div>
														<span>Share to:</span>
														<img alt="" title="Facebook" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon-comment-share icon-comment-share-facebook" action="yt.window.popup('\/\/www.facebook.com\/sharer.php?u=http%3A%2F%2Fwrappertube.org%2Fwatch%3Fv%3D<?php echo $_GET['v']; ?>', {height:440, width:620, scrollbars:true});">
														<img alt="" title="Twitter" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon-comment-share icon-comment-share-twitter" action="yt.window.popup('\/\/twitter.com\/share?url=http%3A%2F%2Fwrappertube.org%2Fwatch%3Fv%3D<?php echo $_GET['v']; ?>', {height:650, width:1024, scrollbars:true});">
														<img alt="" title="Google+" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon-comment-share icon-comment-share-googleplus" action="yt.window.popup('\/\/plus.google.com\/share?url=http%3A%2F%2Fwrappertube.org%2Fwatch%3Fv%3D<?php echo $_GET['v']; ?>', {height:620, width:620, scrollbars:true});">
													</div>
												</div>
												<div class="close comment-action" data-action="close-share">
													<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="close-button">
												</div>
											</div>
											<?php 
												$stmt = $__db->prepare("SELECT * FROM group_videos WHERE video = :v ORDER BY id DESC LIMIT 6");
												$stmt->bindParam(":v", $_GET['v']);
												$stmt->execute();
											?>
											<?php if($stmt->rowCount() != 0) { ?>
												<div class="comments-section">
													<a class="comments-section-see-all" href="/video_groups_view_all?v=<?php echo htmlspecialchars($_video['rid']); ?>">
													see all
													</a>
													<h4>Groups (<?php echo $__video_h->get_groups_from_video($_GET['v']); ?>)</h4>
													<ul class="video-list">
													<?php 
														while($video = $stmt->fetch(PDO::FETCH_ASSOC)) { 
$video = $__video_h->fetch_group_id($video['toid']);
															if($video) { 
													?>
                                        <div style="width: 33%;display: inline-block;">
                                            <img style="width: 50px;height:50px;" src="/dynamic/thumbs/<?php echo $video['group_picture']; ?>">
                                            <span style="display: inline-block; vertical-align:top;width: 100px;font-size: 11px;">
                                                <b><a href="/group/<?php echo htmlspecialchars($video['id']); ?>"><?php echo htmlspecialchars($video['group_title']); ?></a></b><br>
                                                <?php echo $__video_h->fetch_group_video_count($video['id']); ?> videos<br>
                                                <?php echo $__video_h->fetch_group_playlist_count($video['id']); ?> playlists<br>
                                                <?php echo $__video_h->fetch_group_member_count($video['id']); ?> members<br>
                                            </span><br><br>
                                        </div>

													<?php } } ?>
													</ul>
												</div>
											<?php } $stmt = null; ?>
											<?php 
$videoresponding;
												$stmt = $__db->prepare("SELECT * FROM video_response WHERE toid = :v ORDER BY id DESC LIMIT 4");
												$stmt->bindParam(":v", $_GET['v']);
												$stmt->execute();

$stmtvr = $__db->prepare("SELECT * FROM video_response WHERE video = :id LIMIT 1");
$stmtvr->bindParam(":id", $_video['rid']);
$stmtvr->execute();
while($vidresp = $stmtvr->fetch(PDO::FETCH_ASSOC)) {
$videoresponding = $__video_h->fetch_video_rid($vidresp["toid"]);
}
$stmtvr = null;

											?>

											<?php if($stmt->rowCount() != 0 || $videoresponding) { ?>
												<div class="comments-section">
													<a class="comments-section-see-all" href="/video_response_view_all?v=<?php echo htmlspecialchars($_video['rid']); ?>">
													see all
													</a>
													<h4>Video Responses (<?php echo $__video_h->get_video_responses($_GET['v']); ?>)</h4>
<?php if ($videoresponding) { ?>
<div class="comments-section-description">This is a video response to <a href="/watch?v=<?php echo htmlspecialchars($videoresponding['rid']); ?>"><?php echo htmlspecialchars($videoresponding['title']); ?></a></div>
<?php } ?>
													<ul class="video-list">
													<?php 
														while($video = $stmt->fetch(PDO::FETCH_ASSOC)) { 
															if($__video_h->video_exists($video['video'])) { 
																$video = $__video_h->fetch_video_rid($video['video']);
																$video['age'] = $__time_h->time_elapsed_string($video['publish']);		
																$video['duration'] = $__time_h->timestamp($video['duration']);
																$video['views'] = $__video_h->fetch_video_views($video['rid']);
																$video['author'] = htmlspecialchars($video['author']);		
																$video['title'] = htmlspecialchars($video['title']);
																$video['description'] = $__video_h->shorten_description($video['description'], 50);
													?>
														<li class="video-list-item yt-tile-default">
															<a href="/watch?v=<?php echo $video['rid']; ?>" class="related-video yt-uix-contextlink  yt-uix-sessionlink" data-sessionlink="<?php echo htmlspecialchars($_video['author']); ?>&amp;feature=watch_response"><span class="ux-thumb-wrap contains-addto "><span class="video-thumb ux-thumb yt-thumb-default-120 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="<?php echo $video['title']; ?>" data-thumb="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" width="120"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $video['duration']; ?></span>
															<button onclick=";return false;" title="Watch Later" type="button" class="addto-button video-actions spf-nolink addto-watch-later-button yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" data-video-ids="<?php echo $video['rid']; ?>" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
															</span><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></button>
															</span><span dir="ltr" class="title" title="<?php echo $video['title']; ?>"><?php echo $video['title']; ?></span><span class="stat attribution">by <span class="yt-user-name " dir="ltr"><?php echo $video['author']; ?></span></span><span class="stat view-count"><?php echo $video['views']; ?> views</span></a>
														</li>
													<?php } } ?>
													</ul>
												</div>
											<?php } ?>
											<div class="comments-section " onmouseover="if (yt.www &amp;&amp; yt.www.watch &amp;&amp; yt.www.watch.livecomments) yt.www.watch.livecomments.handleCommentMouseEvent(this, event);" onmouseout="if (yt.www &amp;&amp; yt.www.watch &amp;&amp; yt.www.watch.livecomments) yt.www.watch.livecomments.handleCommentMouseEvent(this, event);">
												<div id="comments-header-container">
													<div id="comments-header">
														<h4>
															All Comments
															<span class="comments-section-stat">(<?php echo $_video['comments']; ?>)</span>
														</h4>
													</div>
												</div>
												<?php if(!isset($_SESSION['siteusername'])) { ?>
													<div class="comments-post-container clearfix">
														<div class="comments-post-alert">
															<a href="/sign_in">Sign In</a> or <a href="/sign_up">Sign Up</a><span class="comments-post-form-rollover-text"> now to post a comment!</span>
														</div>
													</div>
												<?php } else if($_video['commenting'] == "d") { ?>
													<div class="comments-disabled-message">
														<img src="//s.ytimg.com/yt/img/icon_comments_disabled-vflxokpZC.png">
														<span>Adding comments has been disabled for this video.</span>
													</div>
												<?php } else if($__user_h->if_blocked($_video['author'], $_SESSION['siteusername'])) { ?>
													<div class="comments-post-container clearfix">
														<div class="comments-post-alert">
															This user has blocked you!
														</div>
													</div>
												<?php } else { ?>
													<div class="comments-post-container clearfix">
														<form method="post" action="/comment_service_ajax">
															<div class="yt-alert yt-alert-default yt-alert-error hid comments-post-message">
																<div class="yt-alert-icon">
																	<img class="icon master-sprite" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" width="32px" height="35px">
																</div>
																<div class="yt-alert-buttons"></div>
																<div class="yt-alert-content" role="alert"></div>
															</div>
															<input type="hidden" name="form_id" value="">
															<input type="hidden" name="source" value="w">
															<input type="hidden" value="" name="reply_parent_id">
															<a href="/user/<?php echo htmlspecialchars($_SESSION['siteusername']); ?>" class="yt-user-photo comments-post-profile"><span class="video-thumb ux-thumb yt-thumb-square-46 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="/dynamic/pfp/<?php echo $__user_h->fetch_pfp($_SESSION['siteusername']); ?>" alt="<?php echo htmlspecialchars($_SESSION['siteusername']); ?>" width="46"><span class="vertical-align"></span></span></span></span></a>
															<div class="comments-textarea-container" onclick="yt.www.comments.initForm(this, true, false);">
																<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="" class="comments-textarea-tip"><label class="comments-textarea-label" data-upsell="comment">Respond to this video...</label>  
																<div class="yt-uix-form-input yt-grid ">
																	<textarea id="comment-area" class="yt-uix-form-textarea comments-textarea" onfocus="yt.www.comments.initForm(this, false, false);" data-upsell="comment" name="comment"></textarea><br>
<div class="kaomoji">
<select onchange="insertThisInThere(this.value,'comment-area');this.selectedIndex=0;">
  <option value="" disabled selected>--Kaomoji--</option>
  <option value="ｷﾀ━━━(ﾟ∀ﾟ)━━━!!">ｷﾀ━━━(ﾟ∀ﾟ)━━━!!</option>
  <option value="(;´Д`)">(;´Д`)</option>
  <option value="ヽ(´∇`)ノ">ヽ(´∇`)ノ</option>
  <option value="(´ー`)">(´ー`)</option>
  <option value="( ´ー｀)y-~~">( ´ー｀)y-~~</option>
  <option value="（ ’～’）">（ ’～’）</option>
  <option value="ヽ(`Д´)ノ">ヽ(`Д´)ノ</option>
  <option value="( ´ω`)">( ´ω`)</option>
  <option value="(・∀・)">(・∀・)</option>
  <option value="(´・ω・｀)">(´・ω・｀)</option>
  <option value="( ´,_ゝ｀)">( ´,_ゝ｀)</option>
  <option value="Σ(;ﾟДﾟ)">Σ(;ﾟДﾟ)</option>
  <option value="(;｀Д´)">(;｀Д´)</option>
  <option value="( ﾟ ヮﾟ) Mittens!">( ﾟ ヮﾟ)</option>
  <option value="^°^">^°^</option>
  <option value="=^..^=">=^..^=</option>
  <option value="^v^">^v^</option>
  <option value="VvV">VvV</option>
  <option value="UwU">UwU</option>
  <option value="( ° _ ° )">( ° _ ° )</option>
  <option value="&gt;v^">&gt;v^</option>
  <option value="^_&lt;">^_&lt;</option>
  <option value="&gt_^">&gt;_^</option>
  <option value="^v&lt;">^v&lt;</option>
  <option value="( &gt; v &lt; )">( &gt; v &lt; )</option>
  <option value="&gt;v&lt;">&gt;v&lt;</option>
</select>
</div>
																</div>
<?php if (!$__user_h->if_partner($_SESSION['siteusername'])) { ?>
																<script src="/captcha/captcha.js"></script>
<?php } ?>
															</div>
															<p class="comments-remaining">
																<span class="comments-remaining-count" data-max-count="500"></span> characters remaining
															</p>
															<p class="comments-threshold-countdown hid">
																<span class="comments-threshold-count"></span> seconds remaining before you can post
															</p>
															<p class="comments-post-buttons">
																<span class="comments-post-video-response-link"><a href="/add_video_response?v=<?php echo $_GET['v']; ?>">Create a video response</a>&nbsp;or&nbsp;</span><button type="submit" class="comments-post yt-uix-button yt-uix-button-default" role="button"><span class="yt-uix-button-content">Post </span></button>    
															</p>
														</form>
													</div>
												<?php } ?><br>
												<div id="live-comments-setting-scroll" class="live-comments-setting hid">
													<span id="live-comments-count"></span>
													<a onclick="yt.www.watch.livecomments.setScroll(true); return false;">Update automatically</a>
												</div>
												<div id="live-comments-setting-no-scroll" class="live-comments-setting hid">
													<a onclick="yt.www.watch.livecomments.setScroll(false); return false;">Disable automatic updates</a>
												</div>
												<ul class="comment-list" id="live_comments">
														<?php
														$results_per_page = 20;

														$stmt = $__db->prepare("SELECT count(*) FROM comments WHERE toid = :rid");
														$stmt->bindParam(":rid", $_video['rid']);
														$stmt->execute();
														$number_of_result = (int)$stmt->fetchColumn();
														$stmt = null;

														$number_of_page = ceil ($number_of_result / $results_per_page);  

														if (!isset ($_GET['page']) ) {  
															$page = 1;  
														} else {  
															$page = (int)$_GET['page'];  
														}  

														$page_first_result = ($page - 1) * $results_per_page;  

														$stmt = $__db->prepare("SELECT * FROM comments WHERE toid = :rid ORDER BY id DESC LIMIT :pfirst, :pper");
														$stmt->bindParam(":rid", $_video['rid']);
														$stmt->bindParam(":pfirst", $page_first_result);
														$stmt->bindParam(":pper", $results_per_page);
														$stmt->execute();

														while($comment = $stmt->fetch(PDO::FETCH_ASSOC)) { 
															if($__video_h->if_comment_liked($_SESSION['siteusername'], $comment['id'], true))
																$comment['liked'] = true;
															else if($__video_h->if_comment_liked($_SESSION['siteusername'], $comment['id'], false))
																$comment['disliked'] = true;
																
															$comment['likes']  = $__video_h->get_comment_likes($comment['id'], true);
															$comment['likes'] -= $__video_h->get_comment_likes($comment['id'], false);
													?>

														<li class="comment yt-tile-default <?php if($comment['liked']){ ?>voted-up<?php }else if($comment['disliked']){ ?>voted-down<?php } ?>" data-author-viewing="" id="comment_<?php echo $comment['id']; ?>" data-author-id="-uD01K8FQTeOSS5sniRFzQ" data-id="<?php echo $comment['id']; ?>" data-score="<?php echo $comment['likes']; ?>" <?php if($comment['liked']){ ?>data-voted="1"<?php }else if($comment['disliked']){ ?>data-voted="-1"<?php } ?>>
															<div class="comment-body">
																<div class="content-container">
																	<div class="content">
																		<div class="comment-text" dir="ltr">
																			<p><?php echo $__video_h->shorten_description($comment['comment'], 999999, true); ?></p>
																		</div>
																		<p class="metadata">
																			<span class="author ">
																			<a href="/user/<?php echo htmlspecialchars($comment['author']); ?>" class="yt-uix-sessionlink yt-user-name " data-sessionlink="<?php echo htmlspecialchars($comment['author']); ?>" dir="ltr"><?php echo htmlspecialchars($comment['author']); ?></a>
																			</span>
																			<span class="time" dir="ltr">
																			<span dir="ltr"><?php echo $__time_h->time_elapsed_string($comment['date']); ?><span>
																			</span>
																			</span></span>
																			<?php if($comment['likes'] != 0) { ?>
																				<?php if($comment['likes'] < 0) { ?>
																				<span dir="ltr" class="comments-rating-positive" title="<?php echo $__video_h->get_comment_likes($comment['id'], true); ?> up, <?php echo $__video_h->get_comment_likes($comment['id'], false); ?> down" style="color:#c16a6a;">
																					<?php echo abs($comment['likes']); ?>
																					<img src="/yt/imgbin/dislike.png">
																				</span>
																				<?php } else { ?>
																				<span dir="ltr" class="comments-rating-positive" title="<?php echo $__video_h->get_comment_likes($comment['id'], true); ?> up, <?php echo $__video_h->get_comment_likes($comment['id'], false); ?> down">
																					<?php echo $comment['likes']; ?>
																					<img class="comments-rating-thumbs-up" src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif">
																				</span>
																				<?php } ?>
																			<?php } ?>
																		</p>
																	</div>
																	<div class="comment-actions">
																		<span class="yt-uix-button-group"><button type="button" class="start comment-action-vote-up comment-action yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" onclick=";return false;" title="Vote Up" data-action="vote-up" data-tooltip-show-delay="300" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-watch-comment-vote-up" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Vote Up"><span class="yt-valign-trick"></span></span></button><button type="button" class="end comment-action-vote-down comment-action yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" onclick=";return false;" title="Vote Down" data-action="vote-down" data-tooltip-show-delay="300" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-watch-comment-vote-down" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Vote Down"><span class="yt-valign-trick"></span></span></button></span>
																		<span class="yt-uix-button-group">
																			<button type="button" 
																					class="start comment-action yt-uix-button yt-uix-button-default" 
																					onclick=";$('#reply_to_<?php echo $comment['id']; ?>').show();return false;" data-action="reply" role="button"><span class="yt-uix-button-content">Reply</span>
																			</button><button type="button" class="end flip yt-uix-button yt-uix-button-default yt-uix-button-empty" onclick=";return false;" data-button-has-sibling-menu="true" role="button" aria-pressed="false" aria-expanded="false" aria-haspopup="true" aria-activedescendant="">
																				<img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
																				<div class=" yt-uix-button-menu yt-uix-button-menu-default" style="display: none;">
																					<ul>
																						<li class="comment-action" data-action="share"><span class="yt-uix-button-menu-item">Share</span></li>
                                            <?php if(isset($_SESSION['siteusername']) && $_SESSION['siteusername'] == $_video['author']) { ?>
                                               																						
<li class="comment-action" data-action="null"><a href="javascript:void(0);" onclick="delete_comment('<?php echo $comment['id'];?>');return false;"><span class="yt-uix-button-menu-item">Remove</span></a></li>
<?php } ?>
																						<li class="comment-action" data-action="flag"><span class="yt-uix-button-menu-item">Flag for spam</span></li>
																						<li class="comment-action-block comment-action" data-action="block"><span class="yt-uix-button-menu-item">Block User</span></li>
																						<li class="comment-action-unblock comment-action" data-action="unblock"><span class="yt-uix-button-menu-item">Unblock User</span></li>
																					</ul>
																				</div>
																			</button>
																		</span>
																	</div>
																<?php if(isset($_SESSION['siteusername'])) { ?> 
																	<li id="reply_to_<?php echo $comment['id']; ?>" style="display: none;" class="comment yt-tile-default  child" data-tag="O" data-author-viewing="" data-id="iRV7EkT9us81mDLFDSB6FAsB156Fdn13HUmTm26C3PE" data-score="34" data-author="<?php echo htmlspecialchars($row['author']); ?>">

																	<div class="comment-body">
																		<div class="content-container">
																		<div class="content">
																			<div class="comment-text" dir="ltr">
																			<form method="post" action="/d/reply?id=<?php echo $comment['id']; ?>&v=<?php echo $_GET['v']; ?>" id="reply_form_<?php echo $comment['id']; ?>" onsubmit="reply_to_comment('<?php echo $comment['id']; ?>');return false;">
																				<img style="width: 50px;" src="">
																				<textarea style="padding:5px;border-radius:5px;background-color:white;border: 1px solid #d3d3d3; width: 577px;"cols="32" id="com<?php echo $comment['id'] ?>" placeholder="Share your thoughts" name="comment"></textarea><br>
<select onchange="insertThisInThere(this.value,'com<?php echo $comment['id'] ?>');this.selectedIndex=0;">
  <option value="" disabled selected>--Kaomoji--</option>
  <option value="ｷﾀ━━━(ﾟ∀ﾟ)━━━!!">ｷﾀ━━━(ﾟ∀ﾟ)━━━!!</option>
  <option value="(;´Д`)">(;´Д`)</option>
  <option value="ヽ(´∇`)ノ">ヽ(´∇`)ノ</option>
  <option value="(´ー`)">(´ー`)</option>
  <option value="( ´ー｀)y-~~">( ´ー｀)y-~~</option>
  <option value="（ ’～’）">（ ’～’）</option>
  <option value="ヽ(`Д´)ノ">ヽ(`Д´)ノ</option>
  <option value="( ´ω`)">( ´ω`)</option>
  <option value="(・∀・)">(・∀・)</option>
  <option value="(´・ω・｀)">(´・ω・｀)</option>
  <option value="( ´,_ゝ｀)">( ´,_ゝ｀)</option>
  <option value="Σ(;ﾟДﾟ)">Σ(;ﾟДﾟ)</option>
  <option value="(;｀Д´)">(;｀Д´)</option>
  <option value="( ﾟ ヮﾟ) Mittens!">( ﾟ ヮﾟ)</option>
  <option value="^°^">^°^</option>
  <option value="=^..^=">=^..^=</option>
  <option value="^v^">^v^</option>
  <option value="VvV">VvV</option>
  <option value="UwU">UwU</option>
  <option value="( ° _ ° )">( ° _ ° )</option>
  <option value="&gt;v^">&gt;v^</option>
  <option value="^_&lt;">^_&lt;</option>
  <option value="&gt_^">&gt;_^</option>
  <option value="^v&lt;">^v&lt;</option>
  <option value="( &gt; v &lt; )">( &gt; v &lt; )</option>
  <option value="&gt;v&lt;">&gt;v&lt;</option>
</select>
<br><br>
																				<input style="float: none; margin-right: 0px; margin-top: 0px;" class="yt-uix-button yt-uix-button-default" type="submit" value="Reply" name="replysubmit">
																				<input style="display: none;" name="id" value="<?php echo $row['id']; ?>">
																				
																			</form>
																		</div>
																	</div>
																<?php } ?>
																</div>
															</div>
														</li>
														<span id="replies_to_<?php echo $comment['id']; ?>">
														<?php 
															$stmt2 = $__db->prepare("SELECT * FROM comment_reply WHERE toid = :rid");
															$stmt2->bindParam(":rid", $comment['id']);
															$stmt2->execute();

															while($reply = $stmt2->fetch(PDO::FETCH_ASSOC)) { 
														?>
															<li class="comment yt-tile-default " style="margin-left: 30px;" data-author-viewing="" data-author-id="-uD01K8FQTeOSS5sniRFzQ" data-id="<?php echo $reply['id']; ?>" data-score="0" id="comment_reply_<?php echo $reply['id']; ?>">
																<div class="comment-body">
																	<div class="content-container">
																		<div class="content">
																			<div class="comment-text" dir="ltr">
																				<p><?php echo $__video_h->shorten_description($reply['comment'], 999999, true); ?></p>
																			</div>
																			<p class="metadata">
																				<span class="author ">
																				<a href="/user/<?php echo htmlspecialchars($reply['author']); ?>" class="yt-uix-sessionlink yt-user-name " data-sessionlink="<?php echo htmlspecialchars($reply['author']); ?>" dir="ltr"><?php echo htmlspecialchars($reply['author']); ?></a>
																				</span>
																				<span class="time" dir="ltr">
																				<span dir="ltr"><?php echo $__time_h->time_elapsed_string($reply['date']); ?><span>
																				</span>
																				</span></span>
																			</p>
																		</div>
																		<div class="comment-actions">
																			<span class="yt-uix-button-group"><button type="button" class="start comment-action-vote-up comment-action yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" onclick=";return false;" title="Vote Up" data-action="vote-up" data-tooltip-show-delay="300" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-watch-comment-vote-up" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Vote Up"><span class="yt-valign-trick"></span></span></button><button type="button" class="end comment-action-vote-down comment-action yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" onclick=";return false;" title="Vote Down" data-action="vote-down" data-tooltip-show-delay="300" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-watch-comment-vote-down" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Vote Down"><span class="yt-valign-trick"></span></span></button></span>
																			<span class="yt-uix-button-group">
																				<button type="button" 
																						class="start comment-action yt-uix-button yt-uix-button-default" 
																						onclick=";$('#reply_to_<?php echo $comment['id']; ?>').show();return false;" data-action="reply" role="button"><span class="yt-uix-button-content">Reply</span>
																				</button><button type="button" class="end flip yt-uix-button yt-uix-button-default yt-uix-button-empty" onclick=";return false;" data-button-has-sibling-menu="true" role="button" aria-pressed="false" aria-expanded="false" aria-haspopup="true" aria-activedescendant="">
																					<img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
																					<div class=" yt-uix-button-menu yt-uix-button-menu-default" style="display: none;">
																						<ul>
																							<li class="comment-action" data-action="share"><span class="yt-uix-button-menu-item">Share</span></li>
                                            <?php if(isset($_SESSION['siteusername']) && $_SESSION['siteusername'] == $_video['author']) { ?>

<li class="comment-action" data-action="null"><a href="javascript:void(0);" onclick="delete_reply('<?php echo $reply['id'];?>');return false;"><span class="yt-uix-button-menu-item">Remove</span></a></li>
<?php } ?>
																							<li class="comment-action" data-action="flag"><span class="yt-uix-button-menu-item">Flag for spam</span></li>
																							<li class="comment-action-block comment-action" data-action="block"><span class="yt-uix-button-menu-item">Block User</span></li>
																							<li class="comment-action-unblock comment-action" data-action="unblock"><span class="yt-uix-button-menu-item">Unblock User</span></li>
																						</ul>
																					</div>
																				</button>
																			</span>
																		</div>
																	</div>
																</div>
															</li>
														<?php } $stmt2 = null; ?>
														</span>
													<?php } $stmt = null; ?>
												</ul>
											</div>
											<div class="comments-section">
												
												<div class="comments-pagination" data-ajax-enabled="true">
													<div class="yt-uix-pager" role="navigation">
                  <?php 
                                                                                                                if (!isset ($_GET['page']) ) {
                                                                                                                        $curpage = 1;
                                                                                                                } else {
                                                                                                                        $curpage = (int)$_GET['page'];
                                                                                                                }
?>
<?php if ($curpage > 1) { ?>
<a href="/watch?v=<?php echo $_GET['v']; ?>&amp;page=<?php echo $curpage - 1; ?>" class="yt-uix-button yt-uix-sessionlink yt-uix-pager-prev yt-uix-pager-button yt-uix-button-default" data-page="<?php echo $curpage - 1; ?>">
                        <span class="yt-uix-button-content">« Prev</span>
                     </a>
<?php } ?>
<?php for($page = 1; $page<= $number_of_page; $page++) { ?>
<a href="/watch?v=<?php echo $_GET['v']; ?>&amp;page=<?php echo $page; ?>" class="yt-uix-button yt-uix-sessionlink yt-uix-pager-page-num yt-uix-pager-button <?php if($curpage==$page){ ?>yt-uix-button-toggled<?php } ?> yt-uix-button-default" data-sessionlink="" data-page="<?php echo $page; ?>" aria-label="Go to page <?php echo $page; ?>"><span class="yt-uix-button-content"><strong><?php echo $page; ?></strong></span></a>
                  <?php } ?>
<?php if ($curpage < $number_of_page) { ?>
<a href="/watch?v=<?php echo $_GET['v']; ?>&amp;page=<?php echo $curpage + 1; ?>" class="yt-uix-button yt-uix-sessionlink yt-uix-pager-next yt-uix-pager-button yt-uix-button-default" data-page="<?php echo $curpage + 1; ?>">
                        <span class="yt-uix-button-content">Next »</span>
                     </a>
<?php } ?>
													</div>
												</div>
														
											</div>
											<ul>
												<li class="hid" id="parent-comment-loading"> Loading comment...</li>
											</ul>
											<div id="comments-loading" class="hid"><img src="/static/img/loadingg.gif"> Loading...</div>
										</div>
									</div>
								</div>
								<div id="watch-sidebar">
									<div class="watch-sidebar-section">
										<button type="button" class="collapsible" id="more-from-button"><img class="www-right-arrow" id="arrow_more">More From: <?php echo htmlspecialchars($_video['author']); ?></button>
										<div id="watch-more-from-container" class="watch-sidebar-body">
											<ul id="watch-more-more-from" class="video-list">
											<p class="yt-spinner">
											<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="yt-spinner-img" alt="">
											Loading...
											</p>
											</ul>
										</div>
										<button type="button" class="collapsible"><img class="www-right-arrow" id="arrow_more">Related Videos</button>
										<div id="watch-related-container" class="watch-sidebar-body" style="display: block;">
											<ul id="watch-related" class="video-list">
												<?php
													$stmt = $__db->prepare("SELECT * FROM playlists WHERE visibility = 'n' ORDER BY rand() LIMIT 2");
													$stmt->execute();
													while($_playlist = $stmt->fetch(PDO::FETCH_ASSOC)) {	
														$_playlist['videos'] = json_decode($_playlist['videos']);
                                                                    $_playlist['count'] = count($_playlist['videos']);
                                                                    $_playlist['videos'] = array_slice($_playlist['videos'], 0, 4);
                                                                    $playlist_thumbs = [];
                                                                    foreach ($_playlist['videos'] as $vid) {
                                                                     if($__video_h->video_exists($vid)) {
                                                                     $video = $__video_h->fetch_video_rid($vid);
                                                                     $playlist_thumbs[] = $video['thumbnail'];
                                                                     } else {
                                                                      $playlist_thumbs[] = "default.jpg";
                                                                     }
                                                                    }

												?>
												<li class="video-list-item">
													<a href="/view_playlist?v=<?php echo $_playlist['rid']; ?>" class="related-playlist yt-uix-contextlink  yt-uix-sessionlink" data-sessionlink="ved=CAMQzhooAA%3D%3D&amp;ei=CKf4md_r7rMCFYMfRAodLGlRiA%3D%3D&amp;feature=list_other">
														<span class="ux-thumb-wrap">
															<span class="video-thumb ux-thumb yt-thumb-default-120 ">
																<span class="yt-thumb-clip">
																	<span class="yt-thumb-clip-inner">
																		<img src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="<?php echo htmlspecialchars($_playlist['title']); ?>" data-thumb="/dynamic/thumbs/<?php echo $playlist_thumbs[0] ?? 'default.jpg'; ?>" width="120">
																		<span class="vertical-align"></span>
																	</span>
																</span>
															</span>
															<span class="video-count">
																<strong><?php echo $_playlist['count']; ?></strong> videos </span>
														</span>
														<span class="thumb-row">
															<span class="video-thumb ux-thumb yt-thumb-default-40 ">
																<span class="yt-thumb-clip">
																	<span class="yt-thumb-clip-inner">
																		<img src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="Thumbnail" data-thumb="/dynamic/thumbs/<?php echo $playlist_thumbs[1] ?? 'default.jpg'; ?>" width="40">
																		<span class="vertical-align"></span>
																	</span>
																</span>
															</span>
															<span class="video-thumb ux-thumb yt-thumb-default-40 "> 
																<span class="yt-thumb-clip">
																	<span class="yt-thumb-clip-inner">
																		<img src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="Thumbnail" data-thumb="/dynamic/thumbs/<?php echo $playlist_thumbs[2] ?? 'default.jpg'; ?>" width="40">
																		<span class="vertical-align"></span>
																	</span>
																</span>
															</span>
															<span class="video-thumb ux-thumb yt-thumb-default-40 ">
																<span class="yt-thumb-clip">
																	<span class="yt-thumb-clip-inner">
																		<img src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="Thumbnail" data-thumb="/dynamic/thumbs/<?php echo $playlist_thumbs[3] ?? 'default.jpg'; ?>" width="40">
																		<span class="vertical-align"></span>
																	</span>
																</span>
															</span>
														</span>
														<span dir="ltr" class="title" title="<?php echo htmlspecialchars($_playlist['title']); ?>"><?php echo htmlspecialchars($_playlist['title']); ?></span>
													</a>
												</li>
												<?php } $stmt = null; ?>
												<div id="ppv-container" class="hid"></div>
												<?php
													$stmt = $__db->prepare("SELECT * FROM videos WHERE visibility = 'n' ORDER BY rand() LIMIT 20");
													$stmt->execute();
													while($video = $stmt->fetch(PDO::FETCH_ASSOC)) {	
														$video['age'] = $__time_h->time_elapsed_string($video['publish']);		
														$video['duration'] = $__time_h->timestamp($video['duration']);
														$video['views'] = $__video_h->fetch_video_views($video['rid']);
														$video['author'] = htmlspecialchars($video['author']);		
														$video['title'] = htmlspecialchars($video['title']);
														$video['description'] = $__video_h->shorten_description($video['description'], 50);
												?>
												<li class="video-list-item"><a href="/watch?v=<?php echo $video['rid']; ?>" class="related-video yt-uix-contextlink  yt-uix-sessionlink" data-sessionlink="ved=CAIQzRooAA%3D%3D&amp;<?php echo htmlspecialchars($_video['author']); ?>&amp;feature=relmfu"><span class="ux-thumb-wrap contains-addto "><span class="video-thumb ux-thumb yt-thumb-default-120 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="<?php echo $video['title']; ?>" onerror=";this.src='/dynamic/thumbs/default.jpg';" data-thumb="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" width="120"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $video['duration']; ?></span>
													<button onclick=";return false;" title="Watch Later" type="button" class="addto-button video-actions spf-nolink addto-watch-later-button yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" data-video-ids="<?php echo $video['rid']; ?>" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
													</span><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></button>
													</span><span dir="ltr" class="title" title="<?php echo $video['title']; ?>"><?php echo $video['title']; ?></span><span class="stat attribution">by <span class="yt-user-name " dir="ltr"><?php echo htmlspecialchars($video['author']); ?></span></span><span class="stat view-count"><?php echo $video['views']; ?> views</span></a>
												</li>
												<?php } $stmt = null; ?>
											</ul>
											<ul id="watch-more-related" class="video-list hid">
											<p class="yt-spinner">
											<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="yt-spinner-img" alt="">
											Loading...
											</p>
											</ul>
										</div>
									</div>
									<span class="yt-vertical-rule-main"></span>
									<span class="yt-vertical-rule-corner-top"></span>
									<span class="yt-vertical-rule-corner-bottom"></span>
								</div>
								<div class="clear"></div>
							</div>
							<div style="visibility: hidden; height: 0px; padding: 0px; overflow: hidden;">
								<img src="//www.youtube-nocookie.com/gen_204?attributionpartner=machinima" width="1" height="1" border="0">
							</div>
						</div>
						<!-- end watch-main-container -->
					</div>
				</div>
				<!-- end content -->
			</div>
			<div id="footer-container"><?php require($_SERVER['DOCUMENT_ROOT'] . "/s/mod/footer.php") ?></div>
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
									<li class="empty playlist-bar-help-message">Your queue is empty. Add videos to your queue using this button: <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="addto-button-help"><br> or <a href="//accounts.google.com/ServiceLogin?passive=true&amp;continue=http%3A%2F%2Fwww.youtube.com%2Fsignin%3Faction_handle_signin%3Dtrue%26feature%3Dplaylist%26nomobiletemp%3D1%26hl%3Den_US%26next%3D%252Fwatch%253Fv%253D<?php echo htmlspecialchars($_video['rid']); ?>%2526feature%253Dg-logo-xit&amp;uilel=3&amp;hl=en_US&amp;service=youtube">sign in</a> to load a different list.</li>
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
						<!--<li class="playlist-bar-item yt-uix-slider-slide-unit __classes__" data-video-id="__video_encrypted_id__"><a href="__video_url__" title="__video_title__" class="yt-uix-sessionlink" data-sessionlink="<?php echo htmlspecialchars($_video['author']); ?>&amp;feature=BFa"><span class="video-thumb ux-thumb yt-thumb-default-106 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="__video_title__" data-thumb-manual="true" data-thumb="__video_thumb_url__" width="106" ><span class="vertical-align"></span></span></span></span><span class="screen"></span><span class="count"><strong>__list_position__</strong></span><span class="play"><img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif"></span><span class="yt-uix-button yt-uix-button-default delete"><img class="yt-uix-button-icon-playlist-bar-delete" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Delete"></span><span class="now-playing">Now playing</span><span dir="ltr" class="title"><span>__video_title__  <span class="uploader">by __video_display_name__</span>
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
				<a href="//accounts.google.com/ServiceLogin?passive=true&amp;continue=http%3A%2F%2Fwww.youtube.com%2Fsignin%3Faction_handle_signin%3Dtrue%26feature%3Dplaylist%26nomobiletemp%3D1%26hl%3Den_US%26next%3D%252Fwatch%253Fv%253D<?php echo htmlspecialchars($_video['rid']); ?>%2526feature%253Dg-logo-xit&amp;uilel=3&amp;hl=en_US&amp;service=youtube" class="sign-in-link">Sign in</a> to add this to a playlist
			</div>
			<div id="shared-addto-menu" style="display: none;" class="hid sign-in">
				<div class="addto-menu">
					<div id="addto-list-panel" class="menu-panel active-panel">
						<span class="yt-uix-button-menu-item yt-uix-tooltip sign-in" data-possible-tooltip="" data-tooltip-show-delay="750"><a href="//accounts.google.com/ServiceLogin?passive=true&amp;continue=http%3A%2F%2Fwww.youtube.com%2Fsignin%3Faction_handle_signin%3Dtrue%26feature%3Dplaylist%26nomobiletemp%3D1%26hl%3Den_US%26next%3D%252Fwatch%253Fv%253D<?php echo htmlspecialchars($_video['rid']); ?>%2526feature%253Dg-logo-xit&amp;uilel=3&amp;hl=en_US&amp;service=youtube" class="sign-in-link">Sign in</a> to add this to a playlist
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
		<script id="www-core-js" src="/yt/jsbin/www-core-vfl1pq97W.js" data-loaded="true"></script>
		<script>
			yt.setConfig({
			'XSRF_TOKEN': 'sWZ0733z73lb8fEYAYSd84MaNV98MTM0OTEzMDExNUAxMzQ5MDQzNzE1',
			'XSRF_FIELD_NAME': 'session_token'
			});
			yt.pubsub.subscribe('init', yt.www.xsrf.populateSessionToken);
			
			yt.setConfig('XSRF_REDIRECT_TOKEN', '08fYRr2a9pjbx2VYZhoZtyl-4lh8MTM0OTEzMDExNUAxMzQ5MDQzNzE1');
			
			yt.setConfig({
			'EVENT_ID': "CJuY27ur3rICFaL4OgodEHRznw==",
			'CURRENT_URL': "\/\/www.youtube.com\/watch?v=<?php echo htmlspecialchars($_video['rid']); ?>\u0026feature=g-logo-xit",
			'LOGGED_IN': false,
			'SESSION_INDEX': null,
			
			'WATCH_CONTEXT_CLIENTSIDE': false,
			
			'FEEDBACK_LOCALE_LANGUAGE': "en",
			'FEEDBACK_LOCALE_EXTRAS': {"logged_in": false, "experiments": "906717,901803,907354,904448,901424,922401,920704,912806,913419,913546,913556,919349,919351,925109,919003,912706,900816", "guide_subs": "NA", "accept_language": null}    });
		</script>
		<script>
			if (window.yt.timing) {yt.timing.tick("js_head");}    
		</script>
		<script>
			yt.setAjaxToken('subscription_ajax', "");
			yt.pubsub.subscribe('init', yt.www.subscriptions.SubscriptionButton.init);
			
		</script>
		<script>
			yt.setConfig({
			  'VIDEO_ID': "<?php echo htmlspecialchars($_video['rid']); ?>"    });
			yt.setAjaxToken('watch_actions_ajax', "");
			
			if (window['gYouTubePlayerReady']) {
			  yt.registerGlobal('gYouTubePlayerReady');
			}
		</script>
		<script>
    yt = yt || {};
      yt.playerConfig = {"assets": {"css_actions": "\/\/s.ytimg.com\/yt\/cssbin\/www-player-actions-vflWsl9n_.css", "html": "\/html5_player_template", "css": "\/\/s.ytimg.com\/yt\/cssbin\/www-player-vflE5bu0u.css", "js": "\/\/s.ytimg.com\/yt\/jsbin\/html5player-vfl1S0-AB.js"}, "url": "\/\/s.ytimg.com\/yt\/swfbin\/watch_as3-vfloWhEvq.swf", "min_version": "8.0.0", "args": {"fexp": "907722,906062,910102,927104,922401,920704,912806,927201,913546,913556,925109,919003,920201,912706,900816", "ptk": "youtube_multi", "enablecsi": "1", "allow_embed": 1, "rvs": "", "vq": "auto", "account_playback_token": "", "autohide": "2", "csi_page_type": "watch5", "keywords": <?php echo json_encode($_video['tags'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>, "cr": "US", "iv3_module": "\/\/s.ytimg.com\/yt\/swfbin\/iv3_module-vflGCS_pr.swf", "fmt_list": "43\/320x240\/99\/0\/0,34\/320x240\/9\/0\/115,18\/320x240\/9\/0\/115,5\/320x240\/7\/0\/0,36\/320x240\/99\/0\/0,17\/176x144\/99\/0\/0", "title": <?php echo json_encode($_video['title'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>, "length_seconds": <?php echo $_video['duration']; ?>, "enablejsapi": 1, "advideo": "1", "tk": "o3_r7m6s_HAaFxeywi14S3qFcY4uSrEiWfZ8KVUoyEB_gj1rlrELuQ==", "iv_load_policy": 1, "iv_module": "\/\/s.ytimg.com\/yt\/swfbin\/iv_module-vflBJ5PLc.swf", "sdetail": "p:bit.ly\/dwMq4b", "url_encoded_fmt_stream_map": "", "watermark": ",\/\/s.ytimg.com\/yt\/img\/watermark\/youtube_watermark-vflHX6b6E.png,\/\/s.ytimg.com\/yt\/img\/watermark\/youtube_hd_watermark-vflAzLcD6.png", "sourceid": "r", "timestamp": 1349916364, "storyboard_spec": "", "plid": "AATLveVba5g8mPZ8", "showpopout": 1, "hl": "en_US", "tmi": "1", "iv_logging_level": 4, "st_module": "\/\/s.ytimg.com\/yt\/swfbin\/st_module-vflCXoloO.swf", "no_get_video_log": "1", "iv_close_button": 0, "endscreen_module": "\/\/s.ytimg.com\/yt\/swfbin\/endscreen-vflK6XzTZ.swf", "iv_read_url": "\/\/www.youtube.com\/annotations_iv\/read2?sparams=expire%2Cvideo_id\u0026expire=1349959800\u0026key=a1\u0026signature=815C68436F1E8F95A9283A421D758B7A6452EFD9.5029A9CC9CFCF79F0B17A60238447CA0FE7CA991\u0026video_id=oHg5SJYRHA0\u0026feat=CS", "iv_queue_log_level": 0, "referrer": "\/\/bit.ly\/dwMq4b", "video_id": "<?php echo htmlspecialchars($_video['rid']); ?>", "sw": "1.0", "sk": "4md16KjsgYmUvVHOsiBQxSFIkPbju0d8C", "pltype": "contentugc", "t": "vjVQa1PpcFN8E8yJ1Q1BJFTy1GYmGAMgRZUyNC4FMBY=", "loudness": -23.6900005341}, "url_v9as2": "\/\/s.ytimg.com\/yt\/swfbin\/cps-vfl2Ur0rq.swf", "params": {"allowscriptaccess": "always", "allowfullscreen": "true", "bgcolor": "#000000"}, "attrs": {"id": "movie_player"}, "url_v8": "\/\/s.ytimg.com\/yt\/swfbin\/cps-vfl2Ur0rq.swf", "html5": true};
      yt.setConfig({
    'EMBED_HTML_TEMPLATE': "\u003ciframe width=\"__width__\" height=\"__height__\" src=\"__url__\" frameborder=\"0\" allowfullscreen\u003e\u003c\/iframe\u003e",
    'EMBED_HTML_URL': "\/\/wrappertube.org\/embed\/__videoid__"
  });
    yt.setMsg('FLASH_UPGRADE', "\u003cdiv class=\"yt-alert yt-alert-default yt-alert-error  yt-alert-player\"\u003e  \u003cdiv class=\"yt-alert-icon\"\u003e\n    \u003cimg s\u0072c=\"\/\/s.ytimg.com\/yt\/img\/pixel-vfl3z5WfW.gif\" class=\"icon master-sprite\" alt=\"Alert icon\"\u003e\n  \u003c\/div\u003e\n\u003cdiv class=\"yt-alert-buttons\"\u003e\u003c\/div\u003e\u003cdiv class=\"yt-alert-content\" role=\"alert\"\u003e    \u003cspan class=\"yt-alert-vertical-trick\"\u003e\u003c\/span\u003e\n    \u003cdiv class=\"yt-alert-message\"\u003e\n            You need to upgrade your Adobe Flash Player to watch this video. \u003cbr\u003e \u003ca href=\"\/\/get.adobe.com\/flashplayer\/\"\u003eDownload it from Adobe.\u003c\/a\u003e\n    \u003c\/div\u003e\n\u003c\/div\u003e\u003c\/div\u003e");
  yt.setMsg('PLAYER_FALLBACK', "\u003cdiv class=\"yt-alert yt-alert-default yt-alert-error  yt-alert-player\"\u003e  \u003cdiv class=\"yt-alert-icon\"\u003e\n    \u003cimg s\u0072c=\"\/\/s.ytimg.com\/yt\/img\/pixel-vfl3z5WfW.gif\" class=\"icon master-sprite\" alt=\"Alert icon\"\u003e\n  \u003c\/div\u003e\n\u003cdiv class=\"yt-alert-buttons\"\u003e\u003c\/div\u003e\u003cdiv class=\"yt-alert-content\" role=\"alert\"\u003e    \u003cspan class=\"yt-alert-vertical-trick\"\u003e\u003c\/span\u003e\n    \u003cdiv class=\"yt-alert-message\"\u003e\n            The Adobe Flash Player or an HTML5 supported browser is required for video playback. \u003cbr\u003e \u003ca href=\"\/\/get.adobe.com\/flashplayer\/\"\u003eGet the latest Flash Player\u003c\/a\u003e \u003cbr\u003e \u003ca href=\"\/html5\"\u003eLearn more about upgrading to an HTML5 browser\u003c\/a\u003e\n    \u003c\/div\u003e\n\u003c\/div\u003e\u003c\/div\u003e");
  yt.setMsg('QUICKTIME_FALLBACK', "\u003cdiv class=\"yt-alert yt-alert-default yt-alert-error  yt-alert-player\"\u003e  \u003cdiv class=\"yt-alert-icon\"\u003e\n    \u003cimg s\u0072c=\"\/\/s.ytimg.com\/yt\/img\/pixel-vfl3z5WfW.gif\" class=\"icon master-sprite\" alt=\"Alert icon\"\u003e\n  \u003c\/div\u003e\n\u003cdiv class=\"yt-alert-buttons\"\u003e\u003c\/div\u003e\u003cdiv class=\"yt-alert-content\" role=\"alert\"\u003e    \u003cspan class=\"yt-alert-vertical-trick\"\u003e\u003c\/span\u003e\n    \u003cdiv class=\"yt-alert-message\"\u003e\n            The Adobe Flash Player or QuickTime is required for video playback. \u003cbr\u003e \u003ca href=\"\/\/get.adobe.com\/flashplayer\/\"\u003eGet the latest Flash Player\u003c\/a\u003e \u003cbr\u003e \u003ca href=\"\/\/www.apple.com\/quicktime\/download\/\"\u003eGet the latest version of QuickTime\u003c\/a\u003e\n    \u003c\/div\u003e\n\u003c\/div\u003e\u003c\/div\u003e");

<?php if ( endsWith($_video['filename'],".mp4") ) { ?>
if (!detectFlash() || detectRuffle()) {
    (function() {
      var forceUpdate = yt.www.watch.player.updateConfig(yt.playerConfig);
      var youTubePlayer = yt.player.update('watch-player', yt.playerConfig,
          forceUpdate, gYouTubePlayerReady);
      yt.setConfig({'PLAYER_REFERENCE': youTubePlayer});
    })();
}
<?php } ?>
  </script>
		<script>
			yt.setConfig({
			  'SUBSCRIBE_AXC': "",
			
			  'IS_OWNER_VIEWING': null,
			  'IS_WIDESCREEN': false,
			  'PREFER_LOW_QUALITY': false,
			  'WIDE_PLAYER_STYLES': ["watch-wide-mode"],
			  'COMMENT_SHARE_URL': "\/\/www.youtube.com\/comment?lc=_COMMENT_ID_",
			  'ALLOW_EMBED': true,
			  'ALLOW_RATINGS': true,
			
			  'LIST_AUTO_PLAY_ON': false,
			  'LIST_AUTO_PLAY_VALUE': 1,
			  'SHUFFLE_VALUE': 0,
			  'SHUFFLE_ENABLED': false,
			  'YPC_CAN_RATE_VIDEO': true,
			  'YPC_SHOW_VPPA_CONFIRM_RATING': false,
			
			
			
			
			
			
			
			
			  'PLAYBACK_ID': "AATK8rd3IxlBnwIO",
			  'PLAY_ALL_MAX': 480    });
			
			yt.setMsg({
			  'LOADING': "Loading...",
			  'WATCH_ERROR_MESSAGE': "This feature is not available right now. Please try again later."    });
			
			
			
			  yt.setMsg({
			'UNBLOCK_USER': "Are you sure you want to unblock this user?",
			'BLOCK_USER': "Are you sure you want to block this user?"
			});
			yt.setConfig('BLOCK_USER_AJAX_XSRF', '');
			
			
			  yt.setConfig({
			'COMMENT_SHARE_URL': "\/\/www.youtube.com\/comment?lc=_COMMENT_ID_",
			'COMMENTS_SIGNIN_URL': "",
			'COMMENTS_THRESHHOLD': -5,
			'COMMENTS_PAGE_SIZE': 10,
			'COMMENTS_COUNT': 41353,
			'COMMENTS_YPC_CAN_POST_OR_REACT_TO_COMMENT': true,
			'COMMENT_VOTE_XSRF' : '',
			'COMMENT_ACTIONS_XSRF' : '',
			'COMMENT_SOURCE': "w",
			'ENABLE_LIVE_COMMENTS': true  });
			
			yt.setAjaxToken('link_ajax', "");
			yt.setAjaxToken('comment_servlet', "");
			yt.setAjaxToken('comment_voting', "");
			
			yt.setMsg({
			'COMMENT_OK': "OK",
			'COMMENT_BLOCKED': "You have been blocked by the owner of this video.",
			'COMMENT_CAPTCHAFAIL': "The response to the letters on the image was not correct, please try again.",
			'COMMENT_PENDING': "Comment Pending Approval!",
			'COMMENT_ERROR_EMAIL': "Error, account unverified (see email)",
			'COMMENT_ERROR': "Error, try again",
			'COMMENT_OWNER_LINKING': "Comments can't contain links, please put the link in your video description and refer to it in the comment."
			});
			
			yt.pubsub.subscribe('init', yt.www.comments.init);
			
			  yt.setConfig({
			'ENABLE_LIVE_COMMENTS': true,
			'COMMENTS_VIDEO_ID': "<?php echo htmlspecialchars($_video['rid']); ?>",
			'COMMENTS_LATEST_TIMESTAMP': 1349043702,
			'COMMENTS_POLLING_INTERVAL': 15000,
			'COMMENTS_FORCE_SCROLLING': false,
			'COMMENTS_PAGE_SIZE': 10  });
			
			yt.setMsg({
			'LC_COUNT_NEW_COMMENTS': "\u003ca href=\"#\" onclick=\"yt.www.watch.livecomments.showNewComments(); return false;\"\u003eShow $count new comments.\u003c\/a\u003e"
			});
			
			yt.pubsub.subscribe('init', function() {
			  yt.net.scriptloader.load("\/\/s.ytimg.com\/yt\/jsbin\/www-livecomments-vflCp_BeU.js", function() {
			    yt.www.watch.livecomments.init();
			  });
			});
			
			
			
			  yt.setConfig('ENABLE_AUTO_LARGE', true);
			  yt.www.watch.watch5.updatePlayerSize();
			  yt.pubsub.subscribe('init', function() {
			    yt.events.listen(window, 'resize',
			        yt.www.watch.watch5.handleResize);
			  });
			
			yt.pubsub.subscribe('init', yt.www.watch.activity.init);
			yt.pubsub.subscribe('init', yt.www.watch.player.init);
			yt.pubsub.subscribe('init', yt.www.watch.actions.init);
			yt.pubsub.subscribe('init', yt.www.watch.shortcuts.init);
			
			
			yt.pubsub.subscribe('init', function() {
			  var description = _gel('watch-description');
			  if (!_hasclass(description, 'yt-uix-expander-collapsed')) {
			    yt.www.watch.watch5.handleToggleDescription(description);
			  }
			});
			
			
			
			
			
			
			
			
			
			
		</script>
		<script>
			if (window.yt.timing) {yt.timing.tick("js_page");}    
		</script>
		<script>yt.pubsub.subscribe('init', function() {yt.www.thumbnaildelayload.init(0);});</script>
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
			
			  yt.setAjaxToken('addto_ajax_logged_out', "KTlts1bRmBPkwoVCGIRuG79_hSF8MTM0OTEzMDExNUAxMzQ5MDQzNzE1");
			
			  yt.www.lists.init();
			
			
			
			
			
			
			
			
			
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
		<script>
			var subscribed = <?php echo($_video['subscribed'] ? 'true' : 'false') ?>;
			var liked = <?php echo($_video['liked'] ? 'true' : 'false') ?>;
                        var disliked = <?php echo($_video['disliked'] ? 'true' : 'false') ?>;
			var myRating = <?php echo $_video['my_rating']; ?>;
			var loggedIn = <?php echo(isset($_SESSION['siteusername']) ? 'true' : 'false') ?>;
			var favourited = <?php echo($_video['favorited'] ? 'true' : 'false') ?>;
			var alerts = 0;
 
			function subscribe() {
				if(loggedIn == true) { 
					if(subscribed == false) { 
						$.ajax({
							url: "/get/subscribe?n=<?php echo urlencode($_video['author']); ?>",
							type: 'GET',
							success: function(res) {
								alerts++;
								$("#subscribe-button").addClass("subscribed");
								addAlert("editsuccess_" + alerts, "Successfully added <?php echo htmlspecialchars($_video['author']); ?> to your subscriptions!");
								showAlert("#editsuccess_" + alerts);
								console.log("DEBUG: " + res);
								subscribed = true;
							}
						});
					} else {
						$.ajax({
							url: "/get/unsubscribe?n=<?php echo urlencode($_video['author']); ?>",
							type: 'GET',
							success: function(res) {
								alerts++;
								$("#subscribe-button").removeClass("subscribed");
								addAlert("editsuccess_" + alerts, "Successfully removed <?php echo htmlspecialchars($_video['author']); ?> from your subscriptions!");
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

         function rate(rating) {
			if (loggedIn) {
					$.ajax({
						url: "/get/star?v=<?php echo htmlspecialchars($_video['rid']); ?>&rating=" + rating,
						type: 'GET',
						xhrFields: {
							withCredentials: true
						},
						success: function (res) {
							if(!myRating) {
								switch (rating) {
								case 5:
								$("#star_1").attr("src","/static/img/full_star.png");
								$("#star_2").attr("src","/static/img/full_star.png");
								$("#star_3").attr("src","/static/img/full_star.png");
								$("#star_4").attr("src","/static/img/full_star.png");
								$("#star_5").attr("src","/static/img/full_star.png");
								$("#ratetext").text("Very Good!");
								liked = true;
								disliked = false;
								break;
								case 4:
                                                                $("#star_1").attr("src","/static/img/full_star.png");
                                                                $("#star_2").attr("src","/static/img/full_star.png");
                                                                $("#star_3").attr("src","/static/img/full_star.png");
                                                                $("#star_4").attr("src","/static/img/full_star.png");
                                                                $("#star_5").attr("src","/static/img/empty_star.png");
                                                                $("#ratetext").text("Good!");
                                                                liked = true;
                                                                disliked = false;
                                                                break;
                                                                case 3:
                                                                $("#star_1").attr("src","/static/img/full_star.png");
                                                                $("#star_2").attr("src","/static/img/full_star.png");
                                                                $("#star_3").attr("src","/static/img/full_star.png");
                                                                $("#star_4").attr("src","/static/img/empty_star.png");
                                                                $("#star_5").attr("src","/static/img/empty_star.png");
                                                                $("#ratetext").text("OK.");
                                                                liked = false;
                                                                disliked = false;
                                                                break;
                                                                case 2:
                                                                $("#star_1").attr("src","/static/img/full_star.png");
                                                                $("#star_2").attr("src","/static/img/full_star.png");
                                                                $("#star_3").attr("src","/static/img/empty_star.png");
                                                                $("#star_4").attr("src","/static/img/empty_star.png");
                                                                $("#star_5").attr("src","/static/img/empty_star.png");
                                                                $("#ratetext").text("Bad..");
                                                                liked = false;
                                                                disliked = true;
                                                                break;
                                                                case 1:
                                                                $("#star_1").attr("src","/static/img/full_star.png");
                                                                $("#star_2").attr("src","/static/img/empty_star.png");
                                                                $("#star_3").attr("src","/static/img/empty_star.png");
                                                                $("#star_4").attr("src","/static/img/empty_star.png");
                                                                $("#star_5").attr("src","/static/img/empty_star.png");
                                                                $("#ratetext").text("Terrible...");
                                                                liked = false;
                                                                disliked = true;
                                                                break;
								}
								myRating = rating;
							} else {
                                                                $("#star_1").attr("src","/static/img/empty_star.png");
                                                                $("#star_2").attr("src","/static/img/empty_star.png");
                                                                $("#star_3").attr("src","/static/img/empty_star.png");
                                                                $("#star_4").attr("src","/static/img/empty_star.png");
                                                                $("#star_5").attr("src","/static/img/empty_star.png");
                                                                $("#ratetext").text("IDK..");
                                                                liked = false;
                                                                disliked = false;
								myRating = 0;
							}
						}
					});
			} else {
				alerts++;
				addAlert("editsuccess_" + alerts, "You need to log in to rate videos!");
				showAlert("#editsuccess_" + alerts);
			}
		}
                        function add_friend() {
                                    $.ajax({
                                            url: "/get/add_friend?sending=<?php echo urlencode($_video['author']); ?>",
                                            type: 'GET',
                                            success: function(res) {
                                            if (res == "OK") {
                                                    $("#friend_text").text("Your friend request is pending.");
                                            } else {
                                                    alerts++;
                                                    addAlert("editsuccess_" + alerts, res);
                                                    showAlert("#editsuccess_" + alerts);
                                            }
                                            }
                                    });
                        }

                        function toggle_favourite() {
                                    var did_i_favourite_already = favourited;
                                    $.ajax({
                                            url: did_i_favourite_already ? "/get/unfavorite?v=<?php echo urlencode($_video['rid']); ?>" : "/get/favorite?v=<?php echo urlencode($_video['rid']); ?>",
                                            type: 'GET',
                                            success: function(res) {
                                                    $("#favourite_text").text((did_i_favourite_already ? "Favorite" : "Unfavorite") + " Video");
                                                    favourited = !favourited;
                                            }
                                    });
                        }

                        
                        function add_to_quicklist() {
                                    $.ajax({
                                            url: "/get/add_to_quicklist?v=<?php echo urlencode($_video['rid']); ?>",
                                            type: 'GET',
                                            success: function(res) {
                                                    alerts++;
                                                    addAlert("editsuccess_" + alerts, res);
                                                    showAlert("#editsuccess_" + alerts);
                                            }
                                    });
                        }

                        function add_to_playlist(playlist) {
                                    $.ajax({
                                            url: "/get/add_to_playlist?id=<?php echo urlencode($_video['rid']); ?>&playlist=" + playlist,
                                            type: 'GET',
                                            success: function(res) {
                                                    alerts++;
                                                    addAlert("editsuccess_" + alerts, escapeHtml(res));
                                                    showAlert("#editsuccess_" + alerts);
                                            }
                                    });
                        }

                        function add_to_group(group) {
                                    $.ajax({
                                            url: "/get/add_video_ajax?vid=<?php echo urlencode($_video['rid']); ?>&gid=" + group,
                                            type: 'GET',
                                            success: function(res) {
                                                    alerts++;
                                                    addAlert("editsuccess_" + alerts, escapeHtml(res));
                                                    showAlert("#editsuccess_" + alerts);
                                            }
                                    });
                        }
function escapeHtml(unsafe) {
  return unsafe
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}

            function reply_to_comment(cid) {
                        $('#reply_form_' + cid + ' input[type="submit"]').prop("disabled", true);
                        var data = {
                            comment: $('#com' + cid).val()
                        };

                        $.ajax( {
                            url: '/d/reply?id=' + cid + '&v=<?php echo urlencode($_video['rid']); ?>',
                            type: 'POST',
                            data: data,
                            cache: false,
                            success: function(result){
                                if(result.substr(0,3) == "OK:") {
                                    $("#replies_to_" + cid).append(result.substr(3));
                                    $('#reply_form_' + cid + ' textarea[name="comment"]').val('');
                                    $('#reply_to_' + cid).hide();
                                } else {
                                    alerts++;
                                    addAlert("editsuccess_" + alerts, result.substr(6));
                                    showAlert("#editsuccess_" + alerts);
                                }
                                $('#reply_form_' + cid + ' input[type="submit"]').prop("disabled", false);
                            }
                        } );
            }
                        function delete_comment(cid) {
                                    if (!confirm('Are you sure you want to remove this comment?')) { return; }
                                    $.ajax({
                                            url: "/get/delete_comment?id=" + cid,
                                            type: 'GET',
                                            success: function(res) {
                                            if (res == "OK") {
                                                    $("#comment_" + cid).remove();
                                                    $("#reply_to_" + cid).remove();
                                                    $("#replies_to_" + cid).remove();
                                            } else {
                                                    alerts++;
                                                    addAlert("editsuccess_" + alerts, res);
                                                    showAlert("#editsuccess_" + alerts);
                                            }
                                            }
                                    });
                        }

                        function delete_reply(cid) {
                                    if (!confirm('Are you sure you want to remove this reply?')) { return; }
                                    $.ajax({
                                            url: "/get/delete_reply?id=" + cid,
                                            type: 'GET',
                                            success: function(res) {
                                            if (res == "OK") {
                                                    $("#comment_reply_" + cid).remove();
                                            } else {
                                                    alerts++;
                                                    addAlert("editsuccess_" + alerts, res);
                                                    showAlert("#editsuccess_" + alerts);
                                            }
                                            }
                                    });
                        }

var flashapp = document.getElementById('scratchproject');
function JSsetPresentationMode(fillScreen) {
	if (fillScreen) {
  if(flashapp.requestFullscreen) {
    flashapp.requestFullscreen();
  } else if(flashapp.mozRequestFullScreen) {
    flashapp.mozRequestFullScreen();
  } else if(flashapp.webkitRequestFullscreen) {
    flashapp.webkitRequestFullscreen();
  } else if(flashapp.webkitRequestFullScreen) {
    flashapp.webkitRequestFullScreen();
  } else if(flashapp.msRequestFullscreen) {
    flashapp.msRequestFullscreen();
  }
	} else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
	}
}

function toggleLarge() {
if (!$('#page').hasClass('watch-wide')) {
yt.www.watch.watch5.enableWide(true);
<?php if (endsWith($_video['filename'],".scratch") || endsWith($_video['filename'],".sb") || endsWith($_video['filename'],".sb2") || endsWith($_video['filename'],".sb3") || endsWith($_video['filename'],".pmp") || endsWith($_video['filename'],".xml") || endsWith($_video['filename'],".ypr")) { ?>
$('#scratchproject').attr("width", 642);
$('#scratchproject').attr("height", <?php echo (endsWith($_video['filename'],".scratch") || endsWith($_video['filename'],".sb") || endsWith($_video['filename'],".sb2"))?'521':((endsWith($_video['filename'],".xml") || endsWith($_video['filename'],".ypr"))?'482':'532'); ?>);
$('#watch-player').css("width", "642px");
$('#watch-player').css("height", "<?php echo (endsWith($_video['filename'],".scratch") || endsWith($_video['filename'],".sb") || endsWith($_video['filename'],".sb2"))?'542':((endsWith($_video['filename'],".xml") || endsWith($_video['filename'],".ypr"))?'500':'560'); ?>px");
$('#watch-player').css("margin", "0 auto");
<?php } ?>
} else {
yt.www.watch.watch5.enableWide(false);
<?php if (endsWith($_video['filename'],".scratch") || endsWith($_video['filename'],".sb") || endsWith($_video['filename'],".sb2") || endsWith($_video['filename'],".sb3") || endsWith($_video['filename'],".pmp") || endsWith($_video['filename'],".xml") || endsWith($_video['filename'],".ypr")) { ?>
$('#scratchproject').attr("width", 482);
$('#scratchproject').attr("height", <?php echo (endsWith($_video['filename'],".scratch") || endsWith($_video['filename'],".sb") || endsWith($_video['filename'],".sb2"))?'401':((endsWith($_video['filename'],".xml") || endsWith($_video['filename'],".ypr"))?'362':'412'); ?>);
$('#watch-player').css("width", "482px");
$('#watch-player').css("height", "<?php echo (endsWith($_video['filename'],".scratch") || endsWith($_video['filename'],".sb") || endsWith($_video['filename'],".sb2"))?'422':((endsWith($_video['filename'],".xml") || endsWith($_video['filename'],".ypr"))?'382':'440'); ?>px");
$('#watch-player').css("margin", "0 79px");
<?php } ?>
}
}
function shareVideoFromFlash(){
yt.www.watch.actions.shareWithPlaylist();
}
function launchFullscreen(element) {
  if(element.requestFullscreen) {
    element.requestFullscreen();
  } else if(element.mozRequestFullScreen) {
    element.mozRequestFullScreen();
  } else if(element.webkitRequestFullscreen) {
    element.webkitRequestFullscreen();
  } else if(element.webkitRequestFullScreen) {
    element.webkitRequestFullScreen();
  } else if(element.msRequestFullscreen) {
    element.msRequestFullscreen();
  }
}
$(document).ready(function() {
  $("#watch-sidebar").css("margin-top", -1 * $("#watch-video").height());
});
		</script>
<?php if (endsWith($_video['filename'],".jpg") || endsWith($_video['filename'],".png") || endsWith($_video['filename'],".jpeg") || endsWith($_video['filename'],".jpe") || endsWith($_video['filename'],".gif") || endsWith($_video['filename'],".bmp") || endsWith($_video['filename'],".svg")) {  ?>
<script>
var isBigImg = false;
var browserWidth;
var browserHeight;
$(function() {
browserWidth = $(window).width();
browserHeight = $(window).height();
$( ".imageModal" ).dialog({
autoOpen: false,
modal: true,
resizable: false,
draggable: false,
title: <?php echo json_encode($_video['title'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>,
width: browserWidth,
height: browserHeight,
open: function( event, ui ) {
$('body').css({
    overflow: 'hidden'
});
},
close: function( event, ui ) {
$('body').css({
    overflow: 'auto'
});
$("#bigimg").css("max-width", browserWidth - 20);
$("#bigimg").css("max-height", browserHeight - 57);
$("#bigimg").css("margin-top", "auto");
$("#bigimg").css("cursor", "zoom-in");
isBigImg = false;
}
});
$("#bigimg").css("max-width", browserWidth - 20);
$("#bigimg").css("max-height", browserHeight - 57);
});
function toggleImgSize() {
if (!isBigImg) {
    $("#bigimg").css("max-width", "none");
    $("#bigimg").css("max-height", "none");
    $("#bigimg").css("margin-top", "0");
    $("#bigimg").css("cursor", "zoom-out");
    isBigImg = true;
} else {
    $("#bigimg").css("max-width", browserWidth - 20);
    $("#bigimg").css("max-height", browserHeight - 57);
    $("#bigimg").css("margin-top", "auto");
    $("#bigimg").css("cursor", "zoom-in");
    isBigImg = false;
}
}
</script>
<?php } ?>
               <script>
                    $(".collapsible").on("click", function() { //way better than the prev code
                        $(this).toggleClass("active-dropdown");
                        $(this).next().slideToggle('fast');
                    });
                </script>
               <script>
                    var moreFromLoaded = false;
                    $("#more-from-button").on("click", function() {
                        if (moreFromLoaded) {
                            return;
                        }
                        moreFromLoaded = true;
                        $.ajax({
                            url: "/get/more_from?n=<?php echo urlencode($_video['author']); ?>",
                            success: function(html){
                                if(html){
                                    $("#watch-more-from-container").html(html);
                                } else {
                                    alert("Unable to get more videos!");
                                    moreFromLoaded = false;
                                }
                             }
                        });
                    });
                </script>
<script type="text/javascript" language="JavaScript">
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
