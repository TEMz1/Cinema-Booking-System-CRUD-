<?php
define('APP_ACCESS', true);
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
			<h1>Booking Details</h1>

			<?php
				$hostname = "localhost";
				$username = "root";
				$password = "";
				$dbname = "paragoncinemadb";

				$connect = mysqli_connect($hostname, $username, $password, $dbname) OR DIE ("Connection failed");

				$sql = "SELECT c.name, i.chosenSeat FROM invoice i
						JOIN customer c ON i.custid = c.custid";
				$sendsql = mysqli_query($connect,$sql);

				

				if($sendsql){
					$count = 1;
					echo "<table>
					<tr>
						<th>No.</th>
                        <th>Customer Name</th>
						<th>Seat No</th>

					</tr>";

				foreach($sendsql as $row)
				{
					echo "<tr>";
						echo "<td>". $count ."</td>";
						echo "<td>". $row["name"] ."</td>";
						echo "<td>". $row["chosenSeat"] ."</td>";
					echo "</tr>";
					$count++;
				}

				echo "</table>";
				
				}else{
					echo "<p>Failed.</p>";
				}
			?>
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
    margin: 30px auto;
    max-width: 90%;
    background-color: #ffffff;
    border-radius: 15px;
    padding: 20px 30px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
}

h1 {
    font-size: 40px;
    font-weight: bold;
    color: #BF0885;
    background-color: #FFE6FF;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    background-color: #FFF1FB;
    font-size: 18px;
    border-radius: 10px;
}

table, th, td {
    border: 1px solid #BF0885;
    text-align: center;
    padding: 15px;
}

th {
    background-color: #BF0885;
    color: #ffffff;
    font-weight: bold;
}

td {
    color: #333333;
    font-weight: 500;
}

tr:nth-child(even) {
    background-color: #FBEAFF;
}

tr:hover {
    background-color: #F5D1EF;
    transition: 0.3s;
}

.add {
    padding: 10px 20px;
    background-color: #BF0885;
    color: white;
    font-size: 16px;
    font-weight: 500;
    text-decoration: none;
    border-radius: 20px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    margin-top: 20px;
    transition: background-color 0.3s ease;
}

.add:hover {
    background-color: #99076B;
}

@media (max-width: 768px) {
    h1 {
        font-size: 28px;
    }

    table {
        font-size: 14px;
    }

    td, th {
        padding: 10px;
    }
}

	</style>
</html>