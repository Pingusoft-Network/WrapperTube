<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/update.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/insert.php"); ?>
<?php
    $_user_fetch_utils = new user_fetch_utils();
    $_video_fetch_utils = new video_fetch_utils();
    $_video_insert_utils = new video_insert_utils();
    $_user_insert_utils = new user_insert_utils();
    $_user_update_utils = new user_update_utils();
    $_base_utils = new config_setup();
    
    $_base_utils->initialize_db_var($conn);
    $_video_fetch_utils->initialize_db_var($conn);
    $_video_insert_utils->initialize_db_var($conn);
    $_user_fetch_utils->initialize_db_var($conn);
    $_user_insert_utils->initialize_db_var($conn);
    $_user_update_utils->initialize_db_var($conn);

if (file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/static/important/lockdown_mode.txt")=="on") {die("Error:WrapperTube is currently experiencing an attack from vandals. Some of the site features have been temporarily disabled. Please try again later.");}

    if(!$_video_fetch_utils->group_exists($_GET['v']))
        die("Error:the group doesn't exist");

    $group = $_video_fetch_utils->fetch_group_id($_GET['v']);

    $group['joined'] = false;

    $group['admin'] = false;

    if($_user_fetch_utils->if_joined_group($_SESSION['siteusername'], $_GET['v']))
        $group['joined'] = true;

    if($_user_fetch_utils->if_group_admin($_SESSION['siteusername'], $_GET['v']))
        $group['admin'] = true;

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
        if($group['commenting'] == "n") { $error['message'] = "Comments have been disabled."; $error['status'] = true; }
        //if(ifBlocked(@$_SESSION['siteusername'], $user['username'], $conn)) { $error = "This user has blocked you!"; $error['status'] = true; } 

        if(!isset($error['message'])) {
            $stmt = $conn->prepare("INSERT INTO `group_discussion` (toid, author, comment) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $group['id'], $_SESSION['siteusername'], $text);
            $text = ($_POST['comment']);
            $stmt->execute();
            $stmt->close();

            $_user_update_utils->update_comment_cooldown_time($_SESSION['siteusername']);
            ?>
OK:            <hr class="thin-line">
            <div class="comment-watch" style="width:100%;">
                <a href="/user/<?php echo $_SESSION['siteusername']; ?>">
                <img class="comment-pfp" src="/dynamic/pfp/<?php echo $_user_fetch_utils->fetch_user_pfp($_SESSION['siteusername']); ?>">
                </a>
                <span  style="display: inline-block; vertical-align: top;width: 93%;">
                    <span class="comment-info" style="display: inline-block;">
                        <b><a style="text-decoration: none;" href="/user/<?php echo $_SESSION['siteusername']; ?>">
                            <?php echo $_SESSION['siteusername']; ?>
                        </a></b>
                        <span style="">(now)</span>
                    </span><br>
                    <span class="comment-text" style="display: inline-block;width: 100% !important;word-wrap: break-word;">
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
