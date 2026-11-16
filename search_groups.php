<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php"); ?>
<?php
    $_user_fetch_utils = new user_fetch_utils();
    $_video_fetch_utils = new video_fetch_utils();
    $_base_utils = new config_setup();
    
    $_base_utils->initialize_db_var($conn);
    $_video_fetch_utils->initialize_db_var($conn);
    $_user_fetch_utils->initialize_db_var($conn);

    $_base_utils->initialize_page_compass("Search Groups");

    $category = "None";

    // "None", "Featured", "Film & Animation", "Autos & Vehicles", "Music", "Pets & Animals", "Sports", "Travel & Events", "Gaming", "People & Blogs", "Comedy", "Entertainment", "News & Politics", "Howto & Style", "Education", "Science & Technology", "Nonprofits & Activism", "Poop-posting"
    //handle category

    $search = "%" . htmlspecialchars($_GET['q']) . "%";

    if(isset($_GET['c'])) 
        $category = ($_GET['c']);
?>
                            <?php
                            if($category != "None" && $category != "Featured") { 
                                $stmt56 = $conn->prepare("SELECT count(*) FROM user_groups WHERE group_category = ? AND (lower(group_title) LIKE lower(?) OR lower(group_description) LIKE lower(?))");
                                $stmt56->bind_param("sss", $category, $search, $search);
                                $stmt56->execute();
                                $stmt56->bind_result($result56);
                                $stmt56->fetch();
                                $stmt56->close();
                            } else if ($category == "Featured") {
                                $stmt56 = $conn->prepare("SELECT count(*) FROM user_groups WHERE group_featured = 'y' AND (lower(group_title) LIKE lower(?) OR lower(group_description) LIKE lower(?))");
                                $stmt56->bind_param("ss", $search, $search);
                                $stmt56->execute();
                                $stmt56->bind_result($result56);
                                $stmt56->fetch();
                                $stmt56->close();
                            } else {
                                $stmt56 = $conn->prepare("SELECT count(*) FROM user_groups WHERE (lower(group_title) LIKE lower(?) OR lower(group_description) LIKE lower(?))");
				$stmt56->bind_param("ss", $search, $search);
                                $stmt56->execute();
                                $stmt56->bind_result($result56);
                                $stmt56->fetch();
                                $stmt56->close();
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
<meta name="description" content="WrapperTube is a site where you can upload your videos, animations, Scratch Projects, Artwork, music, and anything.">
<meta name="theme-color" content="red">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
<meta property="og:title" content="WrapperTube - <?php echo $_base_utils->return_current_page(); ?>" />
<meta property="og:url" content="http://wrappertube.org/" />
<meta property="og:description" content="WrapperTube is a site where you can upload your videos, animations, Scratch Projects, Artwork, music, and anything." />
<meta property="og:image" content="/yt/imgbin/full-size-logo.png" />
        <script src="/static/js/core-js.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/static/css/new/www-core.css">

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
<form method="get" action="/search_groups">
<input type="text" placeholder="Search Groups" name="q" style="width:85%;" value="<?php echo htmlspecialchars($_GET['q']); ?>">
<input type="submit" value="Search" class="www-button www-button-grey">
</form><br>
            <div class="www-videos-left">
                <h2>Search results for "<?php echo htmlspecialchars($_GET['q']); ?>"</h2><br>
                About <strong><?php echo number_format($result56); ?></strong> results<br><br>
                <ul class="videos-list">
                <?php $categories = ["None", "Featured", "Film & Animation", "Autos & Vehicles", "Music", "Pets & Animals", "Sports", "Travel & Events", "Gaming", "People & Blogs", "Comedy", "Entertainment", "News & Politics", "Howto & Style", "Education", "Science & Technology", "Nonprofits & Activism", "Poop-posting"]; ?>
                    <?php foreach($categories as $categoryTag) { ?>
                        <?php if($categoryTag == $category) { ?>
                            <li class=""><?php echo $categoryTag; ?></li>
                        <?php } else { ?>
                            <li class=""><a href="/search_groups?c=<?php echo urlencode($categoryTag); ?>&q=<?php echo urlencode($_GET['q']); ?>"><?php echo $categoryTag; ?></a></li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
            <div class="www-videos-right">
                <h3><?php echo htmlspecialchars($category); ?></h3>
                <div class="videos-box">
                    <div class="videos-title-box-browse">
                    
                    </div>
                    <div class="videos-title-box-contents">
                        <table style="width: 100%;">
                            <tr>
                                <!-- <th style="margin: 5px; width: 5%;"></th> -->
                                <th style="width: 100%;"></th>
                                <th style="margin: 5px; width: 20%;"></th>
                            </tr>
                            <?php
                            $results_per_page = 20;

                            if($category != "None" && $category != "Featured") { 
                                $stmt = $conn->prepare("SELECT count(*) FROM user_groups WHERE group_category = ? AND (lower(group_title) LIKE lower(?) OR lower(group_description) LIKE lower(?))");
                                $stmt->bind_param("sss", $category, $search, $search);
                                $stmt->execute();
                                $stmt->bind_result($number_of_result);
                                $stmt->fetch();
                                $stmt->close();
                            } else if ($category == "Featured") {
                                $stmt = $conn->prepare("SELECT count(*) FROM user_groups WHERE group_featured = 'y' AND (lower(group_title) LIKE lower(?) OR lower(group_description) LIKE lower(?))");
                                $stmt->bind_param("ss", $search, $search);
                                $stmt->execute();
                                $stmt->bind_result($number_of_result);
                                $stmt->fetch();
                                $stmt->close();
                            } else {
                                $stmt = $conn->prepare("SELECT count(*) FROM user_groups WHERE (lower(group_title) LIKE lower(?) OR lower(group_description) LIKE lower(?))");
                                $stmt->bind_param("ss", $search, $search);
                                $stmt->execute();
                                $stmt->bind_result($number_of_result);
                                $stmt->fetch();
                                $stmt->close();
                            }

                            $number_of_page = ceil ($number_of_result / $results_per_page);  

                            if (!isset ($_GET['page']) ) {  
                                $page = 1;  
                            } else {  
                                $page = (int)$_GET['page'];  
                            }  

                            $page_first_result = ($page - 1) * $results_per_page;  

                            $stmt->close();

                            if($category != "None" && $category != "Featured") { 
                                $stmt = $conn->prepare("SELECT * FROM user_groups WHERE group_category = ? AND (lower(group_title) LIKE lower(?) OR lower(group_description) LIKE lower(?)) ORDER BY id DESC LIMIT ?, ?");
                                $stmt->bind_param("sssss", $category, $search, $search, $page_first_result, $results_per_page);
                                $stmt->execute();
                                $result = $stmt->get_result();
                            } else if ($category == "Featured") {
                                $stmt = $conn->prepare("SELECT * FROM user_groups WHERE group_featured = 'y' AND (lower(group_title) LIKE lower(?) OR lower(group_description) LIKE lower(?)) ORDER BY id DESC LIMIT ?, ?");
                                $stmt->bind_param("ssss", $search, $search, $page_first_result, $results_per_page);
                                $stmt->execute();
                                $result = $stmt->get_result();
                            } else {
                                $stmt = $conn->prepare("SELECT * FROM user_groups WHERE (lower(group_title) LIKE lower(?) OR lower(group_description) LIKE lower(?)) ORDER BY id DESC LIMIT ?, ?");
                                $stmt->bind_param("ssss", $search, $search, $page_first_result, $results_per_page);
                                $stmt->execute();
                                $result = $stmt->get_result();
                            }

                            while($group = $result->fetch_assoc()) { ?>
                            <tr style="margin-top: 5px;" id="videoslist">
                                <td class="video-manager-left">
                                    <img src="/dynamic/thumbs/<?php echo $group['group_picture']; ?>" style="width:50px;height:50px;">
                                    <span style="display: inline-block;float: right;"></span>
                                </div>
                                    <span class="video-manager-info" style="width: 93%;">
                                    <a class="video-manager-title" href="/group/<?php echo $group['id']; ?>"><?php echo htmlspecialchars($group['group_title']); ?></a>
                                    <span style="font-size: 11px;" class="grey-text"> - <?php echo $_video_fetch_utils->parseTextDescription($group['group_description']); ?></span>
                                    <span class="grey-text" style="font-size:11px;float:right;">[<?php echo htmlspecialchars($group['group_author']); ?>] [<?php echo $_user_fetch_utils->fetch_group_member_count($group['id']); ?> members] [<?php echo $_user_fetch_utils->fetch_group_video_count($group['id']); ?> videos] [<?php echo $_user_fetch_utils->fetch_group_playlist_count($group['id']); ?> playlists]</span>
                                    <br>
                                    <span style="color: #919191;"><?php echo date("F d, Y g:sA", strtotime($group['group_creation'])); ?></span><br>
                                    <br>         
                                </td>
                            </tr>
                        <?php } $stmt->close(); ?>
                        </table>
                    </div>
                </div>

                <center>
                  <?php
                                                                                                                if (!isset ($_GET['page']) ) {
                                                                                                                        $curpage = 1;
                                                                                                                } else {
                                                                                                                        $curpage = (int)$_GET['page'];
                                                                                                                }
?>
<?php if ($curpage > 1) { ?>
<a href="search_groups?c=<?php echo urlencode($category); ?>&q=<?php echo urlencode($_GET['q']); ?>&page=<?php echo $curpage - 1; ?>">Prev</a>&nbsp;
<?php } ?>
<?php for($page = 1; $page<= $number_of_page; $page++) { ?>
<?php if($curpage==$page){ ?>
<b><?php echo $page; ?></b>&nbsp;
<?php } else { ?>
<a href="search_groups?c=<?php echo urlencode($category); ?>&q=<?php echo urlencode($_GET['q']); ?>&page=<?php echo $page; ?>"><?php echo $page; ?></a>&nbsp;
<?php } ?>
                  <?php } ?>
<?php if ($curpage < $number_of_page) { ?>
<a href="search_groups?c=<?php echo urlencode($category); ?>&q=<?php echo urlencode($_GET['q']); ?>&page=<?php echo $curpage + 1; ?>">Next</a>&nbsp;
<?php } ?>

                </center>  
            </div>
        </div>
        <div class="www-core-container">
        <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/module/footer.php"); ?>
        </div>
        <script src="/static/js/prefixfree.min.js"></script>
    </body>
</html>
