<?php
include 'db_connection.php';

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Content-Type');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $conn = OpenCon();


    $verified = "N";
    $sql = "SELECT otp FROM users WHERE email=? AND verified=?";
    $stmt = $conn->prepare($sql); 
    $stmt->bind_param("ss", $user, $verified);

    $DATA = json_decode(file_get_contents("php://input"),true);

    // Catch user input
    $user = $DATA['user'];
    $otp = intval($DATA['otp']);

    // debug values
    // error_log("$user - $otp");

    if($stmt->execute() === TRUE){
        $result = $stmt->get_result(); // get the mysqli result
        $data = $result->fetch_assoc(); // fetch data 

        if($otp === intval($data['otp'])){
            $verified = "Y";
            $sql = "UPDATE users SET verified=? WHERE email=? AND otp=?";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("ssi", $verified, $user, $otp);
            if($stmt->execute() === TRUE){
                $message = "Welcome to SMSBump!";
                $ecode = 1;
                error_log("Otp verified! ".$ecode);
            }
        }else{
            $message = "Verification failed!";
            $ecode = 0;
            error_log("Otp not verified! ".$ecode);
        }

        echo json_encode(array(
            "message" => $message,
            "ecode" => $ecode
        ));

    }

    CloseCon($conn);
}