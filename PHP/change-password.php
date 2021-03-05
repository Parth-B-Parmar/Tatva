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
    <link rel="stylesheet" href="css/change-password.css">
    
    <title>Notes MarketPlace</title>
</head>

<body>
    
    <section>
        
        <img id="banner" src="images/pre-login/banner-with-overlay.jpg" alt="banner" class="img-responsive">
        <h6><img id="logo" src="images/pre-login/top-logo.png" alt="top-logo" class="img-responsive">
        </h6>
        
        <div id="change-password">
            
            <div class="content-box-lg">
                
                <div class="container">
                    
                    <div class="row">
                        
                        <div class="col-md-12">
                            
                            <div id="password-change" class="text-center">
                                
                                <form>
                                    
                                    <h4>Change Password</h4>
                                    <p>Enter your new password to change your password</p>
                                    
                                    <div class="form-group">
                                        <label>Old Password</label>
                                        <input type="password" class="form-control" id="old-password" placeholder="Enter your old password">
                                        <span><img class="eye" src="images/pre-login/eye.png" alt="eye" class="img-responsive" onclick="myFunction()"></span>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>New Password</label>
                                        <input type="password" class="form-control" id="new-password" placeholder="Enter your new password">
                                        <span><img class="eye" src="images/pre-login/eye.png" alt="eye" class="img-responsive" onclick="myFunction1()"></span>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" class="form-control" id="confirm-password" placeholder="Enter your confirm password">
                                        <span><img class="eye" src="images/pre-login/eye.png" alt="eye" class="img-responsive" onclick="myFunction2()"></span>
                                    </div>
                                    
                                    <div id="submit">
                                        <a class="btn" href="#" title="SUBMIT" role="button">SUBMIT</a>
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
    <script src="js/change-password.js"></script>  
</html>