<?php
        if(isset($_SESSION['siteusername']) && !$_user_fetch_utils->user_exists(@$_SESSION['siteusername'])) {
                die("<a href='/logout'>Your user has been deleted. Logout</a>");
        }
?>
<link rel="stylesheet" href="/static/css/links.css?v2">
<div class="www-header-mast" style="background-color: white;margin-top: -10px;border-bottom-left-radius: 5px;
border-bottom-right-radius: 5px;padding-bottom: 16px;padding-right: 5px;height:47px;"><br>
    <a href="/"><img src="/yt/imgbin/full-size-logo.png" class="www-logo"></a>
    <span class="www-motto" style="top: 32px;position:absolute;left: 87px;">
    <a href="/videos">Videos</a> | <a href="/members">Members</a> | <a href="/scratch_editor">Scratch Editor</a> | <a href="/paint_editor">Paint</a> | <a href="/community">Community</a> | <a href="/upload_video">Upload</a><!--Honeypot for bots that intentionally ignore robots.txt. Only dumb bots follow this link. WARNING: Do not go to this link. It will automatically ban your IP for 48 hours.--><span class="music-editor-link"> | <a href="/music_editor" tabindex="-1" aria-hidden="true">Music Editor</a></span>
    </span>
<div id="google_translate_element" style="display:inline-block;left:87px;top:5px;position:absolute;" class="www-motto"></div>

<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'en,fr,de,nl,ru,it,es,pl,sv,ro,fi,uk,lt,lv,sr,cs,da,et,ja,no,pt-PT,bg,hu,el,hr,sk,sl', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, autoDisplay: false}, 'google_translate_element');
}
</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <div class="www-user-info" style="top: -15px;right:5px;position: absolute;">
        <?php if(!isset($_SESSION['siteusername'])) { ?>
            <strong><a style="border-left: 0px;" class="first" href="/sign_up">Sign Up</a></strong> 
            <a href="/account/">My Account</a>
            <a href="/quicklist">QuickList</a> (0) 
            <a href="/t/help">Help</a> 
            <a class="" href="/sign_in">Sign In</a>
        <?php } else { ?>
            <?php if($_user_fetch_utils->fetch_unread_pms($_SESSION['siteusername']) == 0) { ?>
                <a href="/inbox" style="margin-right: 5px;border-left: 0;"><b style="color:grey;line-height: 0;font-size: 12px;font-weight: 100;">(<?php echo $_user_fetch_utils->fetch_unread_pms($_SESSION['siteusername']); ?>)</b> <img class="mailiconstyle" style="width: 16px;vertical-align: middle;margin-bottom: 3px;" src="/static/img/mail.png"></a>
            <?php } else { ?>
                <a href="/inbox" style="margin-right: 5px;border-left: 0;"><b style="color:grey;line-height: 0;font-size: 12px;font-weight: 100;">(<?php echo $_user_fetch_utils->fetch_unread_pms($_SESSION['siteusername']); ?>)</b> <img class="mailiconstyle" style="width: 16px;vertical-align: middle;margin-bottom: 3px;" src="/static/img/mail_notif.png"></a>
            <?php } ?>
            <div class="dropdown">
                <button onclick="dropdown()" style="color: blue;font-size: 14px;font-weight: bold;" class="dropbtn"><?php echo htmlspecialchars($_SESSION['siteusername']); ?><div style="width: 0px;height: 0;border-left: 5px solid transparent;border-right: 5px solid transparent;border-top: 6px solid #4908d4;margin-left: 3px;display: inherit;"></div></button>
                <div id="dropdown-header" style="margin-left:6px;" class="dropdown-content">
                    <a href="/user/<?php echo htmlspecialchars($_SESSION['siteusername']); ?>">My Channel</a>
                    <a href="/subscriptions">Subscriptions</a>
                    <a href="/subscriptions_videos">Subscriptions Videos</a>
                    <a href="/inbox/">Inbox</a>
                    <a href="/my_videos">My Videos</a>
                    <a href="/favorite_videos">Favorites</a>
                    <a href="/friends">Friends</a>
                    <a href="/groups">Groups</a>
                    <a href="/history">History</a>
                </div>
            </div>
            <a href="/account/">My Account</a>
            <a href="/quicklist">QuickList</a> (<?php echo $_user_fetch_utils->fetch_quicklist_videos($_SESSION['siteusername']); ?>)
            <a href="/t/help">Help</a>
            <a href="/logout" onclick="return confirm('Are you sure you want to sign out?');">Sign Out</a>
        <?php } ?>
    </div><br>
    <form class="search-form-alt" autocomplete="off" style="position: absolute;top: 30px;right: -1px" action="/search_query">
            <input name="q" class="search-box-alt">
            <input type="submit" value="Search">
        </form>
    <br>
