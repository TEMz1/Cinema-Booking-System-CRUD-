<?php
    // validate
    define('APP_ACCESS', true);
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
		<title>CLERK | TEN</title>
        <link rel="shortcut icon" href="img/ten-logo.png" type="image/png">
	</head>
	
	<?php include "sidenav.php"; ?>
	<body>
		<div class="container">
			<h1>Movie Details</h1>
			
			<div class="add_button">
                <a href="add_movie.php" class="add"><i class="fa fa-plus"></i> New Movie</a>
		    </div><br>

			<?php
				$hostname = "localhost";
				$username = "root";
				$password = "";
				$dbname = "paragoncinemadb";

				$connect = mysqli_connect($hostname, $username, $password, $dbname) OR DIE ("Connection failed");

				$sql = "SELECT * FROM movie";
				$sendsql = mysqli_query($connect,$sql);

				if($sendsql){
					echo "<table>
					<tr>
                        <th>ID</th>
						<th>Cover</th>
                        <th>Title</th>
                        <th>Genre</th>
                        <th>Duration</th>
                        <th>Release Date</th>
						<th>Action</th>
					</tr>";

				foreach($sendsql as $row)
				{
					echo "<tr>";
                        echo "<td>". $row["movieid"] ."</td>";
						echo "<td><img src='assets/images/movie_poster/". $row["poster"] ."' width='100' height='150'></td>";
						echo "<td>". $row["title"] ."</td>";
                        echo "<td>". $row["genre"] ."</td>";
                        echo "<td>". $row["duration"] ."</td>";
                        echo "<td>". $row["releaseDate"] ."</td>";
						echo "<td><a href='edit_movie.php?movieid=". $row["movieid"] ."'><i class='fa fa-edit'></i></a> &emsp;";
						echo "<a href='#' class='delete-link' data-href='delete_movie.php?movieid=" . $row["movieid"] . "'><i class='fa fa-trash'></i></a></td>";

					echo "</tr>";
				}

				echo "</table>";
				
				}else{
					echo "<p>Failed.</p>";
				}
			?>
		</div>
        <script>
    // Handle delete link click
    document.querySelectorAll('.delete-link').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault(); // Prevent default link behavior

            // Show confirmation dialog
            const confirmation = confirm('Are you sure you want to delete this movie?');

            // If user clicks "OK", proceed with the deletion
            if (confirmation) {
                window.location.href = this.getAttribute('data-href'); // Redirect to delete_movie.php
            }
        });
    });
</script>

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

img {
    border-radius: 10px;
}

.edit-btn {
    color: #28a745;
    font-size: 20px;
    text-decoration: none;
}

.edit-btn:hover {
    color: #218838;
}

.delete-btn {
    color: #dc3545;
    font-size: 20px;
    text-decoration: none;
}

.delete-btn:hover {
    color: #c82333;
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