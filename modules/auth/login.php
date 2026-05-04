<?php
require "../../config/database.php";

session_start();

$email = trim($_POST['email']);
$password = $_POST['password'];

$stmt = mysqli_prepare($conn, "SELECT id, password, role FROM users WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if ($user && password_verify($password, $user['password'])) {

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];

    if ($user['role'] == 'admin') {
        header("Location: ../../admin/index.php");
    } elseif ($user['role'] == 'seller') {
        header("Location: ../../seller/index.php");
    } else {
        header("Location: ../../index.php");
    }

    exit;

} else {
    echo "Email atau password salah";
}
