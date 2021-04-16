<?php
include "db.php";
session_start();

$name_pattern = "/^[a-zA-Z0-9_ ]*$/";

if (isset($_SESSION['email'])) {
    $user_email = $_SESSION['email'];
    $query = mysqli_query($con, "SELECT emailid,firstname,lastname FROM users WHERE '$user_email'=emailid");

    while ($row = mysqli_fetch_assoc($query)) {
        $user_email = $row['emailid'];
        $user_name_mail = $row['firstname'] . " " . $row['lastname'];
    }
}

$mail_sent = false;
$name_check = true;
$subject_check = true;
$des_check = true;
$mail_check = true;

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $sender_email = $_POST['sender_email'];
    $subject = $_POST['subject'];
    $comment = $_POST['comment'];

    preg_match($name_pattern, $name, $name_match);
    if (!$name_match[0]) {
        $name_check = false;
    }

    preg_match($name_pattern, $subject, $subject_match);
    if (!$subject_match[0]) {
        $subject_check = false;
    }

    preg_match($name_pattern, $comment, $comment_match);
    if (!$comment_match[0]) {
        $des_check = false;
    }

    if (!filter_var($sender_email, FILTER_VALIDATE_EMAIL)) {
        $mail_check = false;
    }

    if ($sender_email != "" && $name_check && $subject_check && $des_check && $mail_check) {
        
        if (isset($_SESSION['email'])) {
            $to = $user_email;
        } else {
            $to = $sender_email;            
        }
        $subject = $subject;
        
        if (isset($_SESSION['email'])) {
            $body = "Sender Name: <b>$user_name_mail</b><br><br>Sender Email: <b>$user_email</b><br><br> ";
            $body.= "Comment: <b>$comment</b> <br><br>";
        } else {
            $body = "Sender Name: <b>$name</b><br><br>Sender Email: <b>$sender_email_email</b><br><br> ";
            $body.= "Comment: <b>$comment</b> <br><br>";            
        }
        
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

<body class="sticky-header">

    <!--header -->
    <?php include "header.php" ?>
    <!--header end-->

    <div id="search-all-font">
        <div id="search-top-img">
            <img src="images/banner-with-overlay-user-profile.jpg" alt="Banner image" class="img-fluid">
            <div id="search-home-heading" class="text-center">
                <h3 class="heading-margin">Contact Us</h3>
            </div>
        </div>
        <div id="contact-us-heading">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="email-sucess blue-font-34 text-center">
                            <?php
                            if ($mail_sent) {
                                echo "Your Feedback is Submitted!";
                            }
                            ?>
                        </div>
                        <h4 class="blue-font-34 contact-us-heading-res">Get in Touch</h4>
                        <p id="contact-us-let-us" class="dark-font-18">Let us know how to get back to you</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact us form -->
        <div id="contact-us-form">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <form action="contact-us-page.php" method="POST">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label id="contact-us-first-label-form">Full Name *</label>
                                    <?php
                                    if (isset($_SESSION['email'])) {
                                        echo "<input value='$user_name_mail' type='text' name='name'
                                        class='form-control input-light-color' placeholder='Enter your full Name'>";
                                    } else
                                        echo "<input type='text' name='name' class='form-control input-light-color'
                                            placeholder='Enter your full Name'>";

                                    ?>
                                    <div class="correct-email">
                                        <?php
                                        if (!$name_check) {
                                            echo "Please enter your name";
                                        }
                                        ?>
                                    </div>
                                    <label class>Email Address *</label>
                                    <?php
                                    if (isset($_SESSION['email']))
                                        echo "<input type='mail' value='$user_email' name='sender_email' class='form-control input-light-color'
                                               placeholder='Enter your email address'>";
                                    else echo "<input type='mail' name='sender_email' class='form-control input-light-color'
                                                placeholder='Enter your email address'>"
                                    ?>
                                    <div class="correct-email">
                                        <?php
                                        if (!$mail_check) {
                                            echo "Please enter your correct email address";
                                        }
                                        ?>
                                    </div>
                                    <label>Subject *</label>
                                    <input type="text" name="subject" class="form-control input-light-color"
                                        placeholder="Enter your subject Name">
                                    <div class="correct-email">
                                        <?php
                                        if (!$subject_check) {
                                            echo "Please enter subject";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label id="contact-us-comment" class="right-content">Comments / Questions *</label>
                                    <textarea id="contact-us-comment-box" name="comment"
                                        class="form-control right-content contact-us-res input-light-color"
                                        placeholder="Comments...."></textarea>
                                    <div class="correct-email right-content">
                                        <?php
                                        if (!$des_check) {
                                            echo "Please enter proper Comments / Questions";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div id="contact-us-btn">
                                <button type="submit" name="submit"
                                    class="btn btn-primary blue-button-hover-white">submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact us form end-->

        <!--footer-->
        <?php include "footer.php"; ?>
        <!--footer end-->
    </div>


    <!--popper js-->
    <script src="js/popper/popper.min.js"></script>

    <!--jquery js-->
    <script src="js/jquery/jquery.min.js"></script>

    <!--bootstrap js-->
    <script src="js/bootstrap/bootstrap.min.js"></script>

    <!--Custom Script-->
    <script src="js/script.js"></script>

</body>

</html>