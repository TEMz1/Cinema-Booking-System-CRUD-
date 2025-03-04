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

$sess_id = $_SESSION['SESS_ID'];

$sql = "SELECT m.title 
        FROM sessions s 
        JOIN movie m ON s.movieid = m.movieid 
        WHERE s.session_id = $sess_id";

$result = $conn->query($sql);
$row =  mysqli_fetch_assoc($result);
$judul = $row['title'];

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
                 
            // Buat instance PDF
            $pdf = new TCPDF();
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('TENCinemas');
            $pdf->SetTitle('Invoice Booking TENCinema');
            $pdf->SetMargins(15, 15, 15);
            $pdf->SetAutoPageBreak(TRUE, 15);
            $pdf->AddPage();
                        
            // Tambahkan logo
            $pdf->Image('assets/images/logo/ten-logo.jpg', 83, 13, 40);
            $pdf->Ln(10);
                        
            // Tambahkan garis pemisah
            $pdf->SetLineWidth(0.4);
            $pdf->Line(15, 52, 195, 52); // Ubah Y dari 55 ke 50
            $pdf->Ln(20); // Kurangi spasi supaya lebih pas dengan konten

            // Detail Booking
            $pdf->SetFont('Helvetica', '', 18);
            $html = '
                        <table border="0" cellpadding="8" cellspacing="0" align="center" width="100%">
                            <tbody>
                                <!-- Baris untuk Detail Booking -->
                                <tr>
                                    <td colspan="2" style="text-align: center; font-weight: bold; font-size: 25px; padding: 12px;">DETAIL BOOKING</td>
                                </tr>
                                <hr>
                                <!-- Baris untuk Perayaan Mati Rasa -->
                                <tr>
                                    <td colspan="2" style="text-align: center; font-weight: bold; font-size: 22px; padding: 12px;"> '.$judul .'</td>
                                </tr>
                                <hr>
                                <!-- Data Customer -->
                                <tr><td style="padding: 12px; font-size: 14px; font-weight: bold;">Theater</td><td style="padding: 12px; font-size: 14px;">'.$theater .'</td></tr>
                                <tr><td style="padding: 12px; font-size: 14px; font-weight: bold;">Hall No</td><td style="padding: 12px; font-size: 14px;">'.$hallNo .'</td></tr>
                                <tr><td style="padding: 12px; font-size: 14px; font-weight: bold;">Date</td><td style="padding: 12px; font-size: 14px;">'.$date .'</td></tr>
                                <tr><td style="padding: 12px; font-size: 14px; font-weight: bold;">Showtime</td><td style="padding: 12px; font-size: 14px;">'.$time .'</td></tr>
                                <tr><td style="padding: 12px; font-size: 14px; font-weight: bold;">Seats</td><td style="padding: 12px; font-size: 14px;">'.$seatsChosen .'</td></tr>
                                <hr>
                                <!-- Total -->
                                <tr style="background-color: #d1cfc8;">
                                    <td style="padding: 12px; text-align: right; font-size: 18px; font-weight: bold; background-color: #d1cfc8;">Total</td>
                                    <td style="padding: 12px; font-size: 18px; font-weight: bold; background-color: #d1cfc8;">Rp '. number_format($amount, 2, ',', '.') .'</td>
                                </tr>
                            </tbody>
                        </table>
                    ';
                                                
                $pdf->Ln(5); // Spasi sebelum garis
                $pdf->SetLineWidth(0.3);

                $pdf->Ln(10);

                $pdf->writeHTML($html, true, false, true, false, '');
                $pdf->Ln(10); // Tambahkan spasi setelah tabel


                // Generate QR Code

                $qr_code_content = $transaction_id;
                $style = array(
                    'border' => false,
                    'vpadding' => 'auto',
                    'hpadding' => 'auto',
                    'fgcolor' => array(0, 0, 0),
                    'bgcolor' => false
                );
                $pdf->write2DBarcode($qr_code_content, 'QRCODE,H', 80, 210, 50, 50, $style);
                            $pdf->Ln(60);
                            $pdf->SetFont('Helvetica', 'I', 10);
                            $pdf->Cell(0, 10, '', 0, 1, 'C');
                
                // Atur Nama File
                $filename = 'Invoice_' . $username . '_' . 'TENCinema' . $order_id . '.pdf';
                // Output PDF ke dalam variabel sebagai string (tanpa menyimpannya di server)
                $pdf_content = $pdf->Output($filename, 'S'); 

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

                // Lampiran Invoice PDF langsung dari string
                $mail->addStringAttachment($pdf_content, "$filename", 'base64', 'application/pdf');

                $mail->isHTML(true);
                $mail->Subject = 'TENCinemas - Booking Confirmation';
                $mail->Body = "Dear $username, <br><br>
                    Thank you for booking your ticket at TENCinemas! <br><br>
                    Please find the attached invoice. You can verify your ticket on TENCinema by scanning the QR Code.<br><br>
                    Best regards,<br>
                    TENCinemas";

                $mail->send();
                 
                
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
