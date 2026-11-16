<?php 
require($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php");

if(isset($_SESSION['siteusername'])) {
    session_start();
    $_SESSION = [];
    session_destroy();
}
header("Location: /");
die();
