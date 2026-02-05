<?php
// Script to add role column to users table if it doesn't exist
include 'connect.php';

// Check if role column exists
$checkColumn = $conn->query("SHOW COLUMNS FROM users LIKE 'role'");

if ($checkColumn->num_rows == 0) {
    // Add role column with default value 'user'
    $alterQuery = "ALTER TABLE users ADD COLUMN role VARCHAR(20) DEFAULT 'user' AFTER phone";
    
    if ($conn->query($alterQuery)) {
        echo "Role column added successfully!<br>";
        
        // Set first user as admin (optional - you can change this)
        $conn->query("UPDATE users SET role = 'admin' WHERE id = 1 LIMIT 1");
        echo "First user set as admin.<br>";
    } else {
        echo "Error adding role column: " . $conn->error;
    }
} else {
    echo "Role column already exists.";
}

$conn->close();
?>
