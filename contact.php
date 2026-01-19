<?php
header('Content-Type: application/json');

// Get form data
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Validate input
if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    echo json_encode([
        "status" => "error",
        "message" => "Please fill in all fields."
    ]);
    exit();
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        "status" => "error",
        "message" => "Please enter a valid email address."
    ]);
    exit();
}

// Email configuration
// CHANGE THIS TO YOUR EMAIL ADDRESS WHERE YOU WANT TO RECEIVE CONTACT FORM SUBMISSIONS
$to_email = "hello@Studenti-Ks.com"; // Your email address
$email_subject = "Contact Form Submission: " . htmlspecialchars($subject);

// Email body with better formatting
$email_body = "===========================================\n";
$email_body .= "NEW CONTACT FORM SUBMISSION\n";
$email_body .= "===========================================\n\n";
$email_body .= "Name: " . htmlspecialchars($name) . "\n";
$email_body .= "Email: " . htmlspecialchars($email) . "\n";
$email_body .= "Subject: " . htmlspecialchars($subject) . "\n\n";
$email_body .= "Message:\n";
$email_body .= "-------------------------------------------\n";
$email_body .= htmlspecialchars($message) . "\n";
$email_body .= "-------------------------------------------\n\n";
$email_body .= "Submitted on: " . date('Y-m-d H:i:s') . "\n";
$email_body .= "===========================================\n";

// Email headers with proper encoding
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
$headers .= "From: " . htmlspecialchars($name) . " <" . htmlspecialchars($email) . ">\r\n";
$headers .= "Reply-To: " . htmlspecialchars($email) . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
$headers .= "X-Priority: 3\r\n";

// Send email
$mail_sent = mail($to_email, $email_subject, $email_body, $headers);

if ($mail_sent) {
    echo json_encode([
        "status" => "success",
        "message" => "Thank you! Your message has been sent successfully."
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Sorry, there was an error sending your message. Please try again later or contact us directly at hello@Studenti-Ks.com"
    ]);
}
?>
