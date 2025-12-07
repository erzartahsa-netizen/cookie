<?php
session_start();
require_once 'config/config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$message = '';
$message_type = '';

// Get user info
$user_query = "SELECT id, username, email, full_name, phone, address, city, postal_code FROM users WHERE id = $user_id";
$user_result = $conn->query($user_query);
$user = $user_result->fetch_assoc();

// Handle profile update
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])){
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $city = $conn->real_escape_string($_POST['city']);
    $postal_code = $conn->real_escape_string($_POST['postal_code']);
    
    $update_query = "UPDATE users SET full_name = '$full_name', phone = '$phone', address = '$address', city = '$city', postal_code = '$postal_code' WHERE id = $user_id";
    
    if($conn->query($update_query)){
        $message = 'Profile updated successfully!';
        $message_type = 'success';
        // Refresh user data
        $user_result = $conn->query($user_query);
        $user = $user_result->fetch_assoc();
    } else {
        $message = 'Error updating profile!';
        $message_type = 'error';
    }
}

// Handle password change
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])){
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Get current password hash
    $pwd_query = "SELECT password FROM users WHERE id = $user_id";
    $pwd_result = $conn->query($pwd_query);
    $pwd_row = $pwd_result->fetch_assoc();
    
    if(password_verify($current_password, $pwd_row['password'])){
        if($new_password === $confirm_password && strlen($new_password) >= 6){
            $hashed_pwd = password_hash($new_password, PASSWORD_DEFAULT);
            $pwd_update = "UPDATE users SET password = '$hashed_pwd' WHERE id = $user_id";
            
            if($conn->query($pwd_update)){
                $message = 'Password changed successfully!';
                $message_type = 'success';
            } else {
                $message = 'Error changing password!';
                $message_type = 'error';
            }
        } else {
            $message = 'Passwords do not match or too short!';
            $message_type = 'error';
        }
    } else {
        $message = 'Current password is incorrect!';
        $message_type = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings - CookieXpress</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="setting.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="home.php" class="logo">🍪 CookieXpress</a>
            <div class="nav-links">
                <a href="home.php">Home</a>
                <a href="menu.php">Menu</a>
                <a href="cart.php">Cart</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <section class="settings-section">
        <div class="settings-header">
            <h1>Account Settings</h1>
            <p>Manage your profile and account information</p>
        </div>

        <?php if($message): ?>
            <div class="message message-<?php echo $message_type; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="settings-container">
            <!-- Profile Information -->
            <div class="settings-box">
                <h2>Profile Information</h2>
                <form method="POST" class="settings-form">
                    <div class="form-group">
                        <label>Username (cannot change)</label>
                        <input type="text" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
                    </div>

                    <div class="form-group">
                        <label>Email (cannot change)</label>
                        <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                    </div>

                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>" placeholder="Enter your full name">
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" placeholder="Enter your phone number">
                    </div>

                    <div class="form-group">
                        <label for="address">Street Address</label>
                        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>" placeholder="Enter your address">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($user['city'] ?? ''); ?>" placeholder="Enter your city">
                        </div>

                        <div class="form-group">
                            <label for="postal_code">Postal Code</label>
                            <input type="text" id="postal_code" name="postal_code" value="<?php echo htmlspecialchars($user['postal_code'] ?? ''); ?>" placeholder="Enter postal code">
                        </div>
                    </div>

                    <button type="submit" name="update_profile" class="btn btn-save">Save Profile</button>
                </form>
            </div>

            <!-- Change Password -->
            <div class="settings-box">
                <h2>Change Password</h2>
                <form method="POST" class="settings-form">
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password" placeholder="Enter current password" required>
                    </div>

                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password" placeholder="Enter new password (min 6 characters)" required>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
                    </div>

                    <button type="submit" name="change_password" class="btn btn-save">Change Password</button>
                </form>
            </div>
        </div>
    </section>

    <footer class="footer">
        <p>&copy; 2025 CookieXpress. All rights reserved.</p>
    </footer>

    <script src="setting.js"></script>
</body>
</html>


