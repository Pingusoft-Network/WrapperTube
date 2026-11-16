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

  if(!isset($_SESSION['siteusername']))
    die(header("Location: /sign_in"));

  $_base_utils->initialize_page_compass("Friends");
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
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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

            .manage-base {
                position: relative;
                left: 6px;
                top: 6px;
            }
        </style>
    </head>
    <body>
        <div class="www-core-container">
            <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/module/header.php"); ?>
                <script src="/static/js/alert.js?v2"></script>
            <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/module/module_sidebar.php"); ?>
            <div class="manage-top">
                <div class="headeraccount" style="width: 100%;border-top: 1px solid #CACACA;border-bottom: 1px solid #CACACA;">
                    <h3 class="headerbot" style="margin-top: 0px;padding: 16px;"><a href="/account/">My Account</a> / Friends</h3>
                </div>
            </div>
            <div class="manage-base" style="position: relative;left: 5px;top: 4px;height: auto;margin-bottom: auto;">
                
                <?php
                    $search = $_SESSION['siteusername'];

                    $results_per_page = 12;

                    $stmt = $conn->prepare("SELECT count(*) FROM friends WHERE sender = ? AND (status != 'a' AND status != 'd')");
                    $stmt->bind_param("s", $_SESSION['siteusername']);
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
                ?>

                <h3>Outgoing Friend Requests</h3>
                <table style="width: 100%;">
                    <tr>
                        <!-- <th style="margin: 5px; width: 5%;"></th> -->
                        <th style="width: 80%;"></th>
                        <th style="margin: 5px; width: 20%;"></th>
                    </tr>
                    <?php
                        $stmt6 = $conn->prepare("SELECT * FROM friends WHERE sender = ? AND (status != 'a' AND status != 'd') ORDER BY id DESC LIMIT ?, ?");
                        $stmt6->bind_param("sss", $search, $page_first_result, $results_per_page);
                        $stmt6->execute();
                        $result6 = $stmt6->get_result();

                        if($number_of_result == 0) {
                            echo '<span style="font-size: 11px;" class="grey-text">You have no outgoing friend requests.</span>';
                        }

                        while($friend = $result6->fetch_assoc()) {           
                    ?> 
                    <tr style="margin-top: 5px;" id="videoslist">
                        <td class="video-manager-left">
                            <a style="text-decoration: none;" href="/user/<?php echo htmlspecialchars($friend['reciever']); ?>"><img src="/dynamic/pfp/<?php echo $_user_fetch_utils->fetch_user_pfp($friend['reciever']); ?>" style="vertical-align: middle;width: 16px;height: 16px;"> <?php echo htmlspecialchars($friend['reciever']); ?></a>
                        </td>
                        <td class="video-manager-stats">
                            <a href="/get/reject_friend_request?id=<?php echo $friend['id']; ?>">Revoke</a><br>
                        </td>
                    </tr>
                    <?php } $stmt6->close(); ?>
                </table> 
                  <?php
                                                                                                                if (!isset ($_GET['page']) ) {
                                                                                                                        $curpage = 1;
                                                                                                                } else {
                                                                                                                        $curpage = (int)$_GET['page'];
                                                                                                                }
?>
<?php if ($curpage > 1) { ?>
<a href="friends?page=<?php echo $curpage - 1; ?>"><button class="www-button www-button-grey">« Prev</button></a>
<?php } ?>
                <?php for($page = 1; $page<= $number_of_page; $page++) { ?>
                    <a href="friends?page=<?php echo $page ?>">
                        <button class="www-button www-button-grey"><?php echo $page; ?></button>
                    </a>
                <?php } ?>   
