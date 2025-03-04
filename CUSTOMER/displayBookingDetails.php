<?php
session_name('cust');
session_start();
include 'dbConnect.php';

if (!isset($_SESSION['USER_ID'])) {
    header("location: login.php");
    exit();
}

// Pastikan transaction_id dan hall_id ada
if (!isset($_SESSION['transaction_id']) || empty($_SESSION['transaction_id'])) {
    header("location:booking_seat.php");
    exit();
}
if (!isset($_SESSION['hall_id']) || empty($_SESSION['hall_id'])) {
    header("location:booking_seat.php");
    exit();
}


// (A) LOAD LIBRARY
require "booking-lib.php";

// echo '<pre>'; // Untuk format tampilan yang lebih rapi
// print_r($_SESSION); // Cetak seluruh isi session
// echo '</pre>';

// GET BOOKING SEAT DATA
$userid = $_SESSION['USER_ID'];
$transaction_id = $_SESSION['transaction_id'];
$hallno = $_SESSION['hall_id'];
$bookingdata = $_RSV->getseatchosen($userid, $transaction_id);

//$_SESSION['seat'] = implode(', ',$seats);

// Access individual booking details
if (!empty($bookingdata)) {
    $seatno = $bookingdata[0]['seatNo'];
    $showtime = $bookingdata[0]['showtime_start'];
    $hallno = $bookingdata[0]['hallNo'];
    $seatNo = $bookingdata[0]['seatNo'];
} else {
    // Handle the case when no booking data is found
    $seatno = "";
    $showtime = "";
    $hallno = "";
    $seatNo = "";
}

$code = "SELECT email, phoneNo from customer WHERE custid = '$userid' ";
$sql = mysqli_query($conn, $code);
$row = mysqli_fetch_assoc($sql);


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEN | Booking</title>

    <!-- ::::::::::::::Icon Tab::::::::::::::-->
    <link rel="shortcut icon" href="assets/images/logo/ten-icon.png" type="image/png">
    <link rel="stylesheet" href="assets/_displaybookdetailsStyles.css" />
    <link rel="stylesheet" href="assets/toast-styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    .btncarousel {
      background: #FFB6C1;
      color: #111111;
      font-weight: bold;
    }

    .btncarousel:hover {
      background: #FF9AA2;
      color: #ffffff;
      font-weight: bold;
    }
  </style>

<script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="SB-Mid-client-kfFM5ZGr7d8tLWYs"></script>

</head>

