<?php ob_start(); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/insert.php"); ?>
<?php
  $_user_fetch_utils = new user_fetch_utils();
  $_user_insert_utils = new user_insert_utils();
  $_video_fetch_utils = new video_fetch_utils();
  $_base_utils = new config_setup();
 
  $_base_utils->initialize_db_var($conn);
  $_video_fetch_utils->initialize_db_var($conn);
  $_user_insert_utils->initialize_db_var($conn);
  $_user_fetch_utils->initialize_db_var($conn);
?>
<?php
$name = $_GET['v'];

if(!isset($_SESSION['siteusername']) || !isset($_GET['v'])) {
    die("You are not logged in or you did not put in an argument");
}

if(!is_int((int)$_GET['rating'])) {
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
}

if (!$_video_fetch_utils->video_exists($_GET['v'])) {
die("nonexistent video");
}

$vid = $_video_fetch_utils->fetch_video_rid($_GET['v']);

if((1 <= (int)$_GET['rating']) && ((int)$_GET['rating']) <= 5) {
    $stmt = $conn->prepare("SELECT 1 FROM stars WHERE sender = ? AND reciever = ? LIMIT 1");
    $stmt->bind_param("ss", $_SESSION['siteusername'], $name);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 1) {
            $_user_insert_utils->remove_star_video($_SESSION['siteusername'], $name);
            goto skip;
        }

    $stmt = $conn->prepare("SELECT 1 FROM likes WHERE sender = ? AND reciever = ? LIMIT 1");
    $stmt->bind_param("ss", $_SESSION['siteusername'], $name);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 1) {
            $_user_insert_utils->remove_like_video($_SESSION['siteusername'], $name);
            goto skip;
        }

    $stmt = $conn->prepare("INSERT INTO stars (sender, reciever, type) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $_SESSION['siteusername'], $name, $_GET['rating']);

    $stmt->execute();
    $stmt->close();

if ($_SESSION['siteusername'] != $vid['author']) {
    $_user_insert_utils->send_message_2($vid['author'], "New rating", 'I rated your video "' . $vid['title'] . '" ' . $_GET['rating'] . ' stars.', $_SESSION['siteusername'], $_GET['v'], "nt");
}

}
skip:
die("OK");
?>
