<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iDiscuss - Coding Froam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
    <?php include 'partials/_header.php'; ?>
    <!-- <?php include 'partials/_dbconnect.php'; ?> -->
    <?php include 'partials/_timeDiff.php'; ?>

    <?php
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `categories` WHERE category_id = $id";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $cat_name = $row['category_name'];
            $cat_desc = $row['category_description'];
        }
    ?>

    <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == 'POST') {
                // Record insert into thread database
                $th_title = $_POST['title'];
                // string replace
                $th_title = str_replace("<", "&lt;", $th_title);
                $th_title = str_replace(">", "&gt;", $th_title);

                $th_desc = $_POST['desc'];
                // string replace
                $th_desc = str_replace("<", "&lt;", $th_desc);
                $th_desc = str_replace(">", "&gt;", $th_desc);

                $userid = $_SESSION['userid'];

                $th_sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `time_stamp`) VALUES ('$th_title', '$th_desc', '$id', '$userid', current_timestamp())
                ";
                $th_result = mysqli_query($conn, $th_sql);
                if ($th_result) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your thread has been added! Please wait for community respond.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                }
            }
        }
    ?>

    <!-- Threads Section -->
    <div class="container my-4">
        <div class="alert alert-primary py-4" role="alert">
            <h2 class="alert-heading">Welcome to <?php echo $cat_name; ?> Forum</h2>
            <p><?php echo $cat_desc; ?></p>
            <hr>
            <p class="mb-0">This is perr to peer forum. Keep it friendly. Be courteous and respectful. Appreciate that
                others may have an opinion different from yours. Stay on topic. Share your knowledge. Refrain from
                demeaning, discriminatory, or harassing behaviour and speech.</p>
            <button type="button" class="btn btn-primary mt-2">Primary</button>
        </div>
    </div>

    <!-- Discussion Section -->
    <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
            echo '<div class="container mb-4">
                <h2 class="py-2">Start a Discussion</h2>
                <form action="'. $_SERVER['REQUEST_URI'] .'" method="post">
                    <div class="mb-3">
                        <label for="title" class="form-label">Problem</label>
                        <input type="text" class="form-control" id="title" name="title" aria-describedby="titleHelp">
                        <div id="titleHelp" class="form-text">Keep your title as short and crisp as possible.</div>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Leave a comment here" id="desc" name="desc"
                            style="height: 100px"></textarea>
                        <label for="desc">Ellaborate your concern</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>';
        }
        else {
            echo '<div class="container mb-4">
                <h2 class="py-2">Start a Discussion</h2>
                <p class="lead">You are not logged in. Please Login to abale start a discussion.</p>
                </div>';
        }
    ?>

    <div class="container" style="min-height: 25vh;">
        <h2 class="py-2">Browse Questions</h2>
        <!-- User Questions -->

        <?php
            $id = $_GET['catid'];
            $sql = "SELECT * FROM `threads` WHERE thread_cat_id = $id";
            $result = mysqli_query($conn, $sql);
            $noResult = true;
            while ($row = mysqli_fetch_assoc($result)) {
                $noResult = false;
                $thread_title = $row['thread_title'];
                $thread_desc = $row['thread_desc'];
                $thread_id = $row['thread_id'];
                $thread_time = $row['time_stamp'];
                $thread_user_id = $row['thread_user_id'];

                $sql2 = "SELECT `user_name`, `img_file_name` FROM `user895` WHERE `sno`= '$thread_user_id'";
                $result2 = mysqli_query($conn, $sql2);
                $user = mysqli_fetch_assoc($result2);

                echo '<div class="row g-0 mb-3">
                        <div class="col-md-1">
                            <img src="users_img/'. $user['img_file_name'] .'" width="80px"  height="80px" class="rounded-circle" alt="User Image">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><a class="text-dark text-decoration-none" href="thread.php?threadid='. $thread_id .'">'. $thread_title .'</a></h5>
                                <p class="card-text">'. $thread_desc .'</p>
                            </div>
                        </div>
                        <h6 class="card-title col-md-3">'. $user['user_name'] .' asked '. timediff($thread_time) .'</h6>
                    </div>';
            }
            if ($noResult) {
                   echo '<p class="text-center fs-4 my-4">Be the first person to ask a question</p>'; 
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