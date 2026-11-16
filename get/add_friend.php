<?php ob_start(); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/insert.php"); ?>
<?php
    $_user_fetch_utils = new user_fetch_utils();
    $_video_fetch_utils = new video_fetch_utils();
    $_user_insert_utils = new user_insert_utils();
    $_base_utils = new config_setup();
    
    $_base_utils->initialize_db_var($conn);
    $_video_fetch_utils->initialize_db_var($conn);
    $_user_fetch_utils->initialize_db_var($conn);
    $_user_insert_utils->initialize_db_var($conn);

?>
<?php if(!isset($_SESSION['siteusername'])) { die("not logged in"); } ?>
<?php

if($_SESSION['siteusername'] == $_GET['sending'])
    die("You can't friend yourself!");

if (!$_user_fetch_utils->user_exists($_GET['sending'])) {
    die("This user doesn't exist!");
}

$stmt = $conn->prepare("SELECT 1 FROM friends WHERE sender = ? AND reciever = ? AND (status = 'a' OR status = 'u') LIMIT 1");
$stmt->bind_param("ss", $_SESSION['siteusername'], $_GET['sending']);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows === 1) die('You already sent a friend request to this person or are friends with this person.');
$stmt->close();

$stmt4 = $conn->prepare("SELECT 1 FROM friends WHERE sender = ? AND reciever = ? AND status = 'd' LIMIT 1");
$stmt4->bind_param("ss", $_SESSION['siteusername'], $_GET['sending']);
    $stmt4->execute();
    $stmt4->store_result();
    if($stmt4->num_rows === 1) {

//add friend again

$stmt6 = $conn->prepare("UPDATE friends SET status = 'u' WHERE sender = ? AND reciever = ?");
$stmt6->bind_param("ss", $_SESSION['siteusername'], $_GET['sending']);

$stmt6->execute();
$stmt6->close();

$_user_insert_utils->send_message($_GET['sending'], "New friend request", 'I sent you a new friend request!', $_SESSION['siteusername']);
die("OK");

    }

$stmt4->close();

$stmt = $conn->prepare("INSERT INTO friends (sender, reciever, status) VALUES (?, ?, 'u')");
$stmt->bind_param("ss", $_SESSION['siteusername'], $_GET['sending']);

$stmt->execute();
$stmt->close();

$_user_insert_utils->send_message($_GET['sending'], "New friend request", 'I sent you a new friend request!', $_SESSION['siteusername']);
die("OK");
?>
