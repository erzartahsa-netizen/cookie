<?php
session_start();
require_once '../config/config.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}

$message = '';
$error = '';
$user = null;

if(isset($_GET['id'])){
    $user_id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM users WHERE id = $user_id");
    $user = $result->fetch_assoc();
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && $user){
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $city = $conn->real_escape_string($_POST['city']);
    $postal_code = $conn->real_escape_string($_POST['postal_code']);
    
    $query = "UPDATE users SET full_name = '$full_name', phone = '$phone', address = '$address', city = '$city', postal_code = '$postal_code' WHERE id = {$user['id']}";
    
    if($conn->query($query)){
        $message = "User updated successfully!";
        $user['full_name'] = $full_name;
        $user['phone'] = $phone;
        $user['address'] = $address;
        $user['city'] = $city;
        $user['postal_code'] = $postal_code;
    } else {
        $error = "Error updating user: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - Admin - CookieXpress</title>
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
                <a href="products.php" class="nav-item">📦 Products</a>
                <a href="orders.php" class="nav-item">🛒 Orders</a>
                <a href="users.php" class="nav-item active">👥 Users</a>
                <hr>
                <a href="logout.php" class="nav-item logout">🚪 Logout</a>
            </nav>
        </aside>

        <main class="admin-main">
            <div class="admin-header-top">
                <h1>Edit User</h1>
                <a href="users.php" class="btn-link">← Back to Users</a>
            </div>

            <?php if($message): ?>
                <div class="success-message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <?php if($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <?php if($user): ?>
            <div class="admin-section">
                <form method="POST" class="admin-form">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                    </div>

                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" rows="3"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($user['city'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="postal_code">Postal Code</label>
                        <input type="text" id="postal_code" name="postal_code" value="<?php echo htmlspecialchars($user['postal_code'] ?? ''); ?>">
                    </div>

                    <button type="submit" class="btn-primary">Update User</button>
                </form>
            </div>
            <?php else: ?>
                <div class="error-message">User not found!</div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
