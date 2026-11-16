<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php"); ?>
<?php
// better search page. wow, lots of code.
  $_user_fetch_utils = new user_fetch_utils();
  $_video_fetch_utils = new video_fetch_utils();
  $_base_utils = new config_setup();
 
  $_base_utils->initialize_db_var($conn);
  $_video_fetch_utils->initialize_db_var($conn);
  $_user_fetch_utils->initialize_db_var($conn);

  $search = "%" . htmlspecialchars($_GET['q']) . "%";

  $switches = '';

  if (isset($_GET['lclk']))
      $switches = $switches . '&lclk=' . $_GET['lclk'];

  if (isset($_GET['where']))
      $switches = $switches . '&where=' . $_GET['where'];

  $_base_utils->initialize_page_compass(htmlspecialchars($_GET['q']));
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
<meta name="description" content="WrapperTube is a site where you can upload your videos, animations, Scratch Projects, Artwork, music, and anything.">
<meta name="theme-color" content="red">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
<meta property="og:title" content="WrapperTube - <?php echo $_base_utils->return_current_page(); ?>" />
<meta property="og:url" content="http://wrappertube.org/" />
<meta property="og:description" content="WrapperTube is a site where you can upload your videos, animations, Scratch Projects, Artwork, music, and anything." />
<meta property="og:image" content="/yt/imgbin/full-size-logo.png" />
        <script src="/static/js/core-js.js"></script>
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
<link rel="stylesheet" href="/static/css/bbcode.css?v2">
    </head>
    <body>
        <div class="www-core-container">
            <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/module/header.php"); ?>
            <h1 style="display: inline-block;">Search results for "<?php echo htmlspecialchars($_GET['q']); ?>"</h1> <br>
            <?php
                $results_per_page = ($_GET['where'] == "videos")?24:20;
                $user_per_page = ($_GET['where'] == "members")?24:6;
		$playlist_per_page = ($_GET['where'] == "playlists")?24:2;

                if(!isset($_GET['lclk'])) { 
if (!isset($_GET['where']) || $_GET['where'] == "videos") {
                    $stmt = $conn->prepare("SELECT count(*) FROM videos WHERE (lower(title) LIKE lower(?) OR lower(tags) LIKE lower(?) OR lower(description) LIKE lower(?)) AND visibility = 'n'");
                    $stmt->bind_param("sss", $search, $search, $search);
                    $stmt->execute();
                    $stmt->bind_result($results);
                    $stmt->fetch();
                    $stmt->close();
}
if (!isset($_GET['where']) || $_GET['where'] == "members") {
                $stmt = $conn->prepare("SELECT count(*) FROM users WHERE (lower(username) LIKE lower(?) OR lower(bio) LIKE lower(?))");
                $stmt->bind_param("ss", $search, $search);
                $stmt->execute();
                $stmt->bind_result($results2);
                $stmt->fetch();
                $stmt->close();
}
if (!isset($_GET['where']) || $_GET['where'] == "playlists") {
                    $stmt = $conn->prepare("SELECT count(*) FROM playlists WHERE (lower(title) LIKE lower(?) OR lower(description) LIKE lower(?)) AND visibility = 'n'");
                    $stmt->bind_param("ss", $search, $search);
                    $stmt->execute();
                    $stmt->bind_result($results3);
                    $stmt->fetch();
                    $stmt->close();
}
                } else {
                    if($_GET['lclk'] == "featured") { 
if (!isset($_GET['where']) || $_GET['where'] == "videos") {
                        $stmt = $conn->prepare("SELECT count(*) FROM videos WHERE featured = 'v' AND visibility = 'n'");
                        $stmt->execute();
                        $stmt->bind_result($results);
                        $stmt->fetch();
                        $stmt->close();
}
                    } else if($_GET['lclk'] == "featured_search") {
if (!isset($_GET['where']) || $_GET['where'] == "videos") {
                        $stmt = $conn->prepare("SELECT count(*) FROM videos WHERE `featured` = 'v' AND (lower(title) LIKE lower(?) OR lower(tags) LIKE lower(?) OR lower(description) LIKE lower(?)) AND visibility = 'n'");
                        $stmt->bind_param("sss", $search, $search, $search);
                        $stmt->execute();
                        $stmt->bind_result($results);
                        $stmt->fetch();
                        $stmt->close();
}
                    } else if($_GET['lclk'] == "this_month") {
if (!isset($_GET['where']) || $_GET['where'] == "videos") {
                        $stmt = $conn->prepare("SELECT count(*) FROM videos WHERE `publish` >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND (lower(title) LIKE lower(?) OR lower(tags) LIKE lower(?) OR lower(description) LIKE lower(?)) AND visibility = 'n'");
                        $stmt->bind_param("sss", $search, $search, $search);
                        $stmt->execute();
                        $stmt->bind_result($results);
                        $stmt->fetch();
                        $stmt->close();
}
if (!isset($_GET['where']) || $_GET['where'] == "members") {
                $stmt = $conn->prepare("SELECT count(*) FROM users WHERE `created` >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND (lower(username) LIKE lower(?) OR lower(bio) LIKE lower(?))");
                $stmt->bind_param("ss", $search, $search);
                $stmt->execute();
                $stmt->bind_result($results2);
                $stmt->fetch();
                $stmt->close();
}
if (!isset($_GET['where']) || $_GET['where'] == "playlists") {
                        $stmt = $conn->prepare("SELECT count(*) FROM playlists WHERE `created` >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND (lower(title) LIKE lower(?) OR lower(description) LIKE lower(?)) AND visibility = 'n'");
                        $stmt->bind_param("ss", $search, $search);
                        $stmt->execute();
                        $stmt->bind_result($results3);
                        $stmt->fetch();
                        $stmt->close();
}
                    } else if($_GET['lclk'] == "this_week") {
if (!isset($_GET['where']) || $_GET['where'] == "videos") {
                        $stmt = $conn->prepare("SELECT count(*) FROM videos WHERE `publish` >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND (lower(title) LIKE lower(?) OR lower(tags) LIKE lower(?) OR lower(description) LIKE lower(?)) AND visibility = 'n'");
                        $stmt->bind_param("sss", $search, $search, $search);
                        $stmt->execute();
                        $stmt->bind_result($results);
                        $stmt->fetch();
                        $stmt->close();
}
if (!isset($_GET['where']) || $_GET['where'] == "members") {
                $stmt = $conn->prepare("SELECT count(*) FROM users WHERE `created` >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND (lower(username) LIKE lower(?) OR lower(bio) LIKE lower(?))");
                $stmt->bind_param("ss", $search, $search);
                $stmt->execute();
                $stmt->bind_result($results2);
                $stmt->fetch();
                $stmt->close();
}
if (!isset($_GET['where']) || $_GET['where'] == "playlists") {
                        $stmt = $conn->prepare("SELECT count(*) FROM playlists WHERE `created` >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND (lower(title) LIKE lower(?) OR lower(description) LIKE lower(?)) AND visibility = 'n'");
                        $stmt->bind_param("ss", $search, $search);
                        $stmt->execute();
                        $stmt->bind_result($results3);
                        $stmt->fetch();
                        $stmt->close();
}
                    } else if($_GET['lclk'] == "today") {
if (!isset($_GET['where']) || $_GET['where'] == "videos") {
                        $stmt = $conn->prepare("SELECT count(*) FROM videos WHERE `publish` >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND (lower(title) LIKE lower(?) OR lower(tags) LIKE lower(?) OR lower(description) LIKE lower(?)) AND visibility = 'n'");
                        $stmt->bind_param("sss", $search, $search, $search);
                        $stmt->execute();
                        $stmt->bind_result($results);
                        $stmt->fetch();
                        $stmt->close();
}
if (!isset($_GET['where']) || $_GET['where'] == "members") {
                $stmt = $conn->prepare("SELECT count(*) FROM users WHERE `created` >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND (lower(username) LIKE lower(?) OR lower(bio) LIKE lower(?))");
                $stmt->bind_param("ss", $search, $search);
                $stmt->execute();
                $stmt->bind_result($results2);
                $stmt->fetch();
                $stmt->close();
}
if (!isset($_GET['where']) || $_GET['where'] == "playlists") {
                        $stmt = $conn->prepare("SELECT count(*) FROM playlists WHERE `created` >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND (lower(title) LIKE lower(?) OR lower(description) LIKE lower(?)) AND visibility = 'n'");
                        $stmt->bind_param("ss", $search, $search);
                        $stmt->execute();
                        $stmt->bind_result($results3);
                        $stmt->fetch();
                        $stmt->close();
}
                    }
                }

