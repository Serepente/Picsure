<?php
session_start();
error_reporting(0);

require_once 'filters.php';

$targetFile = "";
$thumbnails = []; 

if (isset($_SESSION['uploadedFilePath']) && file_exists($_SESSION['uploadedFilePath'])) {
    $targetFile = $_SESSION['uploadedFilePath'];
    $thumbnails = generateThumbnails($targetFile);
}
// $savepath = $_SESSION['savepath'];
// echo $targetFile;
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
    <link rel="stylesheet" href="assets/style.css">
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
                                <span class="hover-text">Grayscale</span>
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
                                            <button type="button" class="btn homeBtn mx-3" id="editImagesBtn">Edit Images</button>
                                            <a href="features" class="btn homeBtn mx-3" role="button">Explore More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                                           
                            <div class="tab-pane fade show h-100" id="list-import" role="tabpanel" aria-labelledby="list-import-list" id="list-import-list">
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
                                    <button id="arrowButton" name="arrow-btn" style="background-color: transparent; border: none; display: none; margin-top: 30px;" onclick="reloadPage()"> 
                                        <i class="fa-solid fa-arrow-down fa-2xl" style="color: #ffffff;"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="tab-pane fade h-100" id="list-edit" role="tabpanel" aria-labelledby="list-edit-list">
                                <h3 class="position-absolute top-0 start-0 mt-3 ms-3 text-white">Grayscaled Image</h3>
                                <div class="h-100 d-flex flex-column justify-content-center align-items-center">
                                    <?php if (!empty($targetFile)): ?>
                                        <div class="d-flex flex-column justify-content-center align-items-center image-container" style="height: 350px;width: 700px;">
                                            <img src="grayscale.php" alt="Grayscale Image" class="imageEdit editImage" id="grayscaleImage">
                                        </div>
                                    <?php else: ?>
                                        <p class="text-white">Please upload an image to use the grayscale.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="tab-pane fade h-100" id="list-bnw" role="tabpanel" aria-labelledby="list-bnw-list">
                                <h3 class="position-absolute top-0 start-0 mt-3 ms-3 text-white">Black and White Image</h3>
                                <div class="h-100 d-flex flex-column justify-content-center align-items-center">
                                    <?php if (!empty($targetFile)): ?>
                                        
                                    <?php else: ?>
                                        <p class="text-white">Please upload an image to use the black and white.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="tab-pane fade h-100" id="list-filters" role="tabpanel" aria-labelledby="list-filters-list">
                                <h3 class="position-absolute top-0 start-0 mt-3 ms-3 text-white">Filters</h3>
                                <div class="h-100 d-flex flex-column justify-content-center align-items-center">
                                    <div class="d-flex flex-column justify-content-center align-items-center mt-4" style="height: 350px;width: 700px;">
                                        <?php if (!empty($targetFile)): ?>
                                            <img id="filteredImage" src="<?php echo htmlspecialchars($targetFile); ?>" alt="" class="imageEdit">
                                            <div class="owl-carousel owl-theme">
                                                <?php foreach ($thumbnails as $filterName => $thumbnailPath): ?>
                                                    <div class='item' onclick="updateMainImage('<?php echo htmlspecialchars($thumbnailPath); ?>')">
                                                        <div style="text-align: center;cursor: pointer;">
                                                            <img src="<?php echo htmlspecialchars($thumbnailPath); ?>" alt="<?php echo htmlspecialchars($filterName); ?>">
                                                            <p style="color: #FFF;"><?php echo htmlspecialchars($filterName); ?></p>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else: ?>
                                            <p class="text-white">Please upload an image to use the filters.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade h-100" id="list-colors" role="tabpanel" aria-labelledby="list-colors-list">
                                <h3 class="position-absolute top-0 start-0 mt-3 ms-3 text-white">RGB Colors</h3>              
                                <div class="h-100 d-flex flex-column justify-content-center align-items-center">
                                    <?php if (!empty($targetFile)): ?>
                                        <div class="d-flex flex-column justify-content-center align-items-center" style="height: 350px; width: 700px;">
                                            <img id="mainImage2" src="<?php echo htmlspecialchars($targetFile); ?>" alt="" class="imageEdit">
                                            <div class="color-slider-container mt-3 d-flex flex-column">
                                                
                                                <!-- Red Slider -->
                                                <div class="slider-row d-flex align-items-center mb-2">
                                                    <input type="range" id="redRange" min="0" max="255" value="0" class="flex-grow-1">
                                                    <button class="reset-btn" data-for="redRange"><i class="fa-solid fa-rotate-left" style="color: #ffffff;"></i></button>
                                                </div>
                                                
                                                <!-- Green Slider -->
                                                <div class="slider-row d-flex align-items-center mb-2">
                                                    <input type="range" id="greenRange" min="0" max="255" value="0" class="flex-grow-1">
                                                    <button class="reset-btn" data-for="greenRange"><i class="fa-solid fa-rotate-left" style="color: #ffffff;"></i></button>
                                                </div>
                                                
                                                <!-- Blue Slider -->
                                                <div class="slider-row d-flex align-items-center mb-2">
                                                    <input type="range" id="blueRange" min="0" max="255" value="0" class="flex-grow-1">
                                                    <button class="reset-btn" data-for="blueRange"><i class="fa-solid fa-rotate-left" style="color: #ffffff;"></i></button>
                                                </div>
                                            </div>
                                            <input type="text" id="rgbValue" value="Just move the colors to display the RGB value." readonly>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-white">Please upload an image to use the filters.</p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="tab-pane fade h-100" id="list-advance" role="tabpanel" aria-labelledby="list-advance-list">
                                <h3 class="position-absolute top-0 start-0 mt-3 ms-3 text-white">Advance</h3>
                                <div class="h-100 d-flex flex-column justify-content-center align-items-center">
                                            <?php if (!empty($targetFile)): ?>
                                            <div class="d-flex flex-column justify-content-center align-items-center" style="height: 350px;width: 700px;">
                                            <img id="mainImage3" src="<?php echo htmlspecialchars($targetFile); ?>" alt="" class="imageEdit">
                                            </div>
                                            <div class="slider-container mt-3 row">
                                                    <div class="col-md-4">
                                                        <label for="warmthRange" class="form-label text-white">Warmth</label>
                                                        <button class="reset-btn" data-for="warmthRange"><i class="fa-solid fa-rotate-left" style="color: #ffffff;"></i></button>
                                                        <input type="range" id="warmthRange" min="-100" max="100" value="0" class="mb-4">
                                                        <label for="contrastRange" class="form-label text-white">Contrast</label>
                                                        <button class="reset-btn" data-for="contrastRange"><i class="fa-solid fa-rotate-left" style="color: #ffffff;"></i></button>
                                                        <input type="range" id="contrastRange" min="-100" max="100" value="0" class="mb-4">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="blurRange" class="form-label text-white">Blur</label>
                                                        <button class="reset-btn" data-for="blurRange"><i class="fa-solid fa-rotate-left" style="color: #ffffff;"></i></button>
                                                        <input type="range" id="blurRange" min="0" max="30" value="0" class="mb-4">
                                                        <label for="sharpRange" class="form-label text-white">Sharpness</label>
                                                        <button class="reset-btn" data-for="sharpRange"><i class="fa-solid fa-rotate-left" style="color: #ffffff;"></i></button>
                                                        <input type="range" id="sharpRange" min="0" max="5" value="0" class="mb-4">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="brightnessRange" class="form-label text-white">Brigthness</label>
                                                        <button class="reset-btn" data-for="brightnessRange"><i class="fa-solid fa-rotate-left" style="color: #ffffff;"></i></button>
                                                        <input type="range" id="brightnessRange" min="0" max="100" value="0" class="mb-4">
                                                        
                                                        <label for="thresholdingRange" class="form-label text-white">Thresholding</label>
                                                        <button class="reset-btn" data-for="thresholdingRange"><i class="fa-solid fa-rotate-left" style="color: #ffffff;"></i></button>
                                                        <input type="range" id="thresholdingRange" min="-127" max="127" value="0" class="mb-4">
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <p class="text-white">Please upload an image to use the filters.</p>
                                            <?php endif; ?>
                                    </div>
                            </div>
                            <div class="tab-pane fade" id="list-export" role="tabpanel" aria-labelledby="list-export-list">
                            <h3 class="position-absolute top-0 start-0 mt-3 ms-3 text-white">One Click Download</h3>
                                <div class="full-height d-flex justify-content-center align-items-center">
                                    <?php if (!empty($targetFile)): ?>
                                        <div class="row">
                                            <div class="col-md-3 image-download-wrapper">
                                                <a href="grayscale.php" download="grayscale-image.jpg">
                                                    <img src="grayscale.php" alt="Grayscaled Image" class="imageEdit editImage dlbnwImage">
                                                    <div class="overlay">
                                                        <i class="fa-solid fa-download fa-2xl" style="color: #ffffff;"></i>
                                                    </div>
                                                </a>
                                                <p style="color: #FFF;" class="text-center mt-2">Grayscaled Image</p>
                                            </div>
                                            <div class="col-md-3 image-download-wrapper">
                                                <a href="bnw.php" download="bnw-image.jpg">
                                                    <img src="bnw.php" alt="Black and White Image" class="imageEdit editImage dlgrayscaleImage">
                                                    <div class="overlay">
                                                        <i class="fa-solid fa-download fa-2xl" style="color: #ffffff;"></i>
                                                    </div>
                                                </a>
                                                <p style="color: #FFF;" class="text-center mt-2">Black and White Image</p>
                                            </div>
                                            <div class="col-md-3 image-download-wrapper">
                                                <a id="dlfilteredImage2" href="<?php echo htmlspecialchars($targetFile); ?>" download="filtered-image.jpg">
                                                    <img id="filteredImage2" src="<?php echo htmlspecialchars($targetFile); ?>" alt="Filtered Image" class="imageEdit dlfilteredImage">
                                                    <div class="overlay">
                                                        <i class="fa-solid fa-download fa-2xl" style="color: #ffffff;"></i>
                                                    </div>
                                                </a>
                                                <p style="color: #FFF;" class="text-center mt-2">Filtered Image</p>
                                            </div>
                                            <div class="col-md-3 image-download-wrapper">
                                                <a id="dlmainImage4" href="<?php echo htmlspecialchars($targetFile); ?>" download="adjusted_image.jpg">
                                                    <img id="mainImage4" src="<?php echo htmlspecialchars($targetFile); ?>" alt="Adjusted Image" class="imageEdit dladjustedImage">
                                                    <div class="overlay">
                                                        <i class="fa-solid fa-download fa-2xl" style="color: #ffffff;"></i>
                                                    </div>
                                                </a>
                                                <p style="color: #FFF;" class="text-center mt-2">Adjusted Image</p>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-white">Please upload an image to use the filters.</p>
                                    <?php endif; ?>
                                </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
    <script src="assets/js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
            $('.owl-carousel').owlCarousel({
            loop:true,
            margin:10,
            nav:false,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:5
                }
            }
        })

