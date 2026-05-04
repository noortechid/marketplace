<?php
require "../helpers/auth.php";
require "../config/database.php";

checkLogin();
requireRole(['seller']);
?>

<h1>Tambah Produk</h1>

<form method="POST" action="store_product.php" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Nama Produk" required><br><br>

    <textarea name="description" placeholder="Deskripsi"></textarea><br><br>

    <input type="number" name="price" placeholder="Harga" required><br><br>

    <input type="number" name="stock" placeholder="Stock" required><br><br>

    <input type="file" name="image" required><br><br>

    <button type="submit">Upload</button>
</form>
