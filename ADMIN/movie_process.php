<?php

    

    include 'dbConnect.php';

    if (isset($_POST["update"])) {
        $movieId = mysqli_real_escape_string($conn, $_POST["movieid"]); 
        $newTitle = mysqli_real_escape_string($conn, $_POST["title"]);
        $newPoster = mysqli_real_escape_string($conn, $_POST["poster"]);
        $newGenre = mysqli_real_escape_string($conn, $_POST["genre"]);
        $newDescription = mysqli_real_escape_string($conn, $_POST["desc"]);
        $newDuration = mysqli_real_escape_string($conn, $_POST["duration"]);
        $newReleaseDate = mysqli_real_escape_string($conn, $_POST["releaseDate"]);
        $newTrailer = mysqli_real_escape_string($conn, $_POST["trailer"]);

        $updateSql = "UPDATE MOVIE SET poster = '$newPoster', title = '$newTitle', genre = '$newGenre', description = '$newDescription', duration = '$newDuration', releaseDate = '$newReleaseDate', trailer = '$newTrailer' WHERE movieid = '$movieId'";

        $result = mysqli_query($conn, $updateSql);

        if ($result) {
            ?>
            <script>
                alert("Data has been updated");
                window.location = "movie.php";
            </script><?php
            exit();
        } else {
            echo "Error updating movie data: " . mysqli_error($conn);
        }
    }
?>
