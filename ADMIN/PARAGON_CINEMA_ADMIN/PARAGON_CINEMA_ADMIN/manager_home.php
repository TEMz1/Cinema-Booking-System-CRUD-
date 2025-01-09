<?php
 // validate
 define('APP_ACCESS', true);
 session_name('admin_session');
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Manager') {
    header("Location: index.php");
    exit();
}

$hostname = "localhost";
$username = "root";
$dbname = "paragoncinemadb";
			
$connect = mysqli_connect($hostname, $username) OR DIE ("Connection failed!");
$selectdb = mysqli_select_db($connect, $dbname) OR DIE ("Database cannot be accessed");
			
$username = $_SESSION["username"];
			
$sql = "SELECT * FROM manager WHERE username = '$username' ";  
	
$sendsql = mysqli_query($connect, $sql) OR DIE("CONNECTION ERROR");	
			
$row = mysqli_fetch_assoc($sendsql)		

?>
<!DOCTYPE html>
<html>
	<head>
		<title>MANAGER | PARAGON</title>
        <link rel="shortcut icon" href="img/ten-logo.png" type="image/png">
	</head>
	
	<?php include "manager_sidenav.php"; ?>
    <body>
        <div class="container">
			<h1>Welcome</h1>
			<?php
				echo "<h2>". $row["name"] . "</h2>";
			?>
			<h2>To the Paragon Manager Management</h2>
			<br>
		</div>
    </body>

	<style>
		body {
        background-color: #F9F0FF;
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
    }

    .container {
        margin: 50px;
        text-align: center;
        background-color: #FFF3FB;
        color: #333333;
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    h1 {
        font-size: 50px;
        font-weight: bold;
        color: #BF0885;
        background-color: #FFE6FF;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    h2 {
        font-size: 24px;
        font-weight: normal;
        color: #BF0885;
        margin: 15px 0;
    }

    @media (max-width: 768px) {
        h1 {
            font-size: 36px;
        }

        h2 {
            font-size: 18px;
        }

        .container {
            padding: 20px;
        }
    }
	</style>
</html>