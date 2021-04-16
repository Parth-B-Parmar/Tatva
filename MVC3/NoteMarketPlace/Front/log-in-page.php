<?php
include "db.php";
session_start();

$login_failed = false;
$email_verified = true;
$correct_email = true;
$inactive = false;
$admin_login = false;

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $email = mysqli_real_escape_string($con, $email);
    $password = mysqli_real_escape_string($con, $password);

    $query = "SELECT * FROM users WHERE emailid='$email' AND password='$password' AND isactive=1 AND roleid=1 AND isemailverified=1";
    $result = mysqli_query($con, $query);
    $user_count = mysqli_num_rows($result);

    if ($user_count == 1) {
        $_SESSION['email'] = $email;
        if (isset($_POST['remember'])) {
            setcookie('email', $email, time() + 60 * 60 * 24 * 7);
            setcookie('password', $password, time() + 60 * 60 * 24 * 7);
        }
        $userid_getter = mysqli_query($con, "SELECT userid FROM users WHERE emailid='$email'");
        while ($row = mysqli_fetch_assoc($userid_getter)) {
            $userid = $row['userid'];
        }
        $exist_userid_in_profile_checker = mysqli_query($con, "SELECT 1 FROM userprofile WHERE userid=$userid");
        $userid_count = mysqli_num_rows($exist_userid_in_profile_checker);

        //to check entry of user in userprofile
        if ($userid_count == 0)
            header('Location:user-profile-page.php');
        else
            header('Location:search-note-page.php');
    } else {
        $login_failed = true;
    }

    //email verfication checker
    $email_verification_checker = mysqli_query($con, "SELECT isemailverified FROM users WHERE emailid='$email' AND isemailverified=0");
    $email_count = mysqli_num_rows($email_verification_checker);

    if ($email_count == 1) {
        $email_verified = false;
    }

    //correct email
    $correct_email_checker = mysqli_query($con, "SELECT emailid FROM users WHERE emailid='$email'");
    $correct_email_count = mysqli_num_rows($correct_email_checker);

    if ($correct_email_count == 0) {
        $correct_email = false;
    }

    // admin checker
    $admin_checker = mysqli_num_rows(mysqli_query($con, "SELECT 1 FROM users WHERE emailid='$email' AND password='$password' AND roleid IN (2,3)"));
    $admin_checker > 0 ? $admin_login = true : "";

    //when admin is inactive
    (mysqli_num_rows(mysqli_query($con, "SELECT 1 FROM users WHERE emailid='$email' AND password='$password' AND isactive=0 ")) == 1) ? $inactive = true : $inactive = false;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <!--Meta tags-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0 ,user-scalable=no">

    <!--Title-->
    <title>Notes Marketplace</title>

    <!--Fevicon-->
    <link rel="icon" href="images/favicon.ico">

    <!--Google Fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!--Font-Awesome-->
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">

    <!--bootstrap css-->
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">

    <!--Custom css-->
    <link rel="stylesheet" href="css/style.css">

    <!--Responsive css-->
    <link rel="stylesheet" href="css/responsive.css">

</head>

<body>

    <div id="home-background">
        <div id="login-with-img">
            <!--Grid-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3 col-lg-3 col-sm-2 col-0 col-xl-4"></div>
                    <div id="log-in-logo" class="col-md-6 col-sm-8 col-12 col-lg-4 text-center">
                        <img src="images/top-logo.png" alt="White-logo" title="Website White Logo" class="img-fluid">
                    </div>
                    <div class="col-md-3 col-lg-3 col-0 col-sm-2 col-xl-4"></div>
                    <div class="col-md-3 col-lg-4 col-0 col-sm-2 col-xl-4"></div>
                    <div class="col-md-6 col-lg-4 col-12 col-sm-8 col-xl-4">
                        <!--Login form -->
                        <div id="log-in">
                            <!--Form-->
                            <form action="log-in-page.php" method="POST">
                                <h2 class="text-center">
                                    Login
                                </h2>
                                <p class="text-center">
                                    Enter your email address and password to login
                                </p>
                                <div class="form-group">
                                    <label>Email</label>
                                    <?php
                                    if (isset($_COOKIE['email'])) {
                                        $cookie_email = $_COOKIE['email'];
                                        echo " <input type='email' name='email' value='$cookie_email' class='form-control'
                                        id='login-email' placeholder='Enter your email'>";
                                    } else {
                                        echo " <input type='email' name='email' class='form-control'
                                        id='login-email' placeholder='Enter your email'>";
                                    }
                                    ?>
                                    <div class="correct-email">
                                        <?php
                                        if (!$correct_email)
                                            echo "Please Enter a Valid Email Address";
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Password</label> <a id="forget-psd" href="forgot-passowrd-page.php"
                                        class="pull-right" title="Click here if you forget your password">
                                        <h6>Forgot Password?</h6>
                                    </a><img src="images/eye.png" toggle="#login-password" alt="View Password"
                                        class="pull-right login-eye toggle-password">
                                    <?php
                                    if (isset($_COOKIE['password'])) {
                                        $cookie_password = $_COOKIE['password'];
                                        echo "<input type='password' value='$cookie_password' class='form-control' name='password' id='login-password'
                                 placeholder='Enter your password'>";
                                    } else
                                        echo "<input type='password' class='form-control' name='password' id='login-password'
                                 placeholder='Enter your password'>";
                                    ?>
                                    <div id="incorrect-psd">

                                        <!-- proper message for incorrect login fail -->
                                        <?php
                                        if ($inactive)
                                            echo "You aren't allowed to login by Administrator";
                                        else if ($admin_login)
                                            echo "Admins aren't allowed to log-in via this webpage";
                                        else if (!$email_verified)
                                            echo "Please verify your email first";
                                        else if ($login_failed)
                                            echo "The password that you've entered is incorrect!";
                                        ?>

                                    </div>
                                </div>
                                <div class="form-group form-check">
                                    <input name="remember" type="checkbox" class="form-check-input"
                                        id="login-remember-me">
                                    <label id="login-remember-me-label" class="form-check-label">
                                        <h6>Remember Me</h6>
                                    </label>
                                </div>
                                <div class="general-btn">
                                    <button id="login-btn" type="submit" name="login"
                                        class="btn btn-primary btn-block">LOGIN</button>
                                </div>
                                <div class="text-center" id="sign-up">
                                    Don't have an account?<a href="sIgn-up-page.php" title="click to Sign up"> Sign up
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-4 col-0 col-sm-2 col-lx-4"></div>
                </div>
            </div>
        </div>
    </div>

    <!--jquery js-->
    <script src="js/jquery/jquery.min.js"></script>

    <!--bootstrap js-->
    <script src="js/bootstrap/bootstrap.min.js"></script>

    <!--Custom Script-->
    <script src="js/script.js"></script>

</body>

</html>