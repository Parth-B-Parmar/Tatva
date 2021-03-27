<?php include "db.php"?>

<?php 

if(isset($_POST['submit'])) {
    
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $country_code = $_POST['countrycode'];
    $phone = $_POST['phone'];
    $profile_picture = $_POST['dp'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zipcode = $_POST['zipcode'];
    $country = $_POST['country'];
    $university = $_POST['university'];
    $college = $_POST['college'];
    
    //sanitizing
    $firstname       = mysqli_real_escape_string($connection, $firstname);
    $lastname        = mysqli_real_escape_string($connection, $lastname);
    $email           = mysqli_real_escape_string($connection, $email);
    $dob             = mysqli_real_escape_string($connection, $dob);
    $gender          = mysqli_real_escape_string($connection, $gender);
    $country_code    = mysqli_real_escape_string($connection, $country_code);
    $phone           = mysqli_real_escape_string($connection, $phone);
    $profile_picture = mysqli_real_escape_string($connection, $profile_picture);
    $address1        = mysqli_real_escape_string($connection, $address1);
    $address2        = mysqli_real_escape_string($connection, $address2);
    $city            = mysqli_real_escape_string($connection, $city);
    $state           = mysqli_real_escape_string($connection, $state);
    $zipcode         = mysqli_real_escape_string($connection, $zipcode);
    $country         = mysqli_real_escape_string($connection, $country);
    $university      = mysqli_real_escape_string($connection, $university);
    $college         = mysqli_real_escape_string($connection, $college);
    
    //update query
    $query = "UPDATE userprofile SET ";
    $query .= "DOB = '{$dob}', ";
    $query .= "Gender = '{$gender}', ";
    $query .= "phonenumber-CountryCode = '{$country_code}', ";
    $query .= "Phonenumber = '{$phone}', ";
    $query .= "ProfilePicture = '{$profile_picture}', ";
    $query .= "AddressLine1 = '{$address1}', ";
    $query .= "AddressLine2 = '{$address2}', ";
    $query .= "City = '{$city}', ";
    $query .= "State = '{$state}', ";
    $query .= "ZipCode = '{$zipcode}', ";
    $query .= "Country = '{$country}' ";
    $query .= "University = '{$university}', ";
    $query .= "College = '{$college}' ";
    $query .= "WHERE UserID = {$_SESSION['user_id']}";
    
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
    
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="Stylesheet" type="text/css" />
    
    
    <!-- Css -->
    <link rel="stylesheet" href="css/user-profile.css">
    
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive/user-profile.css">
    
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
                   <li class="nav-item"><a class="nav-link" href="buyer-request.html">Buyer Requests</a></li>
                   <li class="nav-item"><a class="nav-link" href="FAQ.html">FAQ</a></li>
                   <li class="nav-item"><a class="nav-link" href="contact-us.html">Contact Us</a></li>
                   <li class="nav-item"><a class="nav-link my-2 my-sm-0" href="#"><img src="images/images/reviewer-1.png" alt="reviewer" class="img-responsive reviewer" height="40px" width="40px"></a></li>
               </ul>
                <div id="logout">
                    <a class="btn" href="#" title="logout" role="button">Logout</a>
                </div>
           </div>
       </nav> 
    </header>
    <!-- header ends -->
    
    <section id="user">
        
        <div class="content-box-lg">
            
            <div class="container">
                
                <div class="row">
                    
                    <div class="col-md-12">
                        
                        <div id="name" class="text-center">
                            
                            <h3>User Profile</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Profile details -->
    <form action="user_profile.php" method="post">
    <section id="profile-details">
        
        <div class="content-box-md">
            
            <div class="container">
                
                <div class="row">
                    
                    <div class="col-md-12">
                        
                        <div id="basic">
                            
                            
                                
                                <h4>Basic Profile Details</h4>
                                
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        
                                        <div class="form-group">
                                            
                                            <label>First Name</label>
                                            <input name="firstname" type="text" class="form-control float-right" id="first-name" placeholder="Enter your first name" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        
                                        <div class="form-group">
                                            
                                            <label>Last Name</label>
                                            <input name="lastname" type="text" class="form-control" id="last-name" placeholder="Enter your last name" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        
                                        <div class="form-group">
                                            
                                            <label>Email</label>
                                            <input name="email" type="email" class="form-control" id="email" placeholder="Enter your email address" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        
                                        <div class="form-group">
                                            
                                            <label>Date Of Birth</label>
                                            <input name="dob" type="text" class="form-control" id="birthday" placeholder="Enter your date of birth">
                                            <span><img id="calender" src="images/User-Profile/calendar.png" class="img-responsive"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        
                                        <div class="form-group">
                                            
                                            <label>Gender</label>
                                            <select name="gender" class="form-control" placeholder="Select your gender">
                                                <option>Select your gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                            <span><img src="images/images/arrow-down.png" class="img-responsive arrow-down" alt="arrow-down"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        
                                        <div class="form-group">
                                            <label>Phone Number</label><br>
                                             <select name="countrycode" class="form-control" id="country-code">
                                                
                                                <option>+91</option>
                                            </select>
                                            <span><img src="images/images/arrow-down.png" class="img-responsive arrow-down" alt="arrow-down"></span>
                                            <input name="phone" type="tel" class="form-control" placeholder="Enter your phone number" id="number">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        
                                        <div class="form-group">
                                            
                                            <label>Profile Picture</label>
                                            <input name="dp" type="text-area" class="form-control" id="profile-picture" placeholder="Upload a picture">
                                            <span><img id="upload" src="images/User-Profile/upload.png" class="img-responsive"></span>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Address details -->
    <section id="address-details">
        
        <div class="content-box-md">
            
            <div class="container">
                
                <div class="row">
                    
                    <div class="col-md-12">
                        
                        <div id="address">
                                
                                <h4>Address Details</h4>
                                
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        
                                        <div class="form-group">
                                            
                                            <label>Address line 1</label>
                                            <input name="address1" type="text" class="form-control" id="address-1" placeholder="Enter your address" required> 
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        
                                        <div class="form-group">
                                            
                                            <label>Address line 2</label>
                                            <input name="address2" type="text" class="form-control" id="address-2" placeholder="Enter your address">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        
                                        <div class="form-group">
                                            
                                            <label>City</label>
                                            <input name="city" type="text" class="form-control" id="city" placeholder="Enter your city" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        
                                        <div class="form-group">
                                            
                                            <label>State</label>
                                            <input name="state" type="text" class="form-control" id="State" placeholder="Enter your state" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        
                                        <div class="form-group">
                                            
                                            <label>ZipCode</label>
                                            <input name="zipcode" type="text" class="form-control" id="zipcode" placeholder="Enter your zipcode" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        
                                        <div class="form-group">
                                            
                                            <label>Country</label>
                                            <select name="country" class="form-control">
                                                
                                                <option>Select your country</option>
                                                <option>USA</option>
                                                <option>India</option>
                                                <option>Russia</option>
                                            </select>
                                            <span><img src="images/images/arrow-down.png" class="img-responsive arrow-down" alt="arrow-down"></span>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- college information -->
    <section id="college-information">
        
        <div class="content-box-md">
            
            <div class="container">
                
                <div class="row">
                    
                    <div class="col-md-12">
                        
                        <div id="college-university">
                            
                                
                                <h4>University and College Infomation</h4>
                                
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        
                                        <div class="form-group">
                                            
                                            <label>University</label>
                                            <input name="university" type="text" class="form-control" id="university" placeholder="Enter your university">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            
                                            <label>College</label>
                                            <input name="college" type="text" class="form-control" id="college" placeholder="Enter your college">
                                        </div>
                                    </div>    
                                </div>
                                
                                <div id="submit">
                                    <button name="submit" type="submit">SUBMIT</button>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </form>
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

    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    
<!-- Bootstrap -->
    <script src="js/bootstrap/bootstrap.min.js"></script>

    
<!-- jquery -->
    <script src="js/jquery.min.js"></script>
    
    
<!-- custom -->
    <script src="js/user-profile.js"></script>
    
</html>