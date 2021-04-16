<?php
include "db.php";
if (!isset($_SESSION))
    session_start();
?>

<!--header -->
<header class="site-header">
    <div class="container column-padding-remover">
        <div class="header-wrapper">
            <div class="logo-wrapper">
                <a class="navbar-brand" href="home.php"><img src="images/blue-logo.png" alt="logo"></a>
                <!--Mobile Open Button-->
                <span id="mobile-nav-open-btn">&#9776;</span>
            </div>
            <div class="navigation-wrapper">
                <nav class="main-nav navbar navbar-expand-md">
                    <div class="collapse navbar-collapse">
                        <ul class="menu-navigation">
                            <li><a href="search-note-page.php">Search Notes</a></li>
                            <li><a href="dashboard-page.php">Sell Your Notes</a></li>
                            <li><a href="buyer-request-page.php">Buyer Request</a></li>
                            <li><a href="faq-page.php">FAQ</a></li>
                            <li><a href="contact-us-page.php">Contact Us</a></li>
                            <li class="dropdown">
                                <?php
                                if (isset($_SESSION['email'])) {
                                    $email = $_SESSION['email'];
                                    $userid_getter = mysqli_query($con, "SELECT userid,lastname,firstname FROM users WHERE emailid='$email'");
                                    while ($row = mysqli_fetch_assoc($userid_getter)) {
                                        $userid = $row['userid'];
                                        $full_name = $row['firstname'] . $row['lastname'];
                                    }

                                    $exist_userid_in_profile_checker = mysqli_query($con, "SELECT 1 FROM userprofile WHERE userid=$userid");
                                    $userid_count = mysqli_num_rows($exist_userid_in_profile_checker);

                                    if ($userid_count != 0) {
                                        $dp_path_getter = mysqli_query($con, "SELECT profile_pic FROM userprofile WHERE userid=$userid");
                                        while ($row = mysqli_fetch_assoc($dp_path_getter)) {
                                            $dp_path = $row['profile_pic'];
                                        }
                                        echo "
                                        <a role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                        <img src='$dp_path' title='$full_name' alt='PIC-$full_name' class='img-fluid rounded-circle img-setter'></a>";
                                    } else
                                        echo "
                                        <a role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                        <img  src='../Members/default/PP_default.jpg' title='$full_name' alt='PIC-$full_name' class='img-setter img-fluid rounded-circle'></a>";
                                } else {
                                }
                                ?>
                                <div class="dropdown-menu shadow-drop dropdowncustom" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="user-profile-page.php">
                                        <h6>My Profile</h6>
                                    </a>
                                    <a class="dropdown-item" href="my-downloads-page.php">
                                        <h6>My Downloads</h6>
                                    </a>
                                    <a class="dropdown-item" href="my-sold-notes-page.php">
                                        <h6>My Sold Notes</h6>
                                    </a>
                                    <a class="dropdown-item" href="my-rejected-notes-page.php">
                                        <h6>My Rejected Notes</h6>
                                    </a>
                                    <a class="dropdown-item" href="change-password-page.php">
                                        <h6>Change Password</h6>
                                    </a>
                                    <?php if (isset($_SESSION['email'])) { ?>
                                    <a class="dropdown-item" href="logout.php">
                                        <h5><b>LOGOUT</b></h5>
                                    </a>
                                    <?php
                                    } else {
                                    ?>
                                    <a class="dropdown-item" href="log-in-page.php"><button
                                            class="btn btn-purple btn-outline-primary"
                                            type="submit"><b>LOGIN</b></button></a>
                                    <?php } ?>
                                </div>
                            </li>
                            <li><?php if (isset($_SESSION['email'])) { ?>
                                <a href="logout.php"><button class="btn btn-purple btn-outline-primary"
                                        type="submit"><b>LOGOUT</b></button></a>
                                <?php } else {
                                ?>
                                <a href="log-in-page.php"><button class="btn btn-purple btn-outline-primary"
                                        type="submit"><b>LOGIN</b></button></a>
                                <?php } ?>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>

            <!--for Mobile Menu-->
            <div id="mobile-nav">
                <!--Mobile Close Button-->
                <span id="mobile-nav-close-btn">&times;</span>
                <div id="mobile-nav-content">
                    <ul class="menu-navigation">
                        <div class="clickable-op">
                            <li><a href="search-note-page.php">Search Notes</a></li>
                            <li><a href="dashboard-page.php">Sell Your Notes</a></li>
                            <li><a href="buyer-request-page.php">Buyer Request</a></li>
                            <li><a href="faq-page.php">FAQ</a></li>
                            <li><a href="contact-us-page.php">Contact Us</a></li>
                        </div>
                        <li class="dropdown">
                            <?php
                            if (isset($_SESSION['email'])) {
                                $email = $_SESSION['email'];
                                $userid_getter = mysqli_query($con, "SELECT userid,lastname,firstname FROM users WHERE
                            emailid='$email'");
                                while ($row = mysqli_fetch_assoc($userid_getter)) {
                                    $userid = $row['userid'];
                                    $full_name = $row['firstname'] . $row['lastname'];
                                }

                                $exist_userid_in_profile_checker = mysqli_query($con, "SELECT 1 FROM userprofile WHERE
                            userid=$userid");
                                $userid_count = mysqli_num_rows($exist_userid_in_profile_checker);

                                if ($userid_count != 0) {
                                    $dp_path_getter = mysqli_query($con, "SELECT profile_pic FROM userprofile WHERE
                            userid=$userid");
                                    while ($row = mysqli_fetch_assoc($dp_path_getter)) {
                                        $dp_path = $row['profile_pic'];
                                    }
                                    echo "
                            <a role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                <img src='$dp_path' title='$full_name' alt='PIC-$full_name'
                                    class='img-fluid rounded-circle img-setter'></a>";
                                } else
                                    echo "
                            <a role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                <img src='../Members/default/PP_default.jpg' title='$full_name' alt='PIC-$full_name'
                                    class='img-setter img-fluid rounded-circle'></a>";
                            } else ?>
                            <div class="dropdown-menu shadow-drop dropdowncustom" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="user-profile-page.php">
                                    <h6>My Profile</h6>
                                </a>
                                <a class="dropdown-item" href="my-downloads-page.php">
                                    <h6>My Downloads</h6>
                                </a>
                                <a class="dropdown-item" href="my-sold-notes-page.php">
                                    <h6>My Sold Notes</h6>
                                </a>
                                <a class="dropdown-item" href="my-rejected-notes-page.php">
                                    <h6>My Rejected Notes</h6>
                                </a>
                                <a class="dropdown-item" href="change-password-page.php">
                                    <h6>Change Password</h6>
                                </a>
                                <?php
                                if (isset($_SESSION['email'])) { ?>
                                <a class="dropdown-item" href="logout.php">
                                    <h5>LOGOUT</h5>
                                </a>
                                <?php
                                } else { ?>
                                <a class="dropdown-item" href="log-in-page.php">
                                    <button type="button" class="btn btn-purple btn-outline-primary">LOGIN</button>
                                </a>
                                <?php }  ?>
                                
                            </div>
                        </li>
                        <li>
                            <?php
                            if (isset($_SESSION['email'])) { ?>
                            <a href="logout.php">
                                <button type="button" class="btn btn-purple btn-outline-primary">LOGOUT</button>
                            </a>
                            <?php
                            } else { ?>
                            <a href="log-in-page.php">
                                <button type="button" class="btn btn-purple btn-outline-primary">LOGIN</button>
                            </a>
                            <?php }  ?>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<!--header end-->
