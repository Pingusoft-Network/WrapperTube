<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_update.php"); ?><?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__user_u = new user_update($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php if(!isset($_SESSION['siteusername'])) { header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden"); echo "you are not logged in"; die(); } ?>
<?php
    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }


        if($_SERVER['REQUEST_METHOD'] == 'POST' && @$_GET['n']) {
            if(!empty($_GET["n"]) && $_GET['n'] == "pfp") {
                $target_dir = "../dynamic/pfp/";
                $imageFileType = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
                $target_name = md5_file($_FILES["file"]["tmp_name"]) . "." . $imageFileType;
        	$fileSize = $_FILES["file"]["size"];

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
                    $movedFile = move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
                }
        
                if ($uploadOk) {
                    if ($movedFile) {
                        $stmt = $__db->prepare("UPDATE users SET pfp = :pfp WHERE username = :username");
                        $stmt->bindParam(":pfp", $target_name);
                        $stmt->bindParam(":username", $_SESSION['siteusername']);
                        $stmt->execute();
                        $stmt = null;
                    } else {
                        $fileerror = 'fatal error';
                    }
                }
            }
        } 
if($_SERVER['REQUEST_METHOD'] == 'POST' && @$_FILES['backgroundbgset']) {
            if(!empty($_FILES["backgroundbgset"]["name"])) {
                $target_dir = "../dynamic/banners/";
                $imageFileType = strtolower(pathinfo($_FILES["backgroundbgset"]["name"], PATHINFO_EXTENSION));
                $target_name = md5_file($_FILES["backgroundbgset"]["tmp_name"]) . "." . $imageFileType;
		$fileSize = $_FILES["backgroundbgset"]["size"];

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
    
                if($uploadOk) { 
                    if (file_exists($target_file)) {
                        $movedFile = true;
                    } else {
                        $movedFile = move_uploaded_file($_FILES["backgroundbgset"]["tmp_name"], $target_file);
                    }
                }
    
                if ($uploadOk) {
                    if ($movedFile) {
                        $__user_u->update_row($_SESSION['siteusername'], "2012_bg", $target_name);
                    } else {
                        $fileerror = 'fatal error';
                    }
                }
            }
        }
 if($_SERVER['REQUEST_METHOD'] == 'POST' && @$_FILES['watchsubset']) {
/* non-functional
            echo "asdas";
            if(!empty($_FILES["watchsubset"]["name"])) {
                echo "asdas";

                $target_dir = "../dynamic/banners/";
                $imageFileType = strtolower(pathinfo($_FILES["watchsubset"]["name"], PATHINFO_EXTENSION));
                $target_name = md5_file($_FILES["watchsubset"]["tmp_name"]) . "." . $imageFileType;
    		$fileSize = $_FILES["watchsubset"]["size"];

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
    
                if($uploadOk) { 
                    if (file_exists($target_file)) {
                        $movedFile = true;
                    } else {
                        $movedFile = move_uploaded_file($_FILES["watchsubset"]["tmp_name"], $target_file);
                    }
                }
    
                if ($uploadOk) {
                    if ($movedFile) {
                        $__user_u->update_row($_SESSION['siteusername'], "watch_banner", $target_name);
                    } else {
                        $fileerror = 'fatal error';
                    }
                }
            }
*/
        } 
if($_SERVER['REQUEST_METHOD'] == 'POST' && @$_FILES['bannerset']) {
            if(!empty($_FILES["bannerset"]["name"])) {
                $target_dir = "../dynamic/banners/";
                $imageFileType = strtolower(pathinfo($_FILES["bannerset"]["name"], PATHINFO_EXTENSION));
                $target_name = md5_file($_FILES["bannerset"]["tmp_name"]) . "." . $imageFileType;
    		$fileSize = $_FILES["bannerset"]["size"];

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
    
                if($uploadOk) { 
                    if (file_exists($target_file)) {
                        $movedFile = true;
                    } else {
                        $movedFile = move_uploaded_file($_FILES["bannerset"]["tmp_name"], $target_file);
                    }
                }
    
                if ($uploadOk) {
                    if ($movedFile) {
                        $__user_u->update_row($_SESSION['siteusername'], "banner", $target_name);
                    } else {
                        $fileerror = 'fatal error';
                    }
                } 
            }
        } 
