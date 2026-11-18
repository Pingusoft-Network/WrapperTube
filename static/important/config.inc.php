<?php
$config = array(); // add other stuff here
$post = array(); // used for handling post inputs, put sanitized inputs into here!!!

//configure this to your db settings.
$config['db_host'] = "localhost";
$config['db_user'] = "rickastley";
$config['db_pass'] = "meow";
$config['db_name'] = "wrappertube";
$config['db_connected'] = false;

$config["featured_channels"] = array(); //insert featured channels here

$config['recaptcha_secret'] = "changeme";  //change this when using recaptcha/hcaptcha
$config['recaptcha_sitekey'] = "changeme"; //change this when using recaptcha/hcaptcha

$conn = mysqli_connect($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);

if (!isset($__db)) {
    try
    {
        $__db = new PDO("mysql:host=".$config['db_host'].";dbname=".$config['db_name'].";charset=utf8mb4",
            $config['db_user'],
            $config['db_pass'],
            [
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
        $config['db_connected'] = true;
    }
    catch(PDOException $e)
    {
        die("An error occured connecting to the database: ".$e->getMessage());
    }
}

    ini_set( 'upload_max_filesize' , '200M' );
    ini_set( 'post_max_size', '210M');

    ini_set('session.cookie_httponly', 1);
    ini_set('session.gc_maxlifetime', 2592000);
    session_set_cookie_params(2592000);
    session_start([
    'read_and_close' => true
]);
    /* NOT RUNNING UNDER CF CHECK */
    $_SERVER["HTTP_CF_CONNECTING_IP"] = $_SERVER['REMOTE_ADDR'];
    /* IP BANS */
    $stmt = $__db->prepare("SELECT * FROM bans WHERE username = :username LIMIT 1");
    $stmt->bindParam(":username", $_SERVER["HTTP_CF_CONNECTING_IP"]);
    $stmt->execute();

    while($ban = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ban_info = $ban;
        if($_SERVER['REQUEST_URI'] != "/ip_ban" && $_SERVER['REQUEST_URI'] != "/ban" && $_SERVER['REQUEST_URI'] != "/logout")
            die(header("Location: /ip_ban"));
    }
    $stmt = null;

if (!isset($ban_info)) {
    /* NORMAL BANS */
if(!isset($_SESSION['adminlogin'])) {
    $stmt = $__db->prepare("SELECT * FROM bans WHERE username = :username LIMIT 1");
	$stmt->bindParam(":username", $_SESSION['siteusername']);
	$stmt->execute();

	while($ban = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ban_info = $ban;
        if($_SERVER['REQUEST_URI'] != "/ban" && $_SERVER['REQUEST_URI'] != "/ip_ban" && $_SERVER['REQUEST_URI'] != "/logout")
		    die(header("Location: /ban"));
	}
	$stmt = null;
}
}
if(isset($_SESSION['error'])) {
    session_start();
    $session_error = $_SESSION['error'];
    unset($_SESSION['error']);
    session_write_close();
}
?>
