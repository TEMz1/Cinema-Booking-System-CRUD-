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
		<title>CLERK | PARAGON</title>
        <link rel="shortcut icon" href="img/paragon_logo.png" type="image/png">
	</head>
	
	<?php include "sidenav.php"; ?>
    <body>
        <div class="container">
			<h1>Profile</h1>
                <div class="button">
                    <a href="edit_clerk.php" class="edit"><i class="fa fa-edit"></i> EDIT</a>
                </div><br>
                <?php
                    echo "<table>
                    <tr>
                        <th>Username: </th>
                        <td>$row[username]</td>
                    </tr>";
                    echo "<tr>
                        <th>Password: </th>
                        <td>$row[password]</td>
                    </tr>";
                    echo "<tr>
                        <th>Name: </th>
                        <td>$row[name]</td>
                    </tr>";
                    echo "<tr>
                        <th>IC Number: </th>
                        <td>$row[icNum]</td>
                    </tr>";
                    echo "<tr>
                        <th>Gender: </th>
                        <td>$row[gender]</td>
                    </tr>";
                    
                    echo "<tr>
                        <th>Role: </th>
                        <td>$row[role]</td>
                    </tr>";

                    echo "</table>";       
                ?>
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
    background-color: #FFF3FB;
    margin: 50px auto;
    padding: 30px;
    text-align: center;
    color: #333333;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

h1 {
    font-size: 50px;
    font-weight: bold;
    color: #BF0885;
    background-color: #FFE6FF;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-align: center;
    margin-top: 0;
}

table {
    width: 100%;
    margin-top: 30px;
    border-collapse: collapse;
    font-size: 18px;
    text-align: left;
    color: #333333;
}

th {
    background-color: #BF0885;
    color: white;
    padding: 12px;
    border: 2px solid #BF0885;
    font-weight: bold;
    
}

td {
    padding: 12px;
    border: 2px solid #BF0885;
    font-weight: 500;
    background-color: #FFF5FB;
    color: #333333;
    border-radius: 10px;
}

.edit {
    padding: 10px 20px;
    background-color:  #BF0885;
    color: white;
    font-size: 18px;
    border-radius: 30px;
    text-decoration: none;
    transition: background-color 0.3s ease;
    float: right;
    margin-right: 20px;
}

.edit:hover {
    background-color:rgb(126, 4, 87);
}

@media (max-width: 768px) {
    h1 {
        font-size: 36px;
    }

    table {
        font-size: 16px;
    }
}

	</style>
</html>