<?php
session_name('cust');
session_start();

if (!isset($_POST["sessid"], $_POST["userid"], $_POST["hallno"], $_POST["seats"], $_POST["transaction"])) {
    header("Location: index.php");
    exit();
}

// (A) LOAD LIBRARY
require "booking-lib.php";

// (B) SAVE
$_RSV->save($_POST["sessid"], $_POST["userid"], $_POST["hallno"],$_POST["seats"],$_POST["transaction"]);


$_SESSION['hall_id'] = $_POST["hallno"]; // Menyimpan hall ID
$_SESSION['transaction_id'] = $_POST["transaction"]; // Menyimpan transaction ID

// (D) REDIRECT KE HALAMAN DETAIL
header("location: displayBookingDetails.php");
exit();
