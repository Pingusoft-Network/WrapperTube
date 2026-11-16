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
$respvid = $_video_fetch_utils->fetch_video_rid($_GET['reciever']);
$sendvid = $_video_fetch_utils->fetch_video_rid($_GET['sending']);
?>
<?php if(!isset($_SESSION['siteusername'])) { die(header("Location: /sign_in")); die(); } ?>
<?php
  if($respvid['visibility'] == "v" && @$_SESSION['siteusername'] != $respvid['author'] && (!$_video_fetch_utils->is_admin($_SESSION['siteusername']) && !$_video_fetch_utils->is_moderator($_SESSION['siteusername']))) {
      die("This video is private!");
  }
  if(!$respvid || !$sendvid) {
      die("This video doesn't exist!");
  }
if ($sendvid['author'] != @$_SESSION['siteusername']) {
      die("That is not your video!");
}
?>
<?php
$stmt = $conn->prepare("DELETE FROM video_response WHERE video=?");
$stmt->bind_param("s", $_GET['sending']);
$stmt->execute();
$stmt->close();

$stmt = $conn->prepare("INSERT INTO video_response (toid, author, video) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $_GET['reciever'], $_SESSION['siteusername'], $_GET['sending']);
$stmt->execute();
$stmt->close();
if ($_SESSION['siteusername'] != $respvid['author']) {
    $_user_insert_utils->send_message_2($respvid['author'], "New video response", 'I responded to your video "' . $respvid['title'] . '"', $_SESSION['siteusername'], $_GET['sending'], "nt");
}

header('Location: /watch?v=' . htmlspecialchars($_GET['reciever']));
?>
