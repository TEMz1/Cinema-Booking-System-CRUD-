<?php
session_name('cust');
session_start();
include 'dbConnect.php';



if (isset($_SESSION['USER_ID'])) {
    header("location: index.php");
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet' type='text/css'>
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/_forgotPasswordStyles.css" />
    <script src="https://use.fontawesome.com/6a4ab084c1.js"></script>
  
    <!-- ::::::::::::::Icon Tab::::::::::::::-->
    <link rel="shortcut icon" href="assets/images/logo/ten-icon.png" type="image/png">
    
    <title>TEN | Reset Password</title>
</head>
<body>
<div class="testbox">
        <h1>Reset Password</h1>

        <form action="process_forgot_pw.php" method="post">
            <hr>
            <label id="icon" for="username"><i class="icon-user"></i></label>
            <input type="text" name="Username" id="username" placeholder="Username" required/>
            
            <label id="icon" for="email"><i class="icon-envelope"></i></label>
            <input type="text" name="email" pattern=".+@gmail\.com" size="30" id="email" placeholder="example@gmail.com" required/>            
            <button class="button" name="submit" value="submit">Submit</button>
        </form>
    </div>
</body>
</html>