<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require '../connection.php';
session_start();
if (empty($_SESSION['form_token'])) {
  $_SESSION['form_token'] = bin2hex(random_bytes(32));
}

function generateNumber() {
    return random_int(100000, 999999);
}

// Set response type to JSON
header('Content-Type: application/json');

$response = ['status' => 'error', 'message' => 'An unexpected error occurred.'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_SESSION['form_token']) && isset($_POST['form_token']) &&
        hash_equals($_SESSION['form_token'], $_POST['form_token'])) {

        if (isset($_POST['registersubmit'])) {
            $verificationCode = generateNumber();
            $sql = "SELECT * FROM verification_number WHERE verify_number = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$verificationCode]);

            if ($stmt->fetchAll()) {
                $verificationCode = generateNumber();
            } else {
                $is_used = false;
                $sql = "INSERT INTO verification_number (verify_number, is_used) VALUES (?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$verificationCode, $is_used]);

                $email = $_POST['email'];
                $uid = $_POST['uid'];

                $mail = new PHPMailer(true);

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'facethereality01@gmail.com';
                $mail->Password = 'xzlm ixrh qjiw abbk'; // Replace with your actual password
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                $mail->setFrom('facethereality01@gmail.com');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = "Registration Link";
                $mail->Body = "This is your verification code: $verificationCode<br>Link: http://localhost/parking/register.php<br>UID: $uid";

                if ($mail->send()) {
                    $response = ['status' => 'success', 'message' => 'Verification email sent successfully!'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Failed to send email.'];
                }
            }
        }
        unset($_SESSION['form_token']);
    } else {
        $response = ['status' => 'error', 'message' => 'Invalid form submission or possible CSRF attack.'];
    }
} else {
    $response = ['status' => 'error', 'message' => 'Invalid request method.'];
}

echo json_encode($response);
?>
