<?php
    function OpenCon(){
        $servername = "localhost";
        $username = "root";
        $password = "password";
        $database = "otpfy";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }else{
            error_log("connected");
            return $conn;
        }
    }

    function CloseCon($conn){
        if($conn){
            error_log("disconnected");
            $conn -> close();
        }else{
            error_log("no connection has been made");
        }
    }
?>