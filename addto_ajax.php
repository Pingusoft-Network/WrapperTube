<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/insert.php"); ?>
<?php
    $_user_fetch_utils = new user_fetch_utils();
    $_video_fetch_utils = new video_fetch_utils();
    $_user_insert_utils = new user_insert_utils();
    $_base_utils = new config_setup();

    $_base_utils->initialize_db_var($conn);
    $_video_fetch_utils->initialize_db_var($conn);
    $_user_fetch_utils->initialize_db_var($conn);
    $_user_insert_utils->initialize_db_var($conn);
?>
<?php
$status = 0;
?>
<?php if(!isset($_SESSION['siteusername'])) { $status = 1; goto skip; } ?>
<?php if($_SERVER['REQUEST_METHOD'] != 'POST') { $status = 1; goto skip; } ?>
<?php if(empty($_POST['video_ids'])) { $status = 1; goto skip; } ?>
<?php
if (!$_video_fetch_utils->video_exists($_POST['video_ids'])) {
$status = 1; goto skip;
}

$stmt = $conn->prepare("INSERT INTO quicklist_videos (video, author) VALUES (?, ?)");
$stmt->bind_param("ss", $_POST['video_ids'], $_SESSION['siteusername']);
$stmt->execute();
$stmt->close();

skip:
header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<root><return_code><![CDATA[<?php echo $status; ?>]]></return_code></root>
