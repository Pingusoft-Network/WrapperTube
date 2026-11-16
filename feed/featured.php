<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/insert.php"); ?>
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

header('Content-type: application/atom+xml;charset=UTF-8');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<feed xmlns="http://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss/">
	<link rel="self" href="http://wrappertube.org/feed/featured"/>
	<id>http://wrappertube.org/feed/featured</id>
	<title>Featured Videos</title>
	<link rel="alternate" href="http://wrappertube.org/featured"/>
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM videos WHERE featured = 'v' AND visibility = 'n' ORDER BY id DESC LIMIT 25");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $i = 0;
                        while($video = $result->fetch_assoc()) { 
                                $i++;
if($i==1) { ?>
        <updated><?php echo date(DATE_ATOM, strtotime($video['publish'])); ?></updated>
<?php }
                                if($i <= 25) { 
                        ?>
        <entry>
                <id>http://wrappertube.org/watch?v=<?php echo $video['rid']; ?></id>
                <title><?php echo htmlspecialchars($video['title'], ENT_XML1 | ENT_QUOTES, 'UTF-8'); ?></title>
                <link rel="alternate" href="http://wrappertube.org/watch?v=<?php echo $video['rid']; ?>"/>
                <author>
                        <name><?php echo htmlspecialchars($video['author'], ENT_XML1 | ENT_QUOTES, 'UTF-8'); ?></name>
                        <uri>http://wrappertube.org/user/<?php echo htmlspecialchars($video['author'], ENT_XML1 | ENT_QUOTES, 'UTF-8'); ?></uri>
                </author>
                <published><?php echo date(DATE_ATOM, strtotime($video['publish'])); ?></published>
                <updated><?php echo date(DATE_ATOM, strtotime($video['last_modified'])); ?></updated>
                <media:title><?php echo htmlspecialchars($video['title'], ENT_XML1 | ENT_QUOTES, 'UTF-8'); ?></media:title>
                <media:content width="640" height="360"/>
                <media:player url="http://wrappertube.org/watch?v=<?php echo $video['rid']; ?>" width="640" height="360"/>
                <media:description type="html"><?php echo htmlspecialchars($_video_fetch_utils->parseTextDescription($video['description']), ENT_XML1 | ENT_QUOTES, 'UTF-8'); ?></media:description>
                <content type="html"><?php echo htmlspecialchars($_video_fetch_utils->parseTextDescription($video['description']), ENT_XML1 | ENT_QUOTES, 'UTF-8'); ?></content>
                <media:thumbnail url="http://wrappertube.org/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" width="640" height="360"/>
        </entry>
<?php } } $stmt->close(); ?>
</feed>
