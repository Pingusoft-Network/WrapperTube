<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
use SimpleCaptcha\Builder;
/**
* @Auther: bhief
* @Version: 1.0
*
* Inserts user information
*
**/
class user_insert {
    public $__db;

	public function __construct($conn){
        $this->__db = $conn;
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

    function check_view_channel($vidid, $user) {
        $stmt = $this->__db->prepare("SELECT 1 FROM channel_views WHERE viewer = :user AND channel = :vidid LIMIT 1");
        $stmt->bindParam(":user", $user);
        $stmt->bindParam(":vidid", $vidid);
        $stmt->execute();
	$rowExists = (bool)$stmt->fetchColumn();
        $stmt = null;
        if(!$rowExists) {
            $this->add_view_channel($vidid, $user);
        }
    }
    
    function add_view_channel($vidid, $user) {
        $stmt = $this->__db->prepare("INSERT INTO channel_views (viewer, channel) VALUES (:user, :vidid)");
        $stmt->bindParam(":user", $user);
        $stmt->bindParam(":vidid", $vidid);
        $stmt->execute();
        $stmt = null;
    }   

    function send_message($author, $subject, $to, $message, $video = "", $type = "nm") {
        $stmt = $this->__db->prepare("INSERT INTO pms (owner, subject, touser, message, video_attribute, type) VALUES (:owner, :subject, :touser, :message, :video, :type)");
        $stmt->bindParam(":owner", $author);
        $stmt->bindParam(":subject", $subject);
        $stmt->bindParam(":touser", $to);
        $stmt->bindParam(":message", $message);
        $stmt->bindParam(":video", $video);
        $stmt->bindParam(":type", $type);
        $stmt->execute();
        $stmt = null;
    }   


    function add_to_history($vidid, $user) {
        $stmt = $this->__db->prepare("INSERT INTO history (video, author) VALUES (:video, :author)");
        $stmt->bindParam(":video", $vidid);
        $stmt->bindParam(":author", $user);
        $stmt->execute();
        $stmt = null;
    }

    function admin_log($toid, $owner, $log) {
        $stmt = $this->__db->prepare("INSERT INTO admin_logs (toid, owner, log) VALUES (:id, :owner, :log)");
        $stmt->bindParam(":id", $toid);
        $stmt->bindParam(":owner", $owner);
        $stmt->bindParam(":log", $log);
        $stmt->execute();
        $stmt = null;
    }
}

?>
