<?php
require "../helpers/auth.php";
require "../config/database.php";

checkLogin();
requireRole(['seller']);

$user_id = $_SESSION['user_id'];

// Ambil data toko
$store_query = mysqli_query($conn, "SELECT id FROM stores WHERE user_id = $user_id");
$store = mysqli_fetch_assoc($store_query);

if (!$store) {
    header("Location: create_store.php");
    exit;
}

$store_id = $store['id'];

// Ambil produk + gambar
$products = mysqli_query($conn, "
    SELECT p.*, pi.image_url
    FROM products p
    LEFT JOIN product_images pi ON p.id = pi.product_id
    WHERE p.store_id = $store_id
    GROUP BY p.id
    ORDER BY p.id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Produk | Seller Center</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-700">

<div class="flex min-h-screen">
    <div class="hidden lg:block">
        <?php include "../templates/seller/sidebar.php"; ?>
    </div>

    <main class="flex-1 p-4 lg:p-8">
        
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-slate-900">Produk Anda</h1>
                    <p class="text-slate-500 mt-1">Kelola stok dan informasi produk toko secara real-time.</p>
                </div>
                <div class="mt-4 md:mt-0 flex gap-3">
                    <a href="create_product.php" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow-sm shadow-blue-200 transition-all flex items-center justify-center">
                        <i class="fa-solid fa-plus mr-2 text-sm"></i> Tambah Produk Baru
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total Produk</p>
                    <p class="text-xl font-bold text-slate-900"><?= mysqli_num_rows($products) ?></p>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm text-amber-600">
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Stok Menipis</p>
                    <p class="text-xl font-bold">--</p> </div>
            </div>

            <?php if (mysqli_num_rows($products) > 0): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
                    <?php while ($p = mysqli_fetch_assoc($products)) : ?>
                        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden hover:border-blue-300 transition-all duration-300 group shadow-sm hover:shadow-md">
                            
                            <div class="relative h-56 w-full bg-slate-100 overflow-hidden">
                                <img 
                                    src="../uploads/products/<?= $p['image_url'] ?: 'default.jpg' ?>" 
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                    alt="<?= $p['name'] ?>"
                                >
                                <div class="absolute top-3 left-3">
                                    <?php if($p['stock'] > 0): ?>
                                        <span class="bg-emerald-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-tight">Tersedia</span>
                                    <?php else: ?>
                                        <span class="bg-rose-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-tight">Habis</span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="p-5">
                                <h3 class="font-semibold text-slate-800 leading-snug h-12 overflow-hidden line-clamp-2">
                                    <?= $p['name'] ?>
                                </h3>
                                
                                <div class="mt-3 flex items-end justify-between">
                                    <div>
                                        <p class="text-[11px] text-slate-400 uppercase font-bold tracking-widest">Harga</p>
                                        <p class="text-lg font-extrabold text-blue-600">Rp <?= number_format($p['price'], 0, ',', '.') ?></p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[11px] text-slate-400 uppercase font-bold tracking-widest text-right">Stok</p>
                                        <p class="text-sm font-semibold text-slate-700"><?= $p['stock'] ?> unit</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-2 mt-5">
                                    <a href="edit_product.php?id=<?= $p['id'] ?>" class="flex items-center justify-center py-2 px-3 bg-slate-50 hover:bg-blue-50 text-slate-600 hover:text-blue-600 rounded-lg text-sm font-medium transition-colors border border-slate-100">
                                        <i class="fa-regular fa-pen-to-square mr-2"></i> Edit
                                    </a>
                                    <a href="delete_product.php?id=<?= $p['id'] ?>" 
                                       onclick="return confirm('Hapus produk ini?')"
                                       class="flex items-center justify-center py-2 px-3 bg-slate-50 hover:bg-rose-50 text-slate-400 hover:text-rose-600 rounded-lg text-sm transition-colors border border-slate-100">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-20 bg-white rounded-3xl border border-slate-100 shadow-sm">
                    <img src="https://illustrations.popsy.co/slate/shaking-hands.svg" class="w-48 mx-auto mb-6" alt="Empty">
                    <h3 class="text-xl font-bold text-slate-800">Mulai Isi Etalase Toko</h3>
                    <p class="text-slate-500 mt-2 mb-8">Anda belum memiliki produk yang terdaftar saat ini.</p>
                    <a href="create_product.php" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all">
                        Tambahkan Produk Pertama
                    </a>
                </div>
            <?php endif; ?>
        </div>

    </main>
</div>

</body>
</html>