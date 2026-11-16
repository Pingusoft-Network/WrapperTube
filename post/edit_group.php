<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php"); ?>
<?php if(!isset($_SESSION['siteusername'])) { header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden"); echo "you are not logged in"; die(); } ?>
<?php 
$_user_fetch_utils = new user_fetch_utils();
$_video_fetch_utils = new video_fetch_utils();
$_base_utils = new config_setup();

$_base_utils->initialize_db_var($conn);
$_video_fetch_utils->initialize_db_var($conn);
$_user_fetch_utils->initialize_db_var($conn);

$_video = $_video_fetch_utils->fetch_group_id($_GET['id']);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!isset($_SESSION['siteusername'])) { die(header("Location: /sign_in")); } 
    if(!$_user_fetch_utils->if_group_admin($_SESSION['siteusername'], $_video['id'])) { http_response_code(403); die("forbidden"); } 

    $title = @$_POST['title'];
    $description = @$_POST['comment'];
    $tags = @$_POST['tags'];
    $category = @$_POST['category'];
    $joinable = @$_POST['joinable'];
    $group_club = @$_POST['group_club'];

    echo $title;
    echo $description;

    if(!empty($title)) { 
        $stmt = $conn->prepare("UPDATE user_groups SET group_title = ? WHERE `user_groups`.`id` = ?;");
        $stmt->bind_param("ss", $title, $_GET['id']);
        $stmt->execute();
        $stmt->close();

        echo "test!";
    }

    if(isset($description)) { 
        $stmt = $conn->prepare("UPDATE user_groups SET group_description = ? WHERE `user_groups`.`id` = ?;");
        $stmt->bind_param("ss", $description, $_GET['id']);
        $stmt->execute();
        $stmt->close();

        echo "test1!";
    }

    if(!empty($category)) { 
        $stmt = $conn->prepare("UPDATE user_groups SET group_category = ? WHERE `user_groups`.`id` = ?;");
        $stmt->bind_param("ss", $category, $_GET['id']);
        $stmt->execute();
        $stmt->close();

        echo "test3!";
    }

    if(!empty($joinable)) {
if ($joinable=="n") {
        $stmt = $conn->prepare("UPDATE user_groups SET joinable = 'n' WHERE `user_groups`.`id` = ?;");
        $stmt->bind_param("s", $_GET['id']);
        $stmt->execute();
        $stmt->close();
} else if ($joinable=="y") {
        $stmt = $conn->prepare("UPDATE user_groups SET joinable = 'y' WHERE `user_groups`.`id` = ?;");
        $stmt->bind_param("s", $_GET['id']);
        $stmt->execute();
        $stmt->close();
}
    }

    if(!empty($group_club)) {
if ($group_club=="n") {
        $stmt = $conn->prepare("UPDATE user_groups SET group_club = 'n' WHERE `user_groups`.`id` = ?;");
        $stmt->bind_param("s", $_GET['id']);
        $stmt->execute();
        $stmt->close();
} else if ($group_club=="y") {
        $stmt = $conn->prepare("UPDATE user_groups SET group_club = 'y' WHERE `user_groups`.`id` = ?;");
        $stmt->bind_param("s", $_GET['id']);
        $stmt->execute();
        $stmt->close();
}
    }

    if(!empty($_FILES["fileToUpload"]["name"])) {
        $target_dir = "../dynamic/thumbs/";
        $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
        $target_name = md5_file($_FILES["fileToUpload"]["tmp_name"]) . "." . $imageFileType;
            $fileSize = $_FILES["fileToUpload"]["size"];

        $target_file = $target_dir . $target_name;

        $uploadOk = true;
        $movedFile = false;

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $fileerror = 'unsupported file type. must be jpg, png, gif, or jpeg';
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
                $stmt = $conn->prepare("UPDATE user_groups SET group_picture = ? WHERE `user_groups`.`id` = ?;");
                $stmt->bind_param("ss", $target_name, $_GET['id']);
                $stmt->execute();
                $stmt->close();
            } else {
                $fileerror = 'fatal error';
            }
        }

        skip:
        } else {
            //idk
        }
    } 

    
    header("Location: /edit_group?id=" . $_video['id']);
?>
