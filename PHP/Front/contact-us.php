<?php include "db.php"?>
<?php 

if(isset($_POST['submit'])) {
    
    $full_name = $_POST['full-name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $comments = $_POST['comments'];
    
    $full_name = mysqli_real_escape_string($connection, $full_name);
    $email = mysqli_real_escape_string($connection, $email);
    $subject = mysqli_real_escape_string($connection, $subject);
    $comments = mysqli_real_escape_string($connection, $comments);
    
    
    $to = "pp895131@gmail.com";
    $subject = $subject;
    $body = "Hello ,<br><br> ";
    $body.= "$comments <br><br>";
    $body.= "Regards, <br>";
    $body.= $full_name;
    
    $headers = "From: $email" ;
    $headers .= "MIME-Version: 1.0" . "\r\n" ;
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    
    if(mail($to, $subject, $body, $headers))  {
        echo "Sent";
    } else {
       echo "failed";
    }
    
    
}



?>
   
   
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
    <link rel="stylesheet" href="css/contact-us.css">
    
    <title>Notes MarketPlace</title>
</head>

<body>
    
    <!-- header -->
    <header>
       <nav class="navbar navbar-expand-lg fixed-top white-nav-top">
           <a class="navbar-brand" href="#"><img src="images/Contact-Us/logo.png"></a>
           <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
               <ul class="navbar-nav ml-auto">
                   <li class="nav-item"><a class="nav-link" href="search.html">Search Notes</a></li>
                   <li class="nav-item"><a class="nav-link" href="my-sold-notes.html">Sell Your Notes</a></li>
                   <li class="nav-item"><a class="nav-link" href="FAQ.html">FAQ</a></li>
                   <li class="nav-item"><a class="nav-link" href="contact-us.html">Contact Us</a></li>
               </ul>
                <div id="login">
                    <a class="btn" href="login.php" title="login" role="button">Login</a>
                </div>
           </div>
       </nav> 
    </header>
    <!-- header ends -->
    <section id="contact-us">
        <div class="content-box-lg">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div id="heading" class="text-center">
                            <h3>Contact Us</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section id="get-in-touch">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title">
                        <h4>Get in Touch</h4>
                        <p>Let us know how to get back to you</p>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <form action="contact-us.php" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input name="full-name" type="text" class="form-control" placeholder="Enter your full name" id="full-name">
                                </div>
                                
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input name="email" type="email" class="form-control" placeholder="Enter your email address" id="email">
                                </div>
                                
                                <div class="form-group">
                                    <label>Subject</label>
                                    <input name="subject" type="text" class="form-control" placeholder="Enter your subject" id="subject">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Comments/Questions</label>
                                    <input name="comments" type="text-area" class="form-control" placeholder="Comments..." id="comment">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div id="submit">
                                    <button name="submit" type="submit">submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <hr>
    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>Copyright &copy; TatvaSoft All rights reserved.</p>
                </div>
                
                <div class="col-md-6">
                    <ul class="social-list">
                        
                        <li><a href="#"><img src="images/images/facebook.png" class="img-responsive" alt="facebook"></a></li>
                        <li><a href="#"><img src="images/images/twitter.png" class="img-responsive" alt="twitter"></a></li>
                        <li><a href="#"><img src="images/images/linkedin.png" class="img-responsive" alt="linkedin"></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</body>

<!-- Bootstrap -->
    <script src="js/bootstrap/bootstrap.min.js"></script>

<!-- jquery -->
    <script src="js/jquery.min.js"></script>
    
<!-- JS -->
    <script src="js/script.js"></script>
</html>