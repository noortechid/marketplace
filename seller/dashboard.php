<?php
require "../config/database.php";

checkLogin();
requireRole(['seller']);

$user_id = $_SESSION['user_id'];

// ambil store
$store = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT id, store_name FROM stores WHERE user_id = $user_id
"));

if (!$store) {
    header("Location: create_store.php");
    exit;
}

$store_id = $store['id'];

// KPI sederhana
$total_products = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) as total FROM products WHERE store_id = $store_id
"))['total'];

$total_orders = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(DISTINCT oi.order_id) as total
FROM order_items oi
JOIN products p ON oi.product_id = p.id
WHERE p.store_id = $store_id
"))['total'];

$total_income = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT SUM(oi.price * oi.quantity) as total
FROM order_items oi
JOIN products p ON oi.product_id = p.id
WHERE p.store_id = $store_id
"))['total'] ?? 0;

// order terbaru
$orders = mysqli_query($conn, "
SELECT 
    o.id,
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
LIMIT 10
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard - <?= $store['store_name'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>

<body class="bg-slate-50 text-slate-900">

<div class="flex min-h-screen">
    <?php include "../templates/seller/sidebar.php"; ?>

    <main class="flex-1 p-6 lg:p-10">
        
        <header class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Dashboard Seller</h1>
                <p class="text-slate-500">Selamat datang kembali, <span class="font-semibold text-blue-600"><?= $store['store_name'] ?></span></p>
            </div>
            <div class="flex items-center gap-3">
                <a href="create_product.php" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm transition-all shadow-lg shadow-blue-200">
                    <i class="fa-solid fa-plus mr-2"></i> Tambah Produk
                </a>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-5">
                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-xl">
                    <i class="fa-solid fa-wallet"></i>
                </div>
                <div>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Total Pendapatan</p>
                    <h3 class="text-xl font-extrabold tracking-tight">Rp <?= number_format($total_income, 0, ',', '.') ?></h3>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-5">
                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <div>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Total Pesanan</p>
                    <h3 class="text-xl font-extrabold tracking-tight"><?= $total_orders ?></h3>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-5">
                <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-xl">
                    <i class="fa-solid fa-box"></i>
                </div>
                <div>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Jumlah Produk</p>
                    <h3 class="text-xl font-extrabold tracking-tight"><?= $total_products ?></h3>
                </div>
            </div>
        </div>

        <div class="mb-10">
            <h2 class="text-lg font-bold mb-5 flex items-center gap-2">
                <i class="fa-solid fa-bolt text-amber-500"></i> Aksi Cepat
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="products.php" class="bg-white p-4 rounded-2xl border border-slate-100 hover:border-blue-300 hover:bg-blue-50 transition-all text-center group">
                    <i class="fa-solid fa-boxes-stacked text-slate-400 group-hover:text-blue-600 mb-2 block text-lg"></i>
                    <span class="text-sm font-bold text-slate-700">Produk</span>
                </a>
                <a href="orders.php" class="bg-white p-4 rounded-2xl border border-slate-100 hover:border-blue-300 hover:bg-blue-50 transition-all text-center group">
                    <i class="fa-solid fa-list-check text-slate-400 group-hover:text-blue-600 mb-2 block text-lg"></i>
                    <span class="text-sm font-bold text-slate-700">Orders</span>
                </a>
                <a href="store.php" class="bg-white p-4 rounded-2xl border border-slate-100 hover:border-blue-300 hover:bg-blue-50 transition-all text-center group">
                    <i class="fa-solid fa-store text-slate-400 group-hover:text-blue-600 mb-2 block text-lg"></i>
                    <span class="text-sm font-bold text-slate-700">Info Toko</span>
                </a>
                <a href="../index.php" target="_blank" class="bg-white p-4 rounded-2xl border border-slate-100 hover:border-blue-300 hover:bg-blue-50 transition-all text-center group">
                    <i class="fa-solid fa-eye text-slate-400 group-hover:text-blue-600 mb-2 block text-lg"></i>
                    <span class="text-sm font-bold text-slate-700">Lihat Toko</span>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                <h2 class="text-lg font-bold italic">Order Terbaru</h2>
                <a href="orders.php" class="text-blue-600 text-sm font-bold hover:underline">Lihat Semua</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50/50 text-slate-400 text-[10px] uppercase font-bold tracking-widest">
                        <tr>
                            <th class="px-6 py-4 font-bold tracking-widest italic">ID Order</th>
                            <th class="px-6 py-4 font-bold tracking-widest italic">Pembeli</th>
                            <th class="px-6 py-4 font-bold tracking-widest italic">Produk</th>
                            <th class="px-6 py-4 font-bold tracking-widest italic">Total</th>
                            <th class="px-6 py-4 font-bold tracking-widest italic">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php if (mysqli_num_rows($orders) > 0): ?>
                            <?php while ($o = mysqli_fetch_assoc($orders)): ?>
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-slate-700">#<?= $o['id'] ?></td>
                                    <td class="px-6 py-4 text-slate-600"><?= $o['buyer_name'] ?></td>
                                    <td class="px-6 py-4">
                                        <p class="text-slate-800 font-semibold text-sm"><?= $o['product_name'] ?></p>
                                        <p class="text-slate-400 text-xs font-bold italic"><?= $o['quantity'] ?> item</p>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-blue-600">
                                        Rp <?= number_format($o['price'] * $o['quantity'], 0, ',', '.') ?>
                                    </td>
                                    <td class="px-6 py-4 text-slate-400 text-sm">
                                        <?= date('d M Y, H:i', strtotime($o['created_at'])) ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-slate-400 italic">
                                    Belum ada pesanan masuk.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>

</body>
</html>