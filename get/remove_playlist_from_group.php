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
?>
<?php
if($_user_fetch_utils->if_group_admin($_SESSION['siteusername'], $_GET['gid']) && $_user_fetch_utils->if_playlist_in_group($_GET['vid'], $_GET['gid'])) {
    $stmt = $conn->prepare("DELETE FROM group_playlists WHERE toid = ? AND playlist = ?");
    $stmt->bind_param("ss", $_GET['gid'], $_GET['vid']);
    $stmt->execute();
    $stmt->close();
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
