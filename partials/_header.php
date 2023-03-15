<?php
    session_start();
    echo '
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="/forum">iDiscuss</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="/forum">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="guideline.php">Guidelines</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Top Category
            </a>
            <ul class="dropdown-menu">';

            include '_dbconnect.php';
            $sql = "SELECT category_id, category_name FROM `categories` LIMIT 4";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
              $cat_id = $row['category_id'];
              $cat_name = $row['category_name'];
              echo'<li><a class="dropdown-item" href="threadlist.php?catid='. $cat_id .'">'. $cat_name .'</a></li>';
            }
            echo '</ul>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                  </ul>
                  <form class="d-flex" role="search" action="search.php" method="get">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_query">
                    <button class="btn btn-success" type="submit">Search</button>
                </form>';

        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {
          echo '<div class="mx-2">
                    <a class="btn rounded-circle p-0" href="userProfile.php?profile='. $_SESSION['userid'] .'"><img src="users_img/'. $_SESSION["profile"] .'" width="40px"  height="40px" class="rounded-circle" alt="User Image"></a>
                </div>
                ';
        }
        else{
           echo'<div class="mx-2">
                  <button class="btn btn-outline-primary ml-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                  <button class="btn btn-outline-primary ml-2" data-bs-toggle="modal" data-bs-target="#signupModal">Signup</button>
              </div>';
        }

      echo '</div>
    </div>
  </nav>';

  include 'partials/_loginModal.php';
  include 'partials/_signupModal.php';

  // Error and Alerts

  if (isset($_GET['signupsuccess']) && $_GET['signupsuccess']== 'true') {
    echo '<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
    <strong>Success!</strong> You can now login.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
  }
  if (isset($_GET['signupsuccess']) && $_GET['signupsuccess']== 'false') {
    echo '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
    <strong>Error! </strong>'. $_GET['error'] .'.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
  }
  if (isset($_GET['loginsuccess']) && $_GET['loginsuccess']== 'false') {
    echo '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
    <strong>Error! </strong>'. $_GET['error'] .'.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
  }
?>

