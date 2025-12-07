<?php
session_start();
require_once 'config/config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Get cart items
$cart_query = "SELECT ci.id, p.id as product_id, p.name, p.price, ci.quantity, (p.price * ci.quantity) as subtotal 
               FROM cart_items ci 
               JOIN products p ON ci.product_id = p.id 
               WHERE ci.user_id = $user_id";
$cart_result = $conn->query($cart_query);
$cart_items = [];
$subtotal = 0;

while($row = $cart_result->fetch_assoc()){
    $cart_items[] = $row;
    $subtotal += $row['subtotal'];
}

if(empty($cart_items)){
    header("Location: cart.php");
    exit;
}

// Get user info
$user_query = "SELECT email, full_name, phone, address, city, postal_code FROM users WHERE id = $user_id";
$user_result = $conn->query($user_query);
$user = $user_result->fetch_assoc();

$shipping = 10000;
$tax = $subtotal * 0.1;
$total = $subtotal + $shipping + $tax;

$message = '';

// Handle place order with stock checks and transaction
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['place_order'])){
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $city = $conn->real_escape_string($_POST['city']);
    $postal_code = $conn->real_escape_string($_POST['postal_code']);
    $shipping_method = $conn->real_escape_string($_POST['shipping_method']);
    $notes = $conn->real_escape_string($_POST['notes']);

    // Generate order code
    $order_code = 'ORD' . date('YmdHis') . rand(1000, 9999);

    // Start transaction
    $conn->begin_transaction();
    $ok = true;

    // Re-fetch cart items inside transaction to ensure latest quantities
    $cart_query = "SELECT ci.id, p.id as product_id, p.name, p.price, ci.quantity, (p.price * ci.quantity) as subtotal, p.stock 
                   FROM cart_items ci 
                   JOIN products p ON ci.product_id = p.id 
                   WHERE ci.user_id = $user_id FOR UPDATE";
    $cart_result = $conn->query($cart_query);
    $cart_items = [];
    $subtotal = 0;
    while($row = $cart_result->fetch_assoc()){
        $cart_items[] = $row;
        $subtotal += $row['subtotal'];
        // Check stock
        if($row['stock'] < $row['quantity']){
            $ok = false;
            $message = "Not enough stock for: " . htmlspecialchars($row['name']);
            break;
        }
    }

    if($ok){
        // Insert order
        $insert_order = "INSERT INTO orders (user_id, order_code, total_price, shipping_method, shipping_address, notes, status) 
                         VALUES ($user_id, '$order_code', $total, '$shipping_method', '$address, $city', '$notes', 'pending')";

        if($conn->query($insert_order)){
            $order_id = $conn->insert_id;

            // Insert order items and decrement stock atomically
            foreach($cart_items as $item){
                $product_id = intval($item['product_id']);
                $qty = intval($item['quantity']);

                // Decrement stock if enough
                $decr = $conn->query("UPDATE products SET stock = stock - $qty WHERE id = $product_id AND stock >= $qty");
                // Log attempt and outcome using error_log (goes to Apache/PHP error log)
                $attemptMsg = sprintf("%s - checkout: attempt decrement product=%d qty=%d", date('c'), $product_id, $qty);
                error_log($attemptMsg);

                // Log query outcome
                $outcomeMsg = sprintf("%s - checkout: UPDATE affected_rows=%d, error=%s", date('c'), $conn->affected_rows, $conn->error);
                error_log($outcomeMsg);

                if($decr && $conn->affected_rows > 0){
                    $insert_item = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                                   VALUES ($order_id, $product_id, $qty, {$item['price']})";
                    $conn->query($insert_item);
                } else {
                    $ok = false;
                    $message = 'One of the items is out of stock. Order cancelled.';
                    break;
                }
            }

            if($ok){
                // Clear cart
                $clear_cart = "DELETE FROM cart_items WHERE user_id = $user_id";
                $conn->query($clear_cart);

                $conn->commit();
                // Redirect to confirmation
                $_SESSION['last_order_id'] = $order_id;
                header("Location: confirmation.php");
                exit;
            }
        } else {
            $ok = false;
            $message = 'Error placing order. Please try again.';
        }
    }

    if(!$ok){
        $conn->rollback();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - CookieXpress</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="checkout.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="home.php" class="logo">🍪 CookieXpress</a>
            <div class="nav-links">
                <a href="home.php">Home</a>
                <a href="menu.php">Menu</a>
                <a href="cart.php">Back to Cart</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <section class="checkout-section">
        <div class="checkout-header">
            <h1>Order Checkout</h1>
            <p>Complete your order</p>
        </div>

        <?php if($message): ?>
            <div class="message message-error"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <div class="checkout-container">
            <div class="checkout-form">
                <form method="POST">
                    <h2>Shipping Information</h2>
                    
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="address">Street Address</label>
                        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($user['city'] ?? ''); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="postal_code">Postal Code</label>
                            <input type="text" id="postal_code" name="postal_code" value="<?php echo htmlspecialchars($user['postal_code'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="shipping_method">Shipping Method</label>
                        <select id="shipping_method" name="shipping_method" required>
                            <option value="standard">Standard Delivery (2-3 days)</option>
                            <option value="express">Express Delivery (1 day)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="notes">Order Notes (Optional)</label>
                        <textarea id="notes" name="notes" rows="3" placeholder="Any special instructions?"></textarea>
                    </div>

                    <h2>Payment Information</h2>
                    <div class="form-group">
                        <label for="payment_method">Payment Method</label>
                        <select name="payment_method" id="payment_method" required>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="credit_card">Credit Card</option>
                            <option value="ewallet">E-Wallet</option>
                            <option value="cod">Cash on Delivery</option>
                        </select>
                    </div>

                    <button type="submit" name="place_order" class="btn btn-checkout">Place Order</button>
                </form>
            </div>

            <div class="order-summary">
                <h2>Order Summary</h2>
                <div class="summary-items">
                    <?php foreach($cart_items as $item): ?>
                    <div class="summary-item">
                        <span class="item-name"><?php echo htmlspecialchars($item['name']); ?> × <?php echo $item['quantity']; ?></span>
                        <span class="item-price">Rp <?php echo number_format($item['subtotal'], 0, ',', '.'); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="summary-totals">
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping:</span>
                        <span>Rp <?php echo number_format($shipping, 0, ',', '.'); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Tax (10%):</span>
                        <span>Rp <?php echo number_format($tax, 0, ',', '.'); ?></span>
                    </div>
                    <div class="summary-row total">
                        <span>Total:</span>
                        <span>Rp <?php echo number_format($total, 0, ',', '.'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <p>&copy; 2025 CookieXpress. All rights reserved.</p>
    </footer>

    <script src="checkout.js"></script>
</body>
</html>

