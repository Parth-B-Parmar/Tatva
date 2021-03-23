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
    <link rel="stylesheet" href="css/dashboard.css">
    
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
       
        <!-- dashboard -->
        <section id="dashboard">
    
            <div class="content-box-lg">
    
                <div class="container">
    
                    <div class="row">
                        <div class="col-md-6">
                           
                           <div id="heading">
                               <h4>Dashboard</h4>
                           </div>
                        </div>
                        
                        <div class="col-md-6 text-right">
                            <div id="add-btn">
                                <a class="btn btn-general btn-home smooth-scroll" href="#" title="ADD NOTE" role="button">Add Note</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        
                        <div class="col-md-2">
                            
                            <div class="myearning">
                                <img src="images/images/my-earning.png" alt="myearning" class="img-responsive">
                                
                                <p>My Earning</p>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            
                            <div class="earning">
                                
                                <div class="row">
                                    <div class="col-md-6 text-center">
                                        <h4><a href="my-sold-notes.html">100</a></h4>
                                        <p>Number of Notes Sold</p>
                                    </div>
                                    
                                    <div class="col-md-6 text-center">
                                        <h4><a href="my-sold-notes.html">$10,00,000</a></h4>
                                        <p>Money Earned</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="my-downloads text-center">
                                <h4><a href="my-downloads.html">38</a></h4>
                                <p>My Downloads</p>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="rejected-notes text-center">
                                <h4><a href="my-rejected-notes.html">12</a></h4>
                                <p>My Rejected Notes</p>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="buyer-request text-center">
                                <h4><a href="buyer-request.html">102</a></h4>
                                <p>Buyer Requests</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ends -->
    
        <!-- inprogress-notes -->
        <section id="in-progress-notes">
    
            <div class="content-box-lg">
    
                <div class="container">
    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="title">
                                <h4>In Progress Notes</h4>
                            </div>
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
                                <tr>
                                <th>ADDED DATE</th>
                                <th>TITLE</th>
                                <th>CATEGORY</th>
                                <th>STATUS</th>
                                <th>ACTIONS</th>
                                </tr>
                                <tr>
                                  <td>09-10-2020</td>
                                  <td>Data Science</td>
                                  <td>Science</td>
                                  <td>Draft</td>
                                  <td><a href="add-notes.html"><img src="images/images/edit.png" alt="edit" class="img-responsive edit"></a><img src="images/images/delete.png" alt="delete" class="img-responsive delete"></td>
                                </tr>
                                <tr>
                                  <td>10-10-2020</td>
                                  <td>Accounts</td>
                                  <td>Commerce</td>
                                  <td>In Review</td>
                                  <td><a href="note-details.html"><img src="images/images/eye.png" alt="eye" class="img-responsive eye"></a></td>
                                </tr>
                                <tr>
                                  <td>11-10-2020</td>
                                  <td>Social Studies</td>
                                  <td>Social</td>
                                  <td>Submitted</td>
                                  <td><a href="note-details.html"><img src="images/images/eye.png" alt="eye" class="img-responsive eye"></a></td>
                                </tr>
                                <tr>
                                  <td>12-10-2020</td>
                                  <td>AI</td>
                                  <td>IT</td>
                                  <td>Submitted</td>
                                  <td><a href="note-details.html"><img src="images/images/eye.png" alt="eye" class="img-responsive eye"></a></td>
                                </tr>
                                <tr>
                                  <td>13-10-2020</td>
                                  <td>Lorem ipsum dolor sit</td>
                                  <td>Lorem</td>
                                  <td>Draft</td>
                                  <td><a href="add-notes.html"><img src="images/images/edit.png" alt="edit" class="img-responsive edit"></a><img src="images/images/delete.png" alt="delete" class="img-responsive delete"></td>
                                </tr>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ends -->
        
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
    
    <section id="published-notes">
        <div class="container">
            <div class="row">
                        
                <div class="col-md-6">
                    <div class="title">
                        <h4>Published Notes</h4>
                    </div>
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
                    <tr>
                    <th>ADDED DATE</th>
                    <th>TITLE</th>
                    <th>CATEGORY</th>
                    <th>SELL TYPE</th>
                    <th>PRICE</th>
                    <th>ACTIONS</th>
                    </tr>
                    <tr>
                    <td>09-10-2020</td>
                    <td>Data Science</td>
                    <td>Science</td>
                    <td>Paid</td>
                    <td>$575</td>
                    <td><img src="images/images/eye.png" alt="eye" class="img-responsive eye"></td>
                    </tr>
                    <tr>
                    <td>10-10-2020</td>
                    <td>Accounts</td>
                    <td>Commerce</td>
                    <td>Free</td>
                    <td>$0</td>
                    <td><img src="images/images/eye.png" alt="eye" class="img-responsive eye"></td>
                    </tr>
                    <tr>
                    <td>11-10-2020</td>
                    <td>Social Studies</td>
                    <td>Social</td>
                    <td>Free</td>
                    <td>$0</td>
                    <td><img src="images/images/eye.png" alt="eye" class="img-responsive eye"></td>
                    </tr>
                    <tr>
                    <td>12-10-2020</td>
                    <td>AI</td>
                    <td>IT</td>
                    <td>Paid</td>
                    <td>$3542</td>
                    <td><img src="images/images/eye.png" alt="eye" class="img-responsive eye"></td>
                    </tr>
                    <tr>
                    <td>13-10-2020</td>
                    <td>Lorem ipsum dolor sit</td>
                    <td>Lorem</td>
                    <td>Free</td>
                    <td>$0</td>
                    <td><img src="images/images/eye.png" alt="eye" class="img-responsive eye"></td>
                    </tr>
                </table>
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
