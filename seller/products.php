<?php
require "../config/database.php";

checkLogin();
requireRole(['seller']);

$user_id = $_SESSION['user_id'];

// ambil store
$store = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM stores WHERE user_id = $user_id"));
$store_id = $store['id'];

// ambil produk
$products = mysqli_query($conn, "SELECT * FROM products WHERE store_id = $store_id");
?>

<!DOCTYPE html>
<html>
<?php include "../templates/seller/head.php"?>
<body>

<?php include "../templates/seller/sidebar.php"; ?>

<div style="margin-left:270px; padding:20px;">
    <h1>Daftar Produk</h1>

    <?php while ($p = mysqli_fetch_assoc($products)) : ?>
        <div style="margin-bottom:10px;">
            <?= $p['name'] ?> - Rp <?= $p['price'] ?>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>
