<?php
// Simple helper: visit /scripts/generate_hash.php?pw=yourpassword
if(!isset($_GET['pw'])){
    echo "Usage: ?pw=yourpassword\n\nExample: http://localhost/cookieXpress/scripts/generate_hash.php?pw=admin123";
    exit;
}
$password = $_GET['pw'];
$hash = password_hash($password, PASSWORD_DEFAULT);
header('Content-Type: text/plain; charset=utf-8');
echo $hash;
?>