<?php
require_once 'db.php';


function resize_image($src, $dst, $max_width, $max_height) {
    list($w, $h, $type) = getimagesize($src);
    $ratio = $w/$h;
    if ($max_width/$max_height > $ratio) {
        $new_h = $max_height;
        $new_w = $max_height * $ratio;
    } else {
        $new_w = $max_width;
        $new_h = $max_width / $ratio;
    }
    $dst_img = imagecreatetruecolor($new_w, $new_h);
    switch ($type) {
        case IMAGETYPE_JPEG: $src_img = imagecreatefromjpeg($src); break;
        case IMAGETYPE_PNG: $src_img = imagecreatefrompng($src); break;
        case IMAGETYPE_GIF: $src_img = imagecreatefromgif($src); break;
        default: return false;
    }
    imagecopyresampled($dst_img, $src_img, 0,0,0,0, $new_w, $new_h, $w, $h);
    imagejpeg($dst_img, $dst, 85);
    imagedestroy($dst_img);
    imagedestroy($src_img);
    return true;
}

function is_logged_in() {
    session_start();
    return isset($_SESSION['user_id']);
}

function admin_logged_in() {
    session_start();
    return isset($_SESSION['admin_id']);
}
?>