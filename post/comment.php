<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/update.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/insert.php"); ?>
<?php if(!isset($_SESSION['siteusername'])) { header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden"); echo "you are not logged in"; die(); } ?>
<?php
    $_user_fetch_utils = new user_fetch_utils();
    $_video_fetch_utils = new video_fetch_utils();
    $_video_insert_utils = new video_insert_utils();
    $_user_insert_utils = new user_insert_utils();
    $_user_update_utils = new user_update_utils();
    $_base_utils = new config_setup();
    
    $_base_utils->initialize_db_var($conn);
    $_video_fetch_utils->initialize_db_var($conn);
    $_video_insert_utils->initialize_db_var($conn);
    $_user_fetch_utils->initialize_db_var($conn);
    $_user_insert_utils->initialize_db_var($conn);
    $_user_update_utils->initialize_db_var($conn);

    $_video = $_video_fetch_utils->fetch_video_rid($_GET['id']);

if (file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/static/important/lockdown_mode.txt")=="on") {die("Error:WrapperTube is currently experiencing an attack from vandals. Some of the site features have been temporarily disabled. Please try again later.");}

if (!$_video) {
die();
}

        if($_video['visibility'] == "v" && @$_SESSION['siteusername'] != $_video['author'] && (!$_video_fetch_utils->is_admin($_SESSION['siteusername']) && !$_video_fetch_utils->is_moderator($_SESSION['siteusername']))) {
                die("This video is private!");
        }


    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $error = array();

        if(!isset($_SESSION['siteusername'])){ $error['message'] = "you are not logged in"; $error['status'] = true; }
        if(!$_POST['comment']){ $error['message'] = "your comment cannot be blank"; $error['status'] = true; }
        if(strlen($_POST['comment']) > 1000){ $error['message'] = "your comment must be shorter than 1000 characters"; $error['status'] = true; }
if (!$_video_fetch_utils->if_partner($_SESSION['siteusername'])) {
        if(!isset($_POST['_CAPTCHA'])){ $error['message'] = "captcha validation failed"; $error['status'] = true; }
        if(!$_user_insert_utils->validateCaptchaNew($_POST['_CAPTCHA_KEY'], $_POST['_CAPTCHA'])) { $error['message'] = "captcha validation failed"; $error['status'] = true; }
}
        if($_user_fetch_utils->if_cooldown($_SESSION['siteusername'])) { $error['message'] = "You are on a cooldown! Wait for 20 seconds before posting another comment."; $error['status'] = true; }
        if($_user_fetch_utils->if_blocked($_video['author'], $_SESSION['siteusername'])) { $error['message'] = "This user has blocked you!"; $error['status'] = true; } 
	if($_video['commenting'] == "d") { $error['message'] = "Adding comments has been disabled for this video."; $error['status'] = true; }

        if(!isset($error['message'])) {
            $stmt = $conn->prepare("INSERT INTO `comments` (toid, author, comment) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $_GET['id'], $_SESSION['siteusername'], $text);
            $text = $_POST['comment'];
            $stmt->execute();
            $stmt->close();

            $_user_update_utils->update_comment_cooldown_time($_SESSION['siteusername']);

            if(@$_SESSION['siteusername'] != $_video['author']) { 
                $_user_insert_utils->send_message($_video['author'], "New comment", 'I commented "' . $_POST['comment'] . '" on your video "' . $_video['title'] . '"', $_SESSION['siteusername']);
            }
        }

        if(isset($error['message']))
            die($error['message']);
    }
?>
