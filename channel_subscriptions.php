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
    function check_valid_colorhex($colorCode) {
        if (preg_match('/(#(?:[0-9a-f]{2}){2,4}$|(#[0-9a-f]{3}$)|(rgb|hsl)a?\((-?\d+%?[,\s]+){2,3}\s*[\d\.]+%?\)$|black$|silver$|gray$|whitesmoke$|maroon$|red$|purple$|fuchsia$|green$|lime$|olivedrab$|yellow$|navy$|blue$|teal$|aquamarine$|orange$|aliceblue$|antiquewhite$|aqua$|azure$|beige$|bisque$|blanchedalmond$|blueviolet$|brown$|burlywood$|cadetblue$|chartreuse$|chocolate$|coral$|cornflowerblue$|cornsilk$|crimson$|currentcolor$|darkblue$|darkcyan$|darkgoldenrod$|darkgray$|darkgreen$|darkgrey$|darkkhaki$|darkmagenta$|darkolivegreen$|darkorange$|darkorchid$|darkred$|darksalmon$|darkseagreen$|darkslateblue$|darkslategray$|darkslategrey$|darkturquoise$|darkviolet$|deeppink$|deepskyblue$|dimgray$|dimgrey$|dodgerblue$|firebrick$|floralwhite$|forestgreen$|gainsboro$|ghostwhite$|goldenrod$|gold$|greenyellow$|grey$|honeydew$|hotpink$|indianred$|indigo$|ivory$|khaki$|lavenderblush$|lavender$|lawngreen$|lemonchiffon$|lightblue$|lightcoral$|lightcyan$|lightgoldenrodyellow$|lightgray$|lightgreen$|lightgrey$|lightpink$|lightsalmon$|lightseagreen$|lightskyblue$|lightslategray$|lightslategrey$|lightsteelblue$|lightyellow$|limegreen$|linen$|mediumaquamarine$|mediumblue$|mediumorchid$|mediumpurple$|mediumseagreen$|mediumslateblue$|mediumspringgreen$|mediumturquoise$|mediumvioletred$|midnightblue$|mintcream$|mistyrose$|moccasin$|navajowhite$|oldlace$|olive$|orangered$|orchid$|palegoldenrod$|palegreen$|paleturquoise$|palevioletred$|papayawhip$|peachpuff$|peru$|pink$|plum$|powderblue$|rosybrown$|royalblue$|saddlebrown$|salmon$|sandybrown$|seagreen$|seashell$|sienna$|skyblue$|slateblue$|slategray$|slategrey$|snow$|springgreen$|steelblue$|tan$|thistle$|tomato$|transparent$|turquoise$|violet$|wheat$|white$|yellowgreen$|rebeccapurple$)/i',$colorCode))
                   return true;

        else return false;
    }


if (!startsWith($_SERVER['REQUEST_URI'], "/user/")) {
die(header("Location: /user/" . $_GET['n'] . "/subscriptions"));
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
          

                <?php if($_user['subscriptions'] != 0) { ?>
                <div class="channel-box-profle" style="opacity: <?php echo htmlspecialchars($_user['transparency']); ?>;">
                    <div class="channel-box-top" style="height: 12px;">
                        <h3 class="h3title" style="display: inline-block;">Subscriptions (<?php echo $_user['subscriptions']; ?>)</h3>
                    </div>
                    <div class="channel-box-no-bg">
                            <?php
                            $results_per_page = 36;

                            $stmt = $conn->prepare("SELECT count(*) FROM subscribers WHERE sender = ?");
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

                            $stmt = $conn->prepare("SELECT * FROM subscribers WHERE sender = ? ORDER BY id DESC LIMIT ?, ?");
                            $stmt->bind_param("sss", $_GET['n'], $page_first_result, $results_per_page);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while($subscriber = $result->fetch_assoc()) {
                                if($_user_fetch_utils->user_exists($subscriber['sender'])) { ?>
                                <div class="grid-item" style="width: 90px;">
                                    <img class="channel-pfp" style="width: 58px; height: 58px;" src="/dynamic/pfp/<?php echo $_user_fetch_utils->fetch_user_pfp($subscriber['reciever']); ?>"><br>
                                    <a style="font-size: 10px;text-decoration: none;" href="/user/<?php echo htmlspecialchars($subscriber['reciever']); ?>"><?php echo htmlspecialchars($subscriber['reciever']); ?></a>
                                </div>
                            <?php } } $stmt->close(); ?>
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
                <?php } ?>

            </div>
        </div>
        <div id="channelbg">
            &nbsp;
        </div>
        <script src="/static/js/prefixfree.min.js"></script>
    </body>
</html>
