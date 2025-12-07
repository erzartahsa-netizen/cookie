<?php
$mysqli = new mysqli('localhost','root','','cookiexpress.com');
if ($mysqli->connect_error) { echo "Connect error: " . $mysqli->connect_error . PHP_EOL; exit(1); }
$id = 1;
$qty = 1;
$mysqli->begin_transaction();
$mysqli->query("SELECT stock FROM products WHERE id = $id FOR UPDATE");
$res = $mysqli->query("UPDATE products SET stock = stock - $qty WHERE id = $id AND stock >= $qty");
$aff = $mysqli->affected_rows;
$mysqli->commit();
$sel = $mysqli->query("SELECT stock FROM products WHERE id = $id");
$r = $sel->fetch_assoc();
echo "affected_rows=$aff\\n";
echo "new stock=" . $r['stock'] . "\\n";
$mysqli->close();
