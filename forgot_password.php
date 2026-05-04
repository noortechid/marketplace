<?php include "config/database.php"; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password | NamaAplikasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6">

    <div class="bg-white w-full max-w-md p-8 sm:p-10 rounded-[2rem] shadow-xl border border-slate-100">
        
        <div class="flex items-center justify-between mb-8">
            <a href="login.php" class="text-slate-400 hover:text-blue-600 transition">
                <i class="fa-solid fa-arrow-left text-lg"></i>
            </a>
            <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center">
                <i class="fa-solid fa-key text-blue-600 text-xl"></i>
            </div>
            <div class="w-6"></div> </div>

        <div class="text-center mb-8">
            <h1 class="text-2xl font-extrabold text-slate-900">Lupa Password?</h1>
            <p class="text-slate-500 mt-2 text-sm leading-relaxed">
                Jangan khawatir! Masukkan alamat email Anda dan kami akan mengirimkan instruksi untuk mengatur ulang password.
            </p>
        </div>

        <form method="POST" action="send_reset.php" class="space-y-6">
            
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 ml-1">
                    Alamat Email
                </label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                        <i class="fa-regular fa-envelope"></i>
                    </div>
                    <input 
                        type="email" 
                        name="email" 
                        required 
                        placeholder="nama@email.com"
                        class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all outline-none text-slate-900 placeholder:text-slate-400"
                    >
                </div>
            </div>

            <button 
                id="resetBtn"
                type="submit"
                class="w-full bg-blue-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-200 hover:bg-blue-700 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200"
            >
                Kirim Link Reset
            </button>

        </form>

        <div class="mt-8 text-center">
            <p class="text-sm text-slate-500">
                Ingat password Anda? 
                <a href="login.php" class="text-blue-600 font-bold hover:underline">Masuk kembali</a>
            </p>
        </div>

    </div>

    <script>
        document.querySelector("form").addEventListener("submit", function () {
            const btn = document.getElementById("resetBtn");
            btn.innerHTML = '<i class="fa-solid fa-circle-notch animate-spin mr-2"></i> Mengirim...';
            btn.disabled = true;
            btn.classList.add("opacity-70", "cursor-not-allowed");
        });
    </script>

</body>
</html>