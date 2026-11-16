<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_insert.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__user_i = new user_insert($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php if(isset($_SESSION['siteusername'])) { die(header("Location: /")); } ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['password'] && $_POST['username'] && $_POST['_CAPTCHA']) {

        $request = (object) [
            "username" => $_POST['username'],
            "password" => $_POST['password'],
            "password_hash" => password_hash($_POST['password'], PASSWORD_DEFAULT),
            "returned_password" => "",

            "error" => (object) [
                "message" => "",
                "status" => "OK"
            ]
        ]; 

        $stmt = $__db->prepare("SELECT username, password FROM users WHERE username = :username LIMIT 1");
        $stmt->bindParam(":username", $request->username);
        $stmt->execute();

        if(!$stmt->rowCount()){ 
            { $request->error->message = "Incorrect username or password!"; $request->error->status = ""; } }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = null;
        if(!isset($row['password'])) 
            { $request->error->message = "Incorrect username or password!"; $request->error->status = ""; } 
        else 
            { $request->returned_password = $row['password']; }

        if(!password_verify($request->password, $request->returned_password)) 
            { $request->error->message = "Incorrect username or password!"; $request->error->status = ""; }

        if(!isset($_POST['_CAPTCHA']))
            { $request->error->message = "captcha validation failed"; $request->error->status = ""; }

        if(!$__user_i->validateCaptchaNew($_POST['_CAPTCHA_KEY'], $_POST['_CAPTCHA']))
            { $request->error->message = "captcha validation failed"; $request->error->status = ""; }
        
        if($request->error->status == "OK") {
            session_start();
            $_SESSION['siteusername'] = $row['username'];
            session_write_close();
            die(header("Location: /"));
        } else {
            session_start();
            $_SESSION['error'] = $request->error;
            session_write_close();
            die(header("Location: /sign_in"));
        }
    } else {
        $request->error->message = "Please fill out the required fields.";
        $request->error->status = "";
        session_start();
        $_SESSION['error'] = $request->error;
        session_write_close();
        die(header("Location: /sign_in"));
}
?>
