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

  $category = "None";

  $search = "%" . htmlspecialchars($_GET['q']) . "%";

  $_base_utils->initialize_page_compass("Search Forum Threads");

    if(!empty($_GET['c']))
        $category = ($_GET['c']);
?>
                            <?php
                            if (!empty($_GET['user'])) {
                            if($category != "None") {
                                $stmt56 = $conn->prepare("SELECT count(*) FROM forum_thread WHERE category = ? AND author = ? AND (lower(title) LIKE lower(?) OR lower(contents) LIKE lower(?))");
                                $stmt56->bind_param("ssss", $category, $_GET['user'], $search, $search);
                                $stmt56->execute();
                                $stmt56->bind_result($result56);
                                $stmt56->fetch();
                                $stmt56->close();
                            } else {
                                $stmt56 = $conn->prepare("SELECT count(*) FROM forum_thread WHERE author = ? AND (lower(title) LIKE lower(?) OR lower(contents) LIKE lower(?))");
                                $stmt56->bind_param("sss", $_GET['user'], $search, $search);
                                $stmt56->execute();
                                $stmt56->bind_result($result56);
                                $stmt56->fetch();
                                $stmt56->close();
                            }
                            } else {
                            if($category != "None") {
                                $stmt56 = $conn->prepare("SELECT count(*) FROM forum_thread WHERE category = ? AND (lower(title) LIKE lower(?) OR lower(contents) LIKE lower(?))");
                                $stmt56->bind_param("sss", $category, $search, $search);
                                $stmt56->execute();
                                $stmt56->bind_result($result56);
                                $stmt56->fetch();
                                $stmt56->close();
                            } else {
                                $stmt56 = $conn->prepare("SELECT count(*) FROM forum_thread WHERE (lower(title) LIKE lower(?) OR lower(contents) LIKE lower(?))");
                                $stmt56->bind_param("ss", $search, $search);
                                $stmt56->execute();
                                $stmt56->bind_result($result56);
                                $stmt56->fetch();
                                $stmt56->close();
                            }
                            }
                            ?>
<!DOCTYPE html>
<html>
    <head>
        <title>WrapperTube - <?php echo $_base_utils->return_current_page(); ?></title>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="content-script-type" content="text/javascript">
<meta http-equiv="content-style-type" content="text/css">
<meta name="description" content="Search Results For &quot;<?php echo htmlspecialchars($_GET['q']); ?>&quot;<?php if($category!="None"){ echo htmlspecialchars(" in \"" . $category . "\""); } ?><?php if (!empty($_GET['user'])) { ?> by &quot;<?php echo htmlspecialchars($_GET['user']); ?>&quot;<?php } ?>">
<meta name="theme-color" content="red">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
<meta property="og:title" content="WrapperTube - <?php echo $_base_utils->return_current_page(); ?>" />
<meta property="og:url" content="http://wrappertube.org/" />
<meta property="og:description" content="Search Results For &quot;<?php echo htmlspecialchars($_GET['q']); ?>&quot;<?php if($category!="None"){ echo htmlspecialchars(" in \"" . $category . "\""); } ?><?php if (!empty($_GET['user'])) { ?> by &quot;<?php echo htmlspecialchars($_GET['user']); ?>&quot;<?php } ?>" />
<meta property="og:image" content="/yt/imgbin/full-size-logo.png" />
        <script src="/static/js/core-js.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/static/js/scratchblocks.min.js"></script>
    <script type="text/javascript" src="/static/js/translations.js" charset="utf-8"></script>
    <script type="text/javascript">
    (function ($) {
        scratchblocks._currentLanguage = 'en';
        scratchblocks._currentLanguages = ['en'];
    })(jQuery);
    </script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/static/css/new/www-core.css">
        <style>
            .channel-box-top {
                background: #666;
                color: white;
                padding: 5px;
            }

            .sub_button {
                position: relative;
                bottom: 2px;
            }

            .channel-box-description {
                background: #e6e6e6;
                border: 1px solid #666;
                color: #666;
                padding: 5px;
            }

            .channel-box-no-bg {
                border: 1px solid #666;
                color: black;
                padding: 5px;
            }

            .channel-pfp {
                height: 88px;
                width: 88px;
                border-color: #666;
                border: 3px double #999;
            }

            .channel-stats {
                display: inline-block;
                vertical-align: top;
            }

            .channel-stats-minor {
                font-size: 11px;
            }
            
            .comment-pfp {
                width: 52px;
                height: 52px;
                border-color: #666;
                display: inline-block;
                border: 3px double #999;
            }
        </style>
    <script type="text/javascript">
    $(document).ready(function() {
      scratchblocks.renderMatching('pre.blocks', {
        languages: scratchblocks._currentLanguages,
        replace: function(el, svg, doc, options) {
          // add scratchblocks to `el`
          scratchblocks.replace(el, svg, doc, options);
        }
      });
    });
    </script>
        <link rel="stylesheet" href="/static/css/bbcode.css?v2">
    </head>
    <body>
        <div class="www-core-container">
            <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/module/header.php"); ?>
