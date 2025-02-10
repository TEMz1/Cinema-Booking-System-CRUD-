<?php
define('APP_ACCESS', true);
?>
<?php
session_name('cust');
session_start();
include 'dbConnect.php';

if (!isset($_SESSION['USER_ID'])) {
    header("location:login.php");
    exit();
}


// Jika terdapat sesi transaction_id, hapus data terkait di database
if (isset($_SESSION['transaction_id'])) {
    $transaction_id = $_SESSION['transaction_id'];

    // Hapus data di database berdasarkan transaction_id
    $query = "DELETE FROM invoice WHERE transaction_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $transaction_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

$userid = $_SESSION['USER_ID'];
$today = date('d M Y'); // Formatkan tanggal hari ini ke '09 Jan 2025'

// Query hanya untuk data pada hari ini
$query = "SELECT * FROM invoice WHERE custid = '$userid' AND date >= '$today' ORDER BY date DESC,
showtime ASC";
$result = mysqli_query($conn, $query);



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEN | View Booking</title>
    <!-- ::::::::::::::Icon Tab::::::::::::::-->
    <link rel="shortcut icon" href="assets/images/logo/ten-logo.png" type="image/png">
    <link rel="stylesheet" href="assets/_navbarStyles.css" />
    <link rel="stylesheet" href="assets/_footerStyles.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        
    /* Pastikan dropdown punya lebar yang sama dengan tombol */
.dropdown-menu {
    width: 100%; /* Agar dropdown mengikuti lebar tombol */
    min-width: unset; /* Hapus min-width default */
}

/* Biar dropdown tetap rapi dan sejajar dengan tombol */
.nav-item.dropdown {
    position: relative;
}

.dropdown-menu {
    left: 0; /* Biar dropdown melebar ke kiri */
    right: auto; /* Hapus efek melebar ke kanan */
}

       .sign-in-btn {
    background: #FFB6C1;
    color: #111111;
    font-weight: bold;
    border-radius: 5px;
    padding: 8px 20px;
  }

  .sign-in-btn:hover {
    background: #FF9AA2;
    color: #ffffff;
    font-weight: bold;
  }
    </style>
</head>

<body>

<!-- HEADER SECTION -->
<?php include('header.php') ?>

    <section class="overflow-hidden py-5 my-3">
        <div class="container overflow-hidden text-center">
            <div class="row">
            <h1 style="color:#ffffff;" class="mb-3">Booking Details</h1>
                <?php if ($result) {
                    foreach ($result as $row) { ?>

                        <div class="table-responsive-sm container overflow-hidden text-center">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td scope="row">Theater</td>
                                        <td>TEN Cinema - KTCC Mall</td>
                                    </tr>
                                    <tr>
                                        <td scope="row">Hall No.</td>
                                        <td><?php echo $row["hallNo"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td scope="row">Date</td>
                                        <td><?php echo $row["date"]; ?></td>


                                    </tr>
                                    <tr>
                                        <td scope="row">Showtime</td>
                                        <td><?php echo $row["showtime"]; ?></td>
                                        
                                    </tr>
                                    <tr>
                                        <td scope="row">Seats Chosen</td>
                                        <td><?php echo $row["chosenSeat"]; ?></td>                                                                                 
                                    </tr>
                                    <tr>
                                        <td scope="row">Amount</td>
                                        <td>Rp. <?php echo number_format($row['price'], 0, ',', '.'); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
            </div>
        </div>
<?php }
                } ?>
    </section>


  <!-- FOOTER SECTION -->
  <?php include('footer.php') ?>



</body>

</html>