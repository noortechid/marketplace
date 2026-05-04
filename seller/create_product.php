<?php
require "../helpers/auth.php";
require "../config/database.php";

checkLogin();
requireRole(['seller']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk | Seller Center</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-[#f8fafc] min-h-screen text-slate-800">

<div class="flex">
    <?php include "../templates/seller/sidebar.php"; ?>

    <div class="flex-1 p-4 md:p-10">
        
        <div class="max-w-4xl mx-auto mb-6 flex items-center justify-between">
            <a href="products.php" class="flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition">
                <i class="fa-solid fa-chevron-left mr-2 text-xs"></i>
                Kembali ke Daftar Produk
            </a>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <h1 class="text-xl font-bold text-slate-900">Informasi Produk</h1>
                    <p class="text-sm text-slate-500">Lengkapi detail produk Anda agar pembeli lebih tertarik.</p>
                </div>

                <form method="POST" action="store_product.php" enctype="multipart/form-data" class="p-6 md:p-8 space-y-8">
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-1">
                            <h2 class="font-semibold text-slate-900">Foto Produk</h2>
                            <p class="text-xs text-slate-500 mt-1">Gunakan foto rasio 1:1 dengan pencahayaan yang baik.</p>
                        </div>
                        <div class="lg:col-span-2">
                            <label class="relative group flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer hover:bg-blue-50 hover:border-blue-400 transition-all">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-camera text-xl"></i>
                                    </div>
                                    <p class="text-sm text-slate-600 font-medium">Klik untuk unggah foto</p>
                                    <p class="text-xs text-slate-400 mt-1">PNG, JPG atau JPEG (Maks. 2MB)</p>
                                </div>
                                <input type="file" name="image" class="hidden" required id="imgInput" accept="image/*" />
                                <img id="preview" class="absolute inset-0 w-full h-full object-contain rounded-xl hidden bg-white">
                            </label>
                        </div>
                    </div>

                    <hr class="border-slate-100">

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-1">
                            <h2 class="font-semibold text-slate-900">Detail Produk</h2>
                        </div>
                        <div class="lg:col-span-2 space-y-5">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Produk</label>
                                <input type="text" name="name" required placeholder="Contoh: Meja Kayu Minimalis Jati"
                                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                                <textarea name="description" rows="5" placeholder="Tuliskan spesifikasi, keunggulan, dan kelengkapan produk..."
                                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"></textarea>
                            </div>
                        </div>
                    </div>

                    <hr class="border-slate-100">

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-1">
                            <h2 class="font-semibold text-slate-900">Harga & Inventaris</h2>
                        </div>
                        <div class="lg:col-span-2">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Harga Satuan</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500 text-sm">Rp</span>
                                        <input type="number" name="price" required placeholder="0"
                                            class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Jumlah Stok</label>
                                    <input type="number" name="stock" required placeholder="0"
                                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-4">
                        <button type="button" onclick="history.back()" class="px-6 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-lg transition">
                            Batalkan
                        </button>
                        <button type="submit" id="submitBtn" class="px-8 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-lg shadow-lg shadow-blue-200 hover:bg-blue-700 active:scale-95 transition-all">
                            Simpan Produk
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Preview Gambar Simple
    const imgInput = document.getElementById('imgInput');
    const preview = document.getElementById('preview');

    imgInput.onchange = evt => {
        const [file] = imgInput.files;
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        }
    }

    // Loading button
    document.querySelector("form").addEventListener("submit", function () {
        const btn = document.getElementById("submitBtn");
        btn.innerHTML = '<i class="fa-solid fa-circle-notch animate-spin mr-2"></i> Menyimpan...';
        btn.disabled = true;
        btn.classList.add("opacity-70", "cursor-not-allowed");
    });
</script>

</body>
</html>