<?php
/**
 * Use this to insert data for users.
 *
 * Blah blah blah blah.
 *
 * @copyright  FulpTube
 * @since      Class available since FulpTube backend rewrite 5/9/21
 */ 
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use SimpleCaptcha\Builder;

class user_insert_utils {
    public $conn;
    function initialize_db_var($conn) {
        $this->conn = $conn;    
    }

    function initialize_server_vars($server) {
        $this->server = $server;    
    }

    function register($username, $email, $hashedpassword) {
        $stmt = $this->conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashedpassword);
        $stmt->execute();
        $stmt->close();
        return true;
    }
    
    function validateCaptcha($privatekey, $response) {
	$data = array(
            'secret' => $privatekey,
            'response' => $response
        );
	$verify = curl_init();
	curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
	curl_setopt($verify, CURLOPT_POST, true);
	curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($verify);
	// var_dump($response);
	$responseData = json_decode($response);
        return $responseData->success;
    }

    function validateCaptchaNew($key, $response) {
        session_start();
	$captcha = Builder::create();
	foreach ($_SESSION['captcha'] as $key6 => $captchaobject6) {
        	if (time() >= $captchaobject6['expire']) {
                	unset($_SESSION['captcha'][$key6]);
	        }
	}
        if ($_SESSION['captcha'][$key]) {
                $captchaobject = $_SESSION['captcha'][$key];
                if ( $captchaobject['referer'] == $_SERVER['HTTP_REFERER'] &&
                     $captchaobject['user_agent'] == $_SERVER['HTTP_USER_AGENT'] &&
                     $captchaobject['ip'] == $_SERVER["HTTP_CF_CONNECTING_IP"] &&
                     $captcha->compare($captchaobject['phrase'], $response) &&
                     time() < $captchaobject['expire'] ) {
			unset($_SESSION['captcha'][$key]);
                        return true;
                } else {
			unset($_SESSION['captcha'][$key]);
                        return false;
                }
        } else {
                return false;
        }
        session_write_close(); 
    }

    function validateLongCaptchaNew($key, $response) {
        session_start();
        $captcha = Builder::create();
        foreach ($_SESSION['long_captcha'] as $key6 => $captchaobject6) {
                if (time() >= $captchaobject6['expire']) {
                        unset($_SESSION['long_captcha'][$key6]);
                }
        }
        if ($_SESSION['long_captcha'][$key]) {
                $captchaobject = $_SESSION['long_captcha'][$key];
                if ( $captchaobject['referer'] == $_SERVER['HTTP_REFERER'] &&
                     $captchaobject['user_agent'] == $_SERVER['HTTP_USER_AGENT'] &&
                     $captchaobject['ip'] == $_SERVER["HTTP_CF_CONNECTING_IP"] &&
                     $captcha->compare($captchaobject['phrase'], $response) &&
                     time() < $captchaobject['expire'] ) {
                        unset($_SESSION['long_captcha'][$key]);
                        return true;
                } else {
                        unset($_SESSION['long_captcha'][$key]);
                        return false;
                }
        } else {
                return false;
        }
        session_write_close(); 
    }
    
    function send_message($to, $subject, $message, $owner) {
        $stmt = $this->conn->prepare("INSERT INTO pms (touser, subject, message, owner, type) VALUES (?, ?, ?, ?, 'nt')");
        $stmt->bind_param("ssss", $to, $subject, $message, $owner);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    function send_message_2($to, $subject, $message, $owner, $video = "", $type = "nm") {
        $stmt = $this->conn->prepare("INSERT INTO pms (touser, subject, message, owner, video_attribute, type) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $to, $subject, $message, $owner, $video, $type);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    function send_logs($toid, $owner, $message) {
        $stmt = $this->conn->prepare("INSERT INTO admin_logs (toid, owner, log) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $toid, $owner, $message);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    function remove_like_video($sender, $reciever) {
        $stmt = $this->conn->prepare("DELETE FROM likes WHERE sender = ? AND reciever = ?");
        $stmt->bind_param("ss", $sender, $reciever);
        $stmt->execute();
        $stmt->close();
    }    

    function add_dislike_video($sender, $reciever) {
        $stmt = $this->conn->prepare("INSERT INTO likes (sender, reciever, type) VALUES (?, ?, 'd')");
        $stmt->bind_param("ss", $sender, $reciever);
        $stmt->execute();
        $stmt->close();
    }    

    function add_like_video($sender, $reciever) {
        $stmt = $this->conn->prepare("INSERT INTO likes (sender, reciever, type) VALUES (?, ?, 'l')");
        $stmt->bind_param("ss", $sender, $reciever);
        $stmt->execute();
        $stmt->close();
    }

    function remove_star_video($sender, $reciever) {
        $stmt = $this->conn->prepare("DELETE FROM stars WHERE sender = ? AND reciever = ?");
        $stmt->bind_param("ss", $sender, $reciever);
        $stmt->execute();
        $stmt->close();
    }    

    function add_comment_dislike($sender, $reciever) {
        $stmt = $this->conn->prepare("INSERT INTO comment_likes (sender, reciever, type) VALUES (?, ?, 'd')");
        $stmt->bind_param("ss", $sender, $reciever);
        $stmt->execute();
        $stmt->close();
    }
}

/**
 * Use this to insert data for videos.
 *
 * Blah blah blah blah.
 *
 * @copyright  FulpTube
 * @since      Class available since FulpTube backend rewrite 5/9/21
 */ 
class video_insert_utils {
    public $conn;
    function initialize_db_var($conn) {
        $this->conn = $conn;    
    }

    function initialize_server_vars($server) {
        $this->server = $server;    
    }

    function check_view($vidid, $user) {
        $stmt = $this->conn->prepare("SELECT 1 FROM views WHERE viewer = ? AND videoid = ? LIMIT 1");
        $stmt->bind_param("ss", $user, $vidid);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 0) {
            $this->add_view($vidid, $user);
        }
        $stmt->close();
    }
    
    function add_view($vidid, $user) {
        $stmt = $this->conn->prepare("INSERT INTO views (viewer, videoid) VALUES (?, ?)");
        $stmt->bind_param("ss", $user, $vidid);
        $stmt->execute();
        $stmt->close();
    }    

    function check_view_channel($vidid, $user) {
        $stmt = $this->conn->prepare("SELECT 1 FROM channel_views WHERE viewer = ? AND channel = ? LIMIT 1");
        $stmt->bind_param("ss", $user, $vidid);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 0) {
            $this->add_view_channel($vidid, $user);
        }
        $stmt->close();
    }
    
    function add_view_channel($vidid, $user) {
        $stmt = $this->conn->prepare("INSERT INTO channel_views (viewer, channel) VALUES (?, ?)");
        $stmt->bind_param("ss", $user, $vidid);
        $stmt->execute();
        $stmt->close();
    }    

    function add_to_history($vidid, $user) {
        $stmt = $this->conn->prepare("INSERT INTO history (video, author) VALUES (?, ?)");
        $stmt->bind_param("ss", $vidid, $user);
        $stmt->execute();
        $stmt->close();
    }
}
?>
