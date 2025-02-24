<?php
session_start();
include 'dbConnect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Jika pakai Composer

if (isset($_POST['submit'])) {
    $Username = $_POST['Username'];
    $Email = $_POST['email'];

    // generate token dan expiry
    $token = bin2hex(random_bytes(32));
    $expired = date("Y-m-d H:i:s", strtotime("+10 minutes"));

    // $query = mysqli_query($conn, "SELECT custid FROM customer WHERE username = '$Username' AND email = '$Email'");

    
    $chkcust_sql = "SELECT custid, name FROM customer WHERE email = '$Email' AND username = '$Username'";//Check if email or username already exists
    $chkcust_result = mysqli_query($conn, $chkcust_sql);
    

    
    if ($chkcust_result) {
        if (mysqli_num_rows($chkcust_result) == 0 ) {
            ?>
            <script>		
                alert("The email or username doesn't exist. Please fill correctly.");
                window.location = "forgotpassword.php";
            </script><?php 
            exit();
        }
    }
}else {
    header('HTTP/1.1 405 Method Not Allowed');
        exit();
}
        $row = mysqli_fetch_assoc($chkcust_result);
      
        $customer_id = $row['custid'];
        $customer_name = $row['name'];

        // Generate token unik
        
        // Hapus token lama sebelum menyimpan yang baru
        // mysqli_query($conn, "DELETE FROM password_reset_request WHERE customer_id = '$customer_id'");


        // Simpan token reset password baru
        

        
            // Kirim Email dengan PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'batakoraja1@gmail.com';
                $mail->Password   = 'ivzl lwue qdls pjlo';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                $mail->setFrom('no-reply@tencinema.com', 'Password Reset');
                $mail->addAddress($Email, $Username);

                $mail->isHTML(true);
                $mail->Subject = 'Reset Your Password';
                $mail->Body    = "
                    <p>Hi <b>$customer_name</b>,</p>
                    <p>Klik link di bawah untuk reset password:</p>
                    <p><a href='http://localhost/Cinema-Booking-System-CRUD-/customer/verif_forgotpassword.php?code=$token'>Reset Password</a></p>
                    <p><small>Link berlaku 10 menit.</small></p>
                ";

                if ($mail->send()) {
                    mysqli_query($conn, "INSERT INTO password_reset_request (customer_id, token, token_expiry) VALUES ('$customer_id', '$token', '$expired')");
                    echo "<script>alert('Cek email untuk verifikasi!'); window.location = 'login.php';</script>";
                } else {
                    echo "<script>alert('Gagal mengirim email!'); window.location = 'forgotpassword.php';</script>";
                }   
            } catch (Exception $e) {
                echo "<script>alert('Kesalahan saat mengirim email!'); window.location = 'forgotpassword.php';</script>";
            }
//         } else {
//             echo "<script>alert('Gagal menyimpan token reset password!'); window.location = 'forgotpassword.php';</script>";
//         }
//     } else {
//         echo "<script>alert('Username atau Email tidak ditemukan!'); window.location = 'forgotpassword.php';</script>";
//     }
// }
?>
