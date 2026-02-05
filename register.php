<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    if (isset($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['password'])) {

        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $phone = $conn->real_escape_string($_POST['phone']);
        
        $raw_password = $_POST['password'];
        $password = password_hash($raw_password, PASSWORD_DEFAULT);

        $checkEmail = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($checkEmail);

        if ($result->num_rows > 0) {
            echo json_encode(["status" => "error", "message" => "Email already exists"]);
        } else {
            $insertQuery = "INSERT INTO users (name, email, phone, password, role) VALUES ('$name', '$email', '$phone', '$password', 'user')";
            
            if ($conn->query($insertQuery) === true) {
                $_SESSION['id'] = $conn->insert_id;
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;
                $_SESSION['phone'] = $phone;
                $_SESSION['role'] = 'user';

                echo json_encode(["status" => "success"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Database error"]);
            }
        }
    }
    exit();
}
?>