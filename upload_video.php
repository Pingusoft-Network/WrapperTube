<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php $__server->page_title = "Upload Video"; ?>
<?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php if(!isset($_SESSION['siteusername'])) { die(header("Location: /sign_in")); } ?>
<?php
	$__server->page_embeds->page_title = "WrapperTube - Upload Video";
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
        <link rel="stylesheet" href="/yt/cssbin/www-extra.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script>
            if (window.yt.timing) {yt.timing.tick("ct");}    
        </script>
<style type="text/css">
  .upload-add-tag {
  padding:2px;
  border-radius:3px;
  border:1px solid #d3d3d3;
  color:#000;
  background-color:#f3f3f3;
  cursor:pointer;
  }
</style>
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
					<?php if($__user_h->if_upload_cooldown($_SESSION['siteusername'])) { ?>
						<div id="masthead_child_div"><div class="yt-alert yt-alert-default yt-alert-error ">  <div class="yt-alert-icon">
							<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
						</div>
						<div class="yt-alert-buttons"></div><div class="yt-alert-content" role="alert">    <span class="yt-alert-vertical-trick"></span>
							<div class="yt-alert-message">
								You are under an upload cooldown. Please wait a minute.
							</div>
						</div></div></div>
					<?php } ?>

                    <div class="upload-div-top" <?php if($__user_h->if_upload_cooldown($_SESSION['siteusername'])) { ?>style="display:none;"<?php } ?>>
                        Upload video file
                    </div>
                    <div class="upload-div-base" style="height:440px;<?php if($__user_h->if_upload_cooldown($_SESSION['siteusername'])) { ?>display:none;<?php } ?>">
                        <div class="progressbar">
                            <img src="/static/img/uploading.gif" width="272" height="60"><br>
                            Your video is being uploaded... Please wait... [DO NOT LEAVE THIS PAGE EVEN IF IT IS AT 100%] <span class="timeRemaining"></span><br>
                            <div class="barbg">
                                <div class="bar"></div>
                            </div>
                        </div>
                        <div class="www-upload-left">
                            <center id="initial-upload">
                                <img src="/yt/imgbin/upload_button.png" onclick="$('#video-file').click();" style="width: 139px;cursor:pointer;"><br><br>
                                <button id="upl-but" class="yt-uix-button yt-uix-button-default" onclick="$('#video-file').click();">
                                    Select files from your computer
                                </button><br><br>
                                Or drag and drop a video file
                            </center>
                            <form enctype="multipart/form-data" id="upload_form" action="/d/upload_video" method="post">
                            <div class="upload-stage-2" style="display: none;">
                                <b>Title</b> <br><input id="video-title" placeholder="Video Title" class="yt-uix-form-input-text" style="width: 550px;margin-top: 3px;" type="text" name="title"><br><br>
                                <b>Description</b> <br>
                                <textarea name="description" class="yt-uix-form-input-text" style="width: 550px;margin-top: 3px;" placeholder="Video Description" id="com"></textarea><br>
<select onchange="insertThisInThere(this.value,'com');this.selectedIndex=0;">
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
</select><br><br>
                                <b>Tags</b> <br><input placeholder="Seperate with commas" class="yt-uix-form-input-text" style="width: 550px;margin-top: 3px;" type="text" name="tags" id="tags"><br><br>
                                <b>Recommended Tags</b><br><br>
                                <div style="width: 345px;">
                                    <span class="upload-add-tag" onclick="addTag('game');">+ game</span>
                                    <span class="upload-add-tag" onclick="addTag('funny');">+ funny</span>
                                    <span class="upload-add-tag" onclick="addTag('education');">+ education</span>
                                    <span class="upload-add-tag" onclick="addTag('blog');">+ blog</span>
                                    <span class="upload-add-tag" onclick="addTag('travel');">+ travel</span>
                                    <span class="upload-add-tag" onclick="addTag('science');">+ science</span>
                                </div>
                                <script>
                                    var tags = document.getElementById("tags");

                                    function addTag(tag) {
                                        tags.value = tags.value==""?tag:tags.value + ", " + tag;
                                    } 
                                </script><br><br>
                                <b>Video thumbnails</b><br><br>
                                Thumbnail selections will appear when the video has finished processing.<br><br>