if (!isset($_GET['where']) || $_GET['where'] == "videos") {
                $number_of_result = $results;
                $number_of_page = ceil ($number_of_result / $results_per_page);  
}

if (!isset($_GET['where']) || $_GET['where'] == "members") {
		$number_of_user_result = $results2;
                $number_of_user_page = ceil ($number_of_user_result / $user_per_page);
}

if (!isset($_GET['where']) || $_GET['where'] == "playlists") {
                $number_of_playlist_result = $results3;
                $number_of_playlist_page = ceil ($number_of_playlist_result / $playlist_per_page);
}

                $total_number_of_result = $number_of_result + $number_of_user_result + $number_of_playlist_result;
	    ?>
            <?php if (isset($_GET['where'])) { ?><a href="/search_query?q=<?php echo urlencode($_GET['q']); ?><?php if(isset($_GET['lclk'])){ ?>&lclk=<?php echo $_GET['lclk']; } ?>">All</a><?php } else { ?><b>All</b><?php } ?> &bull;
            <?php if ($_GET['where'] != 'videos') { ?><a href="/search_query?q=<?php echo urlencode($_GET['q']); ?><?php if(isset($_GET['lclk'])){ ?>&lclk=<?php echo $_GET['lclk']; } ?>&where=videos">Videos</a><?php } else { ?><b>Videos</b><?php } ?> &bull; 
            <?php if ($_GET['where'] != 'members') { ?><a href="/search_query?q=<?php echo urlencode($_GET['q']); ?><?php if(isset($_GET['lclk'])){ ?>&lclk=<?php echo $_GET['lclk']; } ?>&where=members">Members</a><?php } else { ?><b>Members</b><?php } ?> &bull; 
            <?php if ($_GET['where'] != 'playlists') { ?><a href="/search_query?q=<?php echo urlencode($_GET['q']); ?><?php if(isset($_GET['lclk'])){ ?>&lclk=<?php echo $_GET['lclk']; } ?>&where=playlists">Playlists</a><?php } else { ?><b>Playlists</b><?php } ?>
            <span style="float: right;">
            <?php if (isset($_GET['lclk'])) { ?><a href="/search_query?q=<?php echo urlencode($_GET['q']); ?><?php if(isset($_GET['where'])){ ?>&where=<?php echo $_GET['where']; } ?>">All Time</a><?php } else { ?><b>All Time</b><?php } ?> &bull;
            <?php if ($_GET['lclk'] != 'this_week') { ?><a href="/search_query?q=<?php echo urlencode($_GET['q']); ?>&lclk=this_week<?php if(isset($_GET['where'])){ ?>&where=<?php echo $_GET['where']; } ?>">This Week</a><?php } else { ?><b>This Week</b><?php } ?> &bull; 
            <?php if ($_GET['lclk'] != 'this_month') { ?><a href="/search_query?q=<?php echo urlencode($_GET['q']); ?>&lclk=this_month<?php if(isset($_GET['where'])){ ?>&where=<?php echo $_GET['where']; } ?>">This Month</a><?php } else { ?><b>This Month</b><?php } ?> &bull; 
            <?php if ($_GET['lclk'] != 'today') { ?><a href="/search_query?q=<?php echo urlencode($_GET['q']); ?>&lclk=today<?php if(isset($_GET['where'])){ ?>&where=<?php echo $_GET['where']; } ?>">Today</a><?php } else { ?><b>Today</b><?php } ?> &bull;
            <?php if ($_GET['lclk'] != 'featured_search' && $_GET['lclk'] != 'featured') { ?><a href="/search_query?q=<?php echo urlencode($_GET['q']); ?>&lclk=featured_search<?php if(isset($_GET['where'])){ ?>&where=<?php echo $_GET['where']; } ?>">Featured</a><?php } else { ?><b>Featured</b><?php } ?>
            </span><br>
            About <strong><?php echo number_format($total_number_of_result); ?></strong> results<br><br>
	    <?php
		$number_of_page = max($number_of_page, $number_of_user_page, $number_of_playlist_page);

                if (!isset ($_GET['page']) ) {  
                    $page = 1;  
                } else {  
                    $page = (int)$_GET['page'];  
                }  

                $page_first_result = ($page - 1) * $results_per_page;  
                $user_page_first_result = ($page - 1) * $user_per_page;
                $playlist_page_first_result = ($page - 1) * $playlist_per_page;

                $stmt->close();

                if(!isset($_GET['lclk'])) { 
if (!isset($_GET['where']) || $_GET['where'] == "videos") {
                    $stmt6 = $conn->prepare("SELECT * FROM videos WHERE (lower(title) LIKE lower(?) OR lower(tags) LIKE lower(?) OR lower(description) LIKE lower(?)) AND visibility = 'n' ORDER BY id DESC LIMIT ?, ?");
                    $stmt6->bind_param("sssss", $search, $search, $search, $page_first_result, $results_per_page);
                    $stmt6->execute();
                    $result6 = $stmt6->get_result();
}
if (!isset($_GET['where']) || $_GET['where'] == "members") {
                $stmt69 = $conn->prepare("SELECT pfp, username FROM users WHERE (lower(username) LIKE lower(?) OR lower(bio) LIKE lower(?)) ORDER BY id DESC LIMIT ?, ?");
                $stmt69->bind_param("ssss", $search, $search, $user_page_first_result, $user_per_page);
                $stmt69->execute();
                $result69 = $stmt69->get_result();
}
if (!isset($_GET['where']) || $_GET['where'] == "playlists") {
                    $stmt4 = $conn->prepare("SELECT * FROM playlists WHERE (lower(title) LIKE lower(?) OR lower(description) LIKE lower(?)) AND visibility = 'n' ORDER BY id DESC LIMIT ?, ?");
                    $stmt4->bind_param("ssss", $search, $search, $playlist_page_first_result, $playlist_per_page);
                    $stmt4->execute();
                    $result4 = $stmt4->get_result();
}
                } else {
                    if($_GET['lclk'] == "featured") { 
if (!isset($_GET['where']) || $_GET['where'] == "videos") {
                        $stmt6 = $conn->prepare("SELECT * FROM videos WHERE featured = 'v' AND visibility = 'n' ORDER BY id DESC LIMIT ?, ?");
                        $stmt6->bind_param("ss", $page_first_result, $results_per_page);
                        $stmt6->execute();
                        $result6 = $stmt6->get_result();
}
                    } else if($_GET['lclk'] == "this_month") {
if (!isset($_GET['where']) || $_GET['where'] == "videos") {
                        $stmt6 = $conn->prepare("SELECT * FROM videos WHERE `publish` >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND (lower(title) LIKE lower(?) OR lower(tags) LIKE lower(?) OR lower(description) LIKE lower(?)) AND visibility = 'n' ORDER BY id DESC LIMIT ?, ?");
                        $stmt6->bind_param("sssss", $search, $search, $search, $page_first_result, $results_per_page);
                        $stmt6->execute();
                        $result6 = $stmt6->get_result();
}
if (!isset($_GET['where']) || $_GET['where'] == "members") {
                $stmt69 = $conn->prepare("SELECT pfp, username FROM users WHERE `created` >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND (lower(username) LIKE lower(?) OR lower(bio) LIKE lower(?)) ORDER BY id DESC LIMIT ?, ?");
                $stmt69->bind_param("ssss", $search, $search, $user_page_first_result, $user_per_page);
                $stmt69->execute();
                $result69 = $stmt69->get_result();
}
if (!isset($_GET['where']) || $_GET['where'] == "playlists") {
                        $stmt4 = $conn->prepare("SELECT * FROM playlists WHERE `created` >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND (lower(title) LIKE lower(?) OR lower(description) LIKE lower(?)) AND visibility = 'n' ORDER BY id DESC LIMIT ?, ?");
                        $stmt4->bind_param("ssss", $search, $search, $playlist_page_first_result, $playlist_per_page);
                        $stmt4->execute();
                        $result4 = $stmt4->get_result();
}
                    } else if($_GET['lclk'] == "featured_search") {
if (!isset($_GET['where']) || $_GET['where'] == "videos") {
                        $stmt6 = $conn->prepare("SELECT * FROM videos WHERE `featured` = 'v' AND (lower(title) LIKE lower(?) OR lower(tags) LIKE lower(?) OR lower(description) LIKE lower(?)) AND visibility = 'n' ORDER BY id DESC LIMIT ?, ?");
                        $stmt6->bind_param("sssss", $search, $search, $search, $page_first_result, $results_per_page);
                        $stmt6->execute();
                        $result6 = $stmt6->get_result();
}
                    } else if($_GET['lclk'] == "this_week") {
if (!isset($_GET['where']) || $_GET['where'] == "videos") {
                        $stmt6 = $conn->prepare("SELECT * FROM videos WHERE `publish` >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND (lower(title) LIKE lower(?) OR lower(tags) LIKE lower(?) OR lower(description) LIKE lower(?)) AND visibility = 'n' ORDER BY id DESC LIMIT ?, ?");
                        $stmt6->bind_param("sssss", $search, $search, $search, $page_first_result, $results_per_page);
                        $stmt6->execute();
                        $result6 = $stmt6->get_result();
}
if (!isset($_GET['where']) || $_GET['where'] == "members") {
                $stmt69 = $conn->prepare("SELECT pfp, username FROM users WHERE `created` >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND (lower(username) LIKE lower(?) OR lower(bio) LIKE lower(?)) ORDER BY id DESC LIMIT ?, ?");
                $stmt69->bind_param("ssss", $search, $search, $user_page_first_result, $user_per_page);
                $stmt69->execute();
                $result69 = $stmt69->get_result();
}
if (!isset($_GET['where']) || $_GET['where'] == "playlists") {
                        $stmt4 = $conn->prepare("SELECT * FROM playlists WHERE `created` >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND (lower(title) LIKE lower(?) OR lower(description) LIKE lower(?)) AND visibility = 'n' ORDER BY id DESC LIMIT ?, ?");
                        $stmt4->bind_param("ssss", $search, $search, $playlist_page_first_result, $playlist_per_page);
                        $stmt4->execute();
                        $result4 = $stmt4->get_result();
}
                    } else if($_GET['lclk'] == "today") {
if (!isset($_GET['where']) || $_GET['where'] == "videos") {
                        $stmt6 = $conn->prepare("SELECT * FROM videos WHERE `publish` >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND (lower(title) LIKE lower(?) OR lower(tags) LIKE lower(?) OR lower(description) LIKE lower(?)) AND visibility = 'n' ORDER BY id DESC LIMIT ?, ?");
                        $stmt6->bind_param("sssss", $search, $search, $search, $page_first_result, $results_per_page);
                        $stmt6->execute();
                        $result6 = $stmt6->get_result();
}
if (!isset($_GET['where']) || $_GET['where'] == "members") {
                $stmt69 = $conn->prepare("SELECT pfp, username FROM users WHERE `created` >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND (lower(username) LIKE lower(?) OR lower(bio) LIKE lower(?)) ORDER BY id DESC LIMIT ?, ?");
                $stmt69->bind_param("ssss", $search, $search, $user_page_first_result, $user_per_page);
                $stmt69->execute();
                $result69 = $stmt69->get_result();
}
if (!isset($_GET['where']) || $_GET['where'] == "playlists") {
                        $stmt4 = $conn->prepare("SELECT * FROM playlists WHERE `created` >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND (lower(title) LIKE lower(?) OR lower(description) LIKE lower(?)) AND visibility = 'n' ORDER BY id DESC LIMIT ?, ?");
                        $stmt4->bind_param("ssss", $search, $search, $playlist_page_first_result, $playlist_per_page);
                        $stmt4->execute();
                        $result4 = $stmt4->get_result();
}
                    }
                }

