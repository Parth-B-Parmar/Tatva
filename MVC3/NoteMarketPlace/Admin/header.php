<?php
include "db.php";

$super_admin = false;
if (isset($_SESSION['email'])) {
    $loggerid = $_SESSION['loggerid'];

    //profile pic getter
    $pic_getter = mysqli_query($con, "SELECT COUNT(1),profile_pic FROM userprofile WHERE userid=$loggerid");
    while ($row = mysqli_fetch_assoc($pic_getter)) {
        $user_exist = $row['COUNT(1)'];
        $pic_path = $user_exist > 0 ? $row['profile_pic'] : "../Members/default/PP_default.jpg";
    }

    //logger name getter
    $name_getter = mysqli_query($con, "SELECT lastname,firstname FROM users WHERE userid='$loggerid'");
    while ($row = mysqli_fetch_assoc($name_getter)) {
        $full_name = $row['firstname'] . ' ' . $row['lastname'];
    }
} else
    session_start();

//super admin checker
$super_admin = ((mysqli_num_rows(mysqli_query($con, "SELECT 1 FROM users WHERE roleid=3 AND userid=$loggerid"))) != 0) ? true : false;

?>

<!--header -->
<header class="site-header">
    <div class="container column-padding-remover">
        <div class="header-wrapper">
            <div class="logo-wrapper">
                <a href="dashboard-page.php" class="navbar-brand"><img src="images/blue-logo.png" alt="logo"></a>
                <!--Mobile Open Button-->
                <span id="mobile-nav-open-btn">&#9776;</span>
            </div>
            <div class="navigation-wrapper">
                <nav class="main-nav navbar navbar-expand-md">
                    <div class="collapse navbar-collapse">
                        <ul class="menu-navigation">
                            <li><a href="dashboard-page.php">Dashboard</a></li>
                            <li class="dropdown">
                                <a role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Notes
                                </a>
                                <div class="dropdown-menu shadow-drop dropdowncustom" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="notes-under-review-page.php">
                                        <h6>Notes Under Review</h6>
                                    </a>
                                    <a class="dropdown-item" href="published-notes-page.php">
                                        <h6>Published Notes</h6>
                                    </a>
                                    <a class="dropdown-item" href="downloaded-notes-page.php">
                                        <h6>Downloaded Notes</h6>
                                    </a>
                                    <a class="dropdown-item" href="rejected-notes-page.php">
                                        <h4>Rejected Notes</h4>
                                    </a>
                                </div>
                            </li>
                            <li><a href="members-page.php">Members</a></li>
                            <li class="dropdown">
                                <a role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Reports
                                </a>
                                <div class="dropdown-menu shadow-drop dropdowncustom" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="spam-report-page.php">
                                        <h5>Spam Reports</h5>
                                    </a>
                                </div>
                            </li>

                            <!-- settings dropdown -->
                            <li class="dropdown">
                                <a role="button" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">Settings</a>
                                <div class="dropdown-menu shadow-drop dropdowncustom" aria-labelledby="navbarDropdown">

                                    <!-- only visible if login user is super admin -->
                                    <?php if ($super_admin) { ?>
                                    <a class="dropdown-item" href="manage-system-configuration-page.php">
                                        <h6>Manage System Configuration</h6>
                                    </a>
                                    <a class="dropdown-item" href="manage-administrator-page.php">
                                        <h6>Manage Administrator</h6>
                                    </a>
                                    <?php   } ?>

                                    <!-- visible to all the admins -->
                                    <a class="dropdown-item" href="manage-category-page.php">
                                        <h6>Mange Category</h6>
                                    </a>
                                    <a class="dropdown-item" href="manage-type-page.php">
                                        <h6>Manage Type</h6>
                                    </a>
                                    <a class="dropdown-item" href="manage-country-page.php">
                                        <h6>Manage Countries</h6>
                                    </a>

                                </div>
                            </li>

                            <li class="dropdown">
                                <a role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    <!-- to get img of user -->
                                    <?php
                                    if (isset($_SESSION['loggerid'])) { ?>
                                    <img src="<?php echo $pic_path ?>" title="<?php echo $full_name ?>"
                                        alt="user-pic-<?php echo $full_name ?>"
                                        class="img-fluid img-setter rounded-circle">
                                    <?php } ?>

                                </a>
                                <div class="dropdown-menu shadow-drop dropdowncustom" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="my-profile-page.php">
                                        <h6>Update Profile</h6>
                                    </a>
                                    <a class="dropdown-item" href="change-password-page.php">
                                        <h6>Change Password</h6>
                                    </a>

                                    <!-- logout or login button -->
                                    <?php
                                    if (isset($_SESSION['loggerid'])) { ?>
                                    <a class="dropdown-item">
                                        <h5 data-toggle='modal' data-target='#confirm-logout-popup'>LOGOUT</h5>
                                    </a>
                                    <?php  } else { ?>
                                    <a href="log-in-page.php" class="dropdown-item">
                                        <h5>LOGIN</h5>
                                    </a>
                                    <?php  }   ?>

                                </div>
                            </li>
                            <li>

                                <!-- logout or login button -->
                                <?php
                                if (isset($_SESSION['loggerid'])) { ?>
                                <a>
                                    <button type="button" data-toggle='modal' data-target='#confirm-logout-popup'
                                        class="btn btn-purple btn-outline-primary">LOGOUT</button>
                                </a>
                                <?php  } else { ?>
                                <a href="log-in-page.php">
                                    <button type="button" class="btn btn-purple btn-outline-primary">LOGIN</button>
                                </a>
                                <?php  }   ?>

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
                        <li><a href="dashboard-page.php">Dashboard</a></li>
                        <li class="dropdown">
                            <a role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Notes
                            </a>
                            <div class="dropdown-menu shadow-drop dropdowncustom" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="notes-under-review-page.php">
                                    <h6>Notes Under Review</h6>
                                </a>
                                <a class="dropdown-item" href="published-notes-page.php">
                                    <h6>Published Notes</h6>
                                </a>
                                <a class="dropdown-item" href="downloaded-notes-page.php">
                                    <h6>Downloaded Notes</h6>
                                </a>
                                <a class="dropdown-item" href="rejected-notes-page.php">
                                    <h4>Rejected Notes</h4>
                                </a>
                            </div>
                        </li>
                        <li><a href="members-page.php">Members</a></li>
                        <li class="dropdown">
                            <a role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Reports
                            </a>
                            <div class="dropdown-menu shadow-drop dropdowncustom" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="spam-report-page.php">
                                    <h5>Spam Reports</h5>
                                </a>
                            </div>
                        </li>

                        <!-- settings dropdown -->
                        <li class="dropdown">
                            <a role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">Settings</a>
                            <div class="dropdown-menu shadow-drop dropdowncustom" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="manage-system-configuration-page.php">
                                    <h6>Manage System Configuration</h6>
                                </a>
                                <a class="dropdown-item" href="manage-administrator-page.php">
                                    <h6>Manage Administrator</h6>
                                </a>
                                <a class="dropdown-item" href="manage-category-page.php">
                                    <h6>Mange Category</h6>
                                </a>
                                <a class="dropdown-item" href="manage-type-page.php">
                                    <h6>Manage Type</h6>
                                </a>
                                <a class="dropdown-item" href="manage-country-page.php">
                                    <h6>Manage Countries</h6>
                                </a>
                            </div>
                        </li>

                        <li class="dropdown">
                            <a role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                <!-- to get img of user -->
                                <?php
                                if (isset($_SESSION['loggerid'])) { ?>
                                <img src="<?php echo $pic_path ?>" title="<?php echo $full_name ?>"
                                    alt="user-pic-<?php echo $full_name ?>" class="img-fluid img-setter rounded-circle">
                                <?php } ?>

                            </a>
                            <div class="dropdown-menu shadow-drop dropdowncustom" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="my-profile-page.php">
                                    <h6>Update Profile</h6>
                                </a>
                                <a class="dropdown-item" href="change-password-page.php">
                                    <h6>Change Password</h6>
                                </a>

                                <!-- logout or login button -->
                                <?php
                                if (isset($_SESSION['loggerid'])) { ?>
                                <a class="dropdown-item">
                                    <h5 data-toggle='modal' data-target='#confirm-logout-popup'>LOGOUT</h5>
                                </a>
                                <?php  } else { ?>
                                <a href="log-in-page.php" class="dropdown-item">
                                    <h5>LOGIN</h5>
                                </a>
                                <?php  }   ?>

                            </div>
                        </li>
                        <li>

                            <!-- logout or login button -->
                            <?php
                            if (isset($_SESSION['loggerid'])) { ?>
                            <a>
                                <button type="button" data-toggle='modal' data-target='#confirm-logout-popup'
                                    class="btn btn-purple btn-outline-primary">LOGOUT</button>
                            </a>
                            <?php  } else { ?>
                            <a href="log-in-page.php">
                                <button type="button" class="btn btn-purple btn-outline-primary">LOGIN</button>
                            </a>
                            <?php  }   ?>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- pop up -->
<div class="popup-box">
    <div style="margin-top: 200px;" id="confirm-logout-popup" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close text-right popup-close-btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body">
                    <div style="transform: translateY(-40px);">
                        <h6 class="blue-font-24">Are you sure, you want to logout? </h6>
                        <h6 style="margin-top: 10px;" class="dark-font-22"> Please confirm. </h6>
                    </div>
                    <div style="margin-top:-25px;">
                        <a href="logout.php" style="margin-right: 30px;"
                            class="btn btn-primary red-button-hover-white">yes</a>
                        <button class="btn btn-primary blue-button-hover-white" onclick="hide_pop_up()">no</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- to hide pop-up -->
<script>
function hide_pop_up() {
    $('#confirm-logout-popup').modal('hide');
}
</script>
<!--header end-->