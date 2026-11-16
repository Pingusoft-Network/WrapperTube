<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/insert.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/update.php"); ?>
<?php
/*
    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }
*/
/*
    function check_valid_colorhex($colorCode) {
        if (preg_match('/(#(?:[0-9a-f]{2}){2,4}$|(#[0-9a-f]{3}$)|(rgb|hsl)a?\((-?\d+%?[,\s]+){2,3}\s*[\d\.]+%?\)$|black$|silver$|gray$|whitesmoke$|maroon$|red$|purple$|fuchsia$|green$|lime$|olivedrab$|yellow$|navy$|blue$|teal$|aquamarine$|orange$|aliceblue$|antiquewhite$|aqua$|azure$|beige$|bisque$|blanchedalmond$|blueviolet$|brown$|burlywood$|cadetblue$|chartreuse$|chocolate$|coral$|cornflowerblue$|cornsilk$|crimson$|currentcolor$|darkblue$|darkcyan$|darkgoldenrod$|darkgray$|darkgreen$|darkgrey$|darkkhaki$|darkmagenta$|darkolivegreen$|darkorange$|darkorchid$|darkred$|darksalmon$|darkseagreen$|darkslateblue$|darkslategray$|darkslategrey$|darkturquoise$|darkviolet$|deeppink$|deepskyblue$|dimgray$|dimgrey$|dodgerblue$|firebrick$|floralwhite$|forestgreen$|gainsboro$|ghostwhite$|goldenrod$|gold$|greenyellow$|grey$|honeydew$|hotpink$|indianred$|indigo$|ivory$|khaki$|lavenderblush$|lavender$|lawngreen$|lemonchiffon$|lightblue$|lightcoral$|lightcyan$|lightgoldenrodyellow$|lightgray$|lightgreen$|lightgrey$|lightpink$|lightsalmon$|lightseagreen$|lightskyblue$|lightslategray$|lightslategrey$|lightsteelblue$|lightyellow$|limegreen$|linen$|mediumaquamarine$|mediumblue$|mediumorchid$|mediumpurple$|mediumseagreen$|mediumslateblue$|mediumspringgreen$|mediumturquoise$|mediumvioletred$|midnightblue$|mintcream$|mistyrose$|moccasin$|navajowhite$|oldlace$|olive$|orangered$|orchid$|palegoldenrod$|palegreen$|paleturquoise$|palevioletred$|papayawhip$|peachpuff$|peru$|pink$|plum$|powderblue$|rosybrown$|royalblue$|saddlebrown$|salmon$|sandybrown$|seagreen$|seashell$|sienna$|skyblue$|slateblue$|slategray$|slategrey$|snow$|springgreen$|steelblue$|tan$|thistle$|tomato$|transparent$|turquoise$|violet$|wheat$|white$|yellowgreen$|rebeccapurple$)/i',$colorCode))
                   return true;

        else return false;
    }
*/
    $_user_fetch_utils = new user_fetch_utils();
    $_video_fetch_utils = new video_fetch_utils();
    $_video_insert_utils = new video_insert_utils();
    $_user_insert_utils = new user_insert_utils();
    $_user_update_utils = new user_update_utils();
    $_base_utils = new config_setup();
    
    $_base_utils->initialize_db_var($conn);
    $_video_fetch_utils->initialize_db_var($conn);
    $_user_fetch_utils->initialize_db_var($conn);
    $_user_insert_utils->initialize_db_var($conn);
    $_user_update_utils->initialize_db_var($conn);
    $_video_insert_utils->initialize_db_var($conn);

if (!startsWith($_SERVER['REQUEST_URI'], "/user/")) {
die(header("Location: /user/" . $_GET['n']));
}

    if(!$_user_fetch_utils->user_exists($_GET['n']))
        die(header("Location: /?userdoesntexist"));

    if(isset($_SESSION['siteusername']) && !$_user_fetch_utils->user_exists(@$_SESSION['siteusername'])) 
        die(header("Location: /logout"));

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
    $_user['friends'] = $_user_fetch_utils->fetch_friends_accepted($_user['username']);
    $_user['playlists'] = $_user_fetch_utils->fetch_user_playlists($_user['username']);

