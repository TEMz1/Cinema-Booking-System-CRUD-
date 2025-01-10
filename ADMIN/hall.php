<?php
// validate
define('APP_ACCESS', true);
session_name('admin_session');  
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Clerk') {
    header("Location: login.php");
    exit();
}

include 'dbConnect.php';

$username = $_SESSION["username"];
			
$sql = "SELECT * FROM CLERK WHERE username = '$username' ";  
	
$sendsql = mysqli_query($conn, $sql) OR DIE("CONNECTION ERROR");	
			
$row = mysqli_fetch_assoc($sendsql)		

?>
<!DOCTYPE html>
<html>
	<head>
		<title>CLERK | TEN</title>
        <link rel="shortcut icon" href="img/ten-logo.png" type="image/png">
	</head>
	
	<?php include "sidenav.php"; ?>
	<body>
		<div class="container">
			<h1>Hall Details</h1>
			
			<div class="add_button">
                <a href="add_hall.php" class="add"><i class="fa fa-plus"></i> New Hall</a>
		    </div><br>

            <?php
				// Mengambil data dari tabel hall
				$sql = "SELECT * FROM hall";
				$sendsql = mysqli_query($conn, $sql);

				// Periksa apakah query berhasil
				if ($sendsql && mysqli_num_rows($sendsql) > 0) {
					echo "<table>
					<tr>
                        <th>Hall Number</th>
						<th>Hall Name</th>
						<th>Action</th>
					</tr>";

					// Loop untuk menampilkan data hall
					while ($row = mysqli_fetch_assoc($sendsql)) {
						echo "<tr>";
                        echo "<td>" . $row["hallNo"] . "</td>";
						echo "<td>" . $row["hallName"] . "</td>";
						echo "<td>
								<a href='edit_hall.php?hallNo=" . $row["hallNo"] . "' class='edit-btn'><i class='fa fa-edit'></i></a>
							  </td>";
						echo "</tr>";
					}

					echo "</table>";
				} else {
					// Jika tidak ada data
					echo "<p>No hall data available.</p>";
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
    margin: 50px auto;
    padding: 30px;
    text-align: center;
    background-color: #FFF3FB;
    color: #333333;
    border-radius: 15px;
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

.edit-btn {
    color: #28a745;
    font-size: 20px;
    text-decoration: none;
}

.edit-btn:hover {
    color: #218838;
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