<?php
define('APP_ACCESS', true);
?>

<?php
session_name('cust');
session_start();
include 'dbConnect.php';


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

if (!empty($_SESSION)) {
    // Simpan hanya USER_ID dan username
    $userId = $_SESSION['USER_ID'] ?? null;
    $username = $_SESSION['USER_NAME'] ?? null;

    // Hapus semua data sesi
    session_unset();

    // Kembalikan USER_ID dan username ke sesi
    if ($userId !== null) {
        $_SESSION['USER_ID'] = $userId;
    }
    if ($username !== null) {
        $_SESSION['USER_NAME'] = $username;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEN Cinema - Finest Online Cinema throughout Indonesia</title>
    <!-- ::::::::::::::Icon Tab::::::::::::::-->
    <link rel="shortcut icon" href="assets/images/logo/ten-icon.png" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/_homeStyles.css" />
    <link rel="stylesheet" href="assets/_navbarStyles.css" />
    <link rel="stylesheet" href="assets/_footerStyles.css" />
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="assets/swiper-bundle.min.css" />
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
    <!-- HEADER SECTION -->
    <?php include('header.php') ?>

    <!-- CAROUSEL SECTION -->
    <section class="main swiper mySwiper">
        <div class="wrapper swiper-wrapper">
            <div class="slide swiper-slide">
                <img src="assets/images/carousel/1kakak_hori.png" alt="" class="image" />
                <div class="image-data">
                    <div class="container">
                        <img style="width:auto;height:200px;padding:0;" src="assets/images/carousel/1kakak7_logo.png" alt="" class="image" />
                    </div>
                    <h2>Coming Soon</h2>
                    <?php
                    $query = "SELECT movieid FROM movie WHERE movieId = 40";
                    $result = mysqli_query($conn, $query);

                    if ($result && $row = mysqli_fetch_assoc($result)) {
                        $movieId = $row["movieid"];
                        echo '<a href="moviedetails.php?movieid=' . $movieId . '" class="button">Learn more</a>';
                    }
                    ?>
                </div>
            </div>
            <div class="slide swiper-slide">
                <img src="assets/images/carousel/1imam-hori.jpeg" alt="" class="image" />
                <div class="image-data">
                    <div class="container">
                        <img style="width:418.3px;height:200px;padding:0;" src="assets/images/carousel/1imam-logo.png" alt="" class="image" />
                    </div>
                    <h2>Coming Soon</h2>
                    <?php
                    $query = "SELECT movieid FROM movie WHERE movieId = 42";
                    $result = mysqli_query($conn, $query);

                    if ($result && $row = mysqli_fetch_assoc($result)) {
                        $movieId = $row["movieid"];
                        echo '<a href="moviedetails.php?movieid=' . $movieId . '" class="opp-button">Learn more</a>';
                    }
                    ?>
                </div>
            </div>
            <div class="slide swiper-slide">
                <img src="assets/images/carousel/matirasa_hori.png" alt="" class="image" />
                <div class="image-data">
                    <div class="container">
                        <img style="width:auto;height:200px;padding:0;" src="assets/images/carousel/mati-rasalogo.png" alt="" class="image" />
                    </div>
                    <h2>Coming Soon</h2>
                    <?php
                    $query = "SELECT movieid FROM movie WHERE movieId = 44";
                    $result = mysqli_query($conn, $query);

                    if ($result && $row = mysqli_fetch_assoc($result)) {
                        $movieId = $row["movieid"];
                        echo '<a href="moviedetails.php?movieid=' . $movieId . '" class="dune-button">Learn more</a>';
                    }
                    ?>
                </div>
            </div>
            <div class="slide swiper-slide">
                <img src="assets/images/carousel/2ndmiracle_hori.png" alt="" class="image" />
                <div class="image-data">
                    <div class="container">
                        <img style="width:auto;height:200px;padding:0;" src="assets/images/carousel/2ndmiracle.png" alt="" class="image" />
                    </div>
                    <h2>Trending</h2>
                    <?php
                    $query = "SELECT movieid FROM movie WHERE movieId = 32";
                    $result = mysqli_query($conn, $query);

                    if ($result && $row = mysqli_fetch_assoc($result)) {
                        $movieId = $row["movieid"];
                        echo '<a href="moviedetails.php?movieid=' . $movieId . '" class="bat-button">Learn more</a>';
                    }

                    ?>
                </div>
            </div>
            <div class="slide swiper-slide">
                <img src="assets/images/carousel/poster-bioskopp.jpg" alt="" class="image" />
                <div class="image-data">
                </div>
            </div>
        </div>

        <div class="swiper-button-next nav-btn"></div>
        <div class="swiper-button-prev nav-btn"></div>
        <div class="swiper-pagination"></div>
    </section>


    <!-- CAROUSEL MOVIE LISTS -->
    <section class="overflow-hidden py-5 my-3">
        <div class="container">
            <div class="row">
                <div class="my-3 py-3" style="padding: 0px;">
                    <h1 style="color: #ffffff; padding: 0;" class="mb-4">Showtimes</h1>
                    <button class="btn btn-outline btncarousel" onclick="changeCarousel('literally-me')">"Indonesia"</button>
                    <button class="btn btn-outline btncarousel" onclick="changeCarousel('now-showing')">Now Showing</button>
                    <button class="btn btn-outline btncarousel" onclick="changeCarousel('top-selling')">Trending</button>
                    <button class="btn btn-outline btncarousel" onclick="changeCarousel('coming-soon')">Coming Soon</button>
                </div>
            </div>
            <div class="row">
                <div class="wrapper-alt">
                    <i id="left" class="fa fa-arrow-left" aria-hidden="true"></i>
                    <div class="carousel">
                        <?php
                        $type = isset($_GET['type']) ? $_GET['type'] : '';

                        // Default query if no button type is specified
                        $query = "SELECT movieid, poster, MIN(showtime_start) AS showtime_start, showtime_end
                        FROM movie
                        LEFT JOIN sessions USING (movieid)";

                        // Modify the SQL query based on the button type
                        if ($type === 'literally-me') {
                            $query .= " WHERE language = 'IDN'";
                        } elseif ($type === 'now-showing') {
                            $query .= " WHERE DATE(showtime_start) = CURDATE()";
                        } elseif ($type === 'top-selling') {
                            $query .= " WHERE movieid IN (32, 33, 43, 39)";
                        } elseif ($type === 'coming-soon') {
                            $query .= " WHERE DATE(releaseDate) > CURDATE()";
                        }

                        $query .= " GROUP BY movieid ORDER BY movieid";

                        $result = mysqli_query($conn, $query);

                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                <a href="moviedetails.php?movieid=<?php echo $row["movieid"]; ?>">
                                    <img style="width: 240px; height: 340px; margin-right: 14px;" src="../ADMIN/assets/images/movie_poster/<?php echo $row["poster"]; ?>" alt="img" draggable="false">
                                </a>
                        <?php
                            }
                        }
                        // Close the database connection
                        mysqli_close($conn);
                        ?>
                    </div>
                    <i id="right" class="fa fa-arrow-right" aria-hidden="true"></i>
                </div>
            </div>
        </div>
    </section>



    <!-- FOOTER SECTION -->
    <?php include('footer.php') ?>


    <!-- Swiper JS -->
    <script src="javascript/swiper-bundle.min.js"></script>
    <script src="javascript/carouseleff.js"></script>
    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            loop: true,
            effect: "fade", // Add the fade effect
            speed: 1000, // Set the transition speed (in milliseconds)
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            autoplay: {
                delay: 5000, // Time in milliseconds before the next slide is shown
                disableOnInteraction: true, // Enable autoplay even when user interacts with the slides
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    </script>

</body>

</html>