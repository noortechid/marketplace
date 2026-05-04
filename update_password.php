<?php
require "config/database.php";

// Pastikan data dikirim via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

$token = mysqli_real_escape_string($conn, $_POST['token']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Ambil data reset
$reset = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT * FROM password_resets WHERE token = '$token'
"));

$success = false;
if (!$reset) {
    $error_message = "Token tidak valid atau sudah digunakan.";
} else {
    $user_id = $reset['user_id'];

    // Update password
    $update = mysqli_query($conn, "
        UPDATE users SET password = '$password' WHERE id = $user_id
    ");

    if ($update) {
        // Hapus token agar tidak bisa dipakai lagi
        mysqli_query($conn, "
            DELETE FROM password_resets WHERE token = '$token'
        ");
        $success = true;
    } else {
        $error_message = "Terjadi kesalahan saat memperbarui password.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pembaruan Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">

    <div class="bg-white w-full max-w-md p-8 sm:p-10 rounded-[2.5rem] shadow-xl border border-slate-100 text-center">
        
        <?php if ($success): ?>
            <div class="w-20 h-20 bg-green-50 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
                <i class="fa-solid fa-check text-4xl animate-[scale_0.5s_ease-in-out]"></i>
            </div>
            
            <h1 class="text-2xl font-extrabold text-slate-900 mb-2">Password Diperbarui!</h1>
            <p class="text-slate-500 mb-8 text-sm leading-relaxed">
                Password Anda telah berhasil diubah. Sekarang Anda dapat masuk kembali menggunakan password baru Anda.
            </p>

            <a href="login.php" class="inline-block w-full bg-blue-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-200 hover:bg-blue-700 hover:scale-[1.02] active:scale-[0.98] transition-all">
                Lanjut ke Login
            </a>

        <?php else: ?>
            <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fa-solid fa-circle-xmark text-4xl"></i>
            </div>
            
            <h1 class="text-2xl font-extrabold text-slate-900 mb-2">Gagal Memperbarui</h1>
            <p class="text-slate-500 mb-8 text-sm leading-relaxed">
                <?= $error_message ?>
            </p>

            <a href="forgot_password.php" class="inline-block w-full bg-slate-900 text-white font-bold py-4 rounded-2xl hover:bg-slate-800 transition shadow-lg shadow-slate-200">
                Minta Link Baru
            </a>
        <?php endif; ?>

    </div>

    <style>
        @keyframes scale {
            0% { transform: scale(0); }
            100% { transform: scale(1); }
        }
    </style>

</body>
</html>