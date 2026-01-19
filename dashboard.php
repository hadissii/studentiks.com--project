<?php
session_start();
include 'connect.php';

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.html');
    exit();
}

// Get user data
$userId = intval($_SESSION['id']);
$result = $conn->query("SELECT * FROM users WHERE id = $userId");
$user = $result->fetch_assoc();

// Update session with latest data
$_SESSION['name'] = $user['name'];
$_SESSION['email'] = $user['email'];
$_SESSION['phone'] = $user['phone'];
$_SESSION['role'] = $user['role'] ?? 'user';

$isAdmin = ($_SESSION['role'] === 'admin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studenti-Ks - Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="light">
    <div class="page-content">
        <!-- ==================== NAVBAR ==================== -->
        <nav class="nav-container">
            <!-- Logo -->
            <img src="LogoStudentiks_pabg.png" alt="Logo" class="logo">
            <!-- Desktop Navigation Links -->
            
            <div class="nav-links">
                <a href="index.html">Ballina</a>
                <a href="about.html">Rreth nesh</a>
                <a href="contact.html">Kontakti</a>
                <a href="colleges.html">Fakultetet</a>
                <a href="dashboard.php">Dashboard</a>
            </div>
            
            <!-- Desktop Auth Buttons -->
            <div class="auth-buttons">
                <a href="dashboard.php"><i class="fa-solid fa-user" id="fa-user"></i></a>
                <a href="logout.php"><button id="logoutBtn">Logout</button></a>
                
                <!-- Theme Toggle -->
                <label class="switch">
                    <input type="checkbox" id="theme-toggle">
                    <span class="slider"></span>
                </label>
            </div>
            
            <!-- Hamburger Menu (Mobile Only) -->
            <button class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </nav>
    
        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobile-menu">
            <div class="mobile-menu-links">
                <a href="index.html">Ballina</a>
                <a href="about.html">Rreth nesh</a>
                <a href="contact.html">Kontakti</a>
                <a href="colleges.html">Fakultetet</a>
                <a href="dashboard.php">Dashboard</a>
            </div>
            <div class="mobile-auth-buttons">
                <a href="dashboard.php"><i class="fa-solid fa-user" id="fa-user"></i></a>
                <a href="logout.php"><button id="logoutBtn">Logout</button></a>
                <!-- Theme Toggle -->
                <i id="switch" class="fa-solid fa-moon"></i>
            </div>
        </div>

        <!-- ==================== DASHBOARD CONTENT ==================== -->
        <div class="dashboard-container">
            <div class="dashboard-header">
                <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
                <p class="user-role">
                    <span class="role-badge <?php echo $isAdmin ? 'admin' : 'user'; ?>">
                        <i class="fa-solid fa-<?php echo $isAdmin ? 'shield-halved' : 'user'; ?>"></i>
                        <?php echo $isAdmin ? 'Administrator' : 'User'; ?>
                    </span>
                </p>
            </div>

            <!-- User Dashboard -->
            <?php if (!$isAdmin): ?>
            <div class="dashboard-grid">
                <div class="dashboard-card profile-card">
                    <div class="card-header">
                        <h2><i class="fa-solid fa-user"></i> Profile Information</h2>
                    </div>
                    <div class="card-content">
                        <div class="profile-info">
                            <div class="profile-avatar">
                                <img src="https://i.pravatar.cc/150?img=<?php echo $userId; ?>" alt="Profile">
                            </div>
                            <div class="profile-details">
                                <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                                <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?></p>
                                <p><strong>User ID:</strong> #<?php echo $userId; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h2><i class="fa-solid fa-house"></i> Quick Actions</h2>
                    </div>
                    <div class="card-content">
                        <div class="action-buttons">
                            <a href="colleges.html" class="action-btn">
                                <i class="fa-solid fa-graduation-cap"></i>
                                <span>Browse Colleges</span>
                            </a>
                            <a href="contact.html" class="action-btn">
                                <i class="fa-solid fa-envelope"></i>
                                <span>Contact Us</span>
                            </a>
                            <a href="user.html" class="action-btn">
                                <i class="fa-solid fa-id-card"></i>
                                <span>View Profile</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h2><i class="fa-solid fa-info-circle"></i> Account Status</h2>
                    </div>
                    <div class="card-content">
                        <div class="status-item">
                            <span class="status-label">Account Type:</span>
                            <span class="status-value user">Regular User</span>
                        </div>
                        <div class="status-item">
                            <span class="status-label">Member Since:</span>
                            <span class="status-value">Active</span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Admin Dashboard -->
            <?php if ($isAdmin): ?>
            <div class="dashboard-grid">
                <div class="stats-row">
                    <div class="stat-card">
                        <div class="stat-icon users">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="total-users">-</h3>
                            <p>Total Users</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon admins">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="total-admins">-</h3>
                            <p>Administrators</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon regular">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="total-regular">-</h3>
                            <p>Regular Users</p>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card profile-card">
                    <div class="card-header">
                        <h2><i class="fa-solid fa-user"></i> Your Profile</h2>
                    </div>
                    <div class="card-content">
                        <div class="profile-info">
                            <div class="profile-avatar">
                                <img src="https://i.pravatar.cc/150?img=<?php echo $userId; ?>" alt="Profile">
                            </div>
                            <div class="profile-details">
                                <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                                <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?></p>
                                <p><strong>Role:</strong> <span class="role-badge admin">Administrator</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h2><i class="fa-solid fa-cog"></i> Admin Actions</h2>
                    </div>
                    <div class="card-content">
                        <div class="action-buttons">
                            <a href="manage-users.html" class="action-btn admin-btn">
                                <i class="fa-solid fa-users-cog"></i>
                                <span>Manage Users</span>
                            </a>
                            <a href="user.html" class="action-btn">
                                <i class="fa-solid fa-id-card"></i>
                                <span>View Profile</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <footer>
            © 2025 Studenti-Ks. All rights reserved.
        </footer>
    </div>

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
        
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                hamburger.classList.remove('active');
                mobileMenu.classList.remove('active');
            });
        });

        const switch2 = document.getElementById('switch');
        if(switch2) {
            switch2.addEventListener("click", () => {
                document.body.classList.toggle("dark");
                document.body.classList.toggle("light");
                const isDark = document.body.classList.contains("dark");
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
            });
        }

        // Load stats for admin dashboard
        <?php if ($isAdmin): ?>
        fetch('get_stats.php')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('total-users').textContent = data.stats.total_users || 0;
                    document.getElementById('total-admins').textContent = data.stats.total_admins || 0;
                    document.getElementById('total-regular').textContent = data.stats.total_regular_users || 0;
                }
            })
            .catch(err => console.error('Error loading stats:', err));
        <?php endif; ?>
    </script>
</body>
</html>
