<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/important/bbcode.php"); ?>
<?php
  $_user_fetch_utils = new user_fetch_utils();
  $_video_fetch_utils = new video_fetch_utils();
  $_base_utils = new config_setup();

  $_base_utils->initialize_db_var($conn);
  $_video_fetch_utils->initialize_db_var($conn);
  $_user_fetch_utils->initialize_db_var($conn);

  if ($_GET['c'] != "All") {
      $_category = $_user_fetch_utils->fetch_category_name($_GET['c']);

      if (!$_category) { http_response_code(404); die("Not Found"); }

      if ($_category['staffonlyviewing'] == "y" && (!$_video_fetch_utils->is_admin($_SESSION['siteusername']) && !$_video_fetch_utils->is_moderator($_SESSION['siteusername']))) {
          http_response_code(404); die("Not Found");
      }
  } else {
      $_category = "All";
  }

header('Content-type: application/atom+xml;charset=UTF-8');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<feed xmlns="http://www.w3.org/2005/Atom" xml:lang="en">
    <title>Latest replies<?php if ($_category != "All") { ?> on <?php echo htmlspecialchars($_category['title'], ENT_XML1 | ENT_QUOTES, 'UTF-8'); ?><?php } ?></title>
    <link href="http://wrappertube.org/<?php if ($_category != "All") { ?>forum/category?c=<?php echo urlencode($_category['title']); ?><?php } else { ?>commmunity<?php } ?>" rel="alternate" />
    <link href="http://wrappertube.org/feed/forum_category_replies?c=<?php if ($_category != "All") { echo urlencode($_category['title']); } else { echo "All"; } ?>" rel="self" />
    <id>http://wrappertube.org/<?php if ($_category != "All") { ?>forum/category?c=<?php echo urlencode($_category['title']); ?><?php } else { ?>commmunity<?php } ?></id>
            <?php
            if ($_GET['c'] != "All") {
                $stmt = $conn->prepare("SELECT r.*, t.title AS topic_title, t.category AS topic_category FROM forum_replies r INNER JOIN forum_thread t ON r.toid = t.id WHERE t.category = ? ORDER BY r.date DESC LIMIT 25");
                $stmt->bind_param("s", $_category['title']);
                $stmt->execute();
                $result = $stmt->get_result();
            } else {
                $stmt = $conn->prepare("SELECT r.*, t.title AS topic_title, t.category AS topic_category FROM forum_replies r INNER JOIN forum_thread t ON r.toid = t.id ORDER BY r.date DESC LIMIT 25");
                $stmt->execute();
                $result = $stmt->get_result();
            }
                $i = 0;
                while($thread = $result->fetch_assoc()) {
                    $_category = $_user_fetch_utils->fetch_category_name($thread['topic_category']);
                    if ($_category['staffonlyviewing'] == "y" && (!$_video_fetch_utils->is_admin($_SESSION['siteusername']) && !$_video_fetch_utils->is_moderator($_SESSION['siteusername']))) {
                        continue;
                    }
                $i++;
                if ($i == 1) {
            ?>
    <updated><?php echo date(DATE_ATOM, strtotime($thread['date'])); ?></updated>
<?php } ?>
    <entry>
        <title><?php echo htmlspecialchars($thread['topic_category'], ENT_XML1 | ENT_QUOTES, 'UTF-8'); ?> :: <?php echo htmlspecialchars($thread['topic_title'], ENT_XML1 | ENT_QUOTES, 'UTF-8'); ?></title>
        <link href="http://wrappertube.org/forum/reply?v=<?php echo htmlspecialchars($thread['id'], ENT_XML1 | ENT_QUOTES, 'UTF-8'); ?>" rel="alternate" />
        <published><?php echo date(DATE_ATOM, strtotime($thread['date'])); ?></published>
        <author>
            <name><?php echo htmlspecialchars($thread['author'], ENT_XML1 | ENT_QUOTES, 'UTF-8'); ?></name>
        </author>
        <id><?php echo htmlspecialchars($thread['id'], ENT_XML1 | ENT_QUOTES, 'UTF-8'); ?></id>
        <summary type="html"><?php echo htmlspecialchars($bbcode->Parse($thread['contents']), ENT_XML1 | ENT_QUOTES, 'UTF-8'); ?></summary>
    </entry>
            <?php } $stmt->close(); ?>
</feed>
