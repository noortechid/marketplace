    <aside class="w-72 bg-white h-screen sticky top-0 border-r border-slate-200 flex flex-col px-4 py-6 overflow-y-auto">
        
        <div class="flex items-center justify-between mb-8 px-2">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm">D</div>
		<span class="font-semibold text-lg text-slate-800"><?= $store['store_name'] ?></span>
            </div>
            <button class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-indent rotate-180"></i>
            </button>
        </div>

        <div class="relative mb-6">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text" placeholder="Search" class="w-full bg-slate-50 border border-slate-100 rounded-lg py-2 pl-10 pr-4 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 transition-all">
            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 border border-slate-200 px-1.5 rounded-md">⌘ F</span>
        </div>

        <div class="mb-4">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-4 px-2">Main Menu</p>
            
            <nav class="space-y-1">
		<a href="index.php" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-lg transition-colors group">
                    <i class="fa-solid fa-chart-pie text-lg group-hover:text-blue-600"></i>
                    <span>Dashboard</span>
                </a>

                <div class="menu-dropdown">
                    <button class="w-full flex items-center justify-between px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-lg transition-colors group">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-box text-lg group-hover:text-blue-600"></i>
                            <span>Kelola Produk</span>
                        </div>
                        <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
                    </button>
                    <div class="hidden ml-11 mt-1 space-y-1 relative border-l border-slate-100">
                        <a href="products.php" class="block px-3 py-2 text-sm text-slate-500 hover:text-blue-600 transition-colors">Daftar Produk</a>
                        <a href="#" class="block px-3 py-2 text-sm text-slate-500 hover:text-blue-600 transition-colors">Tambah Produk</a>
                        <a href="#" class="block px-3 py-2 text-sm text-slate-500 hover:text-blue-600 transition-colors">Kategori Produk</a>
                        <a href="#" class="block px-3 py-2 text-sm text-slate-500 hover:text-blue-600 transition-colors">Stok & Inventori</a>
                    </div>
                </div>

                <div class="menu-dropdown">
                    <button class="w-full flex items-center justify-between px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-lg transition-colors group">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-cart-shopping text-lg group-hover:text-blue-600"></i>
                            <span>Pesanan</span>
                        </div>
                        <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
                    </button>
                    <div class="hidden ml-11 mt-1 space-y-1 border-l border-slate-100">
                        <a href="#" class="block px-3 py-2 text-sm text-slate-500 hover:text-blue-600 transition-colors">Semua Pesanan</a>
                        <a href="#" class="block px-3 py-2 text-sm text-slate-500 hover:text-blue-600 transition-colors">Menunggu Pembayaran</a>
                        <a href="#" class="block px-3 py-2 text-sm text-slate-500 hover:text-blue-600 transition-colors">Diproses</a>
                        <a href="#" class="block px-3 py-2 text-sm text-slate-500 hover:text-blue-600 transition-colors">Dikirim</a>
			<a href="#" class="block px-3 py-2 text-sm text-slate-500 hover:text-blue-600 transition-colors">Selesai</a>
           	        <a href="#" class="block px-3 py-2 text-sm text-slate-500 hover:text-blue-600 transition-colors">Dibatalkan</a>
                    </div>
                </div>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-lg transition-colors group">
                    <i class="fa-solid fa-truck-fast text-lg group-hover:text-blue-600"></i>
                    <span>Pengiriman</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-lg transition-colors group">
                    <i class="fa-solid fa-wallet text-lg group-hover:text-blue-600"></i>
                    <span>Keuangan</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-lg transition-colors group">
                    <i class="fa-solid fa-store text-lg group-hover:text-blue-600"></i>
                    <span>Toko</span>
                </a>
            </nav>
        </div>

        <div class="mt-auto pt-6">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-4 px-2">Settings</p>
            <nav class="space-y-1">
                <a href="#" class="flex items-center justify-between px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-lg transition-colors group">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-bell text-lg group-hover:text-blue-600"></i>
                        <span>Notifikasi</span>
                    </div>
                    <span class="bg-blue-600 text-white text-[10px] px-1.5 py-0.5 rounded-full">3</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-lg transition-colors group">
                    <i class="fa-solid fa-user-gear text-lg group-hover:text-blue-600"></i>
                    <span>Pengaturan Akun</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-red-500 hover:bg-red-50 rounded-lg transition-colors mt-4">
                    <i class="fa-solid fa-arrow-right-from-bracket text-lg"></i>
                    <span>Logout</span>
                </a>
            </nav>
        </div>
    </aside>
    <script>
        document.querySelectorAll('.menu-dropdown button').forEach(button => {
            button.addEventListener('click', () => {
                const submenu = button.nextElementSibling;
                const icon = button.querySelector('.fa-chevron-down');
                
                // Toggle Submenu Visibility
                submenu.classList.toggle('hidden');
                
                // Rotate Icon
                icon.classList.toggle('rotate-180');

                // Active style on click
                button.classList.toggle('text-blue-600');
                button.classList.toggle('bg-blue-50/50');
            });
        });
    </script>
