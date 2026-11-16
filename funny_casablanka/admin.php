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
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);
    $request = (object) [
        "action"  => $_GET['action'],
        "users"   => $_POST['users'],
        "reason"  => $_POST['ban_reason'],
        "videos"  => $_POST['videos'],
        "threads" => $_POST['threads'],
        "groups" => $_POST['groups'],
        "from"    => $_SESSION['siteusername'],
        "expiry"    => time() + (intval($_POST['expiry']) * 86400),

        "error" => (object) [
            "message" => "",
            "status" => "OK"
        ]
    ]; 

    $request->users  = explode(",", $request->users);
    $request->videos = explode(",", $request->videos);
    $request->threads = explode(",", $request->threads);
    $request->groups = explode(",", $request->groups);
    $request->tables = array(
        "users"            => "username",
        "videos"           => "author",
        "channel_views"    => "viewer",
        "comments"         => "author",
        "comment_likes"    => "sender",
        "comment_reply"    => "author",
        "favorite_video"   => "sender",
        "friends"          => "sender",
        "likes"            => "sender",
        "playlists"        => "author",
        "pms"              => "owner",
        "profile_comments" => "author",
        "quicklist_videos" => "author",
        "reports"          => "sender",
        "subscribers"      => "sender",
        "views"            => "viewer",
    );
    $request->tables_increment = 0;

    if($request->action == "ban_users") {        
        foreach($request->users as $username) {
$the_user = $__user_h->fetch_user_username($username);
if ($the_user['status'] == "admin") {
continue;
}
            $stmt = $__db->prepare("DELETE FROM users WHERE username=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));
            $stmt = null;

            $stmt = $__db->prepare("DELETE FROM user_groups WHERE group_author=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));
            $stmt = null;
            
            $stmt = $__db->prepare("DELETE FROM videos WHERE author=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));
            $stmt = null;

    $stmt = $__db->prepare("DELETE FROM video_response WHERE author=:username");
    $stmt->execute(array(
        ':username' => $username,
    ));
    $stmt = null;

            $stmt = $__db->prepare("DELETE FROM channel_views WHERE viewer=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));
            $stmt = null;

            $stmt = $__db->prepare("DELETE FROM comments WHERE author=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));
            $stmt = null;

            $stmt = $__db->prepare("DELETE FROM comment_likes WHERE sender=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));
            $stmt = null;

            $stmt = $__db->prepare("DELETE FROM comment_reply WHERE author=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));
            $stmt = null;

            $stmt = $__db->prepare("DELETE FROM favorite_video WHERE sender=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));
            $stmt = null;

    $stmt = $__db->prepare("DELETE FROM forum_replies WHERE author=:username");
    $stmt->execute(array(
        ':username' => $username,
    ));
    $stmt = null;

    $stmt = $__db->prepare("DELETE FROM forum_thread WHERE author=:username");
    $stmt->execute(array(
        ':username' => $username,
    ));
    $stmt = null;

            $stmt = $__db->prepare("DELETE FROM friends WHERE sender=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));
            $stmt = null;

            $stmt = $__db->prepare("DELETE FROM friends WHERE reciever=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));
            $stmt = null;

            $stmt = $__db->prepare("DELETE FROM likes WHERE sender=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));
            $stmt = null;

    $stmt = $__db->prepare("DELETE FROM block WHERE sender=:username");
    $stmt->execute(array(
        ':username' => $username,
    ));
    $stmt = null;

    $stmt = $__db->prepare("DELETE FROM block WHERE reciever=:username");
    $stmt->execute(array(
        ':username' => $username,
    ));
    $stmt = null;

    $stmt = $__db->prepare("DELETE FROM group_discussion WHERE author=:username");
    $stmt->execute(array(
        ':username' => $username,
    ));
    $stmt = null;

    $stmt = $__db->prepare("DELETE FROM group_members WHERE username=:username");
    $stmt->execute(array(
        ':username' => $username,
    ));
    $stmt = null;

            $stmt = $__db->prepare("DELETE FROM playlists WHERE author=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));
            $stmt = null;

            $stmt = $__db->prepare("DELETE FROM pms WHERE owner=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));
            $stmt = null;

            $stmt = $__db->prepare("DELETE FROM pms WHERE touser=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));
            $stmt = null;

            $stmt = $__db->prepare("DELETE FROM profile_comments WHERE author=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));
            $stmt = null;

            $stmt = $__db->prepare("DELETE FROM profile_comments WHERE toid=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));
            $stmt = null;

    $stmt = $__db->prepare("DELETE FROM history WHERE author=:username");
    $stmt->execute(array(
        ':username' => $username,
    ));
    $stmt = null;

            $stmt = $__db->prepare("DELETE FROM quicklist_videos WHERE author=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));
            $stmt = null;
            
            $stmt = $__db->prepare("DELETE FROM reports WHERE sender=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));
            $stmt = null;

    $stmt = $__db->prepare("DELETE FROM stars WHERE sender=:username");
    $stmt->execute(array(
        ':username' => $username,
    ));
    $stmt = null;

            $stmt = $__db->prepare("DELETE FROM subscribers WHERE sender=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));
            $stmt = null;

            $stmt = $__db->prepare("DELETE FROM subscribers WHERE reciever=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));
            $stmt = null;

            $stmt = $__db->prepare("DELETE FROM ugc_ads WHERE author=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));
            $stmt = null;

            $stmt = $__db->prepare("DELETE FROM views WHERE viewer=:username");
            $stmt->execute(array(
                ':username' => $username,
            ));
            $stmt = null;
		$__user_i->admin_log("admin", $_SESSION['siteusername'], "I deleted the user, " . $username);
        }
            die(header("Location: /funny_casablanka/bans"));
    } else if($request->action == "delete_videos") {
        foreach($request->videos as $video) {
$the_video = $__video_h->fetch_video_rid($video);
  if(strpos($the_video['thumbnail'], "default") === false) {
   unlink('../dynamic/thumbs/' . $the_video['thumbnail']);
  }
unlink('../dynamic/videos/' . $the_video['filename']);
            $stmt = $__db->prepare("DELETE FROM videos WHERE rid=:video");
            $stmt->execute(array(
                ':video' => $video,
            ));
            $stmt = null;
$__user_i->admin_log("admin", $_SESSION['siteusername'], "I deleted the video, \"" . $the_video['title'] . "\" with the description, \"" . $the_video['description'] . "\" by, " . $the_video['author']);
        }
            die(header("Location: /funny_casablanka/bans"));
    } else if($request->action == "delete_forum_thread") {
        foreach($request->threads as $thread) {
        $stmt = $__db->prepare("SELECT * FROM forum_thread WHERE id = :thread LIMIT 1");
        $stmt->bindParam(":thread", $thread);
        $stmt->execute();
        $the_row = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = null;
            $stmt = $__db->prepare("DELETE FROM forum_thread WHERE id=:thread");
            $stmt->execute(array(
                ':thread' => $thread,
            ));
            $stmt = null;
	    $stmt6 = $__db->prepare("DELETE FROM forum_replies WHERE toid=:thread");
            $stmt6->execute(array(
                ':thread' => $thread,
            ));
            $stmt6 = null;
            $__user_i->admin_log("admin", $_SESSION['siteusername'], "I deleted the forum thread, \"" . $the_row['title'] . "\" with the contents, \"" . $the_row['contents'] . "\" by, " . $the_row['author']);
        }
            die(header("Location: /funny_casablanka/bans"));
    } else if($request->action == "delete_group") {
        foreach($request->groups as $group) {
        $stmt = $__db->prepare("SELECT * FROM user_groups WHERE id = :group LIMIT 1");
        $stmt->bindParam(":group", $group);
        $stmt->execute();
        $the_row = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = null;
            $stmt = $__db->prepare("DELETE FROM user_groups WHERE id=:group");
            $stmt->execute(array(
                ':group' => $group,
            ));
            $stmt = null;
            $stmt6 = $__db->prepare("DELETE FROM group_discussion WHERE toid=:group");
            $stmt6->execute(array(
                ':group' => $group,
            ));
            $stmt6 = null;
            $stmt6 = $__db->prepare("DELETE FROM group_members WHERE togroup=:group");
            $stmt6->execute(array(
                ':group' => $group,
            ));
            $stmt6 = null;
            $stmt6 = $__db->prepare("DELETE FROM group_videos WHERE toid=:group");
            $stmt6->execute(array(
                ':group' => $group,
            ));
            $stmt6 = null;
            $stmt6 = $__db->prepare("DELETE FROM group_playlists WHERE toid=:group");
            $stmt6->execute(array(
                ':group' => $group,
            ));
            $stmt6 = null;
            $__user_i->admin_log("admin", $_SESSION['siteusername'], "I deleted the group, \"" . $the_row['group_title'] . "\" with the description, \"" . $the_row['group_description'] . "\" by, " . $the_row['group_author']);
        }
            die(header("Location: /funny_casablanka/bans"));
    }   else if($request->action == "actually_just_ban") {
$the_user = $__user_h->fetch_user_username($_POST['users']);
if ($the_user['status'] == "admin") {
die("You cannot ban admins");
}
$original_expiry = $_POST['expiry'];
        if (!intval($_POST['expiry'])) {
            $_POST['expiry'] = 0;
        } else {
            $_POST['expiry'] = time() + (intval($_POST['expiry']) * 86400);
        }
        $stmt = $__db->prepare("INSERT INTO bans (username, reason, expire, moderator, real_expire) VALUES (:username, :reason, now(), :moderator, :real_expire)");
        $stmt->execute(array(
            ':username'  => $_POST['users'],
            ':moderator' => $_SESSION['siteusername'],
            ':real_expire'   => $_POST['expiry'],
            ':reason'    => $request->reason,
        ));
        $stmt = null;
            $__user_i->admin_log("admin", $_SESSION['siteusername'], "I banned the user, " . $_POST['users'] . " for " . $original_expiry . " days with the reason, " . $request->reason);

        die(header("Location: /funny_casablanka/bans"));
    } else if($request->action == "actually_just_ban_ip") {
        $_user = $__user_h->fetch_user_username($_POST['users']);
if ($_user['status'] == "admin") {
die("You cannot ban admins");
}
        $stmt = $__db->prepare("INSERT INTO bans (username, reason, expire, moderator) VALUES (:username, :reason, now(), :moderator)");
        $stmt->execute(array(
            ':username'  => $_user['ip'],
            ':moderator' => $_SESSION['siteusername'],
            ':reason'    => "",
        ));
        $stmt = null;
        $__user_i->admin_log("admin", $_SESSION['siteusername'], "I banned the IP, " . $_user['ip'] . " of the user, " . $_user['username']);
        die(header("Location: /funny_casablanka/bans"));
    } else if($request->action == "get_user_info") {
        $_user = $__user_h->fetch_user_username($_POST['users']);

	header("Content-Type: text/plain"); //display info
	echo "username: " . $_user["username"] . "\nip: " . $_user["ip"] . "\nemail: " . $_user["email"] . "\nid: " . $_user["id"] . "\npassword: " . $_user["password"] . "\nstatus: " . $_user["status"] . "\ntrusted: " . $_user["partner"] . "\ncreated: " . date("D, M d, Y, h:i A", strtotime($_user["created"])) . "\nlastlogin: " . date("D, M d, Y, h:i A", strtotime($_user["lastlogin"])) . "\ncooldown_comment: " . date("D, M d, Y, h:i A", strtotime($_user["cooldown_comment"])) . "\nupload_cooldown: " . date("D, M d, Y, h:i A", strtotime($_user["upload_cooldown"])) . "\nbio: " . $_user["bio"] . "\nwebsite: " . $_user["website"];
	die();
    } else if($request->action == "get_user_alts") {
?>
                                                                        <?php $_user = $__user_h->fetch_user_username($_POST['users']); ?>
                                                                        <?php
                                                                                $stmt = $__db->prepare("SELECT ip, username FROM users WHERE ip = :ip");
                                                                                $stmt->bindParam(":ip", $_user['ip']);
                                                                                $stmt->execute();
                                                                                $alts = $stmt->rowCount();

                                                                                if($alts != 0) { echo "Alts will pop up below here by IP...<br>"; }

                                                                                while($username = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                                        if($username['username'] != $_POST['users'] && $username['ip'] != "0.0.0.0")
                                                                                                echo "
                                                                                                  <a href='/user/" .  htmlspecialchars($username['username']) . "'>" .
                                                                                                        htmlspecialchars($username['username'])
                                                                                                . "</a><br>";
                                                                                }
                                                                                $stmt = null;
                                                                        ?>

                                                                        <?php $_user = $__user_h->fetch_user_username($_POST['users']); ?>
                                                                        <?php
                                                                                $stmt = $__db->prepare("SELECT ip, username FROM users WHERE email = :email");
                                                                                $stmt->bindParam(":email", $_user['email']);
                                                                                $stmt->execute();
                                                                                $alts = $stmt->rowCount();

                                                                                if($alts != 0) { echo "Alts will pop up below here by E-Mail address...<br>"; }

                                                                                while($username = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                                        if($username['username'] != $_POST['users'])
                                                                                                echo "
                                                                                                  <a href='/user/" .  htmlspecialchars($username['username']) . "'>" .
                                                                                                        htmlspecialchars($username['username'])
                                                                                                . "</a><br>";
                                                                                }
                                                                                $stmt = null;
                                                                        ?>
<?php
        die();
    } else if($request->action == "log_on_to_user") {
        $_user = $__user_h->fetch_user_username($_POST['users']);
        $original_username = $_SESSION['siteusername'];
        session_start();
        $_SESSION['siteusername'] = $_user['username'];
        $_SESSION['adminlogin'] = true;
        $_SESSION['adminloginoriginalusername'] = $original_username;
        session_write_close();
$__user_i->admin_log("admin", $original_username, "I logged on to the user, " . $_user['username']);
        die(header("Location: /"));
    } else if($request->action == "delete_forum_reply") {
        foreach($request->threads as $thread) {
        $stmt = $__db->prepare("SELECT * FROM forum_replies WHERE id = :thread LIMIT 1");
        $stmt->bindParam(":thread", $thread);
        $stmt->execute();
        $the_row = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = null;
            $stmt6 = $__db->prepare("DELETE FROM forum_replies WHERE id=:thread");
            $stmt6->execute(array(
                ':thread' => $thread,
            ));
            $stmt6 = null;
$__user_i->admin_log("admin", $_SESSION['siteusername'], "I deleted the forum reply, \"" . $the_row['content'] . "\" by, " . $the_row['author']);
        }
            die(header("Location: /funny_casablanka/bans"));
    } else if($request->action == "delete_profile_comment") {
        foreach($request->threads as $thread) {
        $stmt = $__db->prepare("SELECT * FROM profile_comments WHERE id = :thread LIMIT 1");
        $stmt->bindParam(":thread", $thread);
        $stmt->execute();
        $the_row = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = null;
            $stmt6 = $__db->prepare("DELETE FROM profile_comments WHERE id=:thread");
            $stmt6->execute(array(
                ':thread' => $thread,
            ));
            $stmt6 = null;
$__user_i->admin_log("admin", $_SESSION['siteusername'], "I deleted the profile comment, \"" . $the_row['comment'] . "\" to " . $the_row['toid'] . " from " . $the_row['author']);
        }
            die(header("Location: /funny_casablanka/bans"));
    } else if($request->action == "delete_comment") {
        foreach($request->threads as $thread) {
        $stmt = $__db->prepare("SELECT * FROM comments WHERE id = :thread LIMIT 1");
        $stmt->bindParam(":thread", $thread);
        $stmt->execute();
        $the_row = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = null;
            $stmt = $__db->prepare("DELETE FROM comment_reply WHERE toid=:thread");
            $stmt->execute(array(
                ':thread' => $thread,
            ));
            $stmt = null;
            $stmt6 = $__db->prepare("DELETE FROM comments WHERE id=:thread");
            $stmt6->execute(array(
                ':thread' => $thread,
            ));
            $stmt6 = null;
$__user_i->admin_log("admin", $_SESSION['siteusername'], "I deleted the comment, \"" . $the_row['comment'] . "\" to " . $__video_h->fetch_video_rid($the_row['toid'])['title'] . " from " . $the_row['author']);
        }
            die(header("Location: /funny_casablanka/bans"));
    } else if($request->action == "delete_reply") {
        foreach($request->threads as $thread) {
        $stmt = $__db->prepare("SELECT * FROM comment_reply WHERE id = :thread LIMIT 1");
        $stmt->bindParam(":thread", $thread);
        $stmt->execute();
        $the_row = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = null;
            $stmt = $__db->prepare("DELETE FROM comment_reply WHERE id=:thread");
            $stmt->execute(array(
                ':thread' => $thread,
            ));
            $stmt = null;
$__user_i->admin_log("admin", $_SESSION['siteusername'], "I deleted the comment reply, \"" . $the_row['comment'] . "\" to " . $__video_h->fetch_comment_id($the_row['toid'])['comment'] . " from " . $the_row['author']);
        }
            die(header("Location: /funny_casablanka/bans"));
    } else if($request->action == "delete_group_comment") {
        foreach($request->threads as $thread) {
        $stmt = $__db->prepare("SELECT * FROM group_discussion WHERE id = :thread LIMIT 1");
        $stmt->bindParam(":thread", $thread);
        $stmt->execute();
        $the_row = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = null;
            $stmt6 = $__db->prepare("DELETE FROM group_discussion WHERE id=:thread");
            $stmt6->execute(array(
                ':thread' => $thread,
            ));
            $stmt6 = null;
$__user_i->admin_log("admin", $_SESSION['siteusername'], "I deleted the group comment, \"" . $the_row['comment'] . "\" to " . $__video_h->fetch_group_id($the_row['toid'])['group_title'] . " from " . $the_row['author']);
        }
            die(header("Location: /funny_casablanka/bans"));
    } else if($request->action == "delete_playlist") {
        foreach($request->threads as $thread) {
        $stmt = $__db->prepare("SELECT * FROM playlists WHERE rid = :thread LIMIT 1");
        $stmt->bindParam(":thread", $thread);
        $stmt->execute();
        $the_row = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = null;
            $stmt6 = $__db->prepare("DELETE FROM playlists WHERE rid=:thread");
            $stmt6->execute(array(
                ':thread' => $thread,
            ));
            $stmt6 = null;

            $__user_i->admin_log("admin", $_SESSION['siteusername'], "I deleted the playlist, \"" . $the_row['title'] . "\" with the description \"" . $the_row['description'] . "\" by " . $the_row['author']);
        }
die(header("Location: /funny_casablanka/bans"));
    } else if($request->action == "change_user_status") {
$__user_u->update_row($_POST['users'], "status", $_POST['status']);
$__user_i->admin_log("admin", $_SESSION['siteusername'], "I changed " . $_POST['users'] . "'s status to a " . $_POST['status']);
die(header("Location: /funny_casablanka/bans"));
    } else if($request->action == "change_user_partner") {
$the_user = $__user_h->fetch_user_username($_POST['users']);
$__user_u->update_row($_POST['users'], "partner", (($the_user['partner']=='y')?'n':'y'));
$__user_i->admin_log("admin", $_SESSION['siteusername'], $_POST['users'] . " is trusted? " . (($the_user['partner']=='y')?'n':'y'));
die(header("Location: /funny_casablanka/bans"));
    } else if($request->action == "update_ban") {
$original_expiry = $_POST['expiry'];
        if (!intval($_POST['expiry'])) {
            $_POST['expiry'] = 0;
        } else {
            $_POST['expiry'] = time() + (intval($_POST['expiry']) * 86400);
        }
        $stmt = $__db->prepare("UPDATE bans SET reason = :reason, moderator = :moderator, real_expire = :real_expire WHERE username = :username");
        $stmt->execute(array(
            ':username'  => $_POST['users'],
            ':moderator' => $_SESSION['siteusername'],
            ':real_expire'   => $_POST['expiry'],
            ':reason'    => $request->reason,
        ));
        $stmt = null;
            $__user_i->admin_log("admin", $_SESSION['siteusername'], "I updated the ban of the user, " . $_POST['users'] . " for " . $original_expiry . " days with the reason, " . $request->reason);

        die(header("Location: /funny_casablanka/bans"));
    } else if($request->action == "update_sitewide_message") {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/static/important/sitewide.txt", $_POST['message']);
            $__user_i->admin_log("admin", $_SESSION['siteusername'], "I updated the sitewide message to: " . $_POST['message']);
        die(header("Location: /funny_casablanka/bans"));
    } else if($request->action == "toggle_signups_disabled") {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/static/important/signups_disabled.txt", ($_POST['signups_disabled']=="on"?"on":""));
            $__user_i->admin_log("admin", $_SESSION['siteusername'], "Signups are " . ($_POST['signups_disabled']=="on"?"disabled":"enabled"));
        die(header("Location: /funny_casablanka/bans"));
    } else if($request->action == "toggle_lockdown_mode") {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/static/important/lockdown_mode.txt", ($_POST['lockdown_mode']=="on"?"on":""));
            $__user_i->admin_log("admin", $_SESSION['siteusername'], "Lockdown Mode is " . ($_POST['lockdown_mode']=="on"?"enabled":"disabled"));
        die(header("Location: /funny_casablanka/bans"));
    } else if($request->action == "move_forum_thread") {
        foreach($request->threads as $thread) {
        $stmt = $__db->prepare("SELECT * FROM forum_thread WHERE id = :thread LIMIT 1");
        $stmt->bindParam(":thread", $thread);
        $stmt->execute();
        $the_row = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = null;
            $stmt = $__db->prepare("UPDATE forum_thread SET category = :category WHERE id = :thread");
            $stmt->execute(array(
                ':category' => $_POST['category'],
                ':thread' => $thread
            ));
            $stmt = null;
            $__user_i->admin_log("admin", $_SESSION['siteusername'], "I moved the forum thread, \"" . $the_row['title'] . "\" with the ID of, " . $thread . " from, \"" . $the_row['category'] . "\" to, \"" . $_POST['category'] . "\"");
        }
            die(header("Location: /funny_casablanka/bans"));
    }

    //echo json_encode($request, JSON_PRETTY_PRINT);
?>
