<?php
session_name('cust');
session_start();
include 'dbConnect.php';



if (isset($_SESSION['USER_ID'])) {
    header("location: index.php");
    exit();
  }

  if (!isset($_GET['code']) || empty($_GET['code'])) {
    header("location: index.php"); // Redirect jika tidak ada kode
    exit();
}

  $token = $_GET['code'];

  
  
  $result = mysqli_query($conn, "SELECT * FROM password_reset_request WHERE token='$token' AND token_expiry > NOW()");


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
        <h1>Reset Password</h1>

        <form id="resetForm" action="" method="post" onsubmit="return validatePassword()">
    <hr>
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

    <?php
    
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $customer_id = $row['customer_id'];
    $user = mysqli_query($conn, "SELECT password FROM customer WHERE custid = '$customer_id'");
    $rowPW = mysqli_fetch_assoc($user);
    $password = $rowPW['password'];
    
if (isset($_POST['submit'])) {
    $NewPassword = $_POST['NewPassword'];

    $chkpass_sql = "SELECT * FROM password_reset_request WHERE token = '$token' ";
    $chkpass_result = mysqli_query($conn, $chkpass_sql);

    if ($chkpass_result) {
        if (mysqli_num_rows($chkpass_result) == 0) {
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo '<script>
                Swal.fire({
                    title: "User Not Found",
                    text: "No user found with the given reset token.",
                    icon: "error",
                    confirmButtonText: "OK"
                }).then(() => {
                    window.location = "forgotpassword.php";
                });
            </script>';
            exit();
        } elseif ($NewPassword == $password){
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
                echo '<script>
                    Swal.fire({
                        title: "Invalid Password",
                        text: "New password cannot be the same as the old password.",
                        icon: "warning",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location = "forgotpassword.php";
                    });
                </script>';
                exit();
        }
         else {
            $updatepass_result = mysqli_query($conn, "UPDATE customer SET password = '$NewPassword' WHERE custid = '$customer_id'");
            mysqli_query($conn, "UPDATE password_reset_request SET is_change = 1 WHERE customer_id = '$customer_id'");
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo '<script>
                Swal.fire({
                    title: "Password Updated",
                    text: "Your password has been successfully updated.",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() => {
                    window.location = "login.php";
                });
            </script>';
            exit();
        }
    }
}
}else {
header("location: login.php");
exit();
}

    ?>
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