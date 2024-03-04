<?php
session_start(); 
if (isset($_POST['reset'])) {

    if (isset($_SESSION['uploadedFilePath']) || isset($_SESSION['grayscaled'])) {

        unset($_SESSION['uploadedFilePath']);
        unset($_SESSION['grayscaled']);
    }

    header('Location: index.php'); 
    exit();
}
?>
