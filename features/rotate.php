<?php
session_start();

if(isset($_SESSION['uploadedFilePath'])){
    $targetFile = $_SESSION['uploadedFilePath'];

    // Set default value for degrees using the ternary operator
    // $degrees = isset($_POST['rotateRange']) ? $_POST['rotateRange'] : 0;
    if(isset($_POST['rotateRange'])){
        $degrees = isset($_POST['rotateRange']) ? $_POST['rotateRange'] : 0;

        $imagePath = $targetFile;

        $imageInfo = getimagesize($imagePath);
        $imageWidth = $imageInfo[0];
        $imageHeight = $imageInfo[1];
        $imageType = $imageInfo[2]; 

        switch ($imageType) {
            case IMAGETYPE_GIF:
                $sourceImage = imagecreatefromgif($imagePath);
                break;
            case IMAGETYPE_JPEG:
                $sourceImage = imagecreatefromjpeg($imagePath);
                break;
            case IMAGETYPE_PNG:
                $sourceImage = imagecreatefrompng($imagePath);
                break;
            default:
                die('Unsupported image type.');
        }
    
        $rotatedImage = imagerotate($sourceImage, $degrees, 0);
        $rotatedFilename = 'adjusted_' . basename($targetFile);
        $rotatedImagePath = '../assets/img/rotated/' . $rotatedFilename;
        imagejpeg($rotatedImage, $rotatedImagePath);

        imagedestroy($sourceImage);
        imagedestroy($rotatedImage);

        echo $rotatedFilename;
    }
    
    if(isset($_POST['xtranslate']) || isset($_POST['ytranslate'])){
        $xtranslate = $_POST['xtranslate'];
        $ytranslate = $_POST['ytranslate'];

        $command = 'D:\Xampp\htdocs\School_projects\Picsure\features\my_venv\Scripts\python.exe "translate.py" ' . escapeshellarg($targetFile) . ' ' . escapeshellarg($xtranslate) . ' ' . escapeshellarg($ytranslate) . ' 2>&1';
        $output = shell_exec($command);
        
        echo $output;
        // echo "X: $xtranslate Y:  $ytranslate";
    }

    // echo $degrees;
} else {
    echo "Error: Uploaded file path not found in session.";
}

?>
