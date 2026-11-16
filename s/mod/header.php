<?php
	if(isset($_SESSION['siteusername'])) {
        if(!isset($_SESSION['adminlogin'])) {
        $stmt = $__db->prepare("UPDATE users SET ip = :ip WHERE username = :username");
        $stmt->bindParam(":username", $_SESSION['siteusername']);
		$stmt->bindParam(":ip",       $_SERVER["HTTP_CF_CONNECTING_IP"]);
        $stmt->execute();
        $stmt = null;

		$stmt = $__db->prepare("UPDATE users SET lastlogin = now() WHERE username = :username");
        $stmt->bindParam(":username", $_SESSION['siteusername']);
        $stmt->execute();
        $stmt = null;
        } else {
        echo "You are currently admin-logged as \"" . $_SESSION['siteusername'] . "\". <a href='/funny_casablanka/admin_logout'>Logout</a>";
        }
	}

	if(isset($_SESSION['siteusername']) && !$__user_h->user_exists(@$_SESSION['siteusername'])) {
		die("<a href='/logout'>Your user has been deleted. Logout</a>");
	}
?>
<!-- begin masthead -->
<link rel="stylesheet" href="/static/css/links.css">
<div id="masthead" class="" dir="ltr">
	<a id="logo-container" href="/" title="WrapperTube home">
	<img id="logo" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="WrapperTube home">
	</a>
	<?php if(!isset($_SESSION['siteusername'])) { ?>
		<div id="masthead-user-bar-container">
		<div id="masthead-user-bar">
		<div id="masthead-user">
		<div id="masthead-user-display">
		<a class="start" href="/sign_up">Create Account</a>
		<span class="masthead-link-separator">|</span>
		<a class="end" href="/sign_in">Sign In</a>
		
		</div>
		</div>
		</div>
		</div>
	<?php } else { ?>
		<div id="masthead-user-bar-container">
			<div id="masthead-user-bar">
				<div id="masthead-user">
					<span id="masthead-gaia-user-expander" class="masthead-user-menu-expander masthead-expander" onclick="yt.www.masthead.toggleExpandedMasthead();loadHeaderVideos();"><span id="masthead-gaia-user-wrapper" class="yt-rounded" tabindex="0"><?php echo htmlspecialchars($_SESSION['siteusername']); ?></span></span>
							<?php if($__user_h->fetch_unread_pms($_SESSION['siteusername']) != 0) { ?>
							<button type="button" onclick=";window.location.href=this.getAttribute('href');return false;" href="/inbox/" class="sb-button sb-notif-on yt-uix-button" id="sb-button-notify" role="button"><span class="yt-uix-button-content"><?php echo $__user_h->fetch_unread_pms($_SESSION['siteusername']); ?></span></button>
					<?php } else { ?>
							<button type="button" onclick=";window.location.href=this.getAttribute('href');return false;" href="/inbox/" class="sb-button sb-notif-off yt-uix-button" id="sb-button-notify" role="button"><span class="yt-uix-button-content"><?php echo $__user_h->fetch_unread_pms($_SESSION['siteusername']); ?></span></button>
					<?php } ?>
							<span id="masthead-gaia-photo-expander" class="masthead-user-menu-expander masthead-expander" onclick="yt.www.masthead.toggleExpandedMasthead();loadHeaderVideos();"><span id="masthead-gaia-photo-wrapper" class="yt-rounded"><span id="masthead-gaia-user-image"><span class="clip"><span class="clip-center"><img src="/dynamic/pfp/<?php echo $__user_h->fetch_pfp($_SESSION['siteusername']); ?>" alt=""><span class="vertical-center"></span></span></span></span><span class="masthead-expander-arrow"></span></span></span>
				</div>
			</div>
		</div>
	<?php } ?>
	<div id="masthead-search-bar-container">
		<div id="masthead-search-bar">
			<div id="masthead-nav"><a href="/videos?feature=mh">Browse</a><span class="masthead-link-separator">|</span><a href="/scratch_editor">Scratch Editor</a><span class="masthead-link-separator">|</span><a href="/paint_editor">Paint</a><span class="masthead-link-separator">|</span><a href="/community">Community</a><span class="masthead-link-separator">|</span><a id="masthead-upload-link" class="" data-upsell="upload" href="/upload_video">Upload</a><span class="music-editor-link"><span class="masthead-link-separator">|</span><a href="/music_editor">Music Editor</a></span></div>
			<form id="masthead-search" class="search-form consolidated-form" action="/search_query" onsubmit="if (_gel('masthead-search-term').value == '') return false;">
				<button class="search-btn-compontent search-button yt-uix-button yt-uix-button-default" onclick="if (_gel('masthead-search-term').value == '') return false; _gel('masthead-search').submit(); return false;;return true;" type="submit" id="search-btn" dir="ltr" tabindex="2" role="button"><span class="yt-uix-button-content">Search </span></button>
				<div id="masthead-search-terms" class="masthead-search-terms-border" dir="ltr"><label><input id="masthead-search-term" autocomplete="off" class="search-term" name="q" value="" type="text" tabindex="1" onkeyup="goog.i18n.bidi.setDirAttribute(event,this)" title="Search"></label></div>
			</form>
		</div>
	</div></div>
	<div class="alerts-2012">
	
	</div>
	<?php if(isset($error['status'])) { ?>
		<div id="masthead_child_div" style="width: 970px;margin: auto;"><div class="yt-alert yt-alert-default yt-alert-error  yt-alert-player">  <div class="yt-alert-icon">
			<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
		</div>
		<div class="yt-alert-buttons"></div><div class="yt-alert-content" role="alert">    <span class="yt-alert-vertical-trick"></span>
			<div class="yt-alert-message">
				<?php echo $error['message']; ?>
			</div>
		</div></div></div>
	<?php } ?>
	<?php if(isset($_GET['error'])) { ?>
		<div id="masthead_child_div" style="width: 970px;margin: auto;"><div class="yt-alert yt-alert-default yt-alert-error ">  <div class="yt-alert-icon">
			<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
		</div>
		<div class="yt-alert-buttons"></div><div class="yt-alert-content" role="alert">    <span class="yt-alert-vertical-trick"></span>
			<div class="yt-alert-message">
				<?php echo htmlspecialchars($_GET['error']); ?>
			</div>
		</div></div></div>
	<?php } ?>
	<?php if(isset($_GET['success'])) { ?>
		<div id="masthead_child_div" style="width: 970px;margin: auto;"><div class="yt-alert yt-alert-default yt-alert-success ">  <div class="yt-alert-icon">
			<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
		</div>
		<div class="yt-alert-buttons"></div><div class="yt-alert-content" role="alert">    <span class="yt-alert-vertical-trick"></span>
			<div class="yt-alert-message">
				<?php echo htmlspecialchars($_GET['success']); ?>
			</div>
		</div></div></div>
	<?php } ?>
	<?php if(isset($session_error)) { ?>
		<div id="masthead_child_div" style="width: 970px;margin: auto;"><div class="yt-alert yt-alert-default yt-alert-error">  <div class="yt-alert-icon">
			<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
		</div>
		<div class="yt-alert-buttons"></div><div class="yt-alert-content" role="alert">    <span class="yt-alert-vertical-trick"></span>
			<div class="yt-alert-message">
				<?php echo $session_error->message; ?>
			</div>
		</div></div></div>
	<?php } ?>
        <?php if(isset($_GET['userdoesntexist'])) { ?>
                <div id="masthead_child_div" style="width: 970px;margin: auto;"><div class="yt-alert yt-alert-default yt-alert-error ">  <div class="yt-alert-icon">
                        <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
                </div>
                <div class="yt-alert-buttons"></div><div class="yt-alert-content" role="alert">    <span class="yt-alert-vertical-trick"></span>
                        <div class="yt-alert-message">
                                This user does not exist!
                        </div>
                </div></div></div>
        <?php } ?>
        <?php if(isset($_GET['videodoesntexist'])) { ?>
                <div id="masthead_child_div" style="width: 970px;margin: auto;"><div class="yt-alert yt-alert-default yt-alert-error ">  <div class="yt-alert-icon">
                        <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
                </div>
                <div class="yt-alert-buttons"></div><div class="yt-alert-content" role="alert">    <span class="yt-alert-vertical-trick"></span>
                        <div class="yt-alert-message">
                                This video does not exist!
                        </div>
                </div></div></div>
        <?php } ?>
        <?php if(isset($_GET['groupdoesntexist'])) { ?>
                <div id="masthead_child_div" style="width: 970px;margin: auto;"><div class="yt-alert yt-alert-default yt-alert-error ">  <div class="yt-alert-icon">
                        <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
                </div>
                <div class="yt-alert-buttons"></div><div class="yt-alert-content" role="alert">    <span class="yt-alert-vertical-trick"></span>
                        <div class="yt-alert-message">
                                This group does not exist!
                        </div>
                </div></div></div>
        <?php } ?>
