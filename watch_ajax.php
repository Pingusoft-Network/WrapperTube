<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_update.php"); ?><?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__user_u = new user_update($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php header("Content-type: text/xml"); ?>
<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<?php if($_GET['action_get_comments'] == 1){ 
$_video = $__video_h->fetch_video_rid($_GET['v']);
if (!$_video) { die("nonexistent"); }
        if($_video['visibility'] == "v" && @$_SESSION['siteusername'] != $_video['author'] && (!$__user_h->if_moderator(@$_SESSION['siteusername']) && !$__user_h->if_admin(@$_SESSION['siteusername']))) {
                die("private");
        }
$_video['comments'] = $__video_h->get_comments_from_video($_video['rid']);
?>
			<root>
				<return_code><![CDATA[0]]></return_code>
				<html_content><![CDATA[
<div class="comments-section " onmouseover="if (yt.www &amp;&amp; yt.www.watch &amp;&amp; yt.www.watch.livecomments) yt.www.watch.livecomments.handleCommentMouseEvent(this, event);" onmouseout="if (yt.www &amp;&amp; yt.www.watch &amp;&amp; yt.www.watch.livecomments) yt.www.watch.livecomments.handleCommentMouseEvent(this, event);">
                                                                                                <div id="comments-header-container">
                                                                                                        <div id="comments-header">
                                                                                                                <h4>
                                                                                                                        All Comments
                                                                                                                        <span class="comments-section-stat">(<?php echo $_video['comments']; ?>)</span>
                                                                                                                </h4>
                                                                                                        </div>
                                                                                                </div>
                                                                                                <?php if(!isset($_SESSION['siteusername'])) { ?>
                                                                                                        <div class="comments-post-container clearfix">
                                                                                                                <div class="comments-post-alert">
                                                                                                                        <a href="/sign_in">Sign In</a> or <a href="/sign_up">Sign Up</a><span class="comments-post-form-rollover-text"> now to post a comment!</span>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                <?php } else if($_video['commenting'] == "d") { ?>
                                                                                                        <div class="comments-disabled-message">
                                                                                                                <img src="//s.ytimg.com/yt/img/icon_comments_disabled-vflxokpZC.png">
                                                                                                                <span>Adding comments has been disabled for this video.</span>
                                                                                                        </div>
                                                                                                <?php } else if($__user_h->if_blocked($_video['author'], $_SESSION['siteusername'])) { ?>
                                                                                                        <div class="comments-post-container clearfix">
                                                                                                                <div class="comments-post-alert">
                                                                                                                        This user has blocked you!
                                                                                                                </div>
                                                                                                        </div>
                                                                                                <?php } else { ?>
                                                                                                        <div class="comments-post-container clearfix">
                                                                                                                <form method="post" action="/comment_service_ajax">
                                                                                                                        <div class="yt-alert yt-alert-default yt-alert-error hid comments-post-message">
                                                                                                                                <div class="yt-alert-icon">
                                                                                                                                        <img class="icon master-sprite" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" width="32px" height="35px">
                                                                                                                                </div>
                                                                                                                                <div class="yt-alert-buttons"></div>
                                                                                                                                <div class="yt-alert-content" role="alert"></div>
                                                                                                                        </div>
                                                                                                                        <input type="hidden" name="form_id" value="">
                                                                                                                        <input type="hidden" name="source" value="w">
                                                                                                                        <input type="hidden" value="" name="reply_parent_id">
                                                                                                                        <a href="/user/<?php echo htmlspecialchars($_SESSION['siteusername']); ?>" class="yt-user-photo comments-post-profile"><span class="video-thumb ux-thumb yt-thumb-square-46 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="/dynamic/pfp/<?php echo $__user_h->fetch_pfp($_SESSION['siteusername']); ?>" alt="<?php echo htmlspecialchars($_SESSION['siteusername']); ?>" width="46"><span class="vertical-align"></span></span></span></span></a>
                                                                                                                        <div class="comments-textarea-container" onclick="yt.www.comments.initForm(this, true, false);">
                                                                                                                                <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="" class="comments-textarea-tip"><label class="comments-textarea-label" data-upsell="comment">Respond to this video...</label>
                                                                                                                                <div class="yt-uix-form-input yt-grid ">
                                                                                                                                        <textarea id="comment-area" class="yt-uix-form-textarea comments-textarea" onfocus="yt.www.comments.initForm(this, false, false);" data-upsell="comment" name="comment"></textarea><br>
<div class="kaomoji">
<select onchange="insertThisInThere(this.value,'comment-area');this.selectedIndex=0;">
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
</select>
</div>
                                                                                                                                </div>
<?php if (!$__user_h->if_partner($_SESSION['siteusername'])) { ?>
                                                                                                                                <script src="/captcha/captcha.js"></script>
<?php } ?>
                                                                                                                        </div>
                                                                                                                        <p class="comments-remaining">
                                                                                                                                <span class="comments-remaining-count" data-max-count="500"></span> characters remaining
                                                                                                                        </p>
                                                                                                                        <p class="comments-threshold-countdown hid">
                                                                                                                                <span class="comments-threshold-count"></span> seconds remaining before you can post
                                                                                                                        </p>
                                                                                                                        <p class="comments-post-buttons">
                                                                                                                                <span class="comments-post-video-response-link"><a href="/add_video_response?v=<?php echo $_GET['v']; ?>">Create a video response</a>&nbsp;or&nbsp;</span><button type="submit" class="comments-post yt-uix-button yt-uix-button-default" role="button"><span class="yt-uix-button-content">Post </span></button>
                                                                                                                        </p>
                                                                                                                </form>
                                                                                                        </div>
                                                                                                <?php } ?><br>
                                                                                                <div id="live-comments-setting-scroll" class="live-comments-setting hid">
                                                                                                        <span id="live-comments-count"></span>
                                                                                                        <a onclick="yt.www.watch.livecomments.setScroll(true); return false;">Update automatically</a>
                                                                                                </div>
                                                                                                <div id="live-comments-setting-no-scroll" class="live-comments-setting hid">
                                                                                                        <a onclick="yt.www.watch.livecomments.setScroll(false); return false;">Disable automatic updates</a>
                                                                                                </div>
                                                                                                <ul class="comment-list" id="live_comments">
                                                                                                                <?php
                                                                                                                $results_per_page = 20;

                                                                                                                $stmt = $__db->prepare("SELECT count(*) FROM comments WHERE toid = :rid");
                                                                                                                $stmt->bindParam(":rid", $_video['rid']);
                                                                                                                $stmt->execute();
                                                                                                                $number_of_result = (int)$stmt->fetchColumn();
                                                                                                                $stmt = null;

                                                                                                                $number_of_page = ceil ($number_of_result / $results_per_page);

                                                                                                                if (!isset ($_GET['p']) ) {
                                                                                                                        $page = 1;
                                                                                                                } else {
                                                                                                                        $page = (int)$_GET['p'];
                                                                                                                }

                                                                                                                $page_first_result = ($page - 1) * $results_per_page;

                                                                                                                $stmt = $__db->prepare("SELECT * FROM comments WHERE toid = :rid ORDER BY id DESC LIMIT :pfirst, :pper");
                                                                                                                $stmt->bindParam(":rid", $_video['rid']);
                                                                                                                $stmt->bindParam(":pfirst", $page_first_result);
                                                                                                                $stmt->bindParam(":pper", $results_per_page);
                                                                                                                $stmt->execute();

                                                                                                                while($comment = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                                                                        if($__video_h->if_comment_liked($_SESSION['siteusername'], $comment['id'], true))
                                                                                                                                $comment['liked'] = true;
                                                                                                                        else if($__video_h->if_comment_liked($_SESSION['siteusername'], $comment['id'], false))
                                                                                                                                $comment['disliked'] = true;

                                                                                                                        $comment['likes']  = $__video_h->get_comment_likes($comment['id'], true);
                                                                                                                        $comment['likes'] -= $__video_h->get_comment_likes($comment['id'], false);
                                                                                                        ?>

                                                                                                                <li class="comment yt-tile-default <?php if($comment['liked']){ ?>voted-up<?php }else if($comment['disliked']){ ?>voted-down<?php } ?>" data-author-viewing="" id="comment_<?php echo $comment['id']; ?>" data-author-id="-uD01K8FQTeOSS5sniRFzQ" data-id="<?php echo $comment['id']; ?>" data-score="<?php echo $comment['likes']; ?>" <?php if($comment['liked']){ ?>data-voted="1"<?php }else if($comment['disliked']){ ?>data-voted="-1"<?php } ?>>
                                                                                                                        <div class="comment-body">
                                                                                                                                <div class="content-container">
                                                                                                                                        <div class="content">
                                                                                                                                                <div class="comment-text" dir="ltr">
                                                                                                                                                        <p><?php echo $__video_h->shorten_description($comment['comment'], 999999, true); ?></p>
                                                                                                                                                </div>
                                                                                                                                                <p class="metadata">
                                                                                                                                                        <span class="author ">
                                                                                                                                                        <a href="/user/<?php echo htmlspecialchars($comment['author']); ?>" class="yt-uix-sessionlink yt-user-name " data-sessionlink="<?php echo htmlspecialchars($comment['author']); ?>" dir="ltr"><?php echo htmlspecialchars($comment['author']); ?></a>
                                                                                                                                                        </span>
                                                                                                                                                        <span class="time" dir="ltr">
                                                                                                                                                        <span dir="ltr"><?php echo $__time_h->time_elapsed_string($comment['date']); ?><span>
                                                                                                                                                        </span>
                                                                                                                                                        </span></span>
                                                                                                                                                        <?php if($comment['likes'] != 0) { ?>
                                                                                                                                                                <?php if($comment['likes'] < 0) { ?>
                                                                                                                                                                <span dir="ltr" class="comments-rating-positive" title="<?php echo $__video_h->get_comment_likes($comment['id'], true); ?> up, <?php echo $__video_h->get_comment_likes($comment['id'], false); ?> down" style="color:#c16a6a;">
                                                                                                                                                                        <?php echo abs($comment['likes']); ?>
                                                                                                                                                                        <img src="/yt/imgbin/dislike.png">
                                                                                                                                                                </span>
                                                                                                                                                                <?php } else { ?>
                                                                                                                                                                <span dir="ltr" class="comments-rating-positive" title="<?php echo $__video_h->get_comment_likes($comment['id'], true); ?> up, <?php echo $__video_h->get_comment_likes($comment['id'], false); ?> down">
                                                                                                                                                                        <?php echo $comment['likes']; ?>
                                                                                                                                                                        <img class="comments-rating-thumbs-up" src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif">
                                                                                                                                                                </span>
                                                                                                                                                                <?php } ?>
                                                                                                                                                        <?php } ?>
                                                                                                                                                </p>
                                                                                                                                        </div>
                                                                                                                                        <div class="comment-actions">
                                                                                                                                                <span class="yt-uix-button-group"><button type="button" class="start comment-action-vote-up comment-action yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" onclick=";return false;" title="Vote Up" data-action="vote-up" data-tooltip-show-delay="300" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-watch-comment-vote-up" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Vote Up"><span class="yt-valign-trick"></span></span></button><button type="button" class="end comment-action-vote-down comment-action yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" onclick=";return false;" title="Vote Down" data-action="vote-down" data-tooltip-show-delay="300" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-watch-comment-vote-down" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Vote Down"><span class="yt-valign-trick"></span></span></button></span>
                                                                                                                                                <span class="yt-uix-button-group">
                                                                                                                                                        <button type="button"
                                                                                                                                                                        class="start comment-action yt-uix-button yt-uix-button-default"
                                                                                                                                                                        onclick=";$('#reply_to_<?php echo $comment['id']; ?>').show();return false;" data-action="reply" role="button"><span class="yt-uix-button-content">Reply</span>
                                                                                                                                                        </button><button type="button" class="end flip yt-uix-button yt-uix-button-default yt-uix-button-empty" onclick=";return false;" data-button-has-sibling-menu="true" role="button" aria-pressed="false" aria-expanded="false" aria-haspopup="true" aria-activedescendant="">
                                                                                                                                                                <img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
                                                                                                                                                                <div class=" yt-uix-button-menu yt-uix-button-menu-default" style="display: none;">
                                                                                                                                                                        <ul>
                                                                                                                                                                                <li class="comment-action" data-action="share"><span class="yt-uix-button-menu-item">Share</span></li>
                                            <?php if(isset($_SESSION['siteusername']) && $_SESSION['siteusername'] == $_video['author']) { ?>

<li class="comment-action" data-action="null"><a href="javascript:void(0);" onclick="delete_comment('<?php echo $comment['id'];?>');return false;"><span class="yt-uix-button-menu-item">Remove</span></a></li>
<?php } ?>
                                                                                                                                                                                <li class="comment-action" data-action="flag"><span class="yt-uix-button-menu-item">Flag for spam</span></li>
                                                                                                                                                                                <li class="comment-action-block comment-action" data-action="block"><span class="yt-uix-button-menu-item">Block User</span></li>
                                                                                                                                                                                <li class="comment-action-unblock comment-action" data-action="unblock"><span class="yt-uix-button-menu-item">Unblock User</span></li>
                                                                                                                                                                        </ul>
                                                                                                                                                                </div>
                                                                                                                                                        </button>
                                                                                                                                                </span>
                                                                                                                                        </div>
                                                                                                                                <?php if(isset($_SESSION['siteusername'])) { ?>
                                                                                                                                        <li id="reply_to_<?php echo $comment['id']; ?>" style="display: none;" class="comment yt-tile-default  child" data-tag="O" data-author-viewing="" data-id="iRV7EkT9us81mDLFDSB6FAsB156Fdn13HUmTm26C3PE" data-score="34" data-author="<?php echo htmlspecialchars($row['author']); ?>">

                                                                                                                                        <div class="comment-body">
                                                                                                                                                <div class="content-container">
                                                                                                                                                <div class="content">
                                                                                                                                                        <div class="comment-text" dir="ltr">
                                                                                                                                                        <form method="post" action="/d/reply?id=<?php echo $comment['id']; ?>&v=<?php echo $_GET['v']; ?>" id="reply_form_<?php echo $comment['id']; ?>" onsubmit="reply_to_comment('<?php echo $comment['id']; ?>');return false;">
                                                                                                                                                                <img style="width: 50px;" src="">
                                                                                                                                                                <textarea style="padding:5px;border-radius:5px;background-color:white;border: 1px solid #d3d3d3; width: 577px;"cols="32" id="com<?php echo $comment['id'] ?>" placeholder="Share your thoughts" name="comment"></textarea><br>
<select onchange="insertThisInThere(this.value,'com<?php echo $comment['id'] ?>');this.selectedIndex=0;">
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
</select>
<br><br>
                                                                                                                                                                <input style="float: none; margin-right: 0px; margin-top: 0px;" class="yt-uix-button yt-uix-button-default" type="submit" value="Reply" name="replysubmit">
                                                                                                                                                                <input style="display: none;" name="id" value="<?php echo $row['id']; ?>">

                                                                                                                                                        </form>
                                                                                                                                                </div>
                                                                                                                                        </div>
                                                                                                                                <?php } ?>
                                                                                                                                </div>
                                                                                                                        </div>
                                                                                                                </li>
                                                                                                                <span id="replies_to_<?php echo $comment['id']; ?>">
                                                                                                                <?php
                                                                                                                        $stmt2 = $__db->prepare("SELECT * FROM comment_reply WHERE toid = :rid");
                                                                                                                        $stmt2->bindParam(":rid", $comment['id']);
                                                                                                                        $stmt2->execute();

                                                                                                                        while($reply = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                                                                                                ?>
                                                                                                                        <li class="comment yt-tile-default " style="margin-left: 30px;" data-author-viewing="" data-author-id="-uD01K8FQTeOSS5sniRFzQ" data-id="<?php echo $reply['id']; ?>" data-score="0" id="comment_reply_<?php echo $reply['id']; ?>">
                                                                                                                                <div class="comment-body">
                                                                                                                                        <div class="content-container">
                                                                                                                                                <div class="content">
                                                                                                                                                        <div class="comment-text" dir="ltr">
                                                                                                                                                                <p><?php echo $__video_h->shorten_description($reply['comment'], 999999, true); ?></p>
                                                                                                                                                        </div>
                                                                                                                                                        <p class="metadata">
                                                                                                                                                                <span class="author ">
                                                                                                                                                                <a href="/user/<?php echo htmlspecialchars($reply['author']); ?>" class="yt-uix-sessionlink yt-user-name " data-sessionlink="<?php echo htmlspecialchars($reply['author']); ?>" dir="ltr"><?php echo htmlspecialchars($reply['author']); ?></a>
                                                                                                                                                                </span>
                                                                                                                                                                <span class="time" dir="ltr">
                                                                                                                                                                <span dir="ltr"><?php echo $__time_h->time_elapsed_string($reply['date']); ?><span>
                                                                                                                                                                </span>
                                                                                                                                                                </span></span>
                                                                                                                                                        </p>
                                                                                                                                                </div>
                                                                                                                                                <div class="comment-actions">
                                                                                                                                                        <span class="yt-uix-button-group"><button type="button" class="start comment-action-vote-up comment-action yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" onclick=";return false;" title="Vote Up" data-action="vote-up" data-tooltip-show-delay="300" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-watch-comment-vote-up" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Vote Up"><span class="yt-valign-trick"></span></span></button><button type="button" class="end comment-action-vote-down comment-action yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" onclick=";return false;" title="Vote Down" data-action="vote-down" data-tooltip-show-delay="300" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-watch-comment-vote-down" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Vote Down"><span class="yt-valign-trick"></span></span></button></span>
                                                                                                                                                        <span class="yt-uix-button-group">
                                                                                                                                                                <button type="button"
                                                                                                                                                                                class="start comment-action yt-uix-button yt-uix-button-default"
                                                                                                                                                                                onclick=";$('#reply_to_<?php echo $comment['id']; ?>').show();return false;" data-action="reply" role="button"><span class="yt-uix-button-content">Reply</span>
                                                                                                                                                                </button><button type="button" class="end flip yt-uix-button yt-uix-button-default yt-uix-button-empty" onclick=";return false;" data-button-has-sibling-menu="true" role="button" aria-pressed="false" aria-expanded="false" aria-haspopup="true" aria-activedescendant="">
                                                                                                                                                                        <img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
                                                                                                                                                                        <div class=" yt-uix-button-menu yt-uix-button-menu-default" style="display: none;">
                                                                                                                                                                                <ul>
                                                                                                                                                                                        <li class="comment-action" data-action="share"><span class="yt-uix-button-menu-item">Share</span></li>
                                            <?php if(isset($_SESSION['siteusername']) && $_SESSION['siteusername'] == $_video['author']) { ?>

<li class="comment-action" data-action="null"><a href="javascript:void(0);" onclick="delete_reply('<?php echo $reply['id'];?>');return false;"><span class="yt-uix-button-menu-item">Remove</span></a></li>
<?php } ?>
                                                                                                                                                                                        <li class="comment-action" data-action="flag"><span class="yt-uix-button-menu-item">Flag for spam</span></li>
                                                                                                                                                                                        <li class="comment-action-block comment-action" data-action="block"><span class="yt-uix-button-menu-item">Block User</span></li>
                                                                                                                                                                                        <li class="comment-action-unblock comment-action" data-action="unblock"><span class="yt-uix-button-menu-item">Unblock User</span></li>
                                                                                                                                                                                </ul>
                                                                                                                                                                        </div>
                                                                                                                                                                </button>
                                                                                                                                                        </span>
                                                                                                                                                </div>
                                                                                                                                        </div>
                                                                                                                                </div>
                                                                                                                        </li>
                                                                                                                <?php } $stmt2 = null; ?>
                                                                                                                </span>
                                                                                                        <?php } $stmt = null; ?>
                                                                                                </ul>
                                                                                        </div>
                                                                                        <div class="comments-section">

                                                                                                <div class="comments-pagination" data-ajax-enabled="true">
                                                                                                        <div class="yt-uix-pager" role="navigation">
                  <?php
                                                                                                                if (!isset ($_GET['p']) ) {
                                                                                                                        $curpage = 1;
                                                                                                                } else {
                                                                                                                        $curpage = (int)$_GET['p'];
                                                                                                                }
?>
<?php if ($curpage > 1) { ?>
<a href="/watch?v=<?php echo $_GET['v']; ?>&amp;page=<?php echo $curpage - 1; ?>" class="yt-uix-button yt-uix-sessionlink yt-uix-pager-prev yt-uix-pager-button yt-uix-button-default" data-page="<?php echo $curpage - 1; ?>">
                        <span class="yt-uix-button-content">« Prev</span>
                     </a>
<?php } ?>
<?php for($page = 1; $page<= $number_of_page; $page++) { ?>
<a href="/watch?v=<?php echo $_GET['v']; ?>&amp;page=<?php echo $page; ?>" class="yt-uix-button yt-uix-sessionlink yt-uix-pager-page-num yt-uix-pager-button <?php if($curpage==$page){ ?>yt-uix-button-toggled<?php } ?> yt-uix-button-default" data-sessionlink="" data-page="<?php echo $page; ?>" aria-label="Go to page <?php echo $page; ?>"><span class="yt-uix-button-content"><strong><?php echo $page; ?></strong></span></a>
                  <?php } ?>
<?php if ($curpage < $number_of_page) { ?>
<a href="/watch?v=<?php echo $_GET['v']; ?>&amp;page=<?php echo $curpage + 1; ?>" class="yt-uix-button yt-uix-sessionlink yt-uix-pager-next yt-uix-pager-button yt-uix-button-default" data-page="<?php echo $curpage + 1; ?>">
                        <span class="yt-uix-button-content">Next »</span>
                     </a>
<?php } ?>
                                                                                                        </div>
                                                                                                </div>

                                                                                        </div>
                                                                                        <ul>
                                                                                                <li class="hid" id="parent-comment-loading"> Loading comment...</li>
                                                                                        </ul>
                                                                                        <div id="comments-loading" class="hid"><img src="/static/img/loadingg.gif"> Loading...</div>
                                                                                </div>
]]></html_content></root>
<?php
} else if ($_GET['action_channel_videos'] == 1) {
$_video = $__video_h->fetch_video_rid($_GET['video_id']);
$stmt = $__db->prepare("SELECT * FROM videos WHERE author = :username AND visibility = 'n' ORDER BY id DESC LIMIT 20");
$stmt->bindParam(":username", $_video['author']);
$stmt->execute();
 ?>
<root><return_code><![CDATA[0]]></return_code><html_content><![CDATA[  
    <div class="yt-uix-slider yt-rounded" id="watch-channel-discoverbox" data-slider-slide-selected="3" data-slider-slides="<?php echo $stmt->rowCount(); ?>">
	<button class="yt-uix-button yt-uix-button-default yt-uix-slider-prev" rel="prev"><img class="yt-uix-slider-prev-arrow" src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="previous"></button>
	<button class="yt-uix-button yt-uix-button-default yt-uix-slider-next" rel="next"><img class="yt-uix-slider-next-arrow" src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="next"></button>
	<div class="yt-uix-slider-head">
		<span class="yt-uix-slider-nums yt-uix-pager">
        <!--
		<button onclick=";return false;" class="yt-uix-slider-num yt-uix-slider-num-current yt-uix-button yt-uix-button-default" type="button" data-slider-num="0" role="button"><span class="yt-uix-button-content">1 </span></button>
		<button onclick=";return false;" class="yt-uix-slider-num  yt-uix-button yt-uix-button-default" type="button" data-slider-num="1" role="button"><span class="yt-uix-button-content">2 </span></button>
		<button onclick=";return false;" class="yt-uix-slider-num  yt-uix-button yt-uix-button-default" type="button" data-slider-num="2" role="button"><span class="yt-uix-button-content">3 </span></button>
		<button onclick=";return false;" class="yt-uix-slider-num  yt-uix-button yt-uix-button-default" type="button" data-slider-num="3" role="button"><span class="yt-uix-button-content">4 </span></button>
        -->
        </span>
		<div class="yt-uix-slider-title">
			<h2><a href="/user/<?php echo htmlspecialchars($_video['author']); ?>/videos">See all <?php echo $__video_h->fetch_user_videos($_video['author']); ?> videos
				&raquo;</a>
			</h2>
		</div>
	</div>
	<div class="yt-uix-slider-body">
		<div class="yt-uix-slider-slides">
                <?php 
                    while($video = $stmt->fetch(PDO::FETCH_ASSOC)) { 
                        $video['age'] = $__time_h->time_elapsed_string($video['publish']);		
                        $video['duration'] = $__time_h->timestamp($video['duration']);
                        $video['views'] = $__video_h->fetch_video_views($video['rid']);
                        $video['author'] = htmlspecialchars($video['author']);		
                        $video['title'] = htmlspecialchars($video['title']);
                        $video['description'] = $__video_h->shorten_description($video['description'], 50);
                ?>
			<ul class="yt-uix-slider-slide ">
                    <li class="yt-uix-slider-slide-item ">
                        <div class="video-list-item  yt-tile-default ">
                            <a href="/watch?v=<?php echo $video['rid']; ?>" class="related-video yt-uix-contextlink  yt-uix-sessionlink" data-sessionlink="feature=channel&amp;ei=COeB-Y25jrUCFdWNIQodzR51Jg%3D%3D"><span class="ux-thumb-wrap contains-addto "><span class="video-thumb ux-thumb yt-thumb-default-120 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img alt="<?php echo $video['title']; ?>" src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" data-thumb="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" width="120" ><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $video['duration']; ?></span>
                            <button type="button" onclick=";return false;" title="Watch Later" class="addto-button video-actions spf-nolink addto-watch-later-button yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" data-video-ids="<?php echo $video['rid']; ?>" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
                            </span></button>
                            </span><span dir="ltr" class="title" title="<?php echo $video['title']; ?>"><?php echo $video['title']; ?></span><span class="stat attribution">by <span class="yt-user-name " dir="ltr"><?php echo $video['author']; ?></span></span><span class="stat view-count"><?php echo $video['views']; ?> views</span></a>
                        </div>
                    </li>
				<li>
					<hr >
				</li>
			</ul>
                <?php } $stmt = null; ?>
		</div>
	</div>
</div>
]]></html_content></root>
<?php } ?>
