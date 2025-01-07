<?php
    session_name('admin_session');
    session_start();

    if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Manager') {
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
        $username = $_POST["username"];
        $password = $_POST["password"];
        $name = $_POST["name"];
        $icNum = $_POST["icNum"];
        $phoneNum = $_POST["phoneNum"];
        $gender = $_POST["gender"];
        $role = $_POST["role"];
        
        // Insert the movie data into the database
        $insertSql = "INSERT INTO clerk (username, password, name, icNum, phoneNum, gender, role) 
              VALUES ('$username', '$password', '$name', '$icNum', '$phoneNum', '$gender', '$role')";

        $result = mysqli_query($connect, $insertSql);

       
            if ($result) {
                ?><script>
                    alert("Data has been added");
                    window.location = "clerk.php";
                </script><?php
                exit();
            } else {
                echo "Error inserting Clerk data: " . mysqli_error($connect);
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
                <h1> Add New Clerk </h1>

                <form action="" method="POST">
                    <input type="text" name="username" placeholder="Username" required/><br/>
                    <input type="text" name="password" placeholder="Password" required/><br/>
                    <input type="text" name="name" placeholder="Name" required/><br/>
                    <input type="text" name="icNum" placeholder="icNum" required/><br/>
                    <input type="number" name="phoneNum" placeholder="phoneNum" required/><br/>
                    <input type="text" name="gender" placeholder="Gender" required/><br/>
                    <input type="text" name="role" placeholder="Role" value="Clerk" readonly/><br/>
                    
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
