<?php

    session_name('admin_session');
    session_start();

    $hostname = "localhost";
    $username = "root";
    $dbname = "paragoncinemadb";

    $connect = mysqli_connect($hostname, $username) OR DIE("Connection failed!");
    $selectdb = mysqli_select_db($connect, $dbname) OR DIE("Database cannot be accessed");

    $username = $_SESSION["username"];

    $sql = "SELECT * FROM CLERK WHERE username = '$username' ";

    $sendsql = mysqli_query($connect, $sql) OR DIE("CONNECTION ERROR");

    $row = mysqli_fetch_assoc($sendsql);

    if (isset($_GET["hallNo"])) {
        $hallNo = $_GET["hallNo"];

        $hallQuery = "SELECT * FROM hall WHERE hallNo = '$hallNo'";
        $hallResult = mysqli_query($connect, $hallQuery);
        $hallData = mysqli_fetch_assoc($hallResult);

        if (!$hallData) {
            echo "Hall not found.";
            exit();
        }
    } else {
        header("Location: index.php");
        exit();
    }

    if (isset($_POST["update"])) {
        $newHallName = $_POST["hallName"];

        $updateSql = "UPDATE hall SET hallName = '$newHallName' WHERE hallNo = '$hallNo'";

        $result = mysqli_query($connect, $updateSql);

        if ($result) {
            ?>
            <script>
                alert("Data has been updated");
                window.location = "hall.php";
            </script><?php
            exit();
            exit();
        } else {
            echo "Error updating hall data: " . mysqli_error($connect);
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
            <h1>Edit Hall</h1>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="hallNo">Hall Number:</label>
                    <input type="text" name="hallNo" value="<?php echo $hallData["hallNo"]; ?>" readonly/>
                </div>

                <div class="form-group">
                    <label for="hallName">Hall Name:</label>
                    <input type="text" name="hallName" value="<?php echo $hallData["hallName"]; ?>" required/>
                </div>

                <br>
                <input type="submit" name="update" value="UPDATE"/>
            </form>
        </div>
    </body>

    <style>
       body {
    background-color: #F9F0FF; /* Soft, light pastel pink for the background */
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.container {
    background-color: #FFF3FB; /* Lighter shade of pink for the container */
    margin: 50px auto;
    padding: 40px;
    text-align: center;
    color: #333;
    border-radius: 20px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    width: 60%;
}

h1 {
    font-size: 48px;
    color: #BF0885; /* Rich pink for the header */
    background-color: #FFE6FF; /* Light pastel pink for the background of the heading */
    padding: 20px;
    border-radius: 12px;
    margin: 0;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    font-family: Poppins, sans-serif; /* Clean font for header */
}

form {
    margin-top: 20px;
}

.form-group {
    display: flex;
    flex-direction: row;
    align-items: center;
    margin-bottom: 15px;
    justify-content: center; /* Centers the form-group for better alignment */
}

.form-group label {
    width: 150px;
    text-align: right;
    margin-right: 10px;
    font-size: 18px;
}

.form-group input[type="text"] {
    width: 250px; /* Adjust width for form inputs */
    padding: 10px;
    font-size: 16px;
}

input, textarea {
    width: 250px;
    padding: 12px;
    border-radius: 5px;
    border: 1px solid #D1D1D1;
    margin: 12px 0;
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
    background-color: #a60471; /* Darker pink on hover */
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

    .form-group label, .form-group input {
        width: 80%;
    }
}

    </style>
</html>
