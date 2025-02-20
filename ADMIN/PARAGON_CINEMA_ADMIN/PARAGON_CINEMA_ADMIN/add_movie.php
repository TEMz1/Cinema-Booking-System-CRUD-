<?php
    session_name('admin_session');
    session_start();
    
    if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Clerk') {
        header("Location: login.php");
        exit();
    }

    $hostname = "localhost";
    $username = "root";
    $dbname = "paragoncinemadb";

    $connect = mysqli_connect($hostname, $username) OR DIE ("Connection failed!");
    $selectdb = mysqli_select_db($connect, $dbname) OR DIE ("Database cannot be accessed");

    $username = $_SESSION["username"];

    $sql = "SELECT * FROM CLERK WHERE username = '$username' ";

    $sendsql = mysqli_query($connect, $sql) OR DIE("CONNECTION ERROR");

    $row = mysqli_fetch_assoc($sendsql);

    // Check if the form is submitted
    if (isset($_POST["add"])) {
        // Get the movie data from the form
        $title = $_POST["title"];
        $genre = $_POST["genre"];
        $desc = $_POST["desc"];
        $duration = $_POST["duration"];
        $releaseDate = $_POST["releaseDate"];
        $trailer = $_POST["trailer"];

        // Handle file upload
        $poster = $_FILES["poster"];
        $posterName = $poster["name"];
        $posterTmpName = $poster["tmp_name"];
        $posterError = $poster["error"];

        // Check if a file was selected
        if ($posterError === UPLOAD_ERR_OK) {
            $posterDestination = "assets/images/movie_poster/" . $posterName;
            move_uploaded_file($posterTmpName, $posterDestination);
        } else {
            echo "Error uploading poster: " . $posterError;
        }

        // Insert the movie data into the database
        $insertSql = "INSERT INTO MOVIE (title, poster, genre, description, duration, releaseDate, trailer) VALUES ('$title', '$posterName', '$genre', '$desc', '$duration', '$releaseDate', '$trailer')";

        $result = mysqli_query($connect, $insertSql);

        if ($result) {
            ?><script>
                alert("Data has been added");
                window.location = "movie.php";
            </script><?php
            exit();
        } else {
            echo "Error adding new movie: " . mysqli_error($connect);
        }
    }
?>
<!DOCTYPE html>
<html>
	<head>
		<title>CLERK | PARAGON</title>
        <link rel="shortcut icon" href="img/paragon_logo.png" type="image/png">
	</head>
	    <body>
            <div class="container">
                <h1> Add New Movie </h1>

                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="text" name="title" placeholder="Movie Title" required/><br/>
                    <input type="file" name="poster" required/><br/>
                    <input type="text" name="genre" placeholder="Movie Genre" required/><br/>
                    <textarea name="desc" placeholder="Movie Desc" required></textarea><br/>
                    <input type="text" name="duration" placeholder="Movie Duration" required/><br/>
                    <input type="date" name="releaseDate" placeholder="Release Date" required/><br/>
                    <input type="text" name="trailer" placeholder="Trailer Link" required/><br/>
                    
                    <br>
                    <input type="submit" name="add" value="ADD"/>
                </form>
            </div>
	    </body>

	<style>
		body {
    background-color: #F9F0FF; /* Soft light pink background for the page */
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.container {
    background-color: #FFF3FB; /* Light pink background for the container */
    margin: 50px auto;
    padding: 40px;
    text-align: center;
    color: #333;
    border-radius: 15px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    width: 60%;
}

h1 {
    font-size: 48px;
    color: #BF0885; /* Strong purple/pink color */
    background-color: #FFE6FF; /* Pastel pink background for the title */
    padding: 20px;
    border-radius: 10px;
    margin: 0;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

form {
    margin-top: 20px;
}

input, textarea {
    width: 250px;
    padding: 12px;
    border-radius: 5px;
    border: 1px solid #D1D1D1;
    margin: 10px 0;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
    font-size: 16px;
}

input[type="submit"] {
    background-color: #BF0885;
    color: white;
    font-size: 18px;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #a60471; /* Darker purple for hover effect */
}

textarea {
    width: 80%; /* Wider input field for description */
    resize: vertical; /* Allows the user to resize the textarea vertically */
    height: 100px;
}

@media (max-width: 768px) {
    .container {
        width: 80%;
        padding: 20px;
    }

    input, textarea {
        width: 80%; /* Adjust the width for mobile responsiveness */
    }

    h1 {
        font-size: 40px;
    }
}

	</style>
</html>
