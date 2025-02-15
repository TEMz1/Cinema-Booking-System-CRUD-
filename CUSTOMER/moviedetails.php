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

if (!isset($_GET['movieid']) || empty($_GET['movieid'])) {
    header("location:index.php"); // Redirect to home if no movie ID
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
        $_SESSION['USER_NAME']= $username;
    }
}

$movieID = $_GET["movieid"];
$query = "SELECT * FROM movie where movieid = '$movieID'"; // display specific movie based on movieid
$result = mysqli_query($conn, $query);

$query02 = "SELECT * FROM sessions  where movieid = '$movieID' ORDER BY showtime_start ASC";
$result02 = mysqli_query($conn, $query02);

$query03 = "SELECT * FROM sessions LEFT JOIN seat USING (hallNo)  where movieid = '$movieID' ORDER BY showtime_start ASC";
$result03 = mysqli_query($conn, $query02);

function getTrailerLinkFromDatabase($conn, $movieID)
{
    $query = "SELECT trailer FROM movie WHERE movieid = '$movieID'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $trailerLink = $row["trailer"];

        // Extract the video ID from the YouTube URL
        $videoID = '';
        parse_str(parse_url($trailerLink, PHP_URL_QUERY), $videoID);
        $videoID = $videoID['v'] ?? '';

        if (!empty($videoID)) {
            // Construct the embed URL
            $embedURL = "https://www.youtube.com/embed/" . $videoID;
            return $embedURL;
        }
    }

    return "https://www.example.com/default-trailer";
}
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/_navbarStyles.css" />
    <link rel="stylesheet" href="assets/movie-detail.css" />
    <link rel="stylesheet" href="assets/_footerStyles.css" />
    
    
</head>

