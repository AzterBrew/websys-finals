<?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "websys_db";

    //concat all em to create db conneciton
    $con = mysqli_connect($host,$username,$password,$database);

    if(!$con){
        die("Connection Failed : ". mysqli_connect_error());
    }
