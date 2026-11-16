<!DOCTYPE html>
<html>
    <head>
        <title>WrapperTube - <?php echo $_base_utils->return_current_page(); ?></title>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="content-script-type" content="text/javascript">
<meta http-equiv="content-style-type" content="text/css">
<meta name="description" content="<?php echo htmlspecialchars($_user['bio']); ?>.">
<meta name="theme-color" content="<?php echo $_user['primary_color']; ?>">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
<meta property="og:title" content="WrapperTube - <?php echo $_base_utils->return_current_page(); ?>" />
<meta property="og:url" content="http://wrappertube.org/" />
<meta property="og:description" content="<?php echo htmlspecialchars($_user['bio']); ?>" />
<meta property="og:image" content="<?php echo "/dynamic/pfp/" . htmlspecialchars($_user['pfp']); ?>" />
        <script src="/static/js/core-js.js"></script>
<link rel="alternate" type="application/atom+xml" title="Videos RSS Feed" href="/feed/channel?n=<?php echo htmlspecialchars($_user['username']); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/static/css/new/www-core.css">

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src='/static/spectrum/spectrum.js'></script>
        <link rel='stylesheet' href='/static/spectrum/spectrum.css' />
        <script src="/static/js/channel-customization.js"></script>
        <style>
            .channel-box-top {
                background: <?php echo htmlspecialchars($_user['primary_color']); ?>;
                color: <?php echo htmlspecialchars($_user['text_color']); ?>;
                padding: 5px;
            }

            .sub_button {
                position: relative;
                bottom: 2px;
            }

            .channel-box-description {
                background: <?php echo htmlspecialchars($_user['secondary_color']); ?>;
                border: 1px solid <?php echo htmlspecialchars($_user['primary_color']); ?>;
                color: <?php echo htmlspecialchars($_user['primary_color_text']); ?>;
                padding: 5px;
            }

            .thin-line {
                border-bottom: 1px solid <?php echo htmlspecialchars($_user['primary_color']); ?>;
                border-top: 0px solid <?php echo htmlspecialchars($_user['primary_color']); ?>;
            }

            .channel-box-no-bg {
                border: 1px solid <?php echo htmlspecialchars($_user['primary_color']); ?>;
                color: <?php echo htmlspecialchars($_user['primary_color_text']); ?>;
                padding: 5px;
                background-color: <?php echo htmlspecialchars($_user['third_color']); ?>;
            }

            .channel-pfp {
                height: 88px;
                width: 88px;
                border-color: <?php echo htmlspecialchars($_user['primary_color']); ?>;
                border: 3px double <?php echo htmlspecialchars($_user['primary_color']); ?>;
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
                border-color: <?php echo htmlspecialchars($_user['primary_color']); ?>;
                display: inline-block;
                border: 3px double <?php echo htmlspecialchars($_user['primary_color']); ?>;;
            }

            .featured-video-info {
                border: 1px solid <?php echo htmlspecialchars($_user['primary_color']); ?>;
                color: black;
                padding: 5px;
                background-color: <?php echo htmlspecialchars($_user['third_color']); ?>;
                font-size: 10px;
                margin-top: -3px;
                margin-bottom: 11px;
            }

            .www-channel-left a {
                color: <?php echo htmlspecialchars($_user['primary_color_text']); ?>;
            }

            .www-channel-right a {
                color: <?php echo htmlspecialchars($_user['primary_color_text']); ?>;
            }
        </style>
        <style>
            body {
                position: absolute;
                right: 0;
                top: 0px;
                left: 0px;
                z-index: -1;
                background-color: <?php echo htmlspecialchars($_user['2012_bgcolor']); ?>;
                background-image: url(/dynamic/banners/<?php echo $_user['2012_bg']; ?>);
                background-position: top;
                <?php
                    $bgoption = "";
                            /*
                                <select name="bgoption" id="cars">
                                    <option value="repeaty">Repeat - Y</option>
                                    <option value="repeatx">Repeat - X</option>
                                    <option value="repeatxy">Repeat - X and Y</option>
                                    <option value="stretch">Stretch</option>
                                    <option value="solid">Solid</option>
                                </select>
                            */

                    switch($_user['2012_bgoption']) {
                        case "stretch":
                        echo "background-size: cover;";
                        break;
                        case "solid":
                        echo "";
                        break;
                        case "norepeat":
                        echo "";
                        break;
                        case "repeatxy":
                        echo "background-repeat: repeat;";
                        break;
                        case "repeaty":
                        echo "background-repeat: repeat-y;";
                        break;
                        case "repeatx":
                        echo "background-repeat: repeat-x;";
                        break;
                    }
                ?>
            }
            .channel-box-top {
                border-radius: <?php echo $_user['border_radius']; ?>px <?php echo $_user['border_radius']; ?>px 0 0 !important;
            }
            .channel-box-description, .channel-box-no-bg {
                border-radius: 0 0 <?php echo $_user['border_radius']; ?>px <?php echo $_user['border_radius']; ?>px !important;
            }
            .featured-video-info {
                border-radius: <?php echo $_user['border_radius']; ?>px !important;
            }
            <?php if (!empty($_user['font'])) { ?>
            .www-core-container {
                font-family: <?php echo strip_tags($_user['font']); ?> !important;
            }
            <?php } ?>
        </style>
