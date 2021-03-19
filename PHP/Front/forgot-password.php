<?php include "db.php"?>
<?php  

if(isset($_POST['submit'])) {
    
    $email = $_POST['email'];
    $email = mysqli_real_escape_string($connection, $email);
    
    $query = "SELECT * FROM users WHERE EmailID ='$email' ";
    $select_email_query = mysqli_query($connection, $query);
    
    
    if(!$select_email_query) {
        die("query failed" . mysqli_error($connection));
    }
    
    $emailcount = mysqli_num_rows($select_email_query);
    
    if($emailcount > 0) {
        
        $password = md5(time());
        $to = $email;
        $subject = "New Temporary Password has been created for you";
        $body = "Hello,<br><br> ";
        $body.= "We have generated a new password for you";
        $body.= "Password: $password ";
        $body.= "Regards, ";
        $body.= "Notes Marketplace";
                    
        $headers = "From: pp895131@gmail.com" ;
        $headers .= "MIME-Version: 1.0" . "\r\n" ;
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    
        if(mail($to, $subject, $body, $headers))  {
            $update = "UPDATE users SET Password = '$password' where EmailID = '$email' ";
            $updateQuery = mysqli_query($connection, $update);
            if(!$updateQuery) {
                echo "Error";
            }
        } else {
            echo "failed";
        }
        
        
    } else {
        echo "Not Found";
    }
}


?>



<!DOCTYPE html>
<html lang="en">
    
<head>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!--  Bootstrap Css -->
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    
    <!-- Css -->
    <link rel="stylesheet" href="css/forgot-password.css">
    
    <title>Notes MarketPlace</title>
</head>

<body>
    
    <section>
        
        <img id="banner" src="images/pre-login/banner-with-overlay.jpg" alt="banner" class="img-responsive">
        <h6><img id="logo" src="images/pre-login/top-logo.png" alt="top-logo" class="img-responsive">
        </h6>
        
        <div id="forgot-password">
            
            <div class="content-box-lg">
                
                <div class="container">
                    
                    <div class="row">
                        
                        <div class="col-md-12">
                            
                            <div id="password-forgot" class="text-center">
                                
                                <form action="forgot-password.php" method="post">
                                    
                                    <h4>Forgot Password?</h4>
                                    <p>Enter your email to reset your password</p>
                                   
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input name=email type="email" class="form-control" id="email" placeholder="Enter your email">
                                    </div>
                                    
                                    <div id="submit">
                                        <button name="submit" type="submit">SUBMIT</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
</body>

<!-- Bootstrap -->
    <script src="js/bootstrap/bootstrap.min.js"></script>

<!-- jquery -->
    <script src="js/jquery.min.js"></script>
    
<!-- JS -->
    <script src="js/script.js"></script>  
</html>