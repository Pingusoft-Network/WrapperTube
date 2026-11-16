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

    $_base_utils->initialize_page_compass("Blog");
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
<link rel="alternate" type="application/atom+xml" title="Latest Blog Posts" href="/feed/forum_category?c=WrapperTube+News">
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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/static/css/new/www-core.css">
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
            <div style="min-height: 300px;">
            <h1>Blog <a href="/feed/forum_category?c=WrapperTube+News" title="Latest Blog Posts"><img src="/static/img/feed-icon-small.png" alt="feed icon" width="14" height="14"></a></h1><hr class="thin-line"><br>
            <?php
                            $stmt = $conn->prepare("SELECT * FROM forum_thread WHERE category = 'WrapperTube News' AND date >= '2026-08-29 00:00:00' ORDER BY id DESC");
                            $stmt->execute();
                            $result = $stmt->get_result();

                while($thread = $result->fetch_assoc()) {
            ?>
            <h1><a style="color:black;" href="/forum/thread?v=<?php echo $thread['id']; ?>"><?php echo htmlspecialchars($thread['title']); ?></a></h1> <small>(<?php echo htmlspecialchars($thread['author']); ?>)</small> <small>(<?php echo (new DateTime($thread['date']))->format('D, M j, Y'); ?>, last modified <?php echo (new DateTime($thread['last_modified']))->format('D, M j, Y'); ?>)</small><hr class="thin-line"><br>
                 <?php echo $bbcode->Parse($thread['contents']); ?><br><br><a href="/forum/thread?v=<?php echo $thread['id']; ?>"><i>View Comments &amp; More...</i></a><br><br><hr class="thin-line">
            <?php } $stmt->close(); ?>
            <h1>New WrapperTube Wiki!</h1> <small>(Thu, Aug 27, 2026)</small><hr class="thin-line"><br>
                            The WrapperTube Wiki is now open! It will replace the Fandom wiki. You can visit the WrapperTube Wiki here: <a href="http://wiki.wrappertube.org/" rel="noopener noreferrer nofollow ugc" target="_blank">http://wiki.wrappertube.org/</a><br>
