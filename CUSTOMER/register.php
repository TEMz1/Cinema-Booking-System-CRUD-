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
    <link rel="stylesheet" href="assets/_registerStyles.css" />
    <script src="https://use.fontawesome.com/6a4ab084c1.js"></script>
  
    <!-- ::::::::::::::Icon Tab::::::::::::::-->
    <link rel="shortcut icon" href="assets/images/logo/ten-icon.png" type="image/png">

    <title>TEN | Register</title>
</head>
<body>

    <div class="testbox">
        <h1>Registration</h1>

        <form action="process.php" method="post">
            <hr>
            <label id="icon" for="name"><i class="icon-text-width" aria-hidden="true"></i></label>
            <input type="text" name="Name" id="name" placeholder="Name" required/>
            <label id="icon" for="email"><i class="icon-envelope "></i></label>
            <input type="text" name="Email" pattern=".+@gmail\.com" size="30" id="email" placeholder="example@gmail.com" required/>
            <label id="icon" for="phone"><i class="icon-phone"></i></label>
            <input type="text" name="phoneNo" id="phone" placeholder="Telephone Number" onkeypress="isInputNumber(event)" maxlength="14" required/>
            <label id="icon" for="username"><i class="icon-user"></i></label>
            <input type="text" name="Username" id="username" placeholder="Username" required/>
            <label id="icon" for="password"><i class="icon-shield"></i></label>
            <input type="password" name="Password" id="password" placeholder="Password" 
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
            title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
            required/>

            <p>Already a member?<br> <a href="login.php">Sign In</a></p>
            <button class="button" name="submit" value="submit">Register</button>
            <!-- <p>By clicking Register, you agree to our <a href="#">terms and conditions</a>.</p> -->
        </form>
    </div>
    <script type="text/javascript">
        class InputValidator {
            isInputNumber(evt) {
                var ch = String.fromCharCode(evt.which);
                if (!/[0-9]/.test(ch)) {
                    evt.preventDefault();
                }
            }
        }
        
        const inputValidator = new InputValidator();
        
        function isInputNumber(evt) {
            inputValidator.isInputNumber(evt);
        }
   
    </script>
   
</body>
</html>
