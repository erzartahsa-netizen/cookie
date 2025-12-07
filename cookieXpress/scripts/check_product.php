<?php
$mysqli = new mysqli('localhost','root','','cookiexpress.com');
if ($mysqli->connect_error) { echo "Connect error: " . $mysqli->connect_error . PHP_EOL; exit(1); }
$res = $mysqli->query("SELECT id, name, stock FROM products WHERE id = 1");
if (!$res) { echo "Query error: " . $mysqli->error . PHP_EOL; exit(1); }
$r = $res->fetch_assoc();
if ($r) {
    echo sprintf("product id=%d name=%s stock=%d\n", $r['id'], $r['name'], $r['stock']);
} else {
    echo "No product with id=1\n";
}
$mysqli->close();
