
								<div class="channel-tab-content channel-layout-two-column selected blogger-template">
									<div class="tab-content-body">
										<div class="primary-pane">
                                            <div class="channel-activity-feeds " data-module-id="10500">
                                                <div class="activity-feeds-container">
                                                    <div class="activity-feeds-header clearfix">
                                                        <ul>
                                                        <li class="user-feed-filter">
                                                                <a href="/user/<?php echo htmlspecialchars($_user['username']); ?>/feed">
                                                                Activity
                                                                </a>
                                                            </li>

                                                            <li class="user-feed-filter selected">
                                                                <a href="/user/<?php echo htmlspecialchars($_user['username']); ?>/discussion">
                                                                Profile Comments
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div id="channel-feed-post-form">
                                                    </div>
                                                    <div class="yt-horizontal-rule channel-section-hr"><span class="first"></span><span class="second"></span><span class="third"></span></div>
                                                    <div class="activity-feed">
                                                        <div class="feed-list-container">
                                                            <div class="feed-item-list">
                                                            <?php if(isset($_SESSION['siteusername']) && $_user['commenting'] == "y") { ?>
                                                            <form method="post" action="/d/comment_profile?u=<?php echo htmlspecialchars($_user['username']); ?>" id="submitform">
                                                                <img style="width: 50px;" src="">
                                                                <textarea style="padding:5px;border-radius:5px;background-color:white;border: 1px solid #d3d3d3; width: 577px;"cols="32" id="com" placeholder="Share your thoughts" name="comment"></textarea><br>
<select onchange="insertThisInThere(this.value,'com');this.selectedIndex=0;">
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
</select><br>
<?php if (!$__user_h->if_partner($_SESSION['siteusername'])) { ?>
								<script src="/captcha/captcha.js"></script>
<?php } ?>
                                                                <input style="float: none; margin-right: 0px; margin-top: 0px;" class="yt-uix-button yt-uix-button-default" type="submit" value="Post" name="replysubmit">
                                                            </form><br>
                                                            <?php } ?>
                                                            <ul class="comment-list" id="live_comments">
                                                                <?php
                                                                $results_per_page = 20;

                                                                $stmt = $__db->prepare("SELECT count(*) FROM profile_comments WHERE toid = :rid");
                                                                $stmt->bindParam(":rid", $_user['username']);
                                                                $stmt->execute();

                                                                $number_of_result = (int)$stmt->fetchColumn();
                                                                $stmt = null;
                                                                $number_of_page = ceil ($number_of_result / $results_per_page);  

                                                                if (!isset ($_GET['page']) ) {  
                                                                    $page = 1;  
                                                                } else {  
                                                                    $page = (int)$_GET['page'];  
                                                                }  

                                                                $page_first_result = ($page - 1) * $results_per_page;  

                                                                $stmt = $__db->prepare("SELECT * FROM profile_comments WHERE toid = :rid ORDER BY id DESC LIMIT :pfirst, :pper");
                                                                $stmt->bindParam(":rid", $_user['username']);
                                                                $stmt->bindParam(":pfirst", $page_first_result);
                                                                $stmt->bindParam(":pper", $results_per_page);
                                                                $stmt->execute();

                                                                while($comment = $stmt->fetch(PDO::FETCH_ASSOC)) { 

                                                            ?>

                                                                <li class="comment yt-tile-default " data-author-viewing="" data-author-id="-uD01K8FQTeOSS5sniRFzQ" data-id="<?php echo $comment['id']; ?>" data-score="0">
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
                                    <?php if(isset($_SESSION['siteusername']) && $_SESSION['siteusername'] == $_user['username']) { ?>
                                        <a style="float: right;" href="javascript:void(0);" onclick="delete_comment('<?php echo $comment['id'];?>');return false;">Remove Comment</a>
                                    <?php } ?>
                                                                                    </span></span>
                                                                                    <?php if($comment['likes'] != 0) { ?>
                                                                                    <span dir="ltr" class="comments-rating-positive" title="9 up, 1 down">
                                                                                        <?php echo $comment['likes']; ?>
                                                                                        <img class="comments-rating-thumbs-up" src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif">
                                                                                    </span>
                                                                                    <?php } ?>
                                                                                </p>
                                                                            </div>
                                                                            <div class="comment-actions hid">
                                                                                <span class="yt-uix-button-group hid" style="display:none;"><button type="button" class="start comment-action-vote-up comment-action yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" onclick=";return false;" title="Vote Up" data-action="vote-up" data-tooltip-show-delay="300" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-watch-comment-vote-up" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Vote Up"><span class="yt-valign-trick"></span></span></button><button type="button" class="end comment-action-vote-down comment-action yt-uix-button yt-uix-button-default yt-uix-tooltip yt-uix-button-empty" onclick=";return false;" title="Vote Down" data-action="vote-down" data-tooltip-show-delay="300" role="button"><span class="yt-uix-button-icon-wrapper"><img class="yt-uix-button-icon yt-uix-button-icon-watch-comment-vote-down" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Vote Down"><span class="yt-valign-trick"></span></span></button></span>
                                                                                <span class="yt-uix-button-group hid" style="display:none;">
                                                                                    <button type="button" 
                                                                                            class="start comment-action yt-uix-button yt-uix-button-default" 
                                                                                            onclick=";$('#reply_to_<?php echo $comment['id']; ?>').show();return false;" data-action="reply" role="button"><span class="yt-uix-button-content">Reply</span>
                                                                                    </button><button type="button" class="end flip yt-uix-button yt-uix-button-default yt-uix-button-empty" onclick=";return false;" data-button-has-sibling-menu="true" role="button" aria-pressed="false" aria-expanded="false" aria-haspopup="true" aria-activedescendant="">
                                                                                        <img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="">
                                                                                        <div class=" yt-uix-button-menu yt-uix-button-menu-default" style="display: none;">
                                                                                            <ul>
                                                                                                <li class="comment-action" data-action="share"><span class="yt-uix-button-menu-item">Share</span></li>
                                                                                                <li class="comment-action-remove comment-action" data-action="remove"><span class="yt-uix-button-menu-item">Remove</span></li>
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
                                                                                    <form method="post" action="/d/reply?id=<?php echo $comment['id']; ?>&v=<?php echo $_GET['v']; ?>">
                                                                                        <img style="width: 50px;" src="">
                                                                                        <textarea style="padding:5px;border-radius:5px;background-color:white;border: 1px solid #d3d3d3; width: 577px;"cols="32" id="com" placeholder="Share your thoughts" name="comment"></textarea><br><br>
                                                                                        <input style="float: none; margin-right: 0px; margin-top: 0px;" class="yt-uix-button yt-uix-button-default" type="submit" value="Reply" name="replysubmit">
                                                                                        <input style="display: none;" name="id" value="<?php echo $row['id']; ?>">
                                                                                        
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                
                                                            <?php }
                                                            $stmt = null; ?>
                                                        </ul>
                  <?php
                                                                                                                if (!isset ($_GET['page']) ) {
                                                                                                                        $curpage = 1;
                                                                                                                } else {
                                                                                                                        $curpage = (int)$_GET['page'];
                                                                                                                }
?>
<?php if ($curpage > 1) { ?>
<a href="?page=<?php echo $curpage - 1; ?>"><button class="yt-uix-button yt-uix-button-default">« Prev</button></a>
<?php } ?>
<?php for($page = 1; $page<= $number_of_page; $page++) { ?>
<a href="?page=<?php echo $page; ?>"><button class="yt-uix-button yt-uix-button-default <?php if($curpage==$page){ ?>yt-uix-button-toggled<?php } ?>"><?php echo $page; ?></button></a>
                  <?php } ?>
<?php if ($curpage < $number_of_page) { ?>
<a href="?page=<?php echo $curpage + 1; ?>"><button class="yt-uix-button yt-uix-button-default">Next »</button></a>
<?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
										<div class="secondary-pane"><?php require($_SERVER['DOCUMENT_ROOT'] . "/s/mod/secondary_pane.php"); ?></div>
									</div>
								</div>
							
