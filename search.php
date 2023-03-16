<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forum Foster - Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
    <?php include 'partials/_header.php'; ?>
    <!-- <?php include 'partials/_dbconnect.php'; ?> -->

    <div class="container my-3" style="min-height: 81vh;">
        <!-- Search Result -->
        <h2 class="my-4">Search results for <em>"<?php
            $search = $_GET['search_query'];
            echo substr($search, 0, 50);
            if (strlen($search) > 50 ) {
                echo ".....";
            } ?>"</em></h2>
        <!-- Search Result Query-->
        <?php
            $que = $_GET['search_query'];
            $sql = "SELECT * FROM `threads` WHERE MATCH(`thread_title`,`thread_desc`) AGAINST ('$que')";
            $result = mysqli_query($conn, $sql);
            $noResult = true;
            while ($row = mysqli_fetch_assoc($result)) {
                $noResult = false;
                $thread_title = $row['thread_title'];
                $thread_desc = $row['thread_desc'];
                $thread_id = $row['thread_id'];

                $url = "thread.php?threadid=". $thread_id;
    
                echo '<div class="result">
                    <h3 class="mb-1"><a href="'. $url .'" class="text-dark text-decoration-none">'. $thread_title .'</a></h3>
                    <p>'. $thread_desc .'</p>
                </div>';
            }
            if ($noResult) {
                echo '<div class="container">
                <h3 class="text-center fs-4 my-4">No Result Found</h3>
                <p class="fs-4 my-2">Suggestions:
                    <ul>
                        <li>Make sure that all words are spelled correctly.</li>
                        <li>Try different keywords.</li>
                    </ul>
                </p>
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

