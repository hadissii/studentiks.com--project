<?php

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'connect.php';

$query_total = "SELECT COUNT(*) as total FROM users";
$result_total = mysqli_query($conn, $query_total);
$row_total = mysqli_fetch_assoc($result_total);
$total_users = $row_total['total'];

$query_recent = "SELECT emri, email, roli, statusi FROM users ORDER BY id DESC LIMIT 5";
$recent_users = mysqli_query($conn, $query_recent);
?>

<section class="admin-stats">
    <div class="stat-box">
        <h4>Total Përdorues</h4>
        <p><?php echo $total_users; ?></p>
        <span class="stat-trend">Përditësuar tani</span>
    </div>
</section>

<section class="admin-table-section">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Emri</th>
                <th>Email</th>
                <th>Roli</th>
                <th>Veprimet</th>
            </tr>
        </thead>
        <tbody>
            <?php while($user = mysqli_fetch_assoc($recent_users)): ?>
            <tr>
                <td><?php echo $user['emri']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['roli']; ?></td>
                <td><button class="edit-btn">Menaxho</button></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>