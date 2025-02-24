<?php
session_name('cust');
session_start();
include 'dbConnect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_GET['order_id'])) {
    header("HTTP/1.1 405 Method Not Allowed"); // Redirect ke halaman utama jika diakses langsung
    exit();
}

// Validasi session
if (!isset($_SESSION['transaction_id']) || empty($_SESSION['transaction_id']) || 
    !isset($_SESSION['hall_id']) || empty($_SESSION['hall_id'])) {
    header("location:displayBookingDetails.php"); // Redirect jika session tidak valid
    exit();
}

require_once '../vendor/autoload.php';
require_once '../vendor/midtrans/midtrans-php/Midtrans.php';

\Midtrans\Config::$serverKey = 'SB-Mid-server-WcIELqE3mQVZmMXl-8WJvPac';
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

// Ambil informasi pembayaran dari Midtrans
$order_id = $_GET['order_id'] ?? null;

// Ambil data dari session
$theater = "TEN Cinema - KTCC Mall";
$custid = $_SESSION['USER_ID'];
$hallNo = $_SESSION['hall_id'];
$showtime = $_SESSION['SHOWTIME'];
$date = (new DateTime($showtime))->format('d M Y');
$time = (new DateTime($showtime))->format('H:i a');
$seatsChosen = $_SESSION['seat'];
$amount = count(explode(', ', $seatsChosen)) * 40000;
$transaction_id = $_SESSION['transaction_id'];

if ($order_id) {
    $status = \Midtrans\Transaction::status($order_id);
    $transaction_status = $status->transaction_status;
    $payment_type = $status->payment_type;
    $payment_time = $status->transaction_time;

    // Tentukan status pembayaran
    if ($transaction_status == 'settlement' || $transaction_status == 'capture') {
        $payment_status = 'settlement';
        // Masukkan data ke database
        $query = "INSERT INTO invoice (price, custid, theaterName, hallNo, date, showtime, chosenSeat, transaction_id, midtrans_order_id, payment_status, payment_type, payment_time) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare dan eksekusi query
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "dissssssssss", $amount, $custid, $theater, $hallNo, $date, $time, $seatsChosen, $transaction_id, $order_id, $payment_status, $payment_type, $payment_time);

        if (mysqli_stmt_execute($stmt)) {
        // Jika berhasil, destroy session kecuali data user
        $user_id = $_SESSION['USER_ID'];
        $username = $_SESSION['USER_NAME'];

        session_destroy(); // Hapus semua session
        session_start(); // Mulai ulang session
        $_SESSION['USER_ID'] = $user_id;
        $_SESSION['USER_NAME'] = $username;

        // Redirect ke halaman index
        ?>
                <script>		
                     alert("Booking successful!!");
                    window.location = "index.php";
                </script>
                <?php
                
        exit();
        } else {
        // Jika gagal, tampilkan pesan error
        echo "Error inserting data: " . mysqli_error($conn);
        }

} else {
    ?>
                <script>		
                    alert("Pembayaran Gagal!!, Silahkan ulangi pemesanan!");
                    window.location = "index.php";
                </script>
                <?php
                die();
}
}




// Tutup koneksi database
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
