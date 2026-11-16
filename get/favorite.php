<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_update.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_insert.php"); ?><?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__user_u = new user_update($__db); ?>
<?php $__user_i = new user_insert($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php if(!isset($_SESSION['siteusername'])) { die("You need to log in to favourite videos!"); } ?>
<?php
$name = $_GET['v'];
$author = $_SESSION['siteusername'];
$respvid = $__video_h->fetch_video_rid($name);

if (!$respvid) {
die("The video does not exist");
}

$stmt = $__db->prepare("SELECT 1 FROM favorite_video WHERE sender = :sender AND reciever = :reciever LIMIT 1");
$stmt->bindParam(":sender", $_SESSION['siteusername']);
$stmt->bindParam(":reciever", $name);
$stmt->execute();
$rowExists = (bool)$stmt->fetchColumn();
$stmt = null;

if($rowExists) { 
    die("You have already favorited this video.");
}

$stmt = $__db->prepare("INSERT INTO favorite_video (sender, reciever) VALUES (:sender, :reciever)");
$stmt->bindParam(":sender", $_SESSION['siteusername']);
$stmt->bindParam(":reciever", $name);
$stmt->execute();
$stmt = null;

if ($_SESSION['siteusername'] != $respvid['author']) {
    $__user_i->send_message($_SESSION['siteusername'], "New favourite", $respvid['author'], "I favourited your video \"" . $respvid['title'] . "\"", $name, "nt");
}

die("OK");
?>