<?php
$sitewide_message = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/static/important/sitewide.txt");
if ($sitewide_message) {
?>
	<div id="ticker" class="ytg-base " style="height:auto!important;min-height:29px!important;"><div id="ticker-inner"><div class="ytg-wide"><button onclick="yt.net.cookies.set('HideTicker', 1, 604800);" class="yt-uix-close" data-close-parent-id="ticker"><img alt="Close" src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif"></button><img class="ticker-icon" src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" alt=""><div class="ticker-content">
		<?php echo $sitewide_message; ?>
	</div></div></div></div><br>
<?php } ?>
<?php if(isset($_SESSION['siteusername'])) { ?>
<div id="masthead-expanded" class="hid" style="display: none;height: 165px;">
	<div id="masthead-expanded-container" style="height: 142px;" class="with-sandbar">

	<div class="yt-rounded" id="watch-channel-discoverbox"
		style="
		width: 580px;
		position: absolute;
		top: -9px;
		left: 1px;
		height: 146px;
		"
	>
										<p class="yt-spinner">
											<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="yt-spinner-img" alt="">
											Loading...
										</p>

</div>


		<div id="masthead-expanded-menus-container">
			<span id="masthead-expanded-menu-shade"></span>
			<div id="masthead-expanded-menu" class="">
				<span class="masthead-expanded-menu-header">WrapperTube</span>
				<ul id="masthead-expanded-menu-list">
					<li class="masthead-expanded-menu-item">
						<a href="/user/<?php echo htmlspecialchars($_SESSION['siteusername']); ?>" class="yt-uix-sessionlink" data-sessionlink="ei=nn0KUubpEcL8kwLQ5oGQDA&amp;feature=mhee">My channel</a>
					</li>
					<li class="masthead-expanded-menu-item">
						<a href="/my_videos" class="yt-uix-sessionlink" data-sessionlink="ei=nn0KUubpEcL8kwLQ5oGQDA&amp;feature=mhee">
						Video Manager
						</a>
					</li>
					<li class="masthead-expanded-menu-item">
						<a href="/subscriptions" class="yt-uix-sessionlink" data-sessionlink="ei=nn0KUubpEcL8kwLQ5oGQDA&amp;feature=mhee">Subscriptions</a>
					</li>
                                        <li class="masthead-expanded-menu-item">
                                                <a href="/subscriptions_videos" class="yt-uix-sessionlink" data-sessionlink="ei=nn0KUubpEcL8kwLQ5oGQDA&amp;feature=mhee">Subscriptions Videos</a>
                                        </li>
					<li class="masthead-expanded-menu-item">
						<a href="/inbox/" class="yt-uix-sessionlink" data-sessionlink="ei=nn0KUubpEcL8kwLQ5oGQDA&amp;feature=mhee">Inbox</a>
					</li>
                                        <li class="masthead-expanded-menu-item">
                                                <a href="/friends" class="yt-uix-sessionlink" data-sessionlink="ei=nn0KUubpEcL8kwLQ5oGQDA&amp;feature=mhee">Friends</a>
                                        </li>
				</ul>
			</div>
			<div id="masthead-expanded-google-menu">
				<span class="masthead-expanded-menu-header">
				Account
				</span>
				<div id="masthead-expanded-menu-google-container">
					<div id="masthead-expanded-menu-google-column1">
						<ul>
							<li class="masthead-expanded-menu-item"><a href="/user/<?php echo htmlspecialchars($_SESSION['siteusername']); ?>">Profile</a></li>
							<li class="masthead-expanded-menu-item"><a href="/community">Community</a></li>
							<li class="masthead-expanded-menu-item">
								<a href="/account/">
								Settings
								</a>
							</li>
                                        		<li class="masthead-expanded-menu-item"><a href="/quicklist">Quicklist (<?php echo $__user_h->fetch_quicklist_videos($_SESSION['siteusername']); ?>)</a></li>
                                                        <li class="masthead-expanded-menu-item"><a href="/groups">Groups</a></li>
                                                        <li class="masthead-expanded-menu-item"><a href="/history">History</a></li>
						</ul>
					</div>
					<div id="masthead-expanded-menu-google-column2">
						<div id="masthead-expanded-menu-account-container">
							<img id="masthead-expanded-menu-gaia-photo" alt="" data-src="/dynamic/pfp/<?php echo $__user_h->fetch_pfp($_SESSION['siteusername']); ?>" src="/dynamic/pfp/<?php echo $__user_h->fetch_pfp($_SESSION['siteusername']); ?>">
							<div id="masthead-expanded-menu-account-info" class="email-only">
								<p><?php echo htmlspecialchars($_SESSION['siteusername']); ?></p>
								<p id="masthead-expanded-menu-email">This is you.</p>
							</div>
						</div>
						<ul>
							<li class="masthead-expanded-menu-item">
								<a class="end" href="/logout" onclick="return confirm('Are you sure you want to sign out?');">
								Sign out
								</a>
							</li>
							<li class="masthead-expanded-menu-item">
								<div class="yt-uix-clickcard masthead-expanded-menu-switch" data-card-class="masthead-card-switch-account">
									<button onclick=";return false;" class="yt-uix-clickcard-target yt-uix-button yt-uix-button-link yt-uix-button-size-default" type="button" data-position="rightbottom" data-orientation="vertical" role="button">    
									</button>
									<div class="yt-uix-clickcard-content">
										<ul id="yt-masthead-multilogin">
											<li>
												<a class="yt-masthead-multilogin-user yt-valign" href="/sign_in">
												<span class="video-thumb yt-masthead-multilogin-user-icon yt-thumb yt-thumb-46">
												<span class="yt-thumb-square">
												<span class="yt-thumb-clip">
												<span class="yt-thumb-clip-inner">
												<img alt="<?php echo htmlspecialchars($_SESSION['siteusername']); ?>" src="https://lh3.googleusercontent.com/-fkHTNWtyMoM/AAAAAAAAAAI/AAAAAAAAAAA/dZZ7bn_kmxE/s46-c-k/photo.jpg" width="46">
												<span class="vertical-align"></span>
												</span>
												</span>
												</span>
												</span>
												<span class="yt-masthead-multilogin-user-content yt-valign-container">
												<span class="yt-masthead-multilogin-user-link" dir="ltr"><?php echo htmlspecialchars($_SESSION['siteusername']); ?></span><br>
												jamie@vid.io
												</span>
												</a>
											</li>
											<li>
												<a class="yt-masthead-multilogin-user yt-valign" href="/sign_in">
													<span class="video-thumb yt-masthead-multilogin-user-icon yt-thumb yt-thumb-46">
													<span class="yt-thumb-square">
													<span class="yt-thumb-clip">
													<span class="yt-thumb-clip-inner">
													<img alt="<?php echo htmlspecialchars($_SESSION['siteusername']); ?>" src="https://lh4.googleusercontent.com/-jGr7ddTE474/AAAAAAAAAAI/AAAAAAAAAAA/nO6xbnZniy0/s46-c-k/photo.jpg" width="46">
													<span class="vertical-align"></span>
													</span>
													</span>
													</span>
													</span>
													<span class="yt-masthead-multilogin-user-content yt-valign-container">
													<span class="yt-masthead-multilogin-user-link" dir="ltr"><?php echo htmlspecialchars($_SESSION['siteusername']); ?></span><br>
													</span>
													<div class="yt-alert yt-alert-naked yt-alert-success">
														<div class="yt-alert-icon">
															<img src="//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
														</div>
													</div>
												</a>
											</li>
										</ul>
										<div id="yt-masthead-multilogin-actions" class="yt-grid-box">
											<button id="yt-masthead-multilogin-sign-out" onclick="document.logoutForm.submit();return false;" class=" yt-uix-button yt-uix-button-link yt-uix-button-size-default" type="button" role="button">    <span class="yt-uix-button-content">
											Sign out 
											</span>
											</button>
											<a href="https://accounts.google.com/AddSession?service=youtube&amp;uilel=0&amp;cont…er%252Bballoon%252Bfight%26nomobiletemp%3D1&amp;hl=en_US&amp;passive=false">Add account</a>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
<?php } ?>
<div id="alerts">

</div>
<script type="text/javascript" language='JavaScript'>
var myxhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
var headerVideos = document.getElementById('watch-channel-discoverbox');
var headerVideosLoaded = false;
function loadHeaderVideos() {
    if (headerVideosLoaded) {
        return;
    }
    headerVideosLoaded = true;
    myxhttp.open("GET", "/get/header_videos", true);
    myxhttp.onreadystatechange = function () {
        if (myxhttp.readyState === 4) {
            if (myxhttp.status === 200) {
                headerVideos.outerHTML = myxhttp.responseText;
            } else {
                //alert('Unable to get user videos.');
                headerVideosLoaded = false;
            }
        }
    }
    myxhttp.send();
}
</script>
<!-- end masthead -->
