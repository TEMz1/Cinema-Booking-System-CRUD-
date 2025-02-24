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
            echo "<script>alert('You have already changed your password. Please log in.'); window.location='login.php';</script>";
            exit();
        }
    
        // Jika token valid dan password belum diganti, arahkan ke halaman ubah password
        echo "<script>alert('Verification successful, please change your password!'); window.location='change_password.php?code=$token';</script>";
        exit();
    }else {
        echo "<script>alert('Token tidak valid atau sudah kadaluarsa!'); window.location='login.php';</script>";
    } 