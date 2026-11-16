<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/update.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/insert.php"); ?>
<?php
    $_user_fetch_utils = new user_fetch_utils();
    $_video_fetch_utils = new video_fetch_utils();
    $_video_insert_utils = new video_insert_utils();
    $_user_insert_utils = new user_insert_utils();
    $_user_update_utils = new user_update_utils();
    $_base_utils = new config_setup();
    
    $_base_utils->initialize_db_var($conn);
    $_video_fetch_utils->initialize_db_var($conn);
    $_video_insert_utils->initialize_db_var($conn);
    $_user_fetch_utils->initialize_db_var($conn);
    $_user_insert_utils->initialize_db_var($conn);
    $_user_update_utils->initialize_db_var($conn);

function startsWith( $haystack, $needle ) {
     $length = strlen( $needle );
     return substr( $haystack, 0, $length ) === $needle;
}

function endsWith( $haystack, $needle ) {
    $length = strlen( $needle );
    if( !$length ) {
        return true;
    }
    return substr( $haystack, -$length ) === $needle;
}


if (!startsWith($_SERVER['REQUEST_URI'], "/group/")) {
die(header("Location: /group/" . $_GET['v'] . "/videos"));
}

    if(!$_video_fetch_utils->group_exists($_GET['v']))
        die(header("Location: /?groupdoesntexist"));

    $group = $_video_fetch_utils->fetch_group_id($_GET['v']);
    $_base_utils->initialize_page_compass(htmlspecialchars($group['group_title']));

    $group['joined'] = false;

    $group['admin'] = false;

    if($_user_fetch_utils->if_joined_group($_SESSION['siteusername'], $_GET['v']))
        $group['joined'] = true;

    if($_user_fetch_utils->if_group_admin($_SESSION['siteusername'], $_GET['v']))
        $group['admin'] = true;
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
<meta name="description" content="<?php echo htmlspecialchars($group['group_description']); ?>">
<meta name="theme-color" content="red">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
<meta property="og:title" content="WrapperTube - <?php echo $_base_utils->return_current_page(); ?>" />
<meta property="og:url" content="http://wrappertube.org/" />
<meta property="og:description" content="<?php echo htmlspecialchars($group['group_description']); ?>" />
<meta property="og:image" content="/dynamic/thumbs/<?php echo $group['group_picture']; ?>" />
        <script src="/static/js/core-js.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<link rel="alternate" type="application/atom+xml" title="Latest Videos on <?php echo htmlspecialchars($group['group_title']); ?>" href="/feed/group_videos?v=<?php echo $group['id']; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/static/css/new/www-core.css">
        <style>
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            td, th {
                text-align: left;
                padding: 3px;
            }

            th {
                border: 1px solid #dddddd;
                background: rgb(230,230,230);
                background: -moz-linear-gradient(0deg, rgba(230,230,230,1) 0%, rgba(255,255,255,1) 100%, rgba(255,255,255,1) 100%);
                background: -webkit-linear-gradient(0deg, rgba(230,230,230,1) 0%, rgba(255,255,255,1) 100%, rgba(255,255,255,1) 100%);
                background: linear-gradient(0deg, rgba(230,230,230,1) 0%, rgba(255,255,255,1) 100%, rgba(255,255,255,1) 100%);
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#ffffff",endColorstr="#e6e6e6",GradientType=0); 
            }

            tr:nth-child(even) {
                background-color: #f9f9f9;
            }
        </style>
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
            <script src="/static/js/alert.js?v2"></script>
            <h3 class="h3title" style="display: inline-block;"><a href="/group/<?php echo $group['id']; ?>"><?php echo htmlspecialchars($group['group_title']); ?></a> <a href="/feed/group_videos?v=<?php echo $group['id']; ?>" title="Latest Videos on <?php echo htmlspecialchars($group['group_title']); ?>"><img src="/static/img/feed-icon-small.png" alt="feed icon" width="14" height="14"></a></h3>
<?php if (isset($_SESSION['siteusername']) && $_SESSION['siteusername'] != $group['group_author']) { ?>
<?php if($group['joinable'] == "y" || $group['joined']) { ?>
            <a href="/get/<?php if($group['joined']) { ?>un<?php } ?>join_group?id=<?php echo $group['id']; ?>" onclick="return confirm('Are you sure you want to <?php if($group['joined']) { ?>Leave<?php } else { ?>Join<?php } ?> this group?');">
                <button type="button" class=" www-button www-button-grey" role="button">
                    <?php if($group['joined']) { ?>Leave<?php } else { ?>Join<?php } ?> Group
                </button>
            </a>
<?php } ?>
<?php } ?>
<?php if ($group['admin']) { ?>
            <a href="/edit_group?id=<?php echo $group['id']; ?>">
                <button type="button" class=" www-button www-button-grey" role="button">
                    Edit Group
                </button>
            </a>
<?php } ?>
            <br>
            <span style="font-size: 11px;" class="grey-text">by <a href="/user/<?php echo htmlspecialchars($group['group_author']); ?>"><?php echo htmlspecialchars($group['group_author']); ?></a><br>
            <a href="/group/<?php echo $group['id']; ?>/videos">Videos: <?php echo $_user_fetch_utils->fetch_group_video_count($_GET['v']); ?></a> | <a href="/group/<?php echo $group['id']; ?>/playlists">Playlists: <?php echo $_user_fetch_utils->fetch_group_playlist_count($_GET['v']); ?></a> | <a href="/group/<?php echo $group['id']; ?>/admins">Admins: <?php echo $_user_fetch_utils->fetch_group_member_count($_GET['v']) - $_user_fetch_utils->fetch_group_curator_count($_GET['v']); ?></a> | <a href="/group/<?php echo $group['id']; ?>/members">Members: <?php echo $_user_fetch_utils->fetch_group_curator_count($_GET['v']); ?></a><br>
            Category: <a href="/community?c=<?php echo urlencode($group['group_category']); ?>"><?php echo htmlspecialchars($group['group_category']); ?></a><br>
            created <?php echo date("M d, Y", strtotime($group['group_creation'])); ?></span><br><br>
            <p>
                <h3>Description:</h3>
                <?php echo $_video_fetch_utils->parseTextDescription($group['group_description']); ?>
            </p>
            <div style="float: right;position: relative;bottom: 108px;">
                <img src="/dynamic/thumbs/<?php echo $group['group_picture']; ?>" style="width:50px;height:50px;">
            </div>

            <h3>Videos (<?php echo $_user_fetch_utils->fetch_group_video_count($_GET['v']); ?>)</h3>
