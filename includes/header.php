<?php 
session_start();
require "dbcon.php";
include 'middleware.php';

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/Keepy_Logo.png" type="image/png">
    <title>Keepy - Inventory System</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css" >
</head>
<body class="content">
<div class="custom-nav">
<?php 
include 'navbar.php'; 
include 'sidebar.php'; 
?>
</div>
            <div>
