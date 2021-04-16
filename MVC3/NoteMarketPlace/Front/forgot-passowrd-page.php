<?php
include "db.php";

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$mail_sent = false;
$account_exist = true;
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $query = "SELECT * FROM users WHERE emailid='$email'";
    $result = mysqli_query($con, $query);
    $email_count = mysqli_num_rows($result);

    if ($email_count == 1) {

        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        for ($i = 0; $i < 12; $i++) {
            $num = rand(0, strlen($alphabet) - 1);
            $password[$i] = $alphabet[$num];
        }

        //query for password change
        $query = "UPDATE users SET password='$password' WHERE emailid='$email'";
        mysqli_query($con, $query);

        
        
        $to = $email;
        $subject = "New Temporary Password has been created for you";
        $body = "Hello,<br><br> ";
        $body.= "We have generated a new password for you<br>Password: $password <br><br>";
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
    } else if ($email_count == 0) {
        $account_exist = false;
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
                    <div class="col-lg-3 col-md-3 col-sm-2 col-0"></div>
                    <div id="logo" class="col-lg-6 col-md-6 col-sm-8 col-12 text-center">
                        <img src="images/top-logo.png" alt="White-logo" title="Website White Logo"
                            class="img-responsive">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-2 col-0"></div>
                    <div class="col-lg-4 col-md-3 col-sm-2 col-1"></div>
                    <div class="col-lg-4 col-md-6 col-sm-8 col-10">
                        <!--Login form -->
                        <div id="log-in">
                            <!--Form-->
                            <form action="forgot-passowrd-page.php" method="POST">
                                <h2 class="text-center">
                                    Forgot Password?
                                </h2>
                                <p class="text-center">
                                    Enter your email to reset your password
                                </p>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" id="login-email"
                                        placeholder="Enter your email">
                                    <div class="correct-email">
                                        <?php
                                        if (!$account_exist) {
                                            echo "Please Enter a Valid email address!";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="general-btn">
                                    <button name="submit" id="forget-password-btn" type="submit"
                                        class="btn btn-primary btn-block">submit</button>
                                </div>
                                <div id="account-error">
                                    <?php
                                    if (!$account_exist)
                                        echo "<h3>There isn't any account associated with this email <span>" . $email . "</span></h3>";
                                    else if ($mail_sent)
                                        echo "<h3>Your password has been changed successfully and newly generated password is sent on your registered email address <span> " . $email . "</span></h3>";
                                    ?>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-3 col-sm-2 col-1"></div>
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