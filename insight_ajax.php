<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_update.php"); ?><?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__user_u = new user_update($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php if(!$__video_h->video_exists($_GET['v'])) { die(); } ?>
<?php $_video = $__video_h->fetch_video_rid($_GET['v']); ?>
<?php 
        if($_video['visibility'] == "v" && @$_SESSION['siteusername'] != $_video['author'] && (!$__user_h->if_moderator(@$_SESSION['siteusername']) && !$__user_h->if_admin(@$_SESSION['siteusername']))) {
                die(header("Location: /?error=This video is private!"));
        }
header('Content-Type: application/xml; charset=utf-8');

echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<root><html_content><![CDATA[
<div id="watch-stats" class="yt-rounded">
    <table id="watch-some-stats" cellspacing="0" cellpadding="0" width="100%">

        <tbody><tr>
            <td>Added: <span class="watch-stat"><?php echo date("D, M d, Y, h:i A", strtotime($_video['publish'])); ?></span></td>
            <td>Views: <span class="watch-stat"><?php echo $__video_h->fetch_video_views($_GET['v']); ?></span></td>
            <td>Ratings: <span class="watch-stat"><?php echo $__video_h->get_video_stars($_GET['v']) +  $__video_h->get_video_likes($_GET['v'],true) + $__video_h->get_video_likes($_GET['v'],false); ?></span></td>
        </tr>
        <tr>
            <td>Responses: <a class="hLink bold" href="/video_response_view_all?v=<?php echo htmlspecialchars($_GET['v']); ?>" onmousedown=""><?php echo $__video_h->get_video_responses($_GET['v']); ?></a></td>
            <td>Comments: <span class="watch-stat"><?php echo $__video_h->get_comments_from_video($_GET['v']); ?></span></td>
            <td>Favourited: <span class="watch-stat"><?php echo $__video_h->fetch_video_favourites($_GET['v']); ?> times</span></td>
        </tr>
        </tbody></table>
    </div>
]]></html_content><return_code><![CDATA[0]]></return_code></root>
