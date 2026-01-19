<?php
session_start();
include 'connect.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode(["status" => "error", "message" => "Not logged in"]);
    exit();
}

// Get user data from session or database
$userData = [
    'id' => $_SESSION['id'] ?? null,
    'name' => $_SESSION['name'] ?? null,
    'email' => $_SESSION['email'] ?? null,
    'phone' => $_SESSION['phone'] ?? null,
    'role' => $_SESSION['role'] ?? 'user' // Get role from session or default to 'user'
];

// If session data is incomplete, fetch from database
if (!$userData['name'] || !$userData['email'] || !$userData['phone'] || !$userData['role']) {
    $id = intval($_SESSION['id']); // Ensure ID is an integer to prevent SQL injection
    $result = $conn->query("SELECT name, email, phone, role FROM users WHERE id = $id");
    if ($result && $result->num_rows > 0) {
        $dbUser = $result->fetch_assoc();
        $userData['name'] = $dbUser['name'] ?? $userData['name'];
        $userData['email'] = $dbUser['email'] ?? $userData['email'];
        $userData['phone'] = $dbUser['phone'] ?? $userData['phone'];
        $userData['role'] = $dbUser['role'] ?? 'user';
        
        // Update session with database data
        $_SESSION['name'] = $userData['name'];
        $_SESSION['email'] = $userData['email'];
        $_SESSION['phone'] = $userData['phone'];
        $_SESSION['role'] = $userData['role'];
    }
}

echo json_encode([
    "status" => "success",
    "name" => $userData['name'],
    "email" => $userData['email'],
    "phone" => $userData['phone'],
    "role" => $userData['role']
]);
?>
