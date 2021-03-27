<?php include "db.php" ?>
  
<?php 

if(isset($_POST['search']) or isset($_POST['type']) or isset($_POST['category']) or isset($_POST['university']) or isset($_POST['course']) or isset($_POST['country']) or isset($_POST['rating'])) {
    echo "running";
    
} else {
    echo "no";
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
    <link rel="stylesheet" href="css/search.css">
    
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
                    <a class="btn" href="login.html" title="login" role="button">Login</a>
                </div>
           </div>
       </nav> 
    </header>
    <!-- header ends -->
    
    <section id="search-page">
        
        <div class="content-box-lg">
            
            <div class="container">
                
                <div class="row">
                    
                    <div class="col-md-12">
                        
                        <div id="heading" class="text-center">
                            
                            <h3>Search Notes</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section id="search-filter">
        
        <div class="content-box-lg">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div id="search-filter-heading">
                            <h4>Search and Filter notes</h4>
                        </div>
                    </div>
                </div>
                <div class="wrapper">
                    <form action="" method="post">
                    <div class="row">

                        <div class="col-md-12">
                           
                            <div class="filter-form">

                                    <div class="form-group">
                                       
                                        <img src="images/images/search-icon.png" class="img-responsive search" alt="search">
                                        <input name="search" type="search" class="form-control" placeholder="Search notes here..." id="search-notes">
                                    </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-2">

                            <div class="filter-form">

                                    <div class="form-group filter">

                                        <select name="type" class="form-control">
                                            <option>Select type</option>
                                            <option>HandWritten</option>
                                            <option>Notebook</option>
                                            <option>Novel</option>
                                            <option>University Notes</option>
                                        </select>
                                        <img src="images/User-Profile/down-arrow.png" class="img-responsive down-arrow">
                                    </div>
                            </div>
                        </div>

                        <div class="col-md-2">

                            <div class="filter-form">

                                    <div class="form-group filter">

                                        <select name="category" class="form-control">
                                            <option>Select category</option>
                                            <option>IT</option>
                                            <option>CS</option>
                                            <option>CA</option>
                                            <option>MBA</option>
                                        </select>
                                        <img src="images/User-Profile/down-arrow.png" class="img-responsive down-arrow">
                                    </div>
                            </div>
                        </div>

                        <div class="col-md-2">

                            <div class="filter-form">

                                    <div class="form-group filter">

                                        <select name="university" class="form-control">
                                            <option>Select university</option>
                                        </select>
                                        <img src="images/User-Profile/down-arrow.png" class="img-responsive down-arrow">
                                    </div>
                            </div>
                        </div>

                        <div class="col-md-2">

                            <div class="filter-form">

                                    <div class="form-group filter">

                                        <select name="course" class="form-control">
                                            <option>Select course</option>
                                        </select>
                                        <img src="images/User-Profile/down-arrow.png" class="img-responsive down-arrow">
                                    </div>
                            </div>
                        </div>

                        <div class="col-md-2">

                            <div class="filter-form">

                                    <div class="form-group filter">

                                        <select name="country" class="form-control">
                                            <option>Select country</option>
                                        </select>
                                        <img src="images/User-Profile/down-arrow.png" class="img-responsive down-arrow">
                                    </div>
                            </div>
                        </div>

                        <div class="col-md-2">

                            <div class="filter-form">

                                    <div class="form-group filter">

                                        <select name="rating" class="form-control">
                                            <option>Select rating</option>
                                            <option>1+</option>
                                            <option>2+</option>
                                            <option>3+</option>
                                            <option>4+</option>
                                            <option>5</option>
                                        </select>
                                        <img src="images/User-Profile/down-arrow.png" class="img-responsive down-arrow">
                                    </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Notes -->
    <section id="notes">
        <div id="note-heading">
            <h4>Total 18 notes</h4>
        </div>
        
        <div class="content-box-lg">
            
            <div class="container">
                
                <div class="row">
                    
                    <!-- 1 -->
                    <div class="col-md-4">
                        
                        <div class="notes">
                            
                            <img src="images/Search/1.jpg" alt="note" class="img-responsive note-image">
                            <h4>Computer Operating System - Final Exam Book With Paper Solution</h4>
                            <ul class="note-details">
                                
                                <li><img src="images/images/university.png" alt="university" class="img-responsive">University of California, US</li>
                                <li><img src="images/images/pages.png" alt="pages" class="img-responsive">204 Pages</li>
                                <li><img src="images/images/date.png" alt="date" class="img-responsive">Thu, Nov 26 2020</li>
                                <li><img src="images/images/flag.png" alt="flag" class="img-responsive">5 Users marked this note as inapropriate</li>
                            </ul>
                        
                        
                            <div class="rate">
                               
                               <img src="images/images/star.png" class="img-responsive">
                               <img src="images/images/star.png" class="img-responsive">
                               <img src="images/images/star.png" class="img-responsive">
                               <img src="images/images/star.png" class="img-responsive">
                               <img src="images/images/star.png" class="img-responsive"> 
                               <p>100 reviews</p> 
                            </div>
                        </div>
                    </div>
                    
                    <!-- 2 -->
                    <div class="col-md-4">
                        
                        <div class="notes">
                            
                            <img src="images/Search/2.jpg" alt="note" class="img-responsive note-image">
                            <h4>Computer Science</h4>
                            <ul class="note-details">
                                
                                <li><img src="images/images/university.png" alt="university" class="img-responsive">University of California, US</li>
                                <li><img src="images/images/pages.png" alt="pages" class="img-responsive">204 Pages</li>
                                <li><img src="images/images/date.png" alt="date" class="img-responsive">Thu, Nov 26 2020</li>
                                <li><img src="images/images/flag.png" alt="flag" class="img-responsive">5 Users marked this note as inapropriate</li>
                            </ul>
                        
                        
                            <div class="rate">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <p>100 reviews</p> 
                            </div>
                        </div>
                    </div>
                    
                    <!-- 3 -->
                    <div class="col-md-4">
                        
                        <div class="notes">
                            
                            <img src="images/Search/3.jpg" alt="note" class="img-responsive note-image">
                            <h4>Basic Computer Engineering Tech India Publication series</h4>
                            <ul class="note-details">
                                
                                <li><img src="images/images/university.png" alt="university" class="img-responsive">University of California</li>
                                <li><img src="images/images/pages.png" alt="pages" class="img-responsive">204 Pages</li>
                                <li><img src="images/images/date.png" alt="date" class="img-responsive">Thu, Nov 26 2020</li>
                                <li><img src="images/images/flag.png" alt="flag" class="img-responsive">5 Users marked this note as inapropriate</li>
                            </ul>
                        
                        
                            <div class="rate">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <p>100 reviews</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 4 -->
                    <div class="col-md-4">
                        
                        <div class="notes">
                            
                            <img src="images/Search/4.jpg" alt="note" class="img-responsive note-image">
                            <h4>Computer Science Illuminated - Seventh Edition</h4>
                            <ul class="note-details">
                                
                                <li><img src="images/images/university.png" alt="university" class="img-responsive">University of California</li>
                                <li><img src="images/images/pages.png" alt="pages" class="img-responsive">204 Pages</li>
                                <li><img src="images/images/date.png" alt="date" class="img-responsive">Thu, Nov 26 2020</li>
                                <li><img src="images/images/flag.png" alt="flag" class="img-responsive">5 Users marked this note as inapropriate</li>
                            </ul>
                        
                        
                            <div class="rate">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <p>100 reviews</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 5 -->
                    <div class="col-md-4">
                        
                        <div class="notes">
                            
                            <img src="images/Search/5.jpg" alt="note" class="img-responsive note-image">
                            <h4>The Principles of Computer Hardware - Oxford</h4>
                            <ul class="note-details">
                                
                                <li><img src="images/images/university.png" alt="university" class="img-responsive">University of California</li>
                                <li><img src="images/images/pages.png" alt="pages" class="img-responsive">204 Pages</li>
                                <li><img src="images/images/date.png" alt="date" class="img-responsive">Thu, Nov 26 2020</li>
                                <li><img src="images/images/flag.png" alt="flag" class="img-responsive">5 Users marked this note as inapropriate</li>
                            </ul>
                        
                        
                            <div class="rate">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <p>100 reviews</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 6 -->
                    <div class="col-md-4">
                        
                        <div class="notes">
                            
                            <img src="images/Search/6.jpg" alt="note" class="img-responsive note-image">
                            <h4>The Computer Book</h4>
                            <ul class="note-details">
                                
                                <li><img src="images/images/university.png" alt="university" class="img-responsive">University of California, US</li>
                                <li><img src="images/images/pages.png" alt="pages" class="img-responsive">204 Pages</li>
                                <li><img src="images/images/date.png" alt="date" class="img-responsive">Thu, Nov 26 2020</li>
                                <li><img src="images/images/flag.png" alt="flag" class="img-responsive">5 Users marked this note as inapropriate</li>
                            </ul>
                        
                        
                            <div class="rate">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <p>100 reviews</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 7 -->
                    <div class="col-md-4">
                        
                        <div class="notes">
                            
                            <img src="images/Search/1.jpg" alt="note" class="img-responsive note-image">
                            <h4>Computer Operating System - Final Exam Book With Paper Solution</h4>
                            <ul class="note-details">
                                
                                <li><img src="images/images/university.png" alt="university" class="img-responsive">University of California, US</li>
                                <li><img src="images/images/pages.png" alt="pages" class="img-responsive">204 Pages</li>
                                <li><img src="images/images/date.png" alt="date" class="img-responsive">Thu, Nov 26 2020</li>
                                <li><img src="images/images/flag.png" alt="flag" class="img-responsive">5 Users marked this note as inapropriate</li>
                            </ul>
                        
                        
                            <div class="rate">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <p>100 reviews</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 8 -->
                    <div class="col-md-4">
                        
                        <div class="notes">
                            
                            <img src="images/Search/2.jpg" alt="note" class="img-responsive note-image">
                            <h4>Computer Science</h4>
                            <ul class="note-details">
                                
                                <li><img src="images/images/university.png" alt="university" class="img-responsive">University of California, US</li>
                                <li><img src="images/images/pages.png" alt="pages" class="img-responsive">204 Pages</li>
                                <li><img src="images/images/date.png" alt="date" class="img-responsive">Thu, Nov 26 2020</li>
                                <li><img src="images/images/flag.png" alt="flag" class="img-responsive">5 Users marked this note as inapropriate</li>
                            </ul>
                        
                        
                            <div class="rate">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <p>100 reviews</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 9 -->
                    <div class="col-md-4">
                        
                        <div class="notes">
                            
                            <img src="images/Search/3.jpg" alt="note" class="img-responsive note-image">
                            <h4>Basic Computer Engineering Tech India Publication series</h4>
                            <ul class="note-details">
                                
                                <li><img src="images/images/university.png" alt="university" class="img-responsive">University of California, US</li>
                                <li><img src="images/images/pages.png" alt="pages" class="img-responsive">204 Pages</li>
                                <li><img src="images/images/date.png" alt="date" class="img-responsive">Thu, Nov 26 2020</li>
                                <li><img src="images/images/flag.png" alt="flag" class="img-responsive">5 Users marked this note as inapropriate</li>
                            </ul>
                        
                        
                            <div class="rate">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <img src="images/images/star.png" class="img-responsive">
                                <p>100 reviews</p>
                            </div>
                        </div>
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

</html>