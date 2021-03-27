<?php include "db.php"?>
<?php 

if(isset($_POST['submit'])) {
    
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirmpassword'];
    
    
    $firstname = mysqli_real_escape_string($connection, $firstname);
    $lastname = mysqli_real_escape_string($connection, $lastname);
    $email = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);
    $confirm_password = mysqli_real_escape_string($connection, $confirm_password);
    
    $token = bin2hex(random_bytes(10));
    
    $query = "SELECT * FROM users where EmailID = '$email' ";
    $select_email_query = mysqli_query($connection, $query);
    
    $emailcount = mysqli_num_rows($select_email_query);
    
    if($emailcount > 0) {
        echo "email already exists";
    } else {
        if($password === $confirm_password){
            $insertroles = "INSERT INTO userroles(Name, Description) VALUES ('Member', 'This is Member')";
            $rolequery = mysqli_query($connection, $insertroles);
            
            if($rolequery) {
                $insertusers = "INSERT INTO users (RoleID, FirstName, LastName, EmailID, Password, IsEmailVerified, token) VALUES (LAST_INSERT_ID(), '$firstname', '$lastname', '$email',$password, 0, '$token')";
                
                $userquery = mysqli_query($connection, $insertusers); 
                if($userquery) {
                    
                    $to = $email;
                    $subject = "Note Marketplace - Email Verification";
                    $body = "Hello $firstname,<br><br> ";
                    $body.= "Thank you for signing up with us. Please click on below link to verify your email address and to do login. <a href='http://localhost/NoteMarketPlace/front/email-verification.php?token=$token'>Verify</a> ";
                    $body.= "$token ";
                    $body.= "Regards, ";
                    $body.= "Notes Marketplace";
                    
                    $headers = "From: pp895131@gmail.com" ;
                    $headers .= "MIME-Version: 1.0" . "\r\n" ;
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    
                    if(mail($to, $subject, $body, $headers))  {
                        echo "Sent";
                    } else {
                        echo "failed";
                    }
                    
                    
                    
                } else {
                    echo "query failed" . mysqli_error($connection);
                }
            } else {
                echo "query failed" . mysqli_error($connection);
            }
            
        }
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
    <link rel="stylesheet" href="css/signup.css">
    
    <title>Notes MarketPlace</title>
</head>

<body>
    
    <section>
        
        <img id="banner" src="images/pre-login/banner-with-overlay.jpg" alt="banner" class="img-responsive">
        <h6><img id="logo" src="images/pre-login/top-logo.png" alt="top-logo" class="img-responsive">
        </h6>
        
        <div id="signup" class="text-center" align="center">
           
            <form action="signup.php" method="post">
                
                <h4>Create an Account</h4>
                <p>Enter your details to signup</p>
                
                <div class="form-group">
                    <label>First Name</label>
                    <input name="firstname" type="text" class="form-control" id="first-name" placeholder="Enter your first name" required>
                </div>
                
                <div class="form-group">
                    <label>Last Name</label>
                    <input name="lastname" type="text" class="form-control" id="last-name" placeholder="Enter your last name" required>
                </div>
                
                <div class="form-group">
                    <label>Email</label>
                    <input name="email" type="email" class="form-control" id="email" placeholder="Enter your email address" required>
                </div>
                
                <div class="form-group">
                    <label>Password</label>
                    <input name="password" type="password" class="form-control" id="password" placeholder="Enter your password">
                    <span><img class="eye" src="images/pre-login/eye.png" alt="eye" class="img-responsive" onclick="myFunction()"></span>
                </div>
                
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input name="confirmpassword" type="password" class="form-control" id="confirm-password" placeholder="Re-enter your password">
                    <span><img class="eye" src="images/pre-login/eye.png" alt="eye" class="img-responsive" onclick="myFunction1()"></span>
                </div>
                
                <div id="signup-button">
                    <button type="submit" name="submit">SIGN UP</button>
                </div>
                
                <div id="footer">
                    <p class="text">Already have an account?<a href="login.php"> Login</a></p>
                </div>
            </form> 
        </div>
    </section>
</body>

<!-- Bootstrap -->
    <script src="js/bootstrap/bootstrap.min.js"></script>

<!-- jquery -->
    <script src="js/jquery.min.js"></script>
    
<!-- JS -->
    <script src="js/signup.js"></script>  
</html>