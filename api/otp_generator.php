<?php

function generateOTP(){
    // simple OTP generator
    $otp = mt_rand(1000,9999);

    return $otp;
}


?>