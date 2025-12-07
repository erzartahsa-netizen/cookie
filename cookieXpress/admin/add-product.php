<?php
session_start();
require_once '../config/config.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}

$message = '';
$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = floatval($_POST['price']);
    $category = $conn->real_escape_string($_POST['category']);
    $stock = intval($_POST['stock']);
    
    $query = "INSERT INTO products (name, description, price, category, stock) VALUES ('$name', '$description', $price, '$category', $stock)";
    
    if($conn->query($query)){
        $message = "Product added successfully!";
    } else {
        $error = "Error adding product: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Admin - CookieXpress</title>
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
                <h1>Add New Product</h1>
                <a href="products.php" class="btn-link">← Back to Products</a>
            </div>

            <?php if($message): ?>
                <div class="success-message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <?php if($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <div class="admin-section">
                <form method="POST" class="admin-form">
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" id="name" name="name" required placeholder="e.g., Chocolate Chip Cookies">
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" rows="4" placeholder="Describe the product..."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="price">Price (Rp)</label>
                        <input type="number" id="price" name="price" step="0.01" required placeholder="e.g., 25000">
                    </div>

                    <div class="form-group">
                        <label for="category">Category</label>
                        <input type="text" id="category" name="category" required placeholder="e.g., Classic, Premium, Specialty">
                    </div>

                    <div class="form-group">
                        <label for="stock">Stock</label>
                        <input type="number" id="stock" name="stock" min="0" required placeholder="e.g., 50">
                    </div>

                    <button type="submit" class="btn-primary">Add Product</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
