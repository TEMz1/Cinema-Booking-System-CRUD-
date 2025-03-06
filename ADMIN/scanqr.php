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
        <script src="https://unpkg.com/html5-qrcode" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	</head>
	
	
    <body>
    <?php
    include 'sidenav.php';
    ?>
    <div id="reader"></div>
    

    <script>
        document.addEventListener("DOMContentLoaded", function() {
    const scanner = new Html5Qrcode("reader");
    const viewportWidth = window.innerWidth * 0.85; // 75% dari lebar layar
        const viewportHeight = window.innerHeight * 0.85; // 75% dari tinggi layar

    scanner.start(
        { facingMode: "environment" }, // Kamera belakang
        {
            fps: 10, // Scan 10 frame per detik
            qrbox: { width: viewportWidth, height: viewportHeight } // Ukuran area scan
        },
        (decodedText, decodedResult) => {
            console.log("Hasil Scan:", decodedText); // Output ke console
            
            // Hentikan scanner sementara setelah QR berhasil dibaca
            scanner.pause();
            fetch('process_qr.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'transaction_id=' + encodeURIComponent(decodedText)
})
.then(response => response.json())
.then(data => {
    console.log("Response dari server:", data); // Tambahkan log ini

    function playSound(status) {
        let audioFile = status === "success" ? "success.mp3" : "error.mp3";
        let audio = new Audio("assets/sounds/" + audioFile);
        audio.play();
    }

    if (data && data.status) { // Pastikan respons ada sebelum menggunakan data.status
        Swal.fire({
            title: data.status === "success" ? "Success!" : "Error!",
            text: data.message,
            icon: data.status === "success" ? "success" : "error",
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            scanner.resume();
        });

        // Putar suara berdasarkan status
        playSound(data.status);
    } else {
        console.error("Format response tidak sesuai:", data);
    }
})
.catch(error => {
    console.error("Error saat fetch:", error);
    Swal.fire({
        title: "Error!",
        text: "Terjadi kesalahan saat menghubungi server!",
        icon: "error"
    });
    scanner.resume(); // Pastikan scanning tetap lanjut jika ada error
});
        },
        (errorMessage) => {
            console.warn(errorMessage); // Jika gagal scan
        }
    ).catch(err => {
        console.error("Gagal membuka kamera:", err);
    });
});

    </script>
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
#reader {
    width: 100vw;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background-color: black; /* Agar tampilan lebih jelas */
    display: flex;
    justify-content: center;
    align-items: center;
}


#reader video {
    width: 100vw !important;
    height: 100vh !important;
    object-fit: cover; /* Agar video menyesuaikan layar */
    transform: scaleX(-1);
}

        #result {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }

	</style>
</html>
