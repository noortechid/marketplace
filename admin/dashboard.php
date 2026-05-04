<?php
require "../helpers/auth.php";
require "../config/database.php";

checkLogin();
requireRole(['admin']);
?>

<h1>Admin Dashboard</h1>
