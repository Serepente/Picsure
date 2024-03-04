<?php
// Assume $image is your source image and $thresholdingRange is your threshold value
$target = 'assets/uploads/1709127445_C6AoauY940.jpg';
$image = imagecreatefromjpeg($target);
// First, convert the image to grayscale
imagefilter($image, IMG_FILTER_GRAYSCALE);

// Get image dimensions
$width = imagesx($image);
$height = imagesy($image);

// Create two new blank images of the same size
$blackedImage = imagecreatetruecolor($width, $height);
$whitedImage = imagecreatetruecolor($width, $height);

// Allocate black and white colors
$black = imagecolorallocate($blackedImage, 0, 0, 0);
$white = imagecolorallocate($whitedImage, 255, 255, 255);

// Fill the new images with white background to start
imagefilledrectangle($blackedImage, 0, 0, $width, $height, $white);
imagefilledrectangle($whitedImage, 0, 0, $width, $height, $white);

// Iterate over each pixel in the original image
for ($y = 0; $y < $height; $y++) {
    for ($x = 0; $x < $width; $x++) {
        $rgb = imagecolorat($image, $x, $y);
        $colors = imagecolorsforindex($image, $rgb);
        $brightness = ($colors['red'] + $colors['green'] + $colors['blue']) / 3;
        if ($brightness < 127) {
            // If below the threshold, set the pixel black in the blackedImage
            imagesetpixel($blackedImage, $x, $y, $black);
        } else {
            // If above the threshold, set the pixel black in the whitedImage
            imagesetpixel($whitedImage, $x, $y, $black);
        }
    }
}

// Now $blackedImage contains the black parts of the image, and $whitedImage contains the white parts

// Save or output the images as needed
imagejpeg($blackedImage, 'assets/img/blacked/blacked_image.jpg');
imagejpeg($whitedImage, 'assets/img/whited/whited_image.jpg');

// Clean up
imagedestroy($blackedImage);
imagedestroy($whitedImage);
imagedestroy($image);

?>