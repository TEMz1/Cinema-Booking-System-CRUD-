<?php
    session_name('admin_session');
    session_start();

    if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Clerk') {
        header("Location: login.php");
        exit();
    }

    include 'dbConnect.php';

    $username = $_SESSION["username"];

    $sql = "SELECT * FROM clerk WHERE username = '$username' ";

    $sendsql = mysqli_query($conn, $sql) OR DIE("CONNECTION ERROR");

    $row = mysqli_fetch_assoc($sendsql);

    // Check if the form is submitted
    if (isset($_POST["add"])) {
        // Get the movie data from the form
        $hallNo = $_POST["hallNo"];
        $hallName = $_POST["hallName"];
        
        // Insert the movie data into the database
        $insertSql = "INSERT INTO hall (hallNo, hallName) VALUES ('$hallNo', '$hallName')";

        $result = mysqli_query($conn, $insertSql);

        if ($result) {
            // Automatically insert seat data for the new hall
            $insertSeatSql = "INSERT INTO seats (seatNo, hallNo) 
                                VALUES ('A1', '$hallNo'), ('A2', '$hallNo'), ('A3', '$hallNo'), ('A4', '$hallNo'), ('A5', '$hallNo'), ('A6', '$hallNo'), 
                                ('B1', '$hallNo'), ('B2', '$hallNo'), ('B3', '$hallNo'), ('B4', '$hallNo'), ('B5', '$hallNo'), ('B6', '$hallNo'), 
                                ('C1', '$hallNo'), ('C2', '$hallNo'), ('C3', '$hallNo'), ('C4', '$hallNo'), ('C5', '$hallNo'), ('C6', '$hallNo'), 
                                ('D1', '$hallNo'), ('D2', '$hallNo'), ('D3', '$hallNo'), ('D4', '$hallNo'), ('D5', '$hallNo'), ('D6', '$hallNo'), 
                                ('E1', '$hallNo'), ('E2', '$hallNo'), ('E3', '$hallNo'), ('E4', '$hallNo'), ('E5', '$hallNo'), ('E6', '$hallNo'), 
                                ('F1', '$hallNo'), ('F2', '$hallNo'), ('F3', '$hallNo'), ('F4', '$hallNo'), ('F5', '$hallNo'), ('F6', '$hallNo'), 
                                ('G1', '$hallNo'), ('G2', '$hallNo'), ('G3', '$hallNo'), ('G4', '$hallNo'), ('G5', '$hallNo'), ('G6', '$hallNo'),
                                ('H1', '$hallNo'), ('H2', '$hallNo'), ('H3', '$hallNo'), ('H4', '$hallNo'), ('H5', '$hallNo'), ('H6', '$hallNo')";
            $resultSeat = mysqli_query($conn, $insertSeatSql);
        
            if ($resultSeat) {
                ?><script>
                    alert("Data has been added");
                    window.location = "hall.php";
                </script><?php
                exit();
            } else {
                echo "Error inserting seat data: " . mysqli_error($conn);
            }
        } else {
            echo "Error adding new hall: " . mysqli_error($conn);
        }
        
    }
?>
<!DOCTYPE html>
<html>
	<head>
		<title>CLERK | TEN</title>
        <link rel="shortcut icon" href="img/ten-icon.png" type="image/png">
	</head>
	    <body>
            <div class="container">
                <h1> Add New Hall </h1>

                <form action="" method="POST">
                    <input type="text" name="hallNo" placeholder="Hall Number" required/><br/>
                    <input type="text" name="hallName" placeholder="Hall Name" required/><br/>
                    
                    <br>
                    <input type="submit" name="add" value="ADD"/>
                </form>
            </div>
	    </body>

	<style>
		body {
    background-color: #F4E1FF; /* Soft pastel purple background for a more calming feel */
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.container {
    background-color: #FFFFFF; /* White background for the form container for better contrast */
    margin: 50px auto;
    padding: 40px;
    width: 60%;
    text-align: center;
    color: #333;
    border-radius: 15px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
}

h1 {
    font-size: 48px;
    color: #BF0885; /* Bold pink color for headings */
    margin: 0;
    padding: 20px 0;
    font-family: 'Poppins', sans-serif;
    background-color: #FFE6F0; /* Very light pink background for the header */
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

form {
    margin-top: 20px;
}

input {
    width: 80%; /* Makes the input fields wider */
    padding: 12px;
    font-size: 16px;
    border-radius: 5px;
    border: 1px solid #D1D1D1;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
    margin: 15px 0;
}

input[type="submit"] {
    background-color: #BF0885; /* Strong pink color for the button */
    color: white;
    font-size: 18px;
    padding: 12px 24px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #a60471; /* Slightly darker pink on hover for interactive feel */
}

@media (max-width: 768px) {
    .container {
        width: 80%; /* Makes the container adapt better on smaller screens */
        padding: 20px;
    }

    h1 {
        font-size: 40px;
    }

    input {
        width: 100%; /* Makes input fields full width on smaller screens */
    }
}

	</style>
</html>
