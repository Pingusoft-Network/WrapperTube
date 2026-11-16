<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php
$sql = "
    SELECT reply_rank, id, contents, date, author, toid, last_modified
    FROM (
        SELECT 
            id, 
            contents, 
            date, 
            author, 
            toid, 
            last_modified, 
            RANK() OVER (PARTITION BY toid ORDER BY id ASC) AS reply_rank
        FROM forum_replies 
        WHERE toid = (SELECT toid FROM forum_replies WHERE id = :id1)
    ) AS ranked_comments
    WHERE id = :id2
    LIMIT 1;
";

$stmt = $__db->prepare($sql);
$stmt->execute([
    'id1' => $_GET['v'],
    'id2' => $_GET['v']
]);

$number_of_result = $stmt->rowCount();

if ($number_of_result === 0) {
die(header("Location: /community?error=This reply doesn't exist!"));
}

$_reply = $stmt->fetch(PDO::FETCH_ASSOC);

die(header("Location: /forum/thread?v=" . $_reply['toid'] . "&page=" . ceil($_reply['reply_rank']/25) . "#" . $_reply['id']));

?>
