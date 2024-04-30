<?php
// Replace 'path/to/your/image.pg' with the path to the image you're working with.
$imagePath = 'image/sampol.jpg';
$image = imagecreatefromjpeg($imagePath);

// Assuming you know the background color. In this case, we're assuming it's white.
$backgroundColor = imagecolorallocate($image, 255, 255, 255);
$transparentColor = imagecolorallocatealpha($image, 0, 0, 0, 127);

// Make the image transparent
imagecolortransparent($image, $backgroundColor);

// Replace the background color with the transparent color
imagesavealpha($image, true);
imagealphablending($image, false);

$width = imagesx($image);
$height = imagesy($image);

for ($x = 0; $x < $width; $x++) {
    for ($y = 0; $y < $height; $y++) {
        if (imagecolorat($image, $x, $y) == $backgroundColor) {
            imagesetpixel($image, $x, $y, $transparentColor);
        }
    }
}

// Save the image
imagejpeg($image, 'transparent_image.jpg');
imagedestroy($image);
?>
