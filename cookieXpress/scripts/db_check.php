<?php
$c = new mysqli('localhost', 'root', '', 'cookiexpress.com');
if($c->connect_error){ echo "connect error: " . $c->connect_error . "\n"; exit; }
$r = $c->query('SELECT id, stock FROM products');
while($row = $r->fetch_assoc()){
    echo "product {$row['id']} stock={$row['stock']}\n";
}
$or = $c->query('SELECT id, order_code, total_price, status, created_at FROM orders ORDER BY id DESC LIMIT 5');
while($o = $or->fetch_assoc()){
    echo "order {$o['id']} code={$o['order_code']} total={$o['total_price']} status={$o['status']} created_at={$o['created_at']}\n";
}
?>