</div>
<?php 
    if(isset($_SESSION['siteusername'])) {
    if(!isset($_SESSION['adminlogin'])) {
        $_base_utils->update_login_time($_SESSION['siteusername']);
        $stmt = $__db->prepare("UPDATE users SET ip = :ip WHERE username = :username");
        $stmt->bindParam(":username", $_SESSION['siteusername']);
        $stmt->bindParam(":ip",       $_SERVER["HTTP_CF_CONNECTING_IP"]);
        $stmt->execute();
        $stmt = null;
    } else {
        echo "You are currently admin-logged as \"" . $_SESSION['siteusername'] . "\". <a href='/funny_casablanka/admin_logout'>Logout</a>";
    }
    }
?>

<div class="alerts">
    <?php if(isset($_GET['userdoesntexist'])) { ?>
    <div class="alert" id="userdoesntexist" style="background-color: #FFA3A3;">
        This user does not exist!
    </div>
    <?php } ?>

    <?php if(isset($_GET['videodoesntexist'])) { ?>
    <div class="alert" id="videodoesntexist" style="background-color: #FFA3A3;">
        This video does not exist!
    </div>
    <?php } ?>

    <?php if(isset($_GET['groupdoesntexist'])) { ?>
    <div class="alert" id="groupdoesntexist" style="background-color: #FFA3A3;">
        This group does not exist!
    </div>
    <?php } ?>

        <?php if(isset($_GET['error'])) { ?>
                        <div class="alert" id="videodoesntexist" style="background-color: #FFA3A3;">
                                <?php echo htmlspecialchars($_GET['error']); ?>
                        </div>
        <?php } ?>
        <?php if(isset($_GET['success'])) { ?>
                   <div class="alert" id="editsuccess">
                                <?php echo htmlspecialchars($_GET['success']); ?>
                   </div>
        <?php } ?>
        <?php if(isset($session_error)) { ?>
                        <div class="alert" id="videodoesntexist" style="background-color: #FFA3A3;">
                                <?php echo $session_error->message; ?>
                        </div>
        <?php } ?>
<?php
$sitewide_message = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/static/important/sitewide.txt");
if ($sitewide_message) {
?>
                        <div class="alert" id="videodoesntexist" id="editsuccess" style="height:auto!important;min-height:21px!important;">
                                <?php echo $sitewide_message; ?>
                        </div>
<?php } ?>
</div>
<script>
function dropdown() {
  var dd = document.getElementById("dropdown-header");
  if ((" " + dd.className + " ").indexOf(" show ") !== -1) {
    dd.className = dd.className.replace(/\bshow\b/g, '');
  } else {
    dd.className += ' show';
  }
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!((" " + event.target.className + " ").indexOf(" dropbtn ") !== -1)) {
    var dropdowns = document.querySelectorAll(".dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if ((" " + openDropdown.className + " ").indexOf(" show ") !== -1) {
        openDropdown.className = openDropdown.className.replace(/\bshow\b/g, '');
      }
    }
  }
}

</script>
