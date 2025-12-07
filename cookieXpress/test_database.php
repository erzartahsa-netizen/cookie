<?php
require_once 'config/config.php';

echo "<h2>Database Connection Test</h2>";

// Test connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "✓ Connected to database<br>";

// Check which database we're using
$result = $conn->query("SELECT DATABASE()");
$row = $result->fetch_row();
echo "✓ Current Database: " . $row[0] . "<br><br>";

// List all tables
echo "<h3>Tables in this database:</h3>";
$tables_result = $conn->query("SHOW TABLES");
if ($tables_result->num_rows > 0) {
    while($table = $tables_result->fetch_row()) {
        echo "• " . $table[0] . "<br>";
    }
} else {
    echo "<strong style='color:red'>❌ NO TABLES FOUND!</strong><br>";
    echo "You need to import web.sql to create the tables.";
}

echo "<br><br><h3>Users table info:</h3>";
$check_users = $conn->query("DESCRIBE users");
if($check_users) {
    echo "✓ Users table exists<br>";
    while($row = $check_users->fetch_assoc()) {
        echo "• " . $row['Field'] . " (" . $row['Type'] . ")<br>";
    }
} else {
    echo "<strong style='color:red'>❌ Users table NOT found!</strong><br>";
    echo "Error: " . $conn->error;
}
?>
