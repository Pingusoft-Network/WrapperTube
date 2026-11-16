<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/insert.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/update.php"); ?>
<?php
    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

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
        if (
              (startsWith($colorCode,'#') || startsWith($colorCode,'rgb(') || startsWith($colorCode,'rgba(')) &&
              (strlen($colorCode) >= 4 && strlen($colorCode) <= 30))
                   return true;

        else return false;
    }

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

    if(!$_user_fetch_utils->user_exists($_GET['username']))
        die();

    if(isset($_SESSION['siteusername']) && !$_user_fetch_utils->user_exists(@$_SESSION['siteusername']))
        die();





    $_user = $_user_fetch_utils->fetch_user_username($_GET['username']);

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
?>
<?php 
$video = $_video_fetch_utils->fetch_playlist_rid($_GET['id']);

if (!$video) { die(); }

        if($video['visibility'] == "v" && @$_SESSION['siteusername'] != $video['author'] && (!$_video_fetch_utils->is_admin($_SESSION['siteusername']) && !$_video_fetch_utils->is_moderator($_SESSION['siteusername']))) {
                die();
        }

$playlist_videos = json_decode($video['videos']);
?>
<div style="position:absolute;width:285px;height:545px">
<div id="playlist-info" style="padding: 6px 6px 0px 6px;height: 24%;">
<a href="/user/<?php echo $_GET['username']; ?>/playlists" style="border-bottom: 1px dotted;text-decoration: none!important;display: inline-block;margin-bottom: 4px;color: <?php echo htmlspecialchars($_user['primary_color_text']); ?>;" onmousedown="selectTab('Playlists',<?php echo htmlspecialchars(json_encode($_GET['username'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);">« Back to Playlists</a><br>
                        <h3 style="display: inline-block;color: white;"><?php echo $video['title']; ?></h3>
<p><?php echo $_video_fetch_utils->parseTextDescription($video['description']); ?></p>
<div style="text-align:right;">
                                    <a href="/view_playlist?v=<?php echo $_GET['id']; ?>" style="border-bottom: 1px dotted;text-decoration: none!important;display: inline-block;margin-bottom: 4px;color: <?php echo htmlspecialchars($_user['primary_color_text']); ?>;">more info</a>
                                </div>
</div>
<hr class="thin-line">
<div style="overflow-y:auto;height:73%;">
                        <?php
foreach($playlist_videos as $video) {
$video6 = $_video_fetch_utils->fetch_video_rid($video);
if ($video6) {
                        ?>
                            <div class="video-item-watch">
                                <a href="/watch?v=<?php echo $video6['rid']; ?>" onclick="playVideo(<?php echo htmlspecialchars(json_encode($video6['rid'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;" class="thumbnail" style="background-image: url(/dynamic/thumbs/<?php echo $video6['thumbnail']; ?>), url('/dynamic/thumbs/default.png');">
                                    <span class="timestamp"><?php echo $_video_fetch_utils->timestamp($video6['duration']); ?></span></a>
                                
                                <div class="video-info-watch">
                                    <a style="color: <?php echo htmlspecialchars($_user['text_color']); ?>;" href="/watch?v=<?php echo $video6['rid']; ?>" onclick="playVideo(<?php echo htmlspecialchars(json_encode($video6['rid'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;"><b><?php echo htmlspecialchars($video6['title']); ?></b></a><br>
                                    <span class="video-info-small-wide">
                                        <span style="color: <?php echo htmlspecialchars($_user['primary_color_text']); ?>;" class="video-views"><?php echo $_video_fetch_utils->fetch_video_views($video6['rid']); ?> views</span><br>
                                        <a style="padding-left: 0px;color: <?php echo htmlspecialchars($_user['text_color']); ?>;" class="video-author-wide" href="/user/<?php echo htmlspecialchars($video6['author']); ?>"><?php echo htmlspecialchars($video6['author']); ?></a>
                                    </span>
                                </div>
                                
                            </div>
                        <?php } ?>
<?php } ?>
</div>
</div>
