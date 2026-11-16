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
die(header("Location: /group/" . $_GET['v']));
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

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $error = array();
if (file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/static/important/lockdown_mode.txt")=="on") {die("WrapperTube is currently experiencing an attack from vandals. Some of the site features have been temporarily disabled. Please try again later.");}
        if(!isset($_SESSION['siteusername'])){ $error['message'] = "you are not logged in"; $error['status'] = true; }
        if(!$_POST['comment']){ $error['message'] = "your comment cannot be blank"; $error['status'] = true; }
        if(strlen($_POST['comment']) > 1000){ $error['message'] = "your comment must be shorter than 1000 characters"; $error['status'] = true; }
if (!$_video_fetch_utils->if_partner($_SESSION['siteusername'])) {
        if(!isset($_POST['_CAPTCHA'])){ $error['message'] = "captcha validation failed"; $error['status'] = true; }
        if(!$_user_insert_utils->validateCaptchaNew($_POST['_CAPTCHA_KEY'], $_POST['_CAPTCHA'])) { $error['message'] = "captcha validation failed"; $error['status'] = true; }
}
        if($_user_fetch_utils->if_cooldown($_SESSION['siteusername'])) { $error['message'] = "You are on a cooldown! Wait for 20 seconds before posting another comment."; $error['status'] = true; }
        if($group['commenting'] == "n") { $error['message'] = "Comments have been disabled."; $error['status'] = true; }
        //if(ifBlocked(@$_SESSION['siteusername'], $user['username'], $conn)) { $error = "This user has blocked you!"; $error['status'] = true; } 

        if(!isset($error['message'])) {
            $stmt = $conn->prepare("INSERT INTO `group_discussion` (toid, author, comment) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $group['id'], $_SESSION['siteusername'], $text);
            $text = ($_POST['comment']);
            $stmt->execute();
            $stmt->close();

            $_user_update_utils->update_comment_cooldown_time($_SESSION['siteusername']);
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
<?php if ($_video_fetch_utils->is_admin($_SESSION['siteusername'])) { ?>
<?php if ($group['group_featured'] == "y") { ?>
<a href="/funny_casablanka/unfeature_group?v=<?php echo $group['id']; ?>" onclick="return confirm('Are you sure you want to unfeature this group?');">
                <button type="button" class=" www-button www-button-grey" role="button">
                    Unfeature Group
                </button>
            </a>
<?php } else { ?>
<a href="/funny_casablanka/feature_group?v=<?php echo $group['id']; ?>" onclick="return confirm('Are you sure you want to feature this group?');">
                <button type="button" class=" www-button www-button-grey" role="button">
                    Feature Group
                </button>
            </a>
<?php } ?>
<?php } ?>
<?php if ($_video_fetch_utils->is_moderator($_SESSION['siteusername'])) { ?>
<?php if ($group['group_featured'] == "y") { ?>
<a href="/vivat_shuravi/unfeature_group?v=<?php echo $group['id']; ?>" onclick="return confirm('Are you sure you want to unfeature this group?');">
                <button type="button" class=" www-button www-button-grey" role="button">
                    Unfeature Group
                </button>
            </a>
<?php } else { ?>
<a href="/vivat_shuravi/feature_group?v=<?php echo $group['id']; ?>" onclick="return confirm('Are you sure you want to feature this group?');">
                <button type="button" class=" www-button www-button-grey" role="button">
                    Feature Group
                </button>
            </a>
<?php } ?>
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

            <h3>Admins (<?php echo $_user_fetch_utils->fetch_group_member_count($_GET['v']) - $_user_fetch_utils->fetch_group_curator_count($_GET['v']); ?>)<a href="/group/<?php echo $_GET['v']; ?>/admins" style="float:right;">View All</a></h3>
            <?php
                $stmt = $conn->prepare("SELECT * FROM group_members WHERE togroup = ? AND (status = 'i' OR status = 'o') LIMIT 10");
                $stmt->bind_param("s", $_GET['v']);
                $stmt->execute();
                $result = $stmt->get_result();

                if($result->num_rows == 0) { echo "There are no admins in this group."; }
            ?>
            <?php while($user = $result->fetch_assoc()) { $user = $_user_fetch_utils->fetch_user_username($user['username']); ?>
                <div class="grid-item" style="animation: scale-up-recent 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;">
                    <img class="channel-pfp" src="/dynamic/pfp/<?php echo $user['pfp']; ?>"><br>
                    <a style="font-size: 10px;text-decoration: none;" href="/user/<?php echo htmlspecialchars($user['username']); ?>"><?php echo htmlspecialchars($user['username']); ?></a>

                    <?php if($group['admin'] && $user['username'] != @$_SESSION['siteusername'] && $user['username'] != $group['group_author']) { ?>
                        <br>
                        <a href="/get/kick_from_group?id=<?php echo $group['id']; ?>&user=<?php echo htmlspecialchars($user['username']); ?>" onclick="return confirm('Are you sure you want to kick this user?');">
                            <button type="button" class=" www-button www-button-grey" role="button">
                                Kick
                            </button>
                        </a>
                        <a href="/get/demote_from_group?id=<?php echo $group['id']; ?>&user=<?php echo htmlspecialchars($user['username']); ?>" onclick="return confirm('Are you sure you want to demote this user?');">
                            <button type="button" class=" www-button www-button-grey" role="button">
                                Demote
                            </button>
                        </a>
                    <?php } $stmt->close(); ?>
                </div>
            <?php } ?><br><br>

            
            <h3>Members (<?php echo $_user_fetch_utils->fetch_group_curator_count($_GET['v']); ?>)<a href="/group/<?php echo $_GET['v']; ?>/members" style="float:right;">View All</a></h3>
<?php if ($group['admin']) { ?>
<form method="get" action="/get/add_user_to_group">
<input type="text" placeholder="Username" name="user" style="width:85%;">
<input type="submit" value="Add User" class="www-button www-button-grey">
<input type="hidden" name="id" value="<?php echo $_GET['v']; ?>">
</form>
<?php } ?>
            <?php 
                $stmt = $conn->prepare("SELECT * FROM group_members WHERE togroup = ? AND status = 'a' LIMIT 10");
                $stmt->bind_param("s", $_GET['v']);
                $stmt->execute();
                $result = $stmt->get_result();

                if($result->num_rows == 0) { echo "There are no members in this group, why not join? "; } 
            ?>
            <?php while($user = $result->fetch_assoc()) { $user = $_user_fetch_utils->fetch_user_username($user['username']); ?>
                <div class="grid-item" style="animation: scale-up-recent 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;">
                    <img class="channel-pfp" src="/dynamic/pfp/<?php echo $user['pfp']; ?>"><br>
                    <a style="font-size: 10px;text-decoration: none;" href="/user/<?php echo htmlspecialchars($user['username']); ?>"><?php echo htmlspecialchars($user['username']); ?></a>
                
                    <?php if($group['admin'] && $user['username'] != @$_SESSION['siteusername'] && $user['username'] != $group['group_author']) { ?>
                        <br>
                        <a href="/get/kick_from_group?id=<?php echo $group['id']; ?>&user=<?php echo htmlspecialchars($user['username']); ?>" onclick="return confirm('Are you sure you want to kick this user?');">
                            <button type="button" class=" www-button www-button-grey" role="button">
                                Kick
                            </button>
                        </a>
                        <a href="/get/promote_from_group?id=<?php echo $group['id']; ?>&user=<?php echo htmlspecialchars($user['username']); ?>" onclick="return confirm('Are you sure you want to promote this user?');">
                            <button type="button" class=" www-button www-button-grey" role="button">
                                Promote
                            </button>
                        </a>
                    <?php } $stmt->close(); ?>
                </div>
            <?php } ?><br><br>

            <h3>Videos (<?php echo $_user_fetch_utils->fetch_group_video_count($_GET['v']); ?>)<a href="/group/<?php echo $_GET['v']; ?>/videos" style="float:right;">View All</a></h3>
<?php if ($group['joined'] || ($group['group_club'] == "y" && isset($_SESSION['siteusername']))) { ?>
<form method="get" action="/get/add_video_group">
<input type="text" placeholder="Video ID" name="vid" style="width:85%;">
<input type="submit" value="Add Video" class="www-button www-button-grey">
<input type="hidden" name="gid" value="<?php echo $_GET['v']; ?>">
</form>
<?php } ?>
            <?php
                $stmt = $conn->prepare("SELECT * FROM group_videos WHERE toid = ? order by id desc LIMIT 10");
                $stmt->bind_param("s", $_GET['v']);
                $stmt->execute();
                $result = $stmt->get_result();

                if($result->num_rows == 0) { echo "There are no videos in this group, why not add one? "; }
            ?>
            <?php while($video = $result->fetch_assoc()) { $video_owner = $video['author']; $video = $_video_fetch_utils->fetch_video_rid($video['video']); if($video) { 
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
<img src="/static/img/<?php echo ($video['star_ratio']>=5)?'full':(($video['star_ratio']>=4.5)?'half':'empty'); ?>_star_s.png">
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
            <?php } } $stmt->close(); ?><br><br>
            <h3>Playlists (<?php echo $_user_fetch_utils->fetch_group_playlist_count($_GET['v']); ?>)<a href="/group/<?php echo $_GET['v']; ?>/playlists" style="float:right;">View All</a></h3>
<?php if ($group['joined'] || ($group['group_club'] == "y" && isset($_SESSION['siteusername']))) { ?>
<form method="get" action="/get/add_playlist_group">
<input type="text" placeholder="Playlist ID" name="vid" style="width:85%;">
<input type="submit" value="Add Playlist" class="www-button www-button-grey">
<input type="hidden" name="gid" value="<?php echo $_GET['v']; ?>">
</form>
<?php } ?>
            <?php
                $stmt = $conn->prepare("SELECT * FROM group_playlists WHERE toid = ? order by id desc LIMIT 10");
                $stmt->bind_param("s", $_GET['v']);
                $stmt->execute();
                $result = $stmt->get_result();

                if($result->num_rows == 0) { echo "There are no playlists in this group, why not add one? "; }
            ?>
            <?php while($video = $result->fetch_assoc()) { $video_owner = $video['author']; $video = $_video_fetch_utils->fetch_playlist_rid($video['playlist']); if ($video) {
$playlist_videos = json_decode($video['videos']);
$the_video = $playlist_videos[0];
if ($the_video && $_video_fetch_utils->video_exists($the_video) ) {
$the_video = $_video_fetch_utils->fetch_video_rid($the_video);
$thumb = $the_video['thumbnail'];
} else {
$thumb = "default.jpg";
}
 ?>
                <div style="animation: scale-up-recent 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;">

<div class="vDetailEntry" style="padding:5px;">
                        <table class="playlist" width="100%" cellspacing="0" cellpadding="2" border="0">
                                <tbody><tr valign="top">
                                        <td><div style="margin-right: 10px;"><div class="vCluster120WideEntry"><div class="vCluster120WrapperOuter"><div class="vCluster120WrapperInner"><a id="video-url-JzOTt2VMufw" href="/view_playlist?v=<?php echo $video['rid']; ?>" rel="nofollow"><img width="126" height="78" title="<?php echo htmlspecialchars($video['title']); ?>" src="/dynamic/thumbs/<?php echo $thumb; ?>" class="vimgCluster120" alt="<?php echo htmlspecialchars($video['title']); ?>"></a><!--<div class="video-corner-text"><span><?php echo count($playlist_videos); ?> videos</span></div>--></div></div></div></div></td>
                                <td width="100%">
                                        <div class="title">
                                                <a href="/view_playlist?v=<?php echo $video['rid']; ?>"><?php echo htmlspecialchars($video['title']); ?></a> <span dir="ltr" class="facets">
                                                <?php echo count($playlist_videos); ?>&nbsp;
Videos</span>
                                        </div>
                                        <div class="desc"><?php echo $_video_fetch_utils->parseTextNoLink($video['description']); ?></div>
                                </td>
                                <td valign="middle" nowrap="" align="right">
                                        <div class="playlistLinks">
                                                <a href="/view_playlist?v=<?php echo $video['rid']; ?>">Play All</a><br>
                                                <a href="javascript:void(0)" onclick="copyToClipboard('http://wrappertube.org/view_playlist?v=<?php echo $video['rid']; ?>');alert('Link copied to your clipboard!');return false;">Share</a>
                    <?php if($group['admin']) { ?>
                        <br><a href="/get/remove_playlist_from_group?gid=<?php echo $group['id']; ?>&vid=<?php echo htmlspecialchars($video['rid']); ?>" onclick="return confirm('Are you sure you want to remove this playlist?');">
                                Remove
                        </a>
                    <?php } $stmt->close(); ?>

                                        </div>
                                </td>
                                </tr>
                        </tbody></table>
                </div>
                </div>
            <?php } } ?><br><br>


            <h3>Group Wall: <?php if($group['admin']) { ?><a style="float: right;" href="/get/toggle_comment_group?id=<?php echo $group['id']; ?>">toggle commenting</a><?php } ?></h3>
            <?php if(!isset($_SESSION['siteusername'])) { ?>
                <div class="comment-alert">
                    <a href="/sign_in">Sign In</a> or <a href="/$video">Sign Up</a> now to post a comment!
                </div>
            <?php } else if ($group['commenting'] == "n") { ?>
                <div class="comment-alert">
                    Comments have been disabled.
                </div>
                    <?php } else { ?>
                <form method="post" action="" id="submitform">
                        <div class="alert" id="comment_error" style="background-color: #FFA3A3;<?php if(!isset($error['status'])) { ?>display: none;<?php } ?>">
                            <?php echo $error['message']; ?>
                        </div>
                        <textarea 
                            onkeyup="textCounter(this,'counter',500);" 
                            class="comment-textbox" cols="32" id="com" style="width: 98%;"
                            placeholder="Leave a nice comment on this group" name="comment"></textarea><br>
<select onchange="insertThisInThere(this.value,'com');this.selectedIndex=0;">
  <option value="" disabled selected>--Kaomoji--</option>
  <option value="ｷﾀ━━━(ﾟ∀ﾟ)━━━!!">ｷﾀ━━━(ﾟ∀ﾟ)━━━!!</option>
  <option value="(;´Д`)">(;´Д`)</option>
  <option value="ヽ(´∇`)ノ">ヽ(´∇`)ノ</option>
  <option value="(´ー`)">(´ー`)</option>
  <option value="( ´ー｀)y-~~">( ´ー｀)y-~~</option>
  <option value="（ ’～’）">（ ’～’）</option>
  <option value="ヽ(`Д´)ノ">ヽ(`Д´)ノ</option>
  <option value="( ´ω`)">( ´ω`)</option>
  <option value="(・∀・)">(・∀・)</option>
  <option value="(´・ω・｀)">(´・ω・｀)</option>
  <option value="( ´,_ゝ｀)">( ´,_ゝ｀)</option>
  <option value="Σ(;ﾟДﾟ)">Σ(;ﾟДﾟ)</option>
  <option value="(;｀Д´)">(;｀Д´)</option>
  <option value="( ﾟ ヮﾟ) Mittens!">( ﾟ ヮﾟ)</option>
  <option value="^°^">^°^</option>
  <option value="=^..^=">=^..^=</option>
  <option value="^v^">^v^</option>
  <option value="VvV">VvV</option>
  <option value="UwU">UwU</option>
  <option value="( ° _ ° )">( ° _ ° )</option>
  <option value="&gt;v^">&gt;v^</option>
  <option value="^_&lt;">^_&lt;</option>
  <option value="&gt_^">&gt;_^</option>
  <option value="^v&lt;">^v&lt;</option>
  <option value="( &gt; v &lt; )">( &gt; v &lt; )</option>
  <option value="&gt;v&lt;">&gt;v&lt;</option>
</select><br><br> 
                        <input disabled class="characters-remaining" maxlength="3" size="3" value="500" id="counter"> <?php if(!isset($cLang)) { ?> characters remaining <?php } else { echo $cLang['charremaining']; } ?> <br>
<?php if (!$_video_fetch_utils->if_partner($_SESSION['siteusername'])) { ?>
                        <script src="/captcha/captcha.js"></script>
<?php } ?>
                        <br><input type="submit" value="Post" class="www-button www-button-grey">
                        <script>
                        function textCounter(field,field2,maxlimit) {
                            var countfield = document.getElementById(field2);
                            if ( field.value.length > maxlimit ) {
                                field.value = field.value.substring( 0, maxlimit );
                                return false;
                            } else {
                                countfield.value = maxlimit - field.value.length;
                            }
                            }
                        </script>
                </form>
            <?php } ?><br>
            <?php 
                            $results_per_page = 20;

                            $stmt = $conn->prepare("SELECT count(*) FROM group_discussion WHERE toid = ?");
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

                            $stmt = $conn->prepare("SELECT * FROM group_discussion WHERE toid = ? ORDER BY id DESC LIMIT ?, ?");
                            $stmt->bind_param("sss", $group['id'], $page_first_result, $results_per_page);
                            $stmt->execute();
                            $result = $stmt->get_result();
            ?>
<span id="comments_section_real">
            <?php while($comment = $result->fetch_assoc()) {  
                $author = htmlspecialchars($comment['author']);
            ?>
            <hr class="thin-line">
            <div class="comment-watch" style="width:100%;" id="comment_<?php echo $comment['id'];?>">
                <a href="/user/<?php echo $author; ?>">
                <img class="comment-pfp" src="/dynamic/pfp/<?php echo $_user_fetch_utils->fetch_user_pfp($comment['author']); ?>">
                </a>
                <span  style="display: inline-block; vertical-align: top;width: 93%;">
                    <span class="comment-info" style="display: inline-block;">
                        <b><a style="text-decoration: none;" href="/user/<?php echo $author; ?>">
                            <?php echo $author; ?> 
                        </a></b> 
                        <span style="">(<?php echo $_video_fetch_utils->time_elapsed_string($comment['date']); ?>)</span>
                        <?php if($group['admin']) { ?>
                            <a style="float: right;" href="javascript:void(0);" onclick="delete_comment('<?php echo $comment['id'];?>');return false;">Remove Comment</a>
                        <?php } ?>
                    </span><br>
                    <span class="comment-text" style="display: inline-block;width: 100% !important;word-wrap: break-word;">
                        <?php echo $_video_fetch_utils->parseTextDescription($comment['comment']); ?>
                    </span>
                </span>

            </div>
            <?php } $stmt->close(); ?>
</span>
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
<?php } ?>
        </div>
        <div class="www-core-container">
        <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/module/footer.php"); ?>
        </div>
<script type="text/javascript" language="JavaScript">
function copyToClipboard(e) {
    var t = document.createElement("input");
    document.body.appendChild(t);
    t.value = e;
    t.select();
    document.execCommand("copy");
    t.parentNode.removeChild(t);
}
</script>
<script type="text/javascript" language="JavaScript">
            var alerts = 0;
            $(function() {
                $('#submitform' ).submit(
                    function( e ) {
                        $("#comment_error").hide();
                        $('#submitform input[type="submit"]').prop("disabled", true);
                        var data = new FormData(this);

                        $.ajax( {
                            url: '/post/comment_group?v=<?php echo $group['id']; ?>',
                            type: 'POST',
                            data: data,
                            cache: false,
                            processData: false,
                            contentType: false,
                            success: function(result){
                                if(result.substr(0,3) == "OK:") {
                                    $("#comments_section_real").prepend(result.substr(3));
                                    $('#submitform textarea[name="comment"]').val('');
                                } else {
                                    $("#comment_error").text(result.substr(6));
                                    $("#comment_error").show();
                                }
<?php if (!$_video_fetch_utils->if_partner($_SESSION['siteusername'])) { ?>
                                ka_reload(false);
<?php } ?>
                                $('#submitform input[type="submit"]').prop("disabled", false);
                            }
                        } );
                        e.preventDefault();
                    }
                );
            });
                        function delete_comment(cid) {
                                    if (!confirm('Are you sure you want to remove this comment?')) { return; }
                                    $.ajax({
                                            url: "/get/delete_comment_group?cid=" + cid + "&gid=<?php echo $group['id']; ?>",
                                            type: 'GET',
                                            success: function(res) {
                                            if (res == "OK") {
                                                    $("#comment_" + cid).prev().remove();
                                                    $("#comment_" + cid).remove();
                                            } else {
                                                    alerts++;
                                                    addAlert("editsuccess_" + alerts, res);
                                                    showAlert("#editsuccess_" + alerts);
                                            }
                                            }
                                    });
                        }
</script>
<script type="text/javascript" language="JavaScript">
function insertThisInThere(thisChar, thereId) {
        function theCursorPosition(ofThisInput) {
                // set a fallback cursor location
                var theCursorLocation = 0;

                // find the cursor location via IE method...
                if (document.selection) {
                        ofThisInput.focus();
                        var theSelectionRange = document.selection.createRange();
                        theSelectionRange.moveStart('character', -ofThisInput.value.length);
                        theCursorLocation = theSelectionRange.text.length;
                } else if (ofThisInput.selectionStart || ofThisInput.selectionStart == '0') {
                        // or the FF way
                        theCursorLocation = ofThisInput.selectionStart;
                }
                return theCursorLocation;
        }

        // now get ready to place our new character(s)...
        var theIdElement = document.getElementById(thereId);
        var currentPos = theCursorPosition(theIdElement);
        var origValue = theIdElement.value;
        var newValue = origValue.substr(0, currentPos) + thisChar + origValue.substr(currentPos);

        theIdElement.value = newValue;

}
</script>
        <script src="/static/js/prefixfree.min.js"></script>
    </body>
</html>
