<?php
require "config/database.php";

$token = isset($_GET['token']) ? mysqli_real_escape_string($conn, $_GET['token']) : '';

$reset = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT * FROM password_resets 
WHERE token = '$token'
"));

$isValid = $reset ? true : false;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Password | NamaAplikasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">

    <div class="bg-white w-full max-w-md p-8 sm:p-10 rounded-[2.5rem] shadow-xl border border-slate-100">
        
        <?php if (!$isValid): ?>
            <!-- Tampilan Jika Token Tidak Valid -->
            <div class="text-center">
                <div class="w-20 h-20 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-triangle-exclamation text-3xl"></i>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 mb-2">Link Tidak Valid</h1>
                <p class="text-slate-500 mb-8 text-sm leading-relaxed">Maaf, link sudah kadaluwarsa. Silakan minta link baru.</p>
                <a href="forgot_password.php" class="inline-block w-full bg-slate-900 text-white font-bold py-4 rounded-2xl hover:bg-slate-800 transition shadow-lg shadow-slate-200 text-center">
                    Minta Link Baru
                </a>
            </div>

        <?php else: ?>
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-shield-halved text-blue-600 text-2xl"></i>
                </div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Password Baru</h1>
                <p class="text-slate-500 mt-2">Masukkan password baru Anda dua kali</p>
            </div>

            <!-- Pesan Error Matching (Hidden by default) -->
            <div id="matchError" class="hidden bg-red-50 text-red-500 text-xs p-3 rounded-xl mb-4 border border-red-100 flex items-center italic">
                <i class="fa-solid fa-circle-exclamation mr-2"></i> Password tidak cocok!
            </div>

            <form id="resetForm" method="POST" action="update_password.php" class="space-y-5">
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                <!-- Input Password 1 -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 ml-1">Password Baru</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </div>
                        <input 
                            id="password"
                            type="password" 
                            name="password" 
                            required 
                            placeholder="Minimal 8 karakter"
                            class="w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all outline-none text-slate-900"
                        >
                    </div>
                </div>

                <!-- Input Password 2 (Verifikasi) -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 ml-1">Konfirmasi Password Baru</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                            <i class="fa-solid fa-check-double text-sm"></i>
                        </div>
                        <input 
                            id="confirm_password"
                            type="password" 
                            required 
                            placeholder="Ulangi password"
                            class="w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all outline-none text-slate-900"
                        >
                    </div>
                </div>

                <button 
                    id="submitBtn"
                    type="submit"
                    class="w-full bg-blue-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-200 hover:bg-blue-700 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200"
                >
                    Update Password
                </button>
            </form>
        <?php endif; ?>

    </div>

    <script>
        const form = document.getElementById('resetForm');
        const password = document.getElementById('password');
        const confirm = document.getElementById('confirm_password');
        const errorBox = document.getElementById('matchError');
        const btn = document.getElementById('submitBtn');

        form?.addEventListener('submit', function (e) {
            // Reset error state
            errorBox.classList.add('hidden');
            
            // Validasi kecocokan
            if (password.value !== confirm.value) {
                e.preventDefault(); // Batalkan pengiriman form
                errorBox.classList.remove('hidden');
                confirm.focus();
                return false;
            }

            // Jika cocok, tampilkan loading
            btn.innerHTML = '<i class="fa-solid fa-circle-notch animate-spin mr-2"></i> Mengupdate...';
            btn.disabled = true;
            btn.classList.add("opacity-70", "cursor-not-allowed");
        });

        // Menghilangkan pesan error saat user mulai mengetik ulang
        [password, confirm].forEach(el => {
            el?.addEventListener('input', () => {
                errorBox.classList.add('hidden');
            });
        });
    </script>

</body>
</html>