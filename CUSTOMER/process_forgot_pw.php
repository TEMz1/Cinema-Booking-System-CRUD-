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
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
                echo '<script>
                    Swal.fire({
                        title: "User Not Found",
                        text: "The email or username doesn\'t exist. Please fill correctly.",
                        icon: "error",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location = "forgotpassword.php";
                    });
                </script>';
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
    
            // Kirim Email dengan PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = '';                 // Use your email address
                $mail->Password   = '';                 // Use App Password from Google account (not password gmail account)
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
                    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
                    echo '<script>
                        Swal.fire({
                            title: "Email Sent!",
                            text: "Check your email for verification.",
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then(() => {
                            window.location = "login.php";
                        });
                    </script>';
                } else {
                    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
                    echo '<script>
                        Swal.fire({
                            title: "Email Failed!",
                            text: "Failed to send email. Please try again.",
                            icon: "error",
                            confirmButtonText: "OK"
                        }).then(() => {
                            window.location = "forgotpassword.php";
                        });
                    </script>';
                }   
            } catch (Exception $e) {
                echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo '<script>
                Swal.fire({
                    title: "Error!",
                    text: "An error occurred while sending the email.",
                    icon: "error",
                    confirmButtonText: "OK"
                }).then(() => {
                    window.location = "forgotpassword.php";
                });
            </script>';
        }

?>
