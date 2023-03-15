<?php
    session_start();
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        session_unset();
        session_destroy();
        echo "Loggeing you out, please wait...";
        header("location: /forum");
        exit();
    }
    else{
        header("location: /forum");
    }
?>