<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "studentiks");
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['email']) || empty($_POST['password'])) {
        echo json_encode(["status" => "error", "message" => "Please fill all fields"]);
        exit();
    }

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, name, email, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {

        $stmt->bind_result($id, $name, $emailDB, $hashedPassword, $role);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {

            $_SESSION['id'] = $id;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $emailDB;
            $_SESSION['role'] = $role;

            echo json_encode(["status" => "success"]);
            exit();
        }
    }

    echo json_encode(["status" => "error", "message" => "Invalid email or password"]);
    exit();
}

echo json_encode(["status" => "error", "message" => "Invalid request"]);
exit();
