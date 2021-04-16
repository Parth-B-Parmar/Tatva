<?php
include "db.php";
session_start();
clearstatcache();

//value get from session
$login = true;
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $loggerid = $_SESSION['loggerid'];
} else
    $login = false;

//data getter if exist
// support_email_getter from system config
$support_email_check = mysqli_query($con, "SELECT value FROM systemconfiguration WHERE key_info='support_email'");
if (mysqli_num_rows($support_email_check) != 0) {
    while ($row = mysqli_fetch_assoc($support_email_check))
        $support_email_val = $row['value'];
}

//support_phone_no getter from system config
$support_phone_no_check = mysqli_query($con, "SELECT value FROM systemconfiguration WHERE key_info='support_phone_no'");
if (mysqli_num_rows($support_phone_no_check) != 0) {
    while ($row = mysqli_fetch_assoc($support_phone_no_check))
        $support_phone_no_val = $row['value'];
}

//email_for_events getter from system config
$email_for_events_check = mysqli_query($con, "SELECT value FROM systemconfiguration WHERE key_info='email_for_events'");
if (mysqli_num_rows($email_for_events_check) != 0) {
    while ($row = mysqli_fetch_assoc($email_for_events_check))
        $email_for_events_val = $row['value'];
}

//fb_url getter from system config
$fb_url_check = mysqli_query($con, "SELECT value FROM systemconfiguration WHERE key_info='fb_url'");
if (mysqli_num_rows($fb_url_check) != 0) {
    while ($row = mysqli_fetch_assoc($fb_url_check))
        $fb_url_val = $row['value'];
}

//twitter_url c getter from system config
$twitter_url_checker = mysqli_query($con, "SELECT value FROM systemconfiguration WHERE key_info='twitter_url'");
if (mysqli_num_rows($twitter_url_checker) != 0) {
    while ($row = mysqli_fetch_assoc($twitter_url_checker))
        $twitter_url_val = $row['value'];
}

//linkedin_url getter from system config
$linkedin_url_check = mysqli_query($con, "SELECT value FROM systemconfiguration WHERE key_info='linkedin_url'");
if (mysqli_num_rows($linkedin_url_check) != 0) {
    while ($row = mysqli_fetch_assoc($linkedin_url_check))
        $linkedin_url_val = $row['value'];
}

