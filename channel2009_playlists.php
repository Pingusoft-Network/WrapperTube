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
    $_user_fetch_utils->initialize_db_var($conn);
    $_user_insert_utils->initialize_db_var($conn);
    $_video_insert_utils->initialize_db_var($conn);

if (!startsWith($_SERVER['REQUEST_URI'], "/user/")) {
die(header("Location: /user/" . $_GET['n'] . "/playlists"));
}

    if(!$_user_fetch_utils->user_exists($_GET['n']))
        die(header("Location: /?userdoesntexist"));


    $_user = $_user_fetch_utils->fetch_user_username($_GET['n']);
$bann = $conn->prepare("SELECT * FROM bans WHERE username = ? LIMIT 1");
$bann->bind_param("s", $_user['username']);
$bann->execute();
$banresult = $bann->get_result();
while($ban = $banresult->fetch_assoc()) {
                $banned = $ban['reason'];
                $_GET['error'] = "This user has been banned until " . ( $ban['real_expire'] ? date("D, M d, Y, h:i A", $ban['real_expire']) : "the end of time" ) . " because of " . $ban['reason'];
}
$bann->close();
    $_user['subscribed'] = $_user_fetch_utils->if_subscribed(@$_SESSION['siteusername'], $_user['username']);
    $_user['dLinks'] = json_decode($_user['links']);
    $_user['subscribers'] = $_user_fetch_utils->fetch_subs_count($_user['username']);
    $_user['videos'] = $_user_fetch_utils->fetch_user_videos($_user['username']);
    $_user['favorites'] = $_user_fetch_utils->fetch_user_favorites($_user['username']);
    $_user['playlists'] = $_user_fetch_utils->fetch_user_playlists($_user['username']);
    $_user['subscriptions'] = $_user_fetch_utils->fetch_subscriptions($_user['username']);
    $_user['custom_header'] = ($_user['custom_header'])?($_user['custom_header']):($_user['username']."'s Channel");
    $_user['contact_custom_text'] = ($_user['contact_custom_text'])?($_user['contact_custom_text']):("Contact with ".$_user['username']);

    $_user['primary_color'] = strip_tags($_user['primary_color']);
    $_user['secondary_color'] = strip_tags($_user['secondary_color']);
    $_user['third_color'] = strip_tags($_user['third_color']);
    $_user['text_color'] = strip_tags($_user['text_color']);
    $_user['primary_color_text'] = strip_tags($_user['primary_color_text']);
    $_user['2009_bgcolor'] = strip_tags($_user['2009_bgcolor']);
    $_user['2012_bgcolor'] = strip_tags($_user['2012_bgcolor']);


    if(!check_valid_colorhex($_user['primary_color'])) { $_user['primary_color'] = ""; }
    if(!check_valid_colorhex($_user['secondary_color'])) { $_user['secondary_color'] = ""; }
    if(!check_valid_colorhex($_user['third_color'])) { $_user['third_color'] = ""; }
    if(!check_valid_colorhex($_user['text_color'])) { $_user['text_color'] = ""; }
    if(!check_valid_colorhex($_user['primary_color_text'])) { $_user['primary_color_text'] = ""; }
    if(!check_valid_colorhex($_user['2009_bgcolor'])) { $_user['2009_bgcolor'] = ""; }
    if(!check_valid_colorhex($_user['2012_bgcolor'])) { $_user['2012_bgcolor'] = ""; }

    $_base_utils->initialize_page_compass(htmlspecialchars($_user['username']));
    $_video_insert_utils->check_view_channel($_user['username'], @$_SESSION['siteusername']);

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
        <script>function onLogin(token){ document.getElementById('submitform').submit(); }</script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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
            <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/module/channel_header.php"); ?><br>
            <?php 
            if(isset($_SESSION['siteusername']) && $_SESSION['siteusername'] == $_user['username']) 
                require($_SERVER['DOCUMENT_ROOT'] . "/static/module/channel_customization.php");
            ?>
           <center>
                                                <?php if ($_user['banner_image_map'] != "") { echo strip_tags($_user['banner_image_map'], "<map><area>"); } ?>
                                                <?php if ($_user['banner'] != "") { ?><img usemap="#imgmap" class="ytg-wide branded-banner-image" src="/dynamic/banners/<?php echo htmlspecialchars($_user['banner']); ?>" width="970"><?php } ?>
           </center>
            <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/module/channel_top.php"); ?>
          

                <?php if($_user['playlists'] != 0) { ?>
                <div class="channel-box-profle" style="opacity: <?php echo htmlspecialchars($_user['transparency']); ?>;">
                    <div class="channel-box-top" style="height: 12px;">
                        <h3 class="h3title" style="display: inline-block;">Playlists (<?php echo $_user['playlists']; ?>)</h3>
                    </div>
                    <div class="channel-box-no-bg">
                            <?php
                            $results_per_page = 20;

                            $stmt = $conn->prepare("SELECT count(*) FROM playlists WHERE author = ? AND visibility = 'n'");
                            $stmt->bind_param("s", $_GET['n']);
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

                            $stmt = $conn->prepare("SELECT * FROM playlists WHERE author = ? AND visibility = 'n' ORDER BY id DESC LIMIT ?, ?");
                            $stmt->bind_param("sss", $_GET['n'], $page_first_result, $results_per_page);
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
					</div>
				</td>
				</tr>
			</tbody></table>
		</div>
                        <?php } ?>
                        <center>
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
                        </center>  
                    </div>
                </div><br>
                <?php } $stmt->close(); ?>

            </div>
        </div>
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
</script>
        <script src="/static/js/prefixfree.min.js"></script>
    </body>
</html>
