<?php
session_start();
require_once '../config/config.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}

$message = '';
$error = '';

// Handle status update
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])){
    $order_id = intval($_POST['order_id']);
    $status = $conn->real_escape_string($_POST['status']);
    
    if($conn->query("UPDATE orders SET status = '$status' WHERE id = $order_id")){
        $message = "Order status updated to: " . ucfirst($status);
    } else {
        $error = "Error updating status: " . $conn->error;
    }
}

// Get all orders with customer info
$orders = $conn->query("
    SELECT o.id, o.order_code, o.total_price, o.status, u.username, u.email, o.created_at, o.shipping_address, o.notes
    FROM orders o 
    JOIN users u ON o.user_id = u.id 
    ORDER BY o.created_at DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - Admin - CookieXpress</title>
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
                <a href="products.php" class="nav-item">📦 Products</a>
                <a href="orders.php" class="nav-item active">🛒 Orders</a>
                <a href="users.php" class="nav-item">👥 Users</a>
                <hr>
                <a href="logout.php" class="nav-item logout">🚪 Logout</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <div class="admin-header-top">
                <h1>Manage Orders</h1>
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
                            <th>Order Code</th>
                            <th>Customer</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($order = $orders->fetch_assoc()): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($order['order_code']); ?></strong></td>
                            <td>
                                <div><?php echo htmlspecialchars($order['username']); ?></div>
                                <small><?php echo htmlspecialchars($order['email']); ?></small>
                            </td>
                            <td>Rp <?php echo number_format($order['total_price'], 0, ',', '.'); ?></td>
                            <td>
                                <form method="POST" class="inline-form">
                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                    <select name="status" class="status-select">
                                        <option value="pending" <?php echo $order['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="confirmed" <?php echo $order['status'] == 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                        <option value="processing" <?php echo $order['status'] == 'processing' ? 'selected' : ''; ?>>Processing</option>
                                        <option value="shipped" <?php echo $order['status'] == 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                                        <option value="delivered" <?php echo $order['status'] == 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                                        <option value="cancelled" <?php echo $order['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                    </select>
                                    <button type="submit" name="update_status" class="btn-small">Update</button>
                                </form>
                            </td>
                            <td><?php echo date('d M Y', strtotime($order['created_at'])); ?></td>
                            <td>
                                <button class="btn-small" onclick="showDetails(<?php echo htmlspecialchars(json_encode($order)); ?>)">View</button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Modal for order details -->
    <div id="detailsModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Order Details</h2>
            <div id="detailsBody"></div>
        </div>
    </div>

    <script>
        function showDetails(order) {
            document.getElementById('detailsBody').innerHTML = `
                <p><strong>Order Code:</strong> ${order.order_code}</p>
                <p><strong>Customer:</strong> ${order.username} (${order.email})</p>
                <p><strong>Total Price:</strong> Rp ${order.total_price.toLocaleString('id-ID')}</p>
                <p><strong>Status:</strong> ${order.status}</p>
                <p><strong>Shipping Address:</strong> ${order.shipping_address}</p>
                <p><strong>Notes:</strong> ${order.notes || 'N/A'}</p>
            `;
            document.getElementById('detailsModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('detailsModal').style.display = 'none';
        }
    </script>
</body>
</html>
