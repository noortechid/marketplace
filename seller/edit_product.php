<?php
require "../helpers/auth.php";
require "../config/database.php";

checkLogin();
requireRole(['seller']);

$user_id = $_SESSION['user_id'];
$id = (int)$_GET['id'];

// ambil store seller
$store = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT id FROM stores WHERE user_id = $user_id
"));

if (!$store) {
    die("Store tidak ditemukan");
}

$store_id = $store['id'];

// ambil produk + validasi kepemilikan
$product = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT * FROM products 
    WHERE id = $id AND store_id = $store_id
"));

if (!$product) {
    die("Produk tidak ditemukan atau bukan milik kamu");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk | <?= $product['name'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-[#f8fafc] min-h-screen">

<div class="flex">
    <?php include "../templates/seller/sidebar.php"; ?>

    <div class="flex-1 p-4 md:p-10">
        
        <div class="max-w-4xl mx-auto mb-6 flex items-center justify-between">
            <a href="products.php" class="flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition">
                <i class="fa-solid fa-arrow-left mr-2"></i>
                Kembali ke Daftar
            </a>
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 bg-slate-100 px-3 py-1 rounded-full">
                ID Produk: #<?= $product['id'] ?>
            </span>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <h1 class="text-xl font-bold text-slate-900">Edit Detail Produk</h1>
                    <p class="text-sm text-slate-500">Perbarui informasi stok atau harga produk Anda.</p>
                </div>

                <form method="POST" action="update_product.php" class="p-6 md:p-8 space-y-8">
                    <input type="hidden" name="id" value="<?= $product['id'] ?>">

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-1">
                            <h2 class="font-semibold text-slate-900 text-base">Informasi Utama</h2>
                            <p class="text-xs text-slate-500 mt-1">Gunakan nama yang jelas agar mudah dicari oleh pembeli.</p>
                        </div>
                        <div class="lg:col-span-2 space-y-5">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Produk</label>
                                <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition bg-white">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                                <textarea name="description" rows="6" 
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"><?= htmlspecialchars($product['description']) ?></textarea>
                            </div>
                        </div>
                    </div>

                    <hr class="border-slate-100">

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-1">
                            <h2 class="font-semibold text-slate-900 text-base">Harga & Stok</h2>
                            <p class="text-xs text-slate-500 mt-1">Atur ketersediaan barang di gudang Anda.</p>
                        </div>
                        <div class="lg:col-span-2">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Harga (Rp)</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <span class="text-slate-400 text-sm font-semibold">Rp</span>
                                        </div>
                                        <input type="number" name="price" value="<?= $product['price'] ?>" required
                                            class="w-full pl-12 pr-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Stok Saat Ini</label>
                                    <div class="relative">
                                        <input type="number" name="stock" value="<?= $product['stock'] ?>" required
                                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                            <span class="text-slate-400 text-xs uppercase font-bold">Unit</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-8 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between gap-4">
                        <button type="button" 
                                onclick="if(confirm('Batalkan perubahan?')) window.location.href='products.php';" 
                                class="w-full md:w-auto px-6 py-2.5 text-sm font-bold text-slate-500 hover:bg-slate-100 rounded-xl transition text-center">
                            Batalkan
                        </button>
                        
                        <button type="submit" id="updateBtn"
                            class="w-full md:w-auto px-10 py-3 bg-blue-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-200 hover:bg-blue-700 active:scale-95 transition-all">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Loading state
    document.querySelector("form").addEventListener("submit", function () {
        const btn = document.getElementById("updateBtn");
        btn.innerHTML = '<i class="fa-solid fa-spinner animate-spin mr-2"></i> Mengupdate...';
        btn.disabled = true;
        btn.classList.add("opacity-70", "cursor-not-allowed");
    });
</script>

</body>
</html>