<?php
session_start();
require_once 'config/config.php';

// Check if user is logged in
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$message = '';
$message_type = '';

// Handle remove from cart
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_item'])){
    $cart_item_id = intval($_POST['cart_item_id']);
    $delete_query = "DELETE FROM cart_items WHERE id = $cart_item_id AND user_id = $user_id";
    $conn->query($delete_query);
    $message = 'Item removed from cart';
    $message_type = 'success';
}

// Handle update quantity
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_quantity'])){
    $cart_item_id = intval($_POST['cart_item_id']);
    $quantity = intval($_POST['quantity']);
    
    if($quantity > 0){
        $update_query = "UPDATE cart_items SET quantity = $quantity WHERE id = $cart_item_id AND user_id = $user_id";
        $conn->query($update_query);
    }
}

// Get cart items with product details
$cart_query = "SELECT ci.id, p.id as product_id, p.name, p.price, ci.quantity, (p.price * ci.quantity) as subtotal 
               FROM cart_items ci 
               JOIN products p ON ci.product_id = p.id 
               WHERE ci.user_id = $user_id
               ORDER BY ci.added_at DESC";
$cart_result = $conn->query($cart_query);
$cart_items = [];
$total = 0;

while($row = $cart_result->fetch_assoc()){
    $cart_items[] = $row;
    $total += $row['subtotal'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - CookieXpress</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="home.php" class="logo">🍪 CookieXpress</a>
            <div class="nav-links">
                <a href="home.php">Home</a>
                <a href="menu.php">Menu</a>
                <a href="setting.php">Profile</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <section class="cart-section">
        <div class="cart-header">
            <h1>Shopping Cart</h1>
            <p>Review your items before checkout</p>
        </div>

        <?php if($message): ?>
            <div class="message message-<?php echo $message_type; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="cart-container">
            <?php if(!empty($cart_items)): ?>
                <div class="cart-items">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($cart_items as $item): ?>
                                <tr>
                                    <td class="product-name"><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td>Rp <?php echo number_format($item['price'], 0, ',', '.'); ?></td>
                                    <td>
                                        <form method="POST" class="qty-form" style="display: flex; gap: 5px;">
                                            <input type="hidden" name="cart_item_id" value="<?php echo $item['id']; ?>">
                                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="qty-input">
                                            <button type="submit" name="update_quantity" class="btn-update">Update</button>
                                        </form>
                                    </td>
                                    <td>Rp <?php echo number_format($item['subtotal'], 0, ',', '.'); ?></td>
                                    <td>
                                        <form method="POST" class="remove-form">
                                            <input type="hidden" name="cart_item_id" value="<?php echo $item['id']; ?>">
                                            <button type="submit" name="remove_item" class="btn-remove">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="cart-summary">
                    <div class="summary-box">
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span>Rp <?php echo number_format($total, 0, ',', '.'); ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Shipping:</span>
                            <span>Rp 10.000</span>
                        </div>
                        <div class="summary-row">
                            <span>Tax (10%):</span>
                            <span>Rp <?php echo number_format($total * 0.1, 0, ',', '.'); ?></span>
                        </div>
                        <div class="summary-row total">
                            <span>Total:</span>
                            <span>Rp <?php echo number_format($total + 10000 + ($total * 0.1), 0, ',', '.'); ?></span>
                        </div>
                        <a href="checkout.php" class="btn btn-checkout">Proceed to Checkout</a>
                        <a href="menu.php" class="btn btn-continue">Continue Shopping</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="empty-cart">
                    <p>Your cart is empty</p>
                    <a href="menu.php" class="btn btn-shop">Go to Menu</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <footer class="footer">
        <p>&copy; 2025 CookieXpress. All rights reserved.</p>
    </footer>

    <script src="cart.js"></script>
</body>
</html>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="cart.css">
</head>

<a href="menu.php">Back to Menu</a>

    <script src="cart.js"></script>
    <script src="main.js"></script>

</body>
</html>
