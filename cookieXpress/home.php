<?php
session_start();
require_once 'config/config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Get user info
$user_query = "SELECT username, email, full_name FROM users WHERE id = $user_id";
$user_result = $conn->query($user_query);
$user = $user_result->fetch_assoc();

// Get cart count
$cart_query = "SELECT COUNT(*) as count FROM cart_items WHERE user_id = $user_id";
$cart_result = $conn->query($cart_query);
$cart_count = $cart_result->fetch_assoc()['count'];

// Get recent orders
$orders_query = "SELECT id, order_code, total_price, status, created_at FROM orders WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 5";
$orders_result = $conn->query($orders_query);
$orders = [];
while($row = $orders_result->fetch_assoc()){
    $orders[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - CookieXpress</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="home.css">
</head>
<body class="home-page">
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="home.php" class="logo">🍪 CookieXpress</a>
            <div class="nav-links">
                <span class="greeting">Welcome, <?php echo htmlspecialchars($user['username']); ?></span>
                <a href="menu.php">Menu</a>
                <a href="cart.php" class="cart-link">🛒 Cart (<?php echo $cart_count; ?>)</a>
                <a href="setting.php">Profile</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header>
        <div class="hero-section">
            <div class="middle">
                <h1>Welcome To CookieXpress</h1>
                <h2>When You Find The Fresh Baked Cookies Right In Front Of Your Face</h2>
            </div>

            <div class="left-image">
                <?php if(file_exists('imagecookie/cookieXpress.png')): ?>
                    <img src="imagecookie/cookieXpress.png" alt="CookieXpress">
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="home-content">
        <section class="quick-actions">
            <h2>What would you like to do?</h2>
            <div class="action-cards">
                <a href="menu.php" class="action-card">
                    <div class="icon">🍪</div>
                    <h3>Browse Menu</h3>
                    <p>Explore our fresh baked cookies</p>
                </a>

                <a href="cart.php" class="action-card">
                    <div class="icon">🛒</div>
                    <h3>View Cart</h3>
                    <p><?php echo $cart_count; ?> items in your cart</p>
                </a>

                <a href="setting.php" class="action-card">
                    <div class="icon">👤</div>
                    <h3>Profile</h3>
                    <p>Manage your account</p>
                </a>
            </div>
        </section>

        <?php if(!empty($orders)): ?>
        <section class="recent-orders">
            <h2>Recent Orders</h2>
            <div class="orders-list">
                <?php foreach($orders as $order): ?>
                <div class="order-item">
                    <div class="order-info">
                        <span class="order-code"><?php echo htmlspecialchars($order['order_code']); ?></span>
                        <span class="order-date"><?php echo date('M d, Y', strtotime($order['created_at'])); ?></span>
                    </div>
                    <div class="order-price">Rp <?php echo number_format($order['total_price'], 0, ',', '.'); ?></div>
                    <span class="order-status status-<?php echo strtolower($order['status']); ?>"><?php echo ucfirst($order['status']); ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
    </main>

    <footer class="footer">
        <p>&copy; 2025 CookieXpress. All rights reserved.</p>
    </footer>

    <script src="home.js"></script>
</body>
</html>
