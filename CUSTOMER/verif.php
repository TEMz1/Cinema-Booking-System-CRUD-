<?php
include 'dbConnect.php';

if (!isset($_GET['code']) || empty($_GET['code'])) {
    header("HTTP/1.1 405 Method Not Allowed"); // Redirect jika tidak ada kode
    exit();
}

$code = mysqli_real_escape_string($conn, $_GET['code']); // Mencegah SQL Injection

// Cek apakah token ada di database
$check_code = mysqli_query($conn, "SELECT * FROM customer WHERE verification_code = '$code'");

if (!$check_code) {
    die("Query Error: " . mysqli_error($conn)); // Debugging jika query error
}

if (mysqli_num_rows($check_code) > 0) {
    $row = mysqli_fetch_assoc($check_code);
    
    // Cek apakah akun sudah diverifikasi
    if ($row['is_verif'] == 1) {
        echo "<script>alert('Your account is already verified. Please log in.'); window.location = 'login.php';</script>";
        exit();
    }

    // Cek apakah token masih berlaku
    if (strtotime($row['token_expiry']) > time()) {
        // Update status verifikasi
        mysqli_query($conn, "UPDATE customer SET is_verif = 1 WHERE verification_code = '$code'");
        echo "<script>alert('Verification successful! You can now log in.'); window.location = 'login.php';</script>";
        exit();
    } else {
        // Jika token kadaluarsa, hapus akun dan redirect ke register
        mysqli_query($conn, "DELETE FROM customer WHERE verification_code = '$code'");
        echo "<script>alert('Verification link has expired. Please register again.'); window.location = 'register.php';</script>";
        exit();
    }
} else {
    // Jika kode tidak ditemukan, redirect ke register
    header("location: register.php");
    exit();
}
?>
