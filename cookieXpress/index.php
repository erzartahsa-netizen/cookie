<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CookieXpress - Fresh Baked Cookies Delivery</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Permanent+Marker&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="home-page">
    <header>
        <div class="hero-section">
            <div class="middle">
                <h1>Welcome To CookieXpress</h1>
                <h2>When You Find The Fresh Baked Cookies Right In Front Of Your Face</h2>
            </div>
    
            <div class="floating-auth">
                <a href="login.php" class="first btn">Login</a>
                <a href="signup.php" class="second btn">Sign Up</a>
            </div>

            <div class="left-image">
                <?php if(file_exists('imagecookie/cookieXpress.png')): ?>
                    <img src="imagecookie/cookieXpress.png" alt="CookieXpress Cookies">
                <?php endif; ?>
            </div>
        </div>
    </header>

    <footer class="footer-img">
        <?php if(file_exists('imagecookie/Footer.svg')): ?>
            <img src="imagecookie/Footer.svg" alt="Footer">
        <?php endif; ?>
    </footer>

    <script src="main.js"></script>
</body>
</html>
