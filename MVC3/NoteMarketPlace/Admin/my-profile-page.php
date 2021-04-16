<?php
include "db.php";
session_start();
$login = true;

//session check
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $loggerid = $_SESSION['loggerid'];

    //to get username
    $user_name_getter = mysqli_query($con, "SELECT firstname,lastname FROM users WHERE userid=$loggerid");
    while ($row = mysqli_fetch_assoc($user_name_getter)) {
        $fname = $row['firstname'];
        $lname = $row['lastname'];
    }

    //to get info from user profile table
    $data_fetch = mysqli_query($con, "SELECT secondemail,phone_country_code,phone_no,profile_pic FROM userprofile WHERE userid=$loggerid");
    while ($row = mysqli_fetch_assoc($data_fetch)) {
        $fetch_another_email = $row['secondemail'];
        $fetch_phone_country = $row['phone_country_code'];
        $fetch_phone_no = $row['phone_no'];
        $fetch_profile_pic = $row['profile_pic'];
    }
} else
    $login = false;

//store values in db
if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $another_email = $_POST['2nd_email'];
    $phone_code = $_POST['phone_code'];
    $phone_no = $_POST['phone_no'];

    //update name
    $name_update = mysqli_query($con, "UPDATE users SET firstname='$fname',lastname='$lname',modifieddate=NOW() WHERE userid=$loggerid");

    //update user profile
    $update_info = mysqli_query($con, "UPDATE userprofile SET secondemail='$another_email',phone_country_code='$phone_code',phone_no='$phone_no',modifieddate=NOW(),modifiedby=$loggerid WHERE userid=$loggerid");

    //profile picture
    $profile_pic = $_FILES['profile_pic'];
    $filename = $profile_pic['name'];
    $filetmp = $profile_pic['tmp_name'];
    $extention = explode('.', $filename);
    $filecheck = strtolower(end($extention));
    $fileextstored = array('jpg', 'png', 'jpeg');

    if (in_array($filecheck, $fileextstored)) {
        if (!is_dir("../Members/")) {
            mkdir('../Members/');
        }
        if (!is_dir("../Members/default")) {
            mkdir("../Members/default");
        }
        if (!is_dir("../Members/" . $loggerid)) {
            mkdir("../Members/" . $loggerid);
        }

        //to delete file
        if ($fetch_profile_pic != "../Members/default/PP_default.jpg")
            unlink($fetch_profile_pic);

        $destinationfile = '../Members/' . $loggerid . '/' . "DP_" . time() . '.' . $filecheck;
        move_uploaded_file($filetmp, $destinationfile);

        $set_profile_pic = mysqli_query($con, "UPDATE userprofile SET profile_pic='$destinationfile' WHERE userid=$loggerid");
    }
    header("Refresh:0");
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
                <form action="" method="post" enctype="multipart/form-data">
                    <div class=" row">
                        <div class="col-md-12">
                            <h4 class="blue-font-34 heading-margin margin-b-15">My Profile</h4>
                        </div>
                        <div class="form-group col-md-6">
                            <label id="contact-us-first-label-form">First Name *</label>
                            <input type="text" name="fname" value="<?php echo $fname ?>"
                                class="form-control input-light-color" placeholder="Enter your first Name">

                            <label class>Last Name *</label>
                            <input type="text" name="lname" value="<?php echo $lname ?>"
                                class="form-control input-light-color" placeholder="Enter your last Name">

                            <label>Email *</label>
                            <input type="email" value="<?php echo $email ?>" disabled name="email"
                                class="form-control input-light-color" placeholder="Enter your email address">

                            <label>Secondary Email</label>
                            <input type="email" name="2nd_email" value="<?php echo $fetch_another_email ?>"
                                class="form-control input-light-color" placeholder="Enter your email address">

                            <label class="right-content">Phone Number</label>
                            <div class="form-row">
                                <div class="col-4">
                                    <select name="phone_code"
                                        class="form-control options-arrow-down input-light-color right-content">
                                        <?php
                                        $phone_code_getter = mysqli_query($con, "SELECT countryid,countrycode FROM countries");
                                        while ($row = mysqli_fetch_assoc($phone_code_getter)) {
                                            $phone_code = $row['countrycode'];
                                            $country_id = $row['countryid'];
                                            echo ($country_id == $fetch_phone_country)
                                                ? "<option selected value='$country_id'>+$phone_code</option>" : "<option value='$country_id'>+$phone_code</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="tel" name="phone_no" value="<?php echo $fetch_phone_no ?>"
                                        class="form-control right-content" placeholder="Enter your phone number">
                                </div>
                            </div>
                            <label>Profile Picture</label>
                            <div class="user-profile-photo-uploader">
                                <label for="image-uploader"><img src="images/upload-file.png"
                                        title="Click here to upload your photo" alt="Upload your photo here"></label>
                                <input id="image-uploader" name="profile_pic" class="form-control input-light-color"
                                    type="file">
                                <div style="font-size: 14px;margin-top:13px;font-weight: 600;"
                                    id="file-upload-filename3">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-12">
                            <button id="my-profile-btn" type="submit" name='submit'
                                class="btn btn-primary blue-button-hover-white margin-top-15">submit</button>
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

    <!-- display src path of img -->
    <script>
    var input3 = document.getElementById("image-uploader");
    var infoArea3 = document.getElementById("file-upload-filename3");
    input3.addEventListener("change", showFileName3);

    function showFileName3(event) {
        var input3 = event.srcElement;
        var fileName3 = input3.files[0].name;
        infoArea3.textContent = "File name: " + fileName3;
    }
    </script>

    <!--Custom Script-->
    <script src="js/script.js"></script>

</body>

</html>