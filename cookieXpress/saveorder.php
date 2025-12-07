<?php
header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"), true);

$host = "localhost";
$db = "cookieXpress";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);
if($conn->connect_error){
    echo json_encode(["success"=>false,"error"=>"DB connection failed"]);
    exit;
}

// Simpan order
$stmt = $conn->prepare("INSERT INTO orders (user_id, order_code, cart_data, total, shipping_method) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("issds", $data['user_id'], $data['order_code'], $data['cart_data'], $data['total'], $data['shipping_method']);
if($stmt->execute()){
    echo json_encode(["success"=>true]);
} else {
    echo json_encode(["success"=>false,"error"=>$stmt->error]);
}
$stmt->close();
$conn->close();
?>