<img src="/static/smileys/anime_saitama06.gif" alt=":saitama2:" title=":saitama2:" class="bbcode_smiley"><br>
Now that the wiki is hosted on our own servers, we can do anything we want! We don't have to follow their silly "Community Guidelines" anymore. No more Fandom censorship, no more forced ads all over your screen, no more kid or adult prompt, and no more irrelevant content. We now have the freedom of customization, freedom of pages (as long as it follows "ZE RULES" of course), and more etc.<br>
<img src="/static/smileys/u_pata.gif" alt=":pata:" title=":pata:" class="bbcode_smiley"><br><br><hr class="thin-line">
            <h1>New WrapperTubeNET IRC Web Chat!</h1> <small>(Sun, Aug 9, 2026)</small><hr class="thin-line"><br>
                 New WrapperTubeNET IRC Web Chat at <a href="https://irc.wrappertube.org/">https://irc.wrappertube.org/</a>. Now, you can use the WrapperTube IRC Server without an IRC Client! Also, the WrapperTube IRC Server is replacing the Telegram, Discord, and Rizon IRC spaces. Please use the WrapperTubeNET IRC Instead.<br><br><hr class="thin-line">
            <h1>More Website Improvements.</h1> <small>(Fri, Jul 31, 2026)</small><hr class="thin-line"><br>
                 Made various improvements to the website, it should be faster now.<br><br><hr class="thin-line">
            <h1>Website Improvements.</h1> <small>(Fri, Jul 10, 2026)</small><hr class="thin-line"><br>
                 Made various improvements to the website and the forums.<br><br><hr class="thin-line">
            <h1>TurboWarp is Back!</h1> <small>(Tue, Jun 16, 2026)</small><hr class="thin-line"><br>
                 We brought back the TurboWarp editor, because some projects couldn't stand the PenguinMod editor.<br><br><hr class="thin-line">
            <h1>TurboWarp is now PenguinMod!</h1> <small>(Wed, Jun 10, 2026)</small><hr class="thin-line"><br>
                 We changed TurboWarp into PenguinMod because PenguinMod has more features than TurboWarp, and it's also compatible with TurboWarp and Scratch. Please clear your browser's cache to make sure you have no problems.<br><br><hr class="thin-line">
            <h1>New Wrappertube IRC Channel on Rizon Chat!</h1> <small>(Mon, Jun 08, 2026)</small><hr class="thin-line"><br>
                 New Wrappertube IRC Channel on Rizon Chat! <a href="/forum/thread?v=126">Read more here.</a><br><br><hr class="thin-line">
            <h1>Removed Upload Captcha.</h1> <small>(Mon, Apr 27, 2026)</small><hr class="thin-line"><br>
                 Removed the captcha in the upload page because of uploading captcha issues. If you were having issues with the uploader, it should work now.<br><br><hr class="thin-line">
            <h1>New WrapperTube Telegram Group!</h1> <small>(Sat, Apr 25, 2026)</small><hr class="thin-line"><br>
                 New WrapperTube Telegram Group at <a href="https://t.me/WrapperTube" target="_blank">https://t.me/WrapperTube</a>. Join the group today.<br><br><hr class="thin-line">
            <h1>New Paint Editors!</h1> <small>(Fri, Apr 24, 2026)</small><hr class="thin-line"><br>
                 I added new paint editors on the site. They are Chicken Paint, Tegaki, PaintBBS Neo, Shi-Painter, and Klecks. All of them are Oekaki applets but with file uploading and downloading. Try them out today, and draw your own pictures!<br><br><hr class="thin-line">
            <h1>New Official WrapperTube CyTube! Watch videos together!</h1> <small>(Sat, Apr 18, 2026)</small><hr class="thin-line"><br>
                 wrappertube's watch party. it's the place to watch videos together. <a href="/forum/thread?v=120">Read more here.</a><br><br><hr class="thin-line">
            <h1>Little Update.</h1> <small>(Sun, Mar 1, 2026)</small><hr class="thin-line"><br>
                 Added font and border radius customization for channels, so you don't have to use CSS.<br><br><hr class="thin-line">
            <h1>New Forum improvements and new emoticons!</h1> <small>(Sat, Feb 14, 2026)</small><hr class="thin-line"><br>
                 Improved the forums by adding quoting to posts, forum signatures, and styling for BBCode elements. I also added more emoticons, and fixed bugs too.<br><br><hr class="thin-line">
            <h1>New Snap Editor!</h1> <small>(Sat, Feb 7, 2026)</small><hr class="thin-line"><br>
                 I added the Snap editor, and also added Snap project support, along with Silverlight and Shockwave projects. I also improved Chibi Paint, you can now download and upload images.<br><br><hr class="thin-line">
            <h1>Alright.</h1> <small>(Mon, Jan 26, 2026)</small><hr class="thin-line"><br>
                I increased the character limit in playlist and group description and also increased the character limit in forum posts, replies, and PMs too. I also fixed bugs that affect the layout, and other bugs too. Remember, clear your cache.<br><br><hr class="thin-line">
            <h1>Player and Scratch 2.0 improvements.</h1> <small>(Sun, Jan 25, 2026)</small><hr class="thin-line"><br>
                Flash supported browsers use the Youtube 2008 player now instead of JWPlayer, and DewPlayer for audio. Scratch 2.0 improvements: updated player to the latest version, switched from s2online to actual Scratch 2.0, and added a "open in editor" button for Scratch 2.0 and 1.x projects.<br><br><hr class="thin-line">
            <h1>Also more improvements.</h1> <small>(Sun, Jan 18, 2026)</small><hr class="thin-line"><br>
                I added a new custom tab and custom layout for 2012 pages, it's the same as the 2009 custom widget, but a page. I also added improvements to the search feature. You can now remove videos in playlists. Also, I fixed bugs in the site, and bugs that appear on old browsers. Finally, I updated the video response page, and the 2012 playlists page.<br><br><hr class="thin-line">
            <h1>Some improvements.</h1> <small>(Sun, Jan 11, 2026)</small><hr class="thin-line"><br>
                I added a search bar on channel pages with Channel 1.0 and Channel 2.0. I also fixed weird glitches too and more.<br><br><hr class="thin-line">
            <h1>Updates.</h1> <small>(Fri, Jan 9, 2026)</small><hr class="thin-line"><br>
                I added more colour options for channels, and transparent colours. I also fixed some bugs.<br><br><hr class="thin-line">
            <h1>New WrapperTube IRC Server!</h1> <small>(Mon, Jan 5, 2026)</small><hr class="thin-line"><br>
                New WrapperTube IRC Server at <a href="irc://irc.wrappertube.org/" target="_parent">irc://irc.wrappertube.org/</a> To join the server, you need an IRC client. Try using HexChat, ChatZilla, or any IRC client. If you want help in using IRC, go to this link: <a href="https://libera.chat/guides/" target="_blank">https://libera.chat/guides/</a> Stop using the Google Group and the D*****d, use the forums and the IRC instead.<br><br><hr class="thin-line">
            <h1>Happy New Year!</h1> <small>(Wed, Dec 31, 2025)</small><hr class="thin-line"><br>
                I finally made WrapperTube work on older browsers. There is now a flash player for older browsers that can't handle HTML5. Also, Scratch 2.0 is BACK!!! o(≧▽≦)o Scratch 2.0 projects now have the Scratch 2 player, and there is now a Scratch 2.0 editor!!! (((o(*°▽°*)o))) YAY!!! Welcome back, Scratch 2.0! We have missed you so much! (☆ω☆) Not only did I bring back Scratch 2.0, I also added a new paint editor, Chibi Paint! It's a good paint editor! I also added a link to more paint editors, if you want to try other paint editors, and a link to Newart.ru, which has a lot of art! Also, Happy New year 2026! I home 2026 will be a better year than 2025!<br><br><hr class="thin-line">
            <h1>New RSS Feeds!</h1> <small>(Thu, Dec 25, 2025)</small><hr class="thin-line"><br>
                I added RSS feeds for channels, your suscriptions, videos, playlists, and groups. <a href="/forum/thread?v=87">Read more here</a>.<br><br><hr class="thin-line">
            <h1>New improvements and features!</h1> <small>(Mon, Dec 22, 2025)</small><hr class="thin-line"><br>
                I added many new features like the paint editor, a captcha, password resetting, account overviews, and email and password changing. I also reduced the comment and upload cooldowns to half. Bugs are also fixed, too. Oh, and I also added a kaomoji picker because they are better and cuter than emoticons.<br><br><hr class="thin-line">
            <h1>New rule change!</h1> <small>(Sat, Dec 13, 2025)</small><hr class="thin-line"><br>
                <a href="http://wrappertube.org/forum/thread?v=81">Read this please.</a><br><br><hr class="thin-line">
            <h1>New star ratings!</h1> <small>(Thu, Dec 11, 2025)</small><hr class="thin-line"><br>
                I replaced the likes and dislikes with star ratings. Likes and dislikes are now five and one star ratings, respectively.<br><br><hr class="thin-line">
            <h1>Merry Christmas from WrapperTube and GoldAnimate!</h1> <small>(Sun, Nov 30, 2025)</small><hr class="thin-line"><br>
                Thank you people for using my website! I just introduced many new improvements in my website. The "Watch later" button now works, new Christmas theme, and new profile snow you can add to your profile! I also added more features, and playlist video thumbnails now show. ^_^<br><br><hr class="thin-line">
            <h1>WRAPPERTUBE IMPROVEMENTS!</h1> <small>(Sat, Nov 22, 2025)</small><hr class="thin-line"><br>
                Wrappertube has improved with many new features like improved groups, comment disabling, and much much more!<br><br><hr class="thin-line">
            <h1>EVEN MORE NEW FEATURES!</h1> <small>(Sat, Nov 8, 2025)</small><hr class="thin-line"><br>
                Wrappertube includes even more new like the channel 2.0 layout and groups. Check it out today! Also, make a project today with the Scratch Editor!<br><br><hr class="thin-line">
            <h1>NEW FEATURES!</h1> <small>(Wed, Nov 5, 2025)</small><hr class="thin-line"><br>
                Wrappertube includes many new features like the 2009 channel layout and the community forums. Check it out today! Also, make a project today with the Scratch Editor!<br><br><hr class="thin-line">
            </div>
            <i>...and then there was nothing...</i>
        </div>
        <div class="www-core-container">
        <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/module/footer.php"); ?>
        </div>
        <script src="/static/js/prefixfree.min.js"></script>
    </body>
</html>
