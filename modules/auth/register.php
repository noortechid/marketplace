<?php
require "../../config/database.php";

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = $_POST['password'];

// validasi sederhana
if (!$name || !$email || !$password) {
    die("Semua field wajib diisi");
}

// hash password
$hashed = password_hash($password, PASSWORD_DEFAULT);

// prepared statement
$stmt = mysqli_prepare($conn, "INSERT INTO users (name, email, password) VALUES (?, ?, ?)");

mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed);

if (mysqli_stmt_execute($stmt)) {
    header("Location: ../../login.php");
} else {
    echo "Gagal register: " . mysqli_error($conn);
}
