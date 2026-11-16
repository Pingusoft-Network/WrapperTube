<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/update.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/insert.php"); ?>
<?php
    ob_start();

    $_user_fetch_utils = new user_fetch_utils();
    $_video_fetch_utils = new video_fetch_utils();
    $_video_insert_utils = new video_insert_utils();
    $_user_insert_utils = new user_insert_utils();
    $_user_update_utils = new user_update_utils();
    $_base_utils = new config_setup();
    
    $_base_utils->initialize_db_var($conn);
    $_video_fetch_utils->initialize_db_var($conn);
    $_video_insert_utils->initialize_db_var($conn);
    $_user_fetch_utils->initialize_db_var($conn);
    $_user_insert_utils->initialize_db_var($conn);
    $_user_update_utils->initialize_db_var($conn);
?>
<?php if(!isset($_SESSION['siteusername'])) { header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden"); echo "you are not logged in"; die(); } ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['bioset'])) {
        $_user_update_utils->update_user_bio($_SESSION['siteusername'], $_POST['bio']);
    } else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['channelset'])) {
        $_user_update_utils->update_user_channels($_SESSION['siteusername'], $_POST['videoid']);
    } else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['featuredset'])) {
        $_user_update_utils->update_user_featured_video($_SESSION['siteusername'], $_POST['videoid']);
    } else if($_SERVER['REQUEST_METHOD'] == 'POST' && @$_POST['setbannerdisplay']) {
        //setbannerdisplay
        $_user_update_utils->update_user_margin_top($_SESSION['siteusername'], $_POST['bannerdisplay']);
    } else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['twitterset'])) {
        //updateUserTwitter($_SESSION['siteusername'], $_POST['twitter'], $conn);
    } else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['instaset'])) {
        //updateUserInstagram($_SESSION['siteusername'], $_POST['instagram'], $conn);
    } else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['twitchset'])) {
        //updateUserTwitch($_SESSION['siteusername'], $_POST['twitch'], $conn);
    } else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['urlset'])) {
        $_user_update_utils->update_user_website_url($_SESSION['siteusername'], $_POST['customurl']);
    } else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['facebookset'])) {
        //updateUserFacebook($_SESSION['siteusername'], $_POST['facebook'], $conn);
    } else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['customtitleset'])) {
        $_user_update_utils->update_user_featured_title($_SESSION['siteusername'], $_POST['featuredtitle']);
    } else if($_SERVER['REQUEST_METHOD'] == 'POST' && @$_POST['setbannerdisplay']) {
        $_user_update_utils->update_user_banner_display($_SESSION['siteusername'], $_POST['bannerdisplay']);
    } else if($_SERVER['REQUEST_METHOD'] == 'POST' && @$_POST['setchannellayout']) {
        //updateUserChannelLayout($_SESSION['siteusername'], $_POST['channellayout'], $conn);
    } else if($_SERVER['REQUEST_METHOD'] == 'POST' && @$_POST['primary']) {
        $_user_update_utils->update_user_primary_color($_SESSION['siteusername'], $_POST['solidcolor']);
    } else if($_SERVER['REQUEST_METHOD'] == 'POST' && @$_POST['secondary']) {
        $_user_update_utils->update_user_secondary_color($_SESSION['siteusername'], $_POST['solidcolor']);
    } else if($_SERVER['REQUEST_METHOD'] == 'POST' && @$_POST['third']) {
        $_user_update_utils->update_user_third_color($_SESSION['siteusername'], $_POST['solidcolor']);
    } else if($_SERVER['REQUEST_METHOD'] == 'POST' && @$_POST['textcolor']) {
        $_user_update_utils->update_user_text_color($_SESSION['siteusername'], $_POST['solidcolor']);
    } else if($_SERVER['REQUEST_METHOD'] == 'POST' && @$_POST['textprimarycolor']) {
        $_user_update_utils->update_user_primary_text_color($_SESSION['siteusername'], $_POST['solidcolor']);
    } else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['headerset'])) {
        $_user_update_utils->update_user_channel_name($_SESSION['siteusername'], $_POST['videoid']);
    } else if($_SERVER['REQUEST_METHOD'] == 'POST' && @$_POST['countryset']) {
        $_user_update_utils->update_user_country($_SESSION['siteusername'], $_POST['country']);
    } else if($_SERVER['REQUEST_METHOD'] == 'POST' && @$_POST['genreset']) {
        $_user_update_utils->update_user_genre($_SESSION['siteusername'], $_POST['genre']);
    } else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cssset'])) {
        $_user_update_utils->update_user_css($_SESSION['siteusername'], $_POST['css']);
    } else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['contactset'])) {
        $_user_update_utils->update_user_contact_custom_text($_SESSION['siteusername'], $_POST['contact_custom_text']);
    } else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['bannerimagemap'])) {
        $_user_update_utils->update_user_banner_image_map($_SESSION['siteusername'], $_POST['banner_image_map']);
    } else if($_SERVER['REQUEST_METHOD'] == 'POST' && @$_POST['bgoptionset']) {
        $bgoption = $_POST['bgoption'];
        $bgcolor = $_POST['solidcolor'];

        $stmt = $conn->prepare("UPDATE users SET 2012_bgoption = ? WHERE `users`.`username` = ?;");
        $stmt->bind_param("ss", $bgoption, $_SESSION['siteusername']);
        $stmt->execute();
        $stmt->close();    

        $stmt = $conn->prepare("UPDATE users SET 2012_bgcolor = ? WHERE `users`.`username` = ?;");
        $stmt->bind_param("ss", $bgcolor, $_SESSION['siteusername']);
        $stmt->execute();
        $stmt->close();    

        if($bgoption == "solid") {
            $stmt = $conn->prepare("UPDATE users SET 2012_bgcolor = ? WHERE `users`.`username` = ?;");
            $stmt->bind_param("ss", $bgcolor, $_SESSION['siteusername']);
            $stmt->execute();
            $stmt->close();        
            
            $stmt = $conn->prepare("UPDATE users SET 2012_bg = ? WHERE `users`.`username` = ?;");
            $stmt->bind_param("ss", $default, $_SESSION['siteusername']);
            $default = "default.png";
            $stmt->execute();
            $stmt->close();    
        }
        /*
            <select name="bgoption" id="cars">
                <option value="repeaty">Repeat - Y</option>
                <option value="repeatx">Repeat - X</option>
                <option value="repeatxy">Repeat - X and Y</option>
                <option value="stretch">Stretch</option>
                <option value="solid">Solid</option>
            </select>
        */
    } else if($_SERVER['REQUEST_METHOD'] == 'POST' && @$_POST['pfpset']) {

        //This is terribly awful and i will probably put this in a function soon
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/dynamic/pfp/";
        $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
        $target_name = md5_file($_FILES["fileToUpload"]["tmp_name"]) . "." . $imageFileType;
	$fileSize = $_FILES["fileToUpload"]["size"];

        $target_file = $target_dir . $target_name;

        $uploadOk = true;
        $movedFile = false;

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            $fileerror = 'unsupported file type. must be jpg, png, jpeg, or gif';
            $uploadOk = false;
            goto skip;
        }


                if ($fileSize > 1048576) {
                    $fileerror = 'max filesize for pfp is 1MB';
                    $uploadOk = false;
                    goto skip;
                }

        if (file_exists($target_file)) {
            $movedFile = true;
        } else {
            $movedFile = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
        }

        if ($uploadOk) {
            if ($movedFile) {
                $stmt = $conn->prepare("UPDATE users SET pfp = ? WHERE `users`.`username` = ?;");
                $stmt->bind_param("ss", $target_name, $_SESSION['siteusername']);
                $stmt->execute();
                $stmt->close();
            } else {
                $fileerror = 'fatal error';
            }
        }
    } else if($_SERVER['REQUEST_METHOD'] == 'POST' && @$_POST['bgset']) {

      //This is terribly awful and i will probably put this in a function soon
      if(!empty($_FILES["fileToUpload"]["name"])) {
            $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/dynamic/banners/";
            $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
            $target_name = md5_file($_FILES["fileToUpload"]["tmp_name"]) . "." . $imageFileType;
	    $fileSize = $_FILES["fileToUpload"]["size"];

            $target_file = $target_dir . $target_name;

            $uploadOk = true;
            $movedFile = false;

            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                $fileerror = 'unsupported file type. must be jpg, png, jpeg, or gif';
                $uploadOk = false;
                goto skip;
            }

                if ($fileSize > 5242880) {
                    $fileerror = 'max filesize for banner is 5MB';
                    $uploadOk = false;
                    goto skip;
                }

            if (file_exists($target_file)) {
                $movedFile = true;
            } else {
                $movedFile = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
            }

            if ($uploadOk) {
                if ($movedFile) {
                    $stmt = $conn->prepare("UPDATE users SET 2012_bg = ? WHERE `users`.`username` = ?;");
                    $stmt->bind_param("ss", $target_name, $_SESSION['siteusername']);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    $fileerror = 'fatal error';
                }
            }
        }
    } else if($_SERVER['REQUEST_METHOD'] == 'POST' && @$_POST['bannerset']) {

      //This is terribly awful and i will probably put this in a function soon
      if(!empty($_FILES["fileToUpload"]["name"])) {
            $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/dynamic/banners/";
            $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
            $target_name = md5_file($_FILES["fileToUpload"]["tmp_name"]) . "." . $imageFileType;
            $fileSize = $_FILES["fileToUpload"]["size"];

            $target_file = $target_dir . $target_name;

            $uploadOk = true;
            $movedFile = false;

            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                $fileerror = 'unsupported file type. must be jpg, png, jpeg, or gif';
                $uploadOk = false;
                goto skip;
            }

                if ($fileSize > 5242880) {
                    $fileerror = 'max filesize for banner is 5MB';
                    $uploadOk = false;
                    goto skip;
                }

            if (file_exists($target_file)) {
                $movedFile = true;
            } else {
                $movedFile = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
            }

            if ($uploadOk) {
                if ($movedFile) {
                    $stmt = $conn->prepare("UPDATE users SET banner = ? WHERE `users`.`username` = ?;");
                    $stmt->bind_param("ss", $target_name, $_SESSION['siteusername']);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    $fileerror = 'fatal error';
                }
            }
        }
    }  else if($_SERVER['REQUEST_METHOD'] == 'POST' && @$_POST['ssubtset']) {

        
  
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/dynamic/subscribe/";
        $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
        $target_name = md5_file($_FILES["fileToUpload"]["tmp_name"]) . "." . $imageFileType;
            $fileSize = $_FILES["fileToUpload"]["size"];

        $target_file = $target_dir . $target_name;
        
        $uploadOk = true;
        $movedFile = false;

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            $fileerror = 'unsupported file type. must be jpg, png, jpeg, or gif';
            $uploadOk = false;
            
            goto skip;
        }

                if ($fileSize > 5242880) {
                    $fileerror = 'max filesize for banner is 5MB';
                    $uploadOk = false;
                    goto skip;
                }

        
        if (file_exists($target_file)) {
            $movedFile = true;
        } else {
            $movedFile = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
        }

        if ($uploadOk) {
            
            if ($movedFile) {
                
                $stmt = $conn->prepare("UPDATE users SET subbutton = ? WHERE `users`.`username` = ?;");
                $stmt->bind_param("ss", $target_name, $_SESSION['siteusername']);
                $stmt->execute();
                $stmt->close();
            } else {
                $fileerror = 'fatal error';
            }
        }
    }
    skip:

    header("Location: /user/" . $_SESSION['siteusername']);
?>
