<?php
require "../helpers/auth.php";
require "../config/database.php";

checkLogin();
requireRole(['seller']);

$user_id = $_SESSION['user_id'];

$id = (int)$_POST['id'];
$name = trim($_POST['name']);
$description = trim($_POST['description']);
$price = (int)$_POST['price'];
$stock = (int)$_POST['stock'];

// ambil store seller
$store = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT id FROM stores WHERE user_id = $user_id
"));

if (!$store) {
    die("Store tidak ditemukan");
}

$store_id = $store['id'];

// validasi kepemilikan produk
$check = mysqli_query($conn, "
SELECT id FROM products 
WHERE id = $id AND store_id = $store_id
");

if (!mysqli_fetch_assoc($check)) {
    die("Akses ditolak");
}

// update data
$stmt = mysqli_prepare($conn, "
UPDATE products 
SET name=?, description=?, price=?, stock=? 
WHERE id=? AND store_id=?
");

mysqli_stmt_bind_param($stmt, "ssiiii", $name, $description, $price, $stock, $id, $store_id);

mysqli_stmt_execute($stmt);

// redirect
header("Location: products.php");
exit;