function updateMainImage(src) {
    // console.log(src);
    document.getElementById('filteredImage').src = src;
    document.getElementById('filteredImage2').src = src;
    document.getElementById('dlfilteredImage2').href = src;
}
    // colors
document.addEventListener('DOMContentLoaded', function() {

    document.getElementById('redRange').addEventListener('input', applyColorAdjustments);
    document.getElementById('greenRange').addEventListener('input', applyColorAdjustments);
    document.getElementById('blueRange').addEventListener('input', applyColorAdjustments);
    document.getElementById('contrastRange').addEventListener('input', applyColorAdjustments);
    document.getElementById('warmthRange').addEventListener('input', applyColorAdjustments);
    document.getElementById('sharpRange').addEventListener('input', applyColorAdjustments);
    document.getElementById('brightnessRange').addEventListener('input', applyColorAdjustments);
    document.getElementById('blurRange').addEventListener('input', applyColorAdjustments);
    document.getElementById('thresholdingRange').addEventListener('input', applyColorAdjustments);
    const rangeIds = ['redRange', 'greenRange', 'blueRange', 'brightnessRange'];
    const rgbValueInput = document.getElementById('rgbValue');


    function applyColorAdjustments() {
        var redRange = document.getElementById('redRange').value;
        var greenRange = document.getElementById('greenRange').value;
        var blueRange = document.getElementById('blueRange').value;
        var contrastRange = document.getElementById('contrastRange').value;
        var warmthRange = document.getElementById('warmthRange').value;
        var sharpRange = document.getElementById('sharpRange').value;
        var brightnessRange = document.getElementById('brightnessRange').value;
        var blurRange = document.getElementById('blurRange').value;
        var thresholdingRange = document.getElementById('thresholdingRange').value;
        var targetFile = '<?php echo $targetFile; ?>';
        var color = 'RGB('+ redRange +','+ greenRange +','+ blueRange +')';
        console.log(color);

        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'colors.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            if (this.status == 200) {
                console.log(this.responseText);
                // document.getElementById('mainImage').src = 'assets/img/color_adjusted/' + this.responseText + '?t=' + new Date().getTime();
                document.getElementById('mainImage2').src = 'assets/img/color_adjusted/' + this.responseText + '?t=' + new Date().getTime();
                document.getElementById('mainImage3').src = 'assets/img/color_adjusted/' + this.responseText + '?t=' + new Date().getTime();
                document.getElementById('mainImage4').src = 'assets/img/color_adjusted/' + this.responseText + '?t=' + new Date().getTime();
                document.getElementById('dlmainImage4').href = 'assets/img/color_adjusted/' + this.responseText + '?t=' + new Date().getTime();
                document.getElementById('rgbValue').value = color;
            }
        };

        xhr.send(`brightnessRange=${brightnessRange}&redRange=${redRange}&greenRange=${greenRange}&blueRange=${blueRange}&targetFile=${targetFile}&blurRange=${blurRange}&contrastRange=${contrastRange}&sharpRange=${sharpRange}&warmthRange=${warmthRange}&thresholdingRange=${thresholdingRange}`);
    }
});

    //Thresholding
// document.addEventListener('DOMContentLoaded', function() {

//     document.getElementById('thresholdingRange').addEventListener('input', applyThresholdingAdjutments);
    



//     function applyThresholdingAdjutments() {
//         var thresholdingRange = document.getElementById('thresholdingRange').value;
//         var targetFile = '';

//         var xhr = new XMLHttpRequest();
//         xhr.open('POST', 'thresholding.php', true);
//         xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

//         xhr.onload = function() {
//             if (this.status == 200) {
//                 console.log(this.responseText);
//                 document.getElementById('thresholdedImage').src = 'assets/img/thresholded/' + this.responseText + '?t=' + new Date().getTime();
//             }
//         };
//         xhr.send(`thresholdingRange=${thresholdingRange}&targetFile=${targetFile}`);
//     }
// });
</script>

</body>

</html>