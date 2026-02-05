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

// Fetch all users
$result = $conn->query("SELECT id, name, email, phone, role FROM users ORDER BY id DESC");
$users = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

echo json_encode([
    "status" => "success",
    "users" => $users
]);
?>
