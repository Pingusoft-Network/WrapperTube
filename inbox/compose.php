<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_update.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_insert.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/important/bbcode.php"); ?><?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__user_u = new user_update($__db); ?>
<?php $__user_i = new user_insert($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php if(!isset($_SESSION['siteusername'])) { die(header("Location: /sign_in")); } ?>
<?php
	$__server->page_embeds->page_title = "WrapperTube - Compose";
	$__server->page_embeds->page_description = "WrapperTube is a site where you can upload your videos, animations, Scratch Projects, Artwork, music, and anything.";
	$__server->page_embeds->page_image = "/yt/imgbin/full-size-logo.png";
	$__server->page_embeds->page_url = "http://wrappertube.org/";
?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $error = array();
if (file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/static/important/lockdown_mode.txt")=="on") {die("WrapperTube is currently experiencing an attack from vandals. Some of the site features have been temporarily disabled. Please try again later.");}

        if(!isset($_SESSION['siteusername'])){ $error['message'] = "You are not logged in"; $error['status'] = true; }
        if(!$_POST['contents']){ $error['message'] = "Your description cannot be blank"; $error['status'] = true; }
        if(empty(trim($_POST['subject']))){ $error['message'] = "Your subject cannot be blank"; $error['status'] = true; }
        if(strlen($_POST['contents']) > 12000){ $error['message'] = "Your description must be shorter than 12000 characters"; $error['status'] = true; }
        if($__user_h->if_cooldown($_SESSION['siteusername'])) { $error['message'] = "You are on a cooldown! Wait for 20 seconds before sending a private message."; $error['status'] = true; }
        if(!$__user_h->user_exists($_POST['to'])) { $error['message'] = "user doesn't exist"; $error['status'] = true; }
        if($__user_h->if_blocked($_POST['to'], $_SESSION['siteusername'])) { $error['message'] = "This user has blocked you!"; $error['status'] = true; }


        if(!isset($error['message'])) {
            $stmt = $__db->prepare("INSERT INTO pms (touser, subject, message, owner, video_attribute, type) VALUES (:touser, :subject, :message, :owner, :video_attribute, 'nm')");
            $stmt->bindParam(":subject", $_POST['subject']);
            $stmt->bindParam(":message", $_POST['contents']);
            $stmt->bindParam(":touser", $_POST['to']);
            $stmt->bindParam(":owner", $_SESSION['siteusername']);
            $stmt->bindParam(":video_attribute", $_POST['video_attribute']);
            $text = htmlspecialchars($_POST['contents']);
            $stmt->execute();
            $stmt = null;

            $__user_u->update_cooldown_time($_SESSION['siteusername'], "cooldown_comment");
            die(header("Location: /inbox/?success=Your message has been sent!"));
        }
    }
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
		<link rel="stylesheet" href="/yt/cssbin/www-inbox.css">
		<script src="//s.ytimg.com/yt/jsbin/www-browse-vflu1nggJ.js" data-loaded="true"></script>
<script src="/s/js/alert.js" data-loaded="true"></script>
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
<script type="text/javascript" src="/static/markitup/jquery.markitup.js"></script>
<script type="text/javascript" src="/static/markitup/sets/bbcode/set.js?v4"></script>
<script type="text/javascript" src="/static/js/board.js"></script>
<link rel="stylesheet" type="text/css" href="/static/markitup/skins/simple/style.css?v3" />
<link rel="stylesheet" type="text/css" href="/static/markitup/sets/bbcode/style.css?v3" />
<script type="text/javascript" src="/static/js/scratchblocks-menu.js"></script>
		<script>
			if (window.yt.timing) {yt.timing.tick("ct");}    
		</script>
        <style>
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
</style>
<script type="text/javascript" >
   $(document).ready(function() {
      $("#com").markItUp(mySettings);
            scratchblocks.renderMatching('.scratchblocks-button ul a', {
              languages: ['en']
            });
   });
</script>
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
                            <li class=" selected">
								<span class="yt-nav-item">
								Inbox
								</span>
							</li>
                                                        <a href="/account/">
                            <li>
                                                                <span class="yt-nav-item">
                                                                Settings
                                                                </span>
                                                        </li>
                            </a>
						</ul>
					</div>
					<div class="browse-container ytg-wide ytg-box no-stage browse-bg-gradient">
						<div class="ytg-fl browse-content">
                            <?php require($_SERVER['DOCUMENT_ROOT'] . "/s/mod/sidebar_inbox.php"); ?>
							<div id="browse-main-column" style="float: right;margin: 0px 0 0 14px;" class="ytg-4col">
								<div class="browse-collection  has-box-ad">
                                    <h1>Compose</h1>
                                    <hr><br>
                                    <form action="/inbox/compose" method="post" id="submitform">
                                    <input style="width: 95%;" value="<?php echo htmlspecialchars(@$_GET['title']); ?>" name="subject" type="text" placeholder="Subject" class="yt-uix-form-input-text"><br><br>
                                    <input style="width: 95%;" value="<?php echo htmlspecialchars(@$_GET['to']); ?>" name="to" type="text" placeholder="To" class="yt-uix-form-input-text"><br><br>
                                    <textarea style="width: 95%;" placeholder="Contents" name="contents" id="com" class="yt-uix-form-textarea"></textarea><br>
<button type="button" class="collapsible"><img class="www-right-arrow" id="arrow_more">Emotes &amp; Kaomoji</button>
<div class="watch-sidebar-body">
<input type="button" onClick="insertThisInThere('ｷﾀ━━━(ﾟ∀ﾟ)━━━!!','com')" value="ｷﾀ━━━(ﾟ∀ﾟ)━━━!!" />
<input type="button" onClick="insertThisInThere('(;´Д`)','com')" value="(;´Д`)" />
<input type="button" onClick="insertThisInThere('ヽ(´∇`)ノ','com')" value="ヽ(´∇`)ノ" />
<input type="button" onClick="insertThisInThere('(´ー`)','com')" value="(´ー`)" />
<input type="button" onClick="insertThisInThere('( ´ー｀)y-~~','com')" value="( ´ー｀)y-~~" />
<input type="button" onClick="insertThisInThere('（ ’～’）','com')" value="（ ’～’）" />
<input type="button" onClick="insertThisInThere('ヽ(`Д´)ノ','com')" value="ヽ(`Д´)ノ" />
<input type="button" onClick="insertThisInThere('( ´ω`)','com')" value="( ´ω`)" />
<input type="button" onClick="insertThisInThere('(・∀・)','com')" value="(・∀・)" />
<input type="button" onClick="insertThisInThere('(´・ω・｀)','com')" value="(´・ω・｀)" />
<input type="button" onClick="insertThisInThere('( ´,_ゝ｀)','com')" value="( ´,_ゝ｀)" />
<input type="button" onClick="insertThisInThere('Σ(;ﾟДﾟ)','com')" value="Σ(;ﾟДﾟ)" />
<input type="button" onClick="insertThisInThere('(;｀Д´)','com')" value="(;｀Д´)" />
<input type="button" onClick="insertThisInThere('( ﾟ ヮﾟ) Mittens!','com')" value="( ﾟ ヮﾟ)" />
<input type="button" onClick="insertThisInThere('^°^','com')" value="^°^" />
<input type="button" onClick="insertThisInThere('=^..^=','com')" value="=^..^=" />
<input type="button" onClick="insertThisInThere('^v^','com')" value="^v^" />
<input type="button" onClick="insertThisInThere('VvV','com')" value="VvV" />
<input type="button" onClick="insertThisInThere('UwU','com')" value="UwU" />
<input type="button" onClick="insertThisInThere('( ° _ ° )','com')" value="( ° _ ° )" />
<input type="button" onClick="insertThisInThere('&gt;v^','com')" value="&gt;v^" />
<input type="button" onClick="insertThisInThere('^_&lt;','com')" value="^_&lt;" />
<input type="button" onClick="insertThisInThere('&gt_^','com')" value="&gt;_^" />
<input type="button" onClick="insertThisInThere('^v&lt;','com')" value="^v&lt;" />
<input type="button" onClick="insertThisInThere('( &gt; v &lt; )','com')" value="( &gt; v &lt; )" />
<input type="button" onClick="insertThisInThere('&gt;v&lt;','com')" value="&gt;v&lt;" /><br />

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':mona2:','com')"><img src="/static/smileys/mona2.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':nida:','com')"><img src="/static/smileys/nida.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':af2:','com')"><img src="/static/smileys/af2.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':nagato:','com')"><img src="/static/smileys/nagato.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':iyahoo:','com')"><img src="/static/smileys/iyahoo.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':purin:','com')"><img src="/static/smileys/purin.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':araebi:','com')"><img src="/static/smileys/araebi.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':mona3:','com')"><img src="/static/smileys/2mona2.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':saitama:','com')"><img src="/static/smileys/anime_saitama05.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':unko:','com')"><img src="/static/smileys/u_unko.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':ranta:','com')"><img src="/static/smileys/anime_imanouchi04.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':mosa:','com')"><img src="/static/smileys/u_mosa.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':shii:','com')"><img src="/static/smileys/anime_shii01.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':syobo:','com')"><img src="/static/smileys/syobo2.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':iyou:','com')"><img src="/static/smileys/2iyou_2.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':1san:','com')"><img src="/static/smileys/1san32.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':zuri:','com')"><img src="/static/smileys/zuri.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':13uo:','com')"><img src="/static/smileys/13uo.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':monatya:','com')"><img src="/static/smileys/monatya.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':pata:','com')"><img src="/static/smileys/u_pata.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':kasari:','com')"><img src="/static/smileys/kasa-ri.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':snowman:','com')"><img src="/static/smileys/showman.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':depression:','com')"><img src="/static/smileys/u_sasu.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':monapc:','com')"><img src="/static/smileys/anime_miruna_pc.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':ppa:','com')"><img src="/static/smileys/ppa.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':rocket:','com')"><img src="/static/smileys/10ite.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':saitama2:','com')"><img src="/static/smileys/anime_saitama06.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':eiki:','com')"><img src="/static/smileys/eiki.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':banana:','com')"><img src="/static/smileys/banana.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':sip:','com')"><img src="/static/smileys/sip.gif" height="30px" width="30px"></button>
<br>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':meow:','com')"><img src="/static/smileys/Meow.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':gobo:','com')"><img src="/static/smileys/Gobo_emoji.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':waffle:','com')"><img src="/static/smileys/Waffle_Emoji.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':semicolon:','com')"><img src="/static/smileys/Semicolon_Emoticon.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':taco:','com')"><img src="/static/smileys/Taco_emoji.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':eggplant:','com')"><img src="/static/smileys/Eggplant_emoji.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':sushi:','com')"><img src="/static/smileys/Sushi_emoji.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':apple:','com')"><img src="/static/smileys/Apple_emoji.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':broccoli:','com')"><img src="/static/smileys/Broccoli_emoji.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':pizza:','com')"><img src="/static/smileys/Pizza_emoji.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':candycorn:','com')"><img src="/static/smileys/Candycorn.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':10mil:','com')"><img src="/static/smileys/10milemoji.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':map:','com')"><img src="/static/smileys/Map_emoji.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':camera:','com')"><img src="/static/smileys/Camera_emoji.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':suitcase:','com')"><img src="/static/smileys/Suitcase_emoji.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':compass:','com')"><img src="/static/smileys/Compass.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':binoculars:','com')"><img src="/static/smileys/Binoculars.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':ksllxmfcai:','com')"><img src="/static/smileys/Ksllxmfcai-emoji.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':cupcake:','com')"><img src="/static/smileys/Cupcake.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':cat:','com')"><img src="/static/smileys/Cat-emoji.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':awwcat:','com')"><img src="/static/smileys/Aww-cat-emoji.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':coolcat:','com')"><img src="/static/smileys/Cool-cat-emoji.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':tongueoutcat:','com')"><img src="/static/smileys/Tongue-out-cat-emoji.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':winkcat:','com')"><img src="/static/smileys/Wink-cat-emoji.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':lolcat:','com')"><img src="/static/smileys/Lol-cat-emoji.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':upsidedowncat:','com')"><img src="/static/smileys/Upside-down-cat-emoji.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':huhcat:','com')"><img src="/static/smileys/Huh-cat-emoji.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':loveitcat:','com')"><img src="/static/smileys/Love-it-cat-emoji.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':favitcat:','com')"><img src="/static/smileys/Fav-it-cat-emoji.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':rainbowcat:','com')"><img src="/static/smileys/Rainbow-cat-emoji.png"></button>
<button type="button" class="yt-uix-button yt-uix-button-default" onClick="insertThisInThere(':pizzacat:','com')"><img src="/static/smileys/Pizza-cat-emoji.png"></button>
</div><br><br>
                                    <input style="width: 95%;" value="<?php echo htmlspecialchars(@$_GET['video_attribute']); ?>" name="video_attribute" type="text" placeholder="Attach Video ID (optional)" class="yt-uix-form-input-text"><br><br>
                                    <input type="submit" value="Send" class="yt-uix-button yt-uix-button-default">
                                    </form>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
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
        <script>
                    $(".collapsible").on("click", function() { //way better than the prev code
                        $(this).toggleClass("active-dropdown");
                        $(this).next().slideToggle('fast');
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
