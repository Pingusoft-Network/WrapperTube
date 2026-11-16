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
<?php
	$__server->page_embeds->page_title = "WrapperTube - Help";
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
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
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
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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
                            <li class=" selected">
								<span class="yt-nav-item">
								WrapperTube
								</span>
							</li>
						</ul>
					</div>
					<div class="browse-container ytg-wide ytg-box no-stage browse-bg-gradient">
						<div class="ytg-fl browse-content">
                            <?php require($_SERVER['DOCUMENT_ROOT'] . "/s/mod/sidebar_about.php"); ?>
							<div id="browse-main-column" style="float: right;margin: 0px 0 0 14px;" class="ytg-4col">
								<div class="browse-collection  has-box-ad">
									<h1>Help</h1>
									<hr><br>
									<p class="intro-text" style="line-height: 18px;margin-bottom: 20px;">
										<span class="highlight">Q: What kind of videos can I upload?</span>

<br><br>A: You may upload any kind of personal video that you would like to share with the world, as long as it follows <a href="community_guidelines">ZE RULES</a>.
<br>
<br>
However, this still leaves a lot of room for creativity!! Do you own a <a href="/search_query?q=dog">dog</a> or a <a href="/search_query?q=cat">cat</a>? Have you gone on vacationing in <a href="/search_query?q=Mexico">Mexico</a>? Do you live in <a href="/search_query?q=Netherlands">The Netherlands</a>?
<br>
<br>
These are just some examples of the videos that our users are uploading. In the end, you know yourself best. What would <i>you</i> like to capture on video?
<br><br><span class="highlight">Q: How long can my video be?</span>

<br><br>A: The video must be under 200MB in size.
<br><br><span class="highlight">Q: What video file formats can I upload?</span>

<br><br>A: We support various media types like images, videos, audio, documents, Scratch projects, and SWF movies.

<br><br><span class="highlight">Q: What is WrapperTube?</span>

<br><br>A: See the <a href="about_wrappertube">about page</a>.

<br><br><span class="highlight">Q: Is WrapperTube better?</span>

<br><br>A: Yes. It has more features, more people, and a better community than any other Scratch alternative.

<br><br><span class="highlight">Q: How can I make videos?</span>

<br><br>A: You can make videos with software included in your computer such as <a href="https://windows-movie-maker-vista.en.softonic.com/" target="_blank">Windows Movie Maker</a>, <a href="https://www.apple.com/lae/imovie/" target="_blank">Apple iMovie</a>, or Microsoft Paint; or you can use the <a href="/scratch_editor">Scratch Editor</a>, or the <a href="/paint_editor">Paint Editor</a>. You can also use various third-party software, like PenguinMod, Vegas Pro, Photoshop, Adobe Premiere Pro, Notepad++, FireAlpaca, and many more right <a href="http://www.newart.ru/everything.php" target="_blank">here at newart.ru</a>.
<br><br><span class="highlight">Q: How can I improve my videos?</span>

<br><br>A: We encourage you to edit your videos with software such as <a href="https://windows-movie-maker-vista.en.softonic.com/" target="_blank">Windows Movie Maker</a> (included with every Windows installation), or <a href="https://www.apple.com/lae/imovie/" target="_blank">Apple iMovie</a>. Using these programs you can easily edit your videos, add soundtracks, etc.

<br><br><span class="highlight">Q: How can I get Macromedia Flash 8 and start making Flash projects?</span>
<br><br>A: <a href="//archive.org/download/macromedia-flash-8/Flash8-en.exe" target="_blank">Download Flash 8 right here</a>, turn off your internet, and install it. After it's done, enter the serial number: <code>WPD800-51933-55332-70430</code> . Keep your internet off until it's fully installed. After that, you can turn on your internet. <a href="https://www.youtube.com/playlist?list=PLD608317DA17633E2" target="_blank">This tutorial right here</a> can help you learn how to use Flash 8.

