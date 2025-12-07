<?php
header('Content-Type: application/json; charset=utf-8');
require_once 'config/config.php';

// Optional `ids` param: comma separated product ids to limit result
$ids = isset($_GET['ids']) ? $_GET['ids'] : null;

if($ids){
    // sanitize ids
    $parts = array_filter(array_map('intval', explode(',', $ids)));
    if(empty($parts)){
        echo json_encode(['error' => 'invalid ids']);
        exit;
    }
    $in = implode(',', $parts);
    $query = "SELECT id, stock FROM products WHERE id IN ($in)";
} else {
    $query = "SELECT id, stock FROM products";
}

$result = $conn->query($query);
$out = [];
if($result){
    while($row = $result->fetch_assoc()){
        $out[$row['id']] = intval($row['stock']);
    }
}

echo json_encode($out);
?>