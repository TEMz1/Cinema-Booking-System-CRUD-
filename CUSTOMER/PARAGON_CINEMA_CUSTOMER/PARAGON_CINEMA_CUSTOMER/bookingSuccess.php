<?php
session_name('cust');
session_start();
include 'dbConnect.php';

// Validasi session
if (!isset($_SESSION['transaction_id']) || empty($_SESSION['transaction_id']) || 
    !isset($_SESSION['hall_id']) || empty($_SESSION['hall_id'])) {
    header("location:displayBookingDetails.php"); // Redirect jika session tidak valid
    exit();
}

// Ambil data dari session
$theater = "Paragon Cinema - KTCC Mall";
$custid = $_SESSION['USER_ID'];
$hallNo = $_SESSION['hall_id'];
$showtime = $_SESSION['SHOWTIME'];
$date = (new DateTime($showtime))->format('d M Y');
$time = (new DateTime($showtime))->format('H:i a');
$seatsChosen = $_SESSION['seat'];
$amount = count(explode(', ', $seatsChosen)) * 20;
$transaction_id = $_SESSION['transaction_id'];

// Masukkan data ke database
$query = "INSERT INTO invoice (price, custid, theaterName, hallNo, date, showtime, chosenSeat, transaction_id) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

// Prepare dan eksekusi query
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "dissssss", $amount, $custid, $theater, $hallNo, $date, $time, $seatsChosen, $transaction_id);

if (mysqli_stmt_execute($stmt)) {
    // Jika berhasil, destroy session kecuali data user
    $user_id = $_SESSION['USER_ID'];
    $username = $_SESSION['username'];

    session_destroy(); // Hapus semua session
    session_start(); // Mulai ulang session
    $_SESSION['USER_ID'] = $user_id;
    $_SESSION['username'] = $username;

    // Redirect ke halaman index
    header("Location: index.php");
    exit();
} else {
    // Jika gagal, tampilkan pesan error
    echo "Error inserting data: " . mysqli_error($conn);
}

// Tutup koneksi database
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
