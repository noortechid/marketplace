<?php
require "../helpers/auth.php";
require "../config/database.php";

checkLogin();

$user_id = $_SESSION['user_id'];

$carts = mysqli_query($conn, "
SELECT carts.*, products.price
FROM carts
JOIN products ON carts.product_id = products.id
WHERE carts.user_id = $user_id
");

$total = 0;

while ($c = mysqli_fetch_assoc($carts)) {
    $total += $c['price'] * $c['quantity'];
}

mysqli_query($conn, "
INSERT INTO orders (user_id, total_price)
VALUES ($user_id, $total)
");

$order_id = mysqli_insert_id($conn);

// ambil cart lagi
$carts = mysqli_query($conn, "
SELECT carts.*, products.price
FROM carts
JOIN products ON carts.product_id = products.id
WHERE carts.user_id = $user_id
");

while ($c = mysqli_fetch_assoc($carts)) {

    mysqli_query($conn, "
    INSERT INTO order_items (
        order_id,
        product_id,
        quantity,
        price
    ) VALUES (
        $order_id,
        {$c['product_id']},
        {$c['quantity']},
        {$c['price']}
    )
    ");
}

// hapus cart
mysqli_query($conn, "
DELETE FROM carts WHERE user_id = $user_id
");

echo "Checkout berhasil";