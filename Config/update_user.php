<?php
session_start();
include 'connect.php';

header('Content-Type: application/json');

// Check if user is logged in and is admin
if (!isset($_SESSION['id'])) {
    echo json_encode(["status" => "error", "message" => "Not logged in"]);
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    echo json_encode(["status" => "error", "message" => "Access denied. Admin only."]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $name = $conn->real_escape_string($_POST['name'] ?? '');
    $email = $conn->real_escape_string($_POST['email'] ?? '');
    $phone = $conn->real_escape_string($_POST['phone'] ?? '');
    $role = $conn->real_escape_string($_POST['role'] ?? 'user');

    if ($id > 0 && $name && $email) {
        $updateQuery = "UPDATE users SET name='$name', email='$email', phone='$phone', role='$role' WHERE id=$id";
        
        if ($conn->query($updateQuery)) {
            echo json_encode(["status" => "success", "message" => "User updated successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid data"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>
