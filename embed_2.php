<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php
if (!startsWith($_SERVER['REQUEST_URI'], "/embed/")) {
if($_GET['autoplay']) {
die(header("Location: /embed_video?".$_SERVER['QUERY_STRING']));
} else {
die(header("Location: /embed/" . $_GET['v']));
}
}
?>
<?php if(!$__video_h->video_exists($_GET['v'])) { header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found"); die("<body text='white' bgcolor='black'><font face='Arial,Helvetica'>This video doesn't exist!</font></body>"); } ?>
<?php $_video = $__video_h->fetch_video_rid($_GET['v']); ?>
<?php
        if($_video['visibility'] == "v" && @$_SESSION['siteusername'] != $_video['author'] && (!$__user_h->if_moderator(@$_SESSION['siteusername']) && !$__user_h->if_admin(@$_SESSION['siteusername']))){
                header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
                die("<body text='white' bgcolor='black'><font face='Arial,Helvetica'>This video is Private!</font></body>");
        }

if($_GET['autoplay']) {
die(header("Location: /embed_video?".$_SERVER['QUERY_STRING']));
}

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
      <meta property="og:title" content="<?php echo $__server->page_embeds->page_title; ?>" />
                <meta property="og:url" content="<?php echo $__server->page_embeds->page_url; ?>" />
                <meta property="og:description" content="<?php echo $__server->page_embeds->page_description; ?>" />
                <meta property="og:image" content="<?php echo $__server->page_embeds->page_image; ?>" />
        <script src="/static/js/core-js.js"></script>
<?php if ($_video['visibility'] != "n") { ?>
<meta name="robots" content="noindex, nofollow, noarchive">
<?php } ?>
</head>
<body style="color:white; background-color:black; overflow:hidden;">
    <div class="player" id="07player" style="cursor:pointer;" href="/embed_video?v=<?php echo htmlspecialchars($_GET['v']); ?>" onclick=";window.location.replace(this.getAttribute('href'));return false;">
    <div class="video-stream" style="
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0px;
        left: 0px;
    ">
    <img id="video-stream" src="/dynamic/thumbs/<?php echo htmlspecialchars($_video['thumbnail']); ?>" onerror="this.src='/dynamic/thumbs/default.png';" style="width: 100%;
        height: 100%;">
    <img src="/2009player/assets/playbutton.png" id="playbut" style="position: absolute;left: 0;top: 0;right: 0;bottom: 0;margin: auto;width: 83px;opacity: 0.9;">
    </div>
    </div>
        <script src="/static/js/prefixfree.min.js"></script>
</body>
</html>
