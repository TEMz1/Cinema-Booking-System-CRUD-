<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
      <title>Clerk Paragon</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <link href="css/index.css" rel="stylesheet" type="text/css">
        <link rel="shortcut icon" href="img/paragon_logo.png" type="image/png">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	</head>
  
  <body>
    <div class="login">

      <h1>ACCESS PORTAL</h1>
      <form action="" method="post">

        <label for="username">
          <i class="fas fa-user"></i>
        </label>
        <input type="text" name="username" placeholder="Username" id="username" required>

        <label for="password">
          <i class="fas fa-lock"></i>
        </label>
        <input type="password" name="password" placeholder="Password" id="password" required>

        <div class="checkbox">
          <input type="checkbox" id="showPassword" onclick="myFunction()">   Show password
        </div>
        <input type="submit" value="Login" name="login">
      
      </form>
    </div>

    <?php
    
    include 'dbConnect.php';
    define('APP_ACCESS', true);
    session_name('admin_session');
    session_start();

    if (isset($_SESSION['role']) && ($_SESSION['role'] == 'Clerk' || $_SESSION['role'] == 'Manager')) {
      // Jika sudah login sebagai admin atau manager, redirect ke dashboard yang sesuai
      if ($_SESSION['role'] == 'Clerk') {
          header("Location: index.php"); // Redirect ke halaman admin
          exit();
      } elseif ($_SESSION['role'] == 'Manager') {
          header("Location: manager_home.php"); // Redirect ke halaman manager
          exit();
      }
  }

// // Validasi session
// if (isset($_SESSION['role'])) {
//     if ($_SESSION['role'] != "clerk" && $_SESSION['role'] != "manager") {
//         // Jika session tidak valid, hancurkan sesi
//         session_destroy();
//         header("Location: login.php"); // Redirect ke halaman login
//         exit();
//     }
// } else {
//     // Jika tidak ada session, hancurkan sesi dan redirect ke login
//     session_destroy();
//     header("Location: login.php");
//     exit();
// }

      if(isset($_POST["login"])){
        
      //   $hostname = "localhost";
			// 	$user = "root";
			// 	$password = "";
			// 	$dbname = "paragoncinemadb";
		
			// 	$connect = mysqli_connect($hostname, $user, $password, $dbname) OR DIE ("Connection failed");
					
			$username = mysqli_real_escape_string($conn, $_POST["username"]);
			$password = mysqli_real_escape_string($conn, $_POST["password"]);

			$sqlcheck = "SELECT * FROM clerk WHERE username = '$username' AND password = '$password'";		
			$result = mysqli_query($conn,$sqlcheck);	
      $data = mysqli_fetch_array($result, MYSQLI_BOTH);
      $count = mysqli_num_rows($result);

      $sqlcheck2 = "SELECT * FROM manager WHERE username = '$username' AND password = '$password'";
      $result2 = mysqli_query($conn,$sqlcheck2);
      $data2 = mysqli_fetch_array($result2, MYSQLI_BOTH);
      $count2 = mysqli_num_rows($result2);
					
      if ($count == 1) {
        // User adalah Clerk
        $_SESSION['id'] = $data['id'];
        $_SESSION['nama'] = $data['name'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];

        echo "<script>
                Swal.fire({
                    title: 'Login Berhasil',
                    text: '',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.value) {
                        window.location = 'index.php';  // Redirect to Clerk's home page
                    }
                })
              </script>";
      } elseif ($count2 == 1) {
        // User adalah Manager
        $_SESSION['id'] = $data2['id'];
        $_SESSION['nama'] = $data2['name'];
        $_SESSION['username'] = $data2['username'];
        $_SESSION['password'] = $data2['password'];
        $_SESSION['role'] = $data2['role'];

        echo "<script>
                Swal.fire({
                    title: 'Login Berhasil',
                    text: '',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.value) {
                        window.location = 'manager_home.php';  // Redirect to Clerk's home page
                    }
                })
              </script>";
      } else {
         // Login failed
         echo "<script>
         Swal.fire({
             title: 'Login Gagal',
             text: 'Username atau password salah.',
             icon: 'error',
             confirmButtonText: 'OK'
         }).then((result) => {
             if (result.value) {
                 window.location = 'login.php';  // Redirect back to login page
             }
         })
       </script>";
      }
      }
			// 	if ($result){
      //     if (mysqli_num_rows($result) > 0){
      //       $_SESSION["username"] = $username;
      //       ?><script>
      //       alert("You have successfuly logged in. Please press OK to proceed.");
      //       window.location = "home.php";
      //       </script><?php
      //     }
      //     else{
      //       ?><script>
      //       alert("Username or password invalid. Please try again");
      //       window.location = "index.php";
      //       </script><?php
      //     }
			// 	}
        
      //   session_start();
      //   $_SESSION["username"] = $username;
      //   $_SESSION["level"] = 
			// }
				
		?>

    <script>
      function myFunction(){
        var x = document.getElementById("password");
        if (x.type === "password") {
        x.type = "text";
        } else {
        x.type = "password";
        }
      }
		</script>

  </body>
  
</html>