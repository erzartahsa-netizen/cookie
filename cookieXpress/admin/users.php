<?php
session_start();
require_once '../config/config.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}

$message = '';
$error = '';

// Handle delete
if(isset($_GET['delete'])){
    $user_id = intval($_GET['delete']);
    if($user_id != $_SESSION['admin_id']){ // Don't allow deleting yourself
        if($conn->query("DELETE FROM users WHERE id = $user_id")){
            $message = "User deleted successfully!";
        } else {
            $error = "Error deleting user: " . $conn->error;
        }
    } else {
        $error = "You cannot delete your own account!";
    }
}

// Get all users
$users = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users - Admin - CookieXpress</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body class="admin-body">
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-logo">
                <h2>🍪 CookieXpress</h2>
                <p>Admin Panel</p>
            </div>
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-item">📊 Dashboard</a>
                <a href="products.php" class="nav-item">📦 Products</a>
                <a href="orders.php" class="nav-item">🛒 Orders</a>
                <a href="users.php" class="nav-item active">👥 Users</a>
                <hr>
                <a href="logout.php" class="nav-item logout">🚪 Logout</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <div class="admin-header-top">
                <h1>Manage Users</h1>
            </div>

            <?php if($message): ?>
                <div class="success-message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <?php if($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <div class="admin-section">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Phone</th>
                            <th>Created Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($user = $users->fetch_assoc()): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($user['username']); ?></strong></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <span class="role-badge role-<?php echo strtolower($user['role']); ?>">
                                    <?php echo ucfirst($user['role']); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($user['phone'] ?? '-'); ?></td>
                            <td><?php echo date('d M Y', strtotime($user['created_at'])); ?></td>
                            <td>
                                <a href="edit-user.php?id=<?php echo $user['id']; ?>" class="btn-small">Edit</a>
                                <?php if($user['id'] != $_SESSION['admin_id']): ?>
                                    <a href="?delete=<?php echo $user['id']; ?>" class="btn-small btn-danger" onclick="return confirm('Delete this user?')">Delete</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
