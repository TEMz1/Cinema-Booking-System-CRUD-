<?php
session_name("admin_session");
session_start();
session_destroy(); // Hapus semua sesi
header("Location: login.php"); // Redirect ke halaman login setelah logout
exit();
?>
