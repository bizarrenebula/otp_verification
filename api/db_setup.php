<?php
// Run the PHP server from /api with 'php -S localhost:3030'
// Then open in browser http://localhost:3030/db_setup.php to recreate the DB and Users table, if needed

function recreateOtpfyDB(){
    $servername = "localhost";
    $username = "root";
    $password = "password";

    // BEGIN: DDL Logic
    $conn = new mysqli($servername, $username, $password);

    $check_db = "USE otpfy";

    if($conn->query($check_db) === FALSE){
        $create_db_query = "CREATE DATABASE otpfy";
        if($conn->query($create_db_query) === TRUE){
            error_log("OTPFY_DB CREATED SUCCESSFULLY.");
            recreateUsersTable();
        }else{
            error_log("OTPFY_DB CANNOT BE CREATED.");
        }
    }

    $conn->close();
}

function recreateUsersTable(){
    $servername = "localhost";
    $username = "root";
    $password = "password";
    $database = "otpfy";

    $conn = new mysqli($servername, $username, $password, $database);

    $sql = "CREATE TABLE IF NOT EXISTS users(
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(30) NOT NULL,
        phone VARCHAR(30) NOT NULL,
        pass VARCHAR(120) NOT NULL,
        otp INT,
        verified VARCHAR(1),
        UNIQUE KEY(email, phone)
    );";

    if ($conn->query($sql) === TRUE) {
        error_log("Table USERS created successfully");
      } else {
        error_log("Error creating table: " . $conn->error);
      }
}

recreateOtpfyDB();

?>