<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_otp = $_POST['otp'];

    if (isset($_SESSION['otp']) && $_SESSION['otp'] == $input_otp) {
        echo "OTP verified successfully!";
        header('Location:ResetPassword.php');
        unset($_SESSION['otp']); // Clear OTP after successful verification
    } else {
        echo "Invalid OTP, please try again.";
    }
}
