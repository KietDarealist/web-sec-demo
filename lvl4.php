<?php

    // Create folder for each user
    session_start();
    $dir = 'upload/' . session_id();
    if ( !file_exists($dir) )
        mkdir($dir);

    $error = '';
    $success = '';
    if(isset($_GET["debug"])) die(highlight_file(__FILE__));
    if(isset($_FILES["file"])) {
        try {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($finfo, $_FILES['file']['tmp_name']);
            $whitelist = array("image/jpeg", "image/png", "image/gif");
            if (!in_array($mime_type, $whitelist, TRUE)) {
                die("Hack detected");
            }
            $file = $dir . "/" . $_FILES["file"]["name"];
            move_uploaded_file($_FILES["file"]["tmp_name"], $file);
            $success = 'Successfully uploaded file at: <a href="/' . $file . '">/' . $file . ' </a>';
        } catch(Exception $e) {
            $error = $e->getMessage();
        }
    }
?>