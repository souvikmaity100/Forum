<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forum Foster - Coding Froam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
    <?php include 'partials/_header.php'; ?>
    <!-- <?php include 'partials/_dbconnect.php'; ?> -->
    <?php include 'partials/_timeDiff.php'; ?>

    <?php
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `threads` WHERE thread_id = $id";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $thread_title = $row['thread_title'];
            $thread_desc = $row['thread_desc'];
            $thread_user_id = $row['thread_user_id'];

            $sql2 = "SELECT `user_name` FROM `user895` WHERE `sno`= '$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $user = mysqli_fetch_assoc($result2);
        }
    ?>

    <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == 'POST') {
                // Record insert into comment database
                $comment = $_POST['comment'];

                // string replace
                $comment = str_replace("<", "&lt;", $comment);
                $comment = str_replace(">", "&gt;", $comment);

                $userid = $_SESSION['userid'];

                $th_sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `user_id`, `comment_time`) VALUES ('$comment', '$id', '$userid', current_timestamp())";
                $th_result = mysqli_query($conn, $th_sql);
                if ($th_result) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your comment has been added!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                }
            }
        }
    ?>

    <!-- Threads Section -->
    <div class="container my-4">
        <div class="alert alert-primary py-4" role="alert">
            <h2 class="alert-heading"><?php echo $thread_title; ?></h2>
            <p><?php echo $thread_desc; ?></p>
            <p class="mt-4">Posted by: <b><?php echo $user['user_name']; ?></b>
            <hr>
            <p class="mb-0">This is perr to peer forum. Keep it friendly. Be courteous and respectful. Appreciate that
                others may have an opinion different from yours. Stay on topic. Share your knowledge. Refrain from
                demeaning, discriminatory, or harassing behaviour and speech.</p>
            </p>
        </div>
    </div>

    <!-- comment section -->
    <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
            echo '<div class="container mb-4">
                <h2 class="py-2">Post a Comment</h2>
                <form action="'. $_SERVER['REQUEST_URI'] .'" method="post">
                    <div class="mb-3">
                        <label for="comment" class="form-label fw-normal">Type your openion or answere</label>
                        <textarea class="form-control" id="comment" rows="3" name="comment"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Post Comment</button>
                </form>
            </div>';
        }
        else {
            echo '<div class="container mb-4">
                <h2 class="py-2">Post a Comment</h2>
                <p class="lead">You are not logged in. Please Login to abale start a Comment.</p>
                </div>';
        }
    ?>

    <div class="container" style="min-height: 50vh;">
        <h2 class="py-2">Discussions</h2>
        <!-- User Comments -->

        <?php
            $id = $_GET['threadid'];
            $sql = "SELECT * FROM `comments` WHERE thread_id = $id";
            $result = mysqli_query($conn, $sql);
            $noResult = true;
            while ($row = mysqli_fetch_assoc($result)) {
                $noResult = false;
                $comment_content = $row['comment_content'];
                $comment_time = $row['comment_time'];
                $thread_user_id = $row['user_id'];

                $sql2 = "SELECT `user_name`, `img_file_name` FROM `user895` WHERE `sno`= '$thread_user_id'";
                $result2 = mysqli_query($conn, $sql2);
                $user = mysqli_fetch_assoc($result2);

                echo '<div class="row g-0 mb-3">
                        <div class="col-md-1">
                            <img src="users_img/'. $user['img_file_name'] .'" width="80px"  class="rounded-circle" height="80px" alt="User Image">
                        </div>
                        <div class="col-md-10">
                            <div class="card-body">
                                <h5 class="card-title">@'. $user['user_name'] .' answered '. timediff($comment_time) .'</h5>
                                <p class="card-text fw-normal">'. $comment_content .'</p>
                            </div>
                        </div>
                    </div>';
            }
            if ($noResult) {
                   echo '<p class="text-center fs-4 my-4 fw-normal">Be the first person to share your answer</p>'; 
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