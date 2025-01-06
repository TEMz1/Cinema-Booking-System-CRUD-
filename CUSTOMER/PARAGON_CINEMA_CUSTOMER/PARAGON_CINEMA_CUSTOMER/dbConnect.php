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
