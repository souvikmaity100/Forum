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

    <!-- Slider -->
    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/s5.jpg" style="height: 400px;" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="images/s1.jpg" style="height: 400px;" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="images/s3.jpg" style="height: 400px;" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Categories Section -->
    <div class="container" style="min-height: 50vh;">
        <h2 class="text-center my-3">iDiscuss - Browse Categories</h2>
        <div class="row">
            <!-- fetch all the Categories -->
            <!-- Use a loop to iterate through categories -->
            <?php
                $sql = "SELECT * FROM `categories`";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $desc = $row['category_description'];
                    $id = $row['category_id'];
                    echo '<div class="col-md-4">
                        <div class="card my-2" style="width: 18rem;">
                            <img height="220px" src="category_img/'. $row['imgfile_name'] .'" class="card-img-top" alt="'. $row['category_name'] .'">
                            <div class="card-body">
                                <h5 class="card-title"><a class="text-dark text-decoration-none" href="threadlist.php?catid='. $id .'">'. $row['category_name'] .'</a></h5>
                                <p class="card-text">'. substr($desc, 0, 110) .'....</p>
                                <a href="threadlist.php?catid='. $id .'" class="btn btn-primary">View Threads</a>
                            </div>
                        </div>
                    </div>';
                }
            ?>

        </div>
    </div>

    <!-- Footer -->
    <?php include 'partials/_footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
</body>

</html>