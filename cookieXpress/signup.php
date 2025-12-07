<?php
session_start();
require_once 'config/config.php';

// If already logged in, redirect to home
if(isset($_SESSION['user_id'])){
    header("Location: home.php");
    exit;
}

$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Check if connection exists and database is selected
    if(!$conn){
        $error = "Database connection failed. Please contact administrator.";
    } else {
        $username = isset($_POST['username']) ? $conn->real_escape_string($_POST['username']) : '';
        $email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
        
        // Validate inputs
        if(empty($username) || empty($email) || empty($password) || empty($confirm_password)){
            $error = "All fields are required!";
        } elseif($password !== $confirm_password){
            $error = "Passwords do not match!";
        } elseif(strlen($password) < 6){
            $error = "Password must be at least 6 characters!";
        } else {
            // Check if email already exists
            $check_query = "SELECT id FROM users WHERE email = '$email' OR username = '$username'";
            $check_result = $conn->query($check_query);
            
            if($check_result === false){
                $error = "Database error: " . $conn->error . " - Make sure you imported web.sql to the database!";
            } elseif($check_result->num_rows > 0){
                $error = "Email or username already exists!";
            } else {
                // Hash password and insert user
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $insert_query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
                
                if($conn->query($insert_query)){
                    // Account created successfully - redirect immediately to login
                    header("Location: login.php");
                    exit;
                } else {
                    $error = "Error creating account: " . $conn->error;
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - CookieXpress</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="signup.css">
</head>
<body>
    <div class="signup-container">
        <div class="signup-box">
            <div class="signup-header">
                <h1>Join CookieXpress</h1>
                <p>Create your account and start ordering</p>
            </div>

            <?php if($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <?php if($success): ?>
                <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form method="POST" action="signup.php" class="signup-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required placeholder="Choose a username">
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Create a password (min 6 characters)">
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required placeholder="Confirm your password">
                </div>

                <button type="submit" class="btn-signup">Create Account</button>
            </form>

            <div class="signup-footer">
                <p>Already have an account? <a href="login.php">Login here</a></p>
                <a href="index.php" class="back-link">← Back to Home</a>
            </div>
        </div>

        <div class="signup-image">
            <?php if(file_exists('imagecookie/cookieXpress.png')): ?>
                <img src="imagecookie/cookieXpress.png" alt="CookieXpress">
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