<style type="text/css">
<?php echo strip_tags($_user['css']); ?>
</style>
<?php if ($_user["snow"] == "y") { ?>
<script src="/static/js/snowstorm-min.js"></script>
<?php } ?>
<link rel="stylesheet" href="/static/css/bbcode.css?v2">
    </head>
    <body>
        <div class="www-core-container">
            <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/module/channel_header.php"); ?>
            <script src="/static/js/alert.js?v2"></script><br>
            <?php 
            if(isset($_SESSION['siteusername']) && $_SESSION['siteusername'] == $_user['username']) 
                require($_SERVER['DOCUMENT_ROOT'] . "/static/module/channel_new_new_customization.php");
            ?><br>
                                                <?php if ($_user['banner_image_map'] != "") { echo strip_tags($_user['banner_image_map'], "<map><area>"); } ?>
            <?php if(!empty($_user['banner'])) { ?>
                <img src="/dynamic/banners/<?php echo $_user['banner']; ?>" style="width: 970px;" usemap="#imgmap">
            <?php } ?>
            <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/module/channel_top.php"); ?>
            <div class="www-channel-left" style="opacity: <?php echo htmlspecialchars($_user['transparency']); ?>;">
                <div class="channel-box-profle">
                    <div class="channel-box-top" style="height:auto;">
                        <h3 class="h3title" style="display: inline-block;"><?php echo htmlspecialchars($_user['channel_title']); ?></h3>

                        <?php if(@$_SESSION['siteusername'] != $_user['username']) { ?>
                        <a href="javascript:void(0);" onclick="subscribe();return false;">
                            <button style="margin: 0px;" class="sub_button"><?php if($_user['subscribed'] == true) { ?>Unsubscribe<?php } else { ?>Subscribe<?php } ?></button>
                        </a>
                        <?php } else { ?>
                        <a href="#">
                            <button style="margin: 0px;" class="sub_button" onclick="dropdownchannel()">Edit Channel</button>
                        </a>
                        <?php } ?>
                    </div>
                    <div class="channel-box-description">
                        <div style="display:inline-block;width:97px;">
                        <a href="/user/<?php echo htmlspecialchars($_user['username']); ?>">
                        <img class="channel-pfp" src="/dynamic/pfp/<?php echo $_user['pfp']; ?>">
                        </a>
        <?php $categories = ["director", "musician", "comedian", "guru", "nonprofit"]; ?>
        <?php if(in_array($_user['genre'], $categories)) { ?>
            <img style="width:94px" src="/static/img/<?php echo htmlspecialchars($_user['genre']); ?>.gif">
        <?php } ?>
                        </div>
                        <span class="channel-stats channelsta2" style="width: 193px;">
                            <h3<?php if (isset($banned)) { ?> style="text-decoration:line-through;color:grey;"<?php } ?>><?php echo htmlspecialchars($_user['username']); ?><?php if($_user['status']=='admin') { ?><span style="color:red;"> ## Admin</span><?php } ?><?php if($_user['status']=='moderator') { ?><span style="color:red;"> ## Mod</span><?php } ?><?php if($_user['partner']=="y") { ?> <img style="width: 29px;vertical-align: middle;margin-left: 10px;" title="This user is trusted" src="/yt/imgbin/RenderedImage.png"><?php } ?> <a href="/feed/channel?n=<?php echo htmlspecialchars($_user['username']); ?>" title="Videos RSS Feed"><img src="/static/img/feed-icon-small.png" alt="feed icon" width="14" height="14"></a></h3>
                            <span class="channel-stats-minor">
                                Joined: <b><?php echo date("M d, Y", strtotime($_user['created'])); ?></b><br>
                                Last Sign In: <b><?php echo $_video_fetch_utils->time_elapsed_string($_user['lastlogin']); ?></b><br>
                                Videos Watched: <b><?php echo $_video_fetch_utils->fetch_history_ammount($_user['username']); ?></b><br>
                                Subscribers: <b><?php echo $_user_fetch_utils->fetch_subs_count($_user['username']); ?></b><br>
                                Channels Views: <b><?php echo $_user_fetch_utils->get_channel_views($_user['username']); ?></b><br>
                                Total Video Views: <b><?php echo $_video_fetch_utils->fetch_views_from_user($_user['username']); ?></b><br>
                                Country: <b><?php echo htmlspecialchars($_user['country']); ?></b><br>
                                Status: <b><?php echo htmlspecialchars(ucfirst($_user['status'])); ?></b><br>
                                <?php if($_user['website'] != "") { ?>
                                    Website: <b><a href="<?php echo htmlspecialchars($_user['website']); ?>" rel="noopener noreferrer nofollow ugc" target="_blank"><?php echo htmlspecialchars($_user['website']); ?></a></b><br>
                                <?php } ?>
                            </span>
                        </span><br>
                        <span style="display: inline-block;width: 295px;word-wrap: break-word;">
                            <?php echo $_video_fetch_utils->parseTextDescription($_user['bio']); ?>
                        </span>
                    </div>
                </div><br>
                <div class="channel-box-profle">
                    <div class="channel-box-top" style="height: 12px;">
                        <h3 class="h3title" style="display: inline-block;"><?php echo htmlspecialchars($_user['contact_custom_text']); ?></h3>
                    </div>
                    <div class="channel-box-no-bg">
                        <a href="/user/<?php echo htmlspecialchars($_user['username']); ?>">
                        <div class="blockstyle" style="display: inline-block;width:116px;height:95px;"><img src="/dynamic/pfp/<?php echo $_user['pfp']; ?>" width="100%" height="100%"></div>
                        </a>
                        <span class="spaninline" style="display: inline-block;vertical-align: top;line-height: 30px;line-height: 21px;font-size: 11px;">
                            <img src="/static/img/mail0.png" style="vertical-align: middle;"> <a href="/inbox/compose?to=<?php echo htmlspecialchars($_user['username']); ?>">Send Message</a><br>
                            <img src="/static/img/comm0.png" style="vertical-align: middle;"> <a href="#discussion">Add Comment</a><br>
                            <img src="/static/img/share0.png" style="vertical-align: middle;"> <a href="javascript:void(0);" onclick="copyToClipboard('http://wrappertube.org/user/<?php echo htmlspecialchars($_user['username']); ?>');alert('Link copied to your clipboard!');return false;">Share Channel</a><br>
                            <?php if($_user_fetch_utils->if_blocked($_SESSION['siteusername'], $_user['username']) == false) { ?>
                                <img src="/static/img/block0.png" style="vertical-align: middle;"> <a href="javascript:void(0);" onclick="toggle_block();return false;" id="block_text">Block</a><br>
                            <?php } else { ?>
                                <img src="/static/img/block0.png" style="vertical-align: middle;"> <a href="javascript:void(0);" onclick="toggle_block();return false;" id="block_text">Unblock</a><br>
                            <?php } ?>
                            <img src="/static/img/friend0.png" style="vertical-align: middle;"> <a href="javascript:void(0);" onclick="add_friend();return false;">Add Friend</a>
                        </span><br>
                        <center><a href="/user/<?php echo htmlspecialchars($_user['username']); ?>">http://wrappertube.org/user/<?php echo htmlspecialchars($_user['username']); ?></a></center>

                    </div>
                </div><br>

                <div class="channel-box-profle">
                    <div class="channel-box-top" style="height: 12px;">
                        <h3 class="h3title" style="display: inline-block;">Recent Activity</h3>
                    </div>
                    <div class="channel-box-no-bg" style="color: #666;">
                        <?php
                            $stmt = $conn->prepare("SELECT rid, title, thumbnail, duration, title, author, publish, description FROM videos WHERE author = ? AND visibility = 'n' ORDER BY id DESC LIMIT 5");
                            $stmt->bind_param("s", $_user['username']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while($video = $result->fetch_assoc()) {
                        ?>
                            <img style="vertical-align: middle;" src="/static/img/upload.png"> <b><?php echo htmlspecialchars($video['author']); ?> uploaded a video</b> (<?php echo $_video_fetch_utils->time_elapsed_string($video['publish']); ?>)
                            <div class="video-item-watch" style="margin-left: 20px;">
                                <div class="thumbnail" style="
                                    background-image: url(/dynamic/thumbs/<?php echo $video['thumbnail']; ?>), url('/dynamic/thumbs/default.png');"><span class="timestamp"><?php echo $_video_fetch_utils->timestamp($video['duration']); ?></span></div>

                                <div class="video-info-watch" style="width: 170px;">
                                    <a href="/watch?v=<?php echo $video['rid']; ?>"><b><?php echo htmlspecialchars($video['title']);  ?></b></a><br>
                                    <span class="video-info-small-wide">
                                        <span class="video-views"><?php echo $_video_fetch_utils->fetch_video_views($video['rid']); ?> views</span><br>
                                        <a style="padding-left: 0px;" class="video-author-wide" href="/user/<?php echo htmlspecialchars($video['author']); ?>"><?php echo htmlspecialchars($video['author']); ?></a>
                                    </span>
                                </div>

                            </div>
                            <hr class="thin-line">
                        <?php } if($result->num_rows == 0)  { echo "This user has not been doing anything recently."; } $stmt->close(); ?>
                    </div>
                </div><br>


                <?php if($_user['subscriptions'] != 0) { ?>
                <div class="channel-box-profle">
                    <div class="channel-box-top">
                        <h3 class="h3title" style="display: inline-block;">Subscriptions (<?php echo $_user['subscriptions']; ?>)</h3>
                    </div>
                    <div class="channel-box-no-bg">
                        <?php
                            $stmt = $conn->prepare("SELECT reciever FROM subscribers WHERE sender = ? ORDER BY id DESC LIMIT 9");
                            $stmt->bind_param("s", $_user['username']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while($subscriber = $result->fetch_assoc()) {
                                if($_user_fetch_utils->user_exists($subscriber['reciever'])) {
                                    $user = htmlspecialchars($subscriber['reciever']);
                        ?>

                                <div class="grid-item" style="width: 90px;">
                                    <a href="/user/<?php echo $user; ?>">
                                    <img class="channel-pfp" style="width: 58px; height: 58px;" src="/dynamic/pfp/<?php echo $_user_fetch_utils->fetch_user_pfp($subscriber['reciever']); ?>"><br>
                                    </a>
                                    <a style="font-size: 10px;text-decoration: none;" href="/user/<?php echo $user; ?>"><?php echo htmlspecialchars($subscriber['reciever']); ?></a>
                                </div>
                        <?php } } $stmt->close(); ?>
                    </div>
                </div><br>
                <?php } ?>
            </div>
            <div class="www-channel-right" style="opacity: <?php echo htmlspecialchars($_user['transparency']); ?>;">
                <?php if($_user['featured'] != "None" && $_video_fetch_utils->video_exists($_user['featured'])) { 
                    $video = $_video_fetch_utils->fetch_video_rid($_user['featured']);
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
                    <center>
                        <iframe style="border: 0px; overflow: hidden;" src="/embed/<?php echo $_user['featured']; ?>" height="365" width="646" allowfullscreen="true"></iframe>
                    </center>
                    <div class="featured-video-info">
                            <div style="float:right;background-color: white;padding: 1px;border-radius: 3px;">
                    <img id="star_1" src="/static/img/<?php echo ($video['star_ratio']>=1)?'full':(($video['star_ratio']>=0.5)?'half':'empty'); ?>_star.png">
                    <img id="star_2" src="/static/img/<?php echo ($video['star_ratio']>=2)?'full':(($video['star_ratio']>=1.5)?'half':'empty'); ?>_star.png">
                    <img id="star_3" src="/static/img/<?php echo ($video['star_ratio']>=3)?'full':(($video['star_ratio']>=2.5)?'half':'empty'); ?>_star.png">
                    <img id="star_4" src="/static/img/<?php echo ($video['star_ratio']>=4)?'full':(($video['star_ratio']>=3.5)?'half':'empty'); ?>_star.png">
                    <img id="star_5" src="/static/img/<?php echo ($video['star_ratio']>=5)?'full':(($video['star_ratio']>=4.5)?'half':'empty'); ?>_star.png">
                            </div>
                            <span id="ratetext" style="float:right;"><?php echo $video['stars']; ?> ratings&nbsp;</span>
                        <h3><a href="/watch?v=<?php echo htmlspecialchars($_user['featured']); ?>"><?php echo htmlspecialchars($video['title']);  ?></a></h3>
                        From: <a href="/user/<?php echo htmlspecialchars($_user['username']); ?>"><?php echo htmlspecialchars($_user['username']); ?></a><br>
                        Views: <?php echo $_video_fetch_utils->fetch_video_views($video['rid']); ?></a><br>
                    </div>
                <?php } ?>

                <?php if($_user['videos'] != 0) { ?>
                <div class="channel-box-profle">
                    <div class="channel-box-top" style="height: 12px;">
                        <h3 class="h3title" style="display: inline-block;">Videos (<?php echo $_user['videos']; ?>)</h3>
                    </div>
                    <div class="channel-box-no-bg">
  <table border="0" cellpadding="5" cellspacing="0" width="100%" height="100%">
<tr>
<td>
<div style="padding:5px;">
<div style="margin: 5px 5px 5px 0;float: right;">
<form method="GET" action="/user/<?php echo htmlspecialchars($_user['username']); ?>/videos">
<input type="text" name="query">
<input type="submit" value="Search">
</form>
</div>
</div>
</td>
</tr>
<tr>
<td>
                        <?php
                            $stmt = $conn->prepare("SELECT rid, title, thumbnail, duration, title, author, publish, description FROM videos WHERE author = ? AND visibility = 'n' ORDER BY id DESC LIMIT 8");
                            $stmt->bind_param("s", $_user['username']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while($video = $result->fetch_assoc()) {
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

                                <div class="grid-item" style="">
                                    <a href="/watch?v=<?php echo $video['rid']; ?>">
                                    <img class="thumbnail" onerror="this.src='/dynamic/thumbs/default.png'" src="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>">
                                    </a>
                                    <div class="video-info-grid">
                                        <a style="display: inline-block;width: 127px;word-wrap: break-word;" href="/watch?v=<?php echo $video['rid']; ?>"><?php echo $_video_fetch_utils->parse_title($video['title']);  ?></a><br>
                                        <span class="video-info-small">
                                            <span class="video-views"><?php echo $_video_fetch_utils->fetch_video_views($video['rid']); ?> views</span><br>
                                            <a href="/user/<?php echo htmlspecialchars($video['author']); ?>"><?php echo htmlspecialchars($video['author']); ?></a><br>
<span style="background-color: white;padding: 1px;border-radius: 3px;">
<img src="/static/img/<?php echo ($video['star_ratio']>=1)?'full':(($video['star_ratio']>=0.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($video['star_ratio']>=2)?'full':(($video['star_ratio']>=1.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($video['star_ratio']>=3)?'full':(($video['star_ratio']>=2.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($video['star_ratio']>=4)?'full':(($video['star_ratio']>=3.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($video['star_ratio']>=5)?'full':(($video['star_ratio']>=4.5)?'half':'empty'); ?>_star_s.png">
</span>
                                        </span>
                                    </div>
                                </div>
                        <?php } $stmt->close(); ?>
</td>
</tr>
</table>
                    </div>
                </div><br>
                <?php } ?>

                <?php if($_user['favorites'] != 0) { ?>
                <div class="channel-box-profle">
                    <div class="channel-box-top" style="height: 12px;">
                        <h3 class="h3title" style="display: inline-block;">Favorites (<?php echo $_user['favorites']; ?>)</h3>
                    </div>
                    <div class="channel-box-no-bg">
                        <?php
                            $stmt = $conn->prepare("SELECT reciever FROM favorite_video WHERE sender = ? ORDER BY id DESC LIMIT 4");
                            $stmt->bind_param("s", $_user['username']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while($video = $result->fetch_assoc()) {
                                $video = $_video_fetch_utils->fetch_video_rid($video['reciever']);
                                if($_video_fetch_utils->video_exists($video['rid'])) {
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

                                <div class="grid-item" style="">
                                    <a href="/watch?v=<?php echo $video['rid']; ?>">
                                    <img class="thumbnail" onerror="this.src='/dynamic/thumbs/default.png'" src="/dynamic/thumbs/<?php echo htmlspecialchars($video['thumbnail']); ?>">
                                    </a>
                                    <div class="video-info-grid">
                                        <a href="/watch?v=<?php echo $video['rid']; ?>"><?php echo htmlspecialchars($video['title']);  ?></a><br>
                                        <span class="video-info-small">
                                            <span class="video-views"><?php echo $_video_fetch_utils->fetch_video_views($video['rid']); ?> views</span><br>
                                            <a href="/user/<?php echo htmlspecialchars($video['author']); ?>"><?php echo htmlspecialchars($video['author']); ?></a><br>
<span style="background-color: white;padding: 1px;border-radius: 3px;">
<img src="/static/img/<?php echo ($video['star_ratio']>=1)?'full':(($video['star_ratio']>=0.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($video['star_ratio']>=2)?'full':(($video['star_ratio']>=1.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($video['star_ratio']>=3)?'full':(($video['star_ratio']>=2.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($video['star_ratio']>=4)?'full':(($video['star_ratio']>=3.5)?'half':'empty'); ?>_star_s.png">
<img src="/static/img/<?php echo ($video['star_ratio']>=5)?'full':(($video['star_ratio']>=4.5)?'half':'empty'); ?>_star_s.png">
</span>
                                        </span>
                                    </div>
                                </div>
                        <?php } } $stmt->close(); ?>
                    </div>
                </div><br>
                <?php } ?>

                <?php if($_user['subscribers'] != 0) { ?>
                <div class="channel-box-profle">
                    <div class="channel-box-top" style="height: 12px;">
                        <h3 class="h3title" style="display: inline-block;">Subscribers (<?php echo $_user['subscribers']; ?>)</h3>
                    </div>
                    <div class="channel-box-no-bg">
                        <?php
                            $stmt = $conn->prepare("SELECT sender FROM subscribers WHERE reciever = ? ORDER BY id DESC LIMIT 8");
                            $stmt->bind_param("s", $_user['username']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while($subscriber = $result->fetch_assoc()) {
                                $user = htmlspecialchars($subscriber['sender']);
                        ?>

                                <div class="grid-item" style="">
                                    <a href="/user/<?php echo $user; ?>">
                                    <img class="channel-pfp" src="/dynamic/pfp/<?php echo $_user_fetch_utils->fetch_user_pfp($subscriber['sender']); ?>"><br>
                                    </a>
                                    <a style="font-size: 10px;text-decoration: none;" href="/user/<?php echo $user; ?>"><?php echo $user; ?></a>
                                </div>
                        <?php } $stmt->close(); ?>
                    </div>
                </div><br>
                <?php } ?>

                <?php if($_user['friends'] != 0) { ?>
                <div class="channel-box-profle">
                    <div class="channel-box-top" style="height: 12px;">
                        <h3 class="h3title" style="display: inline-block;">Friends (<?php echo $_user['friends']; ?>)</h3>
                    </div>
                    <div class="channel-box-no-bg">
                        <?php
                            $stmt = $conn->prepare("SELECT * FROM friends WHERE reciever = ? AND status = 'a' LIMIT 4");
                            $stmt->bind_param("s", $_user['username']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while($friend = $result->fetch_assoc()) { 
                                $user = htmlspecialchars($friend['sender']);
                        ?>
                            <div class="grid-item" style="">
                                <a href="/user/<?php echo $user; ?>">
                                <img class="channel-pfp" src="/dynamic/pfp/<?php echo $_user_fetch_utils->fetch_user_pfp($friend['sender']); ?>"><br>
                                </a>
                                <a style="font-size: 10px;text-decoration: none;" href="/user/<?php echo $user; ?>"><?php echo $user; ?></a>
                            </div>
                        <?php } $stmt->close(); ?>

                        <?php
                            $stmt = $conn->prepare("SELECT * FROM friends WHERE sender = ? AND status = 'a' LIMIT 4");
                            $stmt->bind_param("s", $_user['username']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while($friend = $result->fetch_assoc()) { 
                                $user = htmlspecialchars($friend['reciever']);
                        ?>
                            <div class="grid-item" style="">
                                <a href="/user/<?php echo $user; ?>">
                                <img class="channel-pfp" src="/dynamic/pfp/<?php echo $_user_fetch_utils->fetch_user_pfp($friend['reciever']); ?>"><br>
                                </a>
                                <a style="font-size: 10px;text-decoration: none;" href="/user/<?php echo $user; ?>"><?php echo $user; ?></a>
                            </div>
                        <?php } $stmt->close(); ?>
                    </div>
                </div><br>
                <?php } ?>

                <?php 
                            $results_per_page = 20;

                            $stmt = $conn->prepare("SELECT count(*) FROM profile_comments WHERE toid = ?");
                            $stmt->bind_param("s", $_user['username']);
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

                            $stmt = $conn->prepare("SELECT * FROM profile_comments WHERE toid = ? ORDER BY id DESC LIMIT ?, ?");
                            $stmt->bind_param("sss", $_GET['n'], $page_first_result, $results_per_page);
                            $stmt->execute();
                            $result = $stmt->get_result();
                ?>
                <div class="channel-box-profle">
                    <div class="channel-box-top" style="height: 12px;">
                        <a name="discussion"></a>
                        <h3 class="h3title" style="display: inline-block;">Channel Comments (<?php echo $number_of_result; ?>)</h3>
                    </div>
                    <div class="channel-box-no-bg">
                        <?php if(!isset($_SESSION['siteusername'])) { ?>
                            <div class="comment-alert">
                                <a href="/sign_in">Sign In</a> or <a href="/sign_up">Sign Up</a> now to post a comment!
                            </div>
                        <?php } else if($_user_fetch_utils->if_blocked($_user['username'], $_SESSION['siteusername'])) { ?>
                            <div class="comment-alert">
                                <br>
                                This user has blocked you!
                            </div>
                        <?php } else if($_user['commenting'] == "n") { ?>
                            <div class="comment-alert">
                                This channel has commenting disabled!
                            </div>
                        <?php } else { ?>
                            <form method="post" action="" id="submitform">
                                    <div class="alert" id="comment_error" style="background-color: #FFA3A3;<?php if(!isset($error['status'])) { ?>display: none;<?php } ?>">
                                        <?php echo $error['message']; ?>
                                    </div>
                            
                                    <textarea 
                                        onkeyup="textCounter(this,'counter',500);" 
                                        class="comment-textbox" cols="32" id="com" style="width: 98%;"
                                        placeholder="Leave a nice comment on this channel" name="comment"></textarea><br>
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
                                    <script src="/captcha/captcha.js"></script><br>
<?php } ?>
                                    <input type="submit" value="Post">
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
<span id="comments_section_real">
                        <?php while($comment = $result->fetch_assoc()) {
                            $author = htmlspecialchars($comment['author']);
                        ?>
                        <hr class="thin-line">
                        <div class="comment-watch" id="comment_<?php echo $comment['id'];?>">
                            <a href="/user/<?php echo $author; ?>">
                            <img class="comment-pfp" src="/dynamic/pfp/<?php echo $_user_fetch_utils->fetch_user_pfp($comment['author']); ?>">
                            </a>
                            <span class="cauthor" style="display: inline-block; vertical-align: top;width: 562px;">
                                <span class="comment-info" style="display: inline-block;">
                                    <b><a style="text-decoration: none;" href="/user/<?php echo $author; ?>">
                                        <?php echo $author; ?> 
                                    </a></b> 
                                    <span style="color: #666;">(<?php echo $_video_fetch_utils->time_elapsed_string($comment['date']); ?>)</span>
                                    <?php if(isset($_SESSION['siteusername']) && $_SESSION['siteusername'] == $_user['username']) { ?>
                                        <a style="float: right;" href="javascript:void(0);" onclick="delete_comment('<?php echo $comment['id'];?>');return false;">Remove Comment</a>
                                    <?php } ?>
                                </span><br>
                                <span class="comment-text" style="display: inline-block;width: 575px;word-wrap: break-word;">
                                    <?php echo $_video_fetch_utils->parseTextDescription($comment['comment']); ?>
                                </span>
                            </span>

                        </div>
                        <?php } $stmt->close(); ?>
</span>
<center>
                  <?php
                                                                                                                if (!isset ($_GET['page']) ) {
                                                                                                                        $curpage = 1;
                                                                                                                } else {
                                                                                                                        $curpage = (int)$_GET['page'];
                                                                                                                }
?>
<?php if ($curpage > 1) { ?>
<a href="/user/<?php echo htmlspecialchars($_user['username']) ?>?page=<?php echo $curpage - 1; ?>">Prev</a>&nbsp;
<?php } ?>
<?php for($page = 1; $page<= $number_of_page; $page++) { ?>
<?php if($curpage==$page){ ?>
<b><?php echo $page; ?></b>&nbsp;
<?php } else { ?>
<a href="/user/<?php echo htmlspecialchars($_user['username']) ?>?page=<?php echo $page; ?>"><?php echo $page; ?></a>&nbsp;
<?php } ?>
                  <?php } ?>
<?php if ($curpage < $number_of_page) { ?>
<a href="/user/<?php echo htmlspecialchars($_user['username']) ?>?page=<?php echo $curpage + 1; ?>">Next</a>&nbsp;
<?php } ?>
</center>
                    </div>
                </div>
            </div>
        </div>
        <div id="channelbg">
            &nbsp;
        </div>
        <script>
            userUserName = <?php echo json_encode($_user['username'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
            subscribed = <?php echo($_user['subscribed'] ? 'true' : 'false') ?>;
            loggedIn = <?php echo(isset($_SESSION['siteusername']) ? 'true' : 'false') ?>;
            blocked = <?php echo $_user_fetch_utils->if_blocked($_SESSION['siteusername'], $_user['username']) ? 'true' : 'false'; ?>;
            amITrusted = <?php echo $_video_fetch_utils->if_partner($_SESSION['siteusername']) ? 'true' : 'false'; ?>;
            alerts = 0;
        </script>
        <script src="/static/js/channel_1.js?v5"></script>
<script type="text/javascript" language="JavaScript">
function copyToClipboard(e) {
    var t = document.createElement("input");
    document.body.appendChild(t);
    t.value = e;
    t.select();
    document.execCommand("copy");
    t.parentNode.removeChild(t);
}
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
