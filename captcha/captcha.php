<?php
require($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php");
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use SimpleCaptcha\Builder;

session_start();

//remove expired captchas
foreach ($_SESSION['captcha'] as $key => $captchaobject) {
	if (time() >= $captchaobject['expire']) {
		unset($_SESSION['captcha'][$key]);
	}
}

$captcha = Builder::create();

if (!empty($_GET['key']) && !empty($_GET['_CAPTCHA'])) {
	//checking
	if ($_SESSION['captcha'][$_GET['key']]) {
		$captchaobject = $_SESSION['captcha'][$_GET['key']];
		if ( $captchaobject['referer'] == $_SERVER['HTTP_REFERER'] &&
		     $captchaobject['user_agent'] == $_SERVER['HTTP_USER_AGENT'] &&
		     $captchaobject['ip'] == $_SERVER["HTTP_CF_CONNECTING_IP"] &&
		     $captcha->compare($captchaobject['phrase'], $_GET['_CAPTCHA']) &&
		     time() < $captchaobject['expire'] ) {
			echo "CHECK correct";
		} else {
			echo "CHECK fail";
		}
	} else {
		echo "CHECK fail";
	}
} else if (!empty($_GET['key'])) {
	//create
	$_SESSION['captcha'][$_GET['key']] = [
	"referer" => $_SERVER['HTTP_REFERER'],
	"user_agent" => $_SERVER['HTTP_USER_AGENT'],
	"ip" => $_SERVER["HTTP_CF_CONNECTING_IP"],
	"phrase" => $captcha->phrase,
	"expire" => time() + 600,
	];

	echo "NEW " . $captcha->build(180, 60)->inline();
}

session_write_close(); 
