<?php
require "../helpers/auth.php";
require "../config/database.php";

checkLogin();
requireRole(['seller']);

$user_id = $_SESSION['user_id'];
$id = (int)$_GET['id'];

// ambil store seller
$store = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT id FROM stores WHERE user_id = $user_id
"));

if (!$store) {
    die("Store tidak ditemukan");
}

$store_id = $store['id'];

// cek kepemilikan produk
$product = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT * FROM products 
WHERE id = $id AND store_id = $store_id
"));

if (!$product) {
    die("Produk tidak ditemukan atau bukan milik kamu");
}

// hapus gambar dulu (biar file tidak nyangkut)
$image = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT image_url FROM product_images 
WHERE product_id = $id
"));

if ($image) {
    $filePath = "../uploads/products/" . $image['image_url'];
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

// hapus image record
mysqli_query($conn, "DELETE FROM product_images WHERE product_id = $id");

// hapus produk
mysqli_query($conn, "DELETE FROM products WHERE id = $id AND store_id = $store_id");

// redirect balik
header("Location: products.php");
exit;