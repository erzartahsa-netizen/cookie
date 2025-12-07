<?php
// One-time admin inserter. Run in browser: /scripts/insert_admin.php
// After use, delete this file for security.

header('Content-Type: text/plain; charset=utf-8');
require_once __DIR__ . '/../config/config.php';

$admin_email = 'admin@cookiexpress.com';
$admin_username = 'admin';
$admin_password = 'admin123';

// Check if admin exists
$check = $conn->query("SELECT id FROM users WHERE email = '" . $conn->real_escape_string($admin_email) . "' AND role = 'admin'");
if ($check && $check->num_rows > 0) {
    echo "Admin user already exists (email: $admin_email).\n";
    exit;
}

// Insert admin
$hashed = password_hash($admin_password, PASSWORD_DEFAULT);
$insert = $conn->query("INSERT INTO users (username, email, password, role) VALUES ('" . $conn->real_escape_string($admin_username) . "', '" . $conn->real_escape_string($admin_email) . "', '" . $conn->real_escape_string($hashed) . "', 'admin')");

if ($insert) {
    echo "Admin account created successfully:\n";
    echo "  email: $admin_email\n";
    echo "  password: $admin_password\n";
    echo "\nIMPORTANT: Delete this file (scripts/insert_admin.php) after verifying login.\n";
} else {
    echo "Error creating admin: " . $conn->error . "\n";
}
?>