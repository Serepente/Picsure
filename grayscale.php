<?php
session_start();
if (isset($_SESSION['uploadedFilePath']) && file_exists($_SESSION['uploadedFilePath'])) {
    $filePath = $_SESSION['uploadedFilePath'];
    $info = getimagesize($filePath);
    
    switch ($info[2]) {
        case IMAGETYPE_JPEG:
            $image = imagecreatefromjpeg($filePath);
            break;
        case IMAGETYPE_PNG:
            $image = imagecreatefrompng($filePath);
            break;
        default:
            die("Unsupported image format.");
    }

    if(imagefilter($image, IMG_FILTER_GRAYSCALE)) {
        header("Content-type: image/jpeg");
        imagejpeg($image);

        // Ug ganahan isave
        // imagejpeg($image, 'path/to/save/grayscale_image.jpg');
    } else {
        echo "Failed to apply grayscale filter.";
    }

    imagedestroy($image);
} else {
    echo "No image uploaded.";
}
?>
