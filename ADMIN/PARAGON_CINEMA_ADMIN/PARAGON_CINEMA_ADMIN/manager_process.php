<?php
    // validate
    define('APP_ACCESS', true);
    session_name('admin_session');
    session_start();

    $hostname = "localhost";
    $username = "root";
    $dbname = "paragoncinemadb";

    $connect = mysqli_connect($hostname, $username) OR DIE("Connection failed!");
    $selectdb = mysqli_select_db($connect, $dbname) OR DIE("Database cannot be accessed");

    if (isset($_POST["update"])) {
        $id = $_POST["id"];
        $newName = $_POST["name"];
        $newIcNum = $_POST["icNum"];
        $newGender = $_POST["gender"];
        $newRole = $_POST["role"];
        $newUsername = $_POST["username"];
        $newpassword = $_POST["password"];
        
        $updateSql = "UPDATE manager SET name = '$newName', icNum = '$newIcNum', gender = '$newGender', role = '$newRole', username = '$newUsername', password = '$newpassword' WHERE id = '$id'";

        $result = mysqli_query($connect, $updateSql);

        if ($result) {
            ?><script>
                alert("Please login using the new credential");
                window.location = "manager_login.php";
            </script><?php
            exit();
        } else {
            echo "Error updating manager data: " . mysqli_error($connect);
        }
    }
?>