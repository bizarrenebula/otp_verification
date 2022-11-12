<?php
include 'db_connection.php';
include 'otp_generator.php';

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Content-Type');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $conn = OpenCon();

    $stmt = $conn->prepare("UPDATE users SET otp=? WHERE email=?");
    $stmt->bind_param("is", $otp, $email);

    $DATA = json_decode(file_get_contents("php://input"),true);

    // Catch user input
    $email = $DATA['user'];
    $otp = generateOTP();

    if($stmt->execute() === TRUE){
        $verified = "N";
        $sql = "UPDATE users SET verified=? WHERE email=? AND otp=?";
        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("ssi", $verified, $user, $otp);
            if($stmt->execute() === TRUE){
                echo json_encode(array(
                        "otp" => $otp,
                        "email" => $email,
                    ));
                    error_log("Updated DB: ");
                    error_log("$email, $otp");
                }else{
                    echo json_encode(array(
                        "message" => $stmt->error,
                    ));
                    error_log($stmt->error);
                }
        }else{
            $message = "Could not generate new OTP!";
            echo $message;
            error_log("Otp not generated!");
        }

    CloseCon($conn);
}
