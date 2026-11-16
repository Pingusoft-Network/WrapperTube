<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/insert.php"); ?>
<?php if(!isset($_SESSION['siteusername'])) { die(header("Location: /sign_in")); die(); } ?>
<?php 
    $_user_fetch_utils = new user_fetch_utils();
    $_video_fetch_utils = new video_fetch_utils();
    $_video_insert_utils = new video_insert_utils();
    $_user_insert_utils = new user_insert_utils();
    $_base_utils = new config_setup();

    $_base_utils->initialize_db_var($conn);
    $_video_fetch_utils->initialize_db_var($conn);
    $_video_insert_utils->initialize_db_var($conn);
    $_user_fetch_utils->initialize_db_var($conn);
    $_user_insert_utils->initialize_db_var($conn);

$thread = $_user_fetch_utils->fetch_thread_name($_GET['v']);

if(!$thread) { die('This thread doesn\'t exist!'); }
if($thread['author'] != $_SESSION['siteusername']) { die('This is not your thread!'); }

$stmt = $conn->prepare("UPDATE forum_thread SET open = 'y' WHERE id = ?");
$stmt->bind_param("s", $thread['id']);
$stmt->execute();
$stmt->close();

header("Location: /forum/thread?v=" . $thread['id']);
?>
