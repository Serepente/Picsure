<?php

if (isset($_SESSION['uploadedFilePath']) && file_exists($_SESSION['uploadedFilePath'])) {
    $filePath = $_SESSION['uploadedFilePath'];
    $info = getimagesize($filePath);
    
    // Natural
    function applyNaturalFilter($image, $filePath) {

        imagefilter($image, IMG_FILTER_CONTRAST, -10);
        imagefilter($image, IMG_FILTER_BRIGHTNESS, 5);
        $editedImageNatural = "assets/img/natural/natural_" . basename($filePath);
        imagejpeg($image, $editedImageNatural);
        return $editedImageNatural;
    }
    // Fresh
    function applyFreshFilter($image, $filePath) {
        imagefilter($image, IMG_FILTER_COLORIZE, 0, 15, 15, 30);
        $editedImageFresh = "assets/img/fresh/fresh_" . basename($filePath);
        imagejpeg($image, $editedImageFresh);
        return $editedImageFresh;
    }
    // brightened
    function applyBrightnessFilter($image, $filePath) {
        imagefilter($image, IMG_FILTER_BRIGHTNESS, 100);
        $editedImageBrightness = "assets/img/brightened/brightened_" . basename($filePath);
        imagejpeg($image, $editedImageBrightness);

        return $editedImageBrightness;
    }
    // contrast
    function applyContrastFilter($image, $filePath) {
        imagefilter($image, IMG_FILTER_CONTRAST, -50); 
        $editedImageContrast = "assets/img/contrasted/contrasted_" . basename($filePath);
        imagejpeg($image, $editedImageContrast);

        return $editedImageContrast;
    }
    // sepia
    function applySepiaFilter($image, $filePath) {
        imagefilter($image, IMG_FILTER_GRAYSCALE);
        imagefilter($image, IMG_FILTER_COLORIZE, 100, 50, 0);
        $editedImageSepia = "assets/img/sepia/sepia_" . basename($filePath);
        imagejpeg($image, $editedImageSepia);

        return $editedImageSepia;
    }
    // sunglow
    function applySunglowFilter($image, $filePath) {
    
        imagefilter($image, IMG_FILTER_COLORIZE, 50, 30, 0);
        $editedImageSunglow = "assets/img/sunglowed/sunglowed_" . basename($filePath);
        imagejpeg($image, $editedImageSunglow);

        return $editedImageSunglow;
    }
    // Warm
    function applyWarmFilter($image, $filePath) {
    
        imagefilter($image, IMG_FILTER_COLORIZE, 60, 15, 0);
        $editedImageWarm = "assets/img/warmed/warmed_" . basename($filePath);
        imagejpeg($image, $editedImageWarm);

        return $editedImageWarm;
    }
    // Cool
    function applyCoolFilter($image, $filePath) {

        imagefilter($image, IMG_FILTER_COLORIZE, 0, 0, 50);
        $editedImageCool = "assets/img/cool/cool_" . basename($filePath);
        imagejpeg($image, $editedImageCool);

        return $editedImageCool;
    }
    // Autumn
    function applyAutumnFilter($image, $filePath) {
        
        imagefilter($image, IMG_FILTER_COLORIZE, 80, 30, 0);
        $editedImageAutumn = "assets/img/autumn/autumn_" . basename($filePath);
        imagejpeg($image, $editedImageAutumn);

        return $editedImageAutumn;
    }
    // Negative
    function applyNegativeFilter($image, $filePath) {
        
        imagefilter($image, IMG_FILTER_NEGATE);
        $editedImageNegative = "assets/img/negative/negative_" . basename($filePath);
        imagejpeg($image, $editedImageNegative);

        return $editedImageNegative;
    }
    // Grayscale
    function applyGrayscaleFilter($image, $filePath) {
        
        imagefilter($image, IMG_FILTER_GRAYSCALE);
        $editedImageGrayscale = "assets/img/grayscaled/grayed_" . basename($filePath);
        imagejpeg($image, $editedImageGrayscale);

        return $editedImageGrayscale;
    }
    // Noir
    function applyNoirFilter($image, $filePath) {
        
        imagefilter($image, IMG_FILTER_GRAYSCALE);
        imagefilter($image, IMG_FILTER_CONTRAST, -50);
        imagefilter($image, IMG_FILTER_BRIGHTNESS, -10);
        $editedImageNoir = "assets/img/noir/noir_" . basename($filePath);
        imagejpeg($image, $editedImageNoir);

        return $editedImageNoir;
    }
    // Draw
    function applyDrawFilter($image, $filePath) {
        
        imagefilter($image, IMG_FILTER_GRAYSCALE);
        imagefilter($image, IMG_FILTER_CONTRAST, -50);
        imagefilter($image, IMG_FILTER_MEAN_REMOVAL);
        $editedImageDraw = "assets/img/draw/draw_" . basename($filePath);
        imagejpeg($image, $editedImageDraw);

        return $editedImageDraw;
    }
    // Charcoal
    function applyCharcoalFilter($image, $filePath){

        imagefilter($image, IMG_FILTER_GRAYSCALE);

        imagefilter($image, IMG_FILTER_BRIGHTNESS, -30); 
        imagefilter($image, IMG_FILTER_CONTRAST, -30); 

        $editedImageCharcoal = "assets/img/charcoal/charcoal_" . basename($filePath);
        imagejpeg($image, $editedImageCharcoal);

        return $editedImageCharcoal;
    }

    function applyBnwFilter($image, $filePath){

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

        $editedImageBnw = "assets/img/BNW/BNW_" . basename($filePath);
        imagejpeg($image, $editedImageBnw);

        return $editedImageBnw;
    }

    function generateThumbnails($filePath) {
        $filters = ['Natural', 'Fresh', 'Brightness', 'Contrast', 'Sepia', 'Sunglow', 'Warm', 'Cool', 'Autumn', 'Negative', 'Grayscale', 'Noir', 'Draw', 'Charcoal', 'BNW'];
        $thumbnails = [];

        foreach ($filters as $filter) {
            $image = imagecreatefromjpeg($filePath);
            $functionName = "apply" . $filter . "Filter";
            if (function_exists($functionName)) {
            
                $thumbnailPath = $functionName($image, $filePath);
                imagedestroy($image); 
                $thumbnails[$filter] = $thumbnailPath;
            }
        }

        return $thumbnails;
    }
    // header('Location: index.php');
    // exit;
}
?>