// insert data into system config
if (isset($_POST['submit'])) {

    // fetch data using post
    $support_email = $_POST['support_email'];
    $support_phone_no = $_POST['support_phone_no'];
    $email_for_events = $_POST['email_for_events'];
    $fb_url = $_POST['fb_url'];
    $twitter_url = $_POST['twitter_url'];
    $linkedin_url = $_POST['linkedin_url'];

    // support_email_check
    $support_email_check = mysqli_query($con, "SELECT 1 FROM systemconfiguration WHERE key_info='support_email'");
    if (mysqli_num_rows($support_email_check) == 0)
        mysqli_query($con, "INSERT INTO systemconfiguration(key_info,value,createddate,createdby,modifieddate,modifiedby,isactive) 
                            VALUES ('support_email','$support_email',NOW(),$loggerid,NOW(),$loggerid,1)");
    else
        mysqli_query($con, "UPDATE systemconfiguration SET value='$support_email',modifieddate=NOW(),modifiedby=$loggerid WHERE key_info='support_email'");


    //support_phone_no_check
    $support_phone_no_check = mysqli_query($con, "SELECT 1 FROM systemconfiguration WHERE key_info='support_phone_no'");
    if (mysqli_num_rows($support_phone_no_check) == 0)
        mysqli_query($con, "INSERT INTO systemconfiguration(key_info,value,createddate,createdby,modifieddate,modifiedby,isactive) 
                            VALUES ('support_phone_no','$support_phone_no',NOW(),$loggerid,NOW(),$loggerid,1)");
    else
        mysqli_query($con, "UPDATE systemconfiguration SET value='$support_phone_no',modifieddate=NOW(),modifiedby=$loggerid WHERE key_info='support_phone_no'");


    //email_for_events_check
    $email_for_events_check = mysqli_query($con, "SELECT 1 FROM systemconfiguration WHERE key_info='email_for_events'");
    if (mysqli_num_rows($email_for_events_check) == 0)
        mysqli_query($con, "INSERT INTO systemconfiguration(key_info,value,createddate,createdby,modifieddate,modifiedby,isactive) 
                            VALUES ('email_for_events','$email_for_events',NOW(),$loggerid,NOW(),$loggerid,1)");
    else
        mysqli_query($con, "UPDATE systemconfiguration SET value='$email_for_events',modifieddate=NOW(),modifiedby=$loggerid WHERE key_info='email_for_events'");


    //fb_url_check
    $fb_url_check = mysqli_query($con, "SELECT 1 FROM systemconfiguration WHERE key_info='fb_url'");
    if (mysqli_num_rows($fb_url_check) == 0)
        mysqli_query($con, "INSERT INTO systemconfiguration(key_info,value,createddate,createdby,modifieddate,modifiedby,isactive) 
                            VALUES ('fb_url','$fb_url',NOW(),$loggerid,NOW(),$loggerid,1)");
    else
        mysqli_query($con, "UPDATE systemconfiguration SET value='$fb_url',modifieddate=NOW(),modifiedby=$loggerid WHERE key_info='fb_url'");


    //twitter_url checker
    $twitter_url_checker = mysqli_query($con, "SELECT 1 FROM systemconfiguration WHERE key_info='twitter_url'");
    if (mysqli_num_rows($twitter_url_checker) == 0)
        mysqli_query($con, "INSERT INTO systemconfiguration(key_info,value,createddate,createdby,modifieddate,modifiedby,isactive) 
                            VALUES ('twitter_url','$twitter_url',NOW(),$loggerid,NOW(),$loggerid,1)");
    else
        mysqli_query($con, "UPDATE systemconfiguration SET value='$twitter_url',modifieddate=NOW(),modifiedby=$loggerid WHERE key_info='twitter_url'");


    //linkedin_url check
    $linkedin_url_check = mysqli_query($con, "SELECT 1 FROM systemconfiguration WHERE key_info='linkedin_url'");
    if (mysqli_num_rows($linkedin_url_check) == 0)
        mysqli_query($con, "INSERT INTO systemconfiguration(key_info,value,createddate,createdby,modifieddate,modifiedby,isactive) 
                            VALUES ('linkedin_url','$linkedin_url',NOW(),$loggerid,NOW(),$loggerid,1)");
    else
        mysqli_query($con, "UPDATE systemconfiguration SET value='$linkedin_url',modifieddate=NOW(),modifiedby=$loggerid WHERE key_info='linkedin_url'");

    //default pic for note checker
    $display_pic = $_FILES['default_note_pic'];
    $filename = $display_pic['name'];
    $filetmp = $display_pic['tmp_name'];
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
        $destinationfile = '../Members/default/DP_default.jpg';
        move_uploaded_file($filetmp, $destinationfile);

        $default_note_check = mysqli_query($con, "SELECT 1 FROM systemconfiguration WHERE key_info='default_note'");
        if (mysqli_num_rows($default_note_check) == 0)
            mysqli_query($con, "INSERT INTO systemconfiguration(key_info,value,createddate,createdby,modifieddate,modifiedby,isactive) 
                                VALUES ('default_note','$destinationfile',NOW(),$loggerid,NOW(),$loggerid,1)");
        else
            mysqli_query($con, "UPDATE systemconfiguration SET value='$destinationfile',modifieddate=NOW(),modifiedby=$loggerid WHERE key_info='default_note'");
    }

    //default pic for user profile checker
    $display_pic = $_FILES['default_user_pic'];
    $filename = $display_pic['name'];
    $filetmp = $display_pic['tmp_name'];
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
        $destinationfile = '../Members/default/PP_default.jpg';
        move_uploaded_file($filetmp, $destinationfile);

        $default_user_pic_check = mysqli_query($con, "SELECT 1 FROM systemconfiguration WHERE key_info='default_profile_pic'");
        if (mysqli_num_rows($default_user_pic_check) == 0)
            mysqli_query($con, "INSERT INTO systemconfiguration(key_info,value,createddate,createdby,modifieddate,modifiedby,isactive) 
                                VALUES ('default_profile_pic','$destinationfile',NOW(),$loggerid,NOW(),$loggerid,1)");
        else
            mysqli_query($con, "UPDATE systemconfiguration SET value='$destinationfile',modifieddate=NOW(),modifiedby=$loggerid WHERE key_info='default_profile_pic'");
    }
    header("Clear-Site-Data: 'cache'");
    header("Location:manage-system-configuration-page.php");
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
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="blue-font-34 heading-margin margin-b-10">Manage System Configuration</h4>
                        </div>
                        <div class="form-group col-md-6">

                            <!-- Support email address -->
                            <label id="contact-us-first-label-form">Support email address *</label>
                            <input type="email" name="support_email"
                                <?php echo (mysqli_num_rows($support_email_check) != 0) ? "value='$support_email_val'" : "" ?>
                                class="form-control input-light-color" placeholder="Enter email address">

                            <!-- Support phone number -->
                            <label class>Support phone number *</label>
                            <input type="number" name="support_phone_no"
                                <?php echo (mysqli_num_rows($support_phone_no_check) != 0) ? "value='$support_phone_no_val'" : "" ?>
                                class="form-control input-light-color" placeholder="Enter phone number">

                            <!-- Email Address for various events -->
                            <label>Email Address(es) (for various events system will send notifications to these
                                users) *</label>
                            <input type="email" name="email_for_events"
                                <?php echo (mysqli_num_rows($email_for_events_check) != 0) ? "value='$email_for_events_val'" : "" ?>
                                class="form-control input-light-color" placeholder="Enter email address">

                            <!-- Facebook URL -->
                            <label>Facebook URL</label>
                            <input type="text" name="fb_url"
                                <?php echo (mysqli_num_rows($fb_url_check) != 0) ? "value='$fb_url_val'" : "" ?>
                                class="form-control input-light-color" placeholder="Enter facebook URL">

                            <!-- Twitter URL -->
                            <label>Twitter URL</label>
                            <input type="text" name="twitter_url"
                                <?php echo (mysqli_num_rows($twitter_url_checker) != 0) ? "value='$twitter_url_val'" : "" ?>
                                class="form-control input-light-color" placeholder="Enter twitter URL">

                            <!-- LinkedIn URL -->
                            <label>LinkedIn URL</label>
                            <input type="text" name="linkedin_url"
                                <?php echo (mysqli_num_rows($linkedin_url_check) != 0) ? "value='$linkedin_url_val'" : "" ?>
                                class="form-control input-light-color" placeholder="Enter LinkedIn URL">

                            <!-- Default image for notes -->
                            <label> Default image for notes (if seller do not upload)</label>
                            <div class="user-profile-photo-uploader">
                                <label><img src="images/upload-file.png" title="Click here to upload your photo"
                                        alt="Upload your photo here">
                                </label>
                                <input name="default_note_pic" id="default_note" class="form-control input-light-color"
                                    type="file">
                                <div style="margin-top: 12px;font-weight: 600;font-size: 15px"
                                    id="default_note_filename"></div>
                            </div>

                            <!-- Default Profile picture -->
                            <label>Default Profile picture (if seller do not upload)</label>
                            <div class="user-profile-photo-uploader">
                                <label><img src="images/upload-file.png" title="Click here to upload your photo"
                                        alt="Upload your photo here">
                                </label>
                                <input name="default_user_pic" id="default_profile"
                                    class="form-control input-light-color" type="file">
                                <div style="margin-top: 12px;font-weight: 600;font-size: 15px"
                                    id="default_profile_filename"></div>
                            </div>

                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-12">
                            <button type="submit" id="my-profile-btn" name="submit"
                                class="btn btn-primary blue-button-hover-white margin-top-15 margin-b-30">submit</button>
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

    <script>
    //show file name
    var input = document.getElementById("default_note");
    var infoArea = document.getElementById("default_note_filename");
    input.addEventListener("change", showFileName);

    function showFileName(event) {
        var input = event.srcElement;
        var fileName = input.files[0].name;
        infoArea.textContent = "Selected File name: " + fileName;
    }

    var input2 = document.getElementById("default_profile");
    var infoArea2 = document.getElementById("default_profile_filename");
    input2.addEventListener("change", showFileName2);

    function showFileName2(event) {
        var input2 = event.srcElement;
        var fileName2 = input2.files[0].name;
        infoArea2.textContent = "Selected File name: " + fileName2;
    }
    </script>

</body>

</html>