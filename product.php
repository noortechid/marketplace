<?php
require "config/database.php";

$id = $_GET['id'];

$product = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT 
    products.*,
    stores.store_name
FROM products
JOIN stores ON products.store_id = stores.id
WHERE products.id = $id
"));

if (!$product) {
    die("Produk tidak ditemukan");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $product['name'] ?></title>
</head>

<body>

<img 
    src="uploads/products/<?= $product['image'] ?>" 
    width="300"
>

<h1><?= $product['name'] ?></h1>

<p>
    Rp <?= number_format($product['price']) ?>
</p>

<p>
    Toko: <?= $product['store_name'] ?>
</p>

<p>
    <?= $product['description'] ?>
</p>

<form method="POST" action="add_to_cart.php">

    <input 
        type="hidden"
        name="product_id"
        value="<?= $product['id'] ?>"
    >

    <button type="submit">
        Tambah ke Keranjang
    </button>

</form>

</body>
</html>