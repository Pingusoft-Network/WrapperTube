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
        "id" => $_GET['id'],

        "error" => (object) [
            "message" => "",
            "status" => "OK"
        ]
    ]; 

        $stmt = $__db->prepare("SELECT * FROM pms WHERE id = :group LIMIT 1");
        $stmt->bindParam(":group", $request->id);
        $stmt->execute();
        $the_row = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = null;

    $stmt = $__db->prepare("UPDATE pms SET readed = 'r' WHERE id = :id");
    $stmt->execute(array(
        ':id' => $request->id
    ));
    $stmt = null;

$__user_i->admin_log("moderator", $_SESSION['siteusername'], "I deleted the message \"" . $the_row['message'] . "\" from " . $the_row['owner'] . " to " . $the_row['touser']);

    header('Location: ' . $_SERVER['HTTP_REFERER']);

    //echo json_encode($request, JSON_PRETTY_PRINT);
?>
