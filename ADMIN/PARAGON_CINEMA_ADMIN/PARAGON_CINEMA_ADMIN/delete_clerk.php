<?php
    session_name('admin_session');
    session_start();
    include 'dbConnect.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>CLERK | PARAGON</title>
        <link rel="shortcut icon" href="img/ten-logo.png" type="image/png">
    </head>

    <body>
    <?php
       
        $id = $_GET["kode"];

        $sql = "DELETE FROM clerk WHERE id = '$id'";
        $sendsql = mysqli_query($conn,$sql);

        if($sendsql){
            ?><script>
                alert("Data has been deleted");
                window.location = "clerk.php";
            </script><?php
            exit();
        }else{
            echo "Error deleting clerk data: " . mysqli_error($connect);
        }
        ?>

    </body>

</html>