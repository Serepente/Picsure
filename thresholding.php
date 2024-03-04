<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $thresholdingRange = isset($_POST['thresholdingRange']) && is_numeric($_POST['thresholdingRange']) ? intval($_POST['thresholdingRange']) : 127;
    $targetFile = $_POST['targetFile'];

    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
        $image = imagecreatefromjpeg($targetFile);
    } elseif ($imageFileType == "png") {
        $image = imagecreatefrompng($targetFile);
    } elseif ($imageFileType == "gif") {
        $image = imagecreatefromgif($targetFile);
    } else {
        echo "Invalid file type.";
        exit;
    }

    if ($image === false) {
        echo 'Error loading image';
        exit;
    }

    imagefilter($image, IMG_FILTER_GRAYSCALE);

    for ($y = 0; $y < imagesy($image); $y++) {
        for ($x = 0; $x < imagesx($image); $x++) {
            $rgb = imagecolorat($image, $x, $y);
            $colors = imagecolorsforindex($image, $rgb);
            $brightness = ($colors['red'] + $colors['green'] + $colors['blue']) / 3;
            $newColor = $brightness < $thresholdingRange ? 0x000000 : 0xFFFFFF;
            imagesetpixel($image, $x, $y, $newColor);
        }
    } 

    $adjustedFileName = 'thresholded_' . basename($targetFile);
    $savePath = 'assets/img/thresholded/' . $adjustedFileName;

    imagejpeg($image, $savePath);
    imagedestroy($image);

    echo $adjustedFileName;
}
?>