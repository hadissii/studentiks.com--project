<?php
session_start();
include 'connect.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode(["status" => "error", "message" => "Not logged in"]);
    exit();
}

$stats = [];

// Get total users count
$result = $conn->query("SELECT COUNT(*) as total FROM users");
if ($result) {
    $stats['total_users'] = $result->fetch_assoc()['total'];
}

// Get admin count
$result = $conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'admin'");
if ($result) {
    $stats['total_admins'] = $result->fetch_assoc()['total'];
}

// Get regular users count
$result = $conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'user'");
if ($result) {
    $stats['total_regular_users'] = $result->fetch_assoc()['total'];
}

// Get current user info
$stats['current_user'] = [
    'name' => $_SESSION['name'] ?? 'User',
    'email' => $_SESSION['email'] ?? '',
    'role' => $_SESSION['role'] ?? 'user'
];

echo json_encode([
    "status" => "success",
    "stats" => $stats
]);
?>
