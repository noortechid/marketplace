<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: /marketplace/login.php");
        exit;
    }
}

function getUserRole() {
    return $_SESSION['role'] ?? null;
}

function requireRole($roles = []) {
    checkLogin();

    $userRole = $_SESSION['role'] ?? null;

    if (!in_array($userRole, $roles)) {
        http_response_code(403);
        die("403 Forbidden - Akses ditolak");
    }
}
