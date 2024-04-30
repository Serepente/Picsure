<?php
session_start();
error_reporting(0);

require_once 'shapeDetection.php';

$targetFile = "";
// $shapeImagePath = "";
$thumbnails = []; 

if (isset($_SESSION['uploadedFilePath']) && file_exists($_SESSION['uploadedFilePath'])) {
    $targetFile = $_SESSION['uploadedFilePath'];
    $shapeImagePath = $_SESSION['shapeImagePath'];
    
    // $thumbnails = generateThumbnails($targetFile);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/img/favicon-32x32.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">


    <title>PicSure Photo Editor</title>
</head>

<body>
    <section class="main justify-content-center">
        <div class="container d-flex justify-content-center align-items-center" style="height: 700px; width: 1200px;">
            <div class="container border rounded-2 main-border main-container">
                <div class="row">
                    <div class="col-1 p-0">
                        <div class="list-group" id="list-tab" role="tablist">
                                <a class="list-group-item list-group-item-action active p-4 text-center" id="list-home-list" data-bs-toggle="list" href="#list-home" role="tab" aria-controls="list-home"><i class="fa-solid fa-house fa-lg" style="color: #ffffff;"></i>
                                <span class="hover-text">Home</span>
                                </a>
                                <a class="list-group-item list-group-item-action p-4 text-center" id="list-import-list" data-bs-toggle="list" href="#list-import" role="tab" aria-controls="list-import">
                                <i class="fa-solid fa-file-import fa-lg" style="color: #ffffff;"></i>
                                <span class="hover-text">Import Image</span>
                                </a>
                                <a class="list-group-item list-group-item-action p-4 text-center" id="list-edit-list" data-bs-toggle="list" href="#list-edit" role="tab" aria-controls="list-edit"><i class="fa-solid fa-circle-half-stroke fa-lg" style="color: #f7f9fd;"></i>
                                <span class="hover-text">Detect Shapes</span>
                                </a>
                                <a class="list-group-item list-group-item-action p-4 text-center" id="list-bnw-list" data-bs-toggle="list" href="#list-bnw" role="tab" aria-controls="list-bnw"><i class="fa-solid fa-droplet fa-lg" style="color: #fcfcfd;"></i>
                                <span class="hover-text">Black & White</span>
                                </a>
                                <a class="list-group-item list-group-item-action p-4 text-center" id="list-filters-list" data-bs-toggle="list" href="#list-filters" role="tab" aria-controls="list-filters"><i class="fa-solid fa-filter fa-lg" style="color: #ffffff;"></i>
                                <span class="hover-text">Filters</span>
                                </a>
                                <a class="list-group-item list-group-item-action p-4 text-center" id="list-colors-list" data-bs-toggle="list" href="#list-colors" role="tab" aria-controls="list-colors"><i class="fa-solid fa-palette fa-lg" style="color: #ffffff;"></i>
                                <span class="hover-text">Colors Hue</span>
                                </a>
                                <a class="list-group-item list-group-item-action p-4 text-center" id="list-advance-list" data-bs-toggle="list" href="#list-advance" role="tab" aria-controls="list-advance"><i class="fa-solid fa-sliders fa-lg" style="color: #fafafa;"></i>
                                <span class="hover-text">Adjustments</span>
                                </a>
                                <a class="list-group-item list-group-item-action p-4 text-center" id="list-export-list" data-bs-toggle="list" href="#list-export" role="tab" aria-controls="list-export"><i class="fa-solid fa-file-export fa-lg" style="color: #ffffff;"></i>
                                <span class="hover-text">Export File</span>
                                </a>
                        </div>
                      </form>
                    </div>
                    <div class="col-11">
                      <div class="tab-content h-100" id="nav-tabContent" style="position: relative;">
                            <img src="assets/img/logo.png" alt="" class="top-left-logo" id="topLeftLogo" style="display: none;">
                            <form action="reset.php" id="resetForm" method="POST" style="display: none;">
                                <button type="submit" name="reset" class="position-absolute bottom-0 end-0" style="background-color: transparent; border: none;">
                                    <i class="fa-solid fa-trash fa-lg" style="color: #ffffff;"></i>
                                </button> 
                            </form>

                            <div class="tab-pane fade show active h-100" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                                <div class="container h-100 d-flex justify-content-center align-items-center flex-column">
                                    <div class="text-center"> <!-- Added a wrapping div with text-center class for alignment -->
                                        <h1 class="text-white">
                                            WELCOME TO PICSURE
                                        </h1>
                                        <span class="text-white">Online Image Processing Project</span>
                                        <!-- Buttons added below -->
                                        <div class="mt-5"> <!-- This div is used to wrap buttons and provide margin-top for spacing -->
                                            <button type="button" class="btn homeBtn mx-3" id="editImagesBtns">Edit Images</button>
                                            <button type="button" class="btn homeBtn mx-3">Explore More</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                                           
                            <div class="tab-pane fade show h-100" id="list-import" role="tabpanel" aria-labelledby="list-import-list">
                                <div class="container h-100 d-flex justify-content-center align-items-center flex-column"> 
                                    <div class="upload-border d-flex flex-column justify-content-center align-items-center">
                                        <input type="file" id="fileInput" style="display: none;" accept="image/*"/>
                                        <div id="uploadContainer" onclick="document.getElementById('fileInput').click();">
                                            <i class="fa-solid fa-upload fa-2xl" style="color: #ffffff; cursor: pointer;"></i>
                                            <span style="color: #ffffff; margin-top: 30px;">Upload image from folder</span>
                                        </div>
                                        <img id="imagePreview" src="" alt="" style="margin-top: 20px;"> 
                                    </div>
                                    <div id="uploadMsg" class="text-white" style="display: none;margin-top: 30px;">Uploading...
                                        <span id="progressPercentage">0%</span>
                                    </div>
                                    <form action="shapeDetection.php" method="POST">
                                        <div class="mt-3" name="imageCategory" id="imageCategory">
                                            <div class="form-check form-check-inline text-white">
                                                Image Background Type:
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="white" value="white" required>
                                                <label class="form-check-label text-white" for="white">White</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="black" value="black" required>
                                                <label class="form-check-label text-white" for="black">Black</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="colored" value="colored" disabled>
                                                <label class="form-check-label text-white" for="colored">Colored</label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mt-3"> 
                                            <button type="submit" id="arrowButton" name="arrow-btn" style="background-color: transparent; border: none; display: none; margin-top: 30px;" onclick="reloadPage()">
                                                <i class="fa-solid fa-arrow-down fa-2xl" style="color: #ffffff;"></i>
                                            </button>
                                        </div>
                                    </form> 
                                </div>
                            </div>

                            <div class="tab-pane fade h-100" id="list-edit" role="tabpanel" aria-labelledby="list-edit-list">
                                <h3 class="position-absolute top-0 start-0 mt-3 ms-3 text-white">Detect Shapes</h3>
                                <div class="d-flex flex-column justify-content-center align-items-center h-100">
                                    <?php if (!empty($targetFile)): ?>
                                        <div class="video-container mt-3" style="width: 700px; height: 350px; position: relative;">
                                            <video src="<?php echo $_SESSION['video_name'] ?>" autoplay loop muted style="width: 100%; height: 100%; object-fit: contain;"></video>
                                        </div>
                                        <div class="accordion w-100 mt-3 info-accordion" id="accordionExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                    Shape Counter
                                                </button>
                                                </h2>
                                                <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <ul class="list-group">
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    Triangle
                                                                    <span class="badge text-bg-primary rounded-pill"><?php echo $_SESSION['Triangle'] ?></span>
                                                                </li>
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    Square
                                                                    <span class="badge text-bg-primary rounded-pill"><?php echo $_SESSION['Square'] ?></span>
                                                                </li>
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    Rectangle
                                                                    <span class="badge text-bg-primary rounded-pill"><?php echo $_SESSION['Rectangle'] ?></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <ul class="list-group">
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    Diamond
                                                                    <span class="badge text-bg-primary rounded-pill"><?php echo $_SESSION['Diamond'] ?></span>
                                                                </li>
                                                                <li class="list-group-item d-flex justify-content-between align-items-center quadrilateral">
                                                                    Quadrilateral
                                                                    <span class="badge text-bg-primary rounded-pill"><?php echo $_SESSION['Quadrilateral'] ?></span>
                                                                </li>
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    Pentagon
                                                                    <span class="badge text-bg-primary rounded-pill"><?php echo $_SESSION['Pentagon'] ?></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <ul class="list-group">
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    Hexagon
                                                                    <span class="badge text-bg-primary rounded-pill"><?php echo $_SESSION['Hexagon'] ?></span>
                                                                </li>
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    Octagon
                                                                    <span class="badge text-bg-primary rounded-pill"><?php echo $_SESSION['Octagon'] ?></span>
                                                                </li>
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    Oblong
                                                                    <span class="badge text-bg-primary rounded-pill"><?php echo $_SESSION['Oblong'] ?></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <ul class="list-group">
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    Star
                                                                    <span class="badge text-bg-primary rounded-pill"><?php echo $_SESSION['Star'] ?></span>
                                                                </li>
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    Circle
                                                                    <span class="badge text-bg-primary rounded-pill"><?php echo $_SESSION['Circle'] ?></span>
                                                                </li>
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    Total
                                                                    <span class="badge text-bg-primary rounded-pill"><?php echo $_SESSION['Total'] ?></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    Color Counter
                                                </button>
                                                </h2>
                                                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <ul class="list-group">
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    Red
                                                                    <span class="badge text-bg-danger rounded-pill"><?php echo $_SESSION['Red'] ?></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <ul class="list-group">
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    Green
                                                                    <span class="badge text-bg-success rounded-pill"><?php echo $_SESSION['Green'] ?></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <ul class="list-group">
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    Blue
                                                                    <span class="badge text-bg-primary rounded-pill"><?php echo $_SESSION['Blue'] ?></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <ul class="list-group">
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    Yellow
                                                                    <span class="badge text-bg-warning rounded-pill"><?php echo $_SESSION['Yellow'] ?></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-white">Please upload an image to detect shapes</p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            
                            <div class="tab-pane fade h-100" id="list-bnw" role="tabpanel" aria-labelledby="list-bnw-list">
                                <div class="h-100 d-flex flex-column justify-content-center align-items-center">
                                    <?php if (!empty($targetFile)): ?>
                                        <div class="picture_container mt-3" style="width: 700px; height: 350px; position: relative;">
                                            <img id="switchImage" src="<?php echo $targetFile ?>" alt="" style="width: 100%; height: 100%; object-fit: contain;">
                                        </div>
                                        <div class="accordion w-100 mt-3 info-accordion" id="accordionImageSetting">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwoSetting" aria-expanded="false" aria-controls="collapseTwoSetting">
                                                    Image Settings
                                                </button>
                                                </h2>
                                                <div id="collapseTwoSetting" class="accordion-collapse collapse" data-bs-parent="#accordionImageSetting">
                                                    <div class="accordion-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <ul class="list-group">
                                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" type="checkbox" role="switch" id="showImageCenter">
                                                                            <label class="form-check-label" for="showImageCenter">Show Center of Image</label>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <ul class="list-group">
                                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" type="checkbox" role="switch" id="showObjectBoxes">
                                                                            <label class="form-check-label" for="showObjectBoxes">Show Object Boxes</label>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-md-12 mt-3">
                                                                <div class="d-flex align-items-center justify-content-between">
                                                                    <label for="rotateRange" class="form-label text-white">Rotate Image</label>
                                                                    <div class="d-flex align-items-center text-white">
                                                                        <span class="me-2" id="rotateValue" contenteditable="true" oninput="updateRotation(this.textContent)">0</span>°
                                                                    </div>
                                                                </div>
                                                                <ul class="list-group">
                                                                    <li class="list-group-item d-flex justify-content-center align-items-center">
                                                                        <input type="range" id="rotateRange" min="-360" max="360" value="0">
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <label class="form-label text-white">Translate Image</label>
                                                            <div class="col-md-3">
                                                                <ul class="list-group">
                                                                    <li class="list-group-item d-flex">
                                                                        <label for="xtranslate" class="col-form-label">X: </label>
                                                                        <input type="number" id="xtranslate" class="text-white text-center" min="0" max="100" value="0" style="background: transparent; border: none; border-bottom: 1px solid white;">
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <ul class="list-group">
                                                                    <li class="list-group-item d-flex">
                                                                        <label for="ytranslate" class="col-form-label">Y: </label>
                                                                        <input type="number" id="ytranslate" class="text-white text-center" min="0" max="100" value="0" style="background: transparent; border: none; border-bottom: 1px solid white;">
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsThreeSetting" aria-expanded="false" aria-controls="collapsThreeSetting">
                                                    Image Information
                                                </button>
                                                </h2>
                                                <div id="collapsThreeSetting" class="accordion-collapse collapse" data-bs-parent="#accordionImageSetting">
                                                    <div class="accordion-body">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <ul class="list-group">
                                                                    <li class="list-group-item d-flex justify-content-between align-items-center sizes">
                                                                        Object Size
                                                                        <span class="badge text-bg-primary rounded-pill"><?php echo $_SESSION['object_size'] ?> px</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <ul class="list-group">
                                                                    <li class="list-group-item d-flex justify-content-between align-items-center sizes">
                                                                        Image Size
                                                                        <span class="badge text-bg-primary rounded-pill"><?php echo $_SESSION['image_height'] ?> x <?php echo $_SESSION['image_width'] ?> px</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <ul class="list-group">
                                                                    <li class="list-group-item d-flex justify-content-between align-items-center sizes">
                                                                        Coordinates
                                                                        <span class="badge text-bg-primary rounded-pill"><?php echo $_SESSION['centroid_x'] ?> x <?php echo $_SESSION['centroid_y'] ?></span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>  
                                        </div>
                                    <?php else: ?>
                                        <p class="text-white">Please upload an image to use the grayscale.</p>
                                    <?php endif; ?>
                                </div>
                                <div id="contextMenu" class="context-menu">
                                    <ul>
                                        <li id="mirrorHorizontal">Mirror horizontally</li>
                                        <li id="mirrorVertical">Mirror vertically</li>
                                        <li id="binaryProjection">Binary Projection</li>
                                        <li id="colorHistogram">Color Histogram</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="tab-pane fade h-100" id="list-filters" role="tabpanel" aria-labelledby="list-filters-list">
                                <h3 class="position-absolute top-0 start-0 mt-3 ms-3 text-white">Convolution</h3>  
                                <div class="h-100 d-flex flex-column justify-content-center align-items-center">
                                    <?php if (!empty($targetFile)): ?>
                                        <div class="picture_container mt-3" style="width: 700px; height: 350px; position: relative;">
                                            <img id="convolutionImage" src="<?php echo $targetFile ?>" alt="" style="width: 100%; height: 100%; object-fit: contain;">
                                        </div>
                                        <div class="accordion w-100 mt-3 info-accordion" id="accordionConvolution">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseConvolution" aria-expanded="false" aria-controls="collapseConvolution">
                                                    Image Settings
                                                </button>
                                                </h2>
                                                <div id="collapseConvolution" class="accordion-collapse collapse" data-bs-parent="#accordionConvolution">
                                                    <div class="accordion-body convolution">
                                                        <div class="row">
                                                            <div class="col-md-2 d-flex justify-content-center align-items-center">
                                                                <div class="picture_container" style="width: 100px; height: 100px; position: relative;">
                                                                    <img src="assets/img/convolution/smoothedImage.jpg" alt="" style="width: 100%; height: 100%; object-fit: contain; cursor: pointer;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 d-flex justify-content-center align-items-center">
                                                                <div class="picture_container" style="width: 100px; height: 100px; position: relative;">
                                                                    <img src="assets/img/convolution/gaussianBlurredImage.jpg" alt="" style="width: 100%; height: 100%; object-fit: contain; cursor: pointer;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 d-flex justify-content-center align-items-center">
                                                                <div class="picture_container" style="width: 100px; height: 100px; position: relative;">
                                                                    <img src="assets/img/convolution/sharpenedImage.jpg" alt="" style="width: 100%; height: 100%; object-fit: contain; cursor: pointer;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 d-flex justify-content-center align-items-center">
                                                                <div class="picture_container" style="width: 100px; height: 100px; position: relative;">
                                                                    <img src="assets/img/convolution/meanImage.jpg" alt="" style="width: 100%; height: 100%; object-fit: contain; cursor: pointer;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 d-flex justify-content-center align-items-center">
                                                                <div class="picture_container" style="width: 100px; height: 100px; position: relative;">
                                                                    <img src="assets/img/convolution/lapcianEmboss.jpg" alt="" style="width: 100%; height: 100%; object-fit: contain; cursor: pointer;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 d-flex justify-content-center align-items-center">
                                                                <div class="picture_container" style="width: 100px; height: 100px; position: relative;">
                                                                    <img src="assets/img/convolution/embossedImage.jpg" alt="" style="width: 100%; height: 100%; object-fit: contain; cursor: pointer;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                    <?php else: ?>
                                        <p class="text-white">Please upload an image to use the grayscale.</p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="tab-pane fade h-100" id="list-colors" role="tabpanel" aria-labelledby="list-colors-list">
                               
                            </div>

                            <div class="tab-pane fade h-100" id="list-advance" role="tabpanel" aria-labelledby="list-advance-list">
                                
                            </div>
                            <div class="tab-pane fade" id="list-export" role="tabpanel" aria-labelledby="list-export-list">
                           
                                <footer>
                                    <div class="position-relative">
                                        <div class="position-absolute top-0 start-50 translate-middle">
                                            <i class="fa-brands fa-github fa-2xl p-3" style="color: #ffffff;"></i>
                                            <i class="fa-brands fa-facebook fa-2xl p-3" style="color: #ffffff;"></i>
                                            <i class="fa-brands fa-instagram fa-2xl p-3" style="color: #ffffff;"></i>
                                        </div>
                                    </div>
                                </footer>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
        <div class="position-relative">
            <div class="position-absolute top-100 start-50 translate-middle">
                <p class="text-white"><i class="fa-regular fa-copyright" style="color: #ffffff;"></i> 2024 PICSURE by Yongski | All Rights Reserved | Powered by UB-CPE3</p>
            </div>
        </div>
    <footer>
        .
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('xtranslate').addEventListener('input', translationxy);
            document.getElementById('ytranslate').addEventListener('input', translationxy);

            function translationxy(){
                var xtranslate = document.getElementById('xtranslate').value;
                var ytranslate = document.getElementById('ytranslate').value;

                // If the input fields are empty, set the values to 0
                xtranslate = xtranslate === '' ? 0 : xtranslate;
                ytranslate = ytranslate === '' ? 0 : ytranslate;

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'rotate.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function() {
                    if (this.status == 200) {
                        console.log(this.responseText);
                        document.getElementById('switchImage').src = this.responseText + '?t=' + new Date().getTime();
                    }
                };
                xhr.send(`xtranslate=${xtranslate}&ytranslate=${ytranslate}`);
            }
        });
    


    const contextMenu = document.getElementById('contextMenu');
    const switchImage = document.getElementById('switchImage');
    const pictureContainer = document.querySelector('.picture_container');

    switchImage.addEventListener('contextmenu', (e) => {
        e.preventDefault();
        const containerRect = pictureContainer.getBoundingClientRect();
        const posX = e.clientX - containerRect.left;
        const posY = e.clientY - containerRect.top;
        contextMenu.style.display = 'block';
        contextMenu.style.left = `${posX}px`;
        contextMenu.style.top = `${posY}px`;
    });

    document.addEventListener('click', (e) => {
        if (!contextMenu.contains(e.target)) {
            contextMenu.style.display = 'none';
        }
    });

    document.getElementById('mirrorHorizontal').addEventListener('click', () => {
        const valueToSend = 0;
        sendValueToPHP(valueToSend);
    });

    document.getElementById('mirrorVertical').addEventListener('click', () => {
        const valueToSend = 1;
        sendValueToPHP(valueToSend);
    });

    document.getElementById('colorHistogram').addEventListener('click', () => {
        const valueToSend = "colorHistogram";
        sendValueToPHP(valueToSend);
    });

    document.getElementById('binaryProjection').addEventListener('click', () => {
        const valueToSend = "binaryProjection";
        sendValueToPHP(valueToSend);
    });
    function sendValueToPHP(value) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'shapeDetection.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
            if (this.status === 200) {
                console.log(this.responseText);
                document.getElementById('switchImage').src = this.responseText + '?t=' + new Date().getTime();
            }
        };
        xhr.send(`value=${value}`);
    }
    </script>
    <script>
        const targetFileValue = "<?php echo $targetFile; ?>";
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
    <script src="../assets/js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function(){
            $('.accordion-body img').click(function(){
                var imgSrc = $(this).attr('src');
                $('#convolutionImage').attr('src', imgSrc);
            });
        });
    </script>
</body>

</html>