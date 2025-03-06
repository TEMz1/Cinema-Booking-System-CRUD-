<?php
session_name('cust');
session_start();
include 'dbConnect.php';

$msg = "";

if (isset($_SESSION['USER_ID'])) {
  header("location: index.php");
  exit();
}


?>



<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TEN | Login</title>
     <!-- ::::::::::::::Icon Tab::::::::::::::-->
     <link rel="shortcut icon" href="assets/images/logo/ten-icon.png" type="image/png">
    <link rel="stylesheet" href="assets/_loginStyles.css" />
      <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
  <body>
    <div class="content">
      <div class="flex-div">
        <div class="name-content">
          <h1 class="logo">TEN</h1>
          <h4 class="logo-2nd">Cinema</h4>
          <p>
            Where dreams ignite, and stories unfold,
            Book your seat, let the magic enfold.</p>
        </div>
          <form action="" method="post">
            <input type="text" id="username" name="Username" placeholder="Email or Username" required>
            <input type="password" id="password" name="Password" placeholder="Password"
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
            title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
            <button style="font-family:'Poppins';" name="login" class="login" value="login">Log In</button>
              <div class="error">  
                <?php echo $msg ?>  
              </div>  
            <a id="forgotpassword" name="forgotpassword" href="forgotpassword.php">Forgot Password ?</a>
            <hr>
            <a href="register.php" class="create-account">Create New Account</a>
          </form>
          
      </div>
      
    </div>
    <?php
    if (isset($_POST['login'])) {
      $Username = mysqli_real_escape_string($conn, $_POST['Username']);
      $Password = mysqli_real_escape_string($conn, $_POST['Password']);
  
      $sql = mysqli_query($conn, "SELECT * FROM customer WHERE (username='$Username' OR email='$Username') AND password='$Password' AND is_verif=1");
      $num = mysqli_num_rows($sql);
  
      if ($num > 0) {
          $row = mysqli_fetch_assoc($sql);
  
          $_SESSION['USER_ID'] = $row['custid'];
          $_SESSION['USER_NAME'] = $row['username'];
  
          echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
              Swal.fire({
                  title: 'Login Success',
                  text: 'Welcome to TENCinema!',
                  icon: 'success',
                  confirmButtonText: 'OK'
              }).then(() => {
                  window.location = 'index.php';
              });
          });
        </script>";
  exit();
  } else {
  echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
              Swal.fire({
                  title: 'Login Failed!',
                  text: 'Email or password is wrong!',
                  icon: 'error',
                  confirmButtonText: 'Try Again'
              }).then(() => {
                  window.location = 'login.php';
              });
          });
        </script>";
  exit();
  }
  }
    ?>
  </body>
</html>