<?php if ($group['joined'] || ($group['group_club'] == "y" && isset($_SESSION['siteusername']))) { ?>
<form method="get" action="/get/add_video_group">
<input type="text" placeholder="Video ID" name="vid" style="width:85%;">
<input type="submit" value="Add Video" class="www-button www-button-grey">
<input type="hidden" name="gid" value="<?php echo $_GET['v']; ?>">
</form>
<?php } ?>
            <?php
                            $results_per_page = 20;

                            $stmt = $conn->prepare("SELECT count(*) FROM group_videos WHERE toid = ?");
                            $stmt->bind_param("s", $group['id']);
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

                            $stmt = $conn->prepare("SELECT * FROM group_videos WHERE toid = ? order by id desc LIMIT ?, ?");
                            $stmt->bind_param("sss", $group['id'], $page_first_result, $results_per_page);
                            $stmt->execute();
                            $result = $stmt->get_result();

                if($number_of_result == 0) { echo "There are no videos in this group, why not add one? "; }
            ?>
            <?php while($video = $result->fetch_assoc()) { $video_owner = $video['author']; $video = $_video_fetch_utils->fetch_video_rid($video['video']); if ($video) { 
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
                <div class="grid-item" style="animation: scale-up-recent 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;">
                                                    <div class="grid-item" style="">
                                    <a href="/watch?v=<?php echo $video['rid']; ?>">
                                    <img class="thumbnail" onerror="this.src='/dynamic/thumbs/default.png'" src="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>">
                                    </a>
                                    <div class="video-info-grid">
                                        <a style="display: inline-block;width: 127px;word-wrap: break-word;" href="/watch?v=<?php echo $video['rid']; ?>"><?php echo $_video_fetch_utils->parse_title($video['title']);  ?></a><br>
                                        <span class="video-info-small">
                                            <span class="video-views"><?php echo $_video_fetch_utils->fetch_video_views($video['rid']); ?> views</span><br>
                                            <a href="/user/<?php echo htmlspecialchars($video['author']); ?>"><?php echo htmlspecialchars($video['author']); ?></a><br>
<img src="/static/img/<?php echo ($video['star_ratio']>=1)?'full':(($video['star_ratio']>=0.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($video['star_ratio']>=2)?'full':(($video['star_ratio']>=1.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($video['star_ratio']>=3)?'full':(($video['star_ratio']>=2.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($video['star_ratio']>=4)?'full':(($video['star_ratio']>=3.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($video['star_ratio']>=5)?'full':(($video['star_ratio']>=4.5)?'half':'empty'); ?>_star_s.png"><br>
<?php echo $video['stars']; ?> ratings
                                        </span>
                                    </div>
                                </div>

                    <?php if($group['admin']) { ?>
                        <br>
                        <a href="/get/remove_video_from_group?gid=<?php echo $group['id']; ?>&vid=<?php echo htmlspecialchars($video['rid']); ?>" onclick="return confirm('Are you sure you want to remove this video?');">
                            <button type="button" class=" www-button www-button-grey" role="button">
                                Remove
                            </button>
                        </a>
                    <?php } ?>
                </div>
            <?php } } $stmt->close(); ?>
<br><br>
                  <?php
                                                                                                                if (!isset ($_GET['page']) ) {
                                                                                                                        $curpage = 1;
                                                                                                                } else {
                                                                                                                        $curpage = (int)$_GET['page'];
                                                                                                                }
?>
<?php if ($curpage > 1) { ?>
<a href="?page=<?php echo $curpage - 1; ?>">Prev</a>&nbsp;
<?php } ?>
<?php for($page = 1; $page<= $number_of_page; $page++) { ?>
<?php if($curpage==$page){ ?>
<b><?php echo $page; ?></b>&nbsp;
<?php } else { ?>
<a href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>&nbsp;
<?php } ?>
                  <?php } ?>
<?php if ($curpage < $number_of_page) { ?>
<a href="?page=<?php echo $curpage + 1; ?>">Next</a>&nbsp;
<?php } ?><br><br>
        </div>
        <div class="www-core-container">
        <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/module/footer.php"); ?>
        </div>
        <script src="/static/js/prefixfree.min.js"></script>
    </body>
</html>
