<?php
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $db = "vidhub";
    $conn = new mysqli($servername, $username, $password, $db);

    if($conn->conecct_error){
        die("Connection failed: ".$conn->connect_error);
    }
    echo "Connected Successfully";
    // Create database
    // $sql = "CREATE DATABASE vidhub";
    // if ($conn->query($sql) === TRUE) {
    //     echo "Database created successfully";
    // } else {
    //     echo "Error creating database: " . $conn->error;
    // }

    $conn->close();
?>