<br><br><span class="highlight">Q: Why don't Flash projects, Silverlight projects, Shockwave projects, Chibi Paint, Scratch 2.0 projects, and the Scratch 2.0 editor work properly?</span>
<br><br>A: <a href="/t/plugin_tutorial">Read this page</a>.


<br><br><span class="highlight">Q: How do I use BBCode?</span>
<br><br>A: We use the NBBC BBCode Parser to parse BBCode. You can find how by visiting <a href="//nbbc.sourceforge.net/readme.php@page=bbc.html" target="_blank">the official website</a>. For the BBCode editor, we use MarkItUp, you can find help by visiting <a href="//web.archive.org/web/20190731135356/http://markitup.jaysalvat.com/documentation/" target="_blank">the official website</a>. Holding the [Alt] key while clicking on a button or pressing the shortcut keys allows you to set advanced options. Additionally, we support <a href="//en.scratch-wiki.info/wiki/Block_Plugin/Syntax" target="_blank">the ScratchBlocks plugin</a> for rendering Scratch blocks, more text formatting tags, and embedding from other sites; which could be accessed from the MarkItUp editor.

<br><br><span class="highlight">Q: How do I format my comments and descriptions?</span>
<br><br>A: We support markdown-like formatting in comments and descriptions, and we also support forum emotes and smileys. To insert a smiley, it's just like what you do in the forums. Here is how you can format your comments and descriptions with the markdown-like formatting:
</p>
<table width="100%">
        <tr>
            <th>
                Font
            </th>
            <th>
                Markdown
            </th>
        </tr>
        <tr>
            <td>
                <span style="text-shadow:0px 0px 40px #00fe20, 0px 0px 2px #00fe20">Glow Text</span>
            </td>
            <td>
                %%Glow Text%%
            </td>
        </tr>
        <tr>
            <td>
                <span style="text-shadow:0px 0px 40px #fffb00, 0px 0px 2px #fffb00">Sneed Text</span>
            </td>
            <td>
                ::Sneed Text::
            </td>
        </tr>
        <tr>
            <td>
                <span style="text-shadow:0px 0px 40px #bd0606, 0px 0px 2px #bd0606">Red Glow</span>
            </td>
            <td>
                !!Red Glow!!
            </td>
        </tr>
        <tr>
            <td>
                <span style="text-shadow:0px 0px 40px #36d7f7, 0px 0px 2px #36d7f7">Blue glow</span>
            </td>
            <td>
                ;;Blue glow;;
            </td>
        </tr>
        <tr>
            <td>
                <b style="color:#af0a0f;">RED TEXT</b>
            </td>
            <td>
                ==RED TEXT==
            </td>
        </tr>
        <tr>
            <td>
                <b style="color:#2424ad;">BLUE TEXT</b>
            </td>
            <td>
                --BLUE TEXT--
            </td>
        </tr>
        <tr>
            <td>
                <b style="color:#720b98;">VIOLET TEXT</b>
            </td>
            <td>
                -=VIOLET TEXT-=
            </td>
        </tr>
        <tr>
            <td>
                <span style="color:#f6750b;">&lt;ORANGE TEXT</span>
            </td>
            <td>
                &lt;ORANGE TEXT <sup>(arrow must be put first in line; affects entire line)</sup>
            </td>
        </tr>
        <tr>
            <td>
                <span style="color:#789922;">&gt;GREEN TEXT</span>
            </td>
            <td>
                &gt;GREEN TEXT <sup>(arrow must be put first in line; affects entire line)</sup>
            </td>
        </tr>
        <tr>
            <td>
                <span style="color:#6577E6;">^LIGHT BLUE TEXT</span>
            </td>
            <td>
                 ^LIGHT BLUE TEXT <sup>(arrow must be put first in line; affects entire line)</sup>
            </td>
        </tr>
        <tr>
            <td>
                <b>BOLD</b>
            </td>
            <td>
                '''BOLD''' <sup>(three prime symbols)</sup>
            </td>
        </tr>
        <tr>
            <td>
                <i>Italic</i>
            </td>
            <td>
                ''Italic'' <sup>(two prime symbols)</sup>
            </td>
        </tr>
        <tr>
            <td>
                <s>STRIKETHROUGH</s>
            </td>
            <td>
                ~~STRIKETHROUGH~~
            </td>
        </tr>
        <tr>
            <td>
                <span class="bbcode_spoiler">SPOILER</span>
            </td>
            <td>
                **SPOILER**
            </td>
        </tr>
        <tr>
            <td>
                <u>UNDERLINE</u>
            </td>
            <td>
                __UNDERLINE__
            </td>
        </tr>
        <tr>
            <td>
                <code>CODE</code>
            </td>
            <td>
                ```CODE```
            </td>
        </tr>
        <tr>
            <td>
                <span style="font-size:x-large">Big Text</span>
            </td>
            <td>
                +=Big Text=+
            </td>
        </tr>
        <tr>
            <td>
                <span style="background: linear-gradient(to left, red, orange, yellow, green, cyan, blue, violet);-webkit-background-clip: text;-webkit-text-fill-color: transparent;">Rainbow text</span>
            </td>
            <td>
                ~-~Rainbow text~-~
            </td>
        </tr>
        <tr>
            <td>
                <span style="color:#FD3D98; font-weight:bold;"><b>Pisces Text</b></span>
            </td>
            <td>
                -~-Pisces Text-~-
            </td>
        </tr>
        <tr>
            <td>
                <span class="aagiko">Shift-JIS Text</span>
            </td>
            <td>
                @$Shift-JIS Text@$
            </td>
        </tr>
        <tr>
            <td>
                <span style="font-size:x-small">Tiny Text</span>
            </td>
            <td>
                _=Tiny Text=_
            </td>
        </tr>
