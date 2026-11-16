<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/insert.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/update.php"); ?>
<?php
    $_user_fetch_utils = new user_fetch_utils();
    $_video_fetch_utils = new video_fetch_utils();
    $_video_insert_utils = new video_insert_utils();
    $_user_insert_utils = new user_insert_utils();
    $_user_update_utils = new user_update_utils();
    $_base_utils = new config_setup();
    
    $_base_utils->initialize_db_var($conn);
    $_video_fetch_utils->initialize_db_var($conn);
    $_user_fetch_utils->initialize_db_var($conn);
    $_user_insert_utils->initialize_db_var($conn);
    $_user_update_utils->initialize_db_var($conn);
    $_video_insert_utils->initialize_db_var($conn);

if (file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/static/important/lockdown_mode.txt")=="on") {die("Error:WrapperTube is currently experiencing an attack from vandals. Some of the site features have been temporarily disabled. Please try again later.");}

    if(!$_user_fetch_utils->user_exists($_GET['n']))
        die("Error:This user does not exist!");

    if(isset($_SESSION['siteusername']) && !$_user_fetch_utils->user_exists(@$_SESSION['siteusername'])) 
        die(header("Location: /logout"));

    $_user = $_user_fetch_utils->fetch_user_username($_GET['n']);


    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $error = array();

        if(!isset($_SESSION['siteusername'])){ $error['message'] = "you are not logged in"; $error['status'] = true; }
        if(!$_POST['comment']){ $error['message'] = "your comment cannot be blank"; $error['status'] = true; }
        if(strlen($_POST['comment']) > 1000){ $error['message'] = "your comment must be shorter than 1000 characters"; $error['status'] = true; }
if (!$_video_fetch_utils->if_partner($_SESSION['siteusername'])) {
        if(!isset($_POST['_CAPTCHA'])){ $error['message'] = "captcha validation failed"; $error['status'] = true; }
        if(!$_user_insert_utils->validateCaptchaNew($_POST['_CAPTCHA_KEY'], $_POST['_CAPTCHA'])) { $error['message'] = "captcha validation failed"; $error['status'] = true; }
}
        if($_user_fetch_utils->if_cooldown($_SESSION['siteusername'])) { $error['message'] = "You are on a cooldown! Wait for 20 seconds before posting another comment."; $error['status'] = true; }
        if($_user_fetch_utils->if_blocked($_user['username'], $_SESSION['siteusername'])) { $error = "This user has blocked you!"; $error['status'] = true; } 
        if($_user['commenting'] == "n") { $error = "This channel has commenting disabled!"; $error['status'] = true; }

        if(!isset($error['message'])) {
            $stmt = $conn->prepare("INSERT INTO `profile_comments` (toid, author, comment) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $_user['username'], $_SESSION['siteusername'], $text);
            $text = ($_POST['comment']);
            $stmt->execute();
            $stmt->close();

            $_user_update_utils->update_comment_cooldown_time($_SESSION['siteusername']);

            if(@$_SESSION['siteusername'] != $_user['username']) { 
                $_user_insert_utils->send_message($_user['username'], "New comment", 'I commented "' . $_POST['comment'] . '" on your profile!', $_SESSION['siteusername']);
            }
?>
OK:        <hr class="thin-line">
        <div class="comment-watch">
            <a href="/user/<?php echo $_SESSION['siteusername']; ?>">
            <img class="comment-pfp" src="/dynamic/pfp/<?php echo $_user_fetch_utils->fetch_user_pfp($_SESSION['siteusername']); ?>">
            </a>
            <span class="cauthor" style="display: inline-block; vertical-align: top;width: 562px;">
                <span class="comment-info" style="display: inline-block;">
                    <b><a style="text-decoration: none;" href="/user/<?php echo $_SESSION['siteusername']; ?>">
                        <?php echo $_SESSION['siteusername']; ?>
                    </a></b>
                    <span style="color: <?php echo htmlspecialchars($_user['primary_color_text']); ?>;">(now)</span>
                </span><br>
                <span class="comment-text" style="display: inline-block;width: 575px;word-wrap: break-word;">
                    <?php echo $_video_fetch_utils->parseTextDescription($_POST['comment']); ?>
                </span>
            </span>

        </div>
<?php
        } else {
          die("Error:" . $error['message']);
        }
    }
?>
