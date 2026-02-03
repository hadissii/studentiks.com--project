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
        $password = $_POST['password'];

        // Check if email exists
        $checkEmail = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($checkEmail);

        if ($result->num_rows > 0) {
            echo json_encode(["status" => "error", "message" => "Email already exists"]);
        } else {
            // Insert with default role 'user'
            $insertQuery = "INSERT INTO users (name, email, phone, password, role) VALUES ('$name', '$email', '$phone', '$password', 'user')";
            if ($conn->query($insertQuery) === true) {
                // Save user ID and all form data in session
                $_SESSION['id'] = $conn->insert_id;
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;
                $_SESSION['phone'] = $phone;
                $_SESSION['role'] = 'user'; // Default role for new users

                // Return success JSON
                echo json_encode(["status" => "success"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Database error"]);
            }
        }
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>StudentiKs - Register</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
<div class="form-container">
    <div id="msg"></div>
    <form id="signup-form">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="tel" name="phone" placeholder="Phone" required>
        <input type="password" id="password" name="password" placeholder="Password" required>
        <input type="password" id="confirm_password" placeholder="Confirm Password" required>
        <button type="submit" class="submit-btn">Create Account</button>
    </form>
</div>

<script>
document.getElementById("signup-form").addEventListener("submit", function(e) {
    e.preventDefault(); // Prevent default form submission

    const pass = document.getElementById("password").value;
    const confirm = document.getElementById("confirm_password").value;

    if (pass !== confirm) {
        alert("Passwords do not match!");
        return;
    }

    const formData = new FormData(this);

    fetch("register.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            // Redirect to user.html on successful registration
            window.location.href = "user.html";
        } else {
            document.getElementById("msg").innerText = data.message;
        }
    })
    .catch(err => {
        console.error("Fetch error:", err);
        document.getElementById("msg").innerText = "Something went wrong. Try again.";
    });
});
</script>
</body>
</html>
