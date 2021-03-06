<?php require_once __DIR__ . "/../config/database.php"; ?>

<?php
if (!isset($_SESSION)) {
    session_start();
}
session_unset();
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = false;
    $error_message = "<ul class='text-danger'>";
    if (empty($_POST['email'])) {
        $error_message .= "<li> Please enter an email </li>";
        $errors = true;
    }
    if (empty($_POST['password'])) {
        $error_message .= "<li> Please enter a password </li>";
        $errors = true;
    }


    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $user = $db->query("SELECT * FROM users WHERE email='$email' LIMIT 1")->fetch();
        // echo $user['username'];
    } catch (\Exception $err) {
        $error_message .= "<li> User not found </li>";
        print_r($err);
    }

    if (password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['password'] = $user['password'];
        header("Location: /admin/posts.php");
    } else {
        echo "<li> Invalid credentials </li>";
    }
}
?>
<title>LOGIN</title>
<style lang="css">
    body {
        margin: 0;
        padding: 0;
        font-family: sans-serif;
        background: linear-gradient(to right, #b92b27, #1565c0)
    }

    .card {
        height: 100vh;
        border: none;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .box {
        width: 500px;
        padding: 40px;
        background: #191919;
        text-align: center;
        transition: 0.25s;
    }

    .box input[type="text"],
    .box input[type="email"],
    .box input[type="password"] {
        border: 0;
        background: none;
        display: block;
        margin: 20px auto;
        text-align: center;
        border: 2px solid #3498db;
        padding: 10px 10px;
        width: 250px;
        outline: none;
        color: white;
        border-radius: 24px;
        transition: 0.25s
    }

    .box h1 {
        color: white;
        text-transform: uppercase;
        font-weight: 500
    }

    .box input[type="text"]:focus,
    .box input[type="email"]:focus,
    .box input[type="password"]:focus {
        width: 300px;
        border-color: #2ecc71
    }

    .box input[type="submit"] {
        border: 0;
        background: none;
        display: block;
        margin: 20px auto;
        text-align: center;
        border: 2px solid #2ecc71;
        padding: 14px 40px;
        outline: none;
        color: white;
        border-radius: 24px;
        transition: 0.25s;
        cursor: pointer
    }

    .box input[type="submit"]:hover {
        background: #2ecc71
    }

    .forgot {
        text-decoration: underline
    }

    ul.social-network {
        list-style: none;
        display: inline;
        margin-left: 0 !important;
        padding: 0
    }

    ul.social-network li {
        display: inline;
        margin: 0 5px
    }

    .social-network a.icoFacebook:hover {
        background-color: #3B5998
    }

    .social-network a.icoTwitter:hover {
        background-color: #33ccff
    }

    .social-network a.icoGoogle:hover {
        background-color: #BD3518
    }

    .social-network a.icoFacebook:hover i,
    .social-network a.icoTwitter:hover i,
    .social-network a.icoGoogle:hover i {
        color: #fff
    }

    a.socialIcon:hover,
    .socialHoverClass {
        color: #44BCDD
    }

    .social-circle li a {
        display: inline-block;
        position: relative;
        margin: 0 auto 0 auto;
        border-radius: 50%;
        text-align: center;
        width: 50px;
        height: 50px;
        font-size: 20px
    }

    .social-circle li i {
        margin: 0;
        line-height: 50px;
        text-align: center
    }

    .social-circle li a:hover i,
    .triggeredHover {
        transform: rotate(360deg);
        transition: all 0.2s
    }

    .social-circle i {
        color: #fff;
        transition: all 0.8s;
        transition: all 0.8s
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="box">
                    <h1>Login</h1>
                    <p class="text-muted"> Please enter your login and password!</p>
                    <input type="email" name="email" placeholder="email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <a class="forgot text-muted" href="#">Forgot password?</a>
                    <input type="submit" name="" value="Login" href="#">
                </form>
            </div>
        </div>
    </div>
</div>