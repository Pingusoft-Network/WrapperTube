<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/insert.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/static/important/bbcode.php"); ?>
<?php
    $_user_fetch_utils = new user_fetch_utils();
    $_video_fetch_utils = new video_fetch_utils();
    $_video_insert_utils = new video_insert_utils();
    $_user_insert_utils = new user_insert_utils();
    $_base_utils = new config_setup();
    
    $_base_utils->initialize_db_var($conn);
    $_video_fetch_utils->initialize_db_var($conn);
    $_video_insert_utils->initialize_db_var($conn);
    $_user_fetch_utils->initialize_db_var($conn);
    $_user_insert_utils->initialize_db_var($conn);

    $thread = $_user_fetch_utils->fetch_thread_name($_GET['v']);

    if(isset($_SESSION['siteusername']) && !$_user_fetch_utils->user_exists(@$_SESSION['siteusername'])) 
        die(header("Location: /logout"));

    if(!isset($_SESSION['siteusername'])) {
        die(header("Location: /sign_in"));
    }
    if(!$thread || $thread['author'] != $_SESSION['siteusername']) { die(header("Location: /community?error=This thread doesn't exist or you don't own it!")); }
    if($thread['open'] == "n" || $thread['adminopen'] == 'n') { die(header("Location: /community?error=This thread is closed or archived!")); }

    $_base_utils->initialize_page_compass('Editing "' . $thread['title'] . '"');
?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(!isset($_SESSION['siteusername'])){ $_GET['error'] = "you are not logged in"; goto skipcomment; }
        if(!$_POST['comment']){ $_GET['error'] = "your comment cannot be blank"; goto skipcomment; }
        if(strlen($_POST['comment']) > 12000){ $_GET['error'] = "your comment must be shorter than 12000 characters"; goto skipcomment; }
        //if(ifBlocked(@$_SESSION['siteusername'], $user['username'], $conn)) { $_GET['error'] = "This user has blocked you!"; goto skipcomment; } 

        $stmt = $conn->prepare("UPDATE forum_thread SET contents = ?, title = ?, last_modified = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->bind_param("sss", $text, $title, $pid);
        $title = $_POST['title'];
        $text = $_POST['comment'];
        $pid = $thread['id'];
        $stmt->execute();
        $stmt->close();

        die(header("Location: thread?v=" . $thread['id']));

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
        <script src="/static/js/core-js.js"></script>
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
<b><a href="/community">Index</a> » <a href="/forum/category?c=<?php echo urlencode($thread['category']); ?>"><?php echo htmlspecialchars($thread['category']); ?></a> » <a href="/forum/thread?v=<?php echo $thread['id']; ?>"><?php echo htmlspecialchars($thread['title']); ?></a> » Editing Thread</b><br>
            <h1>Editing "<?php echo htmlspecialchars($thread['title']); ?>"</h1>
            <hr class="thin-line">
            <form method="post" action="" id="submitform">
                    <input type="text" name="title" required="required" placeholder="Title" value="<?php echo htmlspecialchars($thread['title']); ?>" style="width: 100%;"><br>
                    <textarea 
                        onkeyup="textCounter(this,'counter',12000);" 
                        class="markup comment-textbox" cols="32" id="com" style="width: 100%;"
                        placeholder="Edit forum post" name="comment"><?php echo htmlspecialchars($thread['contents']); ?></textarea><br>
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
                    <br>
                    <input type="submit" value="Update" class="www-button www-button-grey">
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
</script>
        <script src="/static/js/prefixfree.min.js"></script>
    </body>
</html>