<?php if (!$__user_h->if_partner($_SESSION['siteusername'])) { ?>
                                <script src="/long_captcha/captcha.js"></script><br>
<?php } ?>
                                <input type="submit" value="Upload Video" class="yt-uix-button yt-uix-button-default">
                            </div>
                        </div>
                        <div class="www-upload-right">
                            <div class="upload-initial-right">
                                <h1>More ways to upload and create</h1><br> 
                                <img src="/s/img/upload_multiple.png" style="vertical-align: top;">
                                <span style="display: inline-block;">
                                    <h4>Uploading high quality media</h4>
                                    <span class="small-text">
                                        WrapperTube <b>NOW</b> suports various media types like <br>
                                        images, videos, audio, documents, <br>
                                        Scratch projects, and SWF movies.<br>
                                        You can upload media up to 200MB.
                                    </span>
                                </span><br><br>
                                <img src="/s/img/record_from_webcam.png" style="vertical-align: top;">
                                <span style="display: inline-block;">
                                    <h4>Create a project with:</h4>
                                    <span class="small-text">
                                        <a href="/scratch_editor">Scratch Editor</a><br>
                                        <a href="/paint_editor">Paint Editor</a><br>
                                    </span>
                                </span><br><br>
                                <span style="display: inline-block;">
                                    <h4>Supported File Types:</h4>
                                    <span class="small-text">
                                        Video files - .flv, .mkv, .avi, .mov, .movie, .qt, .wmv, .asf, .mp4, .m4v, .3gp, .3g2, .mp(e)g<br>
                                        Audio files - .mp3, .wav, .m4a, .aac, .wma, .ogg, .aiff, .flac, .mpc<br>
                                        Image files - .png, .jpg, .jpeg, .jpe, .gif, .bmp<br>
                                        Text files - .txt<br>
                                        HTML files - .htm(l)<br>
                                        PDF files - .pdf<br>
                                        Flash files - .swf<br>
                                        Shockwave (Director) files - .dcr<br>
                                        Silverlight files - .xap<br>
                                        Scratch projects - .scratch, .sb, .sb2, .sb3, .pmp<br>
                                        Snap projects - .xml, .ypr
                                    </span>
                                </span><br><br>
                            </div>
                            <div class="upload-stage-2-right" style="display: none;">
                                <b>Category</b> <br>
                                <select style="margin-top:5px;" name="category" class="yt-uix-button yt-uix-button-default">
                                    <?php $categories = ["None", "Film & Animation", "Autos & Vehicles", "Music", "Pets & Animals", "Sports", "Travel & Events", "Gaming", "People & Blogs", "Comedy", "Entertainment", "News & Politics", "Howto & Style", "Education", "Science & Technology", "Nonprofits & Activism", "Poop-posting"]; ?>
                                    <?php foreach($categories as $categoryTag) { ?>
                                        <option value="<?php echo $categoryTag; ?>"><?php echo $categoryTag; ?></option>
                                    <?php } ?>
                                </select><br><br>
                                <b>Privacy</b> <span style="font-size:10px;">Change this option in the video manager.</span> <br><br>
                                <input class="yt-uix-form-input-radio" disabled type="radio" style="vertical-align: top;"> 
                                <span style="display: inline-block;">
                                    <b>Public</b><br>
                                    <span class="small-text">
                                        anyone can search for and view - <br>
                                        recommended
                                    </span>
                                </span><br><br>
                                <input class="yt-uix-form-input-radio" disabled type="radio" style="vertical-align: top;"> 
                                <span style="display: inline-block;">
                                    <b>Unlisted</b><br>
                                    <span class="small-text">
                                        anyone with the link can view
                                    </span>
                                </span><br><br>
                                <input class="yt-uix-form-input-radio" disabled type="radio" style="vertical-align: top;"> 
                                <span style="display: inline-block;">
                                    <b>Private</b><br>
                                    <span class="small-text">
                                        only people you choose can view
                                    </span>
                                </span><br>

                                <input name="privacy" type="text" style="visibility: hidden;">
                                <input id="video-file" type="file" name="video_file" style="visibility: hidden;">
                            </div>
                        </div>
                        </form>
                        <script>
                            var isUploading = false;
                            $("#video-file").click(function(){
                                $(this).val("");
                            });

                            $("#video-file").change(function(){
                                $(".upload-div-base").css("height", "520px");
                                $("#video-title").val($(this).val().replace(/^.*\\/, ""));
                                $("#initial-upload").fadeOut(20);
                                $(".upload-initial-right").fadeOut(20);
                                $(".upload-stage-2-right").fadeIn(300);
                                $(".upload-stage-2").fadeIn(300);
                            });

    $('#initial-upload').on('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
    });

    $('#initial-upload').on('dragenter', function() {
        $("#upl-but").text('Drop the Video File');
    });

    $('#initial-upload').on('dragleave', function() {
        $("#upl-but").text('Select files from your computer');
    });