<?php if ($curpage < $number_of_page) { ?>
<a href="friends?page=<?php echo $curpage + 1; ?>"><button class="www-button www-button-grey">Next »</button></a>
<?php } ?>
                <?php
                    $results_per_page = 12;

                    $stmt = $conn->prepare("SELECT count(*) FROM friends WHERE reciever = ? AND (status != 'a' AND status != 'd')");
                    $stmt->bind_param("s", $_SESSION['siteusername']);
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
                ?><br><br>
                <h3>Incoming Friend Requests</h3>
                <table style="width: 100%;">
                    <?php
                        if($number_of_result == 0) {
                            echo '<span style="font-size: 11px;" class="grey-text">You have no incoming friend requests.</span>';
                        }
                    ?>
                    <tr>
                        <!-- <th style="margin: 5px; width: 5%;"></th> -->
                        <th style="width: 80%;"></th>
                        <th style="margin: 5px; width: 20%;"></th>
                    </tr>
                    <?php
                        $stmt6 = $conn->prepare("SELECT * FROM friends WHERE reciever = ? AND (status != 'a' AND status != 'd') ORDER BY id DESC LIMIT ?, ?");
                        $stmt6->bind_param("sss", $search, $page_first_result, $results_per_page);
                        $stmt6->execute();
                        $result6 = $stmt6->get_result();

                        while($friend = $result6->fetch_assoc()) {           
                    ?> 
                    <tr style="margin-top: 5px;" id="videoslist">
                        <td class="video-manager-left">
                            <a style="text-decoration: none;" href="/user/<?php echo htmlspecialchars($friend['sender']); ?>"><img src="/dynamic/pfp/<?php echo $_user_fetch_utils->fetch_user_pfp($friend['sender']); ?>" style="vertical-align: middle;width: 16px;height: 16px;"> <?php echo htmlspecialchars($friend['sender']); ?></a>
                        </td>
                        <td class="video-manager-stats">
                            <a href="/get/deny_friend_request?id=<?php echo $friend['id']; ?>">Deny</a><br>
                            <a href="/get/accept_friend_request?id=<?php echo $friend['id']; ?>">Accept</a><br>
                        </td>
                    </tr>
                    <?php } $stmt6->close(); ?>
                </table> 
                  <?php
                                                                                                                if (!isset ($_GET['page']) ) {
                                                                                                                        $curpage = 1;
                                                                                                                } else {
                                                                                                                        $curpage = (int)$_GET['page'];
                                                                                                                }
?>
<?php if ($curpage > 1) { ?>
<a href="friends?page=<?php echo $curpage - 1; ?>"><button class="www-button www-button-grey">« Prev</button></a>
<?php } ?>
                <?php for($page = 1; $page<= $number_of_page; $page++) { ?>
                    <a href="friends?page=<?php echo $page ?>">
                        <button class="www-button www-button-grey"><?php echo $page; ?></button>
                    </a>
                <?php } ?>
<?php if ($curpage < $number_of_page) { ?>
<a href="friends?page=<?php echo $curpage + 1; ?>"><button class="www-button www-button-grey">Next »</button></a>
<?php } ?>
                <?php
                    $results_per_page = 12;

                    $stmt = $conn->prepare("SELECT count(*) FROM friends WHERE (reciever = ? OR sender = ?) AND (status != 'd' AND status != 'u')");
                    $stmt->bind_param("ss", $_SESSION['siteusername'], $_SESSION['siteusername']);
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
                ?><br><br>
                <h3>Friends</h3>
                <table style="width: 100%;">
                    <?php
                        if($number_of_result == 0) {
                            echo '<span style="font-size: 11px;" class="grey-text">You have no friends. :(</span>';
                        }
                    ?>
                    <tr>
                        <!-- <th style="margin: 5px; width: 5%;"></th> -->
                        <th style="width: 80%;"></th>
                        <th style="margin: 5px; width: 20%;"></th>
                    </tr>
                    <?php
                        $stmt6 = $conn->prepare("SELECT * FROM friends WHERE (reciever = ? OR sender = ?) AND (status != 'd' AND status != 'u') ORDER BY id DESC LIMIT ?, ?");
                        $stmt6->bind_param("ssss", $search, $search, $page_first_result, $results_per_page);
                        $stmt6->execute();
                        $result6 = $stmt6->get_result();

                        while($friend = $result6->fetch_assoc()) {           
                        if(($_user_fetch_utils->user_exists($friend['reciever']) && ($friend['reciever'] != $search)) || ($_user_fetch_utils->user_exists($friend['sender']) && ($friend['sender'] != $search))) {
                        $myuser = ($friend['reciever'] != $search) ? $friend['reciever'] : $friend['sender'];
                    ?> 
                    <tr style="margin-top: 5px;" id="videoslist">
                        <td class="video-manager-left">
                            <a style="text-decoration: none;" href="/user/<?php echo htmlspecialchars($myuser); ?>"><img src="/dynamic/pfp/<?php echo $_user_fetch_utils->fetch_user_pfp($myuser); ?>" style="vertical-align: middle;width: 16px;height: 16px;"> <?php echo htmlspecialchars($myuser); ?></a>
                        </td>
                        <td class="video-manager-stats">
                            <a href="/get/<?php echo ($friend['reciever'] != $search) ? 'reject' : 'deny'; ?>_friend_request?id=<?php echo $friend['id']; ?>" onclick="return confirm('Are you sure you want to unfriend this user?');">Unfriend</a><br>
                        </td>
                    </tr>
                    <?php } } $stmt6->close(); ?>
                </table> 
                  <?php
                                                                                                                if (!isset ($_GET['page']) ) {
                                                                                                                        $curpage = 1;
                                                                                                                } else {
                                                                                                                        $curpage = (int)$_GET['page'];
                                                                                                                }
