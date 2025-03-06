    <!DOCTYPE html>
    <html lang="en">
    <head>
    <link rel="shortcut icon" href="assets/images/logo/ten-logo.png" type="image/png">
    

    </head>
    <body>
        
    </body>
    </html>
    <?php
    // Cek apakah APP_ACCESS sudah didefinisikan
    if (!defined('APP_ACCESS')) {
        // Berikan respons error (status HTTP 403) atau redirect
        header("HTTP/1.0 403 Forbidden");
        exit();
    }

  ?>

    <nav class="navbar sticky-top navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <div class="image-container">
                <a href="index.php"><img class="img-fluid" src="assets/images/logo/ten-logo.png" alt=""></a>
            </div>


            <!-- Tombol Navbar Toggler (Burger Menu di Mobile) -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == 'index.php') echo 'active'; ?>" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == 'movieListings.php' || basename($_SERVER['PHP_SELF']) == 'moviedetails.php') echo 'active'; ?>" href="movieListings.php">Movies</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == 'aboutus.php') echo 'active'; ?>" href="aboutus.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == 'faq.php') echo 'active'; ?>" href="faq.php">FAQ</a>
                    </li>
                    
                     <!-- View Booking hanya muncul jika user sudah login -->
                <?php if (isset($_SESSION['USER_ID'])) { ?>
                    <li class="nav-item">
                        <a style="color:#FF9AA2;" class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == 'viewbooking.php') echo 'active'; ?>" href="viewbooking.php">View Booking</a>
                    </li>
                <?php } ?>

                    <?php if (isset($_SESSION['USER_ID' ])) { ?>
                        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle sign-in-btn" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: black;">
            <i class="fas fa-user-circle"></i> Profile
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="setting.php">Setting</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="javascript:void(0);" onclick="confirmLogout()">Logout</a></li>
        </ul>
    </li>
    <?php } else { ?>
                    <li class="nav-item ml-2">
                        <a style="color: #111111" class="nav-link sign-in-btn <?php if (basename($_SERVER['PHP_SELF']) == 'login.php') echo 'active'; ?>" href="login.php">Sign In</a>
                    </li>
                <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmLogout() {
        Swal.fire({
            title: "Log out Confirmation",
            text: "Are you sure you want to log out?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, Logout",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "logout.php"; // Redirect ke halaman logout
            }
        });
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
document.addEventListener("DOMContentLoaded", function () {
    let toggler = document.querySelector(".navbar-toggler");
    let menu = document.querySelector("#navbarSupportedContent");

    toggler.addEventListener("click", function () {
        menu.classList.toggle("show"); // Toggle menu agar bisa muncul
    });
});
</script>

    <style> </style>