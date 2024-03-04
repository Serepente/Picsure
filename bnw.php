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

    imagefilter($image, IMG_FILTER_GRAYSCALE); 

    for ($y = 0; $y < imagesy($image); $y++) {
        for ($x = 0; $x < imagesx($image); $x++) {
            $rgb = imagecolorat($image, $x, $y);
            $colors = imagecolorsforindex($image, $rgb);
            $brightness = ($colors['red'] + $colors['green'] + $colors['blue']) / 3;
            $threshold = 127; 
            $newColor = $brightness < $threshold ? 0x000000 : 0xFFFFFF;
            imagesetpixel($image, $x, $y, $newColor);
        }
    }
    header("Content-type: image/jpeg");
    imagejpeg($image);

    // ug ganahan e save
    // imagejpeg($image, 'path/to/save/black_white_image.jpg');

    imagedestroy($image);
} else {
    echo "No image uploaded.";
}
?>
