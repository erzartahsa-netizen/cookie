<?php
// Ensure `role` column exists in users table; adds it if missing.
require_once __DIR__ . '/../config/config.php';

// Check columns
$cols = [];
$res = $conn->query("DESCRIBE users");
if ($res) {
    while ($r = $res->fetch_assoc()) {
        $cols[] = $r['Field'];
    }
}

if (!in_array('role', $cols)) {
    echo "Adding 'role' column to users table...\n";
    $alter = $conn->query("ALTER TABLE users ADD COLUMN role VARCHAR(20) DEFAULT 'customer'");
    if ($alter) {
        echo "Column 'role' added successfully.\n";
    } else {
        echo "Failed to add column: " . $conn->error . "\n";
        exit(1);
    }
} else {
    echo "'role' column already exists.\n";
}

?>