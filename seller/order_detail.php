<?php
require "../helpers/auth.php";
require "../config/database.php";

checkLogin();
requireRole(['seller']);

$order_id = (int)$_GET['id'];

$items = mysqli_query($conn, "
SELECT oi.*, p.name
FROM order_items oi
JOIN products p ON oi.product_id = p.id
WHERE oi.order_id = $order_id
");
?>

<h1>Detail Order</h1>

<?php while ($i = mysqli_fetch_assoc($items)) : ?>

<div>
    Produk: <?= $i['name'] ?><br>
    Qty: <?= $i['quantity'] ?><br>
    Harga: Rp <?= $i['price'] ?>
</div>

<hr>

<?php endwhile; ?>