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
    <link rel="stylesheet" href="css/buyer-request.css">
    
    <title>Buyer Requests</title>
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
    
    <section id="my-download-page">
        <div class="content-box-lg">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div id="title">Buyer Requests</div>
                    </div>
                    
                    <div class="col-md-6">
                        <div id="search-bar-button" class="text-right">
                            <input type="text" placeholder="Search" name="search">
                            <img src="images/images/search-icon.png" class="search" class="img-responsive">
                            <a class="btn btn-general smooth-scroll" href="#" title="Search" role="button">Search</a>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">sr no.</th>
                                    <th scope="col">note title</th>
                                    <th scope="col">category</th>
                                    <th scope="col">buyer</th>
                                    <th scope="col">phone no.</th>
                                    <th scope="col">sell type</th>
                                    <th scope="col">price</th>
                                    <th scope="col">downloaded date/time</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td class="note-title">Data Science</td>
                                    <td>Science</td>
                                    <td>testting123@gmail.com</td>
                                    <td>+91 9874563527</td>
                                    <td>Paid</td>
                                    <td>$250</td>
                                    <td>27 Nov 2020, 11:24:34</td>
                                    <td><img src="images/images/eye.png" alt="eye" class="img-responsive eye"><div class="dropdown">
                                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/images/dots.png" alt="dots" class="img-responsive dots"></a>
                                    
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item" href="#">Allow Download</a> 
                                            </div>
                                    </div></td>
                                </tr>
                                
                                <tr>
                                    <td>2</td>
                                    <td class="note-title">Accounts</td>
                                    <td>Commerce</td>
                                    <td>testting123@gmail.com</td>
                                    <td>+91 9874563527</td>
                                    <td>Free</td>
                                    <td>$0</td>
                                    <td>27 Nov 2020, 11:24:34</td>
                                    <td><img src="images/images/eye.png" alt="eye" class="img-responsive eye"><div class="dropdown">
                                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/images/dots.png" alt="dots" class="img-responsive dots"></a>
                                    
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item" href="#">Allow Download</a> 
                                            </div>
                                    </div></td>
                                </tr>
                                
                                <tr>
                                    <td>3</td>
                                    <td class="note-title">Social Studies</td>
                                    <td>AI</td>
                                    <td>testting123@gmail.com</td>
                                    <td>+91 9874563527</td>
                                    <td>Free</td>
                                    <td>$0</td>
                                    <td>27 Nov 2020, 11:24:34</td>
                                    <td><img src="images/images/eye.png" alt="eye" class="img-responsive eye"><div class="dropdown">
                                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/images/dots.png" alt="dots" class="img-responsive dots"></a>
                                    
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item" href="#">Allow Download</a> 
                                            </div>
                                    </div></td>
                                </tr>
                                
                                <tr>
                                    <td>4</td>
                                    <td class="note-title">AI</td>
                                    <td>IT</td>
                                    <td>testting123@gmail.com</td>
                                    <td>+91 9874563527</td>
                                    <td>Paid</td>
                                    <td>$158</td>
                                    <td>27 Nov 2020, 11:24:34</td>
                                    <td><img src="images/images/eye.png" alt="eye" class="img-responsive eye"><div class="dropdown">
                                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/images/dots.png" alt="dots" class="img-responsive dots"></a>
                                    
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item" href="#">Allow Download</a> 
                                            </div>
                                    </div></td>
                                </tr>
                                
                                <tr>
                                    <td>5</td>
                                    <td class="note-title">Lorem ipsum</td>
                                    <td>Lorem</td>
                                    <td>testting123@gmail.com</td>
                                    <td>+91 9874563527</td>
                                    <td>Free</td>
                                    <td>$0</td>
                                    <td>27 Nov 2020, 11:24:34</td>
                                    <td><img src="images/images/eye.png" alt="eye" class="img-responsive eye"><div class="dropdown">
                                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/images/dots.png" alt="dots" class="img-responsive dots"></a>
                                    
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item" href="#">Allow Download</a> 
                                            </div>
                                    </div></td>
                                </tr>
                                
                                <tr>
                                    <td>6</td>
                                    <td class="note-title">Data Science</td>
                                    <td>Science</td>
                                    <td>testting123@gmail.com</td>
                                    <td>+91 9874563527</td>
                                    <td>Paid</td>
                                    <td>$555</td>
                                    <td>27 Nov 2020, 11:24:34</td>
                                    <td><img src="images/images/eye.png" alt="eye" class="img-responsive eye"><div class="dropdown">
                                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/images/dots.png" alt="dots" class="img-responsive dots"></a>
                                    
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item" href="#">Allow Download</a> 
                                            </div>
                                    </div></td>
                                </tr>
                                
                                <tr>
                                    <td>7</td>
                                    <td class="note-title">Accounts</td>
                                    <td>Commerce</td>
                                    <td>testting123@gmail.com</td>
                                    <td>+91 9874563527</td>
                                    <td>Free</td>
                                    <td>$0</td>
                                    <td>27 Nov 2020, 11:24:34</td>
                                    <td><img src="images/images/eye.png" alt="eye" class="img-responsive eye"><div class="dropdown">
                                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/images/dots.png" alt="dots" class="img-responsive dots"></a>
                                    
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item" href="#">Allow Download</a> 
                                            </div>
                                    </div></td>
                                </tr>
                                
                                <tr>
                                    <td>8</td>
                                    <td class="note-title">Social Studies</td>
                                    <td>Social</td>
                                    <td>testting123@gmail.com</td>
                                    <td>+91 9874563527</td>
                                    <td>Free</td>
                                    <td>$0</td>
                                    <td>27 Nov 2020, 11:24:34</td>
                                    <td><img src="images/images/eye.png" alt="eye" class="img-responsive eye"><div class="dropdown">
                                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/images/dots.png" alt="dots" class="img-responsive dots"></a>
                                    
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item" href="#">Allow Download</a> 
                                            </div>
                                    </div></td>
                                </tr>
                                
                                <tr>
                                    <td>9</td>
                                    <td class="note-title">AI</td>
                                    <td>IT</td>
                                    <td>testting123@gmail.com</td>
                                    <td>+91 9874563527</td>
                                    <td>Paid</td>
                                    <td>$250</td>
                                    <td>27 Nov 2020, 11:24:34</td>
                                    <td><img src="images/images/eye.png" alt="eye" class="img-responsive eye"><div class="dropdown">
                                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/images/dots.png" alt="dots" class="img-responsive dots"></a>
                                    
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item" href="#">Allow Download</a> 
                                            </div>
                                    </div></td>
                                </tr>
                                
                                <tr>
                                    <td>10</td>
                                    <td class="note-title">Lorem ipsum</td>
                                    <td>lorem</td>
                                    <td>testting123@gmail.com</td>
                                    <td>+91 9874563527</td>
                                    <td>Free</td>
                                    <td>$0</td>
                                    <td>27 Nov 2020, 11:24:34</td>
                                    <td><img src="images/images/eye.png" alt="eye" class="img-responsive eye"><div class="dropdown">
                                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/images/dots.png" alt="dots" class="img-responsive dots"></a>
                                    
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item" href="#">Allow Download</a> 
                                            </div>
                                    </div></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
        <!-- pagination -->
    <nav aria-label="Page navigation example" class="text-center">
        <ul class="pagination">
            <li class="page-item left-arrow"><a class="page-link" href="#"><img src="images/images/left-arrow.png" class="img-responsive" id="left-arrow"></a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">4</a></li>
            <li class="page-item"><a class="page-link" href="#">5</a></li>
            <li class="page-item right-arrow"><a class="page-link" href="#"><img src="images/images/right-arrow.png" class="img-responsive" id="right-arrow"></a></li>
        </ul>
    </nav>
    
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