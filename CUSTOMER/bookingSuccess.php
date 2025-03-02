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

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../vendor/tecnickcom/tcpdf/tcpdf.php'; // TCPDF

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

            $emailQuery = "SELECT email, username FROM customer WHERE custid = ?";
            $emailStmt = mysqli_prepare($conn, $emailQuery);
            mysqli_stmt_bind_param($emailStmt, "i", $custid);
            mysqli_stmt_execute($emailStmt);
            mysqli_stmt_bind_result($emailStmt, $customerEmail, $username);
            mysqli_stmt_fetch($emailStmt);
            mysqli_stmt_close($emailStmt);

            // === [ 1. BUAT INVOICE PDF DENGAN QR CODE ] === //
            $pdf = new TCPDF();
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('TENCinemas');
            $pdf->SetTitle('Invoice Booking');
            $pdf->SetMargins(15, 15, 15);
            $pdf->SetAutoPageBreak(TRUE, 15);
            $pdf->AddPage();

            // Tambahkan logo
            $pdf->Image('assets/imaages/logo/ten-logo.png', 15, 10, 40);
            $pdf->SetFont('Helvetica', 'B', 18);
            $pdf->Cell(0, 15, 'TENCinemas - Invoice', 0, 1, 'C');

            // Garis pemisah
            $pdf->SetLineWidth(0.5);
            $pdf->Line(15, 35, 195, 35);
            $pdf->Ln(10);

            // Detail Booking
            $pdf->SetFont('Helvetica', 'B', 12);
            $html = "
                <h3>Detail Booking</h3>
                <table border='1' cellpadding='5'>
                    <tr><td><strong>Customer</strong></td><td>$username</td></tr>
                    <tr><td><strong>Theater</strong></td><td>$theater</td></tr>
                    <tr><td><strong>Hall No</strong></td><td>$hallNo</td></tr>
                    <tr><td><strong>Date</strong></td><td>$date</td></tr>
                    <tr><td><strong>Showtime</strong></td><td>$time</td></tr>
                    <tr><td><strong>Seats</strong></td><td>$seatsChosen</td></tr>
                    <tr><td><strong>Amount Paid</strong></td><td>Rp " . number_format($amount, 2) . "</td></tr>
                </table>
            ";
            $pdf->writeHTML($html, true, false, true, false, '');

            // Generate QR Code
            $qr_code_content = "https://tencinemas.com/verify?trx=$transaction_id";
            $style = array(
                'border' => false,
                'vpadding' => 'auto',
                'hpadding' => 'auto',
                'fgcolor' => array(0, 0, 0),
                'bgcolor' => false
            );
            $pdf->write2DBarcode($qr_code_content, 'QRCODE,H', 75, 150, 50, 50, $style);
            $pdf->Ln(60);
            $pdf->SetFont('Helvetica', 'I', 10);
            $pdf->Cell(0, 10, '', 0, 1, 'C');

            // Simpan PDF
            $invoice_pdf = __DIR__ . "/invoices/invoice_$order_id.pdf"; // Simpan di folder 'invoices'
            $pdf->Output($invoice_pdf, 'F');

            // === [ 2. KIRIM EMAIL DENGAN LAMPIRAN INVOICE ] === //
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'batakoraja1@gmail.com';
                $mail->Password = 'ivzl lwue qdls pjlo';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                $mail->setFrom('batakoraja1@gmail.com', 'TENCinemas');
                $mail->addAddress($customerEmail, $username);

                // Lampiran Invoice PDF
                $mail->addAttachment($invoice_pdf);

                $mail->isHTML(true);
                $mail->Subject = 'TENCinemas - Booking Confirmation';
                $mail->Body = "Dear $username, <br><br>
                    Terima kasih telah memesan tiket di TENCinemas! <br><br>
                    Silakan lihat invoice yang terlampir. Anda dapat memverifikasi tiket dengan memindai QR Code.<br><br>
                    Salam,<br>
                    TENCinemas";

                $mail->send();
                if (file_exists($invoice_pdf)) {
                    unlink($invoice_pdf);
                }
                
                
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
            window.location.href = "index.php";
        </script>
        <?php
        exit();

    } catch (Exception $e) {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
            Swal.fire({
                title: "Email Sending Failed",
                text: "'.$mail->ErrorInfo.'",
                icon: "error",
                confirmButtonText: "OK"
            }).then(() => {
                window.location = "index.php";
            });
        </script>';
        exit();
    }
        } else {
        // Jika gagal, tampilkan pesan error
        echo "Error inserting data: " . mysqli_error($conn);
        }

} else {
     // Jika pembayaran gagal
     echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
     echo '<script>
         Swal.fire({
             title: "Payment Failed!",
             text: "Please try placing your order again.",
             icon: "error",
             confirmButtonText: "OK"
         }).then(() => {
             window.location = "index.php";
         });
     </script>';
     exit();
}
}





// Tutup koneksi database
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
