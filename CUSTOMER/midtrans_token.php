<?php
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("HTTP/1.1 405 Method Not Allowed");
    exit();
}

require_once '../vendor/autoload.php';
require_once __DIR__ . '/../vendor/midtrans/midtrans-php/Midtrans.php';

// Konfigurasi Midtrans
\Midtrans\Config::$serverKey = 'SB-Mid-server-WcIELqE3mQVZmMXl-8WJvPac'; // Ganti dengan server key kamu
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

// Ambil data dari request POST
$data = json_decode(file_get_contents("php://input"), true);

// Cek apakah data dikirim dengan benar
if (!isset($data['seat']) || !isset($data['username'])) {
    echo json_encode(["error" => "Data seat atau username tidak dikirim!"]);
    exit();
}

$seatData = explode(', ', $data['seat']);
$username = $data['username'];
$email = $data['email'];
$phone = $data['phoneNum'];

// Buat data transaksi
$transaction_details = [
    'order_id' => uniqid(),
    'gross_amount' => count($seatData) * 40000
];

$customer_details = [
    'first_name' => $username,
    'email' => $email,
    'phone' => $phone
];

$transaction = [
    'transaction_details' => $transaction_details,
    'customer_details' => $customer_details
];

try {
    $snapToken = \Midtrans\Snap::getSnapToken($transaction);
    echo json_encode(['token' => $snapToken]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
