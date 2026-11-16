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

  $_base_utils->initialize_page_compass("Community");

  $category = "None";

  // "None", "Featured", "Film & Animation", "Autos & Vehicles", "Music", "Pets & Animals", "Sports", "Travel & Events", "Gaming", "People & Blogs", "Comedy", "Entertainment", "News & Politics", "Howto & Style", "Education", "Science & Technology", "Nonprofits & Activism", "Poop-posting"
  //handle category

  if(isset($_GET['c'])) 
      $category = ($_GET['c']);
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
<meta name="keywords" content="programming, youth, children, kids, child, novices, visual programming, animated stories, video games, interactive art, sharing, video, camera, upload, friends, social, online communities, user-generated content, pingusoft, studio, creativity, create, creation, crafts, learning, education, beginners, beginning, easy, learn, draw, fun, program, games, animation, educators, play, playful, digital expression, 21st century skills, participatory media, scratch, scratch mod, scratch modification, wrappertube, wrapper tube, social software, cscw, cscl, art, artwork, paint, painting, editor, drawing, graphics, cartoon, recording, photography, photo, design, penguinmod, turbowarp, html, flash, forum, forums, community, oc, ocs, original character, character, cat, cute, computer, digital, artist, images, world, music, sound, audio, message boards, boards, board, message board, interactive, sweet, movie, flash games, dream, dream studio, dreamstudio, blog, bbs, vector, director, directors, network, online, gamedev, 3d"/>
<meta name="theme-color" content="red">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
<meta property="og:title" content="WrapperTube - <?php echo $_base_utils->return_current_page(); ?>" />
<meta property="og:url" content="http://wrappertube.org/" />
<meta property="og:description" content="WrapperTube is a site where you can upload your videos, animations, Scratch Projects, Artwork, music, and anything." />
<meta property="og:image" content="/yt/imgbin/full-size-logo.png" />
        <script src="/static/js/core-js.js"></script>
