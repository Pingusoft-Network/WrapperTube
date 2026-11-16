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
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_updater.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_update.php"); ?><?php $__video_h = new video_helper($__db); ?>
<?php $__video_u = new video_updater($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__user_u = new user_update($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php
    $_video = $__video_h->fetch_video_rid($_GET['v']);
    if($_video['author'] != @$_SESSION['siteusername']) {
        die();
    }

    header("Content-type: application/json");

    $request = (object) [
        "title" => $_POST['title'],
        "description" => $_POST['description'],
        "tags" => $_POST['tags'],
        "privacy" => $_POST['privacy'],
         /* 
            Public   : n
            Unlisted : u
            Private  : v
         */
        "thumbnail" => $_FILES['thumbnail'],
        "category" => $_POST['category'],
	"filename" => $_FILES['video_file'],

        "error" => (object) [
            "message" => "",
            "status" => "OK"
        ]
    ]; 

    $__video_u->update_row($_GET['v'], "title", $request->title);
    $__video_u->update_row($_GET['v'], "description", $request->description);
    $__video_u->update_row($_GET['v'], "tags", $request->tags);
    $__video_u->update_row($_GET['v'], "visibility", $request->privacy);
    // $__video_u->update_row($_GET['v'], "thumbnail", $request->thumbnail);
    $__video_u->update_row($_GET['v'], "category", $request->category);

    if($_SERVER['REQUEST_METHOD'] == 'POST' && @$_FILES['thumbnail']) {
        if(!empty($_FILES["thumbnail"]["name"])) {
            $target_dir = "../dynamic/thumbs/";
            $imageFileType = strtolower(pathinfo($_FILES["thumbnail"]["name"], PATHINFO_EXTENSION));
            $target_name = md5_file($_FILES["thumbnail"]["tmp_name"]) . "." . $imageFileType;
            $fileSize = $_FILES["thumbnail"]["size"];
    
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
                $movedFile = move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file);
            }
    
            if ($uploadOk) {
                if ($movedFile) {
                    $stmt = $__db->prepare("UPDATE videos SET thumbnail = :thumbnail WHERE rid = :rid");
                    $stmt->bindParam(":thumbnail", $target_name);
                    $stmt->bindParam(":rid", $_video['rid']);
                    $stmt->execute();
                    $stmt = null;
                } else {
                    $fileerror = 'fatal error';
                }
            }
        }
    } 

    if($_SERVER['REQUEST_METHOD'] == 'POST' && @$_FILES['video_file']) {
        if(!empty($_FILES["video_file"]["name"])) {
    $rid = $_video['rid'];
    $video_properties = (object) [
        'video_rid' => $_video['rid'],
        'video_filename' => "", // we will update this later
        'video_duration' => 0,
        'video_author' => $_SESSION['siteusername'],
        'video_type' => "",
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

    if(move_uploaded_file(
        $_FILES['video_file']['tmp_name'],
        "../dynamic/temp/" . $_video['rid'] . $video_validation->video_file_type
    )) {
        $video_properties->video_filename = "../dynamic/temp/" . $video_properties->video_rid . $video_validation->video_file_type;
    } else {
        $video_validation->upload_error = "Failed to move temp file to dynamic folder. Pottential IO/permission problem." . $_FILES['video_file']['error'];
        $video_validation->upload_ok = 0;
                $fileerror = "Failed to move temp file to dynamic folder. Pottential IO/permission problem." . $_FILES['video_file']['error'];
                $uploadOk = false;
                goto skip;
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
                $fileerror = 'unsupported file type.' . $_FILES['video_file']['error'];
                $uploadOk = false;
        unlink($video_properties->video_filename);
goto skip;
    }

    /*
        I'm going to hopefully guess that
        user input is fine because I moved
        the temp video name to a randomly
        generated video ID.....
    */

    if ($video_validation->upload_ok == true) {
$uploadOk = true;
        /* Get the video duration if video or audio. */
        if ($video_properties->video_type == "video" || $video_properties->video_type == "audio"){
        $video_properties->video_duration = shell_exec('' . $__server->ffprobe_binary . ' -i ' . escapeshellarg($video_properties->video_filename) . ' -show_entries format=duration -v quiet -of csv="p=0" 2>&1');

        $video_properties->video_duration = round($video_properties->video_duration);
        } else {
        $video_properties->video_duration = 0;
        }

        /* Process the video... */
	unlink('../dynamic/videos/' . $_video['filename']);
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


        /* For some reason, I have to do this manually for only the thumbnail */

        $video_properties->video_filename = $video_properties->video_rid . $video_validation->video_file_type;

        $stmt = $__db->prepare("UPDATE videos
                                    SET filename = :filename, duration = :duration
                                WHERE
                                    rid = :rid");
        $stmt->bindParam(":filename", $video_properties->video_filename);
        $stmt->bindParam(":duration", $video_properties->video_duration);
        $stmt->bindParam(":rid", $rid);
        $stmt->execute();
        $stmt = null;
    } else {
                $fileerror = $video_validation->upload_error;
                $uploadOk = false;
        die($video_validation->upload_error);
    }
        }
    }

        $stmt = $__db->prepare("UPDATE videos SET last_modified = CURRENT_TIMESTAMP WHERE rid = :rid");
        $stmt->bindParam(":rid", $_GET['v']);
        $stmt->execute();
        $stmt = null;

    skip:

    echo json_encode($request, JSON_PRETTY_PRINT);
?>
