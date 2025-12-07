<?php
$host = "localhost";
$user = "root";       // default XAMPP
$password = "";       // default XAMPP
$database = "cookiexpress.com";

$conn = mysqli_connect($host, $user, $password, $database);

if(!$conn){
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
