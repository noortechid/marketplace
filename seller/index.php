<?php
require "../helpers/auth.php";
require "seller_model.php";

checkLogin();
requireRole(['seller']);

$user_id = $_SESSION['user_id'];

$store = getStore($user_id);

if (!$store) {
    header("Location: create_store.php");
    exit;
}

$store_id = $store['id'];

$productQuery = getProducts($store_id);
$total_income = getIncome($store_id);
$total_orders = getTotalOrders($store_id);
$ordersDetail = getOrderDetails($store_id);

// kirim ke view
require "dashboard.php";
