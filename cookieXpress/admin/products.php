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
    $product_id = intval($_GET['delete']);
    if($conn->query("DELETE FROM products WHERE id = $product_id")){
        $message = "Product deleted successfully!";
    } else {
        $error = "Error deleting product: " . $conn->error;
    }
}

// Handle update stock
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_stock'])){
    $product_id = intval($_POST['product_id']);
    $stock = intval($_POST['stock']);
    
    if($conn->query("UPDATE products SET stock = $stock WHERE id = $product_id")){
        $message = "Stock updated successfully!";
    } else {
        $error = "Error updating stock: " . $conn->error;
    }
}

// Get all products
$products = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Admin - CookieXpress</title>
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
                <a href="products.php" class="nav-item active">📦 Products</a>
                <a href="orders.php" class="nav-item">🛒 Orders</a>
                <a href="users.php" class="nav-item">👥 Users</a>
                <hr>
                <a href="logout.php" class="nav-item logout">🚪 Logout</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <div class="admin-header-top">
                <h1>Manage Products</h1>
                <a href="add-product.php" class="btn-primary">+ Add New Product</a>
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
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Stock</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($product = $products->fetch_assoc()): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($product['name']); ?></strong></td>
                            <td>Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($product['category']); ?></td>
                            <td>
                                <form method="POST" class="inline-form">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <input type="number" name="stock" value="<?php echo $product['stock']; ?>" min="0" class="stock-input">
                                    <button type="submit" name="update_stock" class="btn-small">Update</button>
                                </form>
                            </td>
                            <td>
                                <a href="edit-product.php?id=<?php echo $product['id']; ?>" class="btn-small">Edit</a>
                                <a href="?delete=<?php echo $product['id']; ?>" class="btn-small btn-danger" onclick="return confirm('Delete this product?')">Delete</a>
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
