<?php
session_start();
$conn = new mysqli("localhost", "root", "", "studentiks");
if ($conn->connect_error) die("Connection failed");

// If form is submitted, save/update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    // Optional: Save it to session so it persists
    $_SESSION['form_data'] = [
        'name'  => $name,
        'email' => $email,
        'phone' => $phone
    ];
}

$userData = $_SESSION['form_data'] ?? null;

// If the user is logged in, fetch database info
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $result = $conn->query("SELECT * FROM users WHERE id = $id");
    if ($result && $result->num_rows > 0) {
        $dbUser = $result->fetch_assoc();
        $userData = $userData ?? $dbUser;
    }
}

// Default fallback
$userData = $userData ?? [
    'name' => 'User',
    'email' => 'Nuk ka të dhëna',
    'phone' => 'Nuk ka të dhëna',
    'role' => 'Student'
];

// Prepare display name
$displayName = !empty($userData['name']) ? $userData['name'] : ($userData['firstname'] ?? 'User');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studenti-Ks - User</title>
    <link rel="stylesheet" href="user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="page-content">
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
                <a href="register.html"><button id="register-btn">Register</button></a>
                
                <label class="switch">
                    <input type="checkbox" id="theme-toggle">
                    <span class="slider"></span>
                </label>
            </div>
            
            <button class="hamburger" id="hamburger">
                <span></span><span></span><span></span>
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
                <a href="register.html"><button id="register-btn">Register</button></a>
                <i id="switch" class="fa-solid fa-moon"></i>
            </div>
        </div>

        <div class="profile-container">
            <div class="profile-left">
                <img src="https://i.pravatar.cc/300" alt="Profile Photo">
            </div>
            <div class="profile-right">
                <h2><?php echo strtoupper(htmlspecialchars($displayName)); ?></h2>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone'] ?? 'Nuk ka të dhëna'); ?></p>
                <p>
                    <strong>Status:</strong>
                    <span class="status admin"><?php echo htmlspecialchars($user['role'] ?? 'Student'); ?></span> 
                </p>
            </div>
        </div>

        <footer>
             © 2025 Studenti-Ks. All rights reserved.
        </footer>  
    </div>

    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const body = document.body;
        
        themeToggle.addEventListener('change', function() {
            if (this.checked) {
                body.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                body.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        });
        
        const savedTheme = localStorage.getItem('theme');
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

        const switch2 = document.getElementById('switch');
        if(switch2) {
            switch2.addEventListener("click", () => {
                document.body.classList.toggle("dark");
            });
        }
    </script>
</body>
</html>