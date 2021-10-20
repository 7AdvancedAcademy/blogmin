<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="/assets/css/fontawesome.css">
    <link rel="stylesheet" href="../assets/css/subscription.css">

    <title>Subscription</title>
</head>
<!-- Header -->
<header class="">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/">
                <h2>PHP BLOG (SEVEN)<em>.</em></h2>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/pages/about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/pages/blog.php">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/pages/contact.php">Contact Us</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="/pages/subscribe.php">Subscribe
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<body>
    <input type="checkbox" id="toggle">
    <label for="toggle" class="show-btn">Show Modal</label>
    <div class="wrapper">
        <label for="toggle">
            <i class="cancel-icon fas fa-times"></i>
        </label>
        <div class="icon"><i class="far fa-envelope"></i></div>
        <div class="content">
            <header>Subscribe with Us</header>
            <p>Subscribe to our blog and get the latest updates straight to your inbox.</p>
        </div>
        <form action="index.php" method="POST">
            <?php
            $userEmail = ""; //first we leave email field blank
            if (isset($_POST['subscribe'])) { //if subscribe btn clicked
                $userEmail = $_POST['email']; //getting user entered email
                if (filter_var($userEmail, FILTER_VALIDATE_EMAIL)) { //validating user email
                    $subject = "Thank you for Subscribing us - Blogmin ";
                    $message = "Thanks for subscribing to our blog. You'll always receive updates from us. And we won't share and sell your information.";
                    $sender = "From: blogmin";
                    //php function to send mail
                    if (mail($userEmail, $subject, $message, $sender)) {
            ?>
                        <!-- show sucess message once email send successfully -->
                        <div class="alert success-alert">
                            <?php echo "Thanks for Subscribing us." ?>
                        </div>
                    <?php
                        $userEmail = "";
                    } else {
                    ?>
                        <!-- show error message if somehow mail can't be sent -->
                        <div class="alert error-alert">
                            <?php echo "Failed while sending your mail!" ?>
                        </div>
                    <?php
                    }
                } else {
                    ?>
                    <!-- show error message if user entered email is not valid -->
                    <div class="alert error-alert">
                        <?php echo "$userEmail is not a valid email address!" ?>
                    </div>
            <?php
                }
            }
            ?>
            <div class="field">
                <input type="text" class="email" name="email" placeholder="Email Address" required value="<?php echo $userEmail ?>">
            </div>
            <div class="field btn">
                <div class="layer"></div>
                <button type="submit" name="subscribe">Subscribe</button>
            </div>
        </form>
        <div class="text">We do not share your information.</div>
    </div>
</body>

</html>