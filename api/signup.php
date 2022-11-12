<?php
include 'db_connection.php';
include 'otp_generator.php';

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Content-Type');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $conn = OpenCon();

    // prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (email, phone, pass, otp, verified) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $email, $phone, $pass, $otp,$verified);

    $DATA = json_decode(file_get_contents("php://input"),true);

    // Catch user input
    $email = $DATA['userData']['email'];
    $phone = $DATA['phone'];
    // one way password hash
    $pass = hash('md5', $DATA['userData']['pass']);
    $otp = generateOTP();
    $verified = "N";

    // error_log(gettype($phone));

    if($stmt->execute() === TRUE){
        echo json_encode(array(
            "otp" => $otp,
            "email" => $email,
            "phone" => $phone,
        ));
        error_log("Inserted to DB: ");
        error_log("$email, $phone, $pass, $otp");
    }else{
        echo json_encode(array(
            "message" => $stmt->error,
        ));
        error_log($stmt->error);
    }

    CloseCon($conn);
}
