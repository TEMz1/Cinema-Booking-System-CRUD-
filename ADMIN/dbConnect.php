<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("HTTP/1.1 405 Method Not Allowed");
    exit();
}
?>


<?php 
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'paragoncinemadb';

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Could not connect to MySQL: " . mysqli_connect_error());
}
?>
