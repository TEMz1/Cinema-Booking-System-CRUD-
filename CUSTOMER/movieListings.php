<?php
define('APP_ACCESS', true);
?>

<?php
session_name('cust');
session_start();
include 'dbConnect.php';

// if (!isset($_SESSION['USER_ID'])) {
//     header("location:login.php");
//     exit();
// }


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
?>
 <?php

    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEN | Movies</title>
    <!-- ::::::::::::::Icon Tab::::::::::::::-->
    <link rel="shortcut icon" href="assets/images/logo/ten-logo.png" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/_navbarStyles.css" />
    <link rel="stylesheet" href="assets/_footerStyles.css" />
    <link rel="stylesheet" href="assets/_movieListStyles.css" />
  
</head>

<body>
    <!-- HEADER SECTION -->
    <?php include('header.php') ?>

    <div class="container mb-5">

        <h1 class="heading">List of Movies</h1>
        <div class="gallery">
            <?php
            $query = "SELECT * FROM movie ORDER BY movieid ASC";
            $result = mysqli_query($conn, $query);

            if ($result) {
                foreach ($result as $row) {

            ?>
                    <div class="gallery-item">
                        <a href="moviedetails.php?movieid=<?php echo $row["movieid"] ?>">
                            <img class="gallery-image" src="../ADMIN/assets/images/movie_poster/<?php echo $row["poster"]; ?>" alt="Movie Poster">
                        </a>
                    </div>
            <?php
                }
            }

            ?>

        </div>
    </div>

    <!-- FOOTER SECTION -->
    <?php include('footer.php') ?>


</body>

</html>