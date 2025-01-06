<?php
// (A) LOAD LIBRARY
require "booking-lib.php";

// (B) SAVE
$_RSV->save($_POST["sessid"], $_POST["userid"], $_POST["hallno"],$_POST["seats"],$_POST["transaction"]);

session_start();
$_SESSION['hall_id'] = $_POST["hallno"]; // Menyimpan hall ID
$_SESSION['transaction_id'] = $_POST["transaction"]; // Menyimpan transaction ID

// (D) REDIRECT KE HALAMAN DETAIL
header("location: displayBookingDetails.php");
exit();
