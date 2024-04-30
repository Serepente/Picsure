<?php
session_start();
if(isset($_SESSION['uploadedFilePath'])){

    $targetFile = $_SESSION['uploadedFilePath'];
    // $rotateRange = "";
    // $targetFile = "apol.jpg";
    $commanda = 'D:\Xampp\htdocs\School_projects\Picsure\features\my_venv\Scripts\python.exe "convolution.py" ' . escapeshellarg($targetFile) . ' 2>&1';
    $outputa = shell_exec($commanda);
    // $output;

    if(isset($_POST['inlineRadioOptions'])) {
        $selectedCategory = $_POST['inlineRadioOptions'];

        switch ($selectedCategory) {
            case 'white':
                break;
            case 'black':
                break;
            case 'colored':
                break;
            default:
                break;
        }
       
        $command = 'D:\Xampp\htdocs\School_projects\Picsure\features\my_venv\Scripts\python.exe "shape.py" ' . escapeshellarg($targetFile) . ' ' . escapeshellarg($selectedCategory) . ' 2>&1';
        $output = shell_exec($command);
        echo $output;

        
        $jsonStr = file_get_contents('assets/json/video_info.json');
        $data = json_decode($jsonStr, true);

        $video_name = $data["video_name"];
        $_SESSION['video_name'] = $video_name;
        header('Location: index.php#list-edit');

    } 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // if (isset($_SESSION['rotateRange'])){
        //     $rotateRange = $_POST['rotateRange'];
            
        // }
        if(isset($_POST['value']) && ($_POST['value'] == 0 || $_POST['value'] == 1)){
            $valueReceived = $_POST['value'];

            $command4 = 'D:\Xampp\htdocs\School_projects\Picsure\features\my_venv\Scripts\python.exe "flip.py" ' . escapeshellarg($targetFile) . ' ' . escapeshellarg($valueReceived) . ' 2>&1';
            $output4 = shell_exec($command4);
            echo $output4;
        }

        if(isset($_POST['value']) && ($_POST['value'] == "colorHistogram")){

            $commando = 'D:\Xampp\htdocs\School_projects\Picsure\features\my_venv\Scripts\python.exe "histogram.py" ' . escapeshellarg($targetFile) . ' 2>&1';
            $outputo = shell_exec($commando);

            // echo $outputo;
            $data = json_decode($outputo, true);
            $image = $data['histogramGraph'];
        
            echo $image;

        }

        if(isset($_POST['value']) && ($_POST['value'] == "binaryProjection")){

            $commando = 'D:\Xampp\htdocs\School_projects\Picsure\features\my_venv\Scripts\python.exe "histogram.py" ' . escapeshellarg($targetFile) . ' 2>&1';
            $outputo = shell_exec($commando);

            $data = json_decode($outputo, true);
            $image = $data['binaryProjection'];

            echo $image;
        }
    }

    $command2 = 'D:\Xampp\htdocs\School_projects\Picsure\features\my_venv\Scripts\python.exe "size2.py" ' . escapeshellarg($targetFile) . ' 2>&1';
    $output2 = shell_exec($command2);

    $command3 = 'D:\Xampp\htdocs\School_projects\Picsure\features\my_venv\Scripts\python.exe "center.py" ' . escapeshellarg($targetFile) . ' 2>&1';
    $output3 = shell_exec($command3);

    
}

$sizesFilename = 'assets/json/sizes_info.json';
$shapesFilename = 'assets/json/shape_counts.json';
$colorsFilename = 'assets/json/color_counts.json';

if (file_exists($shapesFilename)) {
    $jsonString = file_get_contents($shapesFilename);
    $shapeCounts = json_decode($jsonString, true);

    $_SESSION['Triangle'] = $shapeCounts["Triangle"];
    $_SESSION['Quadrilateral'] = $shapeCounts["Quadrilateral"];
    $_SESSION['Square'] = $shapeCounts["Square"];
    $_SESSION['Rectangle'] = $shapeCounts["Rectangle"];
    $_SESSION['Pentagon'] = $shapeCounts["Pentagon"];
    $_SESSION['Hexagon'] = $shapeCounts["Hexagon"];
    $_SESSION['Octagon'] = $shapeCounts["Octagon"];
    $_SESSION['Star'] = $shapeCounts["Star"];
    $_SESSION['Circle'] = $shapeCounts["Circle"];
    $_SESSION['Diamond'] = $shapeCounts["Diamond"];
    $_SESSION['Oblong'] = $shapeCounts["Oblong"];
    $_SESSION['Total'] = $shapeCounts["Total"];

    $jsonString = file_get_contents($colorsFilename);
    $colorCounts = json_decode($jsonString, true);

    $_SESSION["Red"] = $colorCounts["Red"];
    $_SESSION["Green"] = $colorCounts["Green"];
    $_SESSION["Blue"] = $colorCounts["Blue"];
    $_SESSION["Yellow"] = $colorCounts["Yellow"];

    $jsonString = file_get_contents($sizesFilename);
    $sizesInfo = json_decode($jsonString, true);

    $_SESSION["object_size"] = $sizesInfo["object_size"];
    $_SESSION["image_height"] = $sizesInfo["image_height"];
    $_SESSION["image_width"] = $sizesInfo["image_width"];
    $_SESSION["centroid_x"] = $sizesInfo["centroid_x"];
    $_SESSION["centroid_y"] = $sizesInfo["centroid_y"];


} else {
    echo "File does not exist.";
}

?>