if ($_GET['lclk'] != "featured" && $_GET['lclk'] != "featured_search" && (!isset($_GET['where']) || $_GET['where'] == "members") ) {
                while($user = $result69->fetch_assoc()) { ?>
                    <div class="grid-item" style="animation: scale-up-recent 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;">
                        <img class="channel-pfp" src="/dynamic/pfp/<?php echo $user['pfp']; ?>"><br>
                        <a style="font-size: 10px;text-decoration: none;" href="/user/<?php echo htmlspecialchars($user['username']); ?>"><?php echo htmlspecialchars($user['username']); ?></a>
                    </div>
                <?php
                } $stmt69->close();
}

if ($_GET['lclk'] != "featured" && $_GET['lclk'] != "featured_search" && (!isset($_GET['where']) || $_GET['where'] == "playlists") ) {
                while($video = $result4->fetch_assoc()) { 
$playlist_videos = json_decode($video['videos']);
$the_video = $playlist_videos[0];
if ($the_video && $_video_fetch_utils->video_exists($the_video) ) {
$the_video = $_video_fetch_utils->fetch_video_rid($the_video);
$thumb = $the_video['thumbnail'];
} else {
$thumb = "default.jpg";
}
                    ?>
                     <div class="video-item">
                    <div class="thumbnail" style="
                        background-image: url(/dynamic/thumbs/<?php echo $thumb; ?>), url('/dynamic/thumbs/default.png');"><span class="timestamp"><?php echo count($playlist_videos); ?> videos</span></div>
                    
                    <div class="video-info">
                        <a href="/view_playlist?v=<?php echo $video['rid']; ?>"><b><?php echo htmlspecialchars($video['title']); ?></b></a><br>
                        <?php echo $_video_fetch_utils->parseTextNoLink($video['description']); ?><br>
                        <span class="video-info-small-wide">
                            <span class="video-views"><?php echo date("M d, Y", strtotime($video['created'])); ?></span>
                            <a class="video-author-wide" href="/user/<?php echo htmlspecialchars($video['author']); ?>"><?php echo htmlspecialchars($video['author']); ?></a>
                        </span>
                    </div>
                    
                <?php } $stmt4->close();
                 }

