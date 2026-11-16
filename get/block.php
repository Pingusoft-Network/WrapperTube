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
<?php if(!isset($_SESSION['siteusername'])) { die(header("Location: /sign_in")); die(); } ?>
<?php
$name = $_GET['user'];
$author = $_SESSION['siteusername'];

if (!$_user_fetch_utils->user_exists($_GET['user'])) {
    die("This user doesn't exist!");
}

if ($_video_fetch_utils->is_admin($_GET['user'])) {
    die("You cannot block admins!");
}

if ($_video_fetch_utils->is_moderator($_GET['user'])) {
    die("You cannot block moderators!");
}

if(!isset($_SESSION['siteusername']) && !isset($_GET['user'])) {
    die("You are not signed in or the user does not exist.");
}

if($name == $_SESSION['siteusername']) {
    die("You cannot block yourself!");
}

$stmt = $conn->prepare("SELECT 1 FROM block WHERE sender = ? AND reciever = ? LIMIT 1");
$stmt->bind_param("ss", $_SESSION['siteusername'], $name);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows === 1) die('You already blocked this person!');
$stmt->close();

$stmt = $conn->prepare("INSERT INTO block (sender, reciever) VALUES (?, ?)");
$stmt->bind_param("ss", $_SESSION['siteusername'], $name);

$stmt->execute();
$stmt->close();
$author = htmlspecialchars($_SESSION['siteusername']);
die("OK");
?>
