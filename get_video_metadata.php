<?php
//after a couple days, I finally got this to work.
//get_video_info took longer, but yeah
//it is incomplete, but it's ok
header('Content-Type: application/json');
require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_update.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_insert.php");
$__db_h = new db_helper();
$__video_h = new video_helper($__db);
$__user_h = new user_helper($__db);
if(!$__video_h->video_exists($_GET['video_id'])) { header("Location: /?error=This video doesn't exist!"); }
$_video = $__video_h->fetch_video_rid($_GET['video_id']);

        if($_video['visibility'] == "v" && @$_SESSION['siteusername'] != $_video['author'] && (!$__user_h->if_moderator(@$_SESSION['siteusername']) && !$__user_h->if_admin(@$_SESSION['siteusername']))) {
                die(header("Location: /?error=This video is private!"));
        }

	$uname = $__video_h->fetch_user_videos($_video['author']); 
	$_video['dislikes'] =  $__video_h->get_video_stars_level($_video['rid'], 1);
			$_video['dislikes'] += $__video_h->get_video_stars_level($_video['rid'], 2);
			$_video['likes'] =     $__video_h->get_video_stars_level($_video['rid'], 4);
			$_video['likes'] +=    $__video_h->get_video_stars_level($_video['rid'], 5);
						$_video['dislikes'] += $__video_h->get_video_likes($_video['rid'], false);
			$_video['likes'] += $__video_h->get_video_likes($_video['rid'], true);


    $_video['stars'] = $__video_h->get_video_stars($_video['rid']) + $__video_h->get_video_likes($_video['rid'], false) + $__video_h->get_video_likes($_video['rid'], true);
    $_video['star_1'] = $__video_h->get_video_stars_level($_video['rid'], 1) + $__video_h->get_video_likes($_video['rid'], false);
    $_video['star_2'] = $__video_h->get_video_stars_level($_video['rid'], 2);
    $_video['star_3'] = $__video_h->get_video_stars_level($_video['rid'], 3);
    $_video['star_4'] = $__video_h->get_video_stars_level($_video['rid'], 4);
    $_video['star_5'] = $__video_h->get_video_stars_level($_video['rid'], 5) + $__video_h->get_video_likes($_video['rid'], true);

    if($_video['stars'] != 0) {
        @$_video['star_ratio'] = (
            $_video['star_5'] * 5 + 
            $_video['star_4'] * 4 + 
            $_video['star_3'] * 3 + 
            $_video['star_2'] * 2 + 
            $_video['star_1'] * 1
        ) / (
            $_video['star_5'] + 
            $_video['star_4'] + 
            $_video['star_3'] + 
            $_video['star_2'] + 
            $_video['star_1']
        );

        $_video['star_ratio'] = floor($_video['star_ratio'] * 2) / 2;
    } else { 
        $_video['star_ratio'] = 0;
    }

	$userdetail = array(
	'channel_logo_url' => '/dynamic/pfp/' . htmlspecialchars($__user_h->fetch_pfp($_video['author'])),
	'username' => htmlspecialchars($_video['author']),
	'subscriber_count' => $__user_h->fetch_subs_count($_video['author']),
	'subscription_button_html' => '<span class=\" yt-uix-button-subscription-container\" ><button onclick=";subscribe();return false;"  type=\"button\" class=\"yt-uix-subscription-button yt-uix-button yt-uix-button-subscribe-branded yt-uix-button-size-default\" aria-live=\"polite\" aria-busy=\"false\" onclick=\";return false;\" aria-role=\"button\" data-channel-external-id=\"UCBR8-60-B28hp2BmDPdntcQ\" data-style-type=\"branded\" data-sessionlink=\"feature=html5-player&amp;ei=mXUPUtbaDOOQhgGv14H4Ag\" role=\"button\">    <span class=\"yt-uix-button-icon-wrapper\">\n      <img class=\"yt-uix-button-icon yt-uix-button-icon-subscribe\" src=\"//s.ytimg.com/yts/img/pixel-vfl3z5WfW.gif\" alt=\"\" title=\"\">\n      <span class=\"yt-uix-button-valign\"></span>\n    </span>\n    <span class=\"yt-uix-button-content\">\n<span class=\"subscribe-label\" aria-label=\"Subscribe\">Subscribe</span><span class=\"subscribed-label\" aria-label=\"Unsubscribe\">Subscribed</span><span class=\"unsubscribe-label\" aria-label=\"Unsubscribe\">Unsubscribe</span> \n    </span>\n</button><span class=\"yt-subscription-button-subscriber-count-branded-horizontal\" >10M</span>  <span class=\"yt-subscription-button-disabled-mask\" title=\"\"></span>\n</span>',
	'image_url' => '/dynamic/pfp/' . htmlspecialchars($__user_h->fetch_pfp($_video['author'])),
	'public_name' => htmlspecialchars($_video['author']),
	'channel_title' => htmlspecialchars($__user_h->fetch_user_username($_video['author'])['custom_header']),
	'subscriber_count_string' => $__user_h->fetch_subs_count($_video['author']) . ' subscribers'
	);
	$videodetail = array(
        'title' => $_video['title'],
	'view_count_string' => '<strong>' . $__video_h->fetch_video_views($_GET['video_id']) . '</strong> views', 
	'description' => $_video['description'],
	'parsed_description' => $__video_h->shorten_description($_video['description'], 999999, true),
	'dislikes_count_unformatted' => $_video['dislikes'],
	'likes_count_unformatted' => $_video['likes'],
	'likes_dislikes_string' => ($_video['likes']) . ' ' . 'likes, ' . ($_video['dislikes'])  . ' ' . 'dislikes',
	'view_count' => $__video_h->fetch_video_views($_GET['video_id']),
        'uploaded_date' => date("M d, Y", strtotime($_video['publish'])),
        'tags' => $_video['tags'],
        'thumb' => "/dynamic/thumbs/" . $_video['thumbnail'],
        'category' => $_video['category'],
        'stars' => $_video['stars'],
	'star_5' => $_video['star_5'],
        'star_4' => $_video['star_4'],
        'star_3' => $_video['star_3'],
        'star_2' => $_video['star_2'],
        'star_1' => $_video['star_1'],
        'star_ratio' => $_video['star_ratio'],
        'i_liked' => $__video_h->fetch_user_rating($_video['rid'], $_SESSION['siteusername'])==4 || $__video_h->fetch_user_rating($_video['rid'], $_SESSION['siteusername'])==5 || $__video_h->if_liked($_SESSION['siteusername'], $_video['rid'], true),
        'i_disliked' => $__video_h->fetch_user_rating($_video['rid'], $_SESSION['siteusername'])==1 || $__video_h->fetch_user_rating($_video['rid'], $_SESSION['siteusername'])==2 || $__video_h->if_liked($_SESSION['siteusername'], $_video['rid'], false),
        'i_favourited' => $__video_h->if_favorited($_SESSION['siteusername'], $_video['rid']),
        'my_rating' => $__video_h->fetch_user_rating($_video['rid'], $_SESSION['siteusername'])?$__video_h->fetch_user_rating($_video['rid'], $_SESSION['siteusername']):($__video_h->if_liked($_SESSION['siteusername'], $_video['rid'], true)?5:($__video_h->if_liked($_SESSION['siteusername'], $_video['rid'], false)?1:0))
	);
	$json = array(
	'user_info' => $userdetail,
	'video_info' => $videodetail
	);
	echo json_encode($json);
?>
