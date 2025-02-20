<?php
session_name('cust');
session_start();
include 'dbConnect.php';

if (!isset($_SESSION['USER_ID'])) {
    header("location: login.php");
    exit();
}

// Pastikan `transaction_id` dan `hall_id` ada
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paragon | Booking</title>

    <!-- ::::::::::::::Icon Tab::::::::::::::-->
    <link rel="shortcut icon" href="assets/images/logo/paragon_logo.png" type="image/png">
    <link rel="stylesheet" href="assets/_displaybookdetailsStyles.css" />
    <link rel="stylesheet" href="assets/toast-styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                        <td>Paragon Cinema - KTCC Mall</td>
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
                        <td>RM <?php echo count($seats) * 20; ?></td>
                        
                    </tr>
                </tbody>
            </table>
            <button  class="btn btn-primary btn-lg mt-2 btncarousel" onclick="confirmBooking()">Confirm</button>
        </div>
    </section>

    <!-- Include the jQuery library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Include the Bootstrap JavaScript library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js"></script>

     <?php

$_SESSION['seat'] = implode(', ',$seats);
    ?>

    <script>
    function confirmBooking() {
        // Menampilkan notifikasi berhasil booking
        alert("Booking Successful!")
        // Redirect langsung ke bookingsuccess.php
        window.location.href = "bookingsuccess.php";
    }
</script>
</body>

</html>