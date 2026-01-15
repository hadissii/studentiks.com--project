<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $checkEmail = "SELECT * FROM users where email='$email'";
        $result = $conn->query($checkEmail);

        if ($result->num_rows > 0) {
            echo json_encode(["status" => "error", "message" => "Email Address Already Exists"]);
        } else {
            $insertquery = "INSERT INTO users (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$password')";
            if ($conn->query($insertquery) === true) {
                session_start();
                $_SESSION['id'] = $conn->insert_id;
                echo json_encode(["status" => "success"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
            }
        }
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudentiKs- Create Account</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body class="light">
    <nav class="nav-container">
        <img src="LogoStudentiks_pabg.png" alt="Logo" class="logo">
        <div class="nav-links">
            <a href="index.html">Ballina</a>
            <a href="about.html">Rreth nesh</a>
            <a href="contact.html">Kontakti</a>
            <a href="colleges.html">Fakultetet</a>
        </div>
        <div class="auth-buttons">
            <a href="user.php"><i class="fa-solid fa-user" id="fa-user"></i></a>
            <a href="login.html"><button id="loginBtn">Login</button></a>
            <a href="register.php"><button id="register-btn">Register</button></a>
            <label class="switch">
                <input type="checkbox" id="theme-toggle">
                <span class="slider"></span>
            </label>
        </div>
        <button class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </nav>
    
    <div class="mobile-menu" id="mobile-menu">
        <div class="mobile-menu-links">
            <a href="index.html">Ballina</a>
            <a href="about.html">Rreth nesh</a>
            <a href="contact.html">Kontakti</a>
            <a href="colleges.html">Fakultetet</a>
        </div>
        <div class="mobile-auth-buttons">
            <a href="user.php"><i class="fa-solid fa-user" id="fa-user"></i></a>
            <a href="login.html"><button id="loginBtn">Login</button></a>
            <a href="register.php"><button id="register-btn">Register</button></a>
            <i id="switch" class="fa-solid fa-moon"></i>
        </div>
    </div>

    <main>
        <section>
            <h1 class="title">Create Your Account</h1>
            <p class="title">Join students across Kosovo who are finding the perfect homes and compatible roommates.</p>
            
            <div class="form-container">
                <div id="msg" style="text-align: center; margin-bottom: 10px;"></div>
                <form id="signup-form">
                    <div class="form-group">
                        <label for="full-name">Full Name</label>
                        <input type="text" id="full-name" placeholder="Enter your full name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" placeholder="Enter your email address" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" placeholder="Enter your phone number" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password (minimum 6 characters)</label>
                        <input type="password" id="password" placeholder="Create a password" minlength="6" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" id="confirm-password" placeholder="Confirm your password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="submit-btn">Create Account</button>
                    <p>Already have an account? <a href="login.html">Login here</a></p>
                </form>
            </div>
        </section>
    </main>
    
    <footer>
        © 2025 Studenti-Ks. All rights reserved.
    </footer>
    
    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const body = document.body;
        
        themeToggle.addEventListener('change', function() {
            if (this.checked) {
                body.classList.replace('light', 'dark');
                localStorage.setItem('theme', 'dark');
            } else {
                body.classList.replace('dark', 'light');
                localStorage.setItem('theme', 'light');
            }
        });
        
        const savedTheme = localStorage.getItem('theme') || 'light';
        if (savedTheme === 'dark') {
            body.classList.add('dark');
            themeToggle.checked = true;
        }

        const hamburger = document.getElementById('hamburger');
        const mobileMenu = document.getElementById('mobile-menu');
        hamburger.addEventListener('click', function() {
            hamburger.classList.toggle('active');
            mobileMenu.classList.toggle('active');
        });

        document.getElementById("signup-form").addEventListener("submit", function(e) {
            e.preventDefault();
            const msg = document.getElementById("msg");
            const pass = document.getElementById("password").value;
            const confirmPass = document.getElementById("confirm-password").value;

            if (pass !== confirmPass) {
                msg.textContent = "Passwords do not match!";
                msg.style.color = "red";
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
                    window.location.href = "user.php"; 
                } else {
                    msg.textContent = data.message;
                    msg.style.color = "red";
                }
            })
            .catch(() => {
                msg.textContent = "An error occurred.";
                msg.style.color = "red";
            });
        });
    </script>
</body>
</html>