<?php
    $database = "symptomschecker";
    $password = "usama";
    $servername = "localhost";
    $username = "root";

    $conn = new mysqli($servername,$username,$password,$database);
    if($conn->connect_error){
        die("Connection failed " . $conn->connect_error);
    }else{
//        echo "Connection made successfully";
    }



