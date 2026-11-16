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
                border: 1px solid <?php echo htmlspecialchars($_user['border_color']); ?>;
                color: <?php echo htmlspecialchars($_user['primary_color_text']); ?>;
                padding: 5px;
            }

            .thin-line {
                border-bottom: 1px solid <?php echo htmlspecialchars($_user['primary_color']); ?>;
                border-top: 0px solid <?php echo htmlspecialchars($_user['primary_color']); ?>;
            }

            .channel-box-no-bg {
                border: 1px solid <?php echo htmlspecialchars($_user['border_color']); ?>;
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
                border: 1px solid <?php echo htmlspecialchars($_user['border_color']); ?>;
                color: black;
                padding: 5px;
                background-color: <?php echo htmlspecialchars($_user['third_color']); ?>;
                font-size: 10px;
                margin-top: -3px;
                margin-bottom: 11px;
            }

            input[type="color"] {
                background: transparent url(/static/img/spritesheet_main.png) repeat-x scroll 0 -800px;
                width: 35px;
            }

            .www-channel-left a {
                color: <?php echo htmlspecialchars($_user['primary_color_text']); ?>;
            }

            .www-channel-right a {
                color: <?php echo htmlspecialchars($_user['primary_color_text']); ?>;
            }

            .benifits-outer-front {
                background-color: <?php echo htmlspecialchars($_user['third_color']); ?>;
            }

            .benifits-inner-front {
                background-color: <?php echo htmlspecialchars($_user['third_color']); ?>;
                color: <?php echo htmlspecialchars($_user['primary_color_text']); ?>;
            }

            .benifits-inner-front a {
                color: <?php echo htmlspecialchars($_user['primary_color_text']); ?>;
            }

            .featured-video-info a {
                color: <?php echo htmlspecialchars($_user['primary_color_text']); ?>;
            }

.channel-cmd {
color: <?php echo htmlspecialchars($_user['primary_color_text']); ?>;
border-bottom-color: <?php echo htmlspecialchars($_user['primary_color_text']); ?>;
border-bottom-style: dotted;
border-bottom-width: 1px;
text-decoration: none;
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
                    $videoId = "";
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

            .www-channel-top {
                background-color: <?php echo htmlspecialchars($_user['third_color']); ?>;
                color: <?php echo htmlspecialchars($_user['text_color']); ?>;
            }

            .www-channel-two-left {
                float: left;
                width: 633px;
                padding: 5px;
            }

            .www-channel-two-right {
                float: right;
                width: 294px;
                padding: 5px;
            }

            .www-channel-section {
                background: <?php echo htmlspecialchars($_user['primary_color']); ?>;
                color: <?php echo htmlspecialchars($_user['primary_color_text']); ?>;
                padding: 5px;
                border-radius: 3px;
            }

            .right_arrow {
                width: 0;
                height: 0;
                float: left;
                border: 1px solid #000;
                border-width: 25px 0 23px 12px;
                border-top-color: transparent;
                border-bottom-color: transparent;
                font-size: 0;
                border-left-color: <?php echo htmlspecialchars($_user['third_color']); ?>;
                line-height: 0;
                position: relative;
                bottom: -11px;
            }

            #top-channel-section, #lower-part-channel, .www-channel-top, .www-channel-two-left, .www-channel-two-right, #www-grid, .channel-box-profle, .channel-box-no-bg, #info-panel, #favorite-panel, #playlist-panel, #addto-panel, #flag-panel, .www-channel-section, .channel-box-description {
                border-radius: <?php echo $_user['border_radius']; ?>px !important;
            }
            <?php if (!empty($_user['font'])) { ?>
            .www-core-container {
                font-family: <?php echo strip_tags($_user['font']); ?> !important;
            }
            <?php } ?>
	</style>
<script type="text/javascript">
// preload images
(new Image()).src = "/static/img/full_star.png";
(new Image()).src = "/static/img/half_star.png";
(new Image()).src = "/static/img/empty_star.png";
(new Image()).src = "/static/img/torch.gif";
(new Image()).src = "/static/img/loadingg.gif";
</script>
            <!-- custom css -->
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
            <div style="background-color: white;padding: 5px;border-radius: 5px;margin-top: -8px;border-top-left-radius: 0px;border-top-right-radius: 0px;">
                <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/module/header.php"); ?>
                <script src="/static/js/alert.js?v2"></script>
            </div><br>
            <?php 
            if(isset($_SESSION['siteusername']) && $_SESSION['siteusername'] == $_user['username']) 
                require($_SERVER['DOCUMENT_ROOT'] . "/static/module/channel_new_new_customization.php");
            ?><br>
            <?php $_user['featured_channels'] = explode(",", $_user['featured_channels']); ?>
<?php if ($_user['banner_image_map'] != "") { echo strip_tags($_user['banner_image_map'], "<map><area>"); } ?>
            <?php if(!empty($_user['banner'])) { ?>
                <img src="/dynamic/banners/<?php echo $_user['banner']; ?>" style="width: 970px;" usemap="#imgmap">
            <?php } ?>
            <div id="top-channel-section" style="border-radius:3px;padding:5px;overflow: auto;background-color: <?php echo htmlspecialchars($_user['primary_color']); ?>;opacity: <?php echo htmlspecialchars($_user['transparency']); ?>">
            <div class="www-channel-top" style="overflow: auto;">    
                <div style="background: <?php echo htmlspecialchars($_user['secondary_color']); ?>;color: <?php echo htmlspecialchars($_user['primary_color_text']); ?>;padding: 2px;border-radius: <?php echo $_user['border_radius']; ?>px;">
                    <div class="www-channel-top">
                        <a href="/user/<?php echo htmlspecialchars($_user['username']); ?>">
                        <img class="channel-pfp" src="/dynamic/pfp/<?php echo $_user['pfp']; ?>" style="vertical-align: middle;margin-right: 5px;width: 43px;height: 43px;">
                        </a>
                        <h3 style="display: inline-block;<?php if (isset($banned)) { ?>text-decoration:line-through;color:grey;<?php } else { ?>color:<?php echo htmlspecialchars($_user['primary_color']); ?>;<?php } ?>"><?php echo htmlspecialchars($_user['channel_title']); ?></h3>
                        <?php if(@$_SESSION['siteusername'] != $_user['username']) { ?>
                            <a href="javascript:void(0);" onclick="subscribe();return false;">
                                <button style="margin: 0px;float: none;margin-left: 15px;" class="sub_button"><?php if($_user['subscribed'] == true) { ?>Unsubscribe<?php } else { ?>Subscribe<?php } ?></button>
                            </a>
                            <?php } else { ?>
                            <a href="#">
                                <button style="margin: 0px;float: none;margin-left: 15px;" class="sub_button" onclick="dropdownchannel()">Edit Channel</button>
                            </a>
                        <?php } ?>
                    </div>
                    <div id="channel-top-right-ribb" style="float:right;background: <?php echo htmlspecialchars($_user['secondary_color']); ?>;color: <?php echo htmlspecialchars($_user['primary_color_text']); ?>;display: inline-block;height: 100%;width: 49%;position: relative;bottom: 60px;height: 61px;margin-bottom: -60px;border-bottom-right-radius: <?php echo $_user['border_radius']; ?>px;border-top-right-radius: <?php echo $_user['border_radius']; ?>px;">
                        <div class="right_arrow"></div>
