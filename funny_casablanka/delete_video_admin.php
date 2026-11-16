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
    if(!$__user_h->if_admin($_SESSION['siteusername'])) { header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found"); include $_SERVER['DOCUMENT_ROOT'] . '/404.php'; die(); }

    $video = $__video_h->fetch_video_rid($_GET['v']);
    $request = (object) [
        "video" => $_GET['v'],
        "from" => $_SESSION['siteusername'],

        "error" => (object) [
            "message" => "",
            "status" => "OK"
        ]
    ]; 

  if(strpos($video['thumbnail'], "default") === false) {
   unlink('../dynamic/thumbs/' . $video['thumbnail']);
  }
    unlink('../dynamic/videos/' . $video['filename']);
    $stmt = $__db->prepare("DELETE FROM videos WHERE rid=:video");
    $stmt->execute(array(
        ':video' => $request->video,
    ));
    $stmt = null;

$__user_i->admin_log("admin", $_SESSION['siteusername'], "I deleted the video, \"" . $video['title'] . "\" with the description, \"" . $video['description'] . "\" by, " . $video['author']);

    header("Location: /?success=BALEETED!");

    //echo json_encode($request, JSON_PRETTY_PRINT);
?>
