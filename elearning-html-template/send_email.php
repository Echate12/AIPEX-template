<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Load PHPMailer

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *"); // Allows requests from any origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $fullName = $data['fullName'] ?? '';
    $email = $data['email'] ?? '';
    $phone = $data['phone'] ?? '';
    $description = $data['description'] ?? '';

    if (empty($fullName) || empty($email) || empty($description)) {
        echo json_encode(['message' => 'All fields are required!']);
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'echatemohammed@gmail.com'; // Change to your email
        $mail->Password   = 'tyopbjvfblhurvzh'; // Change to your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Email Content
        $mail->setFrom($email, $fullName);
        $mail->addAddress('echatemohammed@gmail.com'); // Change to your receiving email
        $mail->Subject = "New Contact Form Submission from $fullName";
        $mail->Body    = "Name: $fullName\nEmail: $email\nPhone: $phone\nMessage: $description";

        $mail->send();
        echo json_encode(['message' => 'Email sent successfully!']);
    } catch (Exception $e) {
        echo json_encode(['message' => 'Error sending email: ' . $mail->ErrorInfo]);
    }
} else {
    echo json_encode(['message' => 'Invalid request method.']);
}
