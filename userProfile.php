<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forum Foster - User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
    <?php include 'partials/_header.php'; ?>


    <!-- Change DP -->
    <?php
    $em = false;
    $su = false;
        if (isset($_POST['submit']) && isset($_FILES['user_image'])) {
            
            $img_name = $_FILES['user_image']['name'];
            $img_size = $_FILES['user_image']['size'];
            $tmp_name = $_FILES['user_image']['tmp_name'];
            $error = $_FILES['user_image']['error'];

            if ($error === 0) {
                // error handaling is not done yeat, use alert for this. (importent)
                if ($img_size > 1250000) {
                    $em = "sorry! your img file is to large";
                }
                else {
                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                    $img_ex_lc = strtolower($img_ex);
                    $allowd_exs = array("jpg", "jpeg", "png");

                    if (in_array($img_ex_lc, $allowd_exs)) {
                        $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                        $img_upload_path = 'users_img/'.$new_img_name;
                        move_uploaded_file($tmp_name, $img_upload_path);

                        // upload to database

                        $sql = "UPDATE `user895` SET `img_file_name` = '$new_img_name' WHERE `sno` = ".$_SESSION['userid']."";
                        $result = mysqli_query($conn, $sql);
                    }
                    else {
                        $em = "You can't upload this type of file";
                    }
                }
            }
            else {
                $em = "unknown error occurred!";
            }

        }
        

        if (isset($_POST['user_name']) && isset($_POST['submitName'])) {
            $new_name = $_POST['user_name'];

            $sql = "UPDATE `user895` SET `user_name` = '$new_name' WHERE `sno` = ".$_SESSION['userid']."";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $su = "Your name changed succesfully.";
            }
        }

        if (isset($_POST['user_city']) && isset($_POST['submitCity'])) {
            $new_city = $_POST['user_city'];

            $sql = "UPDATE `user895` SET `user_city` = '$new_city' WHERE `sno` = ".$_SESSION['userid']."";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $su = "Your City name changed succesfully.";
            }
        }
        ?>
    <!-- Alert -->
    <?php
            if ($em) {
                echo '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                <strong>Error! </strong>'.$em.'.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
              }
            if ($su) {
                echo '<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
                <strong>Success! </strong>'.$su.'.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
              }
    ?>

    <!-- Modal for Changes -->
    <div class="modal fade" id="changeDP" tabindex="-1" aria-labelledby="changeDPLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="changeDPLabel">Update profile picture</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php $_SERVER['REQUEST_URI'] ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="file" name="user_image">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="submit" class="btn btn-primary">Update changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="changeName" tabindex="-1" aria-labelledby="changeNameLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="changeNameLabel">Change Name</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php $_SERVER['REQUEST_URI'] ?>" method="post">
                    <div class="modal-body">
                        <label for="userName">Enter new name: </label>
                        <input type="text" id="userName" name="user_name">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="submitName" class="btn btn-primary">Update changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="changeCity" tabindex="-1" aria-labelledby="changeCityLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="changeCityLabel">Change City Name</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php $_SERVER['REQUEST_URI'] ?>" method="post">
                    <div class="modal-body">
                        <label for="usercity">Enter new City name: </label>
                        <input type="text" id="usercity" name="user_city">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="submitCity" class="btn btn-primary">Update changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container my-3" style="min-height: 81vh;">
        <?php
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
                $userid = $_SESSION['userid'];
                $useremail = $_SESSION['useremail'];
                
                // Joining date
                $sql3 = "SELECT * FROM `user895` WHERE `sno` = '$userid'";
                $result3 = mysqli_query($conn, $sql3);
                while ($row = mysqli_fetch_assoc($result3)) {
                    $date = date("d/m/Y", strtotime($row['user_time']));
                    $profile = $row["img_file_name"];
                    $username = $row["user_name"];
                    $city = $row["user_city"];
                }
                
                // Question asked
                $sql = "SELECT * FROM `threads` WHERE `thread_user_id` = '$userid'";
                $result = mysqli_query($conn, $sql);
                $question = mysqli_num_rows($result);

                // Question answered
                $sql2 = "SELECT * FROM `comments` WHERE `user_id` = '$userid'";
                $result2 = mysqli_query($conn, $sql2);
                $answer = mysqli_num_rows($result2);
                
                if ($_GET['profile'] == $userid) {
                    echo '<h1 class="text-center mb-3">User Profile</h1>
                    <p class="text-center w-responsive mx-auto mb-4"></p>
                    <div class="row">
                        <div class="col-3">
                        <div class="card mb-3 ">
                                <img src="users_img/'. $profile .'" class="card-img-top" style="max-height: 300px;" alt="user image">
                                <div class="card-body">
                                <p class="card-text">Welcome '. $username .'<button type="button" class="btn btn-outline-light border border-0 position-absolute top-0 end-0" data-bs-toggle="modal" data-bs-target="#changeDP">
                                &#9998;
                                  </button></p>
                                </div>
                            </div>
                            </div>
                            <div class="col-9">
                            <form class="row g-3" action="/forum/contact.php" method="post">
                            <div class="col-md-6">
                            <label class="form-label">Name:</label>
                            <button type="button" class="btn btn-outline-light border border-0 btn-sm" data-bs-toggle="modal" data-bs-target="#changeName">
                                &#9998;
                            </button>
                            <h3>'. $username .'</h3>
                            </div>
                            <div class="col-md-6">
                            <label class="form-label">Email:</label>
                            <h3>'. $useremail .'</h3>
                            </div>
                            <div class="col-md-6">
                            <label class="form-label">Joining Date:</label>
                            <h4>'. $date .'</h4>
                            </div>
                            <div class="col-md-4">
                            <label class="form-label">City:</label>
                            <button type="button" class="btn btn-outline-light border border-0 btn-sm" data-bs-toggle="modal" data-bs-target="#changeCity">
                                &#9998;
                            </button>
                            <h4>'.$city.'</h4>
                            </div>
                            <div class="col-md-2">
                            <label class="form-label">User id:</label>
                            <h4>'. $userid .'</h4>
                            </div>
                            <div class="col-6">
                            <label class="form-label">Total Question you asked:</label>
                            <h4>'. $question .'</h4>
                            </div>
                            <div class="col-6">
                            <label class="form-label">Total Question you answered:</label>
                            <h4>'. $answer .'</h4>
                            </div>
                            <div class="col-12">
                            <a class="btn btn-outline-danger my-3" href="partials/_handleLogout.php">Logout</a>
                            </div>
                            </form>
                            </div>
                            </div>';
                }
                else {
                    // Other User
                    $otherProfile = $_GET['profile'];
                    $sql4 = "SELECT * FROM `user895` WHERE `sno` = '$otherProfile'";
                    $result4 = mysqli_query($conn, $sql4);
                    $id_alert = true;
                    
                    while ($otherUser = mysqli_fetch_assoc($result4)) {
                        $id_alert = false;
                        // Joining date
                        $date2 = date("d/m/Y", strtotime($otherUser['user_time']));
                        
                        
                        // Question asked
                        $sql5 = "SELECT * FROM `threads` WHERE `thread_user_id` = '$otherProfile'";
                        $result5 = mysqli_query($conn, $sql5);
                        $question2 = mysqli_num_rows($result5);

                        // Question answered
                        $sql6 = "SELECT * FROM `comments` WHERE `user_id` = '$otherProfile'";
                        $result6 = mysqli_query($conn, $sql6);
                        $answer2 = mysqli_num_rows($result6);

                        echo '<h1 class="text-center mb-3">User Profile</h1>
                        <p class="text-center w-responsive mx-auto mb-4"></p>
                        <div class="row">
                        <div class="col-3">
                            <div class="card mb-3">
                                    <img src="users_img/'. $otherUser['img_file_name'] .'" class="card-img-top" style="max-height: 300px;" alt="user image">
                                    <div class="card-body">
                                    <p class="card-text">This is '. $otherUser['user_name'] .'</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-9">
                            <form class="row g-3" action="/forum/contact.php" method="post">
                                    <div class="col-md-4">
                                        <label class="form-label">Name:</label>
                                        <h3>'. $otherUser['user_name'] .'</h3>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">City:</label>
                                        <h4>'. $otherUser['user_city'] .'</h4>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">User id:</label>
                                        <h4>'. $otherUser['sno'] .'</h4>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Joining Date:</label>
                                        <h4>'. $date2 .'</h4>
                                    </div>
                                        <div class="col-4">
                                        <label class="form-label">Total Question you asked:</label>
                                        <h4>'. $question2 .'</h4>
                                        </div>
                                        <div class="col-4">
                                        <label class="form-label">Total Question you answered:</label>
                                        <h4>'. $answer2 .'</h4>
                                        </div>
                                        </form>
                                        </div>
                                        </div>';
                    }
                                if ($id_alert) {
                                    echo '<div class="container mb-4">
                <h2 class="py-2">Alert!</h2>
                <p class="lead">This content is not available at the moment</p>
                </div>';
                                }
                                }
                            }
            else{
                echo '<div class="container mb-4">
                <h2 class="py-2">Alert!</h2>
                <p class="lead">You are not logged in. Please Login to abale to see user profile.</p>
                </div>';
            }
        ?>
    </div>

    <!-- Footer -->
    <?php include 'partials/_footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
        </script>
</body>

</html>