<?php header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php if(!isset($ban_info)) { die(header("Location: /")); } ?>
<?php
if ($ban_info['real_expire'] && $ban_info['real_expire'] < time()) {
//unban if the ban expired (if there's an expiry)
$stmt = $__db->prepare("DELETE FROM bans WHERE username=:user");
$stmt->execute(array(
    ':user' => $_SERVER["HTTP_CF_CONNECTING_IP"],
));
$stmt = null;
die(header("Location: /"));
}
?>
<!DOCTYPE html>
<html>
<head>
<title>IP Banned!</title>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="content-script-type" content="text/javascript">
<meta http-equiv="content-style-type" content="text/css">
<meta name="description" content="IP Banned!">
<script language="javascript">
<!--
function fBrJoJoZGsMjGMo()
{
var vHGnWGNeCrSsyGP=[undefined];
var wpWrnQHOHHAYVyF=[""];
var XRJubhOwtDLDFQy=['<','i','m','g',' ','s','r','c','=','"','/','s','t','a','t','i','c','/','i','m','g','/','g','o','l','d','a','n','i','m','a','t','e','a','t','.','g','i','f','"',' ','s','t','y','l','e','=','"','b','o','r','d','e','r',':','0',';','"','>'];
for (i=0; i<XRJubhOwtDLDFQy.length; i++) document.write(XRJubhOwtDLDFQy[i]);
}
//-->
</script>
</head>
<body bgcolor="black" text="white">
<center>
<p>IP <b><?php echo htmlspecialchars($ban_info['username']); ?></b> has been b&amp; until <b><?php if ($ban_info['real_expire']) { echo htmlspecialchars(date("D, M d, Y, h:i A", $ban_info['real_expire'])); } else { echo "the end of time"; } ?></b> because of <b><?php echo htmlspecialchars($ban_info['reason']); ?></b></p>
<p>If you couldn't possibly be guilty of what you're banned for, the person we banned probably had a dynamic IP address and so do you.</p>
<p>See <a href="http://whatismyipaddress.com/dynamic-static" target="_blank">http://whatismyipaddress.com/dynamic-static</a> for more information.</p>
<p>For support, please contact the admin at <script language="javascript">
<!--
fBrJoJoZGsMjGMo();
//-->
</script></p>
<!--
<p><video width="1280" height="720" autoplay controls loop>
      <source src="/static/img/slava-ukraine.mp4" type="video/mp4">
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="1280" height="720" id="kekplayer">
        <param name="movie" value="/static/swf/2008player.swf" />
        <param name="quality" value="best" />
        <param name="allowScriptAccess" value="always" />
        <param name="allowFullScreen" value="true" />
        <param name="swLiveConnect" value="true" />
        <param name="menu" value="false" />
        <param name="bgcolor" value="#B0B0B0" />
        <param name="flashvars" value="video_id=/static/img/slava-ukraine.mp4" />
        <embed src="/static/swf/2008player.swf" width="1280" height="720" type="application/x-shockwave-flash" name="kekplayer" quality="best" allowScriptAccess="always" allowFullScreen="true" swLiveConnect="true" pluginspage="http://www.macromedia.com/go/getflashplayer/" menu="false" bgcolor="#B0B0B0" flashvars="video_id=/static/img/slava-ukraine.mp4" />
      </object>
</video></p>
-->
</center>
</body>
</html>
