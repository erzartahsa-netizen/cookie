<?php
session_start();
require_once '../config/config.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}

$message = '';
$error = '';
$product = null;

if(isset($_GET['id'])){
    $product_id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM products WHERE id = $product_id");
    $product = $result->fetch_assoc();
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && $product){
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = floatval($_POST['price']);
    $category = $conn->real_escape_string($_POST['category']);
    $stock = intval($_POST['stock']);
    
    $query = "UPDATE products SET name = '$name', description = '$description', price = $price, category = '$category', stock = $stock WHERE id = {$product['id']}";
    
    if($conn->query($query)){
        $message = "Product updated successfully!";
        $product = ['id' => $product['id'], 'name' => $name, 'description' => $description, 'price' => $price, 'category' => $category, 'stock' => $stock];
    } else {
        $error = "Error updating product: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Admin - CookieXpress</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body class="admin-body">
    <div class="admin-container">
        <aside class="admin-sidebar">
            <div class="sidebar-logo">
                <h2>🍪 CookieXpress</h2>
                <p>Admin Panel</p>
            </div>
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-item">📊 Dashboard</a>
                <a href="products.php" class="nav-item active">📦 Products</a>
                <a href="orders.php" class="nav-item">🛒 Orders</a>
                <a href="users.php" class="nav-item">👥 Users</a>
                <hr>
                <a href="logout.php" class="nav-item logout">🚪 Logout</a>
            </nav>
        </aside>

        <main class="admin-main">
            <div class="admin-header-top">
                <h1>Edit Product</h1>
                <a href="products.php" class="btn-link">← Back to Products</a>
            </div>

            <?php if($message): ?>
                <div class="success-message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <?php if($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <?php if($product): ?>
            <div class="admin-section">
                <form method="POST" class="admin-form">
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($product['description']); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="price">Price (Rp)</label>
                        <input type="number" id="price" name="price" value="<?php echo $product['price']; ?>" step="0.01" required>
                    </div>

                    <div class="form-group">
                        <label for="category">Category</label>
                        <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($product['category']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="stock">Stock</label>
                        <input type="number" id="stock" name="stock" value="<?php echo $product['stock']; ?>" min="0" required>
                    </div>

                    <button type="submit" class="btn-primary">Update Product</button>
                </form>
            </div>
            <?php else: ?>
                <div class="error-message">Product not found!</div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
