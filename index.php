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

  $_base_utils->initialize_page_compass("Homepage");
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
<meta name="google-site-verification" content="5e9T3QuRm1XO01UMYtq0pJVBMRw9m_a8YzRRFfDXc1Q" />
<meta name="msvalidate.01" content="6762C542C4D15A666FC076A0BA2B48CD" />
<meta name="yandex-verification" content="0839d1fe799b1c09" />
<link rel="alternate" type="application/atom+xml" title="Featured Videos" href="/feed/featured">
<link rel="alternate" type="application/atom+xml" title="Recent Videos" href="/feed/videos">
<?php if (isset($_SESSION['siteusername'])) { ?>
<link rel="alternate" type="application/atom+xml" title="Your Subscriptions RSS Feed" href="/feed/subscriptions">
<?php } ?>
<link rel="alternate" type="application/atom+xml" title="Videos Being Watched Now" href="/feed/being_watched_now">
<link rel="alternate" type="application/atom+xml" title="Popular Today" href="/feed/popular_today">
<link rel="alternate" type="application/atom+xml" title="Latest Blog Posts" href="/feed/forum_category?c=WrapperTube+News">
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
            .recent-video-timestamp {
                display: inline-block;
                position: relative;
                left: 57px;
                bottom: 25px;
                padding: 3px;
                width: 63px;
                background: rgb(255,255,255);
                background: -moz-linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
                background: -webkit-linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
                background: -webkit-gradient(linear, left top, right top, from(rgba(255,255,255,0)), to(rgba(255,255,255,1)));
                background: -webkit-linear-gradient(left, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
                background: -moz-linear-gradient(left, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
                background: -o-linear-gradient(left, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
                background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#ffffff",endColorstr="#ffffff",GradientType=1);
                text-align: right;
                font-weight: bold;
                color: #000;
            }

            .recent-video-thumbnail {
                -webkit-box-shadow: 0px 19px 8px -2px #EBEBEB; 
                -moz-box-shadow: 0px 19px 8px -2px #EBEBEB; 
                     box-shadow: 0px 19px 8px -2px #EBEBEB;
            }

            @-webkit-keyframes expandDong {
                0% {
                    opacity:0;
                    -webkit-transform:  rotate(10deg) scaleX(0) scaleY(0) ;
                            transform:  rotate(10deg) scaleX(0) scaleY(0) ;
                }
                100% {
                    opacity:1;
                    -webkit-transform:  rotate(0deg) scaleX(1) scaleY(1) ;
                            transform:  rotate(0deg) scaleX(1) scaleY(1) ;
                }
            }

            @-moz-keyframes expandDong {
                0% {
                    opacity:0;
                    -moz-transform:  rotate(10deg) scaleX(0) scaleY(0) ;
                         transform:  rotate(10deg) scaleX(0) scaleY(0) ;
                }
                100% {
                    opacity:1;
                    -moz-transform:  rotate(0deg) scaleX(1) scaleY(1) ;
                         transform:  rotate(0deg) scaleX(1) scaleY(1) ;
                }
            }

            @-o-keyframes expandDong {
                0% {
                    opacity:0;
                    -o-transform:  rotate(10deg) scaleX(0) scaleY(0) ;
                       transform:  rotate(10deg) scaleX(0) scaleY(0) ;
                }
                100% {
                    opacity:1;
                    -o-transform:  rotate(0deg) scaleX(1) scaleY(1) ;
                       transform:  rotate(0deg) scaleX(1) scaleY(1) ;
                }
            }

            @keyframes expandDong {
                0% {
                    opacity:0;
                    -webkit-transform:  rotate(10deg) scaleX(0) scaleY(0) ;
                       -moz-transform:  rotate(10deg) scaleX(0) scaleY(0) ;
                         -o-transform:  rotate(10deg) scaleX(0) scaleY(0) ;
                            transform:  rotate(10deg) scaleX(0) scaleY(0) ;
                }
                100% {
                    opacity:1;
                    -webkit-transform:  rotate(0deg) scaleX(1) scaleY(1) ;
                       -moz-transform:  rotate(0deg) scaleX(1) scaleY(1) ;
                         -o-transform:  rotate(0deg) scaleX(1) scaleY(1) ;
                            transform:  rotate(0deg) scaleX(1) scaleY(1) ;
                }
            }

            .recent-view {  
                -webkit-animation: 0.5s ease-out 0s 1 expandDong;  
                   -moz-animation: 0.5s ease-out 0s 1 expandDong;  
                     -o-animation: 0.5s ease-out 0s 1 expandDong;  
                        animation: 0.5s ease-out 0s 1 expandDong;
            }

            .hover-stuff {
                opacity: 1;
                -webkit-transition: 0.1s;
                -o-transition: 0.1s;
                -moz-transition: 0.1s;
                transition: 0.1s;
            }
.welcome-glow {
	font-size: 24px;
  color: #fff;
  -webkit-animation: welcome-glow 1s ease-in-out infinite alternate;
  -moz-animation: welcome-glow 1s ease-in-out infinite alternate;
  -o-animation: welcome-glow 1s ease-in-out infinite alternate;
     animation: welcome-glow 1s ease-in-out infinite alternate;
}
@-webkit-keyframes welcome-glow {
  from {
	            text-shadow: 0 0 4px red,
                         0 0 8px red,
                         0 0 12px red,
                         0 0 16px red,
                         0 0 20px red;
  }
  to {
	            text-shadow: 0 0 8px blue,
                         0 0 12px blue,
                         0 0 16px blue,
                         0 0 20px blue,
                         0 0 24px blue;
  }
}
@-moz-keyframes welcome-glow {
  from {
                    text-shadow: 0 0 4px red,
                         0 0 8px red,
                         0 0 12px red,
                         0 0 16px red,
                         0 0 20px red;
  }
  to {
                    text-shadow: 0 0 8px blue,
                         0 0 12px blue,
                         0 0 16px blue,
                         0 0 20px blue,
                         0 0 24px blue;
  }
}
@-o-keyframes welcome-glow {
  from {
                    text-shadow: 0 0 4px red,
                         0 0 8px red,
                         0 0 12px red,
                         0 0 16px red,
                         0 0 20px red;
  }
  to {
                    text-shadow: 0 0 8px blue,
                         0 0 12px blue,
                         0 0 16px blue,
                         0 0 20px blue,
                         0 0 24px blue;
  }
}
@keyframes welcome-glow {
  from {
                    text-shadow: 0 0 4px red,
                         0 0 8px red,
                         0 0 12px red,
                         0 0 16px red,
                         0 0 20px red;
  }
  to {
                    text-shadow: 0 0 8px blue,
                         0 0 12px blue,
                         0 0 16px blue,
                         0 0 20px blue,
                         0 0 24px blue;
  }
}
        </style>
<style type="text/css">
        .tag-cloud {
            padding: 4px;
            text-align: center;
            line-height: 1.2;
        }
        .tag-cloud a {
            margin: 0 6px;
            color: #0073aa;
            text-decoration: none;
            display: inline-block;
        }
        .tag-cloud a:hover {
            text-decoration: underline;
            color: #005177;
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
        <div class="www-core-container www-frontpage">
            <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/module/header.php"); ?>
            <script src="/static/js/alert.js?v2"></script>
            <p class="welcome-glow">Welcome to WrapperTube, create and share your projects and talk in the forums! ( ´ω`)</p>
            <div class="www-home-left">
                <?php if(isset($_SESSION['siteusername'])) { ?>
                    <h2><a href="/subscriptions_videos" style="color:black;">Subscribed Channels</a> <a href="/feed/subscriptions" title="Your Subscriptions RSS Feed"><img src="/static/img/feed-icon-small.png" alt="feed icon" width="14" height="14"></a></h2><br>
                    <div class="grid-view" style="width: 650px;height: 100%;overflow-y: hidden;overflow-x: scroll;white-space: nowrap;">
                        <?php
                        $stmt = $conn->prepare("SELECT rid, title, thumbnail, duration, title, author, publish, description FROM videos WHERE visibility = 'n' ORDER BY id DESC LIMIT 250");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $i = 0;
                        while($video = $result->fetch_assoc()) { 
                            if($_user_fetch_utils->if_subscribed(@$_SESSION['siteusername'], $video['author'])) { 
                                $i++;
                                if($i <= 12) { 
                        ?>
                        <div class="grid-item" style="-webkit-animation: scale-up-recent 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;-moz-animation: scale-up-recent 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;-o-animation: scale-up-recent 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;animation: scale-up-recent 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;white-space:normal;">
                            <a href="/watch?v=<?php echo $video['rid']; ?>">
                            <img class="thumbnail" onerror="this.src='/dynamic/thumbs/default.png'" src="/dynamic/thumbs/<?php echo htmlspecialchars($video['thumbnail']); ?>">
                            </a>
                            <div class="video-info-grid" style="text-align: center;width: 129px;">
                                <a style="display: inline-block;width: 126px;word-wrap: anywhere;" href="/watch?v=<?php echo $video['rid']; ?>"><?php echo $_video_fetch_utils->parseTitle($video['title']); ?></a><br>
                                <span class="video-info-small">
                                    <a href="/user/<?php echo htmlspecialchars($video['author']); ?>"><?php echo htmlspecialchars($video['author']); ?></a>
                                </span>
                            </div>
                        </div>
                        <?php } } } if($i == 0) { echo "There are no videos from your subscriptions!<br><br>"; } $stmt->close(); ?>
                    </div><br>
                <?php } ?>
                <h2>Videos Being Watched Now</h2><br>
                <div class="grid-view" style="width: 650px;height: 100%;overflow-y: hidden;overflow-x: scroll;white-space: nowrap;">
                    <?php
                    $stmt = $conn->prepare("SELECT videoid FROM views ORDER BY id DESC LIMIT 12");
                    $stmt->execute();
                    $result = $stmt->get_result();
        
                    while($video = $result->fetch_assoc()) { 
                        $video = $_video_fetch_utils->fetch_video_rid($video['videoid']);
                    if ($video['visibility'] != 'n') {
                        continue;
                    }
                    ?> 
                        <div class="grid-item recent-view" style="white-space:normal;">
                            <a href="/watch?v=<?php echo $video['rid']; ?>">
                            <img class="thumbnail recent-video-thumbnail" onerror="this.src='/dynamic/thumbs/default.png'" src="/dynamic/thumbs/<?php echo htmlspecialchars($video['thumbnail']); ?>">
                            <span class="recent-video-timestamp">
                                <?php echo $_video_fetch_utils->timestamp($video['duration']); ?>
                            </span>
                            </a>
                            <div class="video-info-grid hover-stuff" style="position: relative;bottom: 20px;">
                                <a style="display: inline-block;width: 126px;word-wrap: anywhere;" href="/watch?v=<?php echo $video['rid']; ?>"><?php echo $_video_fetch_utils->parseTitle($video['title']); ?></a><br>
                                <span class="video-info-small">
                                    <a href="/user/<?php echo htmlspecialchars($video['author']); ?>"><?php echo htmlspecialchars($video['author']); ?></a>
                                </span>
                            </div>
                        </div>
                    <?php } $stmt->close(); ?>
                </div><br>
                    <h2><a href="/featured" style="color:black;">Featured Videos</a> <a href="/feed/featured" title="Featured Videos"><img src="/static/img/feed-icon-small.png" alt="feed icon" width="14" height="14"></a></h2><br>
                    <div class="grid-view" style="width: 650px;height: 100%;overflow-y: hidden;overflow-x: scroll;white-space: nowrap;">
                        <?php
                        $stmt = $conn->prepare("SELECT rid, title, thumbnail, duration, title, author, publish, description FROM videos WHERE featured = 'v' AND visibility = 'n' ORDER BY id DESC LIMIT 12");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while($video = $result->fetch_assoc()) { 
                        ?>
                        <div class="grid-item" style="-webkit-animation: scale-up-recent 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;-moz-animation: scale-up-recent 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;-o-animation: scale-up-recent 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;animation: scale-up-recent 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;white-space:normal;">
                            <a href="/watch?v=<?php echo $video['rid']; ?>">
                            <img class="thumbnail" onerror="this.src='/dynamic/thumbs/default.png'" src="/dynamic/thumbs/<?php echo htmlspecialchars($video['thumbnail']); ?>">
                            </a>
                            <div class="video-info-grid" style="text-align: center;width: 129px;">
                                <a style="display: inline-block;width: 126px;word-wrap: anywhere;" href="/watch?v=<?php echo $video['rid']; ?>"><?php echo $_video_fetch_utils->parseTitle($video['title']); ?></a><br>
                                <span class="video-info-small">
                                    <a href="/user/<?php echo htmlspecialchars($video['author']); ?>"><?php echo htmlspecialchars($video['author']); ?></a>
                                </span>
                            </div>
                        </div>
                        <?php } $stmt->close(); ?>
                    </div><br>
                    <h2 style="display: inline-block;">Popular <a href="/feed/popular_today" title="Popular Today"><img src="/static/img/feed-icon-small.png" alt="feed icon" width="14" height="14"></a></h2>
                    <h3 class="featured-videos-text"><a href="/popular">See Most Popular Videos</a></h3><br><br>
                    <div class="grid-view" style="width: 650px;height: 100%;overflow-y: hidden;overflow-x: scroll;white-space: nowrap;">
                        <?php
                        $stmt = $conn->prepare("SELECT
                                v.rid,
                                v.title,
                                v.thumbnail,
                                v.duration,
                                v.title,
                                v.author,
                                v.publish,
                                v.description,
                                l.count AS viewcount
                                FROM
                                videos v
                                LEFT JOIN
                                (SELECT videoid, COUNT(*) AS count FROM views GROUP BY videoid)
                                AS l
                                ON v.rid = l.videoid
                                WHERE v.visibility = 'n'
                                AND v.publish >= DATE_SUB(CURDATE(), INTERVAL 1 DAY)
                                ORDER BY viewcount DESC LIMIT 12");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while($video = $result->fetch_assoc()) { 
                        ?>
                        <div class="grid-item" style="-webkit-animation: scale-up-recent 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;-moz-animation: scale-up-recent 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;-o-animation: scale-up-recent 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;animation: scale-up-recent 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;white-space:normal;">
                            <a href="/watch?v=<?php echo $video['rid']; ?>">
                            <img class="thumbnail" onerror="this.src='/dynamic/thumbs/default.png'" src="/dynamic/thumbs/<?php echo htmlspecialchars($video['thumbnail']); ?>">
                            </a>
                            <div class="video-info-grid" style="text-align: center;width: 129px;">
                                <a style="display: inline-block;width: 126px;word-wrap: anywhere;" href="/watch?v=<?php echo $video['rid']; ?>"><?php echo $_video_fetch_utils->parseTitle($video['title']); ?></a><br>
                                <span class="video-info-small">
                                    <a href="/user/<?php echo htmlspecialchars($video['author']); ?>"><?php echo htmlspecialchars($video['author']); ?></a>
                                </span>
                            </div>
                        </div>
                        <?php } $stmt->close(); ?>
                    </div><br>
                    <h2><a href="/recommended" style="color:black;">Suggested Videos</a></h2><br>
                    <div class="grid-view" style="width: 650px;height: 100%;overflow-y: hidden;overflow-x: scroll;white-space: nowrap;">
                        <?php
                        $stmt = $conn->prepare("SELECT rid, title, thumbnail, duration, title, author, publish, description FROM videos WHERE visibility = 'n' ORDER BY rand() LIMIT 12");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while($video = $result->fetch_assoc()) { 
                        ?>
                        <div class="grid-item" style="-webkit-animation: scale-up-recent 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;-moz-animation: scale-up-recent 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;-o-animation: scale-up-recent 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;animation: scale-up-recent 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;white-space:normal;">
                            <a href="/watch?v=<?php echo $video['rid']; ?>">
                            <img class="thumbnail" onerror="this.src='/dynamic/thumbs/default.png'" src="/dynamic/thumbs/<?php echo htmlspecialchars($video['thumbnail']); ?>">
                            </a>
                            <div class="video-info-grid" style="text-align: center;width: 129px;">
                                <a style="display: inline-block;width: 126px;word-wrap: anywhere;" href="/watch?v=<?php echo $video['rid']; ?>"><?php echo $_video_fetch_utils->parseTitle($video['title']); ?></a><br>
                                <span class="video-info-small">
                                    <a href="/user/<?php echo htmlspecialchars($video['author']); ?>"><?php echo htmlspecialchars($video['author']); ?></a>
                                </span>
                            </div>
                        </div>
                        <?php } $stmt->close(); ?>
                    </div><br>
                <hr class="thin-line">
                <h2 style="display: inline-block;"><a href="/recent" style="color:black;">Recent Videos</a> <a href="/feed/videos" title="Recent Videos"><img src="/static/img/feed-icon-small.png" alt="feed icon" width="14" height="14"></a></h2>
                <h3 class="featured-videos-text"><a href="/videos">See More Videos</a></h3>
                <hr class="thin-line">
                <br>
                <?php
                    $stmt = $conn->prepare("SELECT rid, title, thumbnail, duration, title, author, publish, description FROM videos WHERE visibility = 'n' ORDER BY id DESC LIMIT 12");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while($video = $result->fetch_assoc()) { 
                        $video['stars'] = $_video_fetch_utils->get_video_stars($video['rid']);
                        $video['star_1'] = $_video_fetch_utils->get_video_stars_level($video['rid'], 1);
                        $video['star_2'] = $_video_fetch_utils->get_video_stars_level($video['rid'], 2);
                        $video['star_3'] = $_video_fetch_utils->get_video_stars_level($video['rid'], 3);
                        $video['star_4'] = $_video_fetch_utils->get_video_stars_level($video['rid'], 4);
                        $video['star_5'] = $_video_fetch_utils->get_video_stars_level($video['rid'], 5);
                    
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
                    <a href="/watch?v=<?php echo $video['rid']; ?>">
                        <div class="thumbnail" style="
                            background-image: url(/dynamic/thumbs/<?php echo $video['thumbnail']; ?>), url('/dynamic/thumbs/default.png');">
                            <a class="quicklist-add" href="javascript:void(0);" onclick="add_video_to_quicklist('<?php echo $video['rid']; ?>');return false;"></a>
                            
                            <span class="timestamp"><?php echo $_video_fetch_utils->timestamp($video['duration']); ?></span>
                        </div>
                    </a>
                    
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
                    
                </div>
                <?php } $stmt->close(); ?>
            </div>
            <div class="www-home-right">
                <?php 
                    $_featured_vid = $_video_fetch_utils->fetch_rand_featured_vid();

                    if ($_featured_vid):
                ?>
                <?php 
                    $_featured_vid['stars'] = $_video_fetch_utils->get_video_stars($_featured_vid['rid']);
                    $_featured_vid['star_1'] = $_video_fetch_utils->get_video_stars_level($_featured_vid['rid'], 1);
                    $_featured_vid['star_2'] = $_video_fetch_utils->get_video_stars_level($_featured_vid['rid'], 2);
                    $_featured_vid['star_3'] = $_video_fetch_utils->get_video_stars_level($_featured_vid['rid'], 3);
                    $_featured_vid['star_4'] = $_video_fetch_utils->get_video_stars_level($_featured_vid['rid'], 4);
                    $_featured_vid['star_5'] = $_video_fetch_utils->get_video_stars_level($_featured_vid['rid'], 5);

                    //@$_featured_vid['star_ratio'] = ($_featured_vid['star_1'] + $_featured_vid['star_2'] + $_featured_vid['star_3'] + $_featured_vid['star_4'] + $_featured_vid['star_5']) / $_featured_vid['stars'];

                    /* 
                        5 star - 252
                        4 star - 124
                        3 star - 40
                        2 star - 29
                        1 star - 33

                        totally 478 

                        (252*5 + 124*4 + 40*3 + 29*2 + 33*1) / (252 + 124 + 40 + 29 + 33)
                    */

                    if($_featured_vid['stars'] != 0) {
                        @$_featured_vid['star_ratio'] = (
                            $_featured_vid['star_5'] * 5 + 
                            $_featured_vid['star_4'] * 4 + 
                            $_featured_vid['star_3'] * 3 + 
                            $_featured_vid['star_2'] * 2 + 
                            $_featured_vid['star_1'] * 1
                        ) / (
                            $_featured_vid['star_5'] + 
                            $_featured_vid['star_4'] + 
                            $_featured_vid['star_3'] + 
                            $_featured_vid['star_2'] + 
                            $_featured_vid['star_1']
                        );

                        $_featured_vid['star_ratio'] = floor($_featured_vid['star_ratio'] * 2) / 2;
                    } else { 
                        $_featured_vid['star_ratio'] = 0;
                    }
                ?>
                <iframe id="vid-player" style="border: 0px; overflow: hidden;" src="/embed/<?php echo $_featured_vid['rid']; ?>" height="200" width="310"></iframe> <br>
                <h3><a style="color: #000;font-weight;normal;" href="/watch?v=<?php echo htmlspecialchars($_featured_vid['rid']); ?>"><?php echo htmlspecialchars($_featured_vid['title']);  ?></a></h3>
                From: <a href="/user/<?php echo htmlspecialchars($_featured_vid['author']); ?>">
                        <?php echo htmlspecialchars($_featured_vid['author']); ?>
                    </a>
                        | <?php echo date("M d, Y", strtotime($_featured_vid['publish'])); ?> | <?php echo $_video_fetch_utils->fetch_video_views($_featured_vid['rid']); ?> views
                    <br>
                <p style="font-size: 10px;width: 213px;">
                    <?php echo $_video_fetch_utils->parseTextNoLink($_featured_vid['description']); ?>
                </p>
                
                <div style="float:right;background-color: white;padding: 1px;border-radius: 3px;position: relative;bottom: 30px;">
                    <img src="/static/img/<?php echo ($_featured_vid['star_ratio']>=1)?'full':(($_featured_vid['star_ratio']>=0.5)?'half':'empty'); ?>_star.png">
                    <img src="/static/img/<?php echo ($_featured_vid['star_ratio']>=2)?'full':(($_featured_vid['star_ratio']>=1.5)?'half':'empty'); ?>_star.png">
                    <img src="/static/img/<?php echo ($_featured_vid['star_ratio']>=3)?'full':(($_featured_vid['star_ratio']>=2.5)?'half':'empty'); ?>_star.png">
                    <img src="/static/img/<?php echo ($_featured_vid['star_ratio']>=4)?'full':(($_featured_vid['star_ratio']>=3.5)?'half':'empty'); ?>_star.png">
                    <img src="/static/img/<?php echo ($_featured_vid['star_ratio']>=5)?'full':(($_featured_vid['star_ratio']>=4.5)?'half':'empty'); ?>_star.png">
                </div>
                <?php if(!isset($_SESSION['siteusername'])) { ?>
                <div class="benifits-outer-front">
                    <div class="benifits-inner-front">
                        <b>Want to upload videos?</b><br>
                        <a href="/sign_up">Sign up for a WrapperTube Account</a>
                    </div>
                </div><br>
                <?php } else { ?>
                <div class="channel-latest-stats">
                    <h3>Welcome back, <?php echo htmlspecialchars($_SESSION['siteusername']); ?></h3>
                    You have <a href="/inbox"><?php echo $_user_fetch_utils->fetch_unread_pms($_SESSION['siteusername']); ?> new messages!</a><br>
                    You've watched <b><?php echo $_video_fetch_utils->fetch_history_ammount($_SESSION['siteusername']); ?></b> videos.<br>
                    Your account was created <b><?php echo $_video_fetch_utils->time_elapsed_string($_user_fetch_utils->fetch_creation_date($_SESSION['siteusername'])); ?></b>. Wow!<br>
                    Your videos have been watched <b><?php echo $_video_fetch_utils->fetch_views_from_user($_SESSION['siteusername']); ?></b> times.
                </div>
                <?php } ?>
                <div class="whats-new">
                    <h3><a href="/blog" style="color:#c60;">Blog</a> <a href="/feed/forum_category?c=WrapperTube+News" title="Latest Blog Posts"><img src="/static/img/feed-icon-small.png" alt="feed icon" width="14" height="14"></a></h3><br>
<?php
                    $stmt = $conn->prepare("SELECT id, author, title, date, contents FROM forum_thread WHERE category = 'WrapperTube News' AND date >= '2026-08-29 00:00:00' ORDER BY id DESC LIMIT 3");
                    $stmt->execute();
                    $result = $stmt->get_result();

    while($thread = $result->fetch_assoc()) {
?>
<h3><a href="/forum/thread?v=<?php echo $thread['id']; ?>"><?php echo htmlspecialchars($thread['title']); ?></a></h3>
                    <p class="whats-new-text">
<?php echo $bbcode->Parse($thread['contents']); ?>
</p>
<?php
} $stmt->close();
?>
                </div><br>
                <?php endif; ?>
                <div class="channel-latest-stats">
                    <h3><a href="/community?c=Featured">Featured Groups</a></h3>
                    <?php
                    $stmt = $conn->prepare("SELECT id, group_title, group_picture FROM user_groups WHERE group_featured = 'y' ORDER BY id DESC LIMIT 5");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while($group = $result->fetch_assoc()) { ?>
                    <div class="grid-item" style="width: 80px;">
                    <a href="/group/<?php echo $group['id']; ?>">
                    <img style="width: 60px;height: 60px;border: 3px double #999 !important;" class="channel-pfp" src="/dynamic/thumbs/<?php echo $group['group_picture']; ?>"><br>
                    </a>
                    <a style="font-size: 10px;text-decoration: none;" href="/group/<?php echo $group['id']; ?>"><?php echo htmlspecialchars($group['group_title']); ?></a>
                </div>
                    <?php } $stmt->close(); ?>
                </div>
                <div class="channel-latest-stats">
                    <h3><a href="/tags">Tags</a></h3>
<div class="tag-cloud">
<?php
// Fetch the tag strings from your videos table
$stmt = $conn->prepare("SELECT tags FROM videos WHERE publish >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND tags IS NOT NULL AND TRIM(tags) <> ''");
$stmt->execute();
$result = $stmt->get_result();
$tagCounts = [];

while ($row = $result->fetch_assoc()) {
    // Assuming tags are separated by a comma
    $tagsArray = explode(',', $row['tags']);

    foreach ($tagsArray as $tag) {
        $tag = trim(strtolower($tag)); // Clean up spaces and case
        if (!empty($tag)) {
            $tagCounts[$tag] = ($tagCounts[$tag] ?? 0) + 1;
        }
    }
}

// Sort tags alphabetically or shuffle them
arsort($tagCounts);
array_splice($tagCounts, 15);
// cloud
$minFontSize = 10; // in pixels
$maxFontSize = 30; // in pixels

$maxCount = !empty($tagCounts) ? max($tagCounts) : 1;
$minCount = !empty($tagCounts) ? min($tagCounts) : 1;

foreach ($tagCounts as $tag => $count) {
    // Calculate font size based on frequency
    $fontSize = $minFontSize + (($count - $minCount) / ($maxCount - $minCount)) * ($maxFontSize - $minFontSize);

    echo '<a href="/search_query?q=' . urlencode($tag) . '" style="font-size: ' . round($fontSize) . 'px;" title="' . $count . ' recent videos">' . htmlspecialchars($tag) . '</a>';
}
$stmt->close();
?>
</div>
                </div>
                <div class="channel-latest-stats">
                    <h3>Featured Users</h3>
                    <?php foreach($config['featured_channels'] as $channel) { ?>
                    <div class="grid-item" style="width: 80px;">
                    <a href="/user/<?php echo urlencode($channel); ?>">
                    <img style="width: 60px;height: 60px;border: 3px double #999 !important;" class="channel-pfp" src="/dynamic/pfp/<?php echo $_user_fetch_utils->fetch_user_pfp($channel); ?>"><br>
                    </a>
                    <a style="font-size: 10px;text-decoration: none;" href="/user/<?php echo urlencode($channel); ?>"><?php echo htmlspecialchars($channel); ?></a>
                </div>
                    <?php } ?>
                </div>
                <div class="channel-latest-stats">
                    <h3><a href="/recently_logged_in">Recent Visitors</a></h3>
                    <?php
                    $stmt = $conn->prepare("SELECT username, pfp FROM users ORDER BY lastlogin DESC LIMIT 5");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while($channel = $result->fetch_assoc()) { ?>
                    <div class="grid-item" style="width: 80px;">
                    <a href="/user/<?php echo urlencode($channel['username']); ?>">
                    <img style="width: 60px;height: 60px;border: 3px double #999 !important;" class="channel-pfp" src="/dynamic/pfp/<?php echo $channel['pfp']; ?>"><br>
                    </a>
                    <a style="font-size: 10px;text-decoration: none;" href="/user/<?php echo urlencode($channel['username']); ?>"><?php echo htmlspecialchars($channel['username']); ?></a>
                </div>
                    <?php } $stmt->close(); ?>
                </div>
<?php
$stmt = $conn->prepare("SELECT count(*) FROM videos");
$stmt->execute();
$stmt->bind_result($videos);
$stmt->fetch();
$stmt->close();

$stmt = $conn->prepare("SELECT count(*) FROM users");
$stmt->execute();
$stmt->bind_result($users);
$stmt->fetch();
$stmt->close();

$stmt = $conn->prepare("SELECT username FROM users ORDER BY id DESC LIMIT 1");
$stmt->execute();
$result = $stmt->get_result();
while($row = $result->fetch_assoc()) {
    $latest_user = $row['username'];
}
$stmt->close();

if (isset($latest_user)):
?>
                <div class="channel-latest-stats">
                    <h3><a href="/t/statistics">Statictics</a></h3>
                    There are <?php echo $videos; ?> videos created by our <?php echo $users; ?> registered members, and our newest member is <a href="/user/<?php echo htmlspecialchars($latest_user); ?>"><?php echo htmlspecialchars($latest_user); ?></a>. That's a lot of Wrapp-ing!
                </div>
<?php endif; ?>
            </div>
        </div>
        <div class="www-core-container">
        <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/module/footer.php"); ?>
        </div>
<script type="text/javascript" language="JavaScript">
var alerts = 0;
                        function add_video_to_quicklist(videoId) {
                                    $.ajax({
                                            url: "/get/add_to_quicklist?v=" + videoId,
                                            type: 'GET',
                                            success: function(res) {
                                                    alerts++;
                                                    addAlert("editsuccess_" + alerts, res);
                                                    showAlert("#editsuccess_" + alerts);
                                            }
                                    });
                        }
</script>
        <script src="/static/js/prefixfree.min.js"></script>
    </body>
</html>
