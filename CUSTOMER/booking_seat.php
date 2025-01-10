<?php
session_name('cust');
session_start();
include 'dbConnect.php';

if (!isset($_SESSION['USER_ID'])) {
  header("location: login.php");
  exit();
}

if (!isset($_GET['SESS_ID']) || empty($_GET['SESS_ID']) || !isset($_GET['HALL_ID']) || empty($_GET['HALL_ID'])) {
  header("location:moviedetails.php"); // Redirect to movie details if parameters are invalid
  exit();
}


$_SESSION['SHOWTIME'] = $_GET['SESS_SHOW'];
$hallno = $_GET["HALL_ID"];
$sessid = $_GET["SESS_ID"];
$userid = $_SESSION['USER_ID'];
$_SESSION['SESS_ID'] = $sessid;

// Buat Transaction ID unik untuk sesi ini
if (!isset($_SESSION['transaction_id'])) {
  $_SESSION['transaction_id'] = uniqid("TRANS_", true); // Contoh: TRANS_5ff4e8d132fdc
}
$transaction_id = $_SESSION['transaction_id']; // Ambil ID dari sesi

// Validasi session
if (isset($_SESSION['hall_id']) && isset($_SESSION['transaction_id'])) {
  $hall_no = $_SESSION['hall_id'];           // Ambil dari session
  $transaction_id = $_SESSION['transaction_id']; // Ambil dari session

 // Query untuk menghapus data
 $sql = "DELETE FROM bookings WHERE transaction_id = ? AND hallNo = ?";
 $stmt = mysqli_prepare($conn, $sql);

 if ($stmt) {
     // Bind parameter
     mysqli_stmt_bind_param($stmt, "ss", $transaction_id, $hall_no);

     // Eksekusi query
     mysqli_stmt_execute($stmt);
 }
  // Hapus session terkait (Opsional)
  unset($_SESSION['hall_id']);
  unset($_SESSION['transaction_id']);
}

// (B) GET SESSION SEATS
require "booking-lib.php";
$seats = $_RSV->get($sessid);

?>
<!DOCTYPE html>
<html>

<head>
  <title>TEN | Booking</title>
  <meta charset="utf-8">

  <!-- ::::::::::::::Icon Tab::::::::::::::-->
  <link rel="shortcut icon" href="assets/images/logo/ten-logo.png" type="image/png">
  <link rel="stylesheet" href="assets/_seatLayoutStyles.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="javascript/booking.js"></script>
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
    <div class="container overflow-hidden text-center">
      <div class="d-flex justify-content-center">
        <ul class="ulli">
          <li class="active"><a href="#">
              <div class="icon">
                <img src="./assets/images/icons/seat.gif" style="background:#7a7777;">
              </div>
              <p>Choose Seat</p>
            </a></li>
          <li class="#"><a href="#">
              <div class="icon">
                <img src="./assets/images/icons/receipt.png">
              </div>
              <p>Invoice</p>
            </a></li>
        </ul>

      </div>
      <!-- (A) SCREEN -->
      <div class="mb-3 screen"></div>

      <div class="row">
        <!-- (B) DRAW SEATS LAYOUT -->
        <div id="layout">
          <?php
          foreach ($seats as $s) {
            $taken = !empty($s["bookedSeats"]);
            printf(
              "<div class='seat%s'%s>%s</div>",
              $taken ? " taken" : "",
              $taken ? "" : " onclick='reserve.toggle(this)'",
              $s["seatNo"]
            );
          }
          ?>
        </div>
      </div>


      <ul class="showcase">
        <li>
          <div class="seat"></div>
          <small>Available</small>
        </li>
        <li>
          <div class="seat selected"></div>
          <small>Selected</small>
        </li>
        <li>
          <div class="seat taken"></div>
          <small>Taken</small>
        </li>
      </ul>

      <!-- (D) SAVE SELECTION -->
      <form id="ninja" method="post" action="save.php">
        <input type="hidden" name="sessid" value="<?= $sessid ?>">
        <input type="hidden" name="userid" value="<?= $userid ?>">
        <input type="hidden" name="hallno" value="<?= $hallno ?>">
        <input type="hidden" name="transaction" value="<?= $transaction_id ?>">
      </form>
      <button class="btn btn-outline btn-lg mt-3 btncarousel" id="go" onclick="reserve.save()">Book</button>

    </div>


  </section>


</body>

</html>