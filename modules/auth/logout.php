<?php

session_start();

// hapus semua session
session_unset();

// destroy session
session_destroy();

// redirect ke login
header("Location: /marketplace/login.php");
exit;