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

    // Fetch available halls from the database
    $hallSql = "SELECT * FROM hall";
    $hallResult = mysqli_query($connect, $hallSql);

    // Fetch available movies from the database
    $movieSql = "SELECT * FROM movie";
    $movieResult = mysqli_query($connect, $movieSql);
    
    if (isset($_POST["add"])) {
        $hallNo = $_POST["hallNo"];
        $movieid = $_POST["movieid"];
        $showtime_start = $_POST["showtime_start"];
        $showtime_end = $_POST["showtime_end"];

        $insertSql = "INSERT INTO sessions (hallNo, movieid, showtime_start, showtime_end) VALUES ('$hallNo', '$movieid', '$showtime_start', '$showtime_end')";

        $result = mysqli_query($connect, $insertSql);

        if ($result) {
            ?><script>
                alert("Data has been added");
                window.location = "session.php";
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
        <title>CLERK | TEN</title>
        <link rel="shortcut icon" href="img/ten-logo.png" type="image/png">
    </head>
    <body>
        <div class="container">
            <h1> Add New Session </h1>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="hallNo"></label>
                    <select name="hallNo" required>
                        <option value="">Select Hall</option>
                        <?php while ($hallRow = mysqli_fetch_assoc($hallResult)) { ?>
                            <option value="<?php echo $hallRow['hallNo']; ?>"><?php echo $hallRow['hallNo']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="movieid"></label>
                    <select name="movieid" required>
                        <option value="">Select Movie</option>
                        <?php while ($movieRow = mysqli_fetch_assoc($movieResult)) { ?>
                            <option value="<?php echo $movieRow['movieid']; ?>"><?php echo $movieRow['title']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                <label for="showtime_start">Showtime Start</label>
                <input type="datetime-local" name="showtime_start" id="showtime_start" required>
                </div>

                <div class="form-group">
                <label for="showtime_end">Showtime End</label>
                <input type="datetime-local" name="showtime_end" id="showtime_end" required>
                </div>

                <br>
                <input type="submit" name="add" value="ADD"/>
            </form>
        </div>
    </body> 

    <style>
		body {
    background-color: #F9F0FF; /* Soft, pastel pink for the body background */
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.container {
    background-color: #FFF3FB; /* Lighter pastel pink for the container */
    margin: 50px auto;
    padding: 40px;
    text-align: center;
    color: #333;
    border-radius: 20px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    width: 60%;
}

input[type="datetime-local"]::placeholder {
    font-size: 16px;
    color: #BF0885; /* Warna teks placeholder */
    font-style: italic;
}

h1 {
    font-size: 48px;
    color: #BF0885; /* Bold, eye-catching pink for the header */
    background-color: #FFE6FF; /* Very light pastel pink background for the heading */
    padding: 20px;
    border-radius: 12px;
    margin: 0;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    font-family: Poppins, sans-serif;
}

form {
    margin-top: 20px;
}

.form-group {
    display: flex;
    flex-direction: column; /* Ubah dari row ke column untuk lebih rapi */
    align-items: center; /* Pusatkan elemen secara horizontal */
    justify-content: center; /* Pusatkan elemen secara vertikal */
    margin-bottom: 15px;
    text-align: center; /* Tambahkan agar teks di tengah */
}

.form-group label {
    width: 150px;
    text-align: right;
    margin-right: 10px;
    font-size: 18px;
    color: #BF0885;
}

.form-group select, .form-group input {
    width: 270px; /* Inputs are resized for better alignment */
    padding: 12px;
    font-size: 16px;
    border-radius: 5px;
    border: 1px solid #D1D1D1;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
    margin: 12px 0;
}

.form-group select {
    width: 300px; /* Widen the select dropdown for better UX */
}

input[type="submit"] {
    background-color: #BF0885; /* Bold pink for the button */
    color: white;
    font-size: 18px;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #a60471; /* Slightly darker pink on hover */
}

@media (max-width: 768px) {
    .container {
        width: 80%;
        padding: 20px;
    }

    h1 {
        font-size: 40px;
    }

    .form-group {
        flex-direction: column;
        justify-content: flex-start;
    }

    .form-group label, .form-group input, .form-group select {
        width: 80%;
    }
}

	</style>
    <script>
        document.querySelector('input[type="datetime-local"]').setAttribute('placeholder', 'yyyy-mm-ddThh:mm');

    </script>
</html>