<link rel="alternate" type="application/atom+xml" title="Latest topics" href="/feed/forum_category?c=All">
<link rel="alternate" type="application/atom+xml" title="Latest replies" href="/feed/forum_category_replies?c=All">
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
<form method="get" action="/search_groups">
<input type="text" placeholder="Search Groups" name="q" style="width:85%;">
<input type="submit" value="Search" class="www-button www-button-grey">
</form><br>
            <div style="margin-left: 176px;">
            <h1>Community / Groups</h1>
            <span style="font-size: 11px;" class="grey-text">Find groups with the same interests as yours.</span><br><br>
            </div>
            <div style="overflow:auto;position: relative;height: 415px;bottom: 53px;">
                <div class="www-videos-left">
                    <h2>Groups</h2><br>
                    <ul class="videos-list">
                    <?php $categories = ["None", "Featured", "Film & Animation", "Autos & Vehicles", "Music", "Pets & Animals", "Sports", "Travel & Events", "Gaming", "People & Blogs", "Comedy", "Entertainment", "News & Politics", "Howto & Style", "Education", "Science & Technology", "Nonprofits & Activism", "Poop-posting"]; ?>
                        <?php foreach($categories as $categoryTag) { ?>
                            <?php if($categoryTag == $category) { ?>
                                <li class=""><?php echo $categoryTag; ?></li>
                            <?php } else { ?>
                                <li class=""><a href="/community?c=<?php echo urlencode($categoryTag); ?>"><?php echo $categoryTag; ?></a></li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </div>
                <div class="www-videos-right" style="position: relative;top: 46px;">
                    <h3><?php echo htmlspecialchars($category); ?></h3>
                    <div class="videos-box">
                        <div class="videos-title-box-browse">
                        
                        </div>
                        <div class="videos-title-box-contents">
                            <table style="width: 100%;">
                                <tr>
                                    <!-- <th style="margin: 5px; width: 5%;"></th> -->
                                    <th style="width: 100%;"></th>
                                    <th style="margin: 5px; width: 20%;"></th>
                                </tr>
                                <?php
                                $results_per_page = 5;

                                if($category != "None" && $category != "Featured") { 
                                    $stmt = $conn->prepare("SELECT count(*) FROM user_groups WHERE group_category = ?");
                                    $stmt->bind_param("s", $category);
                                    $stmt->execute();
                                    $stmt->bind_result($number_of_result);
                                    $stmt->fetch();
                                    $stmt->close();
                                } else if ($category == "Featured") {
                                    $stmt = $conn->prepare("SELECT count(*) FROM user_groups WHERE group_featured = 'y'");
                                    $stmt->execute();
                                    $stmt->bind_result($number_of_result);
                                    $stmt->fetch();
                                    $stmt->close();
                                } else {
                                    $stmt = $conn->prepare("SELECT count(*) FROM user_groups");
                                    $stmt->execute();
                                    $stmt->bind_result($number_of_result);
                                    $stmt->fetch();
                                    $stmt->close();
                                }

                                $number_of_page = ceil ($number_of_result / $results_per_page);  

                                if (!isset ($_GET['page']) ) {  
                                    $page = 1;  
                                } else {  
                                    $page = (int)$_GET['page'];  
                                }  

                                $page_first_result = ($page - 1) * $results_per_page;  

                                $stmt->close();

                                if($category != "None" && $category != "Featured") { 
                                    $stmt = $conn->prepare("SELECT * FROM user_groups WHERE group_category = ? ORDER BY id DESC LIMIT ?, ?");
                                    $stmt->bind_param("sss", $category, $page_first_result, $results_per_page);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                } else if ($category == "Featured") {
                                    $stmt = $conn->prepare("SELECT * FROM user_groups WHERE group_featured = 'y' ORDER BY id DESC LIMIT ?, ?");
                                    $stmt->bind_param("ss", $page_first_result, $results_per_page);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                } else {
                                    $stmt = $conn->prepare("SELECT * FROM user_groups ORDER BY id DESC LIMIT ?, ?");
                                    $stmt->bind_param("ss", $page_first_result, $results_per_page);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                }

                                while($group = $result->fetch_assoc()) { ?>
                                <tr style="margin-top: 5px;" id="videoslist">
                                    <td class="video-manager-left">
                                        <img src="/dynamic/thumbs/<?php echo $group['group_picture']; ?>" style="width:50px;height:50px;">
                                        <span style="display: inline-block;float: right;"></span>
                                    </div>
                                        <span class="video-manager-info" style="width: 93%;">
                                        <a class="video-manager-title" href="/group/<?php echo $group['id']; ?>"><?php echo htmlspecialchars($group['group_title']); ?></a>
                                        <span style="font-size: 11px;" class="grey-text"> - <?php echo $_video_fetch_utils->parseDescriptionVideoManager($group['group_description']); ?></span>
                                        <span class="grey-text" style="font-size:11px;float:right;">[<?php echo htmlspecialchars($group['group_author']); ?>] [<?php echo $_user_fetch_utils->fetch_group_member_count($group['id']); ?> members] [<?php echo $_user_fetch_utils->fetch_group_video_count($group['id']); ?> videos] [<?php echo $_user_fetch_utils->fetch_group_playlist_count($group['id']); ?> playlists]</span>
                                        <br>
                                        <span style="color: #919191;"><?php echo date("F d, Y g:sA", strtotime($group['group_creation'])); ?></span><br>
                                        <br>         
                                    </td>
                                </tr>
                            <?php } $stmt->close(); ?>
                            </table>
                        </div>
                    </div>

                    <center>
                  <?php
                                                                                                                if (!isset ($_GET['page']) ) {
                                                                                                                        $curpage = 1;
                                                                                                                } else {
                                                                                                                        $curpage = (int)$_GET['page'];
                                                                                                                }
?>
<?php if ($curpage > 1) { ?>
<a href="community?c=<?php echo urlencode($category); ?>&page=<?php echo $curpage - 1; ?>">Prev</a>&nbsp;
<?php } ?>
<?php for($page = 1; $page<= $number_of_page; $page++) { ?>
<?php if($curpage==$page){ ?>
<b><?php echo $page; ?></b>&nbsp;
<?php } else { ?>
<a href="community?c=<?php echo urlencode($category); ?>&page=<?php echo $page; ?>"><?php echo $page; ?></a>&nbsp;
<?php } ?>
                  <?php } ?>
<?php if ($curpage < $number_of_page) { ?>
<a href="community?c=<?php echo urlencode($category); ?>&page=<?php echo $curpage + 1; ?>">Next</a>&nbsp;
<?php } ?>
                    </center>  
                </div>
            </div>
<form method="get" action="/forum/search">
<input type="text" placeholder="Search Forum Threads" name="q" style="width:60%;">
<input type="text" placeholder="Search Author" name="user" style="width:25%;">
<input type="submit" value="Search" class="www-button www-button-grey">
</form><br>
            <div style="width: 794px;float: right;">
                <hr class="thin-line">
                <h1>Community / Forums <a href="/feed/forum_category?c=All" title="Latest topics"><img src="/static/img/feed-icon-small.png" alt="feed icon" width="14" height="14"></a></h1>
                <span style="font-size: 11px;" class="grey-text">Talk to other users here.</span>
                <?php
                    $stmt87 = $conn->prepare("SELECT * FROM forum_section WHERE staffonlyviewing = 'n'");
                    $stmt87->execute();
                    $result87 = $stmt87->get_result();
                    while($section = $result87->fetch_assoc()) {
                        $stmt = $conn->prepare("SELECT * FROM forum_category WHERE staffonlyviewing = 'n' AND section = ?");
                        $stmt->bind_param("s", $section['title']);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row_count = $result->num_rows;
                        if ($row_count == 0) {
                            continue;
                        }
                ?>
                <hr class="thin-line">
                <a name="<?php echo urlencode($section['title']); ?>"></a>
                <h3><a style="display: inline-block;color:black;" href="#<?php echo urlencode($section['title']); ?>"><?php echo htmlspecialchars($section['title']); ?></a></h3>
                <?php
                        while($category = $result->fetch_assoc()) {
                            $latest_forum_post = $_user_fetch_utils->fetch_latest_forum_post($category['title']);
                            $latest_forum_poster = htmlspecialchars($latest_forum_post['author']);
                ?>
                    <hr class="thin-line">
                    <h3 class="h3title" style="display: inline-block;"><a href="/forum/category?c=<?php echo urlencode($category['title']); ?>"><?php echo htmlspecialchars($category['title']); ?></a></h3>
                    <span style="font-size: 11px; color: gray;">(<?php echo $_video_fetch_utils->get_category_threads($category['title']); ?> threads)<?php if($latest_forum_post) { ?> last post <?php echo date("M d, Y", strtotime($latest_forum_post['date'])); ?><?php } ?></span>
                    <br>
                    <?php echo htmlspecialchars($category['description']); ?><br><br>
<?php if($latest_forum_post) { ?>
                    <a href="/forum/thread?v=<?php echo $latest_forum_post['id']; ?>"><h4 <?php if ($latest_forum_post['open'] == "n" || $latest_forum_post['adminopen'] == "n") { ?>style="text-decoration:line-through;color:grey;"<?php } ?>><?php if ($latest_forum_post['adminopen'] == "n") { ?><img src="/static/img/archive.png" width="16" height="16"> <?php } ?><?php if ($latest_forum_post['sticky'] == "y") { ?><img src="/static/img/sticky.png" width="16" height="16"> Sticky: <?php } ?><?php echo htmlspecialchars($latest_forum_post['title']); ?></h4></a>
                    <div class="comment-watch" style="width:100%;">
                        <a href="/user/<?php echo $latest_forum_poster; ?>">
                        <img class="comment-pfp" src="/dynamic/pfp/<?php echo $_user_fetch_utils->fetch_user_pfp($latest_forum_post['author']); ?>">
                        </a>
                        <span  style="display: inline-block; vertical-align: top;width: 90%;">
                            <span class="comment-info" style="display: inline-block;">
                                <b><a style="text-decoration: none;" href="/user/<?php echo $latest_forum_poster; ?>">
                                    <?php echo htmlspecialchars($latest_forum_post['author']); ?> 
                                </a></b> 
                                <span style="color: #666;">(<?php echo $_video_fetch_utils->time_elapsed_string($latest_forum_post['date']); ?>, last modified <?php echo $_video_fetch_utils->time_elapsed_string($latest_forum_post['last_modified']); ?>)</span>
                            </span><br>
                            <span class="comment-text" style="display: inline-block; width:100% !important;">
                                <?php echo $bbcode->Parse($latest_forum_post['contents']); ?>
                            </span>
                        </span>

                    </div>
<?php } ?>
                <?php } } $stmt87->close(); ?>
            </div>
            <div style="width: 794px;float: right;">
            <br><a href="/forum/search?q=">Overboard</a></br>
            </div>
            <?php if (isset($_SESSION['siteusername'])) { ?>
            <div style="width: 794px;float: right;">
            <br><a href="/forum/signature">Change your signature</a></br>
            </div>
            <?php } ?>
        </div>
        <div class="www-core-container">
        <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/module/footer.php"); ?>
        </div>
        <script src="/static/js/prefixfree.min.js"></script>
    </body>
</html>
