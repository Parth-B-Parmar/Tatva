<?php
include "db.php";

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$name_pattern = '/^[a-zA-Z ]{3,49}$/';

//booleans for validation
$mail_exist = false;
$mail_sent = false;
$mail_check = true;

$fname_check = true;
$lname_check = true;

//boolean for proper Password validation 
$upper_psd_check = true;
$lower_psd_check = true;
$number_psd_check = true;
$length_check = true;
$password_match = true;

//define variable for NOT NULL 
$firstName = "checked";
$lastName = "checked";

if (isset($_POST['submit'])) {
    $firstName = $_POST['fname'];
    $lastName = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $conform_psd = $_POST['conform_psd'];

    $email_checker = mysqli_query($con, "SELECT * FROM users WHERE emailid='$email'");
    $email_count = mysqli_num_rows($email_checker);

    $check_fname = preg_match($name_pattern, $firstName);
    if (!$check_fname) {
        $fname_check = false;
    }

    $check_lname = preg_match($name_pattern, $lastName);
    if (!$check_lname) {
        $lname_check = false;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mail_check = false;
    }

    $upper_psd = preg_match('@[A-Z]@', $password);
    if (!$upper_psd)
        $upper_psd_check = false;

    $lower_psd = preg_match('@[a-z]@', $password);
    if (!$lower_psd)
        $lower_psd_check = false;

    $number_check = preg_match('@[0-9]@', $password);
    if (!$number_check)
        $number_psd_check = false;


    if ($password != $conform_psd) {
        $password_match = false;
    }
    if (strlen($password) < 6) {
        $length_check = false;
    }

    //all booleans should be true
    if ($email_count == 0 && $password_match && $length_check && $lname_check && $fname_check && $mail_check && $upper_psd_check && $lower_psd_check && $number_psd_check) {

        $query = "INSERT INTO users(roleid,firstname,lastname,emailid,password,isemailverified,createddate,isactive) VALUES(1,'$firstName','$lastName','$email','$password',0,NOW(),1)";
        $result = mysqli_query($con, $query);

        //userid getter
        $id = mysqli_insert_id($con);

        //mail function
        $to = $email;
        $subject = "Note Marketplace - Email Verification";
        $body = "Hello $firstname,<br><br> ";
        $body.= "Thank you for signing up with us. Please click on below link to verify your email address and to do login. <br><br> <a href='http://localhost/MVC3/NotesMarketPlace/front/email-checker.php?id=$id'>Verify</a> <br><br>";
        $body.= "Regards, <br> ";
        $body.= "Notes Marketplace";

        $headers = "From: pp895131@gmail.com" ;
        $headers .= "MIME-Version: 1.0" . "\r\n" ;
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n" ;
        if(mail($to, $subject, $body, $headers))  {
            echo "Sent";
        } else {
            echo "failed";
        }
    }
    if ($email_count > 0) {
        $mail_exist = true;
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
                    <div class="col-lg-4 col-md-3 col-sm-2 col-0"></div>
                    <div id="logo" class="col-lg-4 col-md-6 col-sm-8 col-12 text-center signup-logo">
                        <img src="images/top-logo.png" alt="White-logo" title="Website White Logo"
                            class="img-responsive">
                    </div>
                    <div class="col-lg-4 col-md-3 col-sm-2 col-0"></div>
                    <div class="col-lg-4 col-md-3 col-sm-2 col-0"></div>
                    <div class="col-lg-4 col-md-6 col-sm-8 col-12">
                        <!--Login form -->
                        <div id="log-in" class="signup-background">
                            <form action="sign-up-page.php" method="POST">
                                <h2 class="text-center heading-login">
                                    Create an Account
                                </h2>
                                <p id="sign-up-p" class="text-center">
                                    Enter your details to signup
                                </p>
                                <div id="account-success" class="text-center">
                                    <?php
                                    if ($mail_sent)
                                        echo "<span> Your account has been successfully created</span>";
                                    ?>
                                </div>
                                <div class="form-group signup-form">
                                    <label>First Name</label>
                                    <input type="text" name="fname" class="form-control signup-input" id="fname-signup"
                                        placeholder="Enter your first name">
                                    <div class="correct-email">
                                        <?php
                                        if (strlen($firstName) == 0)
                                            echo "Please enter your first name";
                                        else  if (!$fname_check)
                                            echo "First name should be more then 3 characters!";
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group signup-form">
                                    <label>Last Name</label>
                                    <input type="text" name="lname" class="form-control signup-input" id="lname-signup"
                                        placeholder="Enter your last name">
                                    <div class="correct-email">
                                        <?php
                                        if (strlen($lastName) == 0)
                                            echo "Please enter your first name";
                                        else if (!$lname_check)
                                            echo "Last name should be more then 3 characters!";
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group signup-form">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control signup-input" id="email-signup"
                                        placeholder="Enter your email address">
                                    <div class="correct-email">
                                        <?php
                                        if ($mail_exist)
                                            echo "Email address already exists!";
                                        else if (!$mail_check)
                                            echo "Please enter Valid Email address";
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group signup-block signup-form">
                                    <label>Password</label>
                                    <img src="images/eye.png" toggle="#password-signup"
                                        class="pull-right toggle-password" alt="View">
                                    <input type="password" name="password" class="form-control signup-input"
                                        id="password-signup" placeholder="Enter your password">
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
                                <div class="form-group signup-block signup-form">
                                    <label>Confirm Password</label>
                                    <img src="images/eye.png" toggle="#re-password-signup"
                                        class="pull-right toggle-password" alt="View">
                                    <input type="password" name="conform_psd" class="form-control signup-input"
                                        id="re-password-signup" placeholder="Re-enter your password">
                                    <div class="correct-email">
                                        <?php
                                        if (!$password_match && $length_check && $upper_psd_check && $lower_psd_check && $number_psd_check)
                                            echo "The Password and Confirm Password doesn't match!";
                                        ?>
                                    </div>
                                </div>
                                <div class="general-btn">
                                    <button id="signup-btn" type="submit" name="submit"
                                        class="btn btn-primary btn-block">sign
                                        up</button>
                                </div>
                                <div class="text-center" id="sign-up">
                                    <?php
                                    if ($mail_sent) {
                                    } else
                                        echo " Already have an account?<a href='log-in-page.php' title='click to Sign up'>Login</a>";
                                    ?>
                                    <div id="thanks-signup">
                                        <?php
                                        if ($mail_sent) {
                                            echo "<h3>Please verify the email via clicking on the link we sent you at <span>" . $email . "</span>.</h3>";
                                        }
                                        ?>
                                    </div>
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