</table>
<p class="intro-text" style="line-height: 18px;margin-bottom: 20px;">

<br><br><span class="highlight">Q: I found something that is violating the Community Guidelines. How to report it?</span>
<br><br>A: To report a video on WrapperTube, click the 'Flag' button below the video player and report the video for the rule that it's breaking. For other things like comments, users, forum threads, etc.; report it to the staff listed in the <a href="/t/about_wrappertube">about page</a>.

<br><br><span class="highlight">Q: What are you doing to prevent content that violates your policies from appearing in WrapperTube?</span>

<br><br>A: We do a preliminary review on uploaded videos through both a manual and automated process. Although we try our best to detect and remove videos that violate our policy guidelines, our review process is primarily focused on removing adult content or obvious policy violations, and is not bulletproof. However, we encourage our viewers to notify us when they discover policy violations -- we have a process for reviewing reported policy violations.

<br><br><span class="highlight">Q: How can I get more help?</span>

<br><br>A: You can get more help with the <a href="/community">community forums</a>, the <a href="//wiki.wrappertube.org/">WrapperTube Wiki</a>, or the <a href="irc://irc.wrappertube.org/" target="_parent">WrapperTubeNET IRC Server</a> <a href="https://irc.wrappertube.org/">(Web Chat)</a>.

<br><br><span class="highlight">Q: This place is pretty neat, what can I do to help?</span>

<br><br>A: You can <a href="/videos">explore</a> projects people are making, <a href="/forum/category?c=Introduction">introduce</a> yourself to the community, actively engage with the website, <a href="/scratch_editor">create</a> original content/characters, lurk moar, read/contribute to the <a href="//wiki.wrappertube.org/">wiki</a>, and share the website with your friends.<br>
You can click &quot;Subscribe&quot; on any user to receive updates.<br>
Out of ideas or cannot think of anything to make? Try exploring <a href="//scratch.mit.edu/starter_projects" target="_blank">Starter Projects</a> and the <a href="//scratch.mit.edu/ideas" target="_blank">random idea generator</a>.<br>
									</p>
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
