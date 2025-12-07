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

// Handle Add to Cart
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])){
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']) ?? 1;
    
    // Check if product exists
    $product_query = "SELECT id, name, price, stock FROM products WHERE id = $product_id";
    $product_result = $conn->query($product_query);
    
    if($product_result->num_rows > 0){
        $product = $product_result->fetch_assoc();
        
        if($product['stock'] > 0){
            // Check if product already in cart
            $check_query = "SELECT id, quantity FROM cart_items WHERE user_id = $user_id AND product_id = $product_id";
            $check_result = $conn->query($check_query);
            
            if($check_result->num_rows > 0){
                // Update quantity
                $new_quantity = $quantity;
                $update_query = "UPDATE cart_items SET quantity = quantity + $quantity WHERE user_id = $user_id AND product_id = $product_id";
                $conn->query($update_query);
            } else {
                // Insert new item
                $insert_query = "INSERT INTO cart_items (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity)";
                $conn->query($insert_query);
            }
            
            $message = $product['name'] . ' added to cart!';
            $message_type = 'success';
        } else {
            $message = 'Product out of stock!';
            $message_type = 'error';
        }
    }
}

// Get all products
$products_query = "SELECT id, name, description, price, stock, category FROM products ORDER BY category, name";
$products_result = $conn->query($products_query);
$products = [];
while($row = $products_result->fetch_assoc()){
    $products[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookie Menu - CookieXpress</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="menu.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="home.php" class="logo">🍪 CookieXpress</a>
            <div class="nav-links">
                <a href="home.php">Home</a>
                <a href="cart.php" class="cart-link">🛒 Cart</a>
                <a href="setting.php">Profile</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Menu Section -->
    <section class="menu-section">
        <div class="menu-header">
            <h1>Our Delicious Cookie Collection</h1>
            <p>Freshly baked cookies delivered to your door</p>
        </div>

        <?php if($message): ?>
            <div class="message message-<?php echo $message_type; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="products-grid">
            <?php if(!empty($products)): ?>
                <?php foreach($products as $product): ?>
                    <div class="product-card" data-product-id="<?php echo $product['id']; ?>">
                        <div class="product-header">
                            <span class="category-badge"><?php echo htmlspecialchars($product['category']); ?></span>
                            <span class="stock-badge <?php echo $product['stock'] > 0 ? 'in-stock' : 'out-stock'; ?>">
                                <?php echo $product['stock'] > 0 ? 'In Stock' : 'Out'; ?>
                            </span>
                        </div>
                        
                        <div class="product-image">
                            <img src="imagecookie/default-cookie.png" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        </div>

                        <div class="product-info">
                            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p class="description"><?php echo htmlspecialchars($product['description']); ?></p>
                            
                            <div class="product-footer">
                                <div class="price">Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></div>
                                
                                <?php if($product['stock'] > 0): ?>
                                    <form method="POST" class="add-to-cart-form">
                                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                        <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>" class="qty-input">
                                        <button type="submit" name="add_to_cart" class="btn btn-add">+ Add</button>
                                    </form>
                                <?php else: ?>
                                    <button class="btn btn-disabled" disabled>Out of Stock</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-products">
                    <p>No products available at the moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <footer class="footer">
        <p>&copy; 2025 CookieXpress. All rights reserved.</p>
    </footer>

    <script src="menu.js"></script>
</body>
</html>