<body>

    <section class="overflow-hidden py-5 my-3">
        <div class="d-flex justify-content-center">
            <ul>
                <li class="#"><a href="#">
                        <div class="icon">
                            <img src="./assets/images/icons/seat.png" style="background:#7a7777;">
                        </div>
                        <p>Choose Seat</p>
                    </a></li>
                <li class="active"><a href="#">
                        <div class="icon">
                            <img src="./assets/images/icons/receipt.gif">
                        </div>
                        <p>Invoice</p>
                    </a></li>
            </ul>
        </div>

        <div class="table-responsive-sm container overflow-hidden text-center">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td scope="row">Theater</td>
                        <td>TEN Cinema - KTCC Mall</td>
                    </tr>
                    <tr>
                        <td scope="row">Hall No.</td>
                        <td><?php echo $hallno ?></td>
                    </tr>
                    <tr>
                        <td scope="row">Date</td>
                        <td>
                            <?php
                            $datestart = $showtime;
                            $date = new DateTime($datestart);
                            $formattedDate = $date->format('d M Y');

                            echo $formattedDate;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">Showtime</td>
                        <td>
                            <?php
                            $timestart = $showtime;
                            $time = new DateTime($timestart);
                            $formattedtime = $time->format('H:i a');

                            echo $formattedtime;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">Seats Chosen</td>
                        <td>
                            <?php
                            $seats = array_column($bookingdata, 'seatNo');
                             echo implode(', ', $seats);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">Amount</td>
                        <td>Rp. <?php echo count($seats) * 40000; ?></td>
                        
                    </tr>
                </tbody>
            </table>
           <button id="pay-button" class="btn btn-primary btn-lg mt-2 btncarousel">Pay</button>
           <br>
           <button id="cancel-button" class="btn btn-primary btn-lg mt-2 btncarousel">Cancel</button>

           <p>Time Remaining : <span id="countdown">10:00</span></p>

           <!-- Loader -->
        <div id="loadingOverlay">
            <div class="spinner"></div>
        </div>

        <script>
            let timerInterval;
            let remainingTime;
            const TOTAL_TIME = 600000; // 10 menit dalam milidetik

            function startTimer() {
                clearInterval(timerInterval);
                let expiryTime = localStorage.getItem('expiryTime');

                if (!expiryTime) {
                    expiryTime = Date.now() + TOTAL_TIME; // Mulai dari awal
                    localStorage.setItem('expiryTime', expiryTime);
                }

                timerInterval = setInterval(() => {
                    let currentTime = Date.now();
                    remainingTime = expiryTime - currentTime;

                    if (remainingTime <= 0) {
                clearInterval(timerInterval);
                localStorage.removeItem('expiryTime');
                Swal.fire({
                    title: "Session Expired!",
                    text: "Please place your order again.",
                    icon: "error",
                    confirmButtonText: "OK"
                }).then(() => {
                    window.location.href = "index.php"; // Redirect to home page
                });
            }

                    updateCountdownDisplay(remainingTime);
                }, 1000);
            }

            function updateCountdownDisplay(time) {
                let minutes = Math.floor(time / 60000);
                let seconds = Math.floor((time % 60000) / 1000);
                document.getElementById("countdown").innerText =
                    `${minutes}:${seconds.toString().padStart(2, '0')}`;
            }

            // **Saat halaman dimuat, timer mulai dari awal**
            document.addEventListener("DOMContentLoaded", function () {
                localStorage.removeItem('expiryTime'); // Hapus timer sebelumnya
                startTimer();
            });

            // **Hapus timer saat user keluar dari halaman**
            window.addEventListener("beforeunload", function () {
                localStorage.removeItem('expiryTime');
            });

             // Fungsi konfirmasi sebelum cancel
    document.getElementById('cancel-button').addEventListener('click', function () {
        Swal.fire({
            title: "Cancel Order?",
            text: "Your order will be canceled and cannot be recovered.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, Cancel",
            cancelButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {
                localStorage.removeItem('expiryTime'); // Hapus timer
                Swal.fire({
                    title: "Canceled!",
                    text: "Your order has been canceled.",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() => {
                    window.location.href = "index.php"; // Redirect ke halaman awal
                });
            }
        });
    });

            //pay-button function
            document.getElementById('pay-button').addEventListener('click', function () {
                pauseTimer();

            let seatData = "<?php echo implode(', ', $seats); ?>";
            let username = "<?php echo $_SESSION['USER_NAME'] ?? 'Guest'; ?>";
            let email = "<?php echo $row['email'] ?>"; 
            let phoneNo = "<?php echo $row['phoneNo'] ?>"; 

//    setTimeout(() => {
//     alert("Sedang mengambil token pembayaran...");
// }, 100); 

    fetch('midtrans_token.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            seat: seatData,
            username: username,
            email: email,
            phoneNum: phoneNo
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data); // Debugging

        if (data.token) {
    window.snap.pay(data.token, {
        onSuccess: function (result) {
            clearTimer();
           
            Swal.fire({
                title: "Payment Successful!",
                html: `<p>Your order has been confirmed.</p>
                         <p style="font-size: 14px; color: gray;">Please wait while we process your order. <br> Once done, please check your email.</p>`,
                icon: "success",
                confirmButtonText: "OK",
                backdrop: true // Pastikan backdrop aktif untuk mencegah tumpang tindih
            }).then(() => {
                
                location.replace("bookingSuccess.php?order_id=" + result.order_id);
            });
        },
        onPending: function (result) {
            Swal.fire({
                title: "Payment Processing!",
                text: "Your payment is being processed. Please wait.",
                icon: "info",
                confirmButtonText: "OK"
            });
        },
        onError: function (result) {
            clearTimer();
            Swal.fire({
                title: "Payment Failed!",
                text: "Your payment could not be processed. Please try again.",
                icon: "error",
                confirmButtonText: "OK"
            });
        },
        onClose: function () {
            resumeTimer();
            Swal.fire({
                title: "Payment Incomplete!",
                text: "You closed the payment window before completing the transaction.",
                icon: "warning",
                confirmButtonText: "OK"
            });
        }
    });
} else {
    Swal.fire({
        title: "Error!",
        text: "Failed to retrieve payment token.",
        icon: "error",
        confirmButtonText: "OK"
    });
}
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Terjadi kesalahan saat menghubungi server!");
    });
});

function pauseTimer() {
        clearInterval(timerInterval);
        localStorage.setItem('expiryTime', Date.now() + remainingTime);
    }

    function resumeTimer() {
        let expiryTime = Date.now() + remainingTime;
        localStorage.setItem('expiryTime', expiryTime);
        startTimer();
    }

    function clearTimer() {
        clearInterval(timerInterval);
        localStorage.removeItem('expiryTime');
        document.getElementById("countdown").innerText = "00:00";
    }
</script>

        </div>
    </section>

    <!-- Include the jQuery library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Include the Bootstrap JavaScript library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js"></script>

     <?php

$_SESSION['seat'] = implode(', ',$seats);

    ?>


</body>

</html>