<body>
    <!-- HEADER SECTION -->
    <?php include('header.php') 
    ?>

    <?php


    if ($result) {
        foreach ($result as $row) {

    ?>
            <section id="first-section" class="overflow-hidden py-5 mb-3">
                <div class="container overflow-hidden text-center">
                    <div class="row">
                        <div class="col-12 col-lg-3 px-4 text-center">
                            <img style="width:200px;height:300px;" class="gallery-image" src="../ADMIN/assets/images/movie_poster/<?php echo $row["poster"]; ?>" alt="Movie Poster">
                        </div>
                        <div class="col-12 col-lg-9">
                            <h1 class="fw-bold font-xxl mb-0"><?php echo $row["title"] ?></h1>
                            <ul class="row px-0">
                                <li class="col-12 col-sm-6 twi twi-xs twi-date mt-0">
                                    <?php
                                      $oldDate = $row["releaseDate"]; // Nilai dari basis data, misalnya: 2024-08-15
                                      $newDate = DateTime::createFromFormat('Y-m-d', $oldDate); // Format yang sesuai dengan DB
                                      $formattedDate = $newDate->format('d M Y'); // Contoh hasil: 15 Aug 2024
                                      ?>
                                      <strong>Release Date</strong>: <?php echo $formattedDate ?>
                                </li>
                                <li class="col-12 col-sm-6 twi twi-xs twi-date mt-0">
                                    <strong>Language</strong>: <?php echo $row["language"] ?>
                                </li>
                                <li class="col-12 col-sm-6 twi twi-xs twi-date mt-0">
                                    <strong>Running Time</strong>: <?php echo  $row["duration"] ?>
                                </li>
                                <li class="col-12 col-sm-6 twi twi-xs twi-date mt-0">
                                    <strong>Subtitles</strong>: ID
                                </li>
                                <li class="col-12 col-sm-6 twi twi-xs twi-date mt-0">
                                    <strong>Genre</strong>: <?php echo  $row["genre"] ?>
                                </li>
                            </ul>
                            <div class="mt-3">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <div align="left"><strong>Synopsis</strong></div>
                                        <p><?php echo $row["description"]; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-play-circle-fill iconn" style="font-size: 2rem;"></i>
                                        <span class="watch-trailer ml-2" style="padding: 5px 2px; margin-left: 10px; cursor: pointer;">WATCH TRAILER</span>
                                    </div>
                                </div>
                            </div>
                            <div id="trailer-modal">
                                <div id="trailer-content">
                                    <iframe id="trailer-iframe" src="" frameborder="0" allowfullscreen></iframe>
                                </div>
                                <div id="close-trailer"></div>
                            </div>
                            <div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>

    <?php
        }
    }

    ?>

    <div id="second-section" class="overflow-hidden bg-grey py-4">
        <div class="container overflow-hidden text-center">
            <div class="row">
                <h1 class="fw-bold font-xxl mb-0 text-center">Showtimes</h1>
                <!-- Date Container -->
                <div class="date-container d-flex justify-content-center gap-2 my-3" >
                <?php
                $now = new DateTime();
                for ($i = 0; $i < 7; $i++) {
                    $currentDate = $now->format('Y-m-d');
                    $dayName = $now->format('D'); // Mendapatkan 3 huruf nama hari (e.g., Mon, Tue)
                    $displayDate = $now->format('d M');
                    $activeClass = ($i === 0) ? "active" : ""; // Default tanggal pertama sebagai aktif
                    echo "<button class='btn btn-sm btn-outline-light date-btn $activeClass' data-date='$currentDate'>$dayName, $displayDate</button>";
                    $now->modify('+1 day');
                }
                ?>
            </div>

        <!-- Showtime Container -->
        <div class="data-container">
            <!-- Data showtime akan diisi menggunakan JavaScript -->
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Data PHP (contoh format JSON)
        const sessionData = <?php
            $sessions = [];
            if (mysqli_num_rows($result02) > 0) {
                foreach ($result02 as $row) {
                    $sessions[] = [
                        'date' => (new DateTime($row['showtime_start']))->format('Y-m-d'),
                        'time' => (new DateTime($row['showtime_start']))->format('H:i'),
                        'hall' => $row['hallNo'],
                        'session_id' => $row['session_id'],
                        'formatted_datetime' => (new DateTime($row['showtime_start']))->format('d M Y, H:i'),
                    ];
                }
            }
            echo json_encode($sessions);
        ?>;

        // Fungsi untuk mendapatkan data showtime berdasarkan tanggal
        function getShowtimeByDate(date) {
            const dataByDate = sessionData.filter(session => session.date === date);
            const groupedByHall = dataByDate.reduce((acc, session) => {
                if (!acc[session.hall]) acc[session.hall] = [];
                acc[session.hall].push(session);
                return acc;
            }, {});
            return groupedByHall;
        }

        // Fungsi untuk menampilkan data showtime ke data-container
        function renderShowtime(date) {
    const groupedShowtimes = getShowtimeByDate(date);
    const dataContainer = $(".data-container");
    dataContainer.empty();

    const now = new Date(); // Waktu saat ini

    if (Object.keys(groupedShowtimes).length > 0) {
        Object.entries(groupedShowtimes).forEach(([hall, showtimes]) => {
            const hallElement = $(`
                <div class="mt-4">
                    <h4 class="text-white ">${hall}</h4> <br>
                    <div class="d-flex flex-wrap gap-4 justify-content-center"></div>
                </div>
            `);
            const showtimeContainer = hallElement.find("div");

            showtimes.forEach(showtime => {
                const showtimeDate = new Date(`${showtime.date}T${showtime.time}`);
                const diffMinutes = (showtimeDate - now) / (1000 * 60); // Selisih waktu dalam menit

                // Tentukan kelas dan atribut berdasarkan waktu
                const isDisabled = diffMinutes <= -10; // Jika sudah lebih dari 10 menit dari showtime
                const btnClass = isDisabled ? 'btn-secondary disabled' : 'showtime-btn';
                const btnAttributes = isDisabled ? 'style="pointer-events: none;"' : '';

                const showtimeButton = `
                    <a href="booking_seat.php?SESS_ID=${showtime.session_id}&HALL_ID=${showtime.hall}&SESS_SHOW=${showtime.formatted_datetime}"
                       class="btn ${btnClass}" ${btnAttributes}>${showtime.time}</a>
                `;
                showtimeContainer.append(showtimeButton);
            });

            dataContainer.append(hallElement);
        });
    } else {
        dataContainer.html('<p class="text-white overflow-hidden text-center mt-4">No showtimes available for this date.</p>');
    }
}
$(document).ready(function () {
    // Klik pada ikon play circle
    $(".bi-play-circle-fill").click(function () {
        // Mendapatkan link trailer dari PHP
        const trailerLink = "<?php echo getTrailerLinkFromDatabase($conn, $movieID); ?>";

        // Menampilkan modal dan iframe trailer
        $("#trailer-iframe").attr("src", trailerLink);
        $("#trailer-modal").fadeIn();
    });

    // Klik pada tulisan "WATCH TRAILER"
    $(".watch-trailer").click(function () {
        // Mendapatkan link trailer dari PHP
        const trailerLink = "<?php echo getTrailerLinkFromDatabase($conn, $movieID); ?>";

        // Menampilkan modal dan iframe trailer
        $("#trailer-iframe").attr("src", trailerLink);
        $("#trailer-modal").fadeIn();
    });

    // Klik untuk menutup trailer
    $("#trailer-modal").click(function() {
                $("#trailer-modal").fadeOut();
                $("#trailer-iframe").attr("src", "");
            });
});


        // Event klik tombol tanggal
        $(".date-btn").click(function () {
            const selectedDate = $(this).data("date");

            // Aktifkan tombol yang dipilih
            $(".date-btn").removeClass("active");
            $(this).addClass("active");

            // Render data showtime berdasarkan tanggal
            renderShowtime(selectedDate);
        });

        // Pilih tanggal pertama secara default
        $(".date-btn.active").trigger("click");
    });
</script>

    <!-- Bootstrap JS -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js"></script> -->
    <?php
    // Close the database connection
    mysqli_close($conn);
    ?>
    <br> <br>
</body>
<?php
include 'footer.php';
?>
<style>

    </style>
</html>