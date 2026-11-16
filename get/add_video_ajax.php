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
    $video = $_video_fetch_utils->fetch_video_rid($_GET['vid']);
?>
<?php if(!isset($_SESSION['siteusername'])) { die("Not Logged In."); } ?>
<?php if(!$video) { die("This video doesn't exist"); } ?>
<?php if($_user_fetch_utils->if_video_in_group($_GET['vid'], $_GET['gid'])) { die("This video was already added"); } ?>
<?php

if($_user_fetch_utils->if_joined_group($_SESSION['siteusername'], $_GET['gid'])) {
    $stmt = $conn->prepare("INSERT INTO group_videos (video, toid, author) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $_GET['vid'], $_GET['gid'], $_SESSION['siteusername']);
    $stmt->execute();
    $stmt->close();
}

die("Successfully added the video to " . $group['group_title']);
?>
