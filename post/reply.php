<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/update.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/insert.php"); ?>
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
?>
<?php if(!isset($_SESSION['siteusername'])) { header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden"); echo "you are not logged in"; die(); } ?>
<?php 
if($_SERVER['REQUEST_METHOD'] == 'POST') {
if (file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/static/important/lockdown_mode.txt")=="on") {die("Error:WrapperTube is currently experiencing an attack from vandals. Some of the site features have been temporarily disabled. Please try again later.");}
    $error = false;
    if(!$_POST['id']){ $error = true; goto skip; }
    $original_comment = $_user_fetch_utils->fetch_comment_id($_POST['id']);
    if(!$original_comment){ $error = true; goto skip; }
    $_video = $_video_fetch_utils->fetch_video_rid($_GET['id']);
    if(!$_video){ $error = true; goto skip; }
    if($_video['visibility'] == "v" && @$_SESSION['siteusername'] != $_video['author'] && (!$_video_fetch_utils->is_admin($_SESSION['siteusername']) && !$_video_fetch_utils->is_moderator($_SESSION['siteusername']))){ $error = true; goto skip; }
    if($_video['commenting'] == "d"){ $error = true; goto skip; }

    if(!isset($_SESSION['siteusername'])){ $error = true; goto skip; }
    if(!$_POST['comment']){ $error = true; goto skip; }
    if(strlen($_POST['comment']) > 1000){ $error = true; goto skip; }
    if($_user_fetch_utils->if_cooldown($_SESSION['siteusername'])) { $error = true; goto skip; }
    if($_user_fetch_utils->if_blocked($original_comment['author'], $_SESSION['siteusername'])) { $error['message'] = "This user has blocked you!"; $error['status'] = true; }

    if($error == false) {
        $stmt = $conn->prepare("INSERT INTO `comment_reply` (toid, author, comment) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $_POST['id'], $_SESSION['siteusername'], $text);
        $text = $_POST['comment'];
        $stmt->execute();
        $stmt->close();
        $_user_update_utils->update_comment_cooldown_time($_SESSION['siteusername']);
    }

    skip:
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>
