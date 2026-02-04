<?php
session_start();
include 'connect.php';

header('Content-Type: application/json');

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if (!$email || !$password) {
    echo json_encode(["status" => "error", "message" => "Please fill all fields"]);
    exit();
}

$stmt = $conn->prepare("SELECT id, name, email, phone, role, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    if (password_verify($password, $user['password'])) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['phone'] = $user['phone'];
        $_SESSION['role'] = isset($user['role']) ? $user['role'] : 'user';
        
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Wrong password"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "User not found"]);
}

$stmt->close();
$conn->close();
exit();
?>