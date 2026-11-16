<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/update.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/insert.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/important/bbcode.php"); ?>
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

  $thread = $_user_fetch_utils->fetch_thread_name($_GET['v']);

  if(isset($_SESSION['siteusername']) && !$_user_fetch_utils->user_exists(@$_SESSION['siteusername'])) 
    die(header("Location: /logout"));

if(!$thread) { die(header("Location: /community?error=This thread doesn't exist!")); }

  $_category = $_user_fetch_utils->fetch_category_name($thread['category']);

  if ($_category['staffonlyviewing'] == "y" && (!$_video_fetch_utils->is_admin($_SESSION['siteusername']) && !$_video_fetch_utils->is_moderator($_SESSION['siteusername']))) {
      die(header("Location: /community?error=This thread doesn't exist!"));
  }

  $_base_utils->initialize_page_compass($thread['title']);
?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
if (file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/static/important/lockdown_mode.txt")=="on") {die("WrapperTube is currently experiencing an attack from vandals. Some of the site features have been temporarily disabled. Please try again later.");}
        if(!isset($_SESSION['siteusername'])){ $error = "you are not logged in"; goto skipcomment; }
        if(!$_POST['comment']){ $error = "your comment cannot be blank"; goto skipcomment; }
        if(strlen($_POST['comment']) > 12000){ $error = "your comment must be shorter than 12000 characters"; goto skipcomment; }
if (!$_video_fetch_utils->if_partner($_SESSION['siteusername'])) {
        if(!isset($_POST['_CAPTCHA'])){ $error = "captcha validation failed"; goto skipcomment; }
        if(!$_user_insert_utils->validateCaptchaNew($_POST['_CAPTCHA_KEY'], $_POST['_CAPTCHA'])) { $error = "captcha validation failed"; goto skipcomment; }
}
        if($_user_fetch_utils->if_cooldown($_SESSION['siteusername'])) { $error = "You are on a cooldown! Wait for 20 seconds before posting another reply."; goto skipcomment; }
        if($_user_fetch_utils->if_blocked($thread['author'], $_SESSION['siteusername'])) { $error ="This user has blocked you!"; goto skipcomment; }
        if($thread['open'] == "n" || $thread['adminopen'] == 'n') { $error ="This thread is closed or archived!"; goto skipcomment; }

        $stmt = $conn->prepare("INSERT INTO `forum_replies` (toid, author, contents) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $thread['id'], $_SESSION['siteusername'], $text);
        $text = $_POST['comment'];
        $stmt->execute();
        $in_id = $stmt->insert_id;
        $stmt->close();

        $_user_update_utils->update_comment_cooldown_time($_SESSION['siteusername']);

        $stmt = $conn->prepare("UPDATE forum_thread SET last_post = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->bind_param("s", $thread['id']);
        $stmt->execute();
        $stmt->close();

        if ($_SESSION['siteusername']!=$thread['author']) {
        $_user_insert_utils->send_message($thread['author'], "New thread reply", 'I replied with "'.$text.'" on your thread "'.$thread['title'].'" http://wrappertube.org/forum/thread?v='.$thread['id'], $_SESSION['siteusername']);
        }

        $author = htmlspecialchars($thread['author']);

        die(header("Location: reply?v=" . $in_id));

        skipcomment:
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
<meta name="description" content="<?php echo htmlspecialchars($thread["contents"]); ?>">
<meta name="theme-color" content="red">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
<meta property="og:title" content="WrapperTube - <?php echo $_base_utils->return_current_page(); ?>" />
<meta property="og:url" content="http://wrappertube.org/" />
<meta property="og:description" content="<?php echo htmlspecialchars($thread["contents"]); ?>" />
<meta property="og:image" content="/yt/imgbin/full-size-logo.png" />
<?php if ($_category['staffonlyviewing'] == "y") { ?>
<meta name="robots" content="noindex, nofollow, noarchive">
<?php } ?>
        <script src="/static/js/core-js.js"></script>
<link rel="alternate" type="application/atom+xml" title="Latest posts on <?php echo htmlspecialchars($thread['title']); ?>" href="/feed/forum_thread?v=<?php echo urlencode($thread['id']); ?>">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/static/js/scratchblocks.min.js"></script>
    <script type="text/javascript" src="/static/js/translations.js" charset="utf-8"></script>
    <script type="text/javascript">
    (function ($) {
        scratchblocks._currentLanguage = 'en';
        scratchblocks._currentLanguages = ['en'];
    })(jQuery);
    </script>
<script type="text/javascript" src="/static/markitup/jquery.markitup.js"></script>
<script type="text/javascript" src="/static/markitup/sets/bbcode/set.js?v4"></script>
<script type="text/javascript" src="/static/js/board.js"></script>
<link rel="stylesheet" type="text/css" href="/static/markitup/skins/simple/style.css?v3" />
<link rel="stylesheet" type="text/css" href="/static/markitup/sets/bbcode/style.css?v3" />
<script type="text/javascript" src="/static/js/scratchblocks-menu.js"></script>
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
<script type="text/javascript" >
   $(document).ready(function() {
      $("#com").markItUp(mySettings);
            scratchblocks.renderMatching('.scratchblocks-button ul a', {
              languages: ['en']
            });
   });
</script>
    <script type="text/javascript">
    $(document).ready(function() {
      scratchblocks.renderMatching('pre.blocks', {
        languages: scratchblocks._currentLanguages,
        replace: function(el, svg, doc, options) {
          // add scratchblocks to `el`
          scratchblocks.replace(el, svg, doc, options);
        }
      });
    });
    </script>
        <link rel="stylesheet" href="/static/css/bbcode.css?v2">
    </head>
    <body>
        <div class="www-core-container">
            <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/module/header.php"); ?>
<b><a href="/community">Index</a> » <a href="/forum/category?c=<?php echo urlencode($_category['title']); ?>"><?php echo htmlspecialchars($_category['title']); ?></a> » <a href="/forum/thread?v=<?php echo $thread['id']; ?>"><?php echo htmlspecialchars($thread['title']); ?></a></b><br>
            <h1 <?php if ($thread['open'] == "n" || $thread['adminopen'] == 'n') { ?>style="text-decoration:line-through;color:grey;"<?php } ?>><?php if ($thread['adminopen'] == 'n') { ?><img src="/static/img/archive.png" width="16" height="16"> <?php } ?><?php if ($thread['sticky'] == "y") { ?><img src="/static/img/sticky.png" width="16" height="16"> Sticky: <?php } ?><?php echo htmlspecialchars($thread['title']); ?> <a href="/feed/forum_thread?v=<?php echo urlencode($thread['id']); ?>" title="Latest posts on <?php echo htmlspecialchars($thread['title']); ?>"><img src="/static/img/feed-icon-small.png" alt="feed icon" width="14" height="14"></a></h1>
<?php if ($_SESSION['siteusername']==$thread['author']) {
if ($thread['open'] == "y") { ?>
<a href="/get/close_thread?v=<?php echo $thread['id']; ?>" onclick="return confirm('Are you sure you want to close this thread?');">
                <button type="button" class=" www-button www-button-grey" role="button">
                    Close Thread
                </button>
            </a>
<?php } else { ?>
<a href="/get/open_thread?v=<?php echo $thread['id']; ?>" onclick="return confirm('Are you sure you want to open this thread?');">
                <button type="button" class=" www-button www-button-grey" role="button">
                    Open Thread
                </button>
            </a>
<?php }
} ?>
<?php if ($_video_fetch_utils->is_admin($_SESSION['siteusername'])) { ?>
<a href="/funny_casablanka/toggle_sticky?v=<?php echo $thread['id']; ?>" onclick="return confirm('Are you sure you want to toggle sticky this thread?');">
                <button type="button" class=" www-button www-button-grey" role="button">
                    Toggle Sticky
                </button>
            </a>
<?php if ($thread['adminopen'] == "y") { ?>
<a href="/funny_casablanka/close_thread?v=<?php echo $thread['id']; ?>" onclick="return confirm('Are you sure you want to archive this thread?');">
                <button type="button" class=" www-button www-button-grey" role="button">
                    Archive Thread
                </button>
            </a>
<?php } else { ?>
<a href="/funny_casablanka/open_thread?v=<?php echo $thread['id']; ?>" onclick="return confirm('Are you sure you want to unarchive this thread?');">
                <button type="button" class=" www-button www-button-grey" role="button">
                    Unarchive Thread
                </button>
            </a>
<?php } ?>
<?php } ?>
<?php if ($_video_fetch_utils->is_moderator($_SESSION['siteusername'])) { ?>
<a href="/vivat_shuravi/toggle_sticky?v=<?php echo $thread['id']; ?>" onclick="return confirm('Are you sure you want to toggle sticky this thread?');">
                <button type="button" class=" www-button www-button-grey" role="button">
                    Toggle Sticky
                </button>
            </a>
<?php if ($thread['adminopen'] == "y") { ?>
<a href="/vivat_shuravi/close_thread?v=<?php echo $thread['id']; ?>" onclick="return confirm('Are you sure you want to archive this thread?');">
                <button type="button" class=" www-button www-button-grey" role="button">
                    Archive Thread
                </button>
            </a>
<?php } else { ?>
<a href="/vivat_shuravi/open_thread?v=<?php echo $thread['id']; ?>" onclick="return confirm('Are you sure you want to unarchive this thread?');">
                <button type="button" class=" www-button www-button-grey" role="button">
                    Unarchive Thread
                </button>
            </a>
<?php } ?>
<?php } ?>
<?php
                            if (!isset ($_GET['page']) ) {
                                $page = 1;
                            } else {
                                $page = (int)$_GET['page'];
                            }
if ($page == 1) {
?>
<hr class="thin-line"><br>
                <div class="comment-watch" style="width:100%">
                    <a href="/user/<?php echo htmlspecialchars($thread['author']); ?>">
                    <img class="comment-pfp" src="/dynamic/pfp/<?php echo $_user_fetch_utils->fetch_user_pfp($thread['author']); ?>">
                    </a>
                    <span  style="display: inline-block; vertical-align: top;width: 93%;">
                        <span class="comment-info" style="display: inline-block;">
                            <b><a style="text-decoration: none;" href="/user/<?php echo htmlspecialchars($thread['author']); ?>">
                                <?php echo htmlspecialchars($thread['author']); ?> 
                            </a></b> 
                            <a href="/forum/thread?v=<?php echo $thread['id']; ?>"><span style="color: #666;">(<?php echo $_video_fetch_utils->time_elapsed_string($thread['date']); ?>, last modified <?php echo $_video_fetch_utils->time_elapsed_string($thread['last_modified']); ?>)</span></a><?php if(isset($_SESSION['siteusername'])) { ?> [<a href="/report_forum_thread?v=<?php echo $thread['id']; ?>" target="_blank">Report</a>] [<a href="#reply" onclick="quote('1', <?php echo htmlspecialchars(json_encode($thread['author'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>)">Quote</a>]<?php } ?><?php if($_SESSION['siteusername']==$thread['author']){ ?> [<a href="edit_thread?v=<?php echo $thread['id']; ?>">Edit</a>]<?php } ?> <span style="float: right; color: #666;">#1</span>
                        </span><br>
                        <span class="comment-text" style="display: inline-block; width:100% !important;">
                            <?php echo $bbcode->Parse($thread['contents']); ?>
                        </span>
                        <script id="quote1" type="text/template" language="template"><?php echo htmlspecialchars($thread['contents']); ?></script>
                        <?php
                        $user_signature = $_user_fetch_utils->fetch_user_signature($thread['author']);
                        if (!empty($user_signature)) {
                        ?>
                        <hr class="thin-line">
                        <span class="comment-text forum-signature" style="display: inline-block; width:100% !important;">
                            <?php echo $bbcode->Parse($user_signature); ?>
                        </span>
                        <?php
                        }
                        ?>
                    </span>

                </div>
<?php
}
?>
                <?php
                            $results_per_page = 25;

                            $stmt = $conn->prepare("SELECT count(*) FROM forum_replies WHERE toid = ?");
                            $stmt->bind_param("s", $thread['id']);
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

                            $stmt = $conn->prepare("SELECT * FROM forum_replies WHERE toid = ? LIMIT ?, ?");
                            $stmt->bind_param("sss", $thread['id'], $page_first_result, $results_per_page);
                            $stmt->execute();
                            $result = $stmt->get_result();

                    $replyno = $page_first_result + 2;
                    while($comment = $result->fetch_assoc()) {
                        $author = htmlspecialchars($comment['author']);
                ?>
                    <a name="<?php echo $comment['id']; ?>"></a>
                    <hr class="thin-line">
                    <div class="comment-watch" style="width:100%">
                        <a href="/user/<?php echo htmlspecialchars($comment['author']); ?>">
                        <img class="comment-pfp" src="/dynamic/pfp/<?php echo $_user_fetch_utils->fetch_user_pfp($comment['author']); ?>">
                        </a>
                        <span  style="display: inline-block; vertical-align: top;width: 93%;">
                            <span class="comment-info" style="display: inline-block;">
                                <b><a style="text-decoration: none;" href="/user/<?php echo htmlspecialchars($comment['author']); ?>">
                                    <?php echo htmlspecialchars($comment['author']); ?> 
                                </a></b> 
                                <a href="/forum/reply?v=<?php echo $comment['id']; ?>"><span style="color: #666;">(<?php echo $_video_fetch_utils->time_elapsed_string($comment['date']); ?>, last modified <?php echo $_video_fetch_utils->time_elapsed_string($comment['last_modified']); ?>)</span></a><?php if(isset($_SESSION['siteusername'])) { ?> [<a href="/report_forum_reply?v=<?php echo $comment['id']; ?>" target="_blank">Report</a>] [<a href="#reply" onclick="quote('<?php echo $replyno; ?>', <?php echo htmlspecialchars(json_encode($comment['author'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)); ?>)">Quote</a>]<?php } ?><?php if($_SESSION['siteusername']==$comment['author']){ ?> [<a href="edit_reply?v=<?php echo $comment['id']; ?>">Edit</a>]<?php } ?> <span style="float: right; color: #666;">#<?php echo $replyno; ?></span>
                            </span><br>
                            <span class="comment-text" style="display: inline-block;width:100% !important;">
                                <?php echo $bbcode->Parse($comment['contents']); ?>
                            </span>
                            <script id="quote<?php echo $replyno; ?>" type="text/template" language="template"><?php echo htmlspecialchars($comment['contents']); ?></script>
                            <?php
                            $user_signature = $_user_fetch_utils->fetch_user_signature($comment['author']);
                            if (!empty($user_signature)) {
                            ?>
                            <hr class="thin-line">
                            <span class="comment-text forum-signature" style="display: inline-block; width:100% !important;">
                                <?php echo $bbcode->Parse($user_signature); ?>
                            </span>
                            <?php
                            }
                            ?>
                        </span>

                    </div>
                <?php
                $replyno += 1;
                } $stmt->close();
                ?>
                <hr class="thin-line">
                  <?php
                                                                                                                if (!isset ($_GET['page']) ) {
                                                                                                                        $curpage = 1;
                                                                                                                } else {
                                                                                                                        $curpage = (int)$_GET['page'];
                                                                                                                }
?>
<?php if ($curpage > 1) { ?>
<a href="/forum/thread?v=<?php echo $thread['id']; ?>&page=<?php echo $curpage - 1; ?>">Prev</a>&nbsp;
<?php } ?>
<?php for($page = 1; $page<= $number_of_page; $page++) { ?>
<?php if($curpage==$page){ ?>
<b><?php echo $page; ?></b>&nbsp;
<?php } else { ?>
<a href="/forum/thread?v=<?php echo $thread['id']; ?>&page=<?php echo $page; ?>"><?php echo $page; ?></a>&nbsp;
<?php } ?>
                  <?php } ?>
<?php if ($curpage < $number_of_page) { ?>
<a href="/forum/thread?v=<?php echo $thread['id']; ?>&page=<?php echo $curpage + 1; ?>">Next</a>&nbsp;
<?php } ?>
<br>
                <a name="reply"></a>
                <?php if($thread['open'] == "y" && $thread['adminopen'] == 'y') { ?>
                <?php if(!isset($_SESSION['siteusername'])) { ?>
                    <div class="comment-alert">
                        <a href="/sign_in">Sign In</a> or <a href="/sign_up">Sign Up</a> now to reply!
                    </div>
                <?php } else { ?>
                <form method="post" action="" id="submitform" style="width:100%">
                    <?php echo $error; ?>
                        <textarea 
                            onkeyup="textCounter(this,'counter',12000);" 
                            class="markup comment-textbox" cols="32" id="com" style="width: 100%;"
                            placeholder="Reply to this thread" name="comment"></textarea><br>
<button type="button" class="collapsible" style="margin-left:0px;margin-bottom:0px;"><img class="www-right-arrow" id="arrow_more">Emotes &amp; Kaomoji</button>
<div class="content">
<input type="button" onClick="insertThisInThere('ｷﾀ━━━(ﾟ∀ﾟ)━━━!!','com')" value="ｷﾀ━━━(ﾟ∀ﾟ)━━━!!" />
<input type="button" onClick="insertThisInThere('(;´Д`)','com')" value="(;´Д`)" />
<input type="button" onClick="insertThisInThere('ヽ(´∇`)ノ','com')" value="ヽ(´∇`)ノ" />
<input type="button" onClick="insertThisInThere('(´ー`)','com')" value="(´ー`)" />
<input type="button" onClick="insertThisInThere('( ´ー｀)y-~~','com')" value="( ´ー｀)y-~~" />
<input type="button" onClick="insertThisInThere('（ ’～’）','com')" value="（ ’～’）" />
<input type="button" onClick="insertThisInThere('ヽ(`Д´)ノ','com')" value="ヽ(`Д´)ノ" />
<input type="button" onClick="insertThisInThere('( ´ω`)','com')" value="( ´ω`)" />
<input type="button" onClick="insertThisInThere('(・∀・)','com')" value="(・∀・)" />
<input type="button" onClick="insertThisInThere('(´・ω・｀)','com')" value="(´・ω・｀)" />
<input type="button" onClick="insertThisInThere('( ´,_ゝ｀)','com')" value="( ´,_ゝ｀)" />
<input type="button" onClick="insertThisInThere('Σ(;ﾟДﾟ)','com')" value="Σ(;ﾟДﾟ)" />
<input type="button" onClick="insertThisInThere('(;｀Д´)','com')" value="(;｀Д´)" />
<input type="button" onClick="insertThisInThere('( ﾟ ヮﾟ) Mittens!','com')" value="( ﾟ ヮﾟ)" />
<input type="button" onClick="insertThisInThere('^°^','com')" value="^°^" />
<input type="button" onClick="insertThisInThere('=^..^=','com')" value="=^..^=" />
<input type="button" onClick="insertThisInThere('^v^','com')" value="^v^" />
<input type="button" onClick="insertThisInThere('VvV','com')" value="VvV" />
<input type="button" onClick="insertThisInThere('UwU','com')" value="UwU" />
<input type="button" onClick="insertThisInThere('( ° _ ° )','com')" value="( ° _ ° )" />
<input type="button" onClick="insertThisInThere('&gt;v^','com')" value="&gt;v^" />
<input type="button" onClick="insertThisInThere('^_&lt;','com')" value="^_&lt;" />
<input type="button" onClick="insertThisInThere('&gt_^','com')" value="&gt;_^" />
<input type="button" onClick="insertThisInThere('^v&lt;','com')" value="^v&lt;" />
<input type="button" onClick="insertThisInThere('( &gt; v &lt; )','com')" value="( &gt; v &lt; )" />
<input type="button" onClick="insertThisInThere('&gt;v&lt;','com')" value="&gt;v&lt;" /><br />

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':mona2:','com')"><img src="/static/smileys/mona2.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':nida:','com')"><img src="/static/smileys/nida.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':af2:','com')"><img src="/static/smileys/af2.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':nagato:','com')"><img src="/static/smileys/nagato.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':iyahoo:','com')"><img src="/static/smileys/iyahoo.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':purin:','com')"><img src="/static/smileys/purin.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':araebi:','com')"><img src="/static/smileys/araebi.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':mona3:','com')"><img src="/static/smileys/2mona2.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':saitama:','com')"><img src="/static/smileys/anime_saitama05.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':unko:','com')"><img src="/static/smileys/u_unko.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':ranta:','com')"><img src="/static/smileys/anime_imanouchi04.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':mosa:','com')"><img src="/static/smileys/u_mosa.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':shii:','com')"><img src="/static/smileys/anime_shii01.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':syobo:','com')"><img src="/static/smileys/syobo2.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':iyou:','com')"><img src="/static/smileys/2iyou_2.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':1san:','com')"><img src="/static/smileys/1san32.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':zuri:','com')"><img src="/static/smileys/zuri.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':13uo:','com')"><img src="/static/smileys/13uo.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':monatya:','com')"><img src="/static/smileys/monatya.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':pata:','com')"><img src="/static/smileys/u_pata.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':kasari:','com')"><img src="/static/smileys/kasa-ri.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':snowman:','com')"><img src="/static/smileys/showman.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':depression:','com')"><img src="/static/smileys/u_sasu.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':monapc:','com')"><img src="/static/smileys/anime_miruna_pc.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':ppa:','com')"><img src="/static/smileys/ppa.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':rocket:','com')"><img src="/static/smileys/10ite.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':saitama2:','com')"><img src="/static/smileys/anime_saitama06.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':eiki:','com')"><img src="/static/smileys/eiki.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':banana:','com')"><img src="/static/smileys/banana.gif" height="30px" width="30px"></button>

                                                                                        <button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':sip:','com')"><img src="/static/smileys/sip.gif" height="30px" width="30px"></button>