$('#initial-upload').on('drop', function(e) {
    e.preventDefault();
    e.stopPropagation();
        var files = e.originalEvent.dataTransfer.files;

        if (files && files.length == 1) {
            $("#video-file").prop("files", files);
            $("#video-file").change();
        } else {
            alert("Please drag only one file.");
        }
    $("#upl-but").text('Select files from your computer');
});

                            $(function(){ // defer
                                var uploadform = $("#upload_form");
                                var progressbar = $(".progressbar");
                                var bar = $(".bar");
                                var postto = "/d/upload";

                                progressbar.hide(); 

                                // when you press submit
                                uploadform.on('submit', function(e){
                                    // i have to both of these for it to not redirect (i want it to redirect if JS is off) (replaced stopImmediatePropagation with stopPropagation to support older browsers)
                                    e.preventDefault();
                                    e.stopPropagation();
                                    
                                    // good luck understanding this crap. it's mostly copy pasted.
                                    $.ajax({
                                        xhr: function(){
                                            var xhr;
                                            if (window.XMLHttpRequest) {
                                                xhr = new XMLHttpRequest();
                                            } else {
                                                xhr = new ActiveXObject("Microsoft.XMLHTTP");
                                            }
                                            xhr.upload.addEventListener("progress", function(evt){
                                                if (evt.lengthComputable) {
                                                    var percentComplete = Math.floor((evt.loaded / evt.total) * 100);
                                                    bar.width(percentComplete + '%');
                                                    bar.text(percentComplete + '%');

                                                    var seconds_elapsed =   ( new Date().getTime() - started_at.getTime() )/1000;
                                                    var bytes_per_second =  seconds_elapsed ? loaded / seconds_elapsed : 0 ;
                                                    var Kbytes_per_second = bytes_per_second / 1000 ;
                                                    var remaining_bytes =   total - loaded;
                                                    var seconds_remaining = seconds_elapsed ? remaining_bytes / bytes_per_second : 'calculating' ;
                                                    jQuery( '.timeRemaining' ).html( '' );
                                                    jQuery( '.timeRemaining' ).append( seconds_remaining );
                                                }
                                            }, false);
                                            return xhr;
                                        },
                                        // if you can't understand this part you shouldn't be reading this
                                        type: 'POST',
                                        url: postto,
                                        // afaik this only works for POST. don't care enough to check.
                                        data: new FormData(uploadform[0]),
                                        // no idea why this crap is 'false'.
                                        contentType: false,
                                        cache: false,
                                        processData: false,
                                        // right before data starts to be sent
                                        beforeSend: function(){
                                            isUploading = true;
                                            uploadform.hide();
                                            progressbar.show();
                                            $(".upload-stage-2-right").hide();
                                            $(".upload-div-base").css("height", "128px");
                                            bar.width('0%');
                                        },
                                        // when the form gets a non-200 code probably
                                        error: function(xhr, ajaxOptions, thrownError) {
                                            isUploading = false;
                                            alert("Error while uploading: " + xhr.status + " " + xhr.responseText);
                                        },
                                        // when the form succeeds. resp is a string of what the server sent back 
                                        success: function(resp) {
                                            isUploading = false;
                                            console.log(resp);
                                            window.location = "/uploaded_video?v=" + resp;
                                        }
                                    });
                                });
                            }); // defer
                            window.onbeforeunload = function () {
                                if (isUploading) {
                                    // Firefox will not use the string. IE use it
                                    return "Your video is still uploading. Leaving the page will not abort the operaiton.";
                                }
                                // if nothing returned, browser leave the page without any message
                            }
                        </script>
                    </div>
                </div>
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
		<script>
			//yt.setMsg('FLASH_UPGRADE', "\u003cdiv class=\"yt-alert yt-alert-default yt-alert-error  yt-alert-player\"\u003e  \u003cdiv class=\"yt-alert-icon\"\u003e\n    \u003cimg s\u0072c=\"\/\/s.ytimg.com\/yt\/img\/pixel-vfl3z5WfW.gif\" class=\"icon master-sprite\" alt=\"Alert icon\"\u003e\n  \u003c\/div\u003e\n\u003cdiv class=\"yt-alert-buttons\"\u003e\u003c\/div\u003e\u003cdiv class=\"yt-alert-content\" role=\"alert\"\u003e    \u003cspan class=\"yt-alert-vertical-trick\"\u003e\u003c\/span\u003e\n    \u003cdiv class=\"yt-alert-message\"\u003e\n            You need to upgrade your Adobe Flash Player to watch this video. \u003cbr\u003e \u003ca href=\"http:\/\/get.adobe.com\/flashplayer\/\"\u003eDownload it from Adobe.\u003c\/a\u003e\n    \u003c\/div\u003e\n\u003c\/div\u003e\u003c\/div\u003e");
			//yt.setConfig({
			//'PLAYER_CONFIG': {"url": "\/\/s.ytimg.com\/yt\/swf\/masthead_child-vflRMMO6_.swf", "min_version": "8.0.0", "args": {"enablejsapi": 1}, "url_v9as2": "", "params": {"bgcolor": "#FFFFFF", "allowfullscreen": "false", "allowscriptaccess": "always"}, "attrs": {"width": "1", "id": "masthead_child", "height": "1"}, "url_v8": "", "html5": false}
			//});
			
			//yt.flash.embed("masthead_child_div", yt.getConfig('PLAYER_CONFIG'));
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
