<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_insert.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_update.php"); ?>
<?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__user_i = new user_insert($__db); ?>
<?php $__user_u = new user_update($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php if(!$__video_h->video_exists($_GET['v'])) { die(header("Location: /?error=This video doesn't exist!")); } ?>
<?php $_video = $__video_h->fetch_video_rid($_GET['v']); ?>
<?php $_video['comments'] = $__video_h->get_comments_from_video($_video['rid']); ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $error = array();
        $request = (object) [
            "status" => "success"
        ];
if (file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/static/important/lockdown_mode.txt")=="on") {die("WrapperTube is currently experiencing an attack from vandals. Some of the site features have been temporarily disabled. Please try again later.");}

        if(!$_video){ $error['message'] = "video does not exist"; $error['status'] = true; }
        if(!isset($_SESSION['siteusername'])){ $error['message'] = "you are not logged in"; $error['status'] = true; }
        if(!$_POST['comment']){ $error['message'] = "your comment cannot be blank"; $error['status'] = true; }
        if(strlen($_POST['comment']) > 1000){ $error['message'] = "your comment must be shorter than 1000 characters"; $error['status'] = true; }
if (!$__user_h->if_partner($_SESSION['siteusername'])) {
        if(!isset($_POST['_CAPTCHA'])){ $error['message'] = "captcha validation failed"; $error['status'] = true; }
        if(!$__user_i->validateCaptchaNew($_POST['_CAPTCHA_KEY'], $_POST['_CAPTCHA'])) { $error['message'] = "captcha validation failed"; $error['status'] = true; }
}
        if($__user_h->if_cooldown($_SESSION['siteusername'])) { $error['message'] = "You are on a cooldown! Wait for 20 seconds before posting another comment."; $error['status'] = true; }
	if($__user_h->if_blocked($_video['author'], $_SESSION['siteusername'])) { $error['message'] = "This user has blocked you!"; $error['status'] = true; }
	if($_video['commenting'] == "d") { $error['message'] = "Adding comments has been disabled for this video."; $error['status'] = true; }
        if($_video['visibility'] == "v" && @$_SESSION['siteusername'] != $_video['author'] && (!$__user_h->if_moderator(@$_SESSION['siteusername']) && !$__user_h->if_admin(@$_SESSION['siteusername']))) { $error['message'] = "This video is private"; $error['status'] = true; }

        if(!isset($error['message'])) {
			$text = $_POST['comment'];
            $stmt = $__db->prepare("INSERT INTO comments (toid, author, comment) VALUES (:v, :username, :comment)");
            $stmt->bindParam(":v", $_GET['v']);
			$stmt->bindParam(":username", $_SESSION['siteusername']);
			$stmt->bindParam(":comment", $text);
            $stmt->execute();
            $stmt = null;

			$__user_u->update_cooldown_time($_SESSION['siteusername'], "cooldown_comment");
        }

        die(json_encode($request));
    }
?>
