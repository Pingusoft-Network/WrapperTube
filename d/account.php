<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_updater.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_update.php"); ?><?php $__video_h = new video_helper($__db); ?>
<?php $__video_u = new video_updater($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__user_u = new user_update($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php
    if(!isset($_SESSION['siteusername'])) { die("You aren't logged in!"); }

    $request = (object) [
        "action"  => $_GET['action'],
        "email"   => $_POST['email'],
        "password"  => $_POST['password'],
        "new_password"  => $_POST['new_password'],
        "repeat_new_password" => $_POST['repeat_new_password'],
        "username"    => $_SESSION['siteusername'],
        "new_password_hash" => password_hash($_POST['new_password'], PASSWORD_DEFAULT),

        "error" => (object) [
            "message" => "",
            "status" => "OK"
        ]
    ]; 

    $user = $__user_h->fetch_user_username($_SESSION['siteusername']);

    if($request->action == "change_email") {
        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL))
            { $request->error->message = "Your email is invalid!"; $request->error->status = "";  }
        if (!password_verify($request->password, $user['password']))
            { $request->error->message = "Incorrect Password!"; $request->error->status = "";  }
/*
        //STOPFORUMSPAM - E-Mail
        $EMAIL_VAL = file_get_contents("http://api.stopforumspam.org/api?email=".urlencode($request->email));
        if (strpos($EMAIL_VAL,"<appears>yes</appears>") !== false) {
                $request->error->message = "This E-Mail address is not allowed!";
                $request->error->status = "";
                session_start();
                $_SESSION['error'] = $request->error;
                session_write_close();
                header("Location: /account/manage");
                die();
        }
*/
        if($request->error->status == "OK") {
            $__user_u->update_row($request->username, "email", $request->email);
            die(header("Location: /account/manage?success=E-Mail address changed successfully!"));
        } else {
            session_start();
            $_SESSION['error'] = $request->error;
            session_write_close();
            die(header("Location: /account/manage"));
        }
    } else if($request->action == "change_password") {
        if (!password_verify($request->password, $user['password']))
            { $request->error->message = "Incorrect Password!"; $request->error->status = "";  }
        if(strlen($request->new_password) < 8)
            { $request->error->message = "Your new password must at least be 8 characters long."; $request->error->status = ""; }
        if(!preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $request->new_password))
            { $request->error->message = "Include numbers and letters in your new password!"; $request->error->status = ""; }
        if($request->new_password != $request->repeat_new_password)
            { $request->error->message = "New Passwords do not match!"; $request->error->status = ""; }
        if (password_verify($request->new_password, $user['password']))
            { $request->error->message = "Your new password cannot be your current password!"; $request->error->status = "";  }
        if($request->error->status == "OK") {
            $__user_u->update_row($request->username, "password", $request->new_password_hash);
            session_start();
            $_SESSION = [];
            session_destroy();
            die(header("Location: /sign_in"));
        } else {
            session_start();
            $_SESSION['error'] = $request->error;
            session_write_close();
            die(header("Location: /account/manage"));
        }
    } else {
        die(header("Location: /account/manage"));
    }

    //echo json_encode($request, JSON_PRETTY_PRINT);
?>
