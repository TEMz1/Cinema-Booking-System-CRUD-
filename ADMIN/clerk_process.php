<?php

    session_name('admin_session');
    session_start();

    if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Clerk') {
        header("Location: login.php");
        exit();
    }

    $hostname = "localhost";
    $username = "root";
    $dbname = "paragoncinemadb";

    $connect = mysqli_connect($hostname, $username) OR DIE("Connection failed!");
    $selectdb = mysqli_select_db($connect, $dbname) OR DIE("Database cannot be accessed");

    if (isset($_POST["update"])) {
        $id = $_POST["id"];
        $newUsername = $_POST["username"];
        $newpassword = $_POST["password"];
        $newName = $_POST["name"];
        $newIcNum = $_POST["icNum"];
        $newGender = $_POST["gender"];
        $newRole = $_POST["role"];

        $updateSql = "UPDATE clerk SET name = '$newName', icNum = '$newIcNum', gender = '$newGender', role = '$newRole', username = '$newUsername', password = '$newpassword' WHERE id = '$id'";

        $result = mysqli_query($connect, $updateSql);

        if ($result) {
            session_unset();
            session_destroy();
            ?><script>
                alert("Please login using the new credential");
                window.location = "login.php";
            </script><?php
            exit();
        } else {
            echo "Error updating clerk data: " . mysqli_error($connect);
        }
    }
?>