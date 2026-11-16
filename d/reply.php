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
<?php
$request = (object) [
    "to_id" => $_GET['id'],
    "comment" => $_POST['comment'],
    "sender" => $_SESSION['siteusername'],

    "error" => (object) [
        "message" => "",
        "status" => "OK"
    ]
];
if (file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/static/important/lockdown_mode.txt")=="on") {die("Error:WrapperTube is currently experiencing an attack from vandals. Some of the site features have been temporarily disabled. Please try again later.");}

if(empty(trim($request->comment))) { die("Error:your comment cannot be blank"); }
if(strlen($request->comment) > 1000) { die("Error:your comment must be shorter than 1000 characters"); }
if(empty(trim($request->to_id  ))) { die("Error:to id is missing"); }
$original_comment = $__video_h->fetch_comment_id($request->to_id);
if (!$original_comment) {
die("Error:comment doesn't exist");
}
$_video = $__video_h->fetch_video_rid($original_comment['toid']);
if (!$_video) {
die("Error:video does not exist");
}
if ($_video['commenting'] == "d") {
die("Error:Adding comments has been disabled for this video.");
}
if ($_video['visibility'] == "v" && @$_SESSION['siteusername'] != $_video['author'] && (!$__user_h->if_moderator(@$_SESSION['siteusername']) && !$__user_h->if_admin(@$_SESSION['siteusername']))) {
die("Error:This video is private");
}
if($__user_h->if_cooldown($_SESSION['siteusername'])) { die("Error:You are on a cooldown! Wait for 20 seconds before posting another comment."); }
if($__user_h->if_blocked($original_comment['author'], $_SESSION['siteusername'])) { die("Error:This user has blocked you!"); }
if(isset($_SESSION['siteusername'])) {
    $stmt = $__db->prepare("INSERT INTO comment_reply (toid, author, comment) VALUES (:to_id, :author, :comment)");
    $stmt->bindParam(":to_id",   $request->to_id);
    $stmt->bindParam(":author",  $request->sender);
    $stmt->bindParam(":comment", $request->comment);
    $stmt->execute();
    $stmt = null;
    $__user_u->update_cooldown_time($_SESSION['siteusername'], "cooldown_comment");
    if(@$_SESSION['siteusername'] != $original_comment['author']) {
        $__user_i->send_message($_SESSION['siteusername'], "New reply", $original_comment['author'], "I replied with \"" . $_POST['comment'] . "\" on your comment!", $original_comment['toid'], "nt");
    }

    die('OK:<li class="comment yt-tile-default " data-author-viewing="" data-author-id="-uD01K8FQTeOSS5sniRFzQ" data-id="420" data-score="0" style="margin-left: 30px;"><div class="comment-body"><div class="content-container"><div class="content"><div class="comment-text" dir="ltr"><p>' . $__video_h->shorten_description($_POST['comment'], 999999, true) . '<img src="null" onerror="ka_reload(false);" width="1" height="1"></p></div><p class="metadata"><span class="author "><a href="/user/' . htmlspecialchars($_SESSION['siteusername']) . '" class="yt-uix-sessionlink yt-user-name " data-sessionlink="' . htmlspecialchars($_SESSION['siteusername']) . '" dir="ltr">' . htmlspecialchars($_SESSION['siteusername']) . '</a></span><span class="time" dir="ltr"><span dir="ltr">just now<span></span></span></span></p></div><div class="comment-actions"><span class="yt-uix-button-group"><button type="button" class="start comment-action-vote-up comment-action yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" onclick=";return false;" title="Vote Up" data-action="vote-up" data-tooltip-show-delay="300" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-watch-comment-vote-up" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Vote Up"><span class="yt-valign-trick"></span></span></button><button type="button" class="end comment-action-vote-down comment-action yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" onclick=";return false;" title="Vote Down" data-action="vote-down" data-tooltip-show-delay="300" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-watch-comment-vote-down" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Vote Down"><span class="yt-valign-trick"></span></span></button></span><span class="yt-uix-button-group"><!--<button type="button" class="start comment-action yt-uix-button yt-uix-button-default" onclick=";return false;" data-action="reply" role="button"><span class="yt-uix-button-content">Reply </span></button>--><button type="button" class="end flip yt-uix-button yt-uix-button-default yt-uix-button-empty" onclick=";return false;" data-button-has-sibling-menu="true" role="button" aria-pressed="false" aria-expanded="false" aria-haspopup="true" aria-activedescendant=""><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""><div class=" yt-uix-button-menu yt-uix-button-menu-default" style="display: none;"><ul><li class="comment-action" data-action="share"><span class="yt-uix-button-menu-item">Share</span></li><li class="comment-action-remove comment-action" data-action="remove"><span class="yt-uix-button-menu-item">Remove</span></li><li class="comment-action" data-action="flag"><span class="yt-uix-button-menu-item">Flag for spam</span></li><li class="comment-action-block comment-action" data-action="block"><span class="yt-uix-button-menu-item">Block User</span></li><li class="comment-action-unblock comment-action" data-action="unblock"><span class="yt-uix-button-menu-item">Unblock User</span></li></ul></div></button></span></div></div></div></li>');
}
