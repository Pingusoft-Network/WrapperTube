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

    $group = $_video_fetch_utils->fetch_group_id($_GET['id']);
if (!$_user_fetch_utils->user_exists($_GET['user'])) { die(header('Location: /group/' . $_GET['id'] . "?error=this user doesn't exist")); }
if ($_user_fetch_utils->if_joined_group($_GET['user'], $_GET['id'])) { die(header('Location: /group/' . $_GET['id'] . "?error=this user was already added")); }
?>
<?php if(!isset($_SESSION['siteusername'])) { die(header("Location: /sign_in")); die(); } ?>
<?php

if(!$_user_fetch_utils->if_joined_group($_GET['user'], $_GET['id']) && $_user_fetch_utils->if_group_admin($_SESSION['siteusername'], $_GET['id'])) {
    $stmt = $conn->prepare("INSERT INTO group_members (togroup, username) VALUES (?, ?)");
    $stmt->bind_param("ss", $_GET['id'], $_GET['user']);
    $stmt->execute();
    $stmt->close();

    $_user_insert_utils->send_message($_GET['user'], "Added to Group", 'You have been added to the group ' . $group['group_title'], $_SESSION['siteusername']);
}

header('Location: /group/' . htmlspecialchars($_GET['id']));
?>
