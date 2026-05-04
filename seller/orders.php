<?php
require "../helpers/auth.php";
require "../config/database.php";

checkLogin();
requireRole(['seller']);

$user_id = $_SESSION['user_id'];

// ambil store
$store = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT id FROM stores WHERE user_id = $user_id
"));

$store_id = $store['id'];

// ambil order yang punya produk dari store ini
$orders = mysqli_query($conn, "
SELECT DISTINCT o.*
FROM orders o
JOIN order_items oi ON o.id = oi.order_id
JOIN products p ON oi.product_id = p.id
WHERE p.store_id = $store_id
ORDER BY o.created_at DESC
");
?>

<?php include "../templates/seller/head.php"; ?>

<body>

<div style="display:flex;">

<?php include "../templates/seller/sidebar.php"; ?>

<div style="flex:1; padding:20px;">

<h1>Order Masuk</h1>

<?php while ($o = mysqli_fetch_assoc($orders)) : ?>

    <div style="border:1px solid #ddd; padding:10px; margin-bottom:10px;">

        <b>Order #<?= $o['id'] ?></b><br>
        Total: Rp <?= number_format($o['total_price']) ?><br>
        Status: <?= $o['status'] ?><br>
        Tanggal: <?= $o['created_at'] ?><br>

        <a href="order_detail.php?id=<?= $o['id'] ?>">Detail</a>

    </div>

<?php endwhile; ?>

</div>
</div>

</body>
</html>