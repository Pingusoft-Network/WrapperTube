<?php
$kakiWidth = intval($_GET['width']) ? intval($_GET['width']) : 400;
$kakiHeight = intval($_GET['height']) ? intval($_GET['height']) : 300;
  if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_FILES["openImage"]))
  {
    $uploaddir = './upload/';
    $file = $_FILES['openImage']['name'];
    $ext = (strpos($file, '.') === FALSE) ? '' : substr($file, strrpos($file, '.'));
    $uploadfile = $uploaddir . $_SERVER['REMOTE_ADDR'];
    if ($ext != ".png" && $ext != ".jpg" && $ext != ".jpeg" && $ext != ".bmp" && $ext != ".gif" && $ext != ".chi") {
        $errmsg = "Invalid File Type. Supported types: png jpg jpeg bmp gif chi";
        goto skip;
    }
    if ($_FILES['openImage']['size'] > 31457280) {
        $errmsg = "Max file size is 30MB.";
        goto skip;
    }

    $success = TRUE;

    $success = $success && move_uploaded_file($_FILES['openImage']['tmp_name'], $uploadfile . $ext);
    if ($success) {
      if ($ext == ".chi") {
        $kakiFile = $uploadfile . $ext;
      } else {
        $kakiImage = $uploadfile . $ext;
      }
    } else {
      $errmsg = "Failed to load file.";
      goto skip;
    }
  }
  skip:
?>
<!DOCTYPE html>
<html>
    <head>
        <title>ChickenPaint - WrapperTube</title>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta http-equiv="content-script-type" content="text/javascript">
        <meta http-equiv="content-style-type" content="text/css">
        <meta name="theme-color" content="red">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
        <style type="text/css">
            body, html {
                width: 100%;
                height: 100%;
                padding: 0;
                margin: 0;
            }
            body {
                overflow: hidden;
                -webkit-touch-callout: none; /* iOS Safari */
                -webkit-user-select: none; /* Chrome, Safari, Opera */
                -khtml-user-select: none; /* Konqueror HTML */
                -moz-user-select: none; /* Firefox */
                -ms-user-select: none; /* Internet Explorer 10+ and Edge */
                user-select: none; /* Standard property */
                font-family: Verdana, Tahoma, "MS Sans Serif", Arial, Helvetica, sans-serif;
                font-size: 11px;
                cursor: default;
            }
            #container {
                width: 100%;
                height: 100%;
            }
            .menuitem {
                border-style: none;
                background-color: #EEEEEE;
            }
        </style>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/redmond/jquery-ui.css">
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <link rel="stylesheet" type="text/css" href="./css/chickenpaint.css">
        <?php
        if (!empty($errmsg)) {
        ?>
        <script type="text/javascript" language="JavaScript">
        alert(<?php echo json_encode($errmsg); ?>);
        </script>
        <?php
        }
        ?>
        <script src="./js/chickenpaint.min.js"></script>
    </head>
    <body unselectable="on">
    <table id="container" border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
    <tr>
    <td width="100%" height="25" bgcolor="#EEEEEE">
    <input type="button" value="New" class="menuitem" onclick="$('#newDialogue').dialog('open');">
    <input type="button" value="Open" class="menuitem" onclick="$('#openImage').click();">
    </td>
    </tr>
    <tr>
    <td width="100%" height="100%" align="center" valign="center">
    <div id="chickenpaint-parent">
    </div>
    </td>
    </tr>
    </table>
    <div id="newDialogue" title="New Image">
        <form method="get" action="./">
        <p>Width <input type="number" name="width" value="<?php echo $kakiWidth; ?>"></p>
        <p>Height <input type="number" name="height" value="<?php echo $kakiHeight; ?>"></p>
        <input type="submit" value="New Image" style="display:none;">
        </form>
    </div>
    <form id="imageOpen" method="post" action="./" enctype='multipart/form-data' style="display:none;">
        <input type="file" name="openImage" id="openImage" onchange="$('#imageOpen').submit();">
    </form>
    <script type="text/javascript" language="JavaScript">
        $(function() {
            $( "#newDialogue" ).dialog({
                autoOpen: false,
                resizable: false,
                buttons: {
                    "New Image": function() { $(this).find('form').submit(); },
                    "Cancel": function() { $(this).dialog('close'); }
                },
                close: function() { $(this).find('form')[0].reset(); }
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            new ChickenPaint({
                uiElem: document.getElementById("chickenpaint-parent"),
                <?php if ($kakiImage) { ?>loadImageUrl: "<?php echo htmlspecialchars($kakiImage); ?>",<?php } ?>
                <?php if ($kakiFile) { ?>loadChibiFileUrl: "<?php echo htmlspecialchars($kakiFile); ?>",<?php } ?>
                canvasWidth: <?php echo $kakiWidth; ?>,
                canvasHeight: <?php echo $kakiHeight; ?>,
                allowDownload: true,
                resourcesRoot: "./",
                disableBootstrapAPI: true,
                fullScreenMode: "auto"
            });
        });
    </script>
    </body>
</html>
