<html lang="en">
    
    <head>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!--  Bootstrap Css -->
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    
    <!-- font awesome -->
    <link rel="stylesheet" href="css/Font-Awesome/font-awesome-4.7.0/css/font-awesome.min.css">
    
    <!-- Css -->
    <link rel="stylesheet" href="css/add-notes.css">
    
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
                   
                       <div class="dropdown">
                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/images/reviewer-1.png" alt="reviewer" class="img-responsive reviewer" height="40px" width="40px"></a>
                                    
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#">My Profile</a>
                                <a class="dropdown-item" href="#">My Downloads</a>
                                <a class="dropdown-item" href="#">My Sold Notes</a>
                                <a class="dropdown-item" href="#">My Rejected Notes</a>
                                <a class="dropdown-item" href="#">Change Password</a>
                                <a class="dropdown-item button" href="#">Logout</a> 
                            </div>
                        </div>
                   
               </ul>
                <div id="logout">
                    <a class="btn" href="#" title="logout" role="button">Logout</a>
                </div>
           </div>
       </nav> 
    </header>
    <!-- header ends -->
    <section id="add-notes">
        
        <div class="content-box-lg">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div id="top-heading" class="text-center">
                            <h3>Add Notes</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section id="basic-note-detail">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h4>Basic Note Details</h4>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div id="note-detail-form">
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" placeholder="Enter your notes title" id="title" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <input type="text" class="form-control" placeholder="Select your category" id="category" required>
                                        <img src="images/images/arrow-down.png" class="arrow-down img-responsive" alt="arrow-down">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Display Picture</label>
                                        <input type="text-area" class="form-control" placeholder="Upload a picture" id="picture">
                                        <span><img id="upload" src="images/User-Profile/upload.png" class="img-responsive"></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Upload Notes</label>
                                        <input type="text-area" class="form-control" placeholder="Upload your notes" id="notes">
                                        <span><img id="upload-notes" src="images/images/upload-note.png" class="img-responsive"></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Type</label>
                                        <input type="text" class="form-control" placeholder="Select your note type" id="type">
                                        <span><img src="images/images/arrow-down.png" class="arrow-down img-responsive" alt="arrow-down"></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Number of Pages</label>
                                        <input type="text" class="form-control" placeholder="Enter number of note pages" id="pages">
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group description-box">
                                        <label>Description</label>
                                        <input type="text" class="form-control" placeholder="Enter your description" id="description">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section id="info-institute">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h4>Institution Information</h4>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div id="institution">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Country</label>
                                    <input type="text" class="form-control" placeholder="Select your country" id="country">
                                    <span><img src="images/images/arrow-down.png" class="img-responsive arrow-down"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Institution Name</label>
                                    <input type="text" class="form-control" placeholder="Enter your institution name" id="institution-name">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section id="course-details">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h4>Course Details</h4>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div id="course">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Course Name</label>
                                    <input type="text" class="form-control" placeholder="Enter your course name" id="course-name">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Course Code</label>
                                    <input type="text" class="form-control" placeholder="Enter your course code" id="course-code">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Professor / Lecturer</label>
                                    <input type="text" class="form-control" placeholder="Enter your professor name" id="professor-name">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section id="info-selling">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h4>Selling Information</h4>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div id="selling">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="radio">
                                    <label>
                                        <input type="radio" value="Free">Free
                                        <span></span>
                                    </label>
                                    <label>
                                        <input type="radio" value="Paid">Paid
                                        <span></span>
                                    </label>
                                    
                                </div>
                                <div class="form-group">
                                    <label class="sell">Sell Price</label>
                                    <input type="text" class="form-control" placeholder="Enter your price" id="sell-price">
                                </div>
                                
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Note Preview</label>
                                    <input type="text-area" class="form-control" placeholder="Upload a file" id="file-upload">
                                    <span><img id="upload" src="images/User-Profile/upload.png" class="img-responsive"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div id="save-btn">
                                
                                    <a class="btn btn-general smooth-scroll" href="#" title="SAVE" role="button">Save</a>
                                </div>
                                
                                <div id="publish-btn">
                                
                                    <a class="btn btn-general smooth-scroll" href="#" title="PUBLISH" role="button">Publish</a>
                                </div>
                            </div>
                        </div>
                    </div>
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

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<!-- Bootstrap -->
    <script src="js/bootstrap/bootstrap.min.js"></script>

<!-- jquery -->
    <script src="js/jquery.min.js"></script>
    
</html>