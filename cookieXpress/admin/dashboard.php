<?php
session_start();
require_once '../config/config.php';

// Check if admin is logged in
if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}

// Get dashboard stats
$total_orders = $conn->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'];
$pending_orders = $conn->query("SELECT COUNT(*) as count FROM orders WHERE status = 'pending'")->fetch_assoc()['count'];
$total_products = $conn->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'];
$total_users = $conn->query("SELECT COUNT(*) as count FROM users WHERE role = 'customer'")->fetch_assoc()['count'];

// Get recent orders
$recent_orders_result = $conn->query("
    SELECT o.id, o.order_code, o.total_price, o.status, u.username, o.created_at 
    FROM orders o 
    JOIN users u ON o.user_id = u.id 
    ORDER BY o.created_at DESC 
    LIMIT 5
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CookieXpress</title>
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
                <a href="dashboard.php" class="nav-item active">📊 Dashboard</a>
                <a href="products.php" class="nav-item">📦 Products</a>
                <a href="orders.php" class="nav-item">🛒 Orders</a>
                <a href="users.php" class="nav-item">👥 Users</a>
                <hr>
                <a href="logout.php" class="nav-item logout">🚪 Logout</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <div class="admin-header-top">
                <h1>Dashboard</h1>
                <p>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</p>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">📦</div>
                    <div class="stat-info">
                        <h3>Total Orders</h3>
                        <p class="stat-number"><?php echo $total_orders; ?></p>
                    </div>
                </div>

                <div class="stat-card warning">
                    <div class="stat-icon">⏳</div>
                    <div class="stat-info">
                        <h3>Pending Orders</h3>
                        <p class="stat-number"><?php echo $pending_orders; ?></p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">🍪</div>
                    <div class="stat-info">
                        <h3>Total Products</h3>
                        <p class="stat-number"><?php echo $total_products; ?></p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-info">
                        <h3>Total Users</h3>
                        <p class="stat-number"><?php echo $total_users; ?></p>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="admin-section">
                <div class="section-header">
                    <h2>Recent Orders</h2>
                    <a href="orders.php" class="btn-link">View All →</a>
                </div>

                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Order Code</th>
                            <th>Customer</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($order = $recent_orders_result->fetch_assoc()): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($order['order_code']); ?></strong></td>
                            <td><?php echo htmlspecialchars($order['username']); ?></td>
                            <td>Rp <?php echo number_format($order['total_price'], 0, ',', '.'); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo strtolower($order['status']); ?>">
                                    <?php echo ucfirst($order['status']); ?>
                                </span>
                            </td>
                            <td><?php echo date('d M Y', strtotime($order['created_at'])); ?></td>
                            <td><a href="orders.php?edit=<?php echo $order['id']; ?>" class="btn-small">Edit</a></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
