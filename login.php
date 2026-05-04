<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | NamaAplikasi</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>

<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">

    <div class="bg-white w-full max-w-md p-8 sm:p-10 rounded-[2.5rem] shadow-xl border border-slate-100">

        <div class="flex items-center justify-between mb-8">
            <a href="javascript:history.back()" class="text-slate-400 hover:text-blue-600 transition">
                <i class="fa-solid fa-arrow-left text-xl"></i>
            </a>
            <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200">
                <i class="fa-solid fa-bolt text-white text-xl"></i>
            </div>
            <div class="w-6"></div> </div>

        <div class="text-center mb-10">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                Selamat Datang
            </h1>
            <p class="text-slate-500 mt-2">Silakan masuk ke akun Anda</p>
        </div>

        <div id="errorBox" class="hidden bg-red-50 text-red-500 text-sm p-4 rounded-2xl text-center mb-6 border border-red-100">
            <i class="fa-solid fa-circle-exclamation mr-2"></i> Email atau password salah
        </div>

        <form method="POST" action="modules/auth/login.php" class="space-y-6">

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 ml-1">Email</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                        <i class="fa-regular fa-envelope"></i>
                    </div>
                    <input 
                        type="email" 
                        name="email" 
                        required 
                        autocomplete="email"
                        placeholder="nama@email.com"
                        class="w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all outline-none text-slate-900"
                    >
                </div>
            </div>

            <div>
                <div class="flex justify-between items-center mb-2 ml-1">
                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Password</label>
                    <a href="forgot_password.php" class="text-blue-600 text-xs font-bold hover:underline">
                        Lupa Password?
                    </a>
                </div>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                        <i class="fa-regular fa-lock"></i>
                    </div>
                    <input 
                        id="password"
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="w-full pl-11 pr-12 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all outline-none text-slate-900"
                    >
                    <span 
                        onclick="togglePassword()"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 cursor-pointer hover:text-slate-600 transition"
                    >
                        <i id="eyeIcon" class="fa-regular fa-eye"></i>
                    </span>
                </div>
            </div>

            <button 
                id="loginBtn"
                type="submit"
                class="w-full bg-blue-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-200 hover:bg-blue-700 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200 mt-4"
            >
                Masuk Sekarang
            </button>

        </form>

        <div class="mt-10 text-center">
            <p class="text-sm text-slate-500">
                Belum punya akun? 
                <a href="register.php" class="text-blue-600 font-bold hover:underline underline-offset-4">
                    Daftar Gratis
                </a>
            </p>
        </div>

    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById("password");
            const icon = document.getElementById("eyeIcon");

            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.replace("fa-eye-slash", "fa-eye");
            }
        }

        document.querySelector("form").addEventListener("submit", function () {
            const btn = document.getElementById("loginBtn");
            btn.innerHTML = '<i class="fa-solid fa-circle-notch animate-spin mr-2"></i> Memvalidasi...';
            btn.disabled = true;
            btn.classList.add("opacity-70", "cursor-not-allowed");
        });
    </script>

</body>
</html>