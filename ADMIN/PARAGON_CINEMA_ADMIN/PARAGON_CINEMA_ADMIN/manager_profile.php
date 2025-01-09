<?php
    // validate
    define('APP_ACCESS', true);
    session_name('admin_session');
    session_start();

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
			<h1>Profile</h1>
                <div class="button">
                    <a href="edit_manager.php" class="edit"><i class="fa fa-edit"></i> EDIT</a>
                </div><br>
                <?php
                    echo "<table>
                    <tr>
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
                    echo"<tr>
                        <th>Username: </th>
                        <td>$row[username]</td>
                    </tr>";
                    echo "<tr>
                        <th>Password: </th>
                        <td>$row[password]</td>
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
    background-color: #FFFFFF;
    margin: 30px auto;
    max-width: 800px;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: left;
}

h1 {
    font-size: 35px;
    font-weight: bold;
    color: #BF0885;
    background-color: #FFE6FF;
    padding: 10px 20px;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-align: center;
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background-color: #FFF1FB;
    font-size: 16px;
    border-radius: 10px;
}

th, td {
    border: 1px solid #BF0885;
    text-align: left;
    padding: 10px 15px;
    color: #333333;
}

th {
    background-color: #BF0885;
    color: #FFFFFF;
    font-weight: bold;
}

td {
    background-color: #FFE6FF;
    color: #333333;
    font-weight: 500;
}

tr:nth-child(even) td {
    background-color: #FBEAFF;
}

tr:hover td {
    background-color: #F5D1EF;
    transition: 0.3s;
}

.edit {
    display: inline-block;
    padding: 8px 16px;
    background-color: #BF0885;
    color: #FFFFFF;
    font-size: 14px;
    font-weight: bold;
    text-decoration: none;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s ease, transform 0.2s;
    margin-bottom: 20px;
}

.edit:hover {
    background-color: #99076B;
    transform: translateY(-3px);
}

@media (max-width: 768px) {
    .container {
        padding: 15px;
    }

    h1 {
        font-size: 28px;
    }

    table, th, td {
        font-size: 14px;
    }

    .edit {
        font-size: 12px;
        padding: 6px 12px;
    }
}

	</style>
</html>
