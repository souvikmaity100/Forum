<?php
    // Script to connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "idiscuss";

    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die("Sorry we fail to connect because of this error : ". mysqli_connect_error());
    }

?>