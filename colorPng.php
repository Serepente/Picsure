<?php

if (isset($_SESSION['uploadedFilePath']) && file_exists($_SESSION['uploadedFilePath'])) {
    $filePath = $_SESSION['uploadedFilePath'];
    $info = getimagesize($filePath);

    // Function to create image resource based on MIME type
    function createImageFromAny($filePath, $imageType) {
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                return imagecreatefromjpeg($filePath);
            case IMAGETYPE_PNG:
                return imagecreatefrompng($filePath);
            case IMAGETYPE_GIF:
                return imagecreatefromgif($filePath);
            // Add cases for other supported types...
            default:
                return false; // Unsupported type
        }
    }

    // Function to save image resource to file based on original type
    function saveImageToFile($image, $filePath, $imageType) {
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                imagejpeg($image, $filePath);
                break;
            case IMAGETYPE_PNG:
                imagepng($image, $filePath);
                break;
            case IMAGETYPE_GIF:
                imagegif($image, $filePath);
                break;
            // Add cases for other supported types...
        }
    }

    // Adjusted functions for applying filters (example for applyNaturalFilter)
    function applyNaturalFilter($image, $filePath, $imageType) {
        imagefilter($image, IMG_FILTER_CONTRAST, -10);
        imagefilter($image, IMG_FILTER_BRIGHTNESS, 5);
        $editedImageNatural = "assets/img/natural/natural_" . basename($filePath);
        saveImageToFile($image, $editedImageNatural, $imageType); // Use the new save function
        return $editedImageNatural;
    }

    // Fresh
    function applyFreshFilter($image, $filePath, $imageType) {
        imagefilter($image, IMG_FILTER_COLORIZE, 0, 15, 15, 30);
        $editedImageFresh = "assets/img/fresh/fresh_" . basename($filePath);
        saveImageToFile($image, $editedImageFresh, $imageType); // Use the new save function
        return $editedImageFresh;
    }
    // brightened
    function applyBrightnessFilter($image, $filePath, $imageType) {
        imagefilter($image, IMG_FILTER_BRIGHTNESS, 100);
        $editedImageBrightness = "assets/img/brightened/brightened_" . basename($filePath);
        saveImageToFile($image, $editedImageBrightness, $imageType); // Use the new save function

        return $editedImageBrightness;
    }
    // contrast
    function applyContrastFilter($image, $filePath, $imageType) {
        imagefilter($image, IMG_FILTER_CONTRAST, -50); 
        $editedImageContrast = "assets/img/contrasted/contrasted_" . basename($filePath);
        saveImageToFile($image, $editedImageContrast, $imageType); // Use the new save function

        return $editedImageContrast;
    }
    // sepia
    function applySepiaFilter($image, $filePath, $imageType) {
        imagefilter($image, IMG_FILTER_GRAYSCALE);
        imagefilter($image, IMG_FILTER_COLORIZE, 100, 50, 0);
        $editedImageSepia = "assets/img/sepia/sepia_" . basename($filePath);
        saveImageToFile($image, $editedImageSepia, $imageType); // Use the new save function

        return $editedImageSepia;
    }
    // sunglow
    function applySunglowFilter($image, $filePath, $imageType) {
    
        imagefilter($image, IMG_FILTER_COLORIZE, 50, 30, 0);
        $editedImageSunglow = "assets/img/sunglowed/sunglowed_" . basename($filePath);
        saveImageToFile($image, $editedImageSunglow, $imageType); // Use the new save function

        return $editedImageSunglow;
    }
    // Warm
    function applyWarmFilter($image, $filePath, $imageType) {
    
        imagefilter($image, IMG_FILTER_COLORIZE, 60, 15, 0);
        $editedImageWarm = "assets/img/warmed/warmed_" . basename($filePath);
        saveImageToFile($image, $editedImageWarm, $imageType); // Use the new save function

        return $editedImageWarm;
    }
    // Cool
    function applyCoolFilter($image, $filePath, $imageType) {

        imagefilter($image, IMG_FILTER_COLORIZE, 0, 0, 50);
        $editedImageCool = "assets/img/cool/cool_" . basename($filePath);
        saveImageToFile($image, $editedImageCool, $imageType); // Use the new save function

        return $editedImageCool;
    }
    // Autumn
    function applyAutumnFilter($image, $filePath, $imageType) {
        
        imagefilter($image, IMG_FILTER_COLORIZE, 80, 30, 0);
        $editedImageAutumn = "assets/img/autumn/autumn_" . basename($filePath);
        saveImageToFile($image, $editedImageAutumn, $imageType); // Use the new save function

        return $editedImageAutumn;
    }
    // Negative
    function applyNegativeFilter($image, $filePath, $imageType) {
        
        imagefilter($image, IMG_FILTER_NEGATE);
        $editedImageNegative = "assets/img/negative/negative_" . basename($filePath);
        saveImageToFile($image, $editedImageNegative, $imageType); // Use the new save function

        return $editedImageNegative;
    }
    // Noir
    function applyNoirFilter($image, $filePath, $imageType) {
        
        imagefilter($image, IMG_FILTER_GRAYSCALE);
        imagefilter($image, IMG_FILTER_CONTRAST, -50);
        imagefilter($image, IMG_FILTER_BRIGHTNESS, -10);
        $editedImageNoir = "assets/img/noir/noir_" . basename($filePath);
        saveImageToFile($image, $editedImageNoir, $imageType); // Use the new save function

        return $editedImageNoir;
    }
    // Draw
    function applyDrawFilter($image, $filePath, $imageType) {
        
        imagefilter($image, IMG_FILTER_GRAYSCALE);
        imagefilter($image, IMG_FILTER_CONTRAST, -50);
        imagefilter($image, IMG_FILTER_MEAN_REMOVAL);
        $editedImageDraw = "assets/img/draw/draw_" . basename($filePath);
        saveImageToFile($image, $editedImageDraw, $imageType); // Use the new save function

        return $editedImageDraw;
    }
    // Charcoal
    function applyCharcoalFilter($image, $filePath, $imageType){

        imagefilter($image, IMG_FILTER_GRAYSCALE);

        imagefilter($image, IMG_FILTER_BRIGHTNESS, -30); 
        imagefilter($image, IMG_FILTER_CONTRAST, -30); 

        $editedImageCharcoal = "assets/img/charcoal/charcoal_" . basename($filePath);
        saveImageToFile($image, $editedImageCharcoal, $imageType); // Use the new save function

        return $editedImageCharcoal;
    }

    function applyBnwFilter($image, $filePath, $imageType){

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
        saveImageToFile($image, $editedImageBnw, $imageType); // Use the new save function

        return $editedImageBnw;
    }

    // Similarly adjust other filter application functions...

    // Adjust the generateThumbnails function to pass image type
    function generateThumbnails($filePath) {
        $info = getimagesize($filePath);
        $imageType = $info[2]; // Get image type
        $image = createImageFromAny($filePath, $imageType); // Create image resource based on type

        if (!$image) {
            // Handle error for unsupported image types
            return;
        }

        $filters = ['Natural', 'Fresh', 'Brightness', 'Contrast', 'Sepia', 'Sunglow', 'Warm', 'Cool', 'Autumn', 'Negative', 'Noir', 'Draw', 'Charcoal', 'BNW'];
        $thumbnails = [];

        foreach ($filters as $filter) {
            $functionName = "apply" . $filter . "Filter";
            if (function_exists($functionName)) {
                $thumbnailPath = $functionName($image, $filePath, $imageType); // Pass image type
                imagedestroy($image);
                $thumbnails[$filter] = $thumbnailPath;
            }
        }

        return $thumbnails;
    }
    function generateThumbnails($filePath) {
        $filters = ['Natural', 'Fresh', 'Brightness', 'Contrast', 'Sepia', 'Sunglow', 'Warm', 'Cool', 'Autumn', 'Negative', 'Noir', 'Draw', 'Charcoal', 'BNW'];
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

    // Your existing code to use the generateThumbnails function...
}
?>
