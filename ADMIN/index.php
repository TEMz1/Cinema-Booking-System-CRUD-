<?php
session_name('admin_session');
// validate
define('APP_ACCESS', true); 
session_start();
include 'dbConnect.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Clerk') {
    header("Location: login.php");
    exit();
}

$nama = $_SESSION['nama'];

?>
<!DOCTYPE html>
<html>
	<head>
		<title>CLERK | TEN</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="shortcut icon" href="img/ten-icon.png" type="image/png">
	</head>
	
	<?php include "sidenav.php"; ?>
    <body>
        <div class="container">
			<h1>Welcome</h1>
			<?php
				echo "<h2>". $nama . "</h2>";
			?>
			<h2>To the Paragon Clerk Management</h2>
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
    padding: 40px;
    text-align: center;
    color: #333;
    border-radius: 15px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
}

h1 {
    font-size: 60px;
    font-weight: bold;
    color: #BF0885;
    background-color: #FFE6FF;
    padding: 20px;
    border-radius: 10px;
    margin: 0;
    text-align: center;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

h2 {
    font-size: 24px;
    color: #BF0885;
    margin-top: 15px;
}

.container h2 {
    font-size: 26px;
    color: #333333;
    font-weight: 500;
    padding: 15px;
    background-color: #FFF5FB;
    border-radius: 10px;
}

@media (max-width: 768px) {
    h1 {
        font-size: 50px;
    }

    h2 {
        font-size: 20px;
    }

    .container {
        padding: 25px;
    }
}

	</style>
</html>