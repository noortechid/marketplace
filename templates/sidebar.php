<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sidebar deFransz Style</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');

        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }

        /* ── Sidebar collapse transition ── */
        #sidebar {
            width: 18rem;
            transition: width 0.3s cubic-bezier(.4,0,.2,1),
                        padding 0.3s cubic-bezier(.4,0,.2,1);
            overflow: hidden;
        }
        #sidebar.collapsed { width: 4.5rem; }

        /* Hide text / badges when collapsed */
        #sidebar.collapsed .sidebar-label,
        #sidebar.collapsed .sidebar-badge,
        #sidebar.collapsed .sidebar-chevron,
        #sidebar.collapsed .search-box,
        #sidebar.collapsed .section-title { display: none; }

        /* Centre icons when collapsed */
        #sidebar.collapsed .nav-item {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }
        #sidebar.collapsed .nav-item .icon-wrap { margin: 0; }

        /* Tooltip on collapsed icons */
        #sidebar.collapsed .nav-item { position: relative; }
        #sidebar.collapsed .nav-item:hover::after {
            content: attr(data-label);
            position: absolute;
            left: calc(100% + 12px);
            top: 50%;
            transform: translateY(-50%);
            background: #1e293b;
            color: #fff;
            font-size: 12px;
            font-weight: 500;
            padding: 5px 10px;
            border-radius: 6px;
            white-space: nowrap;
            pointer-events: none;
            z-index: 50;
            box-shadow: 0 4px 12px rgba(0,0,0,.15);
            animation: tooltipFade .15s ease;
        }
        @keyframes tooltipFade {
            from { opacity:0; transform:translateY(-50%) translateX(-4px); }
            to   { opacity:1; transform:translateY(-50%) translateX(0); }
        }

        /* ── Submenu slide animation ── */
        .submenu {
            display: grid;
            grid-template-rows: 0fr;
            transition: grid-template-rows 0.28s cubic-bezier(.4,0,.2,1);
        }
        .submenu.open { grid-template-rows: 1fr; }
        .submenu > div { overflow: hidden; }

        /* Hide submenus when sidebar is collapsed */
        #sidebar.collapsed .submenu { display: none !important; }

        /* ── Active nav item ── */
        .nav-item.active {
            background-color: #eff6ff;
            color: #2563eb;
        }
        .nav-item.active .nav-icon { color: #2563eb; }

        /* ── Search input focus ring ── */
        .search-input:focus { box-shadow: 0 0 0 3px rgba(59,130,246,.15); }

        /* ── Mobile overlay ── */
        #overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,.35);
            z-index: 40;
            animation: fadeIn .2s ease;
        }
        @keyframes fadeIn { from {opacity:0} to {opacity:1} }

        /* ── Mobile sidebar ── */
        @media (max-width: 767px) {
            #sidebar {
                position: fixed;
                top: 0; left: 0; bottom: 0;
                z-index: 50;
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(.4,0,.2,1),
                            width 0.3s cubic-bezier(.4,0,.2,1);
                width: 18rem !important;
            }
            #sidebar.mobile-open { transform: translateX(0); }
            #mobile-toggle { display: flex; }
            #overlay.show { display: block; }

            /* Always show labels on mobile */
            #sidebar.collapsed .sidebar-label,
            #sidebar.collapsed .sidebar-badge,
            #sidebar.collapsed .sidebar-chevron,
            #sidebar.collapsed .search-box,
            #sidebar.collapsed .section-title { display: unset; }
            #sidebar.collapsed .nav-item { justify-content: flex-start; padding-left: 0.75rem; padding-right: 0.75rem; }
            #sidebar.collapsed .submenu { display: grid !important; }
        }

        #mobile-toggle { display: none; align-items: center; justify-content: center; }

        /* ── Chevron rotation ── */
        .chevron { transition: transform 0.25s ease; }
        .chevron.rotated { transform: rotate(180deg); }

        /* ── Icon color transition ── */
        .nav-icon { transition: color 0.15s ease; }

        /* ── Ripple on nav click ── */
        .nav-item { position: relative; overflow: hidden; }
        .ripple {
            position: absolute;
            border-radius: 50%;
            transform: scale(0);
            animation: rippleAnim 0.45s linear;
            background: rgba(59,130,246,.18);
            pointer-events: none;
        }
        @keyframes rippleAnim { to { transform: scale(4); opacity: 0; } }

        /* ── Sub-link hover nudge ── */
        .sub-link { transition: color 0.15s ease, padding-left 0.15s ease; }
        .sub-link:hover { padding-left: 1.25rem; color: #2563eb; }
        .sub-link.active-sub { color: #2563eb; font-weight: 500; }

        /* ── No-results message ── */
        #no-results { display: none; }
    </style>
</head>
<body class="flex min-h-screen">

    <!-- Mobile overlay -->
    <div id="overlay"></div>

    <!-- Mobile top bar -->
    <div class="md:hidden fixed top-0 left-0 right-0 z-30 bg-white border-b border-slate-200 flex items-center px-4 h-14">
        <button id="mobile-toggle" class="w-9 h-9 flex items-center justify-center rounded-lg hover:bg-slate-100 text-slate-600 transition-colors mr-3">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-xs">D</div>
            <span class="font-semibold text-slate-800">deFransz</span>
        </div>
    </div>

    <!-- ═══════════ SIDEBAR ═══════════ -->
    <aside id="sidebar" class="bg-white h-screen sticky top-0 border-r border-slate-200 flex flex-col px-4 py-6 overflow-y-auto flex-shrink-0">

        <!-- Logo & collapse toggle -->
        <div class="flex items-center justify-between mb-8 px-2">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">D</div>
                <span class="sidebar-label font-semibold text-lg text-slate-800 whitespace-nowrap">deFransz</span>
            </div>
            <button id="collapse-btn" class="sidebar-label text-slate-400 hover:text-slate-600 transition-colors flex-shrink-0 ml-2" title="Toggle sidebar">
                <i id="collapse-icon" class="fa-solid fa-indent rotate-180 transition-transform duration-300"></i>
            </button>
        </div>

        <!-- Search -->
        <div class="search-box relative mb-6">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
            <input
                id="search-input"
                type="text"
                placeholder="Search"
                class="search-input w-full bg-slate-50 border border-slate-100 rounded-lg py-2 pl-10 pr-10 text-sm focus:outline-none transition-all"
                autocomplete="off"
            >
            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 border border-slate-200 px-1.5 rounded-md select-none">⌘ F</span>
        </div>

        <!-- Main Menu -->
        <div class="mb-4 flex-1" id="main-nav">
            <p class="section-title text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-4 px-2">Main Menu</p>

            <nav id="nav-list" class="space-y-1">

                <!-- Dashboard -->
                <a href="#" data-label="Dashboard"
                   class="nav-item active flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-lg transition-colors group cursor-pointer">
                    <span class="icon-wrap flex-shrink-0">
                        <i class="nav-icon fa-solid fa-chart-pie text-lg text-blue-600"></i>
                    </span>
                    <span class="sidebar-label">Dashboard</span>
                </a>

                <!-- Kelola Produk -->
                <div class="nav-group">
                    <button data-label="Kelola Produk"
                        class="nav-item dropdown-trigger w-full flex items-center justify-between px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-lg transition-colors group">
                        <div class="flex items-center gap-3">
                            <span class="icon-wrap flex-shrink-0">
                                <i class="nav-icon fa-solid fa-box text-lg"></i>
                            </span>
                            <span class="sidebar-label">Kelola Produk</span>
                        </div>
                        <i class="sidebar-chevron chevron fa-solid fa-chevron-down text-[10px]"></i>
                    </button>
                    <div class="submenu">
                        <div>
                            <div class="ml-11 mt-1 space-y-1 border-l border-slate-100 pb-1">
                                <a href="#" class="sub-link block px-3 py-2 text-sm text-slate-500">Daftar Produk</a>
                                <a href="#" class="sub-link block px-3 py-2 text-sm text-slate-500">Tambah Produk</a>
                                <a href="#" class="sub-link block px-3 py-2 text-sm text-slate-500">Kategori Produk</a>
                                <a href="#" class="sub-link block px-3 py-2 text-sm text-slate-500">Stok & Inventori</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pesanan -->
                <div class="nav-group">
                    <button data-label="Pesanan"
                        class="nav-item dropdown-trigger w-full flex items-center justify-between px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-lg transition-colors group">
                        <div class="flex items-center gap-3">
                            <span class="icon-wrap flex-shrink-0">
                                <i class="nav-icon fa-solid fa-cart-shopping text-lg"></i>
                            </span>
                            <span class="sidebar-label">Pesanan</span>
                        </div>
                        <i class="sidebar-chevron chevron fa-solid fa-chevron-down text-[10px]"></i>
                    </button>
                    <div class="submenu">
                        <div>
                            <div class="ml-11 mt-1 space-y-1 border-l border-slate-100 pb-1">
                                <a href="#" class="sub-link block px-3 py-2 text-sm text-slate-500">Semua Pesanan</a>
                                <a href="#" class="sub-link block px-3 py-2 text-sm text-slate-500">Menunggu Pembayaran</a>
                                <a href="#" class="sub-link block px-3 py-2 text-sm text-slate-500">Diproses</a>
                                <a href="#" class="sub-link block px-3 py-2 text-sm text-slate-500">Dikirim</a>
                                <a href="#" class="sub-link block px-3 py-2 text-sm text-slate-500">Selesai</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pengiriman -->
                <a href="#" data-label="Pengiriman"
                   class="nav-item flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-lg transition-colors group cursor-pointer">
                    <span class="icon-wrap flex-shrink-0">
                        <i class="nav-icon fa-solid fa-truck-fast text-lg"></i>
                    </span>
                    <span class="sidebar-label">Pengiriman</span>
                </a>

                <!-- Keuangan -->
                <a href="#" data-label="Keuangan"
                   class="nav-item flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-lg transition-colors group cursor-pointer">
                    <span class="icon-wrap flex-shrink-0">
                        <i class="nav-icon fa-solid fa-wallet text-lg"></i>
                    </span>
                    <span class="sidebar-label">Keuangan</span>
                </a>

                <!-- Toko -->
                <a href="#" data-label="Toko"
                   class="nav-item flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-lg transition-colors group cursor-pointer">
                    <span class="icon-wrap flex-shrink-0">
                        <i class="nav-icon fa-solid fa-store text-lg"></i>
                    </span>
                    <span class="sidebar-label">Toko</span>
                </a>

            </nav>

            <!-- No results -->
            <p id="no-results" class="text-xs text-slate-400 px-3 py-2 mt-2">No results found.</p>
        </div>

        <!-- Settings -->
        <div class="pt-6">
            <p class="section-title text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-4 px-2">Settings</p>
            <nav class="space-y-1">

                <a href="#" data-label="Notifikasi"
                   class="nav-item flex items-center justify-between px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-lg transition-colors group cursor-pointer">
                    <div class="flex items-center gap-3">
                        <span class="icon-wrap flex-shrink-0">
                            <i class="nav-icon fa-solid fa-bell text-lg"></i>
                        </span>
                        <span class="sidebar-label">Notifikasi</span>
                    </div>
                    <span class="sidebar-badge bg-blue-600 text-white text-[10px] px-1.5 py-0.5 rounded-full">3</span>
                </a>

                <a href="#" data-label="Pengaturan Akun"
                   class="nav-item flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-lg transition-colors group cursor-pointer">
                    <span class="icon-wrap flex-shrink-0">
                        <i class="nav-icon fa-solid fa-user-gear text-lg"></i>
                    </span>
                    <span class="sidebar-label">Pengaturan Akun</span>
                </a>

                <a href="#" data-label="Logout"
                   class="nav-item flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-red-500 hover:bg-red-50 rounded-lg transition-colors mt-4 cursor-pointer">
                    <span class="icon-wrap flex-shrink-0">
                        <i class="fa-solid fa-arrow-right-from-bracket text-lg"></i>
                    </span>
                    <span class="sidebar-label">Logout</span>
                </a>

            </nav>
        </div>
    </aside>

    <script>
    (() => {
        const sidebar     = document.getElementById('sidebar');
        const collapseBtn = document.getElementById('collapse-btn');
        const collapseIcon = document.getElementById('collapse-icon');
        const mobileToggle = document.getElementById('mobile-toggle');
        const overlay     = document.getElementById('overlay');
        const searchInput = document.getElementById('search-input');
        const noResults   = document.getElementById('no-results');

        /* ─── Keyboard: Cmd/Ctrl+F → focus search ─── */
        document.addEventListener('keydown', e => {
            if ((e.metaKey || e.ctrlKey) && e.key === 'f') {
                if (!sidebar.classList.contains('collapsed')) {
                    e.preventDefault();
                    searchInput.focus();
                }
            }
        });

        /* ─── Desktop collapse ─── */
        let isCollapsed = false;
        collapseBtn.addEventListener('click', () => {
            isCollapsed = !isCollapsed;
            sidebar.classList.toggle('collapsed', isCollapsed);
            collapseIcon.style.transform = isCollapsed ? 'rotate(0deg)' : 'rotate(180deg)';
            if (isCollapsed) closeAllSubmenus();
        });

        /* ─── Mobile open/close ─── */
        function openMobile()  { sidebar.classList.add('mobile-open');    overlay.classList.add('show'); }
        function closeMobile() { sidebar.classList.remove('mobile-open'); overlay.classList.remove('show'); }
        mobileToggle.addEventListener('click', openMobile);
        overlay.addEventListener('click', closeMobile);

        /* ─── Close mobile on nav link click (not dropdowns) ─── */
        sidebar.querySelectorAll('a.nav-item').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 768) closeMobile();
            });
        });

        /* ─── Submenus ─── */
        function closeAllSubmenus() {
            document.querySelectorAll('.submenu.open').forEach(sm => {
                sm.classList.remove('open');
                const btn = sm.closest('.nav-group')?.querySelector('.dropdown-trigger');
                btn?.querySelector('.chevron')?.classList.remove('rotated');
                btn?.classList.remove('text-blue-600', 'bg-blue-50/50');
            });
        }

        document.querySelectorAll('.dropdown-trigger').forEach(btn => {
            btn.addEventListener('click', e => {
                const group   = btn.closest('.nav-group');
                const submenu = group.querySelector('.submenu');
                const chevron = btn.querySelector('.chevron');
                const isOpen  = submenu.classList.contains('open');

                closeAllSubmenus();

                if (!isOpen) {
                    submenu.classList.add('open');
                    chevron.classList.add('rotated');
                    btn.classList.add('text-blue-600', 'bg-blue-50/50');
                }
                createRipple(btn, e);
            });
        });

        /* ─── Active nav item ─── */
        sidebar.querySelectorAll('a.nav-item').forEach(item => {
            item.addEventListener('click', function(e) {
                sidebar.querySelectorAll('.nav-item').forEach(i => {
                    i.classList.remove('active');
                    i.querySelector('.nav-icon')?.classList.remove('text-blue-600');
                });
                this.classList.add('active');
                this.querySelector('.nav-icon')?.classList.add('text-blue-600');
                createRipple(this, e);
            });
        });

        /* ─── Sub-link active ─── */
        document.querySelectorAll('.sub-link').forEach(link => {
            link.addEventListener('click', function() {
                document.querySelectorAll('.sub-link').forEach(l => l.classList.remove('active-sub'));
                this.classList.add('active-sub');
            });
        });

        /* ─── Ripple ─── */
        function createRipple(el, e) {
            const span = document.createElement('span');
            const rect = el.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            span.className = 'ripple';
            span.style.width  = span.style.height = size + 'px';
            span.style.left   = (e.clientX - rect.left - size / 2) + 'px';
            span.style.top    = (e.clientY - rect.top  - size / 2) + 'px';
            el.appendChild(span);
            span.addEventListener('animationend', () => span.remove());
        }

        /* ─── Live search ─── */
        searchInput.addEventListener('input', () => {
            const q = searchInput.value.toLowerCase().trim();
            const groups = document.querySelectorAll('#nav-list > a, #nav-list > .nav-group');
            let anyVisible = false;

            groups.forEach(group => {
                if (!q) {
                    group.style.display = '';
                    anyVisible = true;
                    return;
                }
                const text = group.textContent.toLowerCase();
                const visible = text.includes(q);
                group.style.display = visible ? '' : 'none';
                if (visible) anyVisible = true;

                // Auto-open matching dropdowns
                if (visible && group.classList.contains('nav-group')) {
                    const sm  = group.querySelector('.submenu');
                    const btn = group.querySelector('.dropdown-trigger');
                    const ch  = btn?.querySelector('.chevron');
                    if (sm && !sm.classList.contains('open')) {
                        sm.classList.add('open');
                        ch?.classList.add('rotated');
                        btn?.classList.add('text-blue-600', 'bg-blue-50/50');
                    }
                }
            });

            noResults.style.display = (!q || anyVisible) ? 'none' : 'block';

            // Restore on clear
            if (!q) closeAllSubmenus();
        });

        /* ─── Escape clears search ─── */
        searchInput.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input'));
                searchInput.blur();
            }
        });

    })();
    </script>
</body>
</html>
