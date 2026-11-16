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

    if(!$_video_fetch_utils->group_exists($_GET['id']))
        die(header("Location: /?error=This group does not exist."));

    $_group= $_video_fetch_utils->fetch_group_id($_GET['id']);
    if(!isset($_SESSION['siteusername'])) { die(header("Location: /sign_in")); } 
    if(!$_user_fetch_utils->if_group_admin($_SESSION['siteusername'], $_GET['id'])) { die(header("Location: /groups")); } 

    $_base_utils->initialize_page_compass("Editing " . htmlspecialchars($_group['group_title']));

    // why does it have to be a/v and not just y/n???

    if($_group['commenting'] == "y") 
        $_group['commentstatus'] = "Commenting allowed";
    else 
        $_group['commentstatus'] = "Commenting disallowed";
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
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <style>
            .collapsible {
                border: 1px solid #dddddd;
                background: rgb(230,230,230);
                background: -moz-linear-gradient(0deg, rgba(230,230,230,1) 0%, rgba(255,255,255,1) 100%, rgba(255,255,255,1) 100%);
                background: -webkit-linear-gradient(0deg, rgba(230,230,230,1) 0%, rgba(255,255,255,1) 100%, rgba(255,255,255,1) 100%);
                background: linear-gradient(0deg, rgba(230,230,230,1) 0%, rgba(255,255,255,1) 100%, rgba(255,255,255,1) 100%);
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#ffffff",endColorstr="#e6e6e6",GradientType=0);
                font-size: 13px;
                padding: 5px;
            }

            .content {
                padding: 3px;
                background-color: #f9f9f9;
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
                    <h3 class="headerbot" style="margin-top: 0px;padding: 16px;"><?php echo htmlspecialchars($_group['group_title']); ?></h3>
                </div>
            </div>
                <div class="manage-base" style="margin-top: -674px !important;">
<?php if ($_SESSION['siteusername'] == $_group['group_author']) { ?>
                    <button style="margin-left: 5px;float: right;" type="button" class="www-button www-button-grey" href="/signup" role="button">
                        <span class="www-button-content">
                            <a class="style39" style="color: #333; text-decoration: none;" href="/get/delete_group?id=<?php echo $_group['id']; ?>" onclick="return confirm('Are you sure you want to delete this group?');">Delete</a>
                        </span>
                    </button>&nbsp;
<?php } ?>
                    <button class="www-button www-button-grey" style="margin-left: 5px;float: right;" type="button" class="www-button www-button-grey" href="/signup" role="button">
                        <span class="www-button-content">
                            <a class="style39" style="color: #333; text-decoration: none;" href="/group/<?php echo $_group['id']; ?>">Cancel </a>
                        </span>
                    </button>&nbsp;
                    <a href="#">
                        <button class="www-button www-button-grey" type="button">
                        Basic Info
                        </button>
                    </a>
                    <hr class="hrstyle" style="border-top: 1px solid #d3d3d3; border-bottom: 0px solid black; padding: 3px;">
                    <div style="width: 650px; padding: 15px; height: 327px;">
                        <button style="position: relative;top: 4px;width: 753px;" class="collapsible active-dropdown" type="button">
                            Basic Group Info
                        </button>
                        <div style="display: block;width: 747px;" class="content">
                            <br>
                            <form method="post" action="/post/edit_group?id=<?php echo $_group['rid']; ?>" enctype="multipart/form-data" id="submitform" style="position: relative;top: 0;">
                                <b>Title</b> <br><input style="width: 345px;padding:5px;border-radius:5px;background-color:white;border: 1px solid #d3d3d3;" type="text" name="title" id="upltx" value="<?php echo htmlspecialchars($_group['group_title']); ?>" required="required" row="20"><br><br>
                                <b>Description</b><br>
                                <textarea onkeyup="textCounter(this,'counter',8192);"  style="width: 345px;padding:5px;border-radius:5px;background-color:white;border: 1px solid #d3d3d3;" id="upltx2" name="comment"><?php echo htmlspecialchars($_group['group_description']); ?></textarea><br>
<select onchange="insertThisInThere(this.value,'upltx2');this.selectedIndex=0;">
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
                                <input disabled style="width: 30px;background-color: transparent; border: 0px solid transparent;" maxlength="4" size="4" value="8192" id="counter"> characters remaining 
                                <br><br>
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
                            </div>
                            <br>

                            <button style="position: relative;top: 4px;width: 753px;" class="collapsible active-dropdown" type="button">
                                Misc. Group Info
                            </button>
                            <div style="display: block;width: 747px;" class="content">
                                <div>
                                    <b>Privacy Settings</b> <img src="/static/img/info.png" title="This is a way to make your group inaccessible to people." style="vertical-align: middle;cursor: help;"><br>
                                    <select id="joinable" name="joinable" style="padding: 3px;border-radius:5px; border: 1px solid #d3d3d3;">
                                        <option value="y" <?php if($_group['joinable']=='y'){ ?>selected<?php } ?>>Public</option>
                                        <option value="n" <?php if($_group['joinable']=='n'){ ?>selected<?php } ?>>Invite Only</option>
                                    </select>
                                </div>
                                <div>
                                    <br>
                                    <b>Who can add videos and playlists</b><br>
                                    <select id="group_club" name="group_club" style="padding: 3px;border-radius:5px; border: 1px solid #d3d3d3;">
                                        <option value="n" <?php if($_group['group_club']=='n'){ ?>selected<?php } ?>>Members Only</option>
                                        <option value="y" <?php if($_group['group_club']=='y'){ ?>selected<?php } ?>>Everyone</option>
                                    </select>
                                </div>
                                <div>
                                    <br>
                                    <b>Category</b><br>
                                    <select id="category" name="category" style="padding: 3px;border-radius:5px; border: 1px solid #d3d3d3;">  
                                        <?php $categories = ["None", "Film & Animation", "Autos & Vehicles", "Music", "Pets & Animals", "Sports", "Travel & Events", "Gaming", "People & Blogs", "Comedy", "Entertainment", "News & Politics", "Howto & Style", "Education", "Science & Technology", "Nonprofits & Activism", "Poop-posting"]; ?>
                                        <?php foreach($categories as $categoryTag) { ?>
                                            <option value="<?php echo $categoryTag; ?>" <?php if($_group['group_category']==$categoryTag){ ?>selected<?php } ?>><?php echo $categoryTag; ?></option>
                                        <?php } ?>
                                    </select>
                                </div><br>
                                <div>
                                    <b>Group Icon [50x50]</b><br>
                                    <input type="file" name="fileToUpload" id="fileToUpload" accept=".png,.jpg,.jpeg,.gif">
                                </div><br>
                            </div>
                        </div>
                        <input style="position: relative;top: 271px;left: 13px;" class="www-button www-button-grey" type="submit" value="Set">
                    </div><br>
                </form>
            </div><br>
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
        <script>
            var alerts = 0; 
            $('#submitform' ).submit(
                function( e ) {
                    var data = new FormData(this);
                    jQuery.each(jQuery('#fileToUpload')[0].files, function(i, file) {
                        data.append('file-'+i, file);
                    });

                    $.ajax( {
                        url: '/post/edit_group?id=<?php echo $_group['id']; ?>',
                        type: 'POST',
                        data: data,
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function(result){
                            alerts++;
                            addAlert("editsuccess_" + alerts, "Successfully updated your group!");
                            showAlert("#editsuccess_" + alerts);
                            console.log("DEBUG: " + result);
                        }
                    } );
                    e.preventDefault();
                } 
            );
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
