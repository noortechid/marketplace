<?php
require "../helpers/auth.php";

checkLogin();
requireRole(['admin']);

header("Location: dashboard.php");
exit;
