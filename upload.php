<?php
session_start();
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

function generateUniqueFileName($originalFileName)
{
    $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);
    $timestamp = time();
    $randomString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 10);
    return $timestamp . "_" . $randomString . "." . $extension;
}

$uploadDirectory = "assets/uploads/";

if (!is_dir($uploadDirectory)) {
    mkdir($uploadDirectory, 0755, true);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == 0) {
        $targetFile = $uploadDirectory . generateUniqueFileName($_FILES['fileToUpload']['name']);

    $targetFile;
       
    if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFile)) {
        $_SESSION['uploadedFilePath'] = $targetFile; 
        header('location: index.php');
        echo "File has been uploaded successfully.";
    } else {
        echo "There was an error uploading your file.";
    }
}elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        unset($_SESSION['uploadedFilePath']);
        echo "No file was uploaded, or previous file display cleared.";
}
?>
