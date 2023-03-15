<?php
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        include '_dbconnect.php';

        $user_name = $_POST['user_name'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];
        $user_cpassword = $_POST['user_cpassword'];

        $showAlert = false;
        // Check whether this email exist in database
        $existSql = "SELECT * FROM `user895` WHERE user_email = '$user_email'";
        $existResult = mysqli_query($conn, $existSql);
        $numRows = mysqli_num_rows($existResult);
        if ($numRows > 0) {
            $showError = "Email already in use";
        }
        else {
            if ($user_password == $user_cpassword) {
                $hash = password_hash($user_password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO `user895` (`user_name`, `user_email`, `user_pass`, `user_time`) VALUES ('$user_name', '$user_email', '$hash', current_timestamp())";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $showAlert = true;
                    header("location: /forum/index.php?signupsuccess=true");
                    exit();
                }
            }
            else {
                $showError = "Password do not match";
            }
        }
        header("location: /forum/index.php?signupsuccess=false&error=$showError");
    }
    else{
        header("location: /forum");
    }
?>