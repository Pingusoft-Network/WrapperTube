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
<?php if(!$__video_h->video_exists($_GET['v'])) { header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found"); die("<body text='white' bgcolor='black'><font face='Arial,Helvetica'>This video doesn't exist!</font></body>"); } ?>
<?php $_video = $__video_h->fetch_video_rid($_GET['v']); ?>
<?php
	if($_video['visibility'] == "v" && @$_SESSION['siteusername'] != $_video['author'] && (!$__user_h->if_moderator(@$_SESSION['siteusername']) && !$__user_h->if_admin(@$_SESSION['siteusername']))){
		header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
		die("<body text='white' bgcolor='black'><font face='Arial,Helvetica'>This video is Private!</font></body>");
        }

	$__video_h->check_view($_GET['v'], @$_SERVER["HTTP_CF_CONNECTING_IP"]);

        if(isset($_SESSION['siteusername'])) {
        if(!isset($_SESSION['adminlogin'])) {
            $__user_i->add_to_history($_GET['v'], @$_SESSION['siteusername']);
        }
        }

	/* 
	PREPARE EMBEDS CLASS -- function(string $page_title, string $page_description...) 
	Returns a list of arrays for compatibility purposes & but downside is ugly for loop codes 
	Work on this tomorrow or some crap idk lol
	*/

	/* 
	USE THE GOD DAMN __CONFIG MORE -- idiot
	Work on this tomorrow or some crap
	*/

	$__server->page_embeds->page_title = htmlspecialchars($_video['title']);
	$__server->page_embeds->page_description = htmlspecialchars($_video['description']);
	$__server->page_embeds->page_image = "/dynamic/thumbs/" . $_video['thumbnail'];
	$__server->page_embeds->page_url = "http://wrappertube.org/embed/" . htmlspecialchars($_video['rid']);
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
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
        <script src="/static/js/core-js.js"></script>
      <script>
         var yt = yt || {};yt.timing = yt.timing || {};yt.timing.tick = function(label, opt_time) {var timer = yt.timing['timer'] || {};if(opt_time) {timer[label] = opt_time;}else {timer[label] = new Date().getTime();}yt.timing['timer'] = timer;};yt.timing.info = function(label, value) {var info_args = yt.timing['info_args'] || {};info_args[label] = value;yt.timing['info_args'] = info_args;};yt.timing.info('e', "907722,906062,910102,927104,922401,920704,912806,927201,913546,913556,925109,919003,920201,912706,900816");yt.timing.wff = true;yt.timing.info('an', "");if (document.webkitVisibilityState == 'prerender') {document.addEventListener('webkitvisibilitychange', function() {yt.timing.tick('start');}, false);}yt.timing.tick('start');yt.timing.info('li','0');try {yt.timing['srt'] = window.gtbExternal && window.gtbExternal.pageT() ||window.external && window.external.pageT;} catch(e) {}if (window.chrome && window.chrome.csi) {yt.timing['srt'] = Math.floor(window.chrome.csi().pageT);}if (window.msPerformance && window.msPerformance.timing) {yt.timing['srt'] = window.msPerformance.timing.responseStart - window.msPerformance.timing.navigationStart;}    
      </script>
      <meta property="og:title" content="<?php echo $__server->page_embeds->page_title; ?>" />
		<meta property="og:url" content="<?php echo $__server->page_embeds->page_url; ?>" />
		<meta property="og:description" content="<?php echo $__server->page_embeds->page_description; ?>" />
		<meta property="og:image" content="<?php echo $__server->page_embeds->page_image; ?>" />
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
<?php if (endsWith($_video['filename'],".swf") || endsWith($_video['filename'],".scratch") || endsWith($_video['filename'],".sb") || endsWith($_video['filename'],".sb2")) { ?>
		<script src="/static/ruffle/ruffle.js"></script>
<?php } ?>
<?php if (endsWith($_video['filename'],".dcr")) { ?>
                <script src="/static/dirplayer/dirplayer-polyfill.js"></script>
<?php } ?>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link id="www-core-css" rel="stylesheet" href="/yt/cssbin/www-core-vfluMRDnk.css">
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
button[title="Large player"], button[title="Small player"] {
	display: none;
}
</style>
</head>
	<body style="margin:0px;padding:0px;width:100%;height:100%;overflow:hidden;background:none;">
					<div id="watch-container" itemscope="" itemtype="//schema.org/VideoObject" style="position:absolute;width:100%;height:100%;top:0px;bottom:0px;margin:0px;padding:0px;">
<?php if ( !endsWith($_video['filename'],".mp4") ) {
if (endsWith($_video['filename'],".jpg") || endsWith($_video['filename'],".png") || endsWith($_video['filename'],".jpeg") || endsWith($_video['filename'],".jpe") || endsWith($_video['filename'],".gif") || endsWith($_video['filename'],".bmp") || endsWith($_video['filename'],".svg")) {  ?>
<img width="100%" height="100%" src="/dynamic/videos/<?php echo($_video['filename']); ?>" alt="<?php echo(htmlspecialchars($_video['title'])); ?>">
<?php } elseif (endsWith($_video['filename'],".txt") || endsWith($_video['filename'],".htm") || endsWith($_video['filename'],".html")) { ?>
<iframe frameborder="0" width="100%" height="100%" src="/dynamic/videos/<?php echo($_video['filename']); ?>" allowfullscreen="true"></iframe>
<?php } elseif (endsWith($_video['filename'],".pdf")) { ?>
<embed src="/dynamic/videos/<?php echo($_video['filename']); ?>" width="100%" height="100%" type="application/pdf"></embed>
<?php } elseif (endsWith($_video['filename'],".swf")) { ?>
<div id="flashmovie" style="width:100%!important;height:100%!important;background-color:white!important;">
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
<?php } elseif (endsWith($_video['filename'],".dcr")) { ?>
<div id="flashmovie" style="width:100%!important;height:100%!important;background-color:white!important;">
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
<?php } elseif (endsWith($_video['filename'],".xap")) { ?>
<div id="flashmovie" style="width:100%!important;height:100%!important;background-color:white!important;">
      <object data="data:application/x-silverlight-2," type="application/x-silverlight-2" width="100%" height="100%">
        <param name="source" value="/dynamic/videos/<?php echo($_video['filename']); ?>" />
        <param name="background" value="white" />
        Microsoft Silverlight is required. <a href="http://go.microsoft.com/fwlink/?LinkId=124807">Get Microsoft Silverlight</a>.
      </object>
</div>
<?php } elseif (endsWith($_video['filename'],".sb3")) { ?>
<iframe src="/scratchtw/embed.html?addons=pause,gamepad,mute-project,remove-curved-stage-border,drag-drop&settings-button&username=<?php echo urlencode($_SESSION['siteusername']); ?>&project_url=<?php echo(isset($_SERVER['HTTPS']) ? 'https' : 'http') ?>%3A%2F%2F<?php echo($_SERVER['SERVER_NAME']) ?>%2Fdynamic%2Fvideos%2F<?php echo(urlencode($_video['filename'])); ?>" width="100%" height="100%" allowtransparency="true" frameborder="0" scrolling="no" allowfullscreen></iframe>
<?php } elseif (endsWith($_video['filename'],".pmp")) { ?>
<iframe src="/scratchpm/embed.html?addons=pause,gamepad,mute-project,remove-curved-stage-border,drag-drop&settings-button&username=<?php echo urlencode($_SESSION['siteusername']); ?>&project_url=<?php echo(isset($_SERVER['HTTPS']) ? 'https' : 'http') ?>%3A%2F%2F<?php echo($_SERVER['SERVER_NAME']) ?>%2Fdynamic%2Fvideos%2F<?php echo(urlencode($_video['filename'])); ?>" width="100%" height="100%" allowtransparency="true" frameborder="0" scrolling="no" allowfullscreen></iframe>
<?php } elseif(endsWith($_video['filename'],".scratch") || endsWith($_video['filename'],".sb") || endsWith($_video['filename'],".sb2")) { ?>
<div id="scratchproject" style="visibility: visible; position: relative; z-index: 1000; width:100%!important;height:100%!important;background-color:white!important;">
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
<?php } elseif (endsWith($_video['filename'],".xml") || endsWith($_video['filename'],".ypr")) { ?>
<iframe src="/snap/snap.html#run:<?php echo(isset($_SERVER['HTTPS']) ? 'https' : 'http') ?>://<?php echo($_SERVER['SERVER_NAME']) ?>/dynamic/videos/<?php echo(urlencode($_video['filename'])); ?>&embedMode&noExitWarning&noRun" id="scratchproject" width="100%" height="100%" allowtransparency="true" frameborder="0" scrolling="no" allowfullscreen></iframe>
<?php } elseif (endsWith($_video['filename'],".mp3")) { ?>
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
<?php }
} else { ?>
<script type="text/javascript">
if (detectFlash() && !detectRuffle()) {

document.write('\
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
');

}
</script>
<?php } ?>
					</div>
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
      var youTubePlayer = yt.player.update('watch-container', yt.playerConfig,
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
                          'WIDE_PLAYER_STYLES': [""],
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
                        'ENABLE_LIVE_COMMENTS': false  });

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
                        'ENABLE_LIVE_COMMENTS': false,
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
function shareVideoFromFlash(){
copyToClipboard('http://wrappertube.org/watch?v=<?php echo $_video['rid']; ?>');
alert('Link copied to your clipboard!');
}
function copyToClipboard(e) {
    var t = document.createElement("input");
    document.body.appendChild(t);
    t.value = e;
    t.select();
    document.execCommand("copy");
    t.parentNode.removeChild(t);
}
</script>
        <script src="/static/js/prefixfree.min.js"></script>
	</body>
</html>
