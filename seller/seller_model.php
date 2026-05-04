<?php
require "../config/database.php";

function getStore($user_id) {
    global $conn;
    $q = mysqli_query($conn, "SELECT * FROM stores WHERE user_id = $user_id");
    return mysqli_fetch_assoc($q);
}

function getProducts($store_id) {
    global $conn;
    return mysqli_query($conn, "SELECT * FROM products WHERE store_id = $store_id");
}

function getIncome($store_id) {
    global $conn;
    $q = mysqli_query($conn, "
        SELECT SUM(oi.price * oi.quantity) as total_income
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        WHERE p.store_id = $store_id
    ");
    return mysqli_fetch_assoc($q)['total_income'] ?? 0;
}

function getTotalOrders($store_id) {
    global $conn;
    $q = mysqli_query($conn, "
        SELECT COUNT(DISTINCT oi.order_id) as total_orders
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        WHERE p.store_id = $store_id
    ");
    return mysqli_fetch_assoc($q)['total_orders'] ?? 0;
}

function getOrderDetails($store_id) {
    global $conn;
    return mysqli_query($conn, "
        SELECT 
            o.id as order_id,
            o.created_at,
            u.name as buyer_name,
            p.name as product_name,
            oi.quantity,
            oi.price
        FROM order_items oi
        JOIN orders o ON oi.order_id = o.id
        JOIN users u ON o.user_id = u.id
        JOIN products p ON oi.product_id = p.id
        WHERE p.store_id = $store_id
        ORDER BY o.created_at DESC
    ");
}