<?php if($_user['videos'] != 0) { ?>
<div style="margin-top: 25px;float: left;">
<a class="videos-button" href="/user/<?php echo htmlspecialchars($_user['username']); ?>" onclick="selectTab('All', <?php echo htmlspecialchars(json_encode($_user['username'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;">All</a>
<a class="videos-button" href="/user/<?php echo htmlspecialchars($_user['username']); ?>/videos" onclick="selectTab('Videos', <?php echo htmlspecialchars(json_encode($_user['username'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;">Uploads</a>
<a class="videos-button" href="/user/<?php echo htmlspecialchars($_user['username']); ?>/favorites" onclick="selectTab('Favourites', <?php echo htmlspecialchars(json_encode($_user['username'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;">Favourites</a>
<a class="videos-button" href="/user/<?php echo htmlspecialchars($_user['username']); ?>/playlists" onclick="selectTab('Playlists', <?php echo htmlspecialchars(json_encode($_user['username'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;">Playlists</a>
</div>
<?php } ?>
                            <div <?php if($_user['videos'] != 0) { ?>style="margin-top: 22px;"<?php } else { ?>style="margin-top: 22px;margin-left: 33px;"<?php } ?>>
                            <?php if($_user['videos'] != 0) { ?>
                            <style>
                                .view-button .contents {
                                    position: relative;
                                    top: 5px;
                                    left: 5px;
                                }

                                .box {
                                    width: 16px;
                                    height: 11px;
                                    left: 0;
                                    top: 0;
                                }

                                .tri {
                                    position: absolute;
                                    top: 2px;
                                    left: 7px;
                                    width: 1px;
                                    height: 1px;
                                    border-width: 3px;
                                        border-right-width: 3px;
                                    border-style: solid;
                                        border-right-style: solid;
                                    border-right: none;
                                }
                                .view-button .a {
                                    position: absolute;
                                    display: block;
                                    font-size: 0;
                                    zoom: 1;
                                    cursor: pointer;
                                }

                                .view-button .xl {
                                    left: 0;
                                }

                                .view-button .a {
                                    background-color: <?php echo htmlspecialchars($_user['third_color']); ?>;
                                    width: 6px;
                                    height: 3px;
                                }

                                .view-button .yt {
                                    top: 0;
                                }

                                .view-button .xc {
                                    left: 7px;
                                }

                                .view-button .xr {
                                    left: 14px;
                                }

                                .view-button .yc {
                                    top: 4px;
                                }

                                .view-button .yb {
                                    top: 8px;
                                }

                                .box {
                                    width: 16px;
                                    height: 11px;
                                    left: 0;
                                    top: 0;
                                }

                                .view-button {
                                    background-color: <?php echo htmlspecialchars($_user['primary_color']); ?>;
                                    box-sizing: border-box;
                                    -webkit-box-sizing: border-box;
                                    -moz-box-sizing: border-box;
                                    position: relative;
                                    width: 31px;
                                    height: 21px;
                                    float: right;
                                    display: block;
                                    margin-right: 7px;
                                    border-radius: 4px;
                                    -moz-border-radius: 4px;
                                    -webkit-border-radius: 4px;
                                    zoom: 1;
                                    top: -3px;
                                }

                                .videos-button {
                                    background-color: <?php echo htmlspecialchars($_user['primary_color']); ?>;
                                    box-sizing: border-box;
                                    -webkit-box-sizing: border-box;
                                    -moz-box-sizing: border-box;
                                    position: relative;
                                    width: auto;
                                    height: 21px;
                                    display: block;
                                    margin-right: 7px;
                                    border-radius: 4px;
                                    -moz-border-radius: 4px;
                                    -webkit-border-radius: 4px;
                                    zoom: 1;
                                    top: -3px;
                                    font-weight: bold;
                                    color: <?php echo htmlspecialchars($_user['third_color']); ?> !important;
                                    padding: 4px 7px;
                                    margin: 0 10px;
                                    display: inline;
                                }

                                .tri {
                                    border-top-color: #5f1718;
                                    border-bottom-color: #5f1718;
                                    background-color: #5f1718;
                                }
                            </style>
                            <a href="javascript:void(0);" onclick="grid();return false;" class="view-button">
                                <div class="contents">
                                    <div class="a yt xl"></div>
                                    <div class="a yt xc"></div>
                                    <div class="a yt xr"></div>
                                    <div class="a yc xl"></div>
                                    <div class="a yc xc"></div>
                                    <div class="a yc xr"></div>
                                    <div class="a yb xl"></div>
                                    <div class="a yb xc"></div>
                                    <div class="a yb xr"></div>
                                </div>
                            </a>
                            <style>
                                .box {
                                    width: 16px;
                                    height: 11px;
                                    left: 0;
                                    top: 0;
                                }

                                .a {
                                    position: absolute;
                                    display: block;
                                    font-size: 0;
                                    zoom: 1;
                                    cursor: pointer;
                                }

                                .tri {
                                    position: absolute;
                                    top: 2px;
                                    left: 7px;
                                    width: 1px;
                                    height: 1px;
                                    border-width: 3px;
                                        border-right-width: 3px;
                                    border-style: solid;
                                        border-right-style: solid;
                                    border-right: none;
                                }

                                .tri {
                                    border-top-color: <?php echo htmlspecialchars($_user['third_color']); ?>;
                                    border-bottom-color: <?php echo htmlspecialchars($_user['third_color']); ?>;
                                    background-color: <?php echo htmlspecialchars($_user['third_color']); ?>;
                                }

                                .yt {
                                    top: 0;
                                }

                                .yc {
                                    top: 4px;
                                }

                                .yb {
                                    top: 8px;
                                }
                            </style>
                            <a href="javascript:void(0);" onclick="main();return false;" class="view-button">
                                <div class="contents" id="test2">
                                    <div class="a box"></div>       
                                    <div class="a tri" style="height: 6px;position: absolute;top: 0;color:<?php echo htmlspecialchars($_user['third_color']); ?>;"></div>
                                    <div class="a yt"></div>
                                    <div class="a yc"></div>
                                    <div class="a yb"></div>
                                </div>
                            </a>
                            <?php } else { ?>
                                <?php echo htmlspecialchars($_user['username']); ?> has no videos available.
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <span id="www-main">
                <?php if($_user['videos'] != 0) { ?>
                <div class="www-channel-two-left">
                    <br>
                    <?php if($_user['featured'] != "None" && $_video_fetch_utils->video_exists($_user['featured'])) { 
                        $video = $_video_fetch_utils->fetch_video_rid($_user['featured']); $videoId = $video['rid'];
                            $video['stars'] = $_video_fetch_utils->get_video_stars($video['rid']) + $_video_fetch_utils->get_video_likes($video['rid']) + $_video_fetch_utils->get_video_dislikes($video['rid']);
                            $video['star_1'] = $_video_fetch_utils->get_video_stars_level($video['rid'], 1) + $_video_fetch_utils->get_video_dislikes($video['rid']);
                            $video['star_2'] = $_video_fetch_utils->get_video_stars_level($video['rid'], 2);
                            $video['star_3'] = $_video_fetch_utils->get_video_stars_level($video['rid'], 3);
                            $video['star_4'] = $_video_fetch_utils->get_video_stars_level($video['rid'], 4);
                            $video['star_5'] = $_video_fetch_utils->get_video_stars_level($video['rid'], 5) + $_video_fetch_utils->get_video_likes($video['rid']);
                            $video['favorited'] = $_user_fetch_utils->if_favorited(@$_SESSION['siteusername'], $video['rid']);

                            //@$_video['star_ratio'] = ($_video['star_1'] + $_video['star_2'] + $_video['star_3'] + $_video['star_4'] + $_video['star_5']) / $_video['stars'];

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
                            <iframe id="watch-player" style="border: 0px; overflow: hidden;" src="/embed/<?php echo $_user['featured']; ?>" height="365" width="646" allowfullscreen="true"></iframe>
                        </center><br>
                        <style>
                            #info {
                                background: transparent url(/static/img/channel-sprites-vfl1Jm6Bm.gif) no-repeat scroll 0 0;
                                margin-top: 2px;
                                margin-left: 9px;
                                vertical-align: text-top;
                                width: 10px;
                                margin-right: 5px;
                                overflow: hidden;
                                background-position: -83px 0;
                                padding: 2px;
                                padding-bottom: 9px;
                            }

                            #favorite {
                                background: transparent url(/static/img/channel-sprites-vfl1Jm6Bm.gif) no-repeat scroll 0 0;
                                margin-top: 2px;
                                margin-left: 9px;
                                vertical-align: text-top;
                                width: 10px;
                                margin-right: 5px;
                                overflow: hidden;
                                background-position: 0 0;
                                padding: 2px;
                                padding-bottom: 9px;
                            }

                            #share {
                                background: transparent url(/static/img/channel-sprites-vfl1Jm6Bm.gif) no-repeat scroll 0 0;
                                margin-top: 2px;
                                margin-left: 9px;
                                vertical-align: text-top;
                                width: 10px;
                                margin-right: 5px;
                                overflow: hidden;
                                background-position: -16px 0;
                                padding: 2px;
                                padding-bottom: 9px;
                            }

                            #addto {
                                background: transparent url(/static/img/channel-sprites-vfl1Jm6Bm.gif) no-repeat scroll 0 0;
                                margin-top: 2px;
                                margin-left: 9px;
                                vertical-align: text-top;
                                width: 10px;
                                margin-right: 5px;
                                overflow: hidden;
                                background-position: -31px 0;
                                padding: 2px;
                                padding-bottom: 9px;
                            }

                            #flag {
                                background: transparent url(/static/img/channel-sprites-vfl1Jm6Bm.gif) no-repeat scroll 0 0;
                                margin-top: 2px;
                                margin-left: 9px;
                                vertical-align: text-top;
                                width: 10px;
                                margin-right: 5px;
                                overflow: hidden;
                                background-position: -50px 0;
                                padding: 2px;
                                padding-bottom: 9px;
                            }

                            #selected {
                                font-weight:bold;
                            }

                            #select-video-options span {
                                position: relative;
                                bottom: 10px;
                            }
                        </style>
                        <div id="select-video-options">
                            <span onclick="selectWatch('#info-panel');" id="selected" style="cursor: pointer;"><img id="info"> Info</span> 
                            <span onclick="selectWatch('#favorite-panel');" style="cursor: pointer;"><img id="favorite"> Favorite</span> 
                            <span onclick="selectWatch('#share-panel');" style="cursor: pointer;"><img id="share"> Share</span>
                            <span onclick="selectWatch('#addto-panel');" style="cursor: pointer;"><img id="addto"> Add to</span>
                            <span onclick="selectWatch('#flag-panel');" style="cursor: pointer;"><img id="flag"> Flag</span>
                        </div>
                        <div id="info-panel" class="featured-video-info" style="min-height: 124px;color: <?php echo htmlspecialchars($_user['text_color']); ?>;width: 100%;border-radius: 3px;background: <?php echo htmlspecialchars($_user['primary_color']); ?>;">
                            <div style="float:right;background-color: white;padding: 1px;border-radius: 3px;">
                    <a href="javascript:void(0);" onclick="rate(1);return false;"><img id="star_1" src="/static/img/<?php echo ($video['star_ratio']>=1)?'full':(($video['star_ratio']>=0.5)?'half':'empty'); ?>_star.png"></a>
                    <a href="javascript:void(0);" onclick="rate(2);return false;"><img id="star_2" src="/static/img/<?php echo ($video['star_ratio']>=2)?'full':(($video['star_ratio']>=1.5)?'half':'empty'); ?>_star.png"></a>
                    <a href="javascript:void(0);" onclick="rate(3);return false;"><img id="star_3" src="/static/img/<?php echo ($video['star_ratio']>=3)?'full':(($video['star_ratio']>=2.5)?'half':'empty'); ?>_star.png"></a>
                    <a href="javascript:void(0);" onclick="rate(4);return false;"><img id="star_4" src="/static/img/<?php echo ($video['star_ratio']>=4)?'full':(($video['star_ratio']>=3.5)?'half':'empty'); ?>_star.png"></a>
                    <a href="javascript:void(0);" onclick="rate(5);return false;"><img id="star_5" src="/static/img/<?php echo ($video['star_ratio']>=5)?'full':(($video['star_ratio']>=4.5)?'half':'empty'); ?>_star.png"></a>
                            </div>
                            <span id="ratetext" style="float:right;"><?php echo $video['stars']; ?> ratings&nbsp;</span>
                            <h2><a id="vidtite" style="color: <?php echo htmlspecialchars($_user['text_color']); ?>;" href="/watch?v=<?php echo htmlspecialchars($video['rid']); ?>"><?php echo htmlspecialchars($video['title']);  ?></a></h2>
                            From: <a id="vidauth" style="color: <?php echo htmlspecialchars($_user['text_color']); ?>;" href="/user/<?php echo htmlspecialchars($video['author']); ?>">
                            <?php echo htmlspecialchars($video['author']); ?>
                                </a>
                                 | <span id="uploaded-date"><?php echo date("M d, Y", strtotime($video['publish'])); ?></span> | <span id="viewc"><?php echo $_video_fetch_utils->fetch_video_views($video['rid']); ?> views</span>
                                <br>
                            <p id="viddesc" class="viddes" style="font-size: 10px;">
                                <?php echo $_video_fetch_utils->parseTextDescription($video['description']); ?>
                            </p>
                            <a href="/watch?v=<?php echo $video['rid']; ?>" id="playnav-watch-link">View comments, related videos, and more</a>
                        </div>

                        <div id="favorite-panel" class="featured-video-info" style="display: none;min-height: 124px;color: <?php echo htmlspecialchars($_user['text_color']); ?>;width: 100%;border-radius: 3px;background: <?php echo htmlspecialchars($_user['primary_color']); ?>;">
                            <?php if(!isset($_SESSION['siteusername'])) { ?>
                            <div class="benifits-outer-front">
                                <div class="benifits-inner-front">
                                    <b>Want to favorite this video?</b><br>
                                    <a href="/sign_up">Sign up for a WrapperTube Account</a>
                                </div>
                            </div>
                            <?php } else { ?>
                                <div class="benifits-outer-front">
                                    <div class="benifits-inner-front">
                                        <?php if($video['favorited'] == false) { ?>
                                            <a id="fav" href="javascript:void(0);" onclick="toggle_favourite();return false;"><h3>Favorite Video</h3></a>
                                        <?php } else { ?>
                                            <a id="fav" href="javascript:void(0);" onclick="toggle_favourite();return false;"><h3>Unfavorite Video</h3></a>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <div id="playlist-panel" class="featured-video-info" style="display: none;min-height: 124px;color: <?php echo htmlspecialchars($_user['text_color']); ?>;width: 100%;border-radius: 3px;background: <?php echo htmlspecialchars($_user['primary_color']); ?>;">
                            <a href="#">MySpace</a> 
                            <a href="//twitter.com/intent/tweet?url=http://wrappertube.org/watch?v=<?php echo $video['rid']; ?>&text=<?php echo htmlspecialchars($video['title']); ?>&related=WrapperTube" target="_blank">Twitter</a> 
                            <a href="//reddit.com/submit?title=<?php echo htmlspecialchars($video['title']); ?>&url=http://wrappertube.org/watch?v=<?php echo $video['rid']; ?>" target="_blank">Reddit</a> 
                            <a href="//facebook.com/sharer/sharer?u=http://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwrappertube.org/watch?v=<?php echo $video['rid']; ?>" target="_blank">Facebook</a>
                            <hr class="thin-line">
                            <b>Paste this link into an email or instant message: </b><input name="video_link" id="watch-url-field" type="text" value="http://wrappertube.org/watch?v=<?php echo $video['rid']; ?>" style="width: 250px;" readonly="" onclick="this.focus();this.select();">
                        </div>

                        <div id="addto-panel" class="featured-video-info" style="display: none;min-height: 124px;color: <?php echo htmlspecialchars($_user['text_color']); ?>;width: 100%;border-radius: 3px;background: <?php echo htmlspecialchars($_user['primary_color']); ?>;">
                            <?php if(!isset($_SESSION['siteusername'])) { ?>
                            <div class="benifits-outer-front">
                                <div class="benifits-inner-front">
                                    <b>Want to add this video to a playlist?</b><br>
                                    <a href="/sign_up">Sign up for a WrapperTube Account</a>
                                </div>
                            </div>
                            <?php } else { ?>
                                        <h3>Add to Quicklist</h3>
                                        <a href="javascript:void(0);" onclick="add_to_quicklist();return false;">Add to Quicklist</a><br>
                                        <br>
					<h3>Add to Playlist</h3>
                                                                    <?php
                                        $stmt99 = $conn->prepare("SELECT * FROM playlists WHERE author = ? ORDER BY id DESC LIMIT 20");
                                        $stmt99->bind_param("s", $_SESSION['siteusername']);
                                        $stmt99->execute();
                                        $result99 = $stmt99->get_result();
                                    ?>
                                    <?php
                                        while($playlist99 = $result99->fetch_assoc()) { 
                                            $buffer = json_decode($playlist99['videos']);
                                            @$rid = $buffer[0];
                                            if(!empty($rid)) {
                                                @$video99 = $_video_fetch_utils->fetch_video_rid($rid);
                                            } else {
                                                $video99['thumbnail'] = "";
                                                $video99['duration'] = 0;
                                            }

                                            $videos99 = count($buffer);
                                    ?>
                                        <a href="javascript:void(0);" onclick="add_to_playlist('<?php echo $playlist99['rid']; ?>');return false;">Add to <?php echo htmlspecialchars($playlist99['title']); ?></a><br>
                                    <?php } $stmt99->close(); ?>
				   <br>
                                        <h3>Add to a Group</h3>
                                                                    <?php
                                        $stmt99 = $conn->prepare("SELECT * FROM group_members WHERE username = ? ORDER BY id DESC LIMIT 20");
                                        $stmt99->bind_param("s", $_SESSION['siteusername']);
                                        $stmt99->execute();
                                        $result99 = $stmt99->get_result();
                                    ?>
                                    <?php
                                        while($playlist99 = $result99->fetch_assoc()) {
                                            $playlist99 = $_video_fetch_utils->fetch_group_id($playlist99['togroup']);
                                    ?>
                                        <a href="javascript:void(0);" onclick="add_to_group('<?php echo $playlist99['id']; ?>');return false;">Add to <?php echo htmlspecialchars($playlist99['group_title']); ?></a><br>
                                    <?php } $stmt99->close(); ?>
                            <?php } ?>
                        </div>

                        <div id="flag-panel" class="featured-video-info" style="display: none;min-height: 124px;color: <?php echo htmlspecialchars($_user['text_color']); ?>;width: 100%;border-radius: 3px;background: <?php echo htmlspecialchars($_user['primary_color']); ?>;">
                            <?php if(!isset($_SESSION['siteusername'])) { ?>
                            <div class="benifits-outer-front">
                                <div class="benifits-inner-front">
                                    <b>Want to flag this video?</b><br>
                                    <a href="/sign_up">Sign up for a WrapperTube Account</a>
                                </div>
                            </div>
                            <?php } else { ?>
                                <div class="benifits-outer-front">
                                    <div class="benifits-inner-front">
                                    By clicking on the link below, you agree that this video is actually breaking the rules in our <a href="/t/community_guidelines">Community Guidelines</a>.<br><br>

                                    <a id="reportlink" href="/report?v=<?php echo $video['rid']; ?>" target="_blank">Report Video</a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <?php 
                            $video = $_video_fetch_utils->fetch_latest_video($_user['username']); $videoId = $video['rid']; 
                            $video['stars'] = $_video_fetch_utils->get_video_stars($video['rid']) + $_video_fetch_utils->get_video_likes($video['rid']) + $_video_fetch_utils->get_video_dislikes($video['rid']);
                            $video['star_1'] = $_video_fetch_utils->get_video_stars_level($video['rid'], 1) + $_video_fetch_utils->get_video_dislikes($video['rid']);
                            $video['star_2'] = $_video_fetch_utils->get_video_stars_level($video['rid'], 2);
                            $video['star_3'] = $_video_fetch_utils->get_video_stars_level($video['rid'], 3);
                            $video['star_4'] = $_video_fetch_utils->get_video_stars_level($video['rid'], 4);
                            $video['star_5'] = $_video_fetch_utils->get_video_stars_level($video['rid'], 5) + $_video_fetch_utils->get_video_likes($video['rid']);
                            $video['favorited'] = $_user_fetch_utils->if_favorited(@$_SESSION['siteusername'], $video['rid']);

                            //@$_video['star_ratio'] = ($_video['star_1'] + $_video['star_2'] + $_video['star_3'] + $_video['star_4'] + $_video['star_5']) / $_video['stars'];

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
                            <iframe id="watch-player" style="border: 0px; overflow: hidden;" src="/embed/<?php echo $video['rid']; ?>" height="365" width="646" allowfullscreen="true"></iframe>
                        </center><br>
                        <style>
                            #info {
                                background: transparent url(/static/img/channel-sprites-vfl1Jm6Bm.gif) no-repeat scroll 0 0;
                                margin-top: 2px;
                                margin-left: 9px;
                                vertical-align: text-top;
                                width: 10px;
                                margin-right: 5px;
                                overflow: hidden;
                                background-position: -83px 0;
                                padding: 2px;
                                padding-bottom: 9px;
                            }

                            #favorite {
                                background: transparent url(/static/img/channel-sprites-vfl1Jm6Bm.gif) no-repeat scroll 0 0;
                                margin-top: 2px;
                                margin-left: 9px;
                                vertical-align: text-top;
                                width: 10px;
                                margin-right: 5px;
                                overflow: hidden;
                                background-position: 0 0;
                                padding: 2px;
                                padding-bottom: 9px;
                            }

                            #share {
                                background: transparent url(/static/img/channel-sprites-vfl1Jm6Bm.gif) no-repeat scroll 0 0;
                                margin-top: 2px;
                                margin-left: 9px;
                                vertical-align: text-top;
                                width: 10px;
                                margin-right: 5px;
                                overflow: hidden;
                                background-position: -16px 0;
                                padding: 2px;
                                padding-bottom: 9px;
                            }

                            #addto {
                                background: transparent url(/static/img/channel-sprites-vfl1Jm6Bm.gif) no-repeat scroll 0 0;
                                margin-top: 2px;
                                margin-left: 9px;
                                vertical-align: text-top;
                                width: 10px;
                                margin-right: 5px;
                                overflow: hidden;
                                background-position: -31px 0;
                                padding: 2px;
                                padding-bottom: 9px;
                            }

                            #flag {
                                background: transparent url(/static/img/channel-sprites-vfl1Jm6Bm.gif) no-repeat scroll 0 0;
                                margin-top: 2px;
                                margin-left: 9px;
                                vertical-align: text-top;
                                width: 10px;
                                margin-right: 5px;
                                overflow: hidden;
                                background-position: -50px 0;
                                padding: 2px;
                                padding-bottom: 9px;
                            }

                            #selected {
                                font-weight:bold;
                            }

                            #select-video-options span {
                                position: relative;
                                bottom: 10px;
                            }
                        </style>
                        <div id="select-video-options">
                            <span onclick="selectWatch('#info-panel');" id="selected" style="cursor: pointer;"><img id="info"> Info</span> 
                            <span onclick="selectWatch('#favorite-panel');" style="cursor: pointer;"><img id="favorite"> Favorite</span> 
                            <span onclick="selectWatch('#share-panel');" style="cursor: pointer;"><img id="share"> Share</span>
                            <span onclick="selectWatch('#addto-panel');" style="cursor: pointer;"><img id="addto"> Add to</span>
                            <span onclick="selectWatch('#flag-panel');" style="cursor: pointer;"><img id="flag"> Flag</span>
                        </div>
                        <div id="info-panel" class="featured-video-info" style="min-height: 124px;color: <?php echo htmlspecialchars($_user['text_color']); ?>;width: 100%;border-radius: 3px;background: <?php echo htmlspecialchars($_user['primary_color']); ?>;">
                            <div style="float:right;background-color: white;padding: 1px;border-radius: 3px;">
                    <a href="javascript:void(0);" onclick="rate(1);return false;"><img id="star_1" src="/static/img/<?php echo ($video['star_ratio']>=1)?'full':(($video['star_ratio']>=0.5)?'half':'empty'); ?>_star.png"></a>
                    <a href="javascript:void(0);" onclick="rate(2);return false;"><img id="star_2" src="/static/img/<?php echo ($video['star_ratio']>=2)?'full':(($video['star_ratio']>=1.5)?'half':'empty'); ?>_star.png"></a>
                    <a href="javascript:void(0);" onclick="rate(3);return false;"><img id="star_3" src="/static/img/<?php echo ($video['star_ratio']>=3)?'full':(($video['star_ratio']>=2.5)?'half':'empty'); ?>_star.png"></a>
                    <a href="javascript:void(0);" onclick="rate(4);return false;"><img id="star_4" src="/static/img/<?php echo ($video['star_ratio']>=4)?'full':(($video['star_ratio']>=3.5)?'half':'empty'); ?>_star.png"></a>
                    <a href="javascript:void(0);" onclick="rate(5);return false;"><img id="star_5" src="/static/img/<?php echo ($video['star_ratio']>=5)?'full':(($video['star_ratio']>=4.5)?'half':'empty'); ?>_star.png"></a>
                            </div>
                            <span id="ratetext" style="float:right;"><?php echo $video['stars']; ?> ratings&nbsp;</span>
                            <h2><a id="vidtite" style="color: <?php echo htmlspecialchars($_user['text_color']); ?>;" href="/watch?v=<?php echo htmlspecialchars($video['rid']); ?>"><?php echo htmlspecialchars($video['title']);  ?></a></h2>
                            From: <a id="vidauth" style="color: <?php echo htmlspecialchars($_user['text_color']); ?>;" href="/user/<?php echo htmlspecialchars($video['author']); ?>">
                            <?php echo htmlspecialchars($video['author']); ?>
                                </a>
                                 | <span id="uploaded-date"><?php echo date("M d, Y", strtotime($video['publish'])); ?></span> | <span id="viewc"><?php echo $_video_fetch_utils->fetch_video_views($video['rid']); ?> views</span>
                                <br>
                            <p id="viddesc" class="viddes" style="font-size: 10px;">
                                <?php echo $_video_fetch_utils->parseTextDescription($video['description']); ?>
                            </p>
                            <a href="/watch?v=<?php echo $video['rid']; ?>" id="playnav-watch-link">View comments, related videos, and more</a>
                        </div>

                        <div id="favorite-panel" class="featured-video-info" style="display: none;min-height: 124px;color: <?php echo htmlspecialchars($_user['text_color']); ?>;width: 100%;border-radius: 3px;background: <?php echo htmlspecialchars($_user['primary_color']); ?>;">
                            <?php if(!isset($_SESSION['siteusername'])) { ?>
                            <div class="benifits-outer-front">
                                <div class="benifits-inner-front">
                                    <b>Want to favorite this video?</b><br>
                                    <a href="/sign_up">Sign up for a WrapperTube Account</a>
                                </div>
                            </div>
                            <?php } else { ?>
                                <div class="benifits-outer-front">
                                    <div class="benifits-inner-front">
                                        <?php if($video['favorited'] == false) { ?>
                                            <a id="fav" href="javascript:void(0);" onclick="toggle_favourite();return false;"><h3>Favorite Video</h3></a>
                                        <?php } else { ?>
                                            <a id="fav" href="javascript:void(0);" onclick="toggle_favourite();return false;"><h3>Unfavorite Video</h3></a>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <div id="playlist-panel" class="featured-video-info" style="display: none;min-height: 124px;color: <?php echo htmlspecialchars($_user['text_color']); ?>;width: 100%;border-radius: 3px;background: <?php echo htmlspecialchars($_user['primary_color']); ?>;">
                            <a href="#">MySpace</a> 
                            <a href="//twitter.com/intent/tweet?url=http://wrappertube.org/watch?v=<?php echo $video['rid']; ?>&text=<?php echo htmlspecialchars($video['title']); ?>&related=WrapperTube" target="_blank">Twitter</a> 
                            <a href="//reddit.com/submit?title=<?php echo htmlspecialchars($video['title']); ?>&url=http://wrappertube.org/watch?v=<?php echo $video['rid']; ?>" target="_blank">Reddit</a> 
                            <a href="//facebook.com/sharer/sharer?u=http://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwrappertube.org/watch?v=<?php echo $video['rid']; ?>" target="_blank">Facebook</a>
                            <hr class="thin-line">
                            <b>Paste this link into an email or instant message: </b><input name="video_link" id="watch-url-field" type="text" value="http://wrappertube.org/watch?v=<?php echo $video['rid']; ?>" style="width: 250px;" readonly="" onclick="this.focus();this.select();">
                        </div>

                        <div id="addto-panel" class="featured-video-info" style="display: none;min-height: 124px;color: <?php echo htmlspecialchars($_user['text_color']); ?>;width: 100%;border-radius: 3px;background: <?php echo htmlspecialchars($_user['primary_color']); ?>;">
                            <?php if(!isset($_SESSION['siteusername'])) { ?>
                            <div class="benifits-outer-front">
                                <div class="benifits-inner-front">
                                    <b>Want to add this video to a playlist?</b><br>
                                    <a href="/sign_up">Sign up for a WrapperTube Account</a>
                                </div>
                            </div>
                            <?php } else { ?>
                                        <h3>Add to Quicklist</h3>
                                        <a href="javascript:void(0);" onclick="add_to_quicklist();return false;">Add to Quicklist</a><br>
                                        <br>
					<h3>Add to Playlist</h3>
                                                                    <?php
                                        $stmt99 = $conn->prepare("SELECT * FROM playlists WHERE author = ? ORDER BY id DESC LIMIT 20");
                                        $stmt99->bind_param("s", $_SESSION['siteusername']);
                                        $stmt99->execute();
                                        $result99 = $stmt99->get_result();
                                    ?>
                                    <?php
                                        while($playlist99 = $result99->fetch_assoc()) { 
                                            $buffer = json_decode($playlist99['videos']);
                                            @$rid = $buffer[0];
                                            if(!empty($rid)) {
                                                @$video99 = $_video_fetch_utils->fetch_video_rid($rid);
                                            } else {
                                                $video99['thumbnail'] = "";
                                                $video99['duration'] = 0;
                                            }

                                            $videos99 = count($buffer);
                                    ?>
                                        <a href="javascript:void(0);" onclick="add_to_playlist('<?php echo $playlist99['rid']; ?>');return false;">Add to <?php echo htmlspecialchars($playlist99['title']); ?></a><br>
                                    <?php } $stmt99->close(); ?>
				   <br>
                                        <h3>Add to a Group</h3>
                                                                    <?php
                                        $stmt99 = $conn->prepare("SELECT * FROM group_members WHERE username = ? ORDER BY id DESC LIMIT 20");
                                        $stmt99->bind_param("s", $_SESSION['siteusername']);
                                        $stmt99->execute();
                                        $result99 = $stmt99->get_result();
                                    ?>
                                    <?php
                                        while($playlist99 = $result99->fetch_assoc()) {
                                            $playlist99 = $_video_fetch_utils->fetch_group_id($playlist99['togroup']);
                                    ?>
                                        <a href="javascript:void(0);" onclick="add_to_group('<?php echo $playlist99['id']; ?>');return false;">Add to <?php echo htmlspecialchars($playlist99['group_title']); ?></a><br>
                                    <?php } $stmt99->close(); ?>
                            <?php } ?>
                        </div>

                        <div id="flag-panel" class="featured-video-info" style="display: none;min-height: 124px;color: <?php echo htmlspecialchars($_user['text_color']); ?>;width: 100%;border-radius: 3px;background: <?php echo htmlspecialchars($_user['primary_color']); ?>;">
                            <?php if(!isset($_SESSION['siteusername'])) { ?>
                            <div class="benifits-outer-front">
                                <div class="benifits-inner-front">
                                    <b>Want to flag this video?</b><br>
                                    <a href="/sign_up">Sign up for a WrapperTube Account</a>
                                </div>
                            </div>
                            <?php } else { ?>
                                <div class="benifits-outer-front">
                                    <div class="benifits-inner-front">
                                    By clicking on the link below, you agree that this video is actually breaking the rules in our <a href="/t/community_guidelines">Community Guidelines</a>.<br><br>

                                    <a id="reportlink" href="/report?v=<?php echo $video['rid']; ?>" target="_blank">Report Video</a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>

                <script>

                </script>
                <div class="www-channel-two-right">
                    <div id="html-sidebar" class="www-channel-section" style="margin-top: 13px;overflow-y: auto;height: 545px;">
                                                <h3 style="display: inline-block;color: white;">Uploads (<?php echo $_user['videos']; ?>)</h3><br><br>
                        <?php
                            $stmt = $conn->prepare("SELECT rid, title, thumbnail, duration, title, author, publish, description FROM videos WHERE author = ? AND visibility = 'n' ORDER BY id DESC LIMIT 3");
                            $stmt->bind_param("s", $_user['username']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while($video = $result->fetch_assoc()) {
                        ?>
                            <div class="video-item-watch">
                                <a href="/watch?v=<?php echo $video['rid']; ?>" onclick="playVideo(<?php echo htmlspecialchars(json_encode($video['rid'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;" class="thumbnail" style="background-image: url(/dynamic/thumbs/<?php echo $video['thumbnail']; ?>), url('/dynamic/thumbs/default.png');">
                                    <span class="timestamp"><?php echo $_video_fetch_utils->timestamp($video['duration']); ?></span></a>

                                <div class="video-info-watch">
                                    <a style="color: <?php echo htmlspecialchars($_user['text_color']); ?>;" href="/watch?v=<?php echo $video['rid']; ?>" onclick="playVideo(<?php echo htmlspecialchars(json_encode($video['rid'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;"><b><?php echo htmlspecialchars($video['title']); ?></b></a><br>
                                    <span class="video-info-small-wide">
                                        <span style="color: <?php echo htmlspecialchars($_user['primary_color_text']); ?>;" class="video-views"><?php echo $_video_fetch_utils->fetch_video_views($video['rid']); ?> views</span><br>
                                        <a style="padding-left: 0px;color: <?php echo htmlspecialchars($_user['text_color']); ?>;" class="video-author-wide" href="/user/<?php echo htmlspecialchars($video['author']); ?>"><?php echo htmlspecialchars($video['author']); ?></a>
                                    </span>
                                </div>

                            </div>
                        <?php } $stmt->close(); ?>
<div class="playnav-more"><a class="channel-cmd" href="/user/<?php echo htmlspecialchars($_user['username']); ?>/videos" onclick="selectTab('Videos',<?php echo htmlspecialchars(json_encode($_user['username'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;">see all</a></div>
                        <hr class="thin-line">
                        <?php if($_user['favorites'] != 0) { ?>
                            <h3 style="display: inline-block;color: white;">Favourites (<?php echo $_user['favorites']; ?>)</h3><br><br>
                        <?php } ?>
                        <?php
                            $stmt = $conn->prepare("SELECT reciever FROM favorite_video WHERE sender = ? ORDER BY id DESC LIMIT 3");
                            $stmt->bind_param("s", $_user['username']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while($video = $result->fetch_assoc()) {
                                $video = $_video_fetch_utils->fetch_video_rid($video['reciever']);
                                if($_video_fetch_utils->video_exists($video['rid'])) { ?>
                                    <div class="video-item-watch">
                                        <a href="/watch?v=<?php echo $video['rid']; ?>" class="thumbnail" style="
                                            background-image: url(/dynamic/thumbs/<?php echo $video['thumbnail']; ?>), url('/dynamic/thumbs/default.png');" onclick="playVideo(<?php echo htmlspecialchars(json_encode($video['rid'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;">
                                            <a class="quicklist-add" style="top: 30px;" href="javascript:void(0);" onclick="add_video_to_quicklist('<?php echo $video['rid']; ?>');return false;"></a>
                                            <span class="timestamp"><?php echo $_video_fetch_utils->timestamp($video['duration']); ?></span></a>

                                        <div class="video-info-watch">
                                            <a style="color: <?php echo htmlspecialchars($_user['text_color']); ?>;" href="/watch?v=<?php echo $video['rid']; ?>" onclick="playVideo(<?php echo htmlspecialchars(json_encode($video['rid'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;"><b><?php echo htmlspecialchars($video['title']); ?></b></a><br>
                                            <span class="video-info-small-wide">
                                                <span class="video-views"><?php echo $_video_fetch_utils->fetch_video_views($video['rid']); ?> views</span><br>
                                                <a style="padding-left: 0px;color: <?php echo htmlspecialchars($_user['text_color']); ?>;" class="video-author-wide" href="/user/<?php echo htmlspecialchars($video['author']); ?>"><?php echo htmlspecialchars($video['author']); ?></a>
                                            </span>
                                        </div>

                                    </div>
                        <?php } } $stmt->close(); ?>
                        <?php if($_user['favorites'] != 0) { ?>
<div class="playnav-more"><a class="channel-cmd" href="/user/<?php echo htmlspecialchars($_user['username']); ?>/favorites" onclick="selectTab('Favourites',<?php echo htmlspecialchars(json_encode($_user['username'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;">see all</a></div>
<hr class="thin-line">
<?php } ?>
                        <?php if($_user['playlists'] != 0) { ?>
                        <h3 style="display: inline-block;color: white;">Playlists (<?php echo $_user['playlists']; ?>)</h3><br><br>
                        <?php } ?>
                        <?php
                                                        $stmt = $conn->prepare("SELECT * FROM playlists WHERE author = ? AND visibility = 'n' ORDER BY id DESC LIMIT 3");
                            $stmt->bind_param("s", $_user['username']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while($video = $result->fetch_assoc()) {
$playlist_videos = json_decode($video['videos']);
$the_video = $playlist_videos[0];
if ($the_video && $_video_fetch_utils->video_exists($the_video) ) {
$the_video = $_video_fetch_utils->fetch_video_rid($the_video);
$thumb = $the_video['thumbnail'];
} else {
$thumb = "default.jpg";
}



                        ?>
                            <div class="video-item-watch">
                                <a href="/view_playlist?v=<?php echo $video['rid']; ?>" onclick="open_playlist(<?php echo htmlspecialchars(json_encode($video['rid'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>, <?php echo htmlspecialchars(json_encode($_user['username'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;" class="thumbnail" style="background-image: url(/dynamic/thumbs/<?php echo $thumb; ?>), url('/dynamic/thumbs/default.png');">
                                    <span class="timestamp"><?php echo count($playlist_videos); ?> videos</span></a>

                                <div class="video-info-watch">
                                    <a style="color: <?php echo htmlspecialchars($_user['text_color']); ?>;" href="/view_playlist?v=<?php echo $video['rid']; ?>" onclick="open_playlist(<?php echo htmlspecialchars(json_encode($video['rid'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>, <?php echo htmlspecialchars(json_encode($_user['username'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;"><b><?php echo htmlspecialchars($video['title']); ?></b></a><br>
                                    <span class="video-info-small-wide">
                                        <span style="color: <?php echo htmlspecialchars($_user['primary_color_text']); ?>;" class="video-views"><?php echo date("M d, Y", strtotime($video['created'])); ?></span><br>
                                        <a style="padding-left: 0px;color: <?php echo htmlspecialchars($_user['text_color']); ?>;" class="video-author-wide" href="/user/<?php echo htmlspecialchars($video['author']); ?>"><?php echo htmlspecialchars($video['author']); ?></a>
                                    </span>
                                </div>

                            </div>
                        <?php } $stmt->close(); ?>
                        <?php if($_user['playlists'] != 0) { ?>
<div class="playnav-more"><a class="channel-cmd" href="/user/<?php echo htmlspecialchars($_user['username']); ?>/playlists" onclick="selectTab('Playlists',<?php echo htmlspecialchars(json_encode($_user['username'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;">see all</a></div>
<?php } ?>
                    </div>
                </div>
                </span>
                <span id="www-grid" style="display: none;">
                <div id="html-grid" style="height: 525px;display: block;overflow-y: auto;color: <?php echo htmlspecialchars($_user['primary_color_text']); ?>;padding-top: 8px;">
                </div>
                </span>
            </div>
            <?php } else { ?>
                <?php if(isset($_SESSION['siteusername']) && $_SESSION['siteusername'] == $_user['username'] && $_user['videos'] == 0) { ?>
                    <div style="color: <?php echo htmlspecialchars($_user['primary_color_text']); ?>;padding: 5px;border: 2px solid <?php echo htmlspecialchars($_user['secondary_color']); ?>;position: relative;bottom: 3px;">
                        <h1>Welcome to your WrapperTube channel!</h1>
                        You can:<br>
                        •  Upload videos, favorite others' videos, or group videos into playlists -- they'll all show up here for your channel viewers to watch and enjoy.<br>
                        •  Customize the look and feel of your channel by clicking the "Edit Channel" buttons at the top of the page or "edit" links thoughout the channel.<br>
                    </div>
                <?php } ?>
            </div>
            <?php } ?>
            </div>
            <br>
            
            <div id="lower-part-channel" style="border-radius:3px;padding:5px;overflow: auto;background-color: <?php echo htmlspecialchars($_user['primary_color']); ?>;opacity: <?php echo htmlspecialchars($_user['transparency']); ?>">
                <div class="www-channel-left">
                    <?php 
                        $_user['module'] = 0;
                        foreach($_user['2009_user_left'] as $module) {
                            $_user['module']++;
                            if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/static/module/channel2/" . clean($module) . ".php")) {
                            echo "<!--mod" . $_user['module'] . "-->";
                            require($_SERVER['DOCUMENT_ROOT'] . "/static/module/channel2/" . clean($module) . ".php");
                            }
                        }
                    ?>
                </div>
                <div class="www-channel-right">
                    <?php 
                        $_user['module'] = 0;
                        foreach($_user['2009_user_right'] as $module) {
                            $_user['module']++;
                            if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/static/module/channel2/" . clean($module) . ".php")) {
                            echo "<!--mod" . $_user['module'] . "-->";
                            require($_SERVER['DOCUMENT_ROOT'] . "/static/module/channel2/" . clean($module) . ".php");
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
        <script type="text/javascript" language="JavaScript">
            <?php
$video = $_video_fetch_utils->fetch_video_rid($videoId);
$video['liked'] = $_video_fetch_utils->fetch_user_rating($video['rid'], $_SESSION['siteusername'])==4 || $_video_fetch_utils->fetch_user_rating($video['rid'], $_SESSION['siteusername'])==5 || $_user_fetch_utils->if_liked_video(@$_SESSION['siteusername'], $videoId);
$video['disliked'] = $_video_fetch_utils->fetch_user_rating($video['rid'], $_SESSION['siteusername'])==1 || $_video_fetch_utils->fetch_user_rating($video['rid'], $_SESSION['siteusername'])==2 || $_user_fetch_utils->if_disliked_video(@$_SESSION['siteusername'], $videoId);
$video['my_rating'] = $_video_fetch_utils->fetch_user_rating($video['rid'], $_SESSION['siteusername'])?$_video_fetch_utils->fetch_user_rating($video['rid'], $_SESSION['siteusername']):($video['liked']?5:($video['disliked']?1:0));
$video['favorited'] = $_user_fetch_utils->if_favorited(@$_SESSION['siteusername'], $video['rid']);
            ?>
            userUserName = <?php echo json_encode($_user['username'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
            currentVideo = <?php echo($video['rid'] ? json_encode($video['rid'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) : "''"); ?>;
            subscribed = <?php echo($_user['subscribed'] ? 'true' : 'false'); ?>;
            liked = <?php echo $video['liked'] ? 'true' : 'false'; ?>;
            disliked = <?php echo $video['disliked'] ? 'true' : 'false'; ?>;
            myRating = <?php echo $video['my_rating'] ?? '0'; ?>;
            loggedIn = <?php echo(isset($_SESSION['siteusername']) ? 'true' : 'false') ?>;
            favourited = <?php echo $video['favorited'] ? 'true' : 'false'; ?>;
            blocked = <?php echo $_user_fetch_utils->if_blocked($_SESSION['siteusername'], $_user['username']) ? 'true' : 'false'; ?>;
            amITrusted = <?php echo $_video_fetch_utils->if_partner($_SESSION['siteusername']) ? 'true' : 'false'; ?>;
            alerts = 0;
        </script>
        <script src='/static/js/channel.js?v25'></script>
        <div id="channelbg">
            &nbsp;
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
