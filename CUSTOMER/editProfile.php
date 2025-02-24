<?php
session_name('cust');
session_start();
include 'dbConnect.php';

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

// Cek apakah user sudah login
if (!isset($_SESSION['USER_ID'])) {
    header("location:login.php");
    exit();
}

// Ambil data user dari database
$user_id = $_SESSION['USER_ID'];
$sql = "SELECT name, phoneNo, email, username FROM customer WHERE custid = $user_id";
$result = $conn->query($sql);
$user = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone']);
  
  $update_sql = "UPDATE customer SET name='$name', username='$username', email='$email', phoneNo='$phone' WHERE custid=$user_id";
  
  if ($conn->query($update_sql) === TRUE) {
      echo "<script>alert('Profil berhasil diperbarui!'); window.location.href='index.php';</script>";
  } else {
      echo "<script>alert('Gagal memperbarui profil!');</script>";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>TEN | Edit Profile</title>
  <meta charset="utf-8">
  <link rel="shortcut icon" href="assets/images/logo/ten-icon.png" type="image/png">
  <link rel="stylesheet" href="assets/_editProfileStyles.css" />
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

      <form action="" method="POST" class="profile-form">
  <div class="profile-container text-start">
    <label for="name">Nama </label>
    <input type="text" id="name" name="name" value="<?php echo ($user['name'])?>" required>
    
    <label for="username">Username</label>
    <input type="text" id="username" name="username" value="<?php echo ($user['username'])?>" required>
    
    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?php echo ($user['email'])?>" readonly>
    
    <label for="phone">Nomor HP</label>
    <input type="number" id="phone" name="phone" value="<?php echo ($user['phoneNo'])?>" required>
  </div>

  <div class="button-profile">
    <button class="btn btncarousel mt-3" type="submit">Save</button>
  </div>
</form>

  </section>
</body>
<style>
  .profile-container input[type="text"], input[type="number"], input[type="email"]{
    width: 600px !important;
    background-color: white;  /* Warna latar belakang putih */
    color: black;  /* Warna teks hitam */
    padding: 10px;
    border-radius: 5px;
   
  }
</style>
</html>
