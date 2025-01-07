<?php
define('APP_ACCESS', true);

session_name('admin_session');
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Manager') {
    header("Location: login.php");
    exit();
}
    
include 'dbConnect.php';
$selectdb = mysqli_select_db($conn, $database) OR DIE ("Database cannot be accessed");
			
$username = $_SESSION["username"];
			
$sql = "SELECT * FROM manager WHERE username = '$username' ";  
	
$sendsql = mysqli_query($conn, $sql) OR DIE("CONNECTION ERROR");	
			
$row = mysqli_fetch_assoc($sendsql)		

?>
<!DOCTYPE html>
<html>
	<head>
		<title>MANAGER | PARAGON</title>
        <link rel="shortcut icon" href="img/paragon_logo.png" type="image/png">
	</head>
	
	<?php include "manager_sidenav.php"; ?>
	<body>
		<div class="container">
			<h1>Clerk Details</h1>
            <div class="add_button">
                <a href="add_clerk.php" class="add"><i class="fa fa-plus"></i> Add Clerk </a>
		    </div><br>
			<?php

				$sql = "SELECT * FROM Clerk";
				$sendsql = mysqli_query($conn,$sql);

				if($sendsql){
					echo "<table>
					<tr>
                        <th>ID</th>
						<th>Clerk Name</th>
						<th>Phone Number</th>
                        <th>icNum</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Action</th>
					</tr>";

				foreach($sendsql as $row)
				{
					echo "<tr>";
                        echo "<td>". $row["id"] ."</td>";
						echo "<td>". $row["name"] ."</td>";
                        echo "<td>". $row["phoneNum"] ."</td>";
						echo "<td>". $row["icNum"] ."</td>";
                        echo "<td>". $row["username"] ."</td>";
						echo "<td>". $row["password"] ."</td>";
						echo "<td><a href='ubah_clerk.php?kode=". $row["id"] ."'><i class='fa fa-edit'></i></a> &emsp;";
						echo "<a href='delete_clerk.php?kode=". $row["id"] ."' onclick = 'return confirm(\"Are you sure you want to delete this clerk?\")'><i class='fa fa-trash'></i></a></td>";
					echo "</tr>";
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

.btn-edit, .btn-delete {
			display: inline-block;
			padding: 8px 15px;
			text-decoration: none;
			font-weight: 500;
			border-radius: 5px;
			color: #333333;
			text-align: center;
			cursor: pointer;
		}

		.btn-edit {
			background-color:rgb(253, 168, 213);
			border: 1px solid rgb(253, 168, 213);
            margin-right: 20px;
		}

		.btn-edit:hover {
			background-color: rgb(255, 114, 189);
		}

		.btn-delete {
			background-color:rgb(255, 129, 120);
			border: 1px solid rgb(255, 129, 120);
		}

		.btn-delete:hover {
			background-color: rgb(247, 86, 75);
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