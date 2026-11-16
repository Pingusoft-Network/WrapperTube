<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_insert.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/email.php'); ?>
<?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__user_i = new user_insert($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php if(isset($_SESSION['siteusername'])) { die(header("Location: /")); } ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['username'] && $_POST['_CAPTCHA']) {

        $request = (object) [
            "username" => $_POST['username'],
            "rid" => bin2hex(random_bytes(64)),

            "error" => (object) [
                "message" => "",
                "status" => "OK"
            ]
        ]; 

        $stmt = $__db->prepare("SELECT email FROM users WHERE username = :username LIMIT 1");
        $stmt->bindParam(":username", $request->username);
        $stmt->execute();

        if(!$stmt->rowCount()){ 
            { $request->error->message = "User doesn't exist!"; $request->error->status = ""; } }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
	$email = $row['email'];

	$stmt = null;

        if(!isset($_POST['_CAPTCHA']))
            { $request->error->message = "captcha validation failed"; $request->error->status = ""; }

        if(!$__user_i->validateCaptchaNew($_POST['_CAPTCHA_KEY'], $_POST['_CAPTCHA']))
            { $request->error->message = "captcha validation failed"; $request->error->status = ""; }
        
        if($request->error->status == "OK") {
            $stmt6 = $__db->prepare("DELETE FROM reset_password WHERE username = :username");
            $stmt6->bindParam(":username", $request->username);
            $stmt6->execute();
            $stmt6 = null;
            $stmt = $__db->prepare("INSERT INTO reset_password (username, rid) VALUES (:username, :rid)");
            $stmt->bindParam(":username", $request->username);
            $stmt->bindParam(":rid", $request->rid);
            $stmt->execute();
            $stmt = null;
	    if (send_a_mail($email, $request->username, "WrapperTube - Reset Password", "Navigate to this link to reset your password:\nhttp://wrappertube.org/forgot_password2?id=" . $request->rid . "\nIf you didn't request a password reset, please ignore this message.\nThe link expires in 30 minutes.")) {
                die(header("Location: /forgot_password?success=Now check your email (and check your spam folder!) for instructions on how to recover your password."));
	    } else {
                $stmt6 = $__db->prepare("DELETE FROM reset_password WHERE username = :username");
                $stmt6->bindParam(":username", $request->username);
                $stmt6->execute();
                $stmt6 = null;
                $request->error->message = "Mail failed to send!";
                $request->error->status = "";
                session_start();
                $_SESSION['error'] = $request->error;
                session_write_close(); 
                die(header("Location: /forgot_password"));
            }
        } else {
            session_start();
            $_SESSION['error'] = $request->error;
            session_write_close();
            die(header("Location: /forgot_password"));
        }

    } else {
            $request->error->message = "Please fill out the required fields.";
            $request->error->status = "";
            session_start();
            $_SESSION['error'] = $request->error;
            session_write_close();
            die(header("Location: /forgot_password"));
    }
