<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_update.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_insert.php"); ?>
<?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__user_i = new user_insert($__db); ?>
<?php $__user_u = new user_update($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php
$request = (object) [
    "name" => $_GET['n'],
    "sender" => $_SESSION['siteusername'],

    "error" => (object) [
        "message" => "",
        "status" => "OK"
    ]
];

if (!isset($_SESSION['siteusername'])) {
    $request->error->message = "You need to log in to add subscriptions!"; $request->error->status = "";
}

if(!$__user_h->user_exists($_GET['n'])) {
    $request->error->message = "This user does not exist!"; $request->error->status = "";
}

if($__user_h->if_subscribed(@$_SESSION['siteusername'], $request->name)) 
    { $request->error->message = "You are already subscribed to this person!"; $request->error->status = ""; }

if($request->error->status == "OK") { 
    $stmt = $__db->prepare("INSERT INTO subscribers (sender, reciever) VALUES (:sender, :reciever)");
    $stmt->bindParam(":sender", $request->sender);
    $stmt->bindParam(":reciever", $request->name);
    $stmt->execute();
    $stmt = null;
    $__user_i->send_message($_SESSION['siteusername'], "New subscriber", $_GET['n'], 'I subscribed to your channel!', "", "nt");
} else {
    echo json_encode($request->error);
}
?>
