<?php
session_start();
require_once '../config/config.php';

// If already logged in as admin, redirect to dashboard
if(isset($_SESSION['admin_id'])){
    header("Location: dashboard.php");
    exit;
}

$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    if(empty($email) || empty($password)){
        $error = "Email and password required!";
    } else {
        // Check if user is admin
        $query = "SELECT id, username, email, password, role FROM users WHERE email = '$email' AND role = 'admin'";
        $result = $conn->query($query);
        
        if($result && $result->num_rows > 0){
            $user = $result->fetch_assoc();
            
            if(password_verify($password, $user['password'])){
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_username'] = $user['username'];
                $_SESSION['admin_email'] = $user['email'];
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Invalid password!";
            }
        } else {
            $error = "Admin account not found!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - CookieXpress</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body class="admin-body">
    <div class="admin-login-container">
        <div class="admin-login-box">
            <div class="admin-header">
                <h1>🍪 CookieXpress Admin</h1>
                <p>Management Portal</p>
            </div>

            <?php if($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" class="admin-form" action="login.php">
                <div class="form-group">
                    <label for="email">Admin Email</label>
                    <input type="email" id="email" name="email" required placeholder="Enter admin email">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter password">
                </div>

                <button type="submit" class="btn-admin-login">Login to Dashboard</button>
            </form>

            <div class="admin-footer">
                <p><a href="../index.php">← Back to Website</a></p>
            </div>
        </div>
    </div>
</body>
</html>
