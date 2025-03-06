    <?php
    session_name('cust');
    session_start();
    include 'dbConnect.php';



    if (isset($_SESSION['USER_ID'])) {
        header("location: index.php");
        exit();
    }
    if (!isset($_GET['code']) || empty($_GET['code'])) {
        header("location: HTTP/1.1 405 Method Not Allowed"); // Redirect jika tidak ada kode
        exit();
    }
    

    $token = $_GET['code'];
    $result = mysqli_query($conn, "SELECT * FROM password_reset_request WHERE token='$token' AND token_expiry > NOW()");
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $customer_id = $row['customer_id'];

        if ($row['is_change'] == 1) {
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo '<script>
                Swal.fire({
                    title: "Password Already Changed!",
                    text: "You have already changed your password. Please log in.",
                    icon: "info",
                    confirmButtonText: "OK"
                }).then(() => {
                    window.location = "login.php";
                });
            </script>';
            exit();
        }else
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
            Swal.fire({
                title: "Verification Successful!",
                text: "Please change your password.",
                icon: "success",
                confirmButtonText: "OK"
            }).then(() => {
                window.location = "change_password.php?code=' . $token . '";
            });
        </script>';
        exit();
    }else {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
        Swal.fire({
            title: "Invalid or Expired Token!",
            text: "Your reset link is invalid or has expired.",
            icon: "error",
            confirmButtonText: "OK"
        }).then(() => {
            window.location = "login.php";
        });
    </script>';
    } 