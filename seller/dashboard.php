<?php
require "../config/database.php";

checkLogin();
requireRole(['seller']);

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
<?php include "../templates/seller/head.php"; ?>
<body class="flex"> 

<?php include "../templates/seller/sidebar.php"; ?>

</body>
</html>