?>
<?php if ($curpage > 1) { ?>
<a href="friends?page=<?php echo $curpage - 1; ?>"><button class="www-button www-button-grey">« Prev</button></a>
<?php } ?>
                <?php for($page = 1; $page<= $number_of_page; $page++) { ?>
                    <a href="friends?page=<?php echo $page ?>">
                        <button class="www-button www-button-grey"><?php echo $page; ?></button>
                    </a>
                <?php } ?>
<?php if ($curpage < $number_of_page) { ?>
<a href="friends?page=<?php echo $curpage + 1; ?>"><button class="www-button www-button-grey">Next »</button></a>
<?php } ?>
            </div>
        </div>
        <div class="www-core-container">
        <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/module/footer.php"); ?>
        </div>
        <style>
            a[href="/inbox"]{text-decoration:none !important;}
            img.mailiconstyle{width:14px !important;}
            #dropdown-header{border-bottom:0 !important;}
            .sign-in-form-box #submitform:before{content: url("data:image/gif;base64,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");margin-left:100px;}
            td[colspan="2"] input{margin-right:112px !important;margin-top:-12px !important;}
            .watch-main-info:last-child{padding-bottom:8px;}
            .channel-info-video.civ button,button.www-button.www-button-grey,input.www-button.www-button-grey{background:transparent url(/static/img/spritesheet_main.png) repeat-x scroll 0 -800px;border:1px solid #aaa;border-radius:3px;padding:2px;padding-top:3px;padding-left:8px;padding-right:8px;margin-top:4px;margin-left:3px;}
            .channel-info-video.civ button:hover,button.www-button.www-button-grey:hover,input.www-button.www-button-grey:hover{cursor:pointer;text-decoration:underline;}
            .quicklist-add:hover{background-position:-25px -355px;}

            /* edit video */
            #submitform button{margin-left:-13px;margin-bottom:5px;}
            hr.hrstyle{border-top-color:#999 !important;
            margin-top:1px;width:48.70rem;border-left:0 !important;border-right:0 !important;}
            #sidebar-item{font-weight:bold;}
            #sidebar-extra{height:360px;}
            .manage-base{margin-top:-34.36rem;margin-bottom:-262px;height: 606px;}
            /*replace these again/sign in reverted*/
            .sign-in-outer-box{border-color:#999;}
            .sign-in-form-box{background-color:#eee;border:1px solid;border-color:#ccc;}
            input#username{width:169px;margin-left:0;}
            #dropdown-header{border:1px solid #A0B1DC;} 
            #dropdown-header a{border-bottom:1px solid #A0B1DC;}
            /*upload page*/
            .upload-main-s b{font-size:13px;}
            .upload-main-s{width:602px;}
            .upload-inputs{width:590px;border-color:#333;border-radius:2px;height:9px;font-size:12px;margin-top:5px;}
            textarea#upltx2{margin-top:5px;border-radius:2px !important;border-color:#333 !important;}
            .upload-new-base{border:1px solid #ddd;border-radius:5px;}
            select#category{margin-top:5px;}
            .barbg{border-color:#aaa;padding:1px;}
            .bar{background-color:#244883;color:rgba(0,0,0,0);}
            .upload-guidelines{background-color:#ffe69b;color:#994800;font-weight:bold;border-radius:4px;}
            select#category{margin-top:5px;}
            input#upltx, input#tags{border-color:#333 !important;margin-top:5px;margin-left:0;}
            /*search box*/
            .search-box{padding:2px 1px 3px;}
            .search-box:active{margin-top:4px !important;margin-left:4px !important;}
            .search-box:focus{border: 2px solid #bbdafd;margin-top:4px;margin-left:3px;margin-right:5px;}
            #search-button:hover,button.yt-uix-button.yt-uix-button-default:hover,input[name="send"]:hover{background:#c6d7f3 url(/static/img/spritesheet_main.png) repeat-x center -1802px;}
            #search-button:hover{text-decoration:underline !important;cursor:pointer;}
            .search-button{margin-top:7px;margin-left:2px;font-size:12px;}
            .search-button:active{margin-left:1px !important;margin-top:6px !important;}

            /*my accounts*/
            #sidebar-item{padding-bottom:3px;padding-top:4px;}
            #sidebar-item:hover{background-color: rgb(239, 239, 239);
                background: -moz-linear-gradient(0deg,rgb(192,192,192,1) 0%,rgb(239,239,239,1) 115%);
                background: -webkit-linear-gradient(0deg,rgb(192,192,192,1) 0%,rgb(239,239,239,1) 115%);
                background: linear-gradient(0deg,rgb(192,192,192) 0%, rgb(239,239,239) 115%);
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#efefef",endColorstr="#c0c0c0",GradientType=0);}
            #sidebar-item:first-child{padding:0;float:left;height:0;border-bottom:0;}
            a[href="/inbox/send"]{margin-left:-43px !important;padding-right:9px !important;position:relative;top:-43px;}
            a[href="/favorites"]{margin-left:0px;}
            ul{border-top-color:#aaa;border-right-color:#aaa;margin-top:70px;}
            div.headeraccount {
                margin-top: 0 !important;
                margin-bottom: 0 !important;
                border-bottom: 2px solid #aaa !important;
                border-top: 0 !important;
                margin-left: -193px;
                position: relative;
                top: -10px;
                width: 123.5% !important;
                padding:5px;
            }
            h3.headerbot{padding:2px !important;font-size:17px;}

            /* watch page */
            .channel-info-video.civ button{margin-top:-10px;position:relative;top:-3px;}
            span.viddes{font-size:12px !important;text-transform:capitalize;}
            .channel-info-video .thin-line{border-color:#aaa;}

            /* inbox */
            .content{background-color:white;}
            div.i10{border:1px solid #aaa;padding:0 !important;margin-top:2.2rem;}
            button.yt-uix-button.yt-uix-button-default,input[name="send"]{font-weight:bold;color:#039;background:#c6d7f3 url(/static/img/spritesheet_main.png) repeat-x center -1602px;border: 1px solid #a0b1dc;
            text-decoration: none;
            border-radius: 3px;
            padding: 3px 0.833em;
            margin: 5px 7px -4px 7px;}
            .content button.yt-uix-button.yt-uix-button-default{margin-top:-5px;margin-left:1px;margin-bottom:-1px;}
            a.style39{color:#039 !important;}
            input[name="send"]:hover,button.yt-uix-button.yt-uix-button-default:hover{text-decoration:underline;cursor:pointer;}

            /* compose */
            div.tableform form table{margin-left:1rem;}
            td.tdstyle{color:#666;}
            b.sendbold{color:#000;padding-right:40px;}
            td.td10 input{margin-left:1rem;}
            input[type="text"][name="subject"]{margin-left:-1.06rem;}
            textarea[name="message"], input[type="text"]{width:600px;margin-left:-1.43rem;border-radius:0 !important;border-color:#aaa !important;}
            input[name="send"]{padding-left:4px;padding-right:1px;margin-left:6.1rem;margin-top:-1rem;margin-bottom:1rem;}

            .sub_button:hover,.comment-text a,#upload_button,button{cursor:pointer;}
            img[src="/static/img/mail_notif.png"]{width: 21px !important;margin-top:-2px;}
            .buffer{opacity:0.4;}
            span.www-button-content a{color:#000 !important;}
            .grid-item .thumbnail{padding:1px;}
            .video-item .thumbnail, .r120{border:3px double #999;background-repeat:no-repeat;background-size:124px 76px;}
            .r120{background-size:120px 67px;}
            .www-channel-right iframe[width="646"]{width:649px;}
            .active-dropdown:nth-child(3) img{background-position:0px -323px;}
            .video-info-grid,.video-info-watch,.channel-box-top h3.h3title,.channel-box-description,.featured-video-info{overflow:hidden;}
            .collapsible:nth-child(3) img{background-position:0px -343px;}
            span.cauthor{width:559px !important;padding-left:8px;}
            .thin-line{border-left:0;border-right:0;}
            .channel-box-top{overflow:hidden;height:16px;}
        </style>
        <script src="/static/js/prefixfree.min.js"></script>
    </body>
</html>
