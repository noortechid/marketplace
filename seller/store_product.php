<?php
require "../helpers/auth.php";
require "../config/database.php";

checkLogin();
requireRole(['seller']);

$user_id = $_SESSION['user_id'];

// ambil store
$storeQuery = mysqli_query($conn, "SELECT id FROM stores WHERE user_id = $user_id");
$store = mysqli_fetch_assoc($storeQuery);

if (!$store) {
    die("Store tidak ditemukan");
}

$store_id = $store['id'];

// ambil input
$name = trim($_POST['name']);
$description = trim($_POST['description']);
$price = (int)$_POST['price'];
$stock = (int)$_POST['stock'];

// validasi sederhana
if (!$name || !$price) {
    die("Data tidak lengkap");
}


// ================== UPLOAD GAMBAR ==================
$file = $_FILES['image'];

$filename = $file['name'];
$tmp = $file['tmp_name'];
$size = $file['size'];
$error = $file['error'];

// validasi error upload
if ($error !== 0) {
    die("Upload gagal");
}

// validasi tipe file
$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
$allowed = ['jpg', 'jpeg', 'png'];

if (!in_array($ext, $allowed)) {
    die("Format gambar tidak valid");
}

// validasi ukuran (max 2MB)
if ($size > 2 * 1024 * 1024) {
    die("Ukuran terlalu besar");
}

// rename file biar unik
$newName = uniqid() . '.' . $ext;
$uploadPath = "../uploads/products/" . $newName;

// pindahkan file
move_uploaded_file($tmp, $uploadPath);


// ================== INSERT PRODUCT ==================
$stmt = mysqli_prepare($conn, "
    INSERT INTO products (store_id, name, description, price, stock)
    VALUES (?, ?, ?, ?, ?)
");

mysqli_stmt_bind_param($stmt, "issii", $store_id, $name, $description, $price, $stock);

mysqli_stmt_execute($stmt);

$product_id = mysqli_insert_id($conn);

// simpan ke product_images
mysqli_query($conn, "
    INSERT INTO product_images (product_id, image_url)
    VALUES ($product_id, '$newName')
");

// redirect
header("Location: index.php");
exit;
