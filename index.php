<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studenti-Ks - Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
</head>
<body class="light">
      <!-- NAVBAR -->
   <!-- ==================== NAVBAR ==================== -->
<nav class="nav-container">
    <img src="LogoStudentiks_pabg.png" alt="Logo" class="logo">

    <div class="nav-links">
    <a href="index.html">
        <i class="fa-solid fa-house"></i>
        Ballina
    </a>

    <a href="about.html">
        <i class="fa-solid fa-circle-info"></i>
        Rreth nesh
    </a>

    <a href="contact.html">
        <i class="fa-solid fa-envelope"></i>
        Kontakti
    </a>

    <a href="colleges.html">
        <i class="fa-solid fa-graduation-cap"></i>
        Fakultetet
    </a>
</div>


    <div class="auth-buttons">
        <a href="dashboard.php"><i class="fa-solid fa-user"></i></a>
        <a href="login.html"><button>Login</button></a>
        <a href="register.html"><button>Register</button></a>

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

<!-- ==================== MOBILE MENU ==================== -->
<div class="mobile-menu" id="mobile-menu">
    <a href="index.html">Ballina</a>
    <a href="about.html">Rreth nesh</a>
    <a href="contact.html">Kontakti</a>
    <a href="colleges.html">Fakultetet</a>
    <a href="dashboard.php">Dashboard</a>
</div>
    
    
    <!-- MAIN CONTENT -->
    <main class="hero">
        <div class="hero-content">
            <h1>Studenti-Ks</h1>
            <p>Find your perfect student accommodation and compatible roommates across Kosovo's universities.</p>
        </div>
        
        <!-- Card Grid -->
        <div class="card-grid">
            <!-- Card 1 -->
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <h3>Student Housing</h3>
                        <p>Find affordable and comfortable housing near your campus</p>
                    </div>
                    <div class="flip-card-back">
                        <img src="housing.jpg" alt="Student Housing">
                        <p>Modern apartments and dormitories</p>
                    </div>
                </div>
            </div>
            
            <!-- Card 2 -->
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <h3>Roommate Matching</h3>
                        <p>Connect with compatible roommates based on your preferences</p>
                    </div>
                    <div class="flip-card-back">
                        <img src="roommates.jpg" alt="Roommate Matching">
                        <p>Smart matching algorithm</p>
                    </div>
                </div>
            </div>
            
            <!-- Card 3 -->
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <h3>University Network</h3>
                        <p>Access housing options across all major universities</p>
                    </div>
                    <div class="flip-card-back">
                        <img src="Image3.jpg" alt="University Network">
                        <p>All universities in Kosovo covered</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <!-- FOOTER -->
    <footer>
        <div class="footer-bottom">
            <p>&copy; 2024 Studenti-Ks. All rights reserved.</p>
        </div>
    </footer>
    
        <script>
        // Theme Toggle
        const themeToggle = document.getElementById('theme-toggle');
        const body = document.body;
        
        themeToggle.addEventListener('change', function() {
            if (this.checked) {
                body.classList.remove('light');
                body.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                body.classList.remove('dark');
                body.classList.add('light');
                localStorage.setItem('theme', 'light');
            }
        });
        
        // Check saved theme
        const savedTheme = localStorage.getItem('theme') || 'light';
        if (savedTheme === 'dark') {
            body.classList.remove('light');
            body.classList.add('dark');
            themeToggle.checked = true;
        }
        
        // Mobile Menu Toggle
        const hamburger = document.getElementById('hamburger');
        const mobileMenu = document.getElementById('mobile-menu');
        
        hamburger.addEventListener('click', function() {
            hamburger.classList.toggle('active');
            mobileMenu.classList.toggle('active');
        });
        
        // Close mobile menu when clicking links
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                hamburger.classList.remove('active');
                mobileMenu.classList.remove('active');
            });
        });
    </script>
     <script>
        const switch2 = document.getElementById('switch');

switch2.addEventListener("click", () => {
    document.body.classList.toggle("dark");
});
    
    </script>
</body>
</html>