<?php
require "config/database.php";

$email = $_POST['email'];

// Proteksi SQL Injection sederhana (Sangat disarankan gunakan Prepared Statements)
$email = mysqli_real_escape_string($conn, $email);

$user = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT id FROM users WHERE email = '$email'
"));

// Jika email tidak ditemukan, kita tampilkan UI Error yang cantik
if (!$user) {
    $error_message = "Email tidak ditemukan di sistem kami.";
} else {
    $user_id = $user['id'];

    // Buat token
    $token = bin2hex(random_bytes(32));
    $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

    // Simpan ke DB
    mysqli_query($conn, "
        INSERT INTO password_resets (user_id, token, expires_at)
        VALUES ($user_id, '$token', '$expires')
    ");

    // Link reset
    $link = "http://localhost/marketplace/reset_password.php?token=$token";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pengiriman | NamaAplikasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">

    <div class="bg-white w-full max-w-md p-8 sm:p-10 rounded-[2.5rem] shadow-xl border border-slate-100 text-center">
        
        <?php if (isset($error_message)): ?>
            <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fa-solid fa-circle-xmark text-4xl"></i>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 mb-2">Email Tidak Terdaftar</h1>
            <p class="text-slate-500 mb-8"><?= $error_message ?></p>
            <a href="javascript:history.back()" class="inline-block w-full bg-slate-900 text-white font-bold py-4 rounded-2xl hover:bg-slate-800 transition">
                Coba Lagi
            </a>

        <?php else: ?>
            <div class="w-20 h-20 bg-green-50 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fa-solid fa-paper-plane text-3xl animate-bounce"></i>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 mb-2">Link Berhasil Dibuat!</h1>
            <p class="text-slate-500 mb-8 text-sm leading-relaxed">
                Silakan klik tombol di bawah ini untuk mengatur ulang password Anda. Link ini akan kedaluwarsa dalam 1 jam.
            </p>

            <div class="bg-blue-50 border border-blue-100 p-4 rounded-2xl mb-8 break-all">
                <p class="text-[10px] uppercase font-bold text-blue-400 tracking-widest mb-2 text-left">Link Rahasia Anda</p>
                <a href="<?= $link ?>" class="text-blue-700 font-semibold hover:underline block text-sm">
                    <?= $link ?>
                </a>
            </div>

            <a href="<?= $link ?>" class="inline-block w-full bg-blue-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-200 hover:bg-blue-700 hover:scale-[1.02] transition-all mb-4">
                Reset Password Sekarang
            </a>
            
            <p class="text-xs text-slate-400">
                <i class="fa-solid fa-circle-info mr-1"></i> Jangan bagikan link ini kepada siapapun.
            </p>
        <?php endif; ?>

    </div>

</body>
</html>