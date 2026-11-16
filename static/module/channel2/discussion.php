<?php 
                            $results_per_page = 20;

                            $stmt = $conn->prepare("SELECT count(*) FROM profile_comments WHERE toid = ?");
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

                            $stmt = $conn->prepare("SELECT * FROM profile_comments WHERE toid = ? ORDER BY id DESC LIMIT ?, ?");
                            $stmt->bind_param("sss", $_GET['n'], $page_first_result, $results_per_page);
                            $stmt->execute();
                            $result = $stmt->get_result();
?>
<div class="channel-box-profle">
    <div class="channel-box-no-bg" style="border-radius: 3px;padding: 7px;">
        <a name="discussion"></a>
        <h2 style="font-weight: normal;">Channel Comments (<?php echo $number_of_result; ?>)</h2>
        <?php if(!isset($_SESSION['siteusername'])) { ?>
            <div class="comment-alert">
                <a href="/sign_in">Sign In</a> or <a href="/sign_up">Sign Up</a> now to post a comment!
            </div>
        <?php } else if($_user_fetch_utils->if_blocked($_user['username'], $_SESSION['siteusername'])) { ?>
            <div class="comment-alert">
                <br>
                This user has blocked you!
            </div>
        <?php } else if($_user['commenting'] == "n") { ?>
            <div class="comment-alert">
                This channel has commenting disabled!
            </div>
        <?php } else { ?>
            <form method="post" action="" id="submitform">
                    <div class="alert" id="comment_error" style="background-color: #FFA3A3;<?php if(!isset($error['status'])) { ?>display: none;<?php } ?>">
                        <?php echo $error['message']; ?>
                    </div>
                    <textarea 
                        onkeyup="textCounter(this,'counter',500);" 
                        class="comment-textbox" cols="32" id="com" style="width: 98%;"
                        placeholder="Leave a nice comment on this channel" name="comment"></textarea><br>
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
</select><br><br> 
                    <input disabled class="characters-remaining" maxlength="3" size="3" value="500" id="counter"> <?php if(!isset($cLang)) { ?> characters remaining <?php } else { echo $cLang['charremaining']; } ?> <br>
<?php if (!$_video_fetch_utils->if_partner($_SESSION['siteusername'])) { ?>
                    <script src="/captcha/captcha.js"></script><br>
<?php } ?>
                    <input type="submit" value="Post" class="www-button www-button-grey">
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
        <?php } ?><br>
<span id="comments_section_real">
        <?php while($comment = $result->fetch_assoc()) {  
            $author = htmlspecialchars($comment['author']);
        ?>
        <hr class="thin-line">
        <div class="comment-watch" id="comment_<?php echo $comment['id'];?>">
            <a href="/user/<?php echo $author; ?>">
            <img class="comment-pfp" src="/dynamic/pfp/<?php echo $_user_fetch_utils->fetch_user_pfp($comment['author']); ?>">
            </a>
            <span class="cauthor" style="display: inline-block; vertical-align: top;width: 562px;">
                <span class="comment-info" style="display: inline-block;">
                    <b><a style="text-decoration: none;" href="/user/<?php echo $author; ?>">
                        <?php echo $author; ?> 
                    </a></b> 
                    <span style="color: <?php echo htmlspecialchars($_user['primary_color_text']); ?>;">(<?php echo $_video_fetch_utils->time_elapsed_string($comment['date']); ?>)</span>
                    <?php if(isset($_SESSION['siteusername']) && $_SESSION['siteusername'] == $_user['username']) { ?>
                        <a style="float: right;" href="javascript:void(0);" onclick="delete_comment('<?php echo $comment['id'];?>');return false;">Remove Comment</a>
                    <?php } ?>
                </span><br>
                <span class="comment-text" style="display: inline-block;width: 575px;word-wrap: break-word;">
                    <?php echo $_video_fetch_utils->parseTextDescription($comment['comment']); ?>
                </span>
            </span>

        </div>
        <?php }
        $stmt->close(); ?>
</span>
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