if($_SERVER['REQUEST_METHOD'] == 'POST' && @$_FILES['videopagebanner']) {
            if(!empty($_FILES["videopagebanner"]["name"])) {
                $target_dir = "../dynamic/subscribe/";
                $imageFileType = strtolower(pathinfo($_FILES["videopagebanner"]["name"], PATHINFO_EXTENSION));
                $target_name = md5_file($_FILES["videopagebanner"]["tmp_name"]) . "." . $imageFileType;
    		$fileSize = $_FILES["videopagebanner"]["size"];

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
    
                if($uploadOk) { 
                    if (file_exists($target_file)) {
                        $movedFile = true;
                    } else {
                        $movedFile = move_uploaded_file($_FILES["videopagebanner"]["tmp_name"], $target_file);
                    }
                }
    
                if ($uploadOk) {
                    if ($movedFile) {
                        $__user_u->update_row($_SESSION['siteusername'], "subbutton", $target_name);
                    } else {
                        $fileerror = 'fatal error';
                    }
                }
            }
        }

        if(isset($_POST['bio'])) { 
            $__user_u->update_row($_SESSION['siteusername'], "bio", $_POST['bio']);
        }

        if(isset($_POST['featuredchannels'])) { 
            $__user_u->update_row($_SESSION['siteusername'], "featured_channels", $_POST['featuredchannels']);
        }

        if(isset($_POST['custom_label_title'])) { 
            $__user_u->update_row($_SESSION['siteusername'], "uploaded_videos_title", $_POST['custom_label_title']);
        }

        if(isset($_POST['custom_label_description'])) { 
            $__user_u->update_row($_SESSION['siteusername'], "uploaded_videos_description", $_POST['custom_label_description']);
        }
    
        if(isset($_POST['css'])) {
            $__user_u->update_row($_SESSION['siteusername'], "css", $_POST['css']);
        }

        if(isset($_POST['videoid'])) {
            $__user_u->update_row($_SESSION['siteusername'], "featured", $_POST['videoid']);
        }

        if(!empty($_POST['solidcolor'])) {
            $__user_u->update_row($_SESSION['siteusername'], "2012_bgoption", $_POST['bgoption']);

            if($_POST['bgoption'] == "solid")
                $__user_u->update_row($_SESSION['siteusername'], "2012_bg", "");

            $__user_u->update_row($_SESSION['siteusername'], "primary_color", $_POST['solidcolor']);
        }

        if(!empty($_POST['transparency'])) {
            $__user_u->update_row($_SESSION['siteusername'], "transparency", $_POST['transparency']);
        }

        if(!empty($_POST['radius'])) {
            $__user_u->update_row($_SESSION['siteusername'], "border_radius", $_POST['radius']);
        }

        if(isset($_POST['font'])) {
            $__user_u->update_row($_SESSION['siteusername'], "font", $_POST['font']);
        }

        if(!empty($_POST['genre'])) {
            $__user_u->update_row($_SESSION['siteusername'], "genre", $_POST['genre']);
        }

        if(!empty($_POST['bordercolor'])) {
            $__user_u->update_row($_SESSION['siteusername'], "border_color", $_POST['bordercolor']);
        }

        if(!empty($_POST['country'])) {
            $__user_u->update_row($_SESSION['siteusername'], "country", $_POST['country']);
        }

        if(isset($_POST['header'])) {
            $__user_u->update_row($_SESSION['siteusername'], "custom_header", $_POST['header']);
        }

        if(isset($_POST['realheader'])) {
            $__user_u->update_row($_SESSION['siteusername'], "real_custom_header", $_POST['realheader']);
        }

        if(isset($_POST['customtext'])) {
            $__user_u->update_row($_SESSION['siteusername'], "custom_text", $_POST['customtext']);
        }

        if(isset($_POST['website'])) {
            $__user_u->update_row($_SESSION['siteusername'], "website", $_POST['website']);
        }
    
        if(!empty($_POST['channelboxcolor'])) {
            $__user_u->update_row($_SESSION['siteusername'], "secondary_color", $_POST['channelboxcolor']);
        }

        if(!empty($_POST['backgroundcolor'])) {
            $__user_u->update_row($_SESSION['siteusername'], "third_color", $_POST['backgroundcolor']);
        }

        if(!empty($_POST['textmaincolor'])) {
            $__user_u->update_row($_SESSION['siteusername'], "primary_color_text", $_POST['textmaincolor']);
        }

        if(isset($_POST['banner_image_map'])) {
            $__user_u->update_row($_SESSION['siteusername'], "banner_image_map", $_POST['banner_image_map']);
        }

        if(!empty($_POST['layout_channel'])) {
            if(
                $_POST['layout_channel'] == "feed"      || 
                $_POST['layout_channel'] == "featured"  || 
                $_POST['layout_channel'] == "playlists" || 
                $_POST['layout_channel'] == "everything" ||
                $_POST['layout_channel'] == "custom"
            )
                $__user_u->update_row($_SESSION['siteusername'], "layout", $_POST['layout_channel']);
        }

    if(!empty($_POST['bgoptionset'])) {
        $bgoption = $_POST['bgoption'];
        $bgcolor = $_POST['solidcolor'];
        $default = "default.png";

        $__user_u->update_row($_SESSION['siteusername'], "2012_bgoption", $bgoption);
        
        $__user_u->update_row($_SESSION['siteusername'], "2012_bgcolor", $bgcolor);

        if($bgoption == "solid") {
            $__user_u->update_row($_SESSION['siteusername'], "2012_bg", $default);
        }
    }
    
    skip:

    $response = (object) [
        "profile_picture" => $target_name,
        "bio" => $_POST['bio']
    ];

    echo json_encode($response);
    // print_r($_POST);

    //echo "<script>
    //window.location = '/channel_2?n=" . htmlspecialchars($_SESSION['siteusername']) . "';
    //</script>";
?>
