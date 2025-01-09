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
                
    $sql = "SELECT * FROM manager WHERE username = '$username' ";  
        
    $sendsql = mysqli_query($connect, $sql) OR DIE("CONNECTION ERROR");	
                
    $row = mysqli_fetch_assoc($sendsql);	
    if (isset($_POST["update"])) {
        // Ambil data dari form
        $id = $_POST["id"];
        $name = mysqli_real_escape_string($connect, $_POST["name"]);
        $icNum = mysqli_real_escape_string($connect, $_POST["icNum"]);
        $gender = mysqli_real_escape_string($connect, $_POST["gender"]);
        $role = mysqli_real_escape_string($connect, $_POST["role"]);
        $username = mysqli_real_escape_string($connect, $_POST["username"]);
        $password = mysqli_real_escape_string($connect, $_POST["password"]);
    
        // Update data ke dalam database
        $sql = "UPDATE manager SET 
            name = '$name', 
            icNum = '$icNum', 
            gender = '$gender', 
            role = '$role', 
            username = '$username', 
            password = '$password' 
            WHERE id = '$id'";
    
        if (mysqli_query($connect, $sql)) {
            // Jika berhasil, redirect ke halaman lain atau tampilkan pesan sukses
            $_SESSION["success"] = "Data berhasil diperbarui.";
            header("Location: manager_profile.php"); // Ganti dengan halaman yang relevan
            exit;
        } else {
            // Jika gagal, tampilkan pesan error
            echo "Error: " . mysqli_error($connect);
        }
    }
    
    // Tutup koneksi
    mysqli_close($connect);
    ?>

<!DOCTYPE html>
<html>
	<head>
		<title>MANAGER | PARAGON</title>
        <link rel="shortcut icon" href="img/ten-logo.png" type="image/png">
	</head>
	    <body>
            <div class="container">
                <br><h1> Update Manager Data </h1><br>

                <form action="manager_process.php" method="POST">
                    <div class="form-group">
                        <label for="id">ID:</label>
                        <input type="number" name="id" value="<?php echo $row["id"] ?>"readonly/>
                    </div>

                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" value="<?php echo $row["name"] ?>"readonly/>
                    </div>

                    <div class="form-group">
                        <label for="icNum">IC Number:</label>
                        <input type="text" name="icNum" value="<?php echo $row["icNum"] ?>"readonly/>
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender:</label>
                        <input type="text" name="gender" value="<?php echo $row["gender"] ?>"readonly/>
                    </div>

                    <div class="form-group">
                        <label for="role">Role:</label>
                        <input type="text" name="role" value="<?php echo $row["role"] ?>"readonly/>
                    </div>

                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" name="username" value="<?php echo $row["username"] ?>"required/>
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="text" name="password" value="<?php echo $row["password"] ?>"required/>
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
    background-color: #FFFFFF;
    margin: 30px auto;
    max-width: 600px;
    padding: 30px;
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
    text-align: center;
    margin-bottom: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    text-align: left;
}

.form-group label {
    font-size: 16px;
    color: #BF0885;
    font-weight: bold;
    margin-bottom: 5px;
}

.form-group input[type="text"],
.form-group input[type="number"] {
    padding: 10px;
    border: 1px solid #BF0885;
    border-radius: 8px;
    width: 100%;
    font-size: 14px;
    background-color: #FDF0FF;
    color: #333;
    transition: all 0.3s ease;
}

.form-group input[type="text"]:focus,
.form-group input[type="number"]:focus {
    border-color: #99076B;
    outline: none;
    background-color: #F9E1FF;
}

input[type="submit"] {
    background-color: #BF0885;
    color: #FFFFFF;
    font-weight: bold;
    font-size: 16px;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    width: 100%;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

input[type="submit"]:hover {
    background-color: #99076B;
    transform: translateY(-3px);
}

@media (max-width: 768px) {
    .container {
        padding: 15px;
        margin: 15px;
    }

    h1 {
        font-size: 28px;
    }

    .form-group input[type="text"],
    .form-group input[type="number"],
    input[type="submit"] {
        font-size: 14px;
    }
}

	</style>
</html>