if (!isset($_GET['where']) || $_GET['where'] == "videos") {
                while($video = $result6->fetch_assoc()) { 
                            $video['stars'] = $_video_fetch_utils->get_video_stars($video['rid']) + $_video_fetch_utils->get_video_likes($video['rid']) + $_video_fetch_utils->get_video_dislikes($video['rid']);
                            $video['star_1'] = $_video_fetch_utils->get_video_stars_level($video['rid'], 1) + $_video_fetch_utils->get_video_dislikes($video['rid']);
                            $video['star_2'] = $_video_fetch_utils->get_video_stars_level($video['rid'], 2);
                            $video['star_3'] = $_video_fetch_utils->get_video_stars_level($video['rid'], 3);
                            $video['star_4'] = $_video_fetch_utils->get_video_stars_level($video['rid'], 4);
                            $video['star_5'] = $_video_fetch_utils->get_video_stars_level($video['rid'], 5) + $_video_fetch_utils->get_video_likes($video['rid']);
                    //@$video['star_ratio'] = ($video['star_1'] + $video['star_2'] + $video['star_3'] + $video['star_4'] + $video['star_5']) / $video['stars'];
                
                    /* 
                        5 star - 252
                        4 star - 124
                        3 star - 40
                        2 star - 29
                        1 star - 33
                
                        totally 478 
                
                        (252*5 + 124*4 + 40*3 + 29*2 + 33*1) / (252 + 124 + 40 + 29 + 33)
                    */
                
                    if($video['stars'] != 0) {
                        @$video['star_ratio'] = (
                            $video['star_5'] * 5 + 
                            $video['star_4'] * 4 + 
                            $video['star_3'] * 3 + 
                            $video['star_2'] * 2 + 
                            $video['star_1'] * 1
                        ) / (
                            $video['star_5'] + 
                            $video['star_4'] + 
                            $video['star_3'] + 
                            $video['star_2'] + 
                            $video['star_1']
                        );
                
                        $video['star_ratio'] = floor($video['star_ratio'] * 2) / 2;
                    } else { 
                        $video['star_ratio'] = 0;
                    }
                    ?>
                     <div class="video-item">
                    <div class="thumbnail" style="
                        background-image: url(/dynamic/thumbs/<?php echo $video['thumbnail']; ?>), url('/dynamic/thumbs/default.png');"><span class="timestamp"><?php echo $_video_fetch_utils->timestamp($video['duration']); ?></span></div>
                    
                    <div class="video-info">
                        <a href="/watch?v=<?php echo $video['rid']; ?>"><b><?php echo htmlspecialchars($video['title']); ?></b></a><br>
                        <?php echo $_video_fetch_utils->parseTextNoLink($video['description']); ?><br>
                        <span class="video-info-small-wide">
                            <span class="stars-watch">
<img src="/static/img/<?php echo ($video['star_ratio']>=1)?'full':(($video['star_ratio']>=0.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($video['star_ratio']>=2)?'full':(($video['star_ratio']>=1.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($video['star_ratio']>=3)?'full':(($video['star_ratio']>=2.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($video['star_ratio']>=4)?'full':(($video['star_ratio']>=3.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($video['star_ratio']>=5)?'full':(($video['star_ratio']>=4.5)?'half':'empty'); ?>_star_s.png">
                            </span>
                            <span style="padding-left: 13px;" class="video-views"><?php echo $_video_fetch_utils->fetch_video_views($video['rid']); ?> views</span>
                            <a class="video-author-wide" href="/user/<?php echo htmlspecialchars($video['author']); ?>"><?php echo htmlspecialchars($video['author']); ?></a>
                        </span>
                    </div>
                    
                <?php } $stmt6->close();
                 } ?>
            	</div>
                  <?php
                                                                                                                if (!isset ($_GET['page']) ) {
                                                                                                                        $curpage = 1;
                                                                                                                } else {
                                                                                                                        $curpage = (int)$_GET['page'];
                                                                                                                }
?>
<?php if ($curpage > 1) { ?>
<a href="search_query?q=<?php echo urlencode($_GET['q']); ?><?php echo $switches; ?>&page=<?php echo $curpage - 1; ?>">Prev</a>&nbsp;
<?php } ?>
<?php for($page = 1; $page<= $number_of_page; $page++) { ?>
<?php if($curpage==$page){ ?>
<b><?php echo $page; ?></b>&nbsp;
<?php } else { ?>
<a href="search_query?q=<?php echo urlencode($_GET['q']); ?><?php echo $switches; ?>&page=<?php echo $page; ?>"><?php echo $page; ?></a>&nbsp;
<?php } ?>
                  <?php } ?>
<?php if ($curpage < $number_of_page) { ?>
<a href="search_query?q=<?php echo urlencode($_GET['q']); ?><?php echo $switches; ?>&page=<?php echo $curpage + 1; ?>">Next</a>&nbsp;
<?php } ?>
        </div>
        <div class="www-core-container">
        <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/module/footer.php"); ?>
        </div>
        <script src="/static/js/prefixfree.min.js"></script>
    </body>
</html>
