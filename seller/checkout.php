<?php
require "config/database.php";
require "helpers/auth.php";

checkLogin();

$user_id = $_SESSION['user_id'];

// contoh: kirim dari 1 produk dulu
$product_id = (int)$_POST['product_id'];
$qty = (int)$_POST['qty'];

// ambil produk
$product = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT * FROM products WHERE id = $product_id
"));

if (!$product) {
    die("Produk tidak ditemukan");
}

$total = $product['price'] * $qty;

// 1. buat order
mysqli_query($conn, "
INSERT INTO orders (user_id, total_price, status)
VALUES ($user_id, $total, 'pending')
");

$order_id = mysqli_insert_id($conn);

// 2. insert item
mysqli_query($conn, "
INSERT INTO order_items (order_id, product_id, quantity, price)
VALUES ($order_id, $product_id, $qty, {$product['price']})
");

echo "Order berhasil dibuat";