<form method="get" action="/forum/search">
<input type="text" placeholder="Search Forum Threads" name="q" style="width:60%;" value="<?php echo htmlspecialchars($_GET['q']); ?>">
<input type="text" placeholder="Search Author" name="user" style="width:25%;" value="<?php echo htmlspecialchars($_GET['user']); ?>">
<input type="hidden" name="c" value="<?php echo htmlspecialchars($category); ?>">
<input type="submit" value="Search" class="www-button www-button-grey">
</form><br>
<b><a href="/community">Index</a> » Search Results</b><br>
            <h1>Search results for "<?php echo htmlspecialchars($_GET['q']); ?>"<?php if($category!="None"){ echo htmlspecialchars(" in \"" . $category . "\""); } ?><?php if (!empty($_GET['user'])) { ?> by &quot;<?php echo htmlspecialchars($_GET['user']); ?>&quot;<?php } ?></h1>
            <span style="font-size: 11px;" class="grey-text">About <strong><?php echo number_format($result56); ?></strong> results</span><br>
            <?php
                            if (!empty($_GET['user'])) {
                            if($category != "None") {
                            $results_per_page = 25;

                            $stmt = $conn->prepare("SELECT count(*) FROM forum_thread WHERE category = ? AND author = ? AND (lower(title) LIKE lower(?) OR lower(contents) LIKE lower(?))");
                            $stmt->bind_param("ssss", $category, $_GET['user'], $search, $search);
                            $stmt->execute();
                            $stmt->bind_result($number_of_result);
                            $stmt->fetch();

                            $number_of_page = ceil ($number_of_result / $results_per_page);

                            if (!isset ($_GET['page']) ) {
                                $page = 1;
                            } else {
                                $page = (int)$_GET['page'];
                            }

                            $page_first_result = ($page - 1) * $results_per_page;

                            $stmt->close();

                            $stmt = $conn->prepare("SELECT * FROM forum_thread WHERE category = ? AND author = ? AND (lower(title) LIKE lower(?) OR lower(contents) LIKE lower(?)) ORDER BY last_post DESC LIMIT ?, ?");
                            $stmt->bind_param("ssssss", $category, $_GET['user'], $search, $search, $page_first_result, $results_per_page);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            } else {
                            $results_per_page = 25;

                            $stmt = $conn->prepare("SELECT count(*) FROM forum_thread WHERE author = ? AND (lower(title) LIKE lower(?) OR lower(contents) LIKE lower(?))");
                            $stmt->bind_param("sss", $_GET['user'], $search, $search);
                            $stmt->execute();
                            $stmt->bind_result($number_of_result);
                            $stmt->fetch();

                            $number_of_page = ceil ($number_of_result / $results_per_page);

                            if (!isset ($_GET['page']) ) {
                                $page = 1;
                            } else {
                                $page = (int)$_GET['page'];
                            }

                            $page_first_result = ($page - 1) * $results_per_page;

                            $stmt->close();

                            $stmt = $conn->prepare("SELECT * FROM forum_thread WHERE author = ? AND (lower(title) LIKE lower(?) OR lower(contents) LIKE lower(?)) ORDER BY last_post DESC LIMIT ?, ?");
                            $stmt->bind_param("sssss", $_GET['user'], $search, $search, $page_first_result, $results_per_page);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            }
                            } else {
                            if($category != "None") {
                            $results_per_page = 25;

                            $stmt = $conn->prepare("SELECT count(*) FROM forum_thread WHERE category = ? AND (lower(title) LIKE lower(?) OR lower(contents) LIKE lower(?))");
                            $stmt->bind_param("sss", $category, $search, $search);
                            $stmt->execute();
                            $stmt->bind_result($number_of_result);
                            $stmt->fetch();

                            $number_of_page = ceil ($number_of_result / $results_per_page);

                            if (!isset ($_GET['page']) ) {
                                $page = 1;
                            } else {
                                $page = (int)$_GET['page'];
                            }

                            $page_first_result = ($page - 1) * $results_per_page;

                            $stmt->close();

                            $stmt = $conn->prepare("SELECT * FROM forum_thread WHERE category = ? AND (lower(title) LIKE lower(?) OR lower(contents) LIKE lower(?)) ORDER BY last_post DESC LIMIT ?, ?");
                            $stmt->bind_param("sssss", $category, $search, $search, $page_first_result, $results_per_page);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            } else {
                            $results_per_page = 25;

                            $stmt = $conn->prepare("SELECT count(*) FROM forum_thread WHERE (lower(title) LIKE lower(?) OR lower(contents) LIKE lower(?))");
                            $stmt->bind_param("ss", $search, $search);
                            $stmt->execute();
                            $stmt->bind_result($number_of_result);
                            $stmt->fetch();

                            $number_of_page = ceil ($number_of_result / $results_per_page);

                            if (!isset ($_GET['page']) ) {
                                $page = 1;
                            } else {
                                $page = (int)$_GET['page'];
                            }

                            $page_first_result = ($page - 1) * $results_per_page;

                            $stmt->close();

                            $stmt = $conn->prepare("SELECT * FROM forum_thread WHERE (lower(title) LIKE lower(?) OR lower(contents) LIKE lower(?)) ORDER BY last_post DESC LIMIT ?, ?");
                            $stmt->bind_param("ssss", $search, $search, $page_first_result, $results_per_page);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            }
                            }
                while($thread = $result->fetch_assoc()) {
                    $_category = $_user_fetch_utils->fetch_category_name($thread['category']);
                    if ($_category['staffonlyviewing'] == "y" && (!$_video_fetch_utils->is_admin($_SESSION['siteusername']) && !$_video_fetch_utils->is_moderator($_SESSION['siteusername']))) {
                        continue;
                    }
                    $latest_forum_post_reply = $_user_fetch_utils->fetch_latest_forum_post_reply($thread['id']);
            ?>
                <hr class="thin-line">
                <h3 class="h3title" style="display: inline-block;"><a href="/forum/category?c=<?php echo urlencode($thread['category']); ?>"><?php echo htmlspecialchars($thread['category']); ?></a> :: <a href="/forum/thread?v=<?php echo $thread['id']; ?>" <?php if ($thread['open'] == 'n' || $thread['adminopen'] == 'n') { ?>style="text-decoration:line-through;color:grey;"<?php } ?>><?php if ($thread['adminopen'] == 'n') { ?><img src="/static/img/archive.png" width="16" height="16"> <?php } ?><?php echo htmlspecialchars($thread['title']); ?></a></h3>
                <span style="color: gray; font-size: 11px;">(<?php echo htmlspecialchars($thread['author']); ?>) (<?php echo $_user_fetch_utils->fetch_thread_replies($thread['id']); ?> replies) <?php echo date("M d, Y", strtotime($thread['date'])); ?>, last modified <?php echo date("M d, Y", strtotime($thread['last_modified'])); ?>, last post <?php echo date("M d, Y", strtotime($thread['last_post'])); ?></span>
                <br>
                <?php echo $bbcode->Parse($_video_fetch_utils->parseTextNoLinkForBBCode($thread['contents'])); ?><br><br>
                <?php if(isset($latest_forum_post_reply['toid'])) { 
                            $author = htmlspecialchars($latest_forum_post_reply['author']);
                ?>
                <div class="comment-watch" style="margin-left: 20px;width: 100%;">
                    <a href="/user/<?php echo $author; ?>">
                    <img class="comment-pfp" style="width: 33px;height: 33px;" src="/dynamic/pfp/<?php echo $_user_fetch_utils->fetch_user_pfp($latest_forum_post_reply['author']); ?>">
                    </a>
                    <span  style="display: inline-block; vertical-align: top;width: 90%;">
                        <span class="comment-info" style="display: inline-block;">
                            <b><a style="text-decoration: none;" href="/user/<?php echo $author; ?>">
                                <?php echo htmlspecialchars($latest_forum_post_reply['author']); ?> 
                            </a></b> 
                            <a href="thread?v=<?php echo $thread['id']; ?>#<?php echo $latest_forum_post_reply['id']; ?>"><span style="color: #666;">(<?php echo $_video_fetch_utils->time_elapsed_string($latest_forum_post_reply['date']); ?>, last modified <?php echo $_video_fetch_utils->time_elapsed_string($latest_forum_post_reply['last_modified']); ?>)</span></a>
                        </span><br>
                        <span class="comment-text" style="display: inline-block;width: 100% !important;">
                            <?php echo $bbcode->Parse($latest_forum_post_reply['contents']); ?>
                        </span>
                    </span>

                </div>
                <?php } ?>
            <?php } $stmt->close(); ?>
                  <?php
                                                                                                                if (!isset ($_GET['page']) ) {
                                                                                                                        $curpage = 1;
                                                                                                                } else {
                                                                                                                        $curpage = (int)$_GET['page'];
                                                                                                                }
