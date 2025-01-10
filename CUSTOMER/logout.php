<?php
    session_name('cust');
    session_start();

    if(session_destroy()){
        header("location: index.php");
    }
?>