<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

// Allow requests from your frontend (adjust as needed)
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

try {
    // Read the JSON input
    $requestBody = file_get_contents('php://input');
    $data = json_decode($requestBody, true);

    // Validate required fields
    if (empty($data['fullName']) || empty($data['email'])) {
        echo json_encode(['success' => false, 'message' => 'Full Name and Email are required.']);
        exit;
    }

    // Set up PHPMailer
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'echatemohammed@gmail.com'; // Your Gmail address
    $mail->Password   = 'feizqbtewinhqzmb';           // Your Gmail app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('echatemohammed@gmail.com', 'Moving Services');
    $mail->addAddress('echatemohammed@gmail.com');      // Recipient address

    $mail->isHTML(true);
    $mail->Subject = 'New Moving Request from ' . $data['fullName'];
    $mail->Body    = "
        <p><strong>Name:</strong> {$data['fullName']}</p>
        <p><strong>Email:</strong> {$data['email']}</p>
        <p><strong>Phone:</strong> {$data['phone']}</p>
        <p><strong>Type:</strong> {$data['type']}</p>
        <p><strong>Moving From:</strong> {$data['movingFrom']}</p>
        <p><strong>Moving To:</strong> {$data['movingTo']}</p>
        <p><strong>Moving Date:</strong> {$data['movingDate']}</p>
        <p><strong>Moving Time:</strong> {$data['movingTime']}</p>
        <p><strong>Size:</strong> {$data['size']}</p>
        <p><strong>Move Description:</strong> {$data['moveDescription']}</p>
    ";

    $mail->send();
    echo json_encode(['success' => true, 'message' => 'Email sent successfully!']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => "Mailer Error: {$mail->ErrorInfo}"]);
}