?>
<?php if ($curpage > 1) { ?>
<a href="/forum/search?<?php if($category != 'None') { echo 'c=' . urlencode($category) . '&'; } ?>q=<?php echo urlencode($_GET['q']); ?><?php if (!empty($_GET['user'])) { ?>&user=<?php echo urlencode($_GET['user']); ?><?php } ?>&page=<?php echo $curpage - 1; ?>">Prev</a>&nbsp;
<?php } ?>
<?php for($page = 1; $page<= $number_of_page; $page++) { ?>
<?php if($curpage==$page){ ?>
<b><?php echo $page; ?></b>&nbsp;
<?php } else { ?>
<a href="/forum/search?<?php if($category != 'None') { echo 'c=' . urlencode($category) . '&'; } ?>q=<?php echo urlencode($_GET['q']); ?><?php if (!empty($_GET['user'])) { ?>&user=<?php echo urlencode($_GET['user']); ?><?php } ?>&page=<?php echo $page; ?>"><?php echo $page; ?></a>&nbsp;
<?php } ?>
                  <?php } ?>
<?php if ($curpage < $number_of_page) { ?>
<a href="/forum/search?<?php if($category != 'None') { echo 'c=' . urlencode($category) . '&'; } ?>q=<?php echo urlencode($_GET['q']); ?><?php if (!empty($_GET['user'])) { ?>&user=<?php echo urlencode($_GET['user']); ?><?php } ?>&page=<?php echo $curpage + 1; ?>">Next</a>&nbsp;
<?php } ?>
        </div>
        </div>
        <div class="www-core-container">
        <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/module/footer.php"); ?>
        </div>
        <script src="/static/js/prefixfree.min.js"></script>
    </body>
</html>
