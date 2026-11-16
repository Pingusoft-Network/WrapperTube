<?php
/**
 * Use this to fetch data for users.
 *
 * Blah blah blah blah.
 *
 * @copyright  FulpTube
 * @since      Class available since FulpTube backend rewrite 5/9/21
 */ 
class user_fetch_utils {
    public $conn;
    function initialize_db_var($conn) {
        $this->conn = $conn;    
    }

    function initialize_server_vars($server) {
        $this->server = $server;    
    }

    function fetch_user_username($username) {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
            $stmt->bind_param("s", $username);
            $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if($result->num_rows === 0) {
            $stmt->close();
            return 0;
        } else {
            $stmt->close();
            return $user;
        }
    }

    function fetch_friends_accepted($username) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM friends WHERE (reciever = ? AND status = 'a') OR (sender = ? AND status = 'a')");
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();

        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();
    
        return $rowCount;
    }

    function fetch_friend_id($id) {
            $stmt = $this->conn->prepare("SELECT * FROM friends WHERE id = ? LIMIT 1");
            $stmt->bind_param("s", $id);
            $stmt->execute();
        $result = $stmt->get_result();
        $friend = $result->fetch_assoc();

        if($result->num_rows === 0) {
            $stmt->close();
            return 0;
        } else {
            $stmt->close();
            return $friend;
        }
    }

    function fetch_profile_comment_id($id) {
            $stmt = $this->conn->prepare("SELECT * FROM profile_comments WHERE id = ? LIMIT 1");
            $stmt->bind_param("s", $id);
            $stmt->execute();
        $result = $stmt->get_result();
        $comment = $result->fetch_assoc();

        if($result->num_rows === 0) {
            $stmt->close();
            return 0;
        } else {
            $stmt->close();
            return $comment;
        }
    }

    function fetch_group_comment_id($id) {
            $stmt = $this->conn->prepare("SELECT * FROM group_discussion WHERE id = ? LIMIT 1");
            $stmt->bind_param("s", $id);
            $stmt->execute();
        $result = $stmt->get_result();
        $comment = $result->fetch_assoc();

        if($result->num_rows === 0) {
            $stmt->close();
            return 0;
        } else {
            $stmt->close();
            return $comment;
        }
    }

    function fetch_comment_id($id) {
            $stmt = $this->conn->prepare("SELECT * FROM comments WHERE id = ? LIMIT 1");
            $stmt->bind_param("s", $id);
            $stmt->execute();
        $result = $stmt->get_result();
        $comment = $result->fetch_assoc();

        if($result->num_rows === 0) {
            $stmt->close();
            return 0;
        } else {
            $stmt->close();
            return $comment;
        }
    }

    function fetch_reply_id($id) {
            $stmt = $this->conn->prepare("SELECT * FROM comment_reply WHERE id = ? LIMIT 1");
            $stmt->bind_param("s", $id);
            $stmt->execute();
        $result = $stmt->get_result();
        $comment = $result->fetch_assoc();

        if($result->num_rows === 0) {
            $stmt->close();
            return 0;
        } else {
            $stmt->close();
            return $comment;
        }
    }

    function fetch_pm_id($id) {
            $stmt = $this->conn->prepare("SELECT * FROM pm WHERE id = ? LIMIT 1");
            $stmt->bind_param("s", $id);
            $stmt->execute();
        $result = $stmt->get_result();
        $pm = $result->fetch_assoc();

        if($result->num_rows === 0) {
            $stmt->close();
            return 0;
        } else {
            $stmt->close();
            return $pm;
        }
    }

    function fetch_unread_pms($id) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM pms WHERE touser = ? AND readed = 'y'");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }

    function fetch_quicklist_videos($id) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM quicklist_videos WHERE author = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }

    function fetch_friends_number($reciever, $sender) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM friends WHERE sender = ? AND reciever = ?");
        $stmt->bind_param("ss", $sender, $reciever);
        $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }

    function fetch_creation_date($username) {
            $stmt = $this->conn->prepare("SELECT created FROM users WHERE username = ? LIMIT 1");
            $stmt->bind_param("s", $username);
            $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if($result->num_rows === 0) {
            $stmt->close();
            return 0;
        } else {
            $stmt->close();
            return $user['created'];
        }
    }

    function fetch_user_videos($id) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM videos WHERE author = ? AND visibility = 'n'");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }

    function fetch_all_user_videos($id) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM videos WHERE author = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }

    function fetch_user_playlists($id) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM playlists WHERE author = ? AND visibility = 'n'");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }

    function fetch_all_user_playlists($id) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM playlists WHERE author = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }

    function if_subscribed($user, $reciever) {
        $stmt = $this->conn->prepare("SELECT 1 FROM subscribers WHERE sender = ? AND reciever = ? LIMIT 1");
        $stmt->bind_param("ss", $user, $reciever);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 1) { $stmt->close(); return true; } else { $stmt->close(); return false; }
    }

    function if_joined_group($user, $groupid) {
        $stmt = $this->conn->prepare("SELECT 1 FROM group_members WHERE username = ? AND togroup = ? LIMIT 1");
        $stmt->bind_param("ss", $user, $groupid);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 1) { $stmt->close(); return true; } else { $stmt->close(); return false; }
    }

    function if_video_in_group($video, $groupid) {
        $stmt = $this->conn->prepare("SELECT 1 FROM group_videos WHERE video = ? AND toid = ? LIMIT 1");
        $stmt->bind_param("ss", $video, $groupid);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 1) { $stmt->close(); return true; } else { $stmt->close(); return false; }
    }

    function if_playlist_in_group($playlist, $groupid) {
        $stmt = $this->conn->prepare("SELECT 1 FROM group_playlists WHERE playlist = ? AND toid = ? LIMIT 1");
        $stmt->bind_param("ss", $playlist, $groupid);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 1) { $stmt->close(); return true; } else { $stmt->close(); return false; }
    }


    function if_group_admin($user, $groupid) {
        $stmt = $this->conn->prepare("SELECT 1 FROM group_members WHERE username = ? AND togroup = ? AND (status = 'i' OR status = 'o') LIMIT 1");
        $stmt->bind_param("ss", $user, $groupid);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 1) { $stmt->close(); return true; } else { $stmt->close(); return false; }
    }

    function if_cooldown($user) {
        if ($this->is_admin($user) || $this->is_moderator($user)) { return false; } // staff exempt
        $stmt = $this->conn->prepare("SELECT 1 FROM users WHERE username = ? AND cooldown_comment >= NOW() - INTERVAL 20 SECOND LIMIT 1");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 1) { $stmt->close(); return true; } else { $stmt->close(); return false; }
    }

    function if_blocked($user, $reciever) {
        $stmt = $this->conn->prepare("SELECT 1 FROM block WHERE sender = ? AND reciever = ? LIMIT 1");
        $stmt->bind_param("ss", $user, $reciever);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 1) { $stmt->close(); return true; } else { $stmt->close(); return false; }
    }    

    function if_favorited($user, $reciever) {
        $stmt = $this->conn->prepare("SELECT 1 FROM favorite_video WHERE sender = ? AND reciever = ? LIMIT 1");
        $stmt->bind_param("ss", $user, $reciever);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 1) { $stmt->close(); return true; } else { $stmt->close(); return false; }
    }

    function fetch_mail($id) {
        $stmt = $this->conn->prepare("SELECT * FROM pms WHERE id = ? LIMIT 1");
        $stmt->bind_param("s", $id);
        $stmt->execute();
    $result = $stmt->get_result();
    $mail = $result->fetch_assoc();
    $stmt->close();
    
    return $mail;
    }    

    function get_channel_views(string $rid) {
            $stmt = $this->conn->prepare("SELECT count(*) FROM channel_views WHERE channel = ?");
            $stmt->bind_param("s", $rid);
            $stmt->execute();

        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }


    function if_liked_video($user, $videoid) {
        $stmt = $this->conn->prepare("SELECT 1 FROM likes WHERE sender = ? AND reciever = ? AND type = 'l' LIMIT 1");
        $stmt->bind_param("ss", $user, $videoid);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 1) { $stmt->close(); return true; } else { $stmt->close(); return false; }
    }

    function if_disliked_video($user, $videoid) {
        $stmt = $this->conn->prepare("SELECT 1 FROM likes WHERE sender = ? AND reciever = ? AND type = 'd' LIMIT 1");
        $stmt->bind_param("ss", $user, $videoid);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 1) { $stmt->close(); return true; } else { $stmt->close(); return false; }
    }

    function fetch_user_rating($id, $username) {
            $stmt = $this->conn->prepare("SELECT type FROM stars WHERE reciever = ? AND sender = ? LIMIT 1");
            $stmt->bind_param("ss", $id, $username);
            $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if($result->num_rows === 0) {
            $stmt->close();
            return 0;
        } else {
            $stmt->close();
            return $user['type'];
        }
    }

    function get_unread_pms($username) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM pms WHERE touser = ? AND readed = 'y'");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }

    function get_user_from_username($name) {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
            $stmt->bind_param("s", $name);
            $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        if($result->num_rows === 0) { $stmt->close(); return('That user does not exist.'); }
        $stmt->close();

        return $user;
    }

    function fetch_user_favorites(string $username) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM favorite_video WHERE sender = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute(); 
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }
    function fetch_group_member_count($id) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM group_members WHERE togroup = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }

    function fetch_group_video_count($id) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM group_videos WHERE toid = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }

    function fetch_group_playlist_count($id) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM group_playlists WHERE toid = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }

    function fetch_group_curator_count($id) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM group_members WHERE togroup = ? AND status = 'a'");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }

    function user_exists($user) {
        $stmt = $this->conn->prepare("SELECT 1 FROM users WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 1) { $stmt->close(); return true; } else { $stmt->close(); return false; }
    }

    function fetch_subs_count($username) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM subscribers WHERE reciever = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }

    function fetch_subscriptions($username) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM subscribers WHERE sender = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }

    function fetch_thread_replies($username) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM forum_replies WHERE toid = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }

    function fetch_user_video_banner($username) {
        $stmt = $this->conn->prepare("SELECT subbutton FROM users WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $subbutton = $row['subbutton'];
        }
        $stmt->close();
        if(empty($subbutton)) {
            return "";
        } else {
            return $subbutton;
        }
    }

    function fetch_user_signature($username) {
        $stmt = $this->conn->prepare("SELECT signature FROM users WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $signature = $row['signature'];
        }
        $stmt->close();
        if(empty($signature)) {
            return "";
        } else {
            return $signature;
        }
    }

    function fetch_user_pfp($username) {
        $stmt = $this->conn->prepare("SELECT pfp FROM users WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $pfp = $row['pfp'];
        }
        $stmt->close();
        //fallback for deleted accs
        if(!isset($pfp)) {
            return "default.png";
        } else {
            return $pfp;
        }
        
    }

    function fetch_category_name(string $rid) {
            $stmt = $this->conn->prepare("SELECT * FROM forum_category WHERE title = ? LIMIT 1");
            $stmt->bind_param("s", $rid);
            $stmt->execute();
        $result = $stmt->get_result();
        $video = $result->fetch_assoc();

        if($result->num_rows === 0) {
            $stmt->close();
            return 0;
        } else {
            $stmt->close();
            return $video;
        }
    }

    function fetch_thread_name(string $rid) {
            $stmt = $this->conn->prepare("SELECT * FROM forum_thread WHERE id = ? LIMIT 1");
            $stmt->bind_param("s", $rid);
            $stmt->execute();
        $result = $stmt->get_result();
        $thread = $result->fetch_assoc();

        if($result->num_rows === 0) {
            $stmt->close();
            return 0;
        } else {
            $stmt->close();
            return $thread;
        }
    }

    function fetch_thread_reply_name(string $rid) {
            $stmt = $this->conn->prepare("SELECT * FROM forum_replies WHERE id = ? LIMIT 1");
            $stmt->bind_param("s", $rid);
            $stmt->execute();
        $result = $stmt->get_result();
        $thread = $result->fetch_assoc();

        if($result->num_rows === 0) {
            $stmt->close();
            return 0;
        } else {
            $stmt->close();
            return $thread;
        }
    }

    function fetch_latest_forum_post(string $rid) {
            $stmt = $this->conn->prepare("SELECT * FROM forum_thread WHERE category = ? ORDER BY sticky DESC, last_post DESC LIMIT 1");
            $stmt->bind_param("s", $rid);
            $stmt->execute();
        $result = $stmt->get_result();
        $thread = $result->fetch_assoc();

        if($result->num_rows === 0) {
            $stmt->close();
            return 0;
        } else {
            $stmt->close();
            return $thread;
        }
    }

    function fetch_latest_forum_post_reply(string $rid) {
            $stmt = $this->conn->prepare("SELECT * FROM forum_replies WHERE toid = ? ORDER BY id DESC LIMIT 1");
            $stmt->bind_param("s", $rid);
            $stmt->execute();
        $result = $stmt->get_result();
        $thread = $result->fetch_assoc();

        if($result->num_rows === 0) {
            $stmt->close();
            return 0;
        } else {
            $stmt->close();
            return $thread;
        }
    }

    function is_admin($username) {
        $stmt = $this->conn->prepare("SELECT 1 FROM users WHERE username = ? AND status = 'admin' LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 1) { $stmt->close(); return true; } else { $stmt->close(); return false; }
    }
    function is_moderator($username) {
        $stmt = $this->conn->prepare("SELECT 1 FROM users WHERE username = ? AND status = 'moderator' LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 1) { $stmt->close(); return true; } else { $stmt->close(); return false; }
    }

}

/**
 * Use this to fetch data for videos.
 *
 * Blah blah blah blah.
 *
 * @copyright  FulpTube
 * @since      Class available since FulpTube backend rewrite 5/9/21
 */ 
class video_fetch_utils {
    public $conn;
    function initialize_db_var($conn) {
        $this->conn = $conn;    
    }

    function initialize_server_vars($server) {
        $this->server = $server;    
    }

    function fetch_history_ammount($username) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM history WHERE author = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }

    function get_video_stars($id) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM stars WHERE reciever = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }    

    function get_video_stars_level($id, $level) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM stars WHERE reciever = ? AND type = ?");
        $stmt->bind_param("si", $id, $level);
        $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }

    function fetch_user_rating($id, $username) {
            $stmt = $this->conn->prepare("SELECT type FROM stars WHERE reciever = ? AND sender = ? LIMIT 1");
            $stmt->bind_param("ss", $id, $username);
            $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if($result->num_rows === 0) {
            $stmt->close();
            return 0;
        } else {
            $stmt->close();
            return $user['type'];
        }
    }


    function get_video_likes($id) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM likes WHERE reciever = ? AND type = 'l'");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }    
    

    function get_video_dislikes($id) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM likes WHERE reciever = ? AND type = 'd'");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }

    function get_category_threads($id) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM forum_thread WHERE category = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }

    function if_upload_cooldown($user) {
        if ($this->is_admin($user) || $this->is_moderator($user)) { return false; } // staff exempt
        $stmt = $this->conn->prepare("SELECT 1 FROM users WHERE username = ? AND upload_cooldown >= NOW() - INTERVAL 1 MINUTE LIMIT 1");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 1) { $stmt->close(); return true; } else { $stmt->close(); return false; }
    }

    function video_responded($reciever, $sending) {
        $stmt = $this->conn->prepare("SELECT 1 FROM video_response WHERE video = ? AND toid = ? LIMIT 1");
        $stmt->bind_param("ss", $sending, $reciever);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 1) { $stmt->close(); return true; } else { $stmt->close(); return false; }
    }

    function if_partner($username) {
        $stmt = $this->conn->prepare("SELECT 1 FROM users WHERE username = ? AND partner = 'y' LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 1) { $stmt->close(); return true; } else { $stmt->close(); return false; }
    }

    function is_admin($username) {
        $stmt = $this->conn->prepare("SELECT 1 FROM users WHERE username = ? AND status = 'admin' LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 1) { $stmt->close(); return true; } else { $stmt->close(); return false; }
    }
    function is_moderator($username) {
        $stmt = $this->conn->prepare("SELECT 1 FROM users WHERE username = ? AND status = 'moderator' LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 1) { $stmt->close(); return true; } else { $stmt->close(); return false; }
    }
    function get_video_responses($id) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM video_response WHERE toid = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }

    function get_video_response(string $rid) {
            $stmt = $this->conn->prepare("SELECT * FROM video_response WHERE id = ? LIMIT 1");
            $stmt->bind_param("s", $rid);
            $stmt->execute();
        $result = $stmt->get_result();
        $video = $result->fetch_assoc();

        if($result->num_rows === 0) {
            $stmt->close();
            return 0;
        } else {
            $stmt->close();
            return $video;
        }
    }

    function fetch_videos_from_user($user) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM videos WHERE author = ? AND visibility = 'n'");
        $stmt->bind_param("s", $user);
        $stmt->execute(); 
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }

    function fetch_all_videos_from_user($user) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM videos WHERE author = ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }

    function get_comments_from_video($id) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM comments WHERE toid = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }

    function fetch_comment_likes($id) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM comment_likes WHERE reciever = ? AND type = 'l'");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }

    function fetch_comment_dislikes($id) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM comment_likes WHERE reciever = ? AND type = 'd'");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }

    function time_elapsed_string($datetime, $full = false) {
        global $cLang;
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        if(!isset($cLang)) {
            $string = array(
                'y' => 'year',
                'm' => 'month',
                'w' => 'week',
                'd' => 'day',
                'h' => 'hour',
                'i' => 'minute',
                's' => 'second',
            );
        } else {
            $string = array(
                'y' => $cLang['year'],
                'm' => $cLang['month'],
                'w' => $cLang['week'],
                'd' => $cLang['day'],
                'h' => $cLang['hour'],
                'i' => $cLang['minute'],
                's' => $cLang['second'],
            );
        }
    
        if(!isset($cLang)) {
            foreach ($string as $k => &$v) {
                if ($diff->$k) {
                    $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                } else {
                    unset($string[$k]);
                }
            }
        } else {
            foreach ($string as $k => &$v) {
                if ($diff->$k) {
                    $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? $cLang['pluralTimeRight'] : '');
                } else {
                    unset($string[$k]);
                }
            }
        }
    
        if(!isset($cLang)) {
            if (!$full) $string = array_slice($string, 0, 1);
            return $string ? implode(', ', $string) . ' ago' : 'just now';
        } else {
            if (!$full) $string = array_slice($string, 0, 1);
            return $string ? implode($cLang['agoLeft'], $string) . " " . " " . $cLang['agoRight'] : $cLang['justNow'];
        }
    }

    function fetch_video_rid(string $rid) {
            $stmt = $this->conn->prepare("SELECT * FROM videos WHERE rid = ? LIMIT 1");
            $stmt->bind_param("s", $rid);
            $stmt->execute();
        $result = $stmt->get_result();
        $video = $result->fetch_assoc();

        if($result->num_rows === 0) {
            $stmt->close();
            return 0;
        } else {
            $stmt->close();
            return $video;
        }
    }

    function get_quicklist_video(string $rid) {
            $stmt = $this->conn->prepare("SELECT * FROM quicklist_videos WHERE id = ? LIMIT 1");
            $stmt->bind_param("s", $rid);
            $stmt->execute();
        $result = $stmt->get_result();
        $video = $result->fetch_assoc();

        if($result->num_rows === 0) {
            $stmt->close();
            return 0;
        } else {
            $stmt->close();
            return $video;
        }
    }

    function get_history_video(string $rid) {
            $stmt = $this->conn->prepare("SELECT * FROM history WHERE id = ? LIMIT 1");
            $stmt->bind_param("s", $rid);
            $stmt->execute();
        $result = $stmt->get_result();
        $video = $result->fetch_assoc();

        if($result->num_rows === 0) {
            $stmt->close();
            return 0;
        } else {
            $stmt->close();
            return $video;
        }
    }


    function get_video_views(string $rid) {
            $stmt = $this->conn->prepare("SELECT count(*) FROM views WHERE videoid = ?");
            $stmt->bind_param("s", $rid);
            $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }

    function fetch_less_video_rid(string $rid) {
            $stmt = $this->conn->prepare("SELECT rid, title, thumbnail, duration, title, author FROM videos WHERE rid = ? LIMIT 1");
            $stmt->bind_param("s", $rid);
            $stmt->execute();
        $result = $stmt->get_result();
        $video = $result->fetch_assoc();

        if($result->num_rows === 0) {
            $stmt->close();
            return 0;
        } else {
            $stmt->close();
            return $video;
        }
    }

    function group_exists($id) {
        $stmt = $this->conn->prepare("SELECT 1 FROM user_groups WHERE id = ? LIMIT 1");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 1) { $stmt->close(); return true; } else { $stmt->close(); return false; }
    }

    function fetch_video_views(string $vidid) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM views WHERE videoid = ?");
        $stmt->bind_param("s", $vidid);
        $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }

    function fetch_latest_video(string $author) {
            $stmt = $this->conn->prepare("SELECT * FROM videos WHERE author = ? AND visibility = 'n' ORDER BY id DESC LIMIT 1");
            $stmt->bind_param("s", $author);
            $stmt->execute();
        $result = $stmt->get_result();
        $video = $result->fetch_assoc();

        if($result->num_rows === 0) {
            $stmt->close();
            return 0;
        } else {
            $stmt->close();
            return $video;
        }
    }
    function fetch_all_latest_video(string $author) {
            $stmt = $this->conn->prepare("SELECT * FROM videos WHERE author = ? ORDER BY id DESC LIMIT 1");
            $stmt->bind_param("s", $author);
            $stmt->execute();
        $result = $stmt->get_result();
        $video = $result->fetch_assoc();

        if($result->num_rows === 0) {
            $stmt->close();
            return 0;
        } else {
            $stmt->close();
            return $video;
        }
    }
    function fetch_rand_featured_vid() {
            $stmt = $this->conn->prepare("SELECT * FROM videos WHERE featured = 'v' AND visibility = 'n' ORDER BY rand() LIMIT 1");
            $stmt->execute();
        $result = $stmt->get_result();
        $video = $result->fetch_assoc();

        if($result->num_rows === 0) {
            $stmt->close();
            return 0;
        } else {
            $stmt->close();
            return $video;
        }
    }
    function fetch_playlist_rid(string $rid) {
            $stmt = $this->conn->prepare("SELECT * FROM playlists WHERE rid = ? LIMIT 1");
            $stmt->bind_param("s", $rid);
            $stmt->execute();
        $result = $stmt->get_result();
        $playlist = $result->fetch_assoc();

        if($result->num_rows === 0) {
            $stmt->close();
            return 0;
        } else {
            $stmt->close();
            return $playlist;
        }
    }

    function fetch_group_id(string $id) {
            $stmt = $this->conn->prepare("SELECT * FROM user_groups WHERE id = ? LIMIT 1");
            $stmt->bind_param("s", $id);
            $stmt->execute();
        $result = $stmt->get_result();
        $group = $result->fetch_assoc();

        if($result->num_rows === 0) {
            $stmt->close();
            return 0;
        } else {
            $stmt->close();
            return $group;
        }
    }

    function fetch_group_membership_id(string $id) {
            $stmt = $this->conn->prepare("SELECT * FROM group_members WHERE id = ? LIMIT 1");
            $stmt->bind_param("s", $id);
            $stmt->execute();
        $result = $stmt->get_result();
        $group = $result->fetch_assoc();

        if($result->num_rows === 0) {
            $stmt->close();
            return 0;
        } else {
            $stmt->close();
            return $group;
        }
    }

    function video_exists($user) {
        $stmt = $this->conn->prepare("SELECT 1 FROM videos WHERE rid = ? LIMIT 1");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows === 1) { $stmt->close(); return true; } else { $stmt->close(); return false; }
    }

    function fetch_views_from_user($user) {
        $stmt = $this->conn->prepare("SELECT `rid` FROM videos WHERE author = ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();
        $views = 0;
        while($row = $result->fetch_assoc()) {
            $views = $views + $this->fetch_video_views($row['rid']);
        }
        $stmt->close();
        return $views;
    }

    function fetch_user_videos(string $id) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM videos WHERE author = ? AND visibility = 'n'");
        $stmt->bind_param("s", $id);
        $stmt->execute(); 
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }
    function fetch_all_user_videos(string $id) {
        $stmt = $this->conn->prepare("SELECT count(*) FROM videos WHERE author = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($rowCount);
        $stmt->fetch();

        $stmt->close();

        return $rowCount;
    }
    function fetch_user_video_banner($username) {
        $stmt = $this->conn->prepare("SELECT subbutton FROM users WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $subbutton = $row['subbutton'];
        }
        $stmt->close();
        if(empty($subbutton)) {
            return "";
        } else {
            return $subbutton;
        }
    }

    function timestamp(int $seconds) {
        if ($seconds > 60*60*24) {
            // over a day
            return sprintf("%d:%s:%s:%s",
                floor($seconds/60/60/24),                                 // Days
                str_pad( floor($seconds/60/60%24), 2, "0", STR_PAD_LEFT), // Hours
                str_pad( floor($seconds/60%60),    2, "0", STR_PAD_LEFT), // Minutes
                str_pad(       $seconds%60,        2, "0", STR_PAD_LEFT)  // Seconds
            );
        } else if ($seconds > 60*60) {
            // over an hour
            return sprintf("%d:%s:%s",
                        floor($seconds/60/60),                        // Hours
                str_pad(floor($seconds/60%60), 2, "0", STR_PAD_LEFT), // Minutes
                str_pad(      $seconds%60,     2, "0", STR_PAD_LEFT)  // Seconds
            );
        } else {
            // less than an hour
            return sprintf("%d:%s",
                        floor($seconds/60),                       // Minutes
                str_pad(      $seconds%60,  2, "0", STR_PAD_LEFT) // Seconds
            );
        }
    }

    function parse_title($text) {
        $text = trim($text);
        if(strlen($text) >= 25) {
            $text = substr($text, 0, 25) . "...";
        } 
        $text = htmlspecialchars($text, ENT_SUBSTITUTE);
        return $text;
    }   

    function parseTitle($text) {
        $text = trim($text);
        if(strlen($text) >= 25) {
            $text = substr($text, 0, 25) . "...";
        }
        $text = htmlspecialchars($text, ENT_SUBSTITUTE);
        return $text;
    }


    function parseTextNoLink($text) {
        $text = trim($text);
        if(strlen($text) >= 90) {
            $text = substr($text, 0, 100) . "...";
        } 
        $text = htmlspecialchars($text, ENT_SUBSTITUTE);
        $text = str_replace(PHP_EOL, "<br>", $text);
        return $text;
    }    

    function parseTextNoLinkForBBCode($text) {
        $text = trim($text);
        if(strlen($text) >= 90) {
            $text = substr($text, 0, 100) . "...";
        }
        return $text;
    }

    function parseTextDescription($text) {
        $text = trim($text);
        $text = htmlspecialchars($text);
        $formatting_find = [
            //smileys
            "/(?<![\/\w])\:mona2\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:nida\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:af2\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:nagato\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:iyahoo\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:purin\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:araebi\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:mona3\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:saitama\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:unko\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:ranta\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:mosa\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:shii\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:syobo\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:iyou\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:1san\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:zuri\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:13uo\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:monatya\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:pata\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:kasari\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:snowman\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:depression\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:monapc\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:ppa\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:rocket\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:saitama2\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:eiki\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:banana\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:sip\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:meow\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:gobo\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:waffle\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:semicolon\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:taco\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:eggplant\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:sushi\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:apple\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:broccoli\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:pizza\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:candycorn\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:10mil\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:map\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:camera\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:suitcase\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:compass\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:binoculars\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:ksllxmfcai\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:cupcake\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:cat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:awwcat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:coolcat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:tongueoutcat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:winkcat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:lolcat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:upsidedowncat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:huhcat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:loveitcat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:favitcat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:rainbowcat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:pizzacat\:(?![^<>]*\>)/",
            "/(?<![\/\w])(&gt;\:\(|&gt;\:\-\(|&gt;\=\(|&gt;\=\-\(|D\:|D\-\:|D\=|D\-\=)(?![^<>]*\>)/",
            "/(?<![\/\w])\^_\^(?![^<>]*\>)/",
            "/(?<![\/\w])(8\)|8\-\))(?![^<>]*\>)/",
            "/(?<![\/\w])(&gt;\:\)|&gt;\:\-\)|&gt;\=\)|&gt;\=\-\)|&gt;\:D|&gt;\:\-D|&gt;\=D|&gt;\=\-D)(?![^<>]*\>)/",
            "/(?<![\/\w])(\:D|\:\-D|\=D|\=\-D)(?![^<>]*\>)/",
            "/(?<![\/\w])(&gt;;\)|&gt;;\-\)|&gt;;D|&gt;;\-D)(?![^<>]*\>)/",
            "/(?<![\/\w])(;D|;\-D)(?![^<>]*\>)/",
            "/(?<![\/\w])\:blue\:(?![^<>]*\>)/",
            "/(?<![\/\w])(o\.O|O\.o)(?![^<>]*\>)/",
            "/(?<![\/\w])(\:\?|\:\-\?|\=\?|\=\-\?)(?![^<>]*\>)/",
            "/(?<![\/\w])(B\)|B\-\))(?![^<>]*\>)/",
            "/(?<![\/\w])(\:\(|\:\-\(|\=\(|\=\-\()(?![^<>]*\>)/",
            "/(?<![\/\w])&lt;3(?![^<>]*\>)/",
            "/(?<![\/\w])(\:\/|\:\-\/|\=\/|\=\-\/|\:\\\\|\:\-\\\\|\=\\\\|\=\-\\\\)(?![^<>]*\>)/",
            "/(?<![\/\w])(XD|X\-D)(?![^<>]*\>)/",
            "/(?<![\/\w])(&lt;_&lt;|&lt;\.&lt;)(?![^<>]*\>)/",
            "/(?<![\/\w])(&gt;_&gt;|&gt;\.&gt;)(?![^<>]*\>)/",
            "/(?<![\/\w])(\:\||\:\-\||\=\||\=\-\||\:I|\\:\-\I|\=I|\=\-I)(?![^<>]*\>)/",
            "/(?<![\/\w])(O\:\)|O\:\-\)|O\=\)|O\=\-\))(?![^<>]*\>)/",
            "/(?<![\/\w])\:zzz\:(?![^<>]*\>)/",
            "/(?<![\/\w])(\:\)|\:\-\)|\=\)|\=\-\))(?![^<>]*\>)/",
            "/(?<![\/\w])(\:3|\:\-3|\=3|\=\-3)(?![^<>]*\>)/",
            "/(?<![\/\w])\:star\:(?![^<>]*\>)/",
            "/(?<![\/\w])(\:O|\:\-O|\=O|\=\-O)(?![^<>]*\>)/",
            "/(?<![\/\w])\^\^;(?![^<>]*\>)/",
            "/(?<![\/\w])(&lt;g&gt;|&lt;G&gt;)(?![^<>]*\>)/",
            "/(?<![\/\w])(\:P|\:\-P|\=P|\=\-P|X\-P)(?![^<>]*\>)/",
            "/(?<![\/\w])(;\)|;\-\))(?![^<>]*\>)/",
            "/(?<![\/\w])(;3|;\-3)(?![^<>]*\>)/",
            "/(?<![\/\w])(\:s |\:\-S |\=s|\=\-S)(?![^<>]*\>)/",
            //markdown
            '@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-~]*(\?\S+)?)?)?)@', //urls
            "/(?<=\s|^)@([a-zA-Z0-9-]+|\\+\\])/", //user profile ats
            "/(?<=\s|^)#([a-zA-Z0-9-]+|\\+\\])/", //hashtags
            "/^&gt;(.*)$/m", //greentext
            "/^&lt;(.*)$/m", //orange text
            "/^\^(.*)$/m", //light blue text
            "/==(.+?)==/s", //red text
            "/--(.+?)--/s", //blue text
            "/-=(.+?)-=/s", //purple text
            "/'''(.+?)'''/s", //bold
            "/''(.+?)''/s", //italic
            "/~~(.+?)~~/s", //strikethrough
            "/\*\*(.+?)\*\*/s", //spoiler
            "/__(.+?)__/s", //underline
            "/```(.+?)```/s", //code text
            "/\+=(.+?)=\+/s", //big text
            "/_=(.+?)=_/s", //tiny text
            "/@\\$(.+?)@\\$/s", //shift jis text
            "/%%(.+?)%%/s", //glow text
            "/\:\:(.+?)\:\:/s", //sneed text
            "/\!\!(.+?)\!\!/s", //red glow
            "/;;(.+?);;/s", //blue glow
            "/~\-~(.+?)~\-~/s", //rainbow text
            "/\-~\-(.+?)\-~\-/s" //pisces text
        ];
        $formatting_replace = [
            //smileys
            '<img src="/static/smileys/mona2.gif" alt=":mona2:" title=":mona2:" class="bbcode_smiley">',
            '<img src="/static/smileys/nida.gif" alt=":nida:" title=":nida:" class="bbcode_smiley">',
            '<img src="/static/smileys/af2.gif" alt=":af2:" title=":af2:" class="bbcode_smiley">',
            '<img src="/static/smileys/nagato.gif" alt=":nagato:" title=":nagato:" class="bbcode_smiley">',
            '<img src="/static/smileys/iyahoo.gif" alt=":iyahoo:" title=":iyahoo:" class="bbcode_smiley">',
            '<img src="/static/smileys/purin.gif" alt=":purin:" title=":purin:" class="bbcode_smiley">',
            '<img src="/static/smileys/araebi.gif" alt=":araebi:" title=":araebi:" class="bbcode_smiley">',
            '<img src="/static/smileys/2mona2.gif" alt=":mona3:" title=":mona3:" class="bbcode_smiley">',
            '<img src="/static/smileys/anime_saitama05.gif" alt=":saitama:" title=":saitama:" class="bbcode_smiley">',
            '<img src="/static/smileys/u_unko.gif" alt=":unko:" title=":unko:" class="bbcode_smiley">',
            '<img src="/static/smileys/anime_imanouchi04.gif" alt=":ranta:" title=":ranta:" class="bbcode_smiley">',
            '<img src="/static/smileys/u_mosa.gif" alt=":mosa:" title=":mosa:" class="bbcode_smiley">',
            '<img src="/static/smileys/anime_shii01.gif" alt=":shii:" title=":shii:" class="bbcode_smiley">',
            '<img src="/static/smileys/syobo2.gif" alt=":syobo:" title=":syobo:" class="bbcode_smiley">',
            '<img src="/static/smileys/2iyou_2.gif" alt=":iyou:" title=":iyou:" class="bbcode_smiley">',
            '<img src="/static/smileys/1san32.gif" alt=":1san:" title=":1san:" class="bbcode_smiley">',
            '<img src="/static/smileys/zuri.gif" alt=":zuri:" title=":zuri:" class="bbcode_smiley">',
            '<img src="/static/smileys/13uo.gif" alt=":13uo:" title=":13uo:" class="bbcode_smiley">',
            '<img src="/static/smileys/monatya.gif" alt=":monatya:" title=":monatya:" class="bbcode_smiley">',
            '<img src="/static/smileys/u_pata.gif" alt=":pata:" title=":pata:" class="bbcode_smiley">',
            '<img src="/static/smileys/kasa-ri.gif" alt=":kasari:" title=":kasari:" class="bbcode_smiley">',
            '<img src="/static/smileys/showman.gif" alt=":snowman:" title=":snowman:" class="bbcode_smiley">',
            '<img src="/static/smileys/u_sasu.gif" alt=":depression:" title=":depression:" class="bbcode_smiley">',
            '<img src="/static/smileys/anime_miruna_pc.gif" alt=":monapc:" title=":monapc:" class="bbcode_smiley">',
            '<img src="/static/smileys/ppa.gif" alt=":ppa:" title=":ppa:" class="bbcode_smiley">',
            '<img src="/static/smileys/10ite.gif" alt=":rocket:" title=":rocket:" class="bbcode_smiley">',
            '<img src="/static/smileys/anime_saitama06.gif" alt=":saitama2:" title=":saitama2:" class="bbcode_smiley">',
            '<img src="/static/smileys/eiki.gif" alt=":eiki:" title=":eiki:" class="bbcode_smiley">',
            '<img src="/static/smileys/banana.gif" alt=":banana:" title=":banana:" class="bbcode_smiley">',
            '<img src="/static/smileys/sip.gif" alt=":sip:" title=":sip:" class="bbcode_smiley">',
            '<img src="/static/smileys/Meow.png" alt=":meow:" title=":meow:" class="bbcode_smiley">',
            '<img src="/static/smileys/Gobo_emoji.png" alt=":gobo:" title=":gobo:" class="bbcode_smiley">',
            '<img src="/static/smileys/Waffle_Emoji.png" alt=":waffle:" title=":waffle:" class="bbcode_smiley">',
            '<img src="/static/smileys/Semicolon_Emoticon.png" alt=":semicolon:" title=":semicolon:" class="bbcode_smiley">',
            '<img src="/static/smileys/Taco_emoji.png" alt=":taco:" title=":taco:" class="bbcode_smiley">',
            '<img src="/static/smileys/Eggplant_emoji.png" alt=":eggplant:" title=":eggplant:" class="bbcode_smiley">',
            '<img src="/static/smileys/Sushi_emoji.png" alt=":sushi:" title=":sushi:" class="bbcode_smiley">',
            '<img src="/static/smileys/Apple_emoji.png" alt=":apple:" title=":apple:" class="bbcode_smiley">',
            '<img src="/static/smileys/Broccoli_emoji.png" alt=":broccoli:" title=":broccoli:" class="bbcode_smiley">',
            '<img src="/static/smileys/Pizza_emoji.png" alt=":pizza:" title=":pizza:" class="bbcode_smiley">',
            '<img src="/static/smileys/Candycorn.png" alt=":candycorn:" title=":candycorn:" class="bbcode_smiley">',
            '<img src="/static/smileys/10milemoji.png" alt=":10mil:" title=":10mil:" class="bbcode_smiley">',
            '<img src="/static/smileys/Map_emoji.png" alt=":map:" title=":map:" class="bbcode_smiley">',
            '<img src="/static/smileys/Camera_emoji.png" alt=":camera:" title=":camera:" class="bbcode_smiley">',
            '<img src="/static/smileys/Suitcase_emoji.png" alt=":suitcase:" title=":suitcase:" class="bbcode_smiley">',
            '<img src="/static/smileys/Compass.png" alt=":compass:" title=":compass:" class="bbcode_smiley">',
            '<img src="/static/smileys/Binoculars.png" alt=":binoculars:" title=":binoculars:" class="bbcode_smiley">',
            '<img src="/static/smileys/Ksllxmfcai-emoji.png" alt=":ksllxmfcai:" title=":ksllxmfcai:" class="bbcode_smiley">',
            '<img src="/static/smileys/Cupcake.png" alt=":cupcake:" title=":cupcake:" class="bbcode_smiley">',
            '<img src="/static/smileys/Cat-emoji.png" alt=":cat:" title=":cat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Aww-cat-emoji.png" alt=":awwcat:" title=":awwcat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Cool-cat-emoji.png" alt=":coolcat:" title=":coolcat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Tongue-out-cat-emoji.png" alt=":tongueoutcat:" title=":tongueoutcat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Wink-cat-emoji.png" alt=":winkcat:" title=":winkcat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Lol-cat-emoji.png" alt=":lolcat:" title=":lolcat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Upside-down-cat-emoji.png" alt=":upsidedowncat:" title=":upsidedowncat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Huh-cat-emoji.png" alt=":huhcat:" title=":huhcat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Love-it-cat-emoji.png" alt=":loveitcat:" title=":loveitcat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Fav-it-cat-emoji.png" alt=":favitcat:" title=":favitcat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Rainbow-cat-emoji.png" alt=":rainbowcat:" title=":rainbowcat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Pizza-cat-emoji.png" alt=":pizzacat:" title=":pizzacat:" class="bbcode_smiley">',
            '<img src="/static/smileys/angry.gif" alt="&gt;:(" title="&gt;:(" class="bbcode_smiley">',
            '<img src="/static/smileys/anime.gif" alt="^_^" title="^_^" class="bbcode_smiley">',
            '<img src="/static/smileys/bigeyes.gif" alt="8)" title="8)" class="bbcode_smiley">',
            '<img src="/static/smileys/evil.gif" alt="&gt;:)" title="&gt;:)" class="bbcode_smiley">',
            '<img src="/static/smileys/bigsmile.gif" alt=":D" title=":D" class="bbcode_smiley">',
            '<img src="/static/smileys/sneaky.gif" alt="&gt;;)" title="&gt;;)" class="bbcode_smiley">',
            '<img src="/static/smileys/bigwink.gif" alt=";D" title=";D" class="bbcode_smiley">',
            '<img src="/static/smileys/blue.gif" alt=":blue:" title=":blue:" class="bbcode_smiley">',
            '<img src="/static/smileys/boggle.gif" alt="o.O" title="o.O" class="bbcode_smiley">',
            '<img src="/static/smileys/confuse.gif" alt=":?" title=":?" class="bbcode_smiley">',
            '<img src="/static/smileys/cool.gif" alt="B)" title="B)" class="bbcode_smiley">',
            '<img src="/static/smileys/frown.gif" alt=":(" title=":(" class="bbcode_smiley">',
            '<img src="/static/smileys/heart.gif" alt="&lt;3" title="&lt;3" class="bbcode_smiley">',
            '<img src="/static/smileys/irritated.gif" alt=":/" title=":/" class="bbcode_smiley">',
            '<img src="/static/smileys/laugh.gif" alt="XD" title="XD" class="bbcode_smiley">',
            '<img src="/static/smileys/lookleft.gif" alt="&lt_&lt;" title="&lt;_&lt;" class="bbcode_smiley">',
            '<img src="/static/smileys/lookright.gif" alt="&gt_&gt;" title="&gt;_&gt;" class="bbcode_smiley">',
            '<img src="/static/smileys/neutral.gif" alt=":|" title=":|" class="bbcode_smiley">',
            '<img src="/static/smileys/saint.gif" alt="O:)" title="O:)" class="bbcode_smiley">',
            '<img src="/static/smileys/sleepy.gif" alt=":zzz:" title=":zzz:" class="bbcode_smiley">',
            '<img src="/static/smileys/smile.gif" alt=":)" title=":)" class="bbcode_smiley">',
            '<img src="/static/smileys/smile3.gif" alt=":3" title=":3" class="bbcode_smiley">',
            '<img src="/static/smileys/star.gif" alt=":star:" title=":star:" class="bbcode_smiley">',
            '<img src="/static/smileys/surprise.gif" alt=":O" title=":O" class="bbcode_smiley">',
            '<img src="/static/smileys/sweatdrop.gif" alt="^^;" title="^^;" class="bbcode_smiley">',
            '<img src="/static/smileys/teeth.gif" alt="&lt;g&gt;" title="&lt;g&gt;" class="bbcode_smiley">',
            '<img src="/static/smileys/tongue.gif" alt=":P" title=":P" class="bbcode_smiley">',
            '<img src="/static/smileys/wink.gif" alt=";)" title=";)" class="bbcode_smiley">',
            '<img src="/static/smileys/wink3.gif" alt=";3" title=";3" class="bbcode_smiley">',
            '<img src="/static/smileys/worry.gif" alt=":s" title=":s" class="bbcode_smiley">',
            //markdown
            '<a href="$1" rel="noopener noreferrer nofollow ugc" target="_blank">$1</a>', //urls
            "<a href='/user/$1'>@$1</a>", //user profile ats
            "<a href='/search_query?q=%23$1'>#$1</a>", //hashtags
            "<span style='color:#789922;'>&gt;$1</span>", //greentext
            "<span style='color:#f6750b;'>&lt;$1</span>", //orange text
            "<span style='color:#6577E6;'>^$1</span>", //light blue text
            "<b style='color:#af0a0f;'>$1</b>", //red text
            "<b style='color:#2424ad;'>$1</b>", //blue text
            "<b style='color:#720b98;'>$1</b>", //purple text
            "<b>$1</b>", //bold
            "<i>$1</i>", //italic
            "<s>$1</s>", //strikethrough
            "<span class='bbcode_spoiler'>$1</span>", //spoiler
            "<u>$1</u>", //underline
            "<code>$1</code>", //code text
            "<span style='font-size:x-large'>$1</span>", //big text
            "<span style='font-size:x-small'>$1</span>", //tiny text
            "<span class='aagiko'>$1</span>", //shift jis text
            "<span style='text-shadow:0px 0px 40px #00fe20, 0px 0px 2px #00fe20'>$1</span>", //glow text
            "<span style='text-shadow:0px 0px 40px #fffb00, 0px 0px 2px #fffb00'>$1</span>", //sneed text
            "<span style='text-shadow:0px 0px 40px #bd0606, 0px 0px 2px #bd0606'>$1</span>", //red glow
            "<span style='text-shadow:0px 0px 40px #36d7f7, 0px 0px 2px #36d7f7'>$1</span>", //blue glow
            "<span style='background: linear-gradient(to left, red, orange, yellow, green, cyan, blue, violet);-webkit-background-clip: text;-webkit-text-fill-color: transparent;'>$1</span>", //rainbow text
            "<span style='color:#FD3D98; font-weight:bold;'><b>$1</b></span>" //pisces text
        ];
        $text = preg_replace($formatting_find, $formatting_replace, $text);
        $text = preg_replace_callback("/((\d{1,2}:)+\d{2})/", function($matches){ return "<a onclick=\"yt.www.watch.player.seekTo(".$this->timestamp($matches[0]).", false)\">".$matches[0]."</a>"; }, $text); //seek to
        $text = str_replace(PHP_EOL, "<br>", $text);
        return $text;
    }

    function parseDescriptionVideoManager($text) {
        $text = trim($text);
        if(strlen($text) >= 30) {
            $text = substr($text, 0, 30) . "...";
        } 
        $text = htmlspecialchars($text, ENT_SUBSTITUTE);
        return $text;
    }    

    function parseTextComment($text) {
        $text = trim($text);
        $text = htmlspecialchars($text);
        $formatting_find = [
            //smileys
            "/(?<![\/\w])\:mona2\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:nida\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:af2\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:nagato\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:iyahoo\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:purin\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:araebi\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:mona3\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:saitama\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:unko\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:ranta\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:mosa\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:shii\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:syobo\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:iyou\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:1san\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:zuri\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:13uo\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:monatya\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:pata\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:kasari\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:snowman\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:depression\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:monapc\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:ppa\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:rocket\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:saitama2\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:eiki\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:banana\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:sip\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:meow\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:gobo\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:waffle\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:semicolon\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:taco\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:eggplant\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:sushi\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:apple\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:broccoli\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:pizza\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:candycorn\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:10mil\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:map\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:camera\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:suitcase\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:compass\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:binoculars\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:ksllxmfcai\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:cupcake\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:cat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:awwcat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:coolcat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:tongueoutcat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:winkcat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:lolcat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:upsidedowncat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:huhcat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:loveitcat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:favitcat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:rainbowcat\:(?![^<>]*\>)/",
            "/(?<![\/\w])\:pizzacat\:(?![^<>]*\>)/",
            "/(?<![\/\w])(&gt;\:\(|&gt;\:\-\(|&gt;\=\(|&gt;\=\-\(|D\:|D\-\:|D\=|D\-\=)(?![^<>]*\>)/",
            "/(?<![\/\w])\^_\^(?![^<>]*\>)/",
            "/(?<![\/\w])(8\)|8\-\))(?![^<>]*\>)/",
            "/(?<![\/\w])(&gt;\:\)|&gt;\:\-\)|&gt;\=\)|&gt;\=\-\)|&gt;\:D|&gt;\:\-D|&gt;\=D|&gt;\=\-D)(?![^<>]*\>)/",
            "/(?<![\/\w])(\:D|\:\-D|\=D|\=\-D)(?![^<>]*\>)/",
            "/(?<![\/\w])(&gt;;\)|&gt;;\-\)|&gt;;D|&gt;;\-D)(?![^<>]*\>)/",
            "/(?<![\/\w])(;D|;\-D)(?![^<>]*\>)/",
            "/(?<![\/\w])\:blue\:(?![^<>]*\>)/",
            "/(?<![\/\w])(o\.O|O\.o)(?![^<>]*\>)/",
            "/(?<![\/\w])(\:\?|\:\-\?|\=\?|\=\-\?)(?![^<>]*\>)/",
            "/(?<![\/\w])(B\)|B\-\))(?![^<>]*\>)/",
            "/(?<![\/\w])(\:\(|\:\-\(|\=\(|\=\-\()(?![^<>]*\>)/",
            "/(?<![\/\w])&lt;3(?![^<>]*\>)/",
            "/(?<![\/\w])(\:\/|\:\-\/|\=\/|\=\-\/|\:\\\\|\:\-\\\\|\=\\\\|\=\-\\\\)(?![^<>]*\>)/",
            "/(?<![\/\w])(XD|X\-D)(?![^<>]*\>)/",
            "/(?<![\/\w])(&lt;_&lt;|&lt;\.&lt;)(?![^<>]*\>)/",
            "/(?<![\/\w])(&gt;_&gt;|&gt;\.&gt;)(?![^<>]*\>)/",
            "/(?<![\/\w])(\:\||\:\-\||\=\||\=\-\||\:I|\\:\-\I|\=I|\=\-I)(?![^<>]*\>)/",
            "/(?<![\/\w])(O\:\)|O\:\-\)|O\=\)|O\=\-\))(?![^<>]*\>)/",
            "/(?<![\/\w])\:zzz\:(?![^<>]*\>)/",
            "/(?<![\/\w])(\:\)|\:\-\)|\=\)|\=\-\))(?![^<>]*\>)/",
            "/(?<![\/\w])(\:3|\:\-3|\=3|\=\-3)(?![^<>]*\>)/",
            "/(?<![\/\w])\:star\:(?![^<>]*\>)/",
            "/(?<![\/\w])(\:O|\:\-O|\=O|\=\-O)(?![^<>]*\>)/",
            "/(?<![\/\w])\^\^;(?![^<>]*\>)/",
            "/(?<![\/\w])(&lt;g&gt;|&lt;G&gt;)(?![^<>]*\>)/",
            "/(?<![\/\w])(\:P|\:\-P|\=P|\=\-P|X\-P)(?![^<>]*\>)/",
            "/(?<![\/\w])(;\)|;\-\))(?![^<>]*\>)/",
            "/(?<![\/\w])(;3|;\-3)(?![^<>]*\>)/",
            "/(?<![\/\w])(\:s |\:\-S |\=s|\=\-S)(?![^<>]*\>)/",
            //markdown
            '@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-~]*(\?\S+)?)?)?)@', //urls
            "/(?<=\s|^)@([a-zA-Z0-9-]+|\\+\\])/", //user profile ats
            "/(?<=\s|^)#([a-zA-Z0-9-]+|\\+\\])/", //hashtags
            "/^&gt;(.*)$/m", //greentext
            "/^&lt;(.*)$/m", //orange text
            "/^\^(.*)$/m", //light blue text
            "/==(.+?)==/s", //red text
            "/--(.+?)--/s", //blue text
            "/-=(.+?)-=/s", //purple text
            "/'''(.+?)'''/s", //bold
            "/''(.+?)''/s", //italic
            "/~~(.+?)~~/s", //strikethrough
            "/\*\*(.+?)\*\*/s", //spoiler
            "/__(.+?)__/s", //underline
            "/```(.+?)```/s", //code text
            "/\+=(.+?)=\+/s", //big text
            "/_=(.+?)=_/s", //tiny text
            "/@\\$(.+?)@\\$/s", //shift jis text
            "/%%(.+?)%%/s", //glow text
            "/\:\:(.+?)\:\:/s", //sneed text
            "/\!\!(.+?)\!\!/s", //red glow
            "/;;(.+?);;/s", //blue glow
            "/~\-~(.+?)~\-~/s", //rainbow text
            "/\-~\-(.+?)\-~\-/s" //pisces text
        ];
        $formatting_replace = [
            //smileys
            '<img src="/static/smileys/mona2.gif" alt=":mona2:" title=":mona2:" class="bbcode_smiley">',
            '<img src="/static/smileys/nida.gif" alt=":nida:" title=":nida:" class="bbcode_smiley">',
            '<img src="/static/smileys/af2.gif" alt=":af2:" title=":af2:" class="bbcode_smiley">',
            '<img src="/static/smileys/nagato.gif" alt=":nagato:" title=":nagato:" class="bbcode_smiley">',
            '<img src="/static/smileys/iyahoo.gif" alt=":iyahoo:" title=":iyahoo:" class="bbcode_smiley">',
            '<img src="/static/smileys/purin.gif" alt=":purin:" title=":purin:" class="bbcode_smiley">',
            '<img src="/static/smileys/araebi.gif" alt=":araebi:" title=":araebi:" class="bbcode_smiley">',
            '<img src="/static/smileys/2mona2.gif" alt=":mona3:" title=":mona3:" class="bbcode_smiley">',
            '<img src="/static/smileys/anime_saitama05.gif" alt=":saitama:" title=":saitama:" class="bbcode_smiley">',
            '<img src="/static/smileys/u_unko.gif" alt=":unko:" title=":unko:" class="bbcode_smiley">',
            '<img src="/static/smileys/anime_imanouchi04.gif" alt=":ranta:" title=":ranta:" class="bbcode_smiley">',
            '<img src="/static/smileys/u_mosa.gif" alt=":mosa:" title=":mosa:" class="bbcode_smiley">',
            '<img src="/static/smileys/anime_shii01.gif" alt=":shii:" title=":shii:" class="bbcode_smiley">',
            '<img src="/static/smileys/syobo2.gif" alt=":syobo:" title=":syobo:" class="bbcode_smiley">',
            '<img src="/static/smileys/2iyou_2.gif" alt=":iyou:" title=":iyou:" class="bbcode_smiley">',
            '<img src="/static/smileys/1san32.gif" alt=":1san:" title=":1san:" class="bbcode_smiley">',
            '<img src="/static/smileys/zuri.gif" alt=":zuri:" title=":zuri:" class="bbcode_smiley">',
            '<img src="/static/smileys/13uo.gif" alt=":13uo:" title=":13uo:" class="bbcode_smiley">',
            '<img src="/static/smileys/monatya.gif" alt=":monatya:" title=":monatya:" class="bbcode_smiley">',
            '<img src="/static/smileys/u_pata.gif" alt=":pata:" title=":pata:" class="bbcode_smiley">',
            '<img src="/static/smileys/kasa-ri.gif" alt=":kasari:" title=":kasari:" class="bbcode_smiley">',
            '<img src="/static/smileys/showman.gif" alt=":snowman:" title=":snowman:" class="bbcode_smiley">',
            '<img src="/static/smileys/u_sasu.gif" alt=":depression:" title=":depression:" class="bbcode_smiley">',
            '<img src="/static/smileys/anime_miruna_pc.gif" alt=":monapc:" title=":monapc:" class="bbcode_smiley">',
            '<img src="/static/smileys/ppa.gif" alt=":ppa:" title=":ppa:" class="bbcode_smiley">',
            '<img src="/static/smileys/10ite.gif" alt=":rocket:" title=":rocket:" class="bbcode_smiley">',
            '<img src="/static/smileys/anime_saitama06.gif" alt=":saitama2:" title=":saitama2:" class="bbcode_smiley">',
            '<img src="/static/smileys/eiki.gif" alt=":eiki:" title=":eiki:" class="bbcode_smiley">',
            '<img src="/static/smileys/banana.gif" alt=":banana:" title=":banana:" class="bbcode_smiley">',
            '<img src="/static/smileys/sip.gif" alt=":sip:" title=":sip:" class="bbcode_smiley">',
            '<img src="/static/smileys/Meow.png" alt=":meow:" title=":meow:" class="bbcode_smiley">',
            '<img src="/static/smileys/Gobo_emoji.png" alt=":gobo:" title=":gobo:" class="bbcode_smiley">',
            '<img src="/static/smileys/Waffle_Emoji.png" alt=":waffle:" title=":waffle:" class="bbcode_smiley">',
            '<img src="/static/smileys/Semicolon_Emoticon.png" alt=":semicolon:" title=":semicolon:" class="bbcode_smiley">',
            '<img src="/static/smileys/Taco_emoji.png" alt=":taco:" title=":taco:" class="bbcode_smiley">',
            '<img src="/static/smileys/Eggplant_emoji.png" alt=":eggplant:" title=":eggplant:" class="bbcode_smiley">',
            '<img src="/static/smileys/Sushi_emoji.png" alt=":sushi:" title=":sushi:" class="bbcode_smiley">',
            '<img src="/static/smileys/Apple_emoji.png" alt=":apple:" title=":apple:" class="bbcode_smiley">',
            '<img src="/static/smileys/Broccoli_emoji.png" alt=":broccoli:" title=":broccoli:" class="bbcode_smiley">',
            '<img src="/static/smileys/Pizza_emoji.png" alt=":pizza:" title=":pizza:" class="bbcode_smiley">',
            '<img src="/static/smileys/Candycorn.png" alt=":candycorn:" title=":candycorn:" class="bbcode_smiley">',
            '<img src="/static/smileys/10milemoji.png" alt=":10mil:" title=":10mil:" class="bbcode_smiley">',
            '<img src="/static/smileys/Map_emoji.png" alt=":map:" title=":map:" class="bbcode_smiley">',
            '<img src="/static/smileys/Camera_emoji.png" alt=":camera:" title=":camera:" class="bbcode_smiley">',
            '<img src="/static/smileys/Suitcase_emoji.png" alt=":suitcase:" title=":suitcase:" class="bbcode_smiley">',
            '<img src="/static/smileys/Compass.png" alt=":compass:" title=":compass:" class="bbcode_smiley">',
            '<img src="/static/smileys/Binoculars.png" alt=":binoculars:" title=":binoculars:" class="bbcode_smiley">',
            '<img src="/static/smileys/Ksllxmfcai-emoji.png" alt=":ksllxmfcai:" title=":ksllxmfcai:" class="bbcode_smiley">',
            '<img src="/static/smileys/Cupcake.png" alt=":cupcake:" title=":cupcake:" class="bbcode_smiley">',
            '<img src="/static/smileys/Cat-emoji.png" alt=":cat:" title=":cat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Aww-cat-emoji.png" alt=":awwcat:" title=":awwcat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Cool-cat-emoji.png" alt=":coolcat:" title=":coolcat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Tongue-out-cat-emoji.png" alt=":tongueoutcat:" title=":tongueoutcat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Wink-cat-emoji.png" alt=":winkcat:" title=":winkcat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Lol-cat-emoji.png" alt=":lolcat:" title=":lolcat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Upside-down-cat-emoji.png" alt=":upsidedowncat:" title=":upsidedowncat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Huh-cat-emoji.png" alt=":huhcat:" title=":huhcat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Love-it-cat-emoji.png" alt=":loveitcat:" title=":loveitcat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Fav-it-cat-emoji.png" alt=":favitcat:" title=":favitcat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Rainbow-cat-emoji.png" alt=":rainbowcat:" title=":rainbowcat:" class="bbcode_smiley">',
            '<img src="/static/smileys/Pizza-cat-emoji.png" alt=":pizzacat:" title=":pizzacat:" class="bbcode_smiley">',
            '<img src="/static/smileys/angry.gif" alt="&gt;:(" title="&gt;:(" class="bbcode_smiley">',
            '<img src="/static/smileys/anime.gif" alt="^_^" title="^_^" class="bbcode_smiley">',
            '<img src="/static/smileys/bigeyes.gif" alt="8)" title="8)" class="bbcode_smiley">',
            '<img src="/static/smileys/evil.gif" alt="&gt;:)" title="&gt;:)" class="bbcode_smiley">',
            '<img src="/static/smileys/bigsmile.gif" alt=":D" title=":D" class="bbcode_smiley">',
            '<img src="/static/smileys/sneaky.gif" alt="&gt;;)" title="&gt;;)" class="bbcode_smiley">',
            '<img src="/static/smileys/bigwink.gif" alt=";D" title=";D" class="bbcode_smiley">',
            '<img src="/static/smileys/blue.gif" alt=":blue:" title=":blue:" class="bbcode_smiley">',
            '<img src="/static/smileys/boggle.gif" alt="o.O" title="o.O" class="bbcode_smiley">',
            '<img src="/static/smileys/confuse.gif" alt=":?" title=":?" class="bbcode_smiley">',
            '<img src="/static/smileys/cool.gif" alt="B)" title="B)" class="bbcode_smiley">',
            '<img src="/static/smileys/frown.gif" alt=":(" title=":(" class="bbcode_smiley">',
            '<img src="/static/smileys/heart.gif" alt="&lt;3" title="&lt;3" class="bbcode_smiley">',
            '<img src="/static/smileys/irritated.gif" alt=":/" title=":/" class="bbcode_smiley">',
            '<img src="/static/smileys/laugh.gif" alt="XD" title="XD" class="bbcode_smiley">',
            '<img src="/static/smileys/lookleft.gif" alt="&lt_&lt;" title="&lt;_&lt;" class="bbcode_smiley">',
            '<img src="/static/smileys/lookright.gif" alt="&gt_&gt;" title="&gt;_&gt;" class="bbcode_smiley">',
            '<img src="/static/smileys/neutral.gif" alt=":|" title=":|" class="bbcode_smiley">',
            '<img src="/static/smileys/saint.gif" alt="O:)" title="O:)" class="bbcode_smiley">',
            '<img src="/static/smileys/sleepy.gif" alt=":zzz:" title=":zzz:" class="bbcode_smiley">',
            '<img src="/static/smileys/smile.gif" alt=":)" title=":)" class="bbcode_smiley">',
            '<img src="/static/smileys/smile3.gif" alt=":3" title=":3" class="bbcode_smiley">',
            '<img src="/static/smileys/star.gif" alt=":star:" title=":star:" class="bbcode_smiley">',
            '<img src="/static/smileys/surprise.gif" alt=":O" title=":O" class="bbcode_smiley">',
            '<img src="/static/smileys/sweatdrop.gif" alt="^^;" title="^^;" class="bbcode_smiley">',
            '<img src="/static/smileys/teeth.gif" alt="&lt;g&gt;" title="&lt;g&gt;" class="bbcode_smiley">',
            '<img src="/static/smileys/tongue.gif" alt=":P" title=":P" class="bbcode_smiley">',
            '<img src="/static/smileys/wink.gif" alt=";)" title=";)" class="bbcode_smiley">',
            '<img src="/static/smileys/wink3.gif" alt=";3" title=";3" class="bbcode_smiley">',
            '<img src="/static/smileys/worry.gif" alt=":s" title=":s" class="bbcode_smiley">',
            //markdown
            '<a href="$1" rel="noopener noreferrer nofollow ugc" target="_blank">$1</a>', //urls
            "<a href='/user/$1'>@$1</a>", //user profile ats
            "<a href='/search_query?q=%23$1'>#$1</a>", //hashtags
            "<span style='color:#789922;'>&gt;$1</span>", //greentext
            "<span style='color:#f6750b;'>&lt;$1</span>", //orange text
            "<span style='color:#6577E6;'>^$1</span>", //light blue text
            "<b style='color:#af0a0f;'>$1</b>", //red text
            "<b style='color:#2424ad;'>$1</b>", //blue text
            "<b style='color:#720b98;'>$1</b>", //purple text
            "<b>$1</b>", //bold
            "<i>$1</i>", //italic
            "<s>$1</s>", //strikethrough
            "<span class='bbcode_spoiler'>$1</span>", //spoiler
            "<u>$1</u>", //underline
            "<code>$1</code>", //code text
            "<span style='font-size:x-large'>$1</span>", //big text
            "<span style='font-size:x-small'>$1</span>", //tiny text
            "<span class='aagiko'>$1</span>", //shift jis text
            "<span style='text-shadow:0px 0px 40px #00fe20, 0px 0px 2px #00fe20'>$1</span>", //glow text
            "<span style='text-shadow:0px 0px 40px #fffb00, 0px 0px 2px #fffb00'>$1</span>", //sneed text
            "<span style='text-shadow:0px 0px 40px #bd0606, 0px 0px 2px #bd0606'>$1</span>", //red glow
            "<span style='text-shadow:0px 0px 40px #36d7f7, 0px 0px 2px #36d7f7'>$1</span>", //blue glow
            "<span style='background: linear-gradient(to left, red, orange, yellow, green, cyan, blue, violet);-webkit-background-clip: text;-webkit-text-fill-color: transparent;'>$1</span>", //rainbow text
            "<span style='color:#FD3D98; font-weight:bold;'><b>$1</b></span>" //pisces text
        ];
        $text = preg_replace($formatting_find, $formatting_replace, $text);
        $text = preg_replace_callback("/((\d{1,2}:)+\d{2})/", function($matches){ return "<a onclick=\"yt.www.watch.player.seekTo(".$this->timestamp($matches[0]).", false)\">".$matches[0]."</a>"; }, $text); //seek to
        $text = str_replace(PHP_EOL, "<br>", $text);
        return $text;
    }    
}
?>
