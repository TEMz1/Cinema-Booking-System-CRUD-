    <?php

    include 'dbConnect.php';

        //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require '../vendor/autoload.php';


    if (isset($_POST['submit'])) {
        $Username = $_POST['Username'];
        $Email = $_POST['Email'];
        $Password = $_POST['Password'];
        $phoneNo = $_POST['phoneNo'];
        $Name = $_POST['Name'];
        $code = md5($Email . date('Y-m-d H:i:s') . bin2hex(random_bytes(5)));


        $chkcust_sql = "SELECT * FROM customer WHERE email = '$Email' or username = '$Username'";//Check if email or username already exists
        $chkcust_result = mysqli_query($conn, $chkcust_sql);
        $expired = date("Y-m-d H:i:s", strtotime("+10 minutes"));



        if($chkcust_result){    
            if(mysqli_num_rows($chkcust_result) > 0){
                echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
                    echo '<script>
                        Swal.fire({
                            title: "Failed!",
                            text: "The email or username has been taken. Please change.",
                            icon: "error",
                            confirmButtonText: "OK"
                        }).then(() => {
                            window.location = "register.php";
                        });
                    </script>';
            exit();  
        }
        }
    }else {
        //Redirect to register page if form is not submitted
        header('HTTP/1.1 405 Method Not Allowed');
        exit();
    }

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = '';                      //Use your email address
        $mail->Password   = '';                     //Use App Password from Google account (not password gmail account)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('no-reply@tencinema.com', 'Verifikasi'); 
        $mail->addAddress($Email, $Name);     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Verification your Account'; //    subject
        $mail->Body    = 'Hi! '.$Name.' Email kamu berhasil didaftarkan di web TENCinemas,<br/>
                        sekarang silahkan lakukan verifkasi akun anda untuk Login <br/><br/>
                        <a href="http://localhost/Cinema-Booking-System-CRUD-/customer/verif.php?code='.$code.'">
                        Verifikasi Akunmu</a>';
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if ($mail->send()) {
            $insert = mysqli_query($conn, "INSERT INTO customer (name, phoneNo, email, username, password, verification_code, token_expiry) VALUES ('$Name','$phoneNo','$Email','$Username','$Password', '$code', '$expired')");
            if ($insert) {
                echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
                echo '<script>
                    Swal.fire({
                        title: "Success!",
                        text: "You have successfully registered. Please check your email for verification!",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location = "login.php";
                    });
                </script>';
                }
        }
    } catch (Exception $e) {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
                    echo '<script>
                        Swal.fire({
                            title: "Failed!",
                            text: "The email does\'nt exist Please input your valid email!",
                            icon: "error",
                            confirmButtonText: "OK"
                        }).then(() => {
                            window.location = "register.php";
                        });
                    </script>';
    }



