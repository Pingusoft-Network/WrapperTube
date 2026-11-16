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
if (file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/static/important/lockdown_mode.txt")=="on") {die("Error:WrapperTube is currently experiencing an attack from vandals. Some of the site features have been temporarily disabled. Please try again later.");}
$_user = $__user_h->fetch_user_username($_GET['u']);
if (!$_user) {
die("Error:User doesn't exist.");
}
$error = array();
$request = (object) [
    "touser" => $_GET['u'],
    "comment" => $_POST['comment'],
    "username" => $_SESSION['siteusername'],

    "error" => (object) [
        "message" => "",
        "status" => "OK"
    ]
]; 

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!isset($request->username)){ $request->error->message = "you are not logged in"; $request->error->status = ""; }
    if(!$request->comment){ $request->error->message = "your comment cannot be blank"; $request->error->status = ""; }
if (!$__user_h->if_partner($_SESSION['siteusername'])) {
    if(!isset($_POST['_CAPTCHA'])){ $request->error->message = "captcha validation failed"; $request->error->status = ""; }
    if(!$__user_i->validateCaptchaNew($_POST['_CAPTCHA_KEY'], $_POST['_CAPTCHA'])) { $request->error->message = "captcha validation failed"; $request->error->status = ""; }
}
    if(strlen($request->comment) > 1000){ $request->error->message = "your comment must be shorter than 1000 characters"; $request->error->status = ""; }
    if($__user_h->if_cooldown($request->username)) { $request->error->message = "You are on a cooldown! Wait for 20 seconds before posting another comment."; $request->error->status = ""; }
    if($__user_h->if_blocked($_user['username'], $_SESSION['siteusername'])) { $request->error->message = "This user has blocked you!"; $request->error->status = ""; }
    if($_user['commenting'] == "n") { $request->error->message = "This channel has commenting disabled!"; $request->error->status = ""; }

    if($request->error->status == "OK") {
        $stmt = $__db->prepare("INSERT INTO profile_comments (toid, author, comment) VALUES (:username, :from, :comment)");
        $stmt->bindParam(":username", $request->touser);
        $stmt->bindParam(":from", $request->username);
        $stmt->bindParam(":comment", $request->comment);
        $stmt->execute();
        $stmt = null;

        $__user_u->update_cooldown_time($request->username, "cooldown_comment");
        if(@$request->username != $_user['username'])
            $__user_i->send_message($request->username, "New profile comment", $_user['username'], "I commented \"" . $request->comment . "\" on your profile!", "", "nt");
        
        die('OK:<li class="comment yt-tile-default " data-author-viewing="" data-author-id="-uD01K8FQTeOSS5sniRFzQ" data-id="420" data-score="0"><div class="comment-body"><div class="content-container"><div class="content"><div class="comment-text" dir="ltr"><p>' . $__video_h->shorten_description($_POST['comment'], 999999, true) . '</p></div><p class="metadata"><span class="author "><a href="/user/' . htmlspecialchars($_SESSION['siteusername']) . '" class="yt-uix-sessionlink yt-user-name " data-sessionlink="' . htmlspecialchars($_SESSION['siteusername']) . '" dir="ltr">' . htmlspecialchars($_SESSION['siteusername']) . '</a></span><span class="time" dir="ltr"><span dir="ltr">just now<span></span></span></span></p></div><div class="comment-actions hid"><span class="yt-uix-button-group hid" style="display:none;"><button type="button" class="start comment-action-vote-up comment-action yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" onclick=";return false;" title="Vote Up" data-action="vote-up" data-tooltip-show-delay="300" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-watch-comment-vote-up" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Vote Up"><span class="yt-valign-trick"></span></span></button><button type="button" class="end comment-action-vote-down comment-action yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" onclick=";return false;" title="Vote Down" data-action="vote-down" data-tooltip-show-delay="300" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-watch-comment-vote-down" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Vote Down"><span class="yt-valign-trick"></span></span></button></span><span class="yt-uix-button-group hid" style="display:none;"><!--<button type="button" class="start comment-action yt-uix-button yt-uix-button-default" onclick=";return false;" data-action="reply" role="button"><span class="yt-uix-button-content">Reply </span></button>--><button type="button" class="end flip yt-uix-button yt-uix-button-default yt-uix-button-empty" onclick=";return false;" data-button-has-sibling-menu="true" role="button" aria-pressed="false" aria-expanded="false" aria-haspopup="true" aria-activedescendant=""><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""><div class=" yt-uix-button-menu yt-uix-button-menu-default" style="display: none;"><ul><li class="comment-action" data-action="share"><span class="yt-uix-button-menu-item">Share</span></li><li class="comment-action-remove comment-action" data-action="remove"><span class="yt-uix-button-menu-item">Remove</span></li><li class="comment-action" data-action="flag"><span class="yt-uix-button-menu-item">Flag for spam</span></li><li class="comment-action-block comment-action" data-action="block"><span class="yt-uix-button-menu-item">Block User</span></li><li class="comment-action-unblock comment-action" data-action="unblock"><span class="yt-uix-button-menu-item">Unblock User</span></li></ul></div></button></span></div></div></div></li>');
    } else {
        die('Error:' . $request->error->message);
    }
}

