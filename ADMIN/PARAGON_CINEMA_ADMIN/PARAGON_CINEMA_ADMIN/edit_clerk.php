<?php
    
    session_name('admin_session');
    session_start();

    if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Clerk') {
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
                
    $row = mysqli_fetch_assoc($sendsql)		

?>
<!DOCTYPE html>
<html>
	<head>
        <title>CLERK | PARAGON</title>
        <link rel="shortcut icon" href="img/ten-logo.png" type="image/png">
	</head>
	    <body>
            <div class="container">
                <br><h1> Update Clerk Data </h1>

                <form action="clerk_process.php" method="POST">
                    <div class="form-group">
                        <label for="id">ID:</label>
                        <input type="number" name="id" value="<?php echo $row["id"] ?>"readonly/><br/>
                    </div>

                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" value="<?php echo $row["name"] ?>"readonly/><br/>
                    </div>

                    <div class="form-group">
                        <label for="icNum">IC Number:</label>
                        <input type="text" name="icNum" value="<?php echo $row["icNum"] ?>"readonly/><br/>
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender:</label>
                        <input type="text" name="gender" value="<?php echo $row["gender"] ?>"readonly/><br/>
                    </div>

                    <div class="form-group">
                        <label for="role">Role:</label>
                        <input type="text" name="role" value="<?php echo $row["role"] ?>"readonly/><br/>
                    </div>

                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" name="username" value="<?php echo $row["username"] ?>"required/><br/>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="text" name="password" value="<?php echo $row["password"] ?>"required/><br/>
                    </div>
                    
                    <br>
                    <input type="submit" name="update" value="UPDATE"/>
                </form>
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
    padding: 40px;
    text-align: center;
    color: #333;
    border-radius: 15px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    width: 50%;
}

h1 {
    font-size: 48px;
    color: #BF0885;
    background-color: #FFE6FF;
    padding: 20px;
    border-radius: 10px;
    margin: 0;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.form-group {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
}

.form-group label {
    width: 150px;
    text-align: right;
    margin-right: 20px;
    font-weight: bold;
    color: #BF0885;
}

.form-group input[type="text"],
.form-group input[type="number"] {
    width: 250px;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #D1D1D1;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
    margin: 5px 0;
}

input[type="submit"] {
    background-color: #BF0885;
    color: white;
    font-size: 18px;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #a60471;
}

@media (max-width: 768px) {
    .container {
        width: 80%;
        padding: 20px;
    }

    .form-group label {
        width: 120px;
    }

    .form-group input[type="text"],
    .form-group input[type="number"] {
        width: 200px;
    }
}

	</style>
</html>