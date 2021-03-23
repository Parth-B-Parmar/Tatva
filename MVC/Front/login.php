<?php include "db.php"?>
<?php session_start(); ?>
<?php 

if(isset($_POST['submit'])) {
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $email = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);
    
    $query = "SELECT * FROM users WHERE EmailID ='$email' and IsEmailVerified = 1";
    $user_query = mysqli_query($connection, $query);
    
    if(!$user_query) {
        die("query failed" . mysqli_error($connection));
    }
    
    while($row = mysqli_fetch_array($user_query)) {
        $db_user_id = $row['ID'];
        $db_email = $row['EmailID'];
        $db_role = $row['RoleID'];
        $db_password = $row['Password'];
        $db_firstname = $row['FirstName'];
        $db_lastname = $row['LastName'];
        $db_verified = $row['IsEmailVerified'];
        
    
    
    if($email !== $db_email && $password !== $db_password) {
        echo "Incorrect password";
    } else if($email == $db_email && $password == $db_password) {
        
        if($db_verified == 1) {
            $_SESSION['email'] = $db_email;
            $_SESSION['firstname'] = $db_firstname;
            $_SESSION['lastname'] = $db_lastname;
            $_SESSION['role'] = $db_role;
            header("Location: index.html");
        } else {
            header("Location: email-verification.php");
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
    <link rel="stylesheet" href="css/login.css">
    
    <title>Notes MarketPlace</title>
</head>

<body>
    
    <!-- login -->
    <section id="login-page">
        
        <img id="banner" src="images/pre-login/banner-with-overlay.jpg" alt="banner" class="img-responsive">
        <h6><img id="logo" src="images/pre-login/top-logo.png" alt="top-logo" class="img-responsive">
        </h6>
        
        <div id="login">
            
            <div class="content-box-lg">
                
                <div class="container">
                    
                    <div class="row">
                        
                        <div class="col-md-12">
                            
                            <div id="log" class="text-center">
                                
                                <form action="login.php" method="post">
                                    
                                    <h4>Login</h4>
                                    <p>Enter your email address and password to login</p>
                                   
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input name="email" type="email" class="form-control" id="email" placeholder="Enter your email">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Password</label><a href="forgot-password.html" class="btn">Forgot Password?</a>
                                        <input name="password" type="password" class="form-control" id="password" placeholder="Enter your password">
                                        <span><img id="eye" src="images/pre-login/eye.png" alt="eye" class="img-responsive" onclick="myFunction()"></span>
                                
                                    </div>
                                    
                                    <div class="form-check form-group">
                                        <input type="checkbox" class="form-check-input" id="checkbox"> 
                                        <label id="me">Remember Me</label>
                                    </div>
                                    
                                    <div id="log-button">
                                        <button type="submit" name="submit">LOGIN</button>
                                    </div>
                                    
                                    <div id="footer">
                                        <p class="text">Don't have an account?<a href="signup.html"> Sign Up</a></p>
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


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    
    
<!-- Bootstrap -->
    <script src="js/bootstrap/bootstrap.min.js"></script>
    
<!-- JS -->
    <script src="js/login.js"></script>  
</html>