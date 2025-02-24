<?php
session_start();


// Validasi session
if (isset($_SESSION['hall_id']) && isset($_SESSION['transaction_id'])) {
    $hall_no = $_SESSION['hall_id'];           // Ambil dari session
    $transaction_id = $_SESSION['transaction_id']; // Ambil dari session
  
   // Query untuk menghapus data
   $sql = "DELETE FROM bookings WHERE transaction_id = ? AND hallNo = ?";
   $stmt = mysqli_prepare($conn, $sql);
  
   if ($stmt) {
       // Bind parameter
       mysqli_stmt_bind_param($stmt, "ss", $transaction_id, $hall_no);
  
       // Eksekusi query
       mysqli_stmt_execute($stmt);
   }
    // Hapus session terkait (Opsional)
    unset($_SESSION['hall_id']);
    unset($_SESSION['transaction_id']);
  }
  

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting...</title>
    <script>
        setTimeout(function() {
            window.location.href = "index.php"// Pindah ke index.html setelah 3 detik
        }, 500);
    </script>
</head>
<body>
    <H1><center>ON GOING</center></H1>
</body>
</html>