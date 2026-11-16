<?php 
require($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php");
if(!isset($_SESSION['siteusername'])) { header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found"); include $_SERVER['DOCUMENT_ROOT'] . '/404.php'; die(); }
if(!$_SESSION['adminlogin']) { header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found"); include $_SERVER['DOCUMENT_ROOT'] . '/404.php'; die(); }

session_start();
unset($_SESSION['adminlogin']);
$_SESSION['siteusername'] = $_SESSION['adminloginoriginalusername'];
unset($_SESSION['adminloginoriginalusername']);
session_write_close();

header("Location: /funny_casablanka/bans");
die();
