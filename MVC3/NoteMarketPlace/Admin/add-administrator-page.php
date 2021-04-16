<?php
include "db.php";
session_start();

$login = true;
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $loggerid = $_SESSION['loggerid'];
} else
    $login = false;

//store values in db
if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email_new_admin = $_POST['email'];
    $country_id = $_POST['county_code'];
    $phone_no = $_POST['phone_no'];

    if (isset($_GET['id'])) {

        //to get userid
        $userid = $_GET['id'];

        //update name
        $update_name = mysqli_query($con, "UPDATE users SET firstname='$fname',lastname='$lname',emailid='$email_new_admin',
                                           modifieddate=NOW(),modifiedby=$loggerid WHERE userid=$userid");

        //update userprofile
        $update_profile = mysqli_query($con, "UPDATE userprofile SET phone_country_code=$country_id,country=$country_id,
                                              phone_no='$phone_no',modifieddate=NOW(),modifiedby=$loggerid WHERE userid=$userid");

        header("Location:manage-administrator-page.php");
    } else {
        $data_insert1 = mysqli_query($con, "INSERT INTO users(roleid,firstname,lastname,emailid,password,isemailverified,createddate,createdby,modifieddate,modifiedby,isactive) 
        VALUES(2,'$fname','$lname','$email_new_admin','Admin123',1,NOW(),$loggerid,NOW(),$loggerid,1)");

        // to get last instred id
        $new_inserted_adminid = mysqli_insert_id($con);

        $data_insert2 = mysqli_query($con, "INSERT INTO userprofile(userid,phone_country_code,profile_pic,phone_no,country,createddate,createdby) VAlUES($new_inserted_adminid,'$country_id','../Members/default/PP_default.jpg','$phone_no','$country_id',NOW(),$loggerid)");
    }
}

// user id getter from get method to edit user
$userid = (isset($_GET['id'])) ? $_GET['id'] : "";

//data getter of user
if (isset($_GET['id'])) {
    $user_data_getter = mysqli_query($con, "SELECT u.firstname,u.lastname,u.emailid,up.phone_country_code,up.phone_no
    FROM users u
    JOIN userprofile up
    ON up.userid=u.userid
    WHERE u.userid=$userid");

    while ($row = mysqli_fetch_assoc($user_data_getter)) {
        $fname = $row['firstname'];
        $lname = $row['lastname'];
        $email_user = $row['emailid'];
        $phone_code = $row['phone_country_code'];
        $phone_no = $row['phone_no'];
    }
}

//log-in failed
if (!$login) { ?>
<script>
alert("Please sign in/register to gain access to this page\npressing OK you will be redirect to login page");
window.location.replace("log-in-page.php");
</script>
<?php } ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <!--Meta tags-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0 ,user-scalable=no">
    <meta charset="UTF-8">

    <!--Title-->
    <title>Notes Marketplace</title>

    <!--Fevicon-->
    <link rel="icon" href="images/favicon.ico">

    <!--Google Fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!--Font-Awesome-->
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">

    <!--bootstrap css-->
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">

    <!--Custom css-->
    <link rel="stylesheet" href="css/style.css">

    <!--Responsive css-->
    <link rel="stylesheet" href="css/responsive.css">

</head>

<body class="sticky-header">

    <div class="above-footer">


        <!--header -->
        <?php include "header.php" ?>
        <!--header end-->

        <div id="user-profile">
            <div class="container">
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="blue-font-30 heading-margin margin-b-15">Add Administrator</h4>
                        </div>
                        <div class="form-group col-md-6">

                            <!-- firstname -->
                            <label id="contact-us-first-label-form">First Name *</label>
                            <input type="text" name="fname" <?php echo (isset($_GET['id'])) ? "value='$fname'" : "" ?>
                                class="form-control input-light-color" placeholder="Enter your first Name" required>

                            <!-- lastname -->
                            <label class>Last Name *</label>
                            <input type="text" name="lname" <?php echo (isset($_GET['id'])) ? "value='$lname'" : "" ?>
                                class="form-control input-light-color" placeholder="Enter your last Name" required>

                            <!-- email -->
                            <label>Email *</label>
                            <input type="email" name="email"
                                <?php echo (isset($_GET['id'])) ? "value='$email_user'" : "" ?>
                                class="form-control input-light-color" placeholder="Enter your email address" required>

                            <label class="right-content">Phone Number</label>
                            <div class="form-row">
                                <div class="col-4">
                                    <select name="county_code"
                                        class="form-control input-light-color text-hidden options-arrow-down right-content">
                                        <?php $country_code_getter = mysqli_query($con, "SELECT countryid,countrycode FROM countries");
                                        while ($row = mysqli_fetch_assoc($country_code_getter)) {
                                            $country_code = $row['countrycode'];
                                            $country_id = $row['countryid'];
                                            echo (isset($_GET['id']) && $phone_code == $country_id) ? "<option selected value='$country_id'>+$country_code</option>" : "<option value='$country_id'>+$country_code</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col">

                                    <!-- user phone no -->
                                    <input type="number" name="phone_no"
                                        <?php echo (isset($_GET['id'])) ? "value='$phone_no'" : "" ?>
                                        class="form-control right-content" placeholder="Enter your phone number">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-12">
                            <button type="submit" name="submit"
                                class="btn btn-primary blue-button-hover-white margin-top-15">submit
                            </button>
                            <div class="suc-msg">
                                <?php
                                if (isset($_POST['submit']) && !isset($_GET['id'])) {
                                    echo $data_insert1 && $data_insert2 ? "New Admin <b>$fname $lname</b> has been added successfully!" : "Sorry something went wrong!";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--footer-->
    <?php include "footer.php"; ?>
    <!--footer end-->


    <!--popper js-->
    <script src="js/popper/popper.min.js"></script>

    <!--jquery js-->
    <script src="js/jquery/jquery.min.js"></script>

    <!--bootstrap js-->
    <script src="js/bootstrap/bootstrap.min.js"></script>

    <!--Custom Script-->
    <script src="js/script.js"></script>

</body>

</html>