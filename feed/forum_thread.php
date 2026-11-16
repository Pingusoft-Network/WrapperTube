<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/insert.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/important/bbcode.php"); ?>
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

  if(!$thread) { http_response_code(404); die("Not Found"); }

  $_category = $_user_fetch_utils->fetch_category_name($thread['category']);

  if ($_category['staffonlyviewing'] == "y" && (!$_video_fetch_utils->is_admin($_SESSION['siteusername']) && !$_video_fetch_utils->is_moderator($_SESSION['siteusername']))) {
      http_response_code(404); die("Not Found");
  }

header('Content-type: application/atom+xml;charset=UTF-8');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<feed xmlns="http://www.w3.org/2005/Atom" xml:lang="en">
    <title>Latest posts on <?php echo htmlspecialchars($thread['title'], ENT_XML1 | ENT_QUOTES, 'UTF-8'); ?></title>
    <link href="http://wrappertube.org/forum/thread?v=<?php echo urlencode($thread['id']); ?>" rel="alternate" />
    <link href="http://wrappertube.org/feed/forum_thread?v=<?php echo urlencode($thread['id']); ?>" rel="self" />
    <id>http://wrappertube.org/forum/thread?v=<?php echo urlencode($thread['id']); ?></id>
            <?php
                $stmt = $conn->prepare("SELECT * FROM forum_replies WHERE toid = ? ORDER BY id DESC LIMIT 25");
                $stmt->bind_param("s", $thread['id']);
                $stmt->execute();
                $result = $stmt->get_result();
                $i = 0;
                while($comment = $result->fetch_assoc()) {
                $i++;
                if ($i == 1) {
            ?>
    <updated><?php echo date(DATE_ATOM, strtotime($comment['date'])); ?></updated>
<?php } ?>
    <entry>
        <title><?php echo htmlspecialchars($thread['category'], ENT_XML1 | ENT_QUOTES, 'UTF-8'); ?> :: <?php echo htmlspecialchars($thread['title'], ENT_XML1 | ENT_QUOTES, 'UTF-8'); ?></title>
        <link href="http://wrappertube.org/forum/thread?v=<?php echo htmlspecialchars($thread['id'], ENT_XML1 | ENT_QUOTES, 'UTF-8'); ?>#<?php echo htmlspecialchars($comment['id'], ENT_XML1 | ENT_QUOTES, 'UTF-8'); ?>" rel="alternate" />
        <published><?php echo date(DATE_ATOM, strtotime($comment['date'])); ?></published>
        <author>
            <name><?php echo htmlspecialchars($comment['author'], ENT_XML1 | ENT_QUOTES, 'UTF-8'); ?></name>
        </author>
        <id><?php echo htmlspecialchars($comment['id'], ENT_XML1 | ENT_QUOTES, 'UTF-8'); ?></id>
        <summary type="html"><?php echo htmlspecialchars($bbcode->Parse($comment['contents']), ENT_XML1 | ENT_QUOTES, 'UTF-8'); ?></summary>
    </entry>
            <?php } $stmt->close(); ?>
</feed>
