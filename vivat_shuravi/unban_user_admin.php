<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_updater.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_insert.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_update.php"); ?><?php $__video_h = new video_helper($__db); ?>
<?php $__video_u = new video_updater($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__user_i = new user_insert($__db); ?>
<?php $__user_u = new user_update($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php
    if(!isset($_SESSION['siteusername'])) { header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found"); include $_SERVER['DOCUMENT_ROOT'] . '/404.php'; die(); }
    if(!$__user_h->if_moderator($_SESSION['siteusername'])) { header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found"); include $_SERVER['DOCUMENT_ROOT'] . '/404.php'; die(); }

    $request = (object) [
        "user" => $_GET['v'],
        "from" => $_SESSION['siteusername'],

        "error" => (object) [
            "message" => "",
            "status" => "OK"
        ]
    ]; 

    $stmt = $__db->prepare("DELETE FROM bans WHERE username=:user");
    $stmt->execute(array(
        ':user' => $request->user,
    ));
    $stmt = null;

$__user_i->admin_log("moderator", $_SESSION['siteusername'], "I unbanned the user, " . $request->user);

    header("Location: /vivat_shuravi/bans");

    //echo json_encode($request, JSON_PRETTY_PRINT);
?>
