<?php
  if (isset($_FILES["picture"]))
  {
    header ('Content-type: text/plain');

    $uploaddir = './pictures/';
    $file = $_FILES['picture']['name'];
    $ext = (strpos($file, '.') === FALSE) ? '' : substr($file, strrpos($file, '.'));
    $uploadfile = $uploaddir . $_SERVER['REMOTE_ADDR'];
    if ($ext != ".png" && $ext != ".jpg" && $ext != ".jpeg" && $ext != ".bmp" && $ext != ".gif") {
        die("CHIBIERROR Invalid Image\n");
    }
    if ($_FILES['picture']['size'] > 31457280) {
        die("CHIBIERROR File size limit exceeded\n");
    }

    $success = TRUE;
    if (isset($_FILES["chibifile"])) {
      if ($_FILES['chibifile']['size'] < 31457280) {
        $success = $success && move_uploaded_file($_FILES['chibifile']['tmp_name'], $uploadfile . ".chi");
      }
    }

    $success = $success && move_uploaded_file($_FILES['picture']['tmp_name'], $uploadfile . $ext);
    if ($success) {
      echo "CHIBIOK\n";
    } else {
      echo "CHIBIERROR\n";
    }
  }
  else
  {
    echo "CHIBIERROR No Data\n";
  }
