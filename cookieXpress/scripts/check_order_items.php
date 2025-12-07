<?php
$mysqli = new mysqli('localhost','root','','cookiexpress.com');
if ($mysqli->connect_error) {
    echo "Connect error: " . $mysqli->connect_error . PHP_EOL;
    exit(1);
}
$res = $mysqli->query("SELECT id, order_id, product_id, quantity, price FROM order_items ORDER BY id DESC LIMIT 20");
if (!$res) {
    echo "Query error: " . $mysqli->error . PHP_EOL;
    exit(1);
}
while ($r = $res->fetch_assoc()) {
    echo sprintf("id=%d order=%d product=%d qty=%d price=%.2f\n", $r['id'], $r['order_id'], $r['product_id'], $r['quantity'], $r['price']);
}
$mysqli->close();
