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
if(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/static/important/signups_disabled.txt")=="on"){die("Sign ups are currently closed.");}
    function remove_emoji($text) {

        $clean_text = "";

        // Match Emoticons
        $regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
        $clean_text = preg_replace($regexEmoticons, '', $text);

        // Match Miscellaneous Symbols and Pictographs
        $regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
        $clean_text = preg_replace($regexSymbols, '', $clean_text);

        // Match Transport And Map Symbols
        $regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
        $clean_text = preg_replace($regexTransport, '', $clean_text);

        // Match Miscellaneous Symbols
        $regexMisc = '/[\x{2600}-\x{26FF}]/u';
        $clean_text = preg_replace($regexMisc, '', $clean_text);

        // Match Dingbats
        $regexDingbats = '/[\x{2700}-\x{27BF}]/u';
        $clean_text = preg_replace($regexDingbats, '', $clean_text);

        return $clean_text;
    }


    if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['password'] && $_POST['username'] && $_POST['_CAPTCHA']) {

        $request = (object) [
            "username" => $_POST['username'],
            "password" => $_POST['password'],
            "repeatpassword" => $_POST['repeatpassword'],
            "email" => $_POST['email'],
            "iagree" => $_POST['iagree'],
            "password_hash" => password_hash($_POST['password'], PASSWORD_DEFAULT),

            "error" => (object) [
                "message" => "",
                "status" => "OK"
            ]
        ]; 

	//STOPFORUMSPAM
        $IP_VAL = file_get_contents("http://api.stopforumspam.org/api?ip=".$_SERVER["HTTP_CF_CONNECTING_IP"]);
	if (strpos($IP_VAL,"<appears>yes</appears>") !== false) {
                $request->error->message = "It looks like your IP address has been recently used for spamming. Please try again later.";
                $request->error->status = "";
                session_start();
                $_SESSION['error'] = $request->error;
                session_write_close();
                header("Location: /sign_up");
                die();
	}
/*
        //STOPFORUMSPAM - E-Mail
        $EMAIL_VAL = file_get_contents("http://api.stopforumspam.org/api?email=".urlencode($request->email));
        if (strpos($EMAIL_VAL,"<appears>yes</appears>") !== false) {
                $request->error->message = "It looks like this E-Mail address has been recently used for spamming. Please try a different one.";
                $request->error->status = "";
                session_start();
                $_SESSION['error'] = $request->error;
                session_write_close();
                header("Location: /sign_up");
                die();
        }
*/

	$IP_VAL = file_get_contents("http://check.getipintel.net/check.php?ip=".$_SERVER["HTTP_CF_CONNECTING_IP"]."&contact=changeme&flags=m"); //change the contact to your email address.
        if ((float)$IP_VAL > 0.7) {
		$request->error->message = "It appears you're a Proxy / VPN / bad IP.";
                $request->error->status = "";
                session_start();
                $_SESSION['error'] = $request->error;
                session_write_close();
                header("Location: /sign_up");
                die();
	}

        $request->username = remove_emoji($request->username);

        // Sign-up rate limit.
        $stmt = $__db->prepare("SELECT count(*) FROM users WHERE created >= NOW() - INTERVAL 600 SECOND");
        $stmt->execute();
        $userCount = (int)$stmt->fetchColumn();
        $stmt = null;

        if($userCount >= 15) { $request->error->message = "WrapperTube is currently experiencing an attack from vandals. The registrations and all actions from new users are temporarily disabled. Please come back later."; $request->error->status = "";  }

        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) 
            { $request->error->message = "Your email is invalid!"; $request->error->status = "";  }
        if(strlen($request->username) > 51) 
            { $request->error->message = "Your username must be shorter than 50 characters."; $request->error->status = ""; }
        if(strlen($request->password) < 8) 
            { $request->error->message = "Your password must at least be 8 characters long."; $request->error->status = ""; }
        if(!preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $request->password)) 
            { $request->error->message = "Include numbers and letters in your password!"; $request->error->status = ""; }
        if(!preg_match('/^[a-zA-Z0-9._\s-]+$/', $request->username)) 
            { $request->error->message = "Your username can only contain letters, numbers, spaces, underscores, hyphens, and periods!"; $request->error->status = ""; }
        if(empty(trim($request->username))) 
            { $request->error->message = "Your username cannot be empty!"; $request->error->status = ""; }
        if($request->username == '.' || $request->username == '..')
            { $request->error->message = "Your username cannot be exactly \".\" or \"..\"!"; $request->error->status = ""; }
        if($request->password != $request->repeatpassword)
            { $request->error->message = "Passwords do not match!"; $request->error->status = ""; }
        if(!isset($_POST['_CAPTCHA']))
            { $request->error->message = "captcha validation failed"; $request->error->status = ""; }
        if(!$__user_i->validateCaptchaNew($_POST['_CAPTCHA_KEY'], $_POST['_CAPTCHA']))
            { $request->error->message = "captcha validation failed"; $request->error->status = ""; }
        if($request->iagree != "on")
            { $request->error->message = "You must agree to the community guidelines and the terms of use!"; $request->error->status = ""; }
        
        $stmt = $__db->prepare("SELECT 1 FROM users WHERE username = lower(:username) LIMIT 1");
        $stmt->bindParam(":username", $request->username);
        $stmt->execute();
        $rowExists = (bool)$stmt->fetchColumn();
        $stmt = null;
        if($rowExists) 
            { $request->error->message = "There's already a user with that same username!"; $request->error->status = ""; }

        $stmt = $__db->prepare("SELECT 1 FROM bans WHERE username = lower(:username) LIMIT 1");
        $stmt->bindParam(":username", $request->username);
        $stmt->execute();
        $rowExists = (bool)$stmt->fetchColumn();
        $stmt = null;
        if($rowExists) 
            { $request->error->message = "This user has been terminated!"; $request->error->status = ""; }
        
        if($request->error->status == "OK") {
            $stmt = $__db->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            $stmt->bindParam(":username", $request->username);
            $stmt->bindParam(":email", $request->email);
            $stmt->bindParam(":password", $request->password_hash);
            $stmt->execute();
            $stmt = null;

            session_start();
            $_SESSION['siteusername'] = $request->username;
            session_write_close();
            die(header("Location: /"));
        } else {
            session_start();
            $_SESSION['error'] = $request->error;
            session_write_close();
            die(header("Location: /sign_up"));
        }
    } else {
       $request->error->message = "Please fill out the required fields.";
       $request->error->status = "";
       session_start();
       $_SESSION['error'] = $request->error;
       session_write_close();
       die(header("Location: /sign_up"));
}
?>
