<?php

/**
* @Auther: bhief
* @Version: 1.0
* @Added Base
*
* Use this class for getting user information
*
**/
class user_helper {
    public $__db;

	public function __construct($conn){
        $this->__db = $conn;
	}

    function fetch_pfp($username) {
        $stmt = $this->__db->prepare("SELECT pfp FROM users WHERE username = :username LIMIT 1");
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pfp = $row['pfp'];
        } // why the while statement? just remove it (i cant be bothered to)
        $stmt = null;

        return (isset($pfp) ? $pfp : "default.png");
    }

    
    function fetch_unread_pms($user) {
        $stmt = $this->__db->prepare("SELECT count(*) FROM pms WHERE touser = :user AND readed = 'y'");
        $stmt->bindParam(":user", $user);
        $stmt->execute();
    
        $rowCount = (int)$stmt->fetchColumn();

        $stmt = null;

        return $rowCount;
    }

    function if_blocked($user, $reciever) {
        $stmt = $this->__db->prepare("SELECT 1 FROM block WHERE sender = :user AND reciever = :reciever LIMIT 1");
        $stmt->bindParam(":user", $user);
        $stmt->bindParam(":reciever", $reciever);
        $stmt->execute();

        $rowExists = (bool)$stmt->fetchColumn();
        $stmt = null;

        return $rowExists;
    }    

    function if_admin($user) {
        $stmt = $this->__db->prepare("SELECT 1 FROM users WHERE username = :user AND status = 'admin' LIMIT 1");
        $stmt->bindParam(":user", $user);
        $stmt->execute();

        $rowExists = (bool)$stmt->fetchColumn();
        $stmt = null;

        return $rowExists;
    }    

    function if_moderator($user) {
        $stmt = $this->__db->prepare("SELECT 1 FROM users WHERE username = :user AND status = 'moderator' LIMIT 1");
        $stmt->bindParam(":user", $user);
        $stmt->execute();

        $rowExists = (bool)$stmt->fetchColumn();
        $stmt = null;

        return $rowExists;
    }

    function if_partner($user) {
        $stmt = $this->__db->prepare("SELECT 1 FROM users WHERE username = :user AND partner = 'y' LIMIT 1");
        $stmt->bindParam(":user", $user);
        $stmt->execute();

        $rowExists = (bool)$stmt->fetchColumn();
        $stmt = null;

        return $rowExists;
    }    
    
    function if_2009($user) {
        $stmt = $this->__db->prepare("SELECT 1 FROM users WHERE username = :user AND is_2009 = 'v' LIMIT 1");
        $stmt->bindParam(":user", $user);
        $stmt->execute();

        $rowExists = (bool)$stmt->fetchColumn();
        $stmt = null;

        return $rowExists;
    }
    function if_cooldown($user) {
        if ($this->if_admin($user) || $this->if_moderator($user)) { return false; } // staff exempt
        $stmt = $this->__db->prepare("SELECT 1 FROM users WHERE username = :username AND cooldown_comment >= NOW() - INTERVAL 20 SECOND LIMIT 1");
        $stmt->bindParam(":username", $user);
        $stmt->execute();
        
        $rowExists = (bool)$stmt->fetchColumn();
        $stmt = null;

        return $rowExists;
    }

    function if_upload_cooldown($user) {
        if ($this->if_admin($user) || $this->if_moderator($user)) { return false; } // staff exempt
        $stmt = $this->__db->prepare("SELECT 1 FROM users WHERE username = :username AND upload_cooldown >= NOW() - INTERVAL 1 MINUTE LIMIT 1");
        $stmt->bindParam(":username", $user);
        $stmt->execute();
        
        $rowExists = (bool)$stmt->fetchColumn();
        $stmt = null;

        return $rowExists;
    }

    function fetch_user_username($username) {
        $stmt = $this->__db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        $valu = ($stmt->rowCount() === 0 ? 0 : $stmt->fetch(PDO::FETCH_ASSOC));

        $stmt = null;

        return $valu;
    }

    function fetch_quicklist_videos($username) {
        $stmt = $this->__db->prepare("SELECT count(*) FROM quicklist_videos WHERE author = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();
    
        $rowCount = (int)$stmt->fetchColumn();

        $stmt = null;

        return $rowCount;
    }

    function user_exists($user) {
        $stmt = $this->__db->prepare("SELECT 1 FROM users WHERE username = :username LIMIT 1");
        $stmt->bindParam(":username", $user);
        $stmt->execute();

        $rowExists = (bool)$stmt->fetchColumn();
        $stmt = null;

        return $rowExists;
    }

    function if_subscribed($user, $reciever) {
        $stmt = $this->__db->prepare("SELECT 1 FROM subscribers WHERE sender = :sender AND reciever = :reciever LIMIT 1");
        $stmt->bindParam(":sender", $user);
        $stmt->bindParam(":reciever", $reciever);
        $stmt->execute();

        $rowExists = (bool)$stmt->fetchColumn();
        $stmt = null;

        return $rowExists;
    }

    function fetch_subs_count($username) {
        $stmt = $this->__db->prepare("SELECT count(*) FROM subscribers WHERE reciever = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        $rowCount = (int)$stmt->fetchColumn();

        $stmt = null;

        return $rowCount;
    }

    function fetch_user_videos(string $id) {
        $stmt = $this->__db->prepare("SELECT count(*) FROM videos WHERE author = :id AND visibility = 'n'");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        
        $rowCount = (int)$stmt->fetchColumn();

        $stmt = null;

        return $rowCount;
    }

    function fetch_all_user_videos(string $id) {
        $stmt = $this->__db->prepare("SELECT count(*) FROM videos WHERE author = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $rowCount = (int)$stmt->fetchColumn();

        $stmt = null;

        return $rowCount;
    }

    function fetch_user_favorites(string $username) {
        $stmt = $this->__db->prepare("SELECT count(*) FROM favorite_video WHERE sender = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute(); 
    
        $rowCount = (int)$stmt->fetchColumn();

        $stmt = null;

        return $rowCount;
    }

    function fetch_subscriptions($username) {
        $stmt = $this->__db->prepare("SELECT count(*) FROM subscribers WHERE sender = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();
    
        $rowCount = (int)$stmt->fetchColumn();

        $stmt = null;

        return $rowCount;
    }

    function get_channel_views(string $rid) {
        $stmt = $this->__db->prepare("SELECT count(*) FROM channel_views WHERE channel = :rid");
        $stmt->bindParam(":rid", $rid);
        $stmt->execute();
        
        $rowCount = (int)$stmt->fetchColumn();

        $stmt = null;

        return $rowCount;
    }

    function fetch_friends_accepted($username) {
        $stmt = $this->__db->prepare("SELECT count(*) FROM friends WHERE (reciever = :username AND status = 'a') OR (sender = :username2 AND status = 'a')");
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":username2", $username);
        $stmt->execute();
    
        $rowCount = (int)$stmt->fetchColumn();

        $stmt = null;

        return $rowCount;
    }

    function fetch_history_ammount($username) {
        $stmt = $this->__db->prepare("SELECT count(*) FROM history WHERE author = :author");
        $stmt->bindParam(":author", $username);
        $stmt->execute();
    
        $rowCount = (int)$stmt->fetchColumn();

        $stmt = null;

        return $rowCount;
    }
}

?>