<br>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':meow:','com')"><img src="/static/smileys/Meow.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':gobo:','com')"><img src="/static/smileys/Gobo_emoji.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':waffle:','com')"><img src="/static/smileys/Waffle_Emoji.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':semicolon:','com')"><img src="/static/smileys/Semicolon_Emoticon.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':taco:','com')"><img src="/static/smileys/Taco_emoji.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':eggplant:','com')"><img src="/static/smileys/Eggplant_emoji.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':sushi:','com')"><img src="/static/smileys/Sushi_emoji.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':apple:','com')"><img src="/static/smileys/Apple_emoji.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':broccoli:','com')"><img src="/static/smileys/Broccoli_emoji.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':pizza:','com')"><img src="/static/smileys/Pizza_emoji.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':candycorn:','com')"><img src="/static/smileys/Candycorn.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':10mil:','com')"><img src="/static/smileys/10milemoji.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':map:','com')"><img src="/static/smileys/Map_emoji.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':camera:','com')"><img src="/static/smileys/Camera_emoji.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':suitcase:','com')"><img src="/static/smileys/Suitcase_emoji.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':compass:','com')"><img src="/static/smileys/Compass.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':binoculars:','com')"><img src="/static/smileys/Binoculars.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':ksllxmfcai:','com')"><img src="/static/smileys/Ksllxmfcai-emoji.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':cupcake:','com')"><img src="/static/smileys/Cupcake.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':cat:','com')"><img src="/static/smileys/Cat-emoji.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':awwcat:','com')"><img src="/static/smileys/Aww-cat-emoji.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':coolcat:','com')"><img src="/static/smileys/Cool-cat-emoji.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':tongueoutcat:','com')"><img src="/static/smileys/Tongue-out-cat-emoji.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':winkcat:','com')"><img src="/static/smileys/Wink-cat-emoji.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':lolcat:','com')"><img src="/static/smileys/Lol-cat-emoji.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':upsidedowncat:','com')"><img src="/static/smileys/Upside-down-cat-emoji.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':huhcat:','com')"><img src="/static/smileys/Huh-cat-emoji.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':loveitcat:','com')"><img src="/static/smileys/Love-it-cat-emoji.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':favitcat:','com')"><img src="/static/smileys/Fav-it-cat-emoji.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':rainbowcat:','com')"><img src="/static/smileys/Rainbow-cat-emoji.png"></button>
<button type="button" style="margin-left:0px;margin-bottom:0px;" onClick="insertThisInThere(':pizzacat:','com')"><img src="/static/smileys/Pizza-cat-emoji.png"></button>
</div><br><br> 
                        <input disabled class="characters-remaining" maxlength="4" size="4" value="12000" id="counter" style="width:40px;"> <?php if(!isset($cLang)) { ?> characters remaining <?php } else { echo $cLang['charremaining']; } ?> 
<?php if (!$_video_fetch_utils->if_partner($_SESSION['siteusername'])) { ?>
			<br><script src="/captcha/captcha.js"></script>
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
                <?php }
                      } else { ?>
                    <div class="comment-alert">
                        This thread is <?php echo ($thread['adminopen'] == 'n' ? 'archived' : 'closed'); ?>!
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="www-core-container">
        <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/module/footer.php"); ?>
        </div>
        <script>
                    $(".collapsible").on("click", function() { //way better than the prev code
                        $(this).toggleClass("active-dropdown");
                        $(this).next().slideToggle('fast');
                    });
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
function quote(post, author) {
	$('#com').val("[quote=" + author + "]" + $('<textarea />').html($('#quote' + post).text()).text() + "[/quote]");
}
</script>
<?php if ($error) { ?>
<script type="text/javascript" language="JavaScript">
$(function() {
    location.hash = "#reply";
});
</script>
<?php } ?>
        <script src="/static/js/prefixfree.min.js"></script>
    </body>
</html>
