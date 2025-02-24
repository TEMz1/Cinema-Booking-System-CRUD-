<?php
session_name('cust');
session_start();
include 'dbConnect.php';



if (!isset($_SESSION['USER_ID'])) {
    header("location: index.php");
    exit();
  }

  


  $customer_id = $_SESSION['USER_ID'];
  
  $result = mysqli_query($conn, "SELECT * FROM customer WHERE custid = '$customer_id' ");
  $user = mysqli_fetch_assoc($result);
  $password = $user['password'];

  if (isset($_POST['submit'])) {
    $oldPassword = $_POST['oldPassword'];
    $NewPassword = $_POST['NewPassword'];

    if ($NewPassword == $password) {
        ?>
        <script>		
            alert("New password cannot be same as old password, Please change your password!!");
            window.location = "changePassword.php";
        </script>
        <?php
    }

    elseif ($oldPassword == $password) {
    $updatepass_result = mysqli_query($conn, "UPDATE customer SET password = '$NewPassword' WHERE custid = '$customer_id'");
    ?>
    <script>		
        alert("Password successfully updated, please login again");
        <?php session_destroy(); ?>
        window.location = "login.php";
    </script>
    <?php
    
    } else {
        ?>
        <script>		
            alert("Wrong Password!!!, please input password correctly");
            window.location = "changePassword.php";
        </script>
        <?php
    }
   
}
  
?>

<style>
    input[type=password]{
  width: 200px; 
  height: 39px; 
  -webkit-border-radius: 0px 4px 4px 0px/5px 5px 4px 4px; 
  -moz-border-radius: 0px 4px 4px 0px/0px 0px 4px 4px; 
  border-radius: 0px 4px 4px 0px/5px 5px 4px 4px; 
  background-color: #fff; 
  -webkit-box-shadow: 1px 2px 5px rgba(0,0,0,.09); 
  -moz-box-shadow: 1px 2px 5px rgba(0,0,0,.09); 
  box-shadow: 1px 2px 5px rgba(0,0,0,.09); 
  border: solid 1px #cbc9c9;
  margin-left: -5px;
  margin-top: 13px; 
  padding-left: 10px;
}

input[type=password]{
  margin-bottom: auto;
}
</style>

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
        <h1>Change Password</h1>

        <form id="resetForm" action="" method="post" onsubmit="return validatePassword()">
    <hr>
    <label id="icon" for="oldPassword"><i class="icon-shield"></i></label>
    <input type="password" name="oldPassword" id="oldPassword" placeholder="Old Password" 
    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
    title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
    required/>

    <label id="icon" for="password"><i class="icon-shield"></i></label>
    <input type="password" name="NewPassword" id="password" placeholder="New Password" 
    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
    title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
    required/>

    <label id="icon" for="confirmPassword"><i class="icon-shield"></i></label>
    <input type="password" name="ConfirmNewPassword" id="confirmPassword" placeholder="Confirm New Password" 
    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
    title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
    required/>
    
    <span id="error-message" style="color: red; font-size: 14px;"></span> <!-- Pesan error di sini -->

    <button class="button" name="submit" value="submit">Change</button>
</form>


    </div>
</body>
<script>
document.getElementById("resetForm").addEventListener("submit", function(event) {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirmPassword").value;
    var errorMessage = document.getElementById("error-message");

    if (password !== confirmPassword) {
        errorMessage.textContent = "Passwords do not match!";
        event.preventDefault(); // Mencegah form terkirim jika password tidak cocok
    } else {
        errorMessage.textContent = ""; // Hapus pesan error jika cocok
    }
});
</script>


</html>