<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iDiscuss - Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
    <?php include 'partials/_header.php'; ?>
    <!-- <?php include 'partials/_dbconnect.php'; ?> -->

    <?php
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'POST') {
            // Record insert into thread database
            $con_name = $_POST['con_name'];
            $con_email = $_POST['con_email'];
            $con_phone = $_POST['con_phone'];
            $con_city = $_POST['con_city'];
            $con_zip = $_POST['con_zip'];
            $con_message = $_POST['con_message'];

            $con_sql = "INSERT INTO `contact_us` (`con_name`, `con_email`, `con_phone`, `con_city`, `con_zip`, `con_message`, `con_time`) VALUES ('$con_name', '$con_email', '$con_phone', '$con_city', '$con_zip', '$con_message', current_timestamp())";
            $con_result = mysqli_query($conn, $con_sql);
            if ($con_result) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Thank you '. $con_name .' for your fidback.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
        }
        
    ?>

    <div class="container my-3" style="min-height: 81vh;">
        <h1 class="text-center mb-3">Contact Us</h1>
        <p class="text-center w-responsive mx-auto mb-4">Do you have any questions? Please do not hesitate to contact us
            directly. Our team will come back to you within
            a matter of hours to help you.</p>
        <div class="row">
            <div class="col-3">
            <div class="card mb-3">
                    <img src="images/contact.png" class="card-img-top" alt="iDiscuss Contact Us">
                    <div class="card-body">
                        <p class="card-text">Just send us your questions or concerns. We will give you the help</p>
                    </div>
                </div>
            </div>
            <div class="col-9">
                <form class="row g-3" action="/forum/contact.php" method="post">
                    <div class="col-md-6">
                        <label for="con_name" class="form-label">Name*</label>
                        <input type="text" class="form-control" id="con_name" name="con_name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="con_email" class="form-label">Email*</label>
                        <input type="email" class="form-control" id="con_email" name="con_email" required>
                    </div>
                    <div class="col-md-6">
                        <label for="con_phone" class="form-label">Phone number</label>
                        <input type="text" class="form-control" id="con_phone" placeholder="+91 000 000 0000"
                            name="con_phone">
                    </div>
                    <div class="col-md-4">
                        <label for="con_city" class="form-label">City*</label>
                        <input type="text" class="form-control" id="con_city" name="con_city" required>
                    </div>
                    <div class="col-md-2">
                        <label for="con_zip" class="form-label">Zip*</label>
                        <input type="text" class="form-control" id="con_zip" name="con_zip" required>
                    </div>
                    <div class="col-12">
                        <label for="con_message" class="form-label">Message*</label>
                        <textarea class="form-control" id="con_message" rows="3" name="con_message" required></textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <?php include 'partials/_footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
</body>

</html>