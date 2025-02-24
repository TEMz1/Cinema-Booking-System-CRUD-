<?php
session_name('cust');
session_start();
include 'dbConnect.php';

if (!isset($_SESSION['USER_ID'])) {
    header("location:login.php");
    exit();
}

// Validasi session
if (isset($_SESSION['hall_id']) && isset($_SESSION['transaction_id'])) {
  $hall_no = $_SESSION['hall_id'];           // Ambil dari session
  $transaction_id = $_SESSION['transaction_id']; // Ambil dari session

 // Query untuk menghapus data
 $sql = "DELETE FROM bookings WHERE transaction_id = ? AND hallNo = ?";
 $stmt = mysqli_prepare($conn, $sql);

 if ($stmt) {
     // Bind parameter
     mysqli_stmt_bind_param($stmt, "ss", $transaction_id, $hall_no);

     // Eksekusi query
     mysqli_stmt_execute($stmt);
 }
  // Hapus session terkait (Opsional)
  unset($_SESSION['hall_id']);
  unset($_SESSION['transaction_id']);
}

// Ambil data user dari database
$user_id = $_SESSION['USER_ID'];
$sql = "SELECT name, phoneNo, email, username FROM customer WHERE custid = $user_id";
$result = $conn->query($sql);
$user = mysqli_fetch_assoc($result);


?>
<!DOCTYPE html>
<html>
<head>
  <title>TEN | Profile</title>
  <meta charset="utf-8">
  <link rel="shortcut icon" href="assets/images/logo/ten-logo.png" type="image/png">
  <link rel="stylesheet" href="assets/_profileStyles.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="javascript/booking.js"></script>
  <style>
    .btncarousel {
      background: #FFB6C1;
      color: #111111;
      font-weight: bold;
      border-radius: 8px;
      border: none;
      padding: 10px 20px;
      justify-content: center;
    }
    .btncarousel:hover {
      background: #FF9AA2;
      color: #ffffff;
    }
    
  </style>
</head>
<body>
<section class="overflow-hidden py-5 my-3">
    <div class="container overflow-hidden text-center">
      <div class="d-flex justify-content-center">
        <ul class="ulli">
          <li class="active"><a href="#">
              <div class="icon">
                <img src="./assets/images/icons/profile.gif" style="background:#7a7777;">
              </div>
              <p><b>Profile</b></p>
            </a></li>
        </ul>
      </div>

      <div class="profile-container text-start">
        <label for="name">Nama </label>
        <input type="text" id="name" value="<?php echo ($user['name'])?>" disabled>
        
        <label for="username">Username</label>
        <input type="text" id="username" value="<?php echo ($user['username'])?>" disabled>
        
        <label for="email">Email</label>
        <input type="email" id="email" value="<?php echo ($user['email'])?>" disabled>
        
        <label for="phone">Nomor HP</label>
        <input type="text" id="phone" value="<?php echo ($user['phoneNo'])?>" disabled>
        
      
        <div class="button-profile d-flex flex-column align-items-left">
  <div class="d-flex justify-content-between w-100">
    <button class="btn btncarousel mt-3" id="edit" onclick="window.location.href='editProfile.php'">Edit Profile</button>
    <button class="btn btncarousel mt-3" id="change-password" onclick="window.location.href='changePassword.php'">Change Password</button>
  </div>
  <br>
  <button class="btn btncarousel mt-3 align-left" id="back" onclick="window.location.href='index.php'">Back</button>
</div>
  </section>
</body>
</html>
