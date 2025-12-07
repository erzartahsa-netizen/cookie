<?php
session_start();
require_once 'config/config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$order_id = $_SESSION['last_order_id'] ?? 0;

if($order_id == 0){
    header("Location: home.php");
    exit;
}

// Get order details
$order_query = "SELECT id, order_code, total_price, created_at FROM orders WHERE id = $order_id AND user_id = $user_id";
$order_result = $conn->query($order_query);

if($order_result->num_rows == 0){
    header("Location: home.php");
    exit;
}

$order = $order_result->fetch_assoc();
unset($_SESSION['last_order_id']); // Clear the flag
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - CookieXpress</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="confirmation.css">
</head>
<body class="confirmation-page">
    <div class="confirmation-container">
        <div class="confirmation-content">
            <div class="success-icon">✓</div>
            
            <h1>Order Confirmed!</h1>
            <p class="subtitle">Thank you for your order</p>

            <div class="order-details">
                <div class="detail-row">
                    <span class="label">Order Number:</span>
                    <span class="value"><?php echo htmlspecialchars($order['order_code']); ?></span>
                </div>

                <div class="detail-row">
                    <span class="label">Order Date:</span>
                    <span class="value"><?php echo date('F d, Y H:i', strtotime($order['created_at'])); ?></span>
                </div>

                <div class="detail-row">
                    <span class="label">Total Amount:</span>
                    <span class="value price">Rp <?php echo number_format($order['total_price'], 0, ',', '.'); ?></span>
                </div>

                <div class="detail-row">
                    <span class="label">Status:</span>
                    <span class="value status">Pending</span>
                </div>
            </div>

            <div class="confirmation-message">
                <p>We're preparing your delicious cookies! 🍪</p>
                <p>You will receive an email confirmation shortly with tracking details.</p>
            </div>

            <div class="confirmation-actions">
                <a href="home.php" class="btn btn-primary">Back to Home</a>
                <a href="menu.php" class="btn btn-secondary">Continue Shopping</a>
            </div>
        </div>

        <div class="confirmation-image">
            <?php if(file_exists('imagecookie/cookieXpress.png')): ?>
                <img src="imagecookie/cookieXpress.png" alt="CookieXpress">
            <?php endif; ?>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 CookieXpress. All rights reserved.</p>
    </footer>

    <script src="confirmation.js"></script>
</body>
</html>

