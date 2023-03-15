<?php
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        include '_dbconnect.php';

        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];

        $sql = "SELECT * FROM `user895` WHERE user_email = '$user_email'";
        $result = mysqli_query($conn, $sql);
        $numRows = mysqli_num_rows($result);
        if ($numRows == 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($user_password, $row['user_pass'])) {
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['useremail'] = $user_email;
                $_SESSION['username'] = $row['user_name'];
                $_SESSION['userid'] = $row['sno'];
                $_SESSION['profile'] = $row['img_file_name'];
                header("location: /forum/index.php");
                exit();
            }
            else {
                $showError = "Please enter correct password";
            }
        }
        else {
            $showError = "Yoo don't have any account in this email";
        }
        header("location: /forum/index.php?loginsuccess=false&error=$showError");
    }
    else{
        header("location: /forum");
    }
?>