<?php
        if(isset($_SESSION['siteusername']) && !$_user_fetch_utils->user_exists(@$_SESSION['siteusername'])) {
                die("<a href='/logout'>Your user has been deleted. Logout</a>");
        }
?>
<link rel="stylesheet" href="/static/css/links.css?v2">
<div class="www-header-mast">
    <a href="/"><img src="/yt/imgbin/full-size-logo.png" class="www-logo"></a>
    <span class="www-motto">
    The place to be in!
    </span>
<div id="google_translate_element" style="display:inline-block;left:90px;top:17px;position:absolute;"></div>

<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'en,fr,de,nl,ru,it,es,pl,sv,ro,fi,uk,lt,lv,sr,cs,da,et,ja,no,pt-PT,bg,hu,el,hr,sk,sl', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, autoDisplay: false}, 'google_translate_element');
}
</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <div class="www-user-info" <?php if(isset($_SESSION["siteusername"])) { ?>style="margin-top: 14px!important;"<?php } ?>>
        <?php if(!isset($_SESSION['siteusername'])) { ?>
            <strong><a style="border-left: 0px;" class="first" href="/sign_up">Sign Up</a></strong> 
            <a href="/account/">Account</a>
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
            <a href="/account/">Account</a>
	    <a href="/quicklist">QuickList (<?php echo $_user_fetch_utils->fetch_quicklist_videos($_SESSION['siteusername']); ?>)</a>
            <a href="/t/help">Help</a> 
            <a href="/logout" onclick="return confirm('Are you sure you want to sign out?');">Sign Out</a> 
        <?php } ?>
    </div>
    <br>
    <div class="www-header-list">
        <a class="www-header-item" href="/videos">Videos</a>
        <a class="www-header-item" href="/members">Members</a>
        <a class="www-header-item" href="/scratch_editor">Scratch Editor</a>
        <a class="www-header-item" href="/paint_editor">Paint</a>
        <a class="www-header-item" href="/community">Community</a>
		<!--Honeypot for bots that intentionally ignore robots.txt. Only dumb bots follow this link. WARNING: Do not go to this link. It will automatically ban your IP for 48 hours.-->
        <span class="music-editor-link"><a class="www-header-item" href="/music_editor" tabindex="-1" aria-hidden="true">Music Editor</a></span>

        <form class="search-form" autocomplete="off" action="/search_query" style="margin-left:40px;">
            <input name="q" class="search-box" style="width:225px;"<?php if ($_SERVER['SCRIPT_NAME'] == "/search_query.php") { ?> value="<?php echo htmlspecialchars($_GET['q']); ?>"<?php } ?>>
            <input type="submit" class="search-button" value="Search">
        </form>

        <a href="/upload_video">
            <button style="cursor:pointer;" class="upload_button">
                Upload
            </button>
        </a>
    </div>
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
<?php
$subscribed = array();

if(isset($_SESSION['siteusername'])) {
    $stmt = $conn->prepare("SELECT * FROM subscribers WHERE sender = ? LIMIT 25");
    $stmt->bind_param("s", $_SESSION['siteusername']);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()) {
        array_push($subscribed, $row['reciever']);
    }
    $stmt->close();
}
?>
