<?php
/**
 * CookieXpress - Database Configuration
 * This file handles MySQL connection through XAMPP/phpMyAdmin
 */

// Database credentials
$host = "localhost";
$db_user = "root";           // Default XAMPP username
$db_password = "";           // Default XAMPP password (empty)
$database = "cookiexpress.com";

// Create connection
$conn = new mysqli($host, $db_user, $db_password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Set charset to UTF-8
$conn->set_charset("utf8mb4");

// Define base URL for links
define('BASE_URL', 'http://localhost/cookieXpress/');
define('SITE_NAME', 'CookieXpress');

?>
