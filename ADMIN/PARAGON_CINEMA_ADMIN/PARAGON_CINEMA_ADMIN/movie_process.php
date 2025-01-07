<?php
    if (!defined('APP_ACCESS')) {
        header("HTTP/1.0 403 Forbidden"); // Kirim respon 403 Forbidden
        exit(); // Hentikan eksekusi
    }
    
    session_start();

    include 'dbConnect.php';

    if (isset($_POST["update"])) {
        $movieId = $_POST["movieid"];
        $newTitle = $_POST["title"];
        $newPoster = $_POST["poster"];
        $newGenre = $_POST["genre"];
        $newDescription = $_POST["desc"];
        $newDuration = $_POST["duration"];
        $newReleaseDate = $_POST["releaseDate"];
        $newTrailer = $_POST["trailer"];

        $updateSql = "UPDATE MOVIE SET poster = '$newPoster', title = '$newTitle', genre = '$newGenre', description = '$newDescription', duration = '$newDuration', releaseDate = '$newReleaseDate', trailer = '$newTrailer' WHERE movieid = '$movieId'";

        $result = mysqli_query($connect, $updateSql);

        if ($result) {
            ?><script>
                alert("Data has been updated");
                window.location = "movie.php";
            </script><?php
            exit();
        } else {
            echo "Error updating movie data: " . mysqli_error($connect);
        }
    }
?>
