<?php

$host = "localhost";
$user = "root";
$pass = "$!13n7";
$db   = "marketplace";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// set charset (penting untuk keamanan & encoding)
mysqli_set_charset($conn, "utf8mb4");
