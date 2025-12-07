<?php
session_start();
require_once 'config/config.php';

// If already logged in, redirect to home
if(isset($_SESSION['user_id'])){
    header("Location: home.php");
    exit;
}

$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    
    // Check if user exists
    $query = "SELECT id, username, email, password FROM users WHERE email = '$email'";
    $result = $conn->query($query);
    
    if($result->num_rows > 0){
        $user = $result->fetch_assoc();
        
        // Verify password
        if(password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            header("Location: home.php");
            exit;
        } else {
            $error = "Invalid email or password!";
        }
    } else {
        $error = "Invalid email or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CookieXpress</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <h1>Welcome Back to CookieXpress</h1>
                <p>Fresh Baked Cookies Delivered</p>
            </div>

            <?php if($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" class="login-form">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                </div>

                <button type="submit" class="btn-login">Login</button>
            </form>

            <div class="login-footer">
                <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
                <a href="index.php" class="back-link">← Back to Home</a>
            </div>
        </div>

        <div class="login-image">
            <?php if(file_exists('imagecookie/cookieXpress.png')): ?>
                <img src="imagecookie/cookieXpress.png" alt="CookieXpress">
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
