<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $redRange = $_POST['redRange'];
        $greenRange = $_POST['greenRange'];
        $blueRange = $_POST['blueRange'];
        $contrastRange = $_POST['contrastRange'];
        $sharpRange = $_POST['sharpRange'];
        $warmthRange = $_POST['warmthRange'];
        $brightnessRange = $_POST['brightnessRange'];  
        $blurRange = $_POST['blurRange'];
        $thresholdingRange = $_POST['thresholdingRange'];
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
    
        if($redRange || $greenRange || $blueRange){
            imagefilter($image, IMG_FILTER_COLORIZE, $redRange, $greenRange, $blueRange); 

        }

        if ($brightnessRange) {
            imagefilter($image, IMG_FILTER_BRIGHTNESS, $brightnessRange);
        }

        if ($blurRange) {
            for ($i = 0; $i < $blurRange; $i++) {
                imagefilter($image, IMG_FILTER_GAUSSIAN_BLUR);
            }
        }

        if ($contrastRange) {
            imagefilter($image, IMG_FILTER_CONTRAST, -$contrastRange);
        }
        
        if ($warmthRange) {
            $redAdjustment = max(-255, min(255, $warmthRange));
            $blueAdjustment = -1 * $redAdjustment;
            
            if ($redAdjustment != 0) {
                imagefilter($image, IMG_FILTER_COLORIZE, $redAdjustment, 0, 0);
            }
            
            if ($blueAdjustment != 0) {
                imagefilter($image, IMG_FILTER_COLORIZE, 0, 0, $blueAdjustment);
            }
        }

        if($sharpRange){

            $sharpenMatrix = array(
                array(0, -1, 0),
                array(-1, 5, -1),
                array(0, -1, 0)
            );
            
            $sharpenMatrix[1][1] = 4 + $sharpRange;
            
            $divisor = 1;
            $offset = 0;
            imageconvolution($image, $sharpenMatrix, $divisor, $offset);
        }

        if($thresholdingRange){

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
        }

    
        $adjustedFileName = 'adjusted_' . basename($targetFile);
        $savePath = 'assets/img/color_adjusted/' . $adjustedFileName;
    
        imagejpeg($image, $savePath);
        imagedestroy($image);
    
        echo $adjustedFileName;
    }

}
?>
