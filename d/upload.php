<?php
ini_set( 'max_execution_time', '5000' );
ini_set( 'max_input_time', '5000' );
set_time_limit( 5000 );
?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_update.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_insert.php"); ?>
<?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__user_u = new user_update($__db); ?>
<?php $__user_i = new user_insert($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php if(!isset($_SESSION['siteusername'])) { header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden"); echo "you are not logged in"; die(); } ?>
<?php
if (file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/static/important/lockdown_mode.txt")=="on") {die("WrapperTube is currently experiencing an attack from vandals. Some of the site features have been temporarily disabled. Please try again later.");}
    $rid = "";
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-_';
    for ($i = 0; $i < 11; $i++)
        $rid .= $characters[mt_rand(0, 63)];

    $video_properties = (object) [
        'video_rid' => $rid,
        'video_title' => $_POST['title'],
        'video_description' => $_POST['description'],
        'video_tags' => $_POST['tags'],
        'video_category' => $_POST['category'],
        'video_availability' => $_POST['privacy'],
        'video_filename' => "", // we will update this later
        'video_thumbnail' => "",
        'video_xml' => "",
        'video_duration' => 0,
        'video_author' => $_SESSION['siteusername'],
        'video_type' => ""
    ];

    $video_validation = (object) [
        'upload_ok' => true,
        'upload_error' => "",
        'moved_files' => true,
        'video_file_type' => "." . strtolower(pathinfo($_FILES["video_file"]["name"], PATHINFO_EXTENSION)),
        'target_upload_name' => md5_file($_FILES["video_file"]["tmp_name"]) . ".mp4",
    ];

    // $_FILES['video_file']['tmp_name'] = substr_replace($_FILES['video_file']['tmp_name'], '/', 8, 0);
    /* -- /tmp/phpfAN4Xu -- Why in the screw does this happen? I love PHP */

    if($__user_h->if_upload_cooldown($_SESSION['siteusername'])) { 
        $video_validation->upload_error = "Under an upload cooldown. Wait a minute before uploading.";
        $video_validation->upload_ok = 0;
	die($video_validation->upload_error);
    }

if (!$__user_h->if_partner($_SESSION['siteusername'])) {
    if(!isset($_POST['_LONG_CAPTCHA'])){ 
        $video_validation->upload_error = "captcha validation failed";
        $video_validation->upload_ok = 0;
        die($video_validation->upload_error);
    }

    if(!$__user_i->validateLongCaptchaNew($_POST['_LONG_CAPTCHA_KEY'], $_POST['_LONG_CAPTCHA'])) { 
        $video_validation->upload_error = "captcha validation failed";
        $video_validation->upload_ok = 0;
        die($video_validation->upload_error);
    }
}

    if(move_uploaded_file(
        $_FILES['video_file']['tmp_name'], 
        "../dynamic/temp/" . $video_properties->video_rid . $video_validation->video_file_type
    )) {
        $video_properties->video_filename = "../dynamic/temp/" . $video_properties->video_rid . $video_validation->video_file_type;
    } else {
        $video_validation->upload_error = "Failed to move temp file to dynamic folder. Pottential IO/permission problem." . $_FILES['video_file']['error'];
        $video_validation->upload_ok = 0;
        die($video_validation->upload_error);
    }

    if( $video_validation->video_file_type == ".png" || 
        $video_validation->video_file_type == ".jpg" || 
        $video_validation->video_file_type == ".jpeg" || 
        $video_validation->video_file_type == ".jpe" ||
        $video_validation->video_file_type == ".gif" ||
        $video_validation->video_file_type == ".bmp"
    ) {
        $video_properties->video_type = "image";
    } elseif ( $video_validation->video_file_type == ".mp3" ||
        $video_validation->video_file_type == ".wav" ||
        $video_validation->video_file_type == ".m4a" ||
        $video_validation->video_file_type == ".aac" ||
        $video_validation->video_file_type == ".wma" ||
        $video_validation->video_file_type == ".ogg" ||
        $video_validation->video_file_type == ".aiff" ||
        $video_validation->video_file_type == ".flac" ||
        $video_validation->video_file_type == ".mpc"
    ) {
        $video_properties->video_type = "audio";
    } elseif ( $video_validation->video_file_type == ".flv" ||
        $video_validation->video_file_type == ".mkv" ||
        $video_validation->video_file_type == ".avi" ||
        $video_validation->video_file_type == ".mov" ||
        $video_validation->video_file_type == ".movie" ||
        $video_validation->video_file_type == ".qt"||
        $video_validation->video_file_type == ".wmv" ||
        $video_validation->video_file_type == ".asf" ||
        $video_validation->video_file_type == ".mp4" ||
        $video_validation->video_file_type == ".m4v" ||
        $video_validation->video_file_type == ".3gp" ||
        $video_validation->video_file_type == ".3g2" ||
        $video_validation->video_file_type == ".mpg" ||
        $video_validation->video_file_type == ".mpeg"
    ) {
        $video_properties->video_type = "video";
    } elseif ( $video_validation->video_file_type == ".txt" ) {
        $video_properties->video_type = "text";
    } elseif ( $video_validation->video_file_type == ".html" ||
               $video_validation->video_file_type == ".htm" ) {
        $video_properties->video_type = "html";
    } elseif ( $video_validation->video_file_type == ".pdf" ) {
        $video_properties->video_type = "pdf";
    } elseif ( $video_validation->video_file_type == ".swf" ) {
        $video_properties->video_type = "flash";
    } elseif ( $video_validation->video_file_type == ".dcr" ) {
        $video_properties->video_type = "shockwave";
    } elseif ( $video_validation->video_file_type == ".xap" ) {
        $video_properties->video_type = "silverlight";
    } elseif ( $video_validation->video_file_type == ".scratch" ||
        $video_validation->video_file_type == ".sb" ||
        $video_validation->video_file_type == ".sb2" ||
        $video_validation->video_file_type == ".sb3" ||
        $video_validation->video_file_type == ".pmp"
    ) {
        $video_properties->video_type = "scratch";
    } elseif ( $video_validation->video_file_type == ".xml" ||
        $video_validation->video_file_type == ".ypr"
    ) {
        $video_properties->video_type = "snap";
    } else {
        $video_validation->upload_error = "Unsupported file type." . $_FILES['video_file']['error'];
        $video_validation->upload_ok = 0;
	unlink($video_properties->video_filename);
        die($video_validation->upload_error);
    }

    /* 
        I'm going to hopefully guess that
        user input is fine because I moved
        the temp video name to a randomly 
        generated video ID.....
    */

    if ($video_validation->upload_ok == true) {

        /* Get the video duration if video or audio. */
        if ($video_properties->video_type == "video" || $video_properties->video_type == "audio"){
        $video_properties->video_duration = shell_exec('' . $__server->ffprobe_binary . ' -i ' . escapeshellarg($video_properties->video_filename) . ' -show_entries format=duration -v quiet -of csv="p=0" 2>&1');

        $video_properties->video_duration = round($video_properties->video_duration);
        } else {
        $video_properties->video_duration = 0;
        }

        /* Process the video... */
        if ($video_properties->video_type == "video"){
        $video_validation->video_processing_logs = shell_exec('' . $__server->ffmpeg_binary . ' -hide_banner -loglevel error -i ' . escapeshellarg($video_properties->video_filename) . ' -vcodec h264 -acodec aac -pix_fmt yuv420p -threads 2 -preset medium -vf "scale=-1:480,pad=ceil(iw/2)*2:ceil(ih/2)*2" -b:v 1500k ' . escapeshellarg('../dynamic/videos/' . $video_properties->video_rid . '.mp4') . ' 2>&1');
        $video_validation->video_file_type = ".mp4";
        unlink($video_properties->video_filename); //delete the temp video (it doesn't do it automatically)
        } elseif ($video_properties->video_type == "audio") {
        $video_validation->video_processing_logs = shell_exec('' . $__server->ffmpeg_binary . ' -hide_banner -loglevel error -i ' . escapeshellarg($video_properties->video_filename) . ' -acodec libmp3lame -ar 44100 -ac 2 -b:a 192k -map_metadata 0 -id3v2_version 3 -write_id3v1 1 -threads 2 ' . escapeshellarg('../dynamic/videos/' . $video_properties->video_rid . '.mp3') . ' 2>&1');
        $video_validation->video_file_type = ".mp3";
        unlink($video_properties->video_filename);
        } else {
        rename($video_properties->video_filename, '../dynamic/videos/' . $video_properties->video_rid . $video_validation->video_file_type); //move it
        }


        /* Process the thumbnail... */
        if ($video_properties->video_type == "video"){
        $video_properties->video_thumbnail = shell_exec('' . $__server->ffmpeg_binary . ' -hide_banner -loglevel error -i ' . escapeshellarg('../dynamic/videos/' . $video_properties->video_rid . '.mp4') . ' -vf "select=eq(n\\,34),scale=-1:360" -vframes 1 ' . escapeshellarg('../dynamic/thumbs/' . $video_properties->video_rid . '.png') . ' 2>&1');
        $video_properties->video_thumbnail = $video_properties->video_rid . '.png';
        } elseif ($video_properties->video_type == "image"){ //for images, thumbnail it to a 360p png
	$video_properties->video_thumbnail = shell_exec('convert ' . escapeshellarg('../dynamic/videos/' . $video_properties->video_rid . $video_validation->video_file_type) . ' -resize 640x360 ' . escapeshellarg('../dynamic/thumbs/' . $video_properties->video_rid . '.png') . '');
        $video_properties->video_thumbnail = $video_properties->video_rid . '.png';
        } elseif ($video_properties->video_type == "audio"){ //for audios, extract the album cover
        $video_properties->video_thumbnail = shell_exec('' . $__server->ffmpeg_binary . ' -hide_banner -loglevel error -i ' . escapeshellarg('../dynamic/videos/' . $video_properties->video_rid . '.mp3') . ' -vf scale=-1:360 -an ' . escapeshellarg('../dynamic/thumbs/' . $video_properties->video_rid . '.png') . ' 2>&1');
        $video_properties->video_thumbnail = $video_properties->video_rid . '.png';
        } else {
        $video_properties->video_thumbnail = 'default_'.$video_properties->video_type.'.png'; //we can't even thumbanil it do use the default
        }
        
        /* For some reason, I have to do this manually for only the thumbnail */
        
        $video_properties->video_filename = $video_properties->video_rid . $video_validation->video_file_type;

        $stmt = $__db->prepare("INSERT INTO videos 
                                    (title, author, filename, thumbnail, description, tags, rid, duration, xml, category) 
                                VALUES 
                                    (:title, :author, :filename, :thumbnail, :description, :tags, :rid, :duration, :xml, :category)");
        $stmt->bindParam(":title", $video_properties->video_title);
        $stmt->bindParam(":author", $video_properties->video_author);
        $stmt->bindParam(":filename", $video_properties->video_filename);
        $stmt->bindParam(":thumbnail", $video_properties->video_thumbnail);
        $stmt->bindParam(":description", $video_properties->video_description);
        $stmt->bindParam(":tags", $video_properties->video_tags);
        $stmt->bindParam(":rid", $video_properties->video_rid);
        $stmt->bindParam(":duration", $video_properties->video_duration);
        $stmt->bindParam(":xml", $video_properties->video_xml);
        $stmt->bindParam(":category", $video_properties->video_category);
        $stmt->execute();
        $stmt = null;

        $__user_u->update_cooldown_time($_SESSION['siteusername'], "upload_cooldown");
        echo($video_properties->video_rid);
    } else {
        die($video_validation->upload_error);
    }
?>
