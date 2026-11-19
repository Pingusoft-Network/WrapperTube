<?php
    $__server = (object) [
        "page_title" => "",
        "featured_channels" => array(), //insert featured channels here
        "ffmpeg_binary" => "ffmpeg", 
        "ffprobe_binary" => "ffprobe", 
        "ffmpeg_threads" => 2, 

        "page_embeds" => (object) [
            "page_title" => "",
            "page_description" => "",
            "page_url" => "",
            "page_image" => "",
        ],

        "db_properties" => (object) [ //configure this to your db settings.
            "db_user" => "changeme",
            "db_password" => "changeme",
            "db_host" => "localhost",
            "db_database" => "changeme",
            "db_connected" => false,
        ], 

        "video_properties" => (object) [ "status" => "unloaded" ],
        "user_properties"  => (object) [ "status" => "unloaded" ],
        "group_properties" => (object) [ "status" => "unloaded" ],
        "forum_properties" => (object) [ "status" => "unloaded" ],
    ];

    try
    {
        $__db = new PDO("mysql:host=".$__server->db_properties->db_host.";dbname=".$__server->db_properties->db_database.";charset=utf8mb4",
            $__server->db_properties->db_user,
            $__server->db_properties->db_password,
            [
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
        $__server->db_properties->db_connected = true;
    }
    catch(PDOException $e)
    {
        die("An error occured connecting to the database: ".$e->getMessage());
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

if (!$ban_info) {
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

function startsWith( $haystack, $needle ) {
     $length = strlen( $needle );
     return substr( $haystack, 0, $length ) === $needle;
}

function endsWith( $haystack, $needle ) {
    $length = strlen( $needle );
    if( !$length ) {
        return true;
    }
    return substr( $haystack, -$length ) === $needle;
}
if(isset($_SESSION['error'])) {
    session_start();
    $session_error = $_SESSION['error'];
    unset($_SESSION['error']);
    session_write_close();
}
?>