$bann = $conn->prepare("SELECT count(*) FROM group_members WHERE username = ?");
$bann->bind_param("s", $_user['username']);
$bann->execute();
$bann->bind_result($banresult);
$bann->fetch();
$bann->close();

    $_user['groups'] = $banresult;

    $_user['s_2009_user_left'] = $_user['2009_user_left'];
    $_user['s_2009_user_right'] = $_user['2009_user_right'];
    $_user['2009_user_left'] = explode(";", strtolower($_user['2009_user_left']));
    $_user['2009_user_right'] = explode(";", strtolower($_user['2009_user_right']));

    $_user['primary_color'] = strip_tags($_user['primary_color']);
    $_user['secondary_color'] = strip_tags($_user['secondary_color']);
    $_user['third_color'] = strip_tags($_user['third_color']);
    $_user['text_color'] = strip_tags($_user['text_color']);
    $_user['primary_color_text'] = strip_tags($_user['primary_color_text']);
    $_user['2009_bgcolor'] = strip_tags($_user['2009_bgcolor']);
    $_user['2012_bgcolor'] = strip_tags($_user['2012_bgcolor']);
    $_user['border_color'] = strip_tags($_user['border_color']);

    $_user['channel_title'] = ($_user['custom_header'])?($_user['custom_header']):($_user['username']."'s Channel");
    $_user['custom_header'] = $_user['real_custom_header'];

    $_user['contact_custom_text'] = ($_user['contact_custom_text'])?($_user['contact_custom_text']):("Contact with ".$_user['username']);
    $_user['blocked'] = $_user_fetch_utils->if_blocked(@$_SESSION['siteusername'], $_user['username']);

    $_user['genre'] = strtolower($_user['genre']);

    if(!check_valid_colorhex($_user['primary_color'])) { $_user['primary_color'] = ""; }
    if(!check_valid_colorhex($_user['secondary_color'])) { $_user['secondary_color'] = ""; }
    if(!check_valid_colorhex($_user['third_color'])) { $_user['third_color'] = ""; }
    if(!check_valid_colorhex($_user['text_color'])) { $_user['text_color'] = ""; }
    if(!check_valid_colorhex($_user['primary_color_text'])) { $_user['primary_color_text'] = ""; }
    if(!check_valid_colorhex($_user['2009_bgcolor'])) { $_user['2009_bgcolor'] = ""; }
    if(!check_valid_colorhex($_user['2012_bgcolor'])) { $_user['2012_bgcolor'] = ""; }
    if(!check_valid_colorhex($_user['border_color'])) { $_user['border_color'] = ""; }

    $_base_utils->initialize_page_compass(htmlspecialchars($_user['username']));
    $_video_insert_utils->check_view_channel($_user['username'], @$_SESSION['siteusername']);

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
        if($_user_fetch_utils->if_blocked($_user['username'], $_SESSION['siteusername'])) { $error = "This user has blocked you!"; $error['status'] = true; } 
        if($_user['commenting'] == "n") { $error = "This channel has commenting disabled!"; $error['status'] = true; }

        if(!isset($error['message'])) {
            $stmt = $conn->prepare("INSERT INTO `profile_comments` (toid, author, comment) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $_user['username'], $_SESSION['siteusername'], $text);
            $text = ($_POST['comment']);
            $stmt->execute();
            $stmt->close();

            $_user_update_utils->update_comment_cooldown_time($_SESSION['siteusername']);

            if(@$_SESSION['siteusername'] != $_user['username']) { 
                $_user_insert_utils->send_message($_user['username'], "New comment", 'I commented "' . $_POST['comment'] . '" on your profile!', $_SESSION['siteusername']);
            }
        }
    }

    if($_user['layout'] == "1")
        include($_SERVER['DOCUMENT_ROOT'] . "/static/module/layouts/channel.php");
    else   
        include($_SERVER['DOCUMENT_ROOT'] . "/static/module/layouts/channel_2.php");

?>
