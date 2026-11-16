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
    $video = $_video_fetch_utils->fetch_playlist_rid($_GET['vid']);
?>
<?php if(!isset($_SESSION['siteusername'])) { die(header("Location: /sign_in")); die(); } ?>
<?php if(!$video) { die(header('Location: /group/' . $_GET['gid'] . "?error=this playlist doesn't exist")); } ?>
<?php if($_user_fetch_utils->if_playlist_in_group($_GET['vid'], $_GET['gid'])) { die(header('Location: /group/' . $_GET['gid'] . "?error=this playlist was already added")); } ?>
<?php

if($_user_fetch_utils->if_joined_group($_SESSION['siteusername'], $_GET['gid']) || $group['group_club'] == "y") {
    $stmt = $conn->prepare("INSERT INTO group_playlists (playlist, toid, author) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $_GET['vid'], $_GET['gid'], $_SESSION['siteusername']);
    $stmt->execute();
    $stmt->close();
}

header('Location: /group/' . $_GET['gid']);
?>
