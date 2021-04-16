<?php
include "db.php";
session_start();

if (!isset($_SESSION['email']))
    header('Location:log-in-page.php');

$upper_psd_check = true;
$lower_psd_check = true;
$number_psd_check = true;
$length_check = true;
$pass_wrong = true;

$email = $_SESSION['email'];
$query = mysqli_query($con, "SELECT * FROM users WHERE emailid='$email'");
while ($row = mysqli_fetch_array($query)) {
    $password = $row['password'];
    $userid = $row['userid'];
}

$new_pass = "";
$confirm_pass = "";
$old_pass = "";

if (isset($_POST['submit'])) {
    $old_pass = $_POST['old_pass'];
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];

    $upper_psd = preg_match('@[A-Z]@', $new_pass);
    if (!$upper_psd)
        $upper_psd_check = false;

    $lower_psd = preg_match('@[a-z]@', $new_pass);
    if (!$lower_psd)
        $lower_psd_check = false;

    $number_check = preg_match('@[0-9]@', $new_pass);
    if (!$number_check)
        $number_psd_check = false;

    if (strlen($new_pass) < 6) {
        $length_check = false;
    }
    if ($password != $old_pass) {
        $pass_wrong = false;
    }

    if ($pass_wrong && $upper_psd_check && $lower_psd_check && $number_psd_check && $length_check && $new_pass == $confirm_pass) {
        $update_pass = mysqli_query($con, "UPDATE users SET password='$new_pass',modifieddate=NOW(),modifiedby=$userid WHERE userid=$userid");
        echo '<script>alert("Your password has been changed sucessfully!\nyou will be logged out and redirect to login page")</script>';
        echo '<script>window.location.replace("logout.php")</script>';
    }
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
                    <div class="col-lg-4 col-md-3 col-sm-2 col-1"></div>
                    <div id="logo" class="col-lg-4 col-md-6 col-sm-8 col-10 text-center">
                        <img src="images/top-logo.png" alt="White-logo" title="Website White Logo" class="img-fluid">
                    </div>
                    <div class="col-lg-4 col-md-3 col-sm-2 col-1"></div>
                    <div class="col-lg-4 col-md-3 col-sm-2 col-0"></div>
                    <div class="col-lg-4 col-md-6 col-sm-8 col-12">
                        <!--Login form -->
                        <div id="log-in">
                            <!--Form-->
                            <form action="change-password-page.php" method="POST">
                                <h2 class="text-center">
                                    Change Password
                                </h2>
                                <p class="text-center">
                                    Enter your new password to change your password
                                </p>
                                <div class="form-group">
                                    <label class="change-psd-label">Old password</label>
                                    <div class="reset-passowrd-eye pull-right">
                                        <img src="images/eye.png" toggle="#old-password" class="toggle-password"
                                            alt="View"> &nbsp;
                                    </div>
                                    <input type="password" name="old_pass" class="form-control" id="old-password"
                                        placeholder="Enter your old password">
                                    <div class="correct-email">
                                        <?php
                                        if (!$pass_wrong)
                                            echo "Please Enter correct old password";
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="change-psd-label">New password</label>
                                    <div class="reset-passowrd-eye pull-right">
                                        <img src="images/eye.png" toggle="#new-password" class="toggle-password"
                                            alt="View"> &nbsp;
                                    </div> <input type="password" name="new_pass" class="form-control" id="new-password"
                                        placeholder="Enter your new password">
                                    <div class="correct-email">
                                        <?php
                                        if (!$length_check)
                                            echo "The Password Length Should be more then 6 characters";
                                        else if (!$upper_psd_check)
                                            echo "Please enter at least one uppercase letter";
                                        else if (!$lower_psd_check)
                                            echo "Please enter at least one lowercase letter";
                                        else if (!$number_psd_check)
                                            echo "Please enter at least one numeric letter";
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="change-psd-label">Confirm password</label>
                                    <div class="reset-passowrd-eye pull-right">
                                        <img src="images/eye.png" toggle="#confirm-password" class="toggle-password"
                                            alt="View"> &nbsp;
                                    </div> <input type="password" name="confirm_pass" class="form-control"
                                        id="confirm-password" placeholder="Enter your confirm password">
                                    <div class="correct-email">
                                        <?php
                                        if ($new_pass != $confirm_pass && $length_check && $upper_psd_check && $lower_psd_check && $number_psd_check)
                                            echo "Password and Confirm password doesn't match!";
                                        ?>
                                    </div>
                                </div>
                                <div class="general-btn">
                                    <button id="reset-passowrd-btn" type="submit" name="submit"
                                        class="btn btn-primary btn-block">submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-3 col-sm-2 col-0"></div>
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