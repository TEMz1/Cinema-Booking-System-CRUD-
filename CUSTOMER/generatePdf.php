<?php
require_once '../vendor/tecnickcom/tcpdf/tcpdf.php';

$judul = "aasdsada";
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
// $pdf->Ln(10);
// $pdf->SetFont('Helvetica', 'B', 25);
// $pdf->Cell(0, 15, 'TENCinemas - Invoice', 0, 1, 'C');
$pdf->Ln(10);

// Tambahkan garis pemisah
$pdf->SetLineWidth(0.4);
$pdf->Line(15, 52, 195, 52); // Ubah Y dari 55 ke 50
$pdf->Ln(20); // Kurangi spasi supaya lebih pas dengan konten

// Tambahkan konten dummy buat testing
$pdf->SetFont('Helvetica', '', 18);

$html = '
    <table border="0" cellpadding="8" cellspacing="0" align="center" width="100%">
        <tbody>
            <!-- Baris untuk Detail Booking -->
            <tr>
                <td colspan="2" style="text-align: center; font-weight: bold; font-size: 25px; padding: 12px;">Detail Booking</td>
            </tr>
            <hr>
            <!-- Baris untuk Perayaan Mati Rasa -->
            <tr>
                <td colspan="2" style="text-align: center; font-weight: bold; font-size: 20px; padding: 12px;"> '.$judul .'</td>
            </tr>
            <hr>
            <!-- Data Customer -->
            <tr><td style="padding: 12px; font-size: 14px; font-weight: bold;">Customer</td><td style="padding: 12px; font-size: 14px;">John Doe</td></tr>
            <tr><td style="padding: 12px; font-size: 14px; font-weight: bold;">Theater</td><td style="padding: 12px; font-size: 14px;">TEN Cinema</td></tr>
            <tr><td style="padding: 12px; font-size: 14px; font-weight: bold;">Hall No</td><td style="padding: 12px; font-size: 14px;">5</td></tr>
            <tr><td style="padding: 12px; font-size: 14px; font-weight: bold;">Date</td><td style="padding: 12px; font-size: 14px;">10 Mar 2025</td></tr>
            <tr><td style="padding: 12px; font-size: 14px; font-weight: bold;">Showtime</td><td style="padding: 12px; font-size: 14px;">18:30</td></tr>
            <tr><td style="padding: 12px; font-size: 14px; font-weight: bold;">Seats</td><td style="padding: 12px; font-size: 14px;">A1, A2</td></tr>
            <hr>
            <!-- Total -->
            <tr style="background-color: #d1cfc8;">
                <td style="padding: 12px; text-align: right; font-size: 18px; font-weight: bold; background-color: #d1cfc8;">Total</td>
                <td style="padding: 12px; font-size: 18px; font-weight: bold; background-color: #d1cfc8;">Rp 80,000.00</td>
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

$qr_code_content = "https://tencinemas.com/verify?trx=a32116asdsad23";
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

            // Simpan PDF
            $invoice_pdf = __DIR__ . "/invoices/invoice_abcd.pdf"; // Simpan di folder 'invoices'
            $pdf->Output($invoice_pdf, 'I');

            
?>
