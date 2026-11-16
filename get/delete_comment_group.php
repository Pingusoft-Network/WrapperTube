<?php ob_start(); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/insert.php"); ?>
<?php
    $_user_fetch_utils = new user_fetch_utils();
    $_video_fetch_utils = new video_fetch_utils();
    $_user_insert_utils = new user_insert_utils();
    $_base_utils = new config_setup();
    
    $_base_utils->initialize_db_var($conn);
    $_video_fetch_utils->initialize_db_var($conn);
    $_user_fetch_utils->initialize_db_var($conn);
    $_user_insert_utils->initialize_db_var($conn);

    $group = $_video_fetch_utils->fetch_group_id($_GET['gid']);
    $comment = $_user_fetch_utils->fetch_group_comment_id($_GET['cid']);
?>
<?php
if($_user_fetch_utils->if_group_admin($_SESSION['siteusername'], $_GET['gid']) && $comment['toid'] == $_GET['gid']) {
    $stmt = $conn->prepare("DELETE FROM group_discussion WHERE toid = ? AND id = ?");
    $stmt->bind_param("ss", $_GET['gid'], $_GET['cid']);
    $stmt->execute();
    $stmt->close();
}

die("OK");
?>
