<?php
    // validate
    define('APP_ACCESS', true);
    // activate session
    session_name('admin_session');
	session_start();

    if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Clerk') {
        header("Location: index.php");
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
				
	$row = mysqli_fetch_assoc($sendsql)		

?>
<!DOCTYPE html>
<html>
	<head>
		<title>CLERK | PARAGON</title>
        <link rel="shortcut icon" href="img/ten-logo.png" type="image/png">
	</head>
	
	<?php include "sidenav.php"; ?>
	<body>
		<div class="container">
			<h1>Session Details</h1>
			
			<div class="add_button">
                <a href="add_session.php" class="add"><i class="fa fa-plus"></i> New Session</a>
		    </div><br>

			<?php
				$hostname = "localhost";
				$username = "root";
				$password = "";
				$dbname = "paragoncinemadb";

				$connect = mysqli_connect($hostname, $username, $password, $dbname) OR DIE ("Connection failed");

				$sql = "SELECT s.session_id, s.hallNo, m.title, s.showtime_start, s.showtime_end FROM sessions s 
                        JOIN movie m ON s.movieid = m.movieid";
				$sendsql = mysqli_query($connect,$sql);

				if($sendsql){
                    $count = 1;
					echo "<table>
					<tr>
                        <th>No.</th>
						<th>Hall Number</th>
                        <th>Movie Name</th>
                        <th>Start</th>
                        <th>End</th>
						<th>Action</th>
					</tr>";

				foreach($sendsql as $row)
				{
					echo "<tr>";
                        echo "<td>". $count ."</td>";
						echo "<td>". $row["hallNo"] ."</td>";
                        echo "<td>". $row["title"] ."</td>";
                        echo "<td>". $row["showtime_start"] ."</td>";
                        echo "<td>". $row["showtime_end"] ."</td>";
						echo "<td><a href='delete_session.php?session_id=". $row["session_id"] ."'><i class='fa fa-trash'></i></a></td>";
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

.add_button {
    margin-top: 20px;
    text-align: right;
}

.add {
    padding: 8px 20px;
    background-color: #007bff;
    color: white;
    font-size: 18px;
    font-weight: 500;
    border-radius: 30px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.add:hover {
    background-color: #0056b3;
}

table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
    font-size: 18px;
    text-align: center;
}

th {
    background-color: #BF0885;
    color: white;
    padding: 10px;
    border: 2px solid #BF0885;
    font-weight: bold;
}

td {
    padding: 10px;
    border: 2px solid #BF0885;
    color: #333333;
    font-weight: 500;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

.delete-btn {
    color: #d9534f;
    font-size: 20px;
    text-decoration: none;
}

.delete-btn:hover {
    color: #c9302c;
}

@media (max-width: 768px) {
    h1 {
        font-size: 36px;
    }

    .add {
        font-size: 16px;
    }

    table {
        font-size: 16px;
    }
}

	</style>
</html>