<?php
    $servername ="localhost";
    $username ="root";
    $password = "";
    $database ="apnakhata";
    $conn=mysqli_connect($servername,$username,$password,$database);
    if(!$conn){
        die("some error occoured");
    }
?>