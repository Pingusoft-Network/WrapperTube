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
if ($_GET['tab'] == "All") {
?>
<h3 style="display: inline-block;color: white;">Uploads (<?php echo $_user['videos']; ?>)</h3> <a style="float:right;" href="/user/<?php echo htmlspecialchars($_user['username']); ?>" onclick="selectTab('Videos', <?php echo htmlspecialchars(json_encode($_user['username'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;">View All</a><br><br>
                    <?php
                        $stmt = $conn->prepare("SELECT rid, title, thumbnail, duration, title, author, publish, description FROM videos WHERE author = ? AND visibility = 'n' ORDER BY id DESC LIMIT 10");
                        $stmt->bind_param("s", $_user['username']);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while($video = $result->fetch_assoc()) {
                    ?>
                        <div class="grid-item" style="">
                            <a href="/watch?v=<?php echo htmlspecialchars($video['rid']); ?>" onclick="playVideo(<?php echo htmlspecialchars(json_encode($video['rid'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;">
                            <img class="thumbnail" onerror="this.src='/dynamic/thumbs/default.png'" src="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>">
                            </a>
                            <div class="video-info-grid">
                                <a style="color: <?php echo htmlspecialchars($_user['text_color']); ?>;display: inline-block;width: 127px;word-wrap: break-word;" href="/watch?v=<?php echo $video['rid']; ?>" onclick="playVideo(<?php echo htmlspecialchars(json_encode($video['rid'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;"><?php echo $_video_fetch_utils->parse_title($video['title']);  ?></a><br>
                                <span class="video-info-small">
                                    <span class="video-views" style="color: <?php echo htmlspecialchars($_user['text_color']); ?>;"><?php echo $_video_fetch_utils->fetch_video_views($video['rid']); ?> views</span><br>
                                    <a style="color: <?php echo htmlspecialchars($_user['text_color']); ?>;" href="/user/<?php echo htmlspecialchars($video['author']); ?>"><?php echo htmlspecialchars($video['author']); ?></a>
                                </span>
                            </div>
                        </div>
                    <?php } $stmt->close(); ?>
<?php if ($_user['favorites'] > 0) { ?>
<hr class="thin-line">
<h3 style="display: inline-block;color: white;">Favourites (<?php echo $_user['favorites']; ?>)</h3> <a style="float:right;" href="/user/<?php echo htmlspecialchars($_user['username']); ?>/favorites" onclick="selectTab('Favourites', <?php echo htmlspecialchars(json_encode($_user['username'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;">View All</a><br><br>
<?php } ?>
                    <?php
                            $stmt = $conn->prepare("SELECT reciever FROM favorite_video WHERE sender = ? ORDER BY id DESC LIMIT 10");
                            $stmt->bind_param("s", $_user['username']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while($video = $result->fetch_assoc()) {
                                $video = $_video_fetch_utils->fetch_video_rid($video['reciever']);
                                if($_video_fetch_utils->video_exists($video['rid'])) {
                    ?>
                        <div class="grid-item" style="">
                            <a href="/watch?v=<?php echo htmlspecialchars($video['rid']); ?>" onclick="playVideo(<?php echo htmlspecialchars(json_encode($video['rid'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;">
                            <img class="thumbnail" onerror="this.src='/dynamic/thumbs/default.png'" src="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>">
                            </a>
                            <div class="video-info-grid">
                                <a style="color: <?php echo htmlspecialchars($_user['text_color']); ?>;display: inline-block;width: 127px;word-wrap: break-word;" href="/watch?v=<?php echo $video['rid']; ?>" onclick="playVideo(<?php echo htmlspecialchars(json_encode($video['rid'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;"><?php echo $_video_fetch_utils->parse_title($video['title']);  ?></a><br>
                                <span class="video-info-small">
                                    <span class="video-views" style="color: <?php echo htmlspecialchars($_user['text_color']); ?>;"><?php echo $_video_fetch_utils->fetch_video_views($video['rid']); ?> views</span><br>
                                    <a style="color: <?php echo htmlspecialchars($_user['text_color']); ?>;" href="/user/<?php echo htmlspecialchars($video['author']); ?>"><?php echo htmlspecialchars($video['author']); ?></a>
                                </span>
                            </div>
                        </div>
                    <?php } } $stmt->close(); ?>
<?php if ($_user['playlists'] > 0) { ?>
<hr class="thin-line">
<h3 style="display: inline-block;color: white;">Playlists (<?php echo $_user['playlists']; ?>)</h3> <a style="float:right;" href="/user/<?php echo htmlspecialchars($_user['username']); ?>/playlists" onclick="selectTab('Playlists', <?php echo htmlspecialchars(json_encode($_user['username'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;">View All</a><br><br>
<?php } ?>
                    <?php
                                                        $stmt = $conn->prepare("SELECT * FROM playlists WHERE author = ? AND visibility = 'n' ORDER BY id DESC LIMIT 10");
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
                        <div class="grid-item" style="">
                            <a href="/view_playlist?v=<?php echo htmlspecialchars($video['rid']); ?>" onclick="open_playlist(<?php echo htmlspecialchars(json_encode($video['rid'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>, <?php echo htmlspecialchars(json_encode($_user['username'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;">
                            <img class="thumbnail" onerror="this.src='/dynamic/thumbs/default.png'" src="/dynamic/thumbs/<?php echo $thumb; ?>">
                            </a>
                            <div class="video-info-grid">
                                <a style="color: <?php echo htmlspecialchars($_user['text_color']); ?>;display: inline-block;width: 127px;word-wrap: break-word;" href="/view_playlist?v=<?php echo $video['rid']; ?>" onclick="open_playlist(<?php echo htmlspecialchars(json_encode($video['rid'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>, <?php echo htmlspecialchars(json_encode($_user['username'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;"><?php echo $_video_fetch_utils->parse_title($video['title']);  ?></a><br>
                                <span class="video-info-small">
                                    <span class="video-views" style="color: <?php echo htmlspecialchars($_user['text_color']); ?>;"><?php echo date("M d, Y", strtotime($video['created'])); ?></span><br>
                                    <a style="color: <?php echo htmlspecialchars($_user['text_color']); ?>;" href="/user/<?php echo htmlspecialchars($video['author']); ?>"><?php echo htmlspecialchars($video['author']); ?></a>
                                </span>
                            </div>
                        </div>
                    <?php } $stmt->close(); ?>
<?php } else if ($_GET['tab'] == 'Videos') { ?>
<?php
    $search = "%" . htmlspecialchars($_GET['search']) . "%";
?>
<div style="position:absolute;width:960px;height:522px">
<div id="playlist-info-grid" style="padding: 6px 6px 0px 6px;height: 5%;">
<div>
        <input type="text" id="upload_search_query-grid" class="box-outline-color" style="width:200px;border-width:1px;border-style:solid;padding: 1px;font:12px Arial,Helvetica,sans-serif;" onkeypress="if (event.keyCode == 13) { searchChannel(document.getElementById('upload_search_query-grid').value); }" value="<?php echo htmlspecialchars($_GET['search']); ?>">
        <input type="button" style="height: 21px;vertical-align: middle;line-height: 21px;font-family:Arial,sans-serif !important;font-size: 12px;padding-top:0;padding-bottom:0;" onclick="searchChannel(document.getElementById('upload_search_query-grid').value);return false" value="Search Uploads">
    </div>
</div>
<hr class="thin-line">
<div style="overflow-y:auto;height:92%;">
                    <?php
                            $results_per_page = 20;

                            $stmt = $conn->prepare("SELECT count(*)
                                                    FROM videos
                                                    WHERE author = ?
                                                    AND (lower(title) LIKE lower(?) OR lower(tags) LIKE lower(?) OR lower(description) LIKE lower(?))
                                                    AND visibility = 'n'");
                            $stmt->bind_param("ssss", $_user['username'], $search, $search, $search);
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

                            $stmt = $conn->prepare("SELECT rid, title, thumbnail, duration, title, author, publish, description
                                                    FROM videos
                                                    WHERE author = ?
                                                    AND (lower(title) LIKE lower(?) OR lower(tags) LIKE lower(?) OR lower(description) LIKE lower(?))
                                                    AND visibility = 'n'
                                                    ORDER BY id DESC LIMIT ?, ?");
                            $stmt->bind_param("ssssss", $_user['username'], $search, $search, $search, $page_first_result, $results_per_page);
                            $stmt->execute();
                            $result = $stmt->get_result();

                        while($video = $result->fetch_assoc()) {
                    ?>
                        <div class="grid-item" style="">
                            <a href="/watch?v=<?php echo htmlspecialchars($video['rid']); ?>" onclick="playVideo(<?php echo htmlspecialchars(json_encode($video['rid'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;">
                            <img class="thumbnail" onerror="this.src='/dynamic/thumbs/default.png'" src="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>">
                            </a>
                            <div class="video-info-grid">
                                <a style="color: <?php echo htmlspecialchars($_user['text_color']); ?>;display: inline-block;width: 127px;word-wrap: break-word;" href="/watch?v=<?php echo $video['rid']; ?>" onclick="playVideo(<?php echo htmlspecialchars(json_encode($video['rid'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;"><?php echo $_video_fetch_utils->parse_title($video['title']);  ?></a><br>
                                <span class="video-info-small">
                                    <span class="video-views" style="color: <?php echo htmlspecialchars($_user['text_color']); ?>;"><?php echo $_video_fetch_utils->fetch_video_views($video['rid']); ?> views</span><br>
                                    <a style="color: <?php echo htmlspecialchars($_user['text_color']); ?>;" href="/user/<?php echo htmlspecialchars($video['author']); ?>"><?php echo htmlspecialchars($video['author']); ?></a>
                                </span>
                            </div>
                        </div>
                    <?php } $stmt->close(); ?>
                        <center>
                        <?php
                                                                                                                if (!isset ($_GET['page']) ) {
                                                                                                                        $curpage = 1;
                                                                                                                } else {
                                                                                                                        $curpage = (int)$_GET['page'];
                                                                                                                }
?>
<?php if ($curpage > 1) { ?>
<a class="channel-cmd" href="javascript:void(0);" onclick="searchChannel(<?php echo htmlspecialchars(json_encode($_GET['search'] ?? '', JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>,<?php echo $curpage - 1; ?>);">Prev</a>&nbsp;
<?php } ?>
<?php for($page = 1; $page<= $number_of_page; $page++) { ?>
<?php if($curpage==$page){ ?>
<b><?php echo $page; ?></b>&nbsp;
<?php } else { ?>
<a class="channel-cmd" href="javascript:void(0);" onclick="searchChannel(<?php echo htmlspecialchars(json_encode($_GET['search'] ?? '', JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>,<?php echo $page; ?>);"><?php echo $page; ?></a>&nbsp;
<?php } ?>
                  <?php } ?>
<?php if ($curpage < $number_of_page) { ?>
<a class="channel-cmd" href="javascript:void(0);" onclick="searchChannel(<?php echo htmlspecialchars(json_encode($_GET['search'] ?? '', JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>,<?php echo $curpage + 1; ?>);">Next</a>&nbsp;
<?php } ?>
</center>
</div>
</div>
<?php } else if ($_GET['tab'] == 'Favourites') { ?>
                    <?php
                            $results_per_page = 20;

                            $stmt = $conn->prepare("SELECT count(*) FROM favorite_video WHERE sender = ?");
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

                            $stmt = $conn->prepare("SELECT reciever FROM favorite_video WHERE sender = ? ORDER BY id DESC LIMIT ?, ?");
                            $stmt->bind_param("sss", $_user['username'], $page_first_result, $results_per_page);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while($video = $result->fetch_assoc()) {
                                $video = $_video_fetch_utils->fetch_video_rid($video['reciever']);
                                if($_video_fetch_utils->video_exists($video['rid'])) {
                    ?>
                        <div class="grid-item" style="">
                            <a href="/watch?v=<?php echo htmlspecialchars($video['rid']); ?>" onclick="playVideo(<?php echo htmlspecialchars(json_encode($video['rid'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;">
                            <img class="thumbnail" onerror="this.src='/dynamic/thumbs/default.png'" src="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>">
                            </a>
                            <div class="video-info-grid">
                                <a style="color: <?php echo htmlspecialchars($_user['text_color']); ?>;display: inline-block;width: 127px;word-wrap: break-word;" href="/watch?v=<?php echo $video['rid']; ?>" onclick="playVideo(<?php echo htmlspecialchars(json_encode($video['rid'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;"><?php echo $_video_fetch_utils->parse_title($video['title']);  ?></a><br>
                                <span class="video-info-small">
                                    <span class="video-views" style="color: <?php echo htmlspecialchars($_user['text_color']); ?>;"><?php echo $_video_fetch_utils->fetch_video_views($video['rid']); ?> views</span><br>
                                    <a style="color: <?php echo htmlspecialchars($_user['text_color']); ?>;" href="/user/<?php echo htmlspecialchars($video['author']); ?>"><?php echo htmlspecialchars($video['author']); ?></a>
                                </span>
                            </div>
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
<a class="channel-cmd" href="javascript:void(0);" onclick="selectTab('Favourites',escape(userUserName),<?php echo $curpage - 1; ?>);">Prev</a>&nbsp;
<?php } ?>
<?php for($page = 1; $page<= $number_of_page; $page++) { ?>
<?php if($curpage==$page){ ?>
<b><?php echo $page; ?></b>&nbsp;
<?php } else { ?>
<a class="channel-cmd" href="javascript:void(0);" onclick="selectTab('Favourites',escape(userUserName),<?php echo $page; ?>);"><?php echo $page; ?></a>&nbsp;
<?php } ?>
                  <?php } ?>
<?php if ($curpage < $number_of_page) { ?>
<a class="channel-cmd" href="javascript:void(0);" onclick="selectTab('Favourites',escape(userUserName),<?php echo $curpage + 1; ?>);">Next</a>&nbsp;
<?php } ?>
</center>
<?php } else if ($_GET['tab'] == 'Playlists') { ?>
                    <?php
                            $results_per_page = 20;

                            $stmt = $conn->prepare("SELECT count(*) FROM playlists WHERE author = ? AND visibility = 'n'");
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

                            $stmt = $conn->prepare("SELECT * FROM playlists WHERE author = ? AND visibility = 'n' ORDER BY id DESC LIMIT ?, ?");
                            $stmt->bind_param("sss", $_user['username'], $page_first_result, $results_per_page);
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
                        <div class="grid-item" style="">
                            <a href="/view_playlist?v=<?php echo htmlspecialchars($video['rid']); ?>" onclick="open_playlist(<?php echo htmlspecialchars(json_encode($video['rid'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>, <?php echo htmlspecialchars(json_encode($_user['username'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;">
                            <img class="thumbnail" onerror="this.src='/dynamic/thumbs/default.png'" src="/dynamic/thumbs/<?php echo $thumb; ?>">
                            </a>
                            <div class="video-info-grid">
                                <a style="color: <?php echo htmlspecialchars($_user['text_color']); ?>;display: inline-block;width: 127px;word-wrap: break-word;" href="/view_playlist?v=<?php echo $video['rid']; ?>" onclick="open_playlist(<?php echo htmlspecialchars(json_encode($video['rid'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>, <?php echo htmlspecialchars(json_encode($_user['username'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>);return false;"><?php echo $_video_fetch_utils->parse_title($video['title']);  ?></a><br>
                                <span class="video-info-small">
                                    <span class="video-views" style="color: <?php echo htmlspecialchars($_user['text_color']); ?>;"><?php echo date("M d, Y", strtotime($video['created'])); ?></span><br>
                                    <a style="color: <?php echo htmlspecialchars($_user['text_color']); ?>;" href="/user/<?php echo htmlspecialchars($video['author']); ?>"><?php echo htmlspecialchars($video['author']); ?></a>
                                </span>
                            </div>
                        </div>
                    <?php } $stmt->close(); ?>
                        <center>
                        <?php
                                                                                                                if (!isset ($_GET['page']) ) {
                                                                                                                        $curpage = 1;
                                                                                                                } else {
                                                                                                                        $curpage = (int)$_GET['page'];
                                                                                                                }
?>
<?php if ($curpage > 1) { ?>
<a class="channel-cmd" href="javascript:void(0);" onclick="selectTab('Playlists',escape(userUserName),<?php echo $curpage - 1; ?>);">Prev</a>&nbsp;
<?php } ?>
<?php for($page = 1; $page<= $number_of_page; $page++) { ?>
<?php if($curpage==$page){ ?>
<b><?php echo $page; ?></b>&nbsp;
<?php } else { ?>
<a class="channel-cmd" href="javascript:void(0);" onclick="selectTab('Playlists',escape(userUserName),<?php echo $page; ?>);"><?php echo $page; ?></a>&nbsp;
<?php } ?>
                  <?php } ?>
<?php if ($curpage < $number_of_page) { ?>
<a class="channel-cmd" href="javascript:void(0);" onclick="selectTab('Playlists',escape(userUserName),<?php echo $curpage + 1; ?>);">Next</a>&nbsp;
<?php } ?>
</center>
<?php } ?>
