<?php
include "db.php";
session_start();

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    $query = mysqli_query($con, "SELECT * FROM users WHERE emailid='$email'");

    while ($row = mysqli_fetch_assoc($query)) {
        $userid = $row['userid'];
        $fname = $row['firstname'];
        $lname = $row['lastname'];
    }
} else
    header('Location:log-in-page.php');

$query = mysqli_query($con, "SELECT 1 FROM userprofile WHERE userid='$userid'");
$exist = mysqli_num_rows($query);

if ($exist != 0) {

    $query = mysqli_query($con, "SELECT country,gender,phone_country_code  FROM userprofile WHERE userid=$userid");
    while ($row = mysqli_fetch_assoc($query)) {
        $current_country_id = $row['country'];
        $current_gender_id = $row['gender'];
        $current_phone_country_code = $row['phone_country_code'];
    }

    $profile_pic_path_getter = mysqli_query($con, "SELECT profile_pic FROM userprofile WHERE userid='$userid'");
    while ($row = mysqli_fetch_assoc($profile_pic_path_getter)) {
        $profile_pic_path = $row['profile_pic'];
    }
}

if (isset($_POST['submit'])) {

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $phone_code = $_POST['number_code'];
    $phone_no = $_POST['phone_no'];
    $add_line1 = $_POST['add_line1'];
    $add_line2 = $_POST['add_line2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zipcode = $_POST['zip_code'];
    $country = $_POST['country'];
    $university = $_POST['university'];
    $college = $_POST['college'];
    $destinationfile = "../Members/default/PP_default.jpg";

    $update_name = mysqli_query($con, "UPDATE users SET firstname='$fname',lastname='$lname' WHERE userid=$userid");

    if ($exist == 0)
        $insert_query = mysqli_query($con, "INSERT INTO userprofile(profile_pic,userid,createddate,createdby) VALUES('$destinationfile',$userid,NOW(),$userid)");

    $update_query = "UPDATE userprofile SET dob='$dob',gender='$gender',phone_country_code='$phone_code',
                     phone_no='$phone_no',address_line1='$add_line1',
                     address_line2='$add_line2',zipcode='$zipcode',state='$state',city='$city',
                     country='$country',university='$university',college='$college',modifieddate=NOW(),
                     modifiedby='$userid' WHERE userid='$userid'";

    $update_query_result = mysqli_query($con, $update_query);

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
        if (!is_dir("../Members/" . $userid)) {
            mkdir("../Members/" . $userid);
        }

        //to delete file
        if ($exist != 0) {
            if ($profile_pic_path != "../Members/default/PP_default.jpg")
                unlink($profile_pic_path);
        }

        $destinationfile = '../Members/' . $userid . '/' . "DP_" . time() . '.' . $filecheck;
        move_uploaded_file($filetmp, $destinationfile);

        $set_profile_pic = mysqli_query($con, "UPDATE userprofile SET profile_pic='$destinationfile' WHERE userid=$userid");
    }
    header("Refresh:0");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <!--Meta tags-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0 ,user-scalable=no">

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

    <!--header -->
    <?php include "header.php" ?>
    <!--header end-->

    <div id="user-profile">
        <div id="search-top-img">
            <img src="images/banner-with-overlay-user-profile.jpg" alt="Banner image" class="img-fluid">
            <div id="search-home-heading" class="text-center">
                <h3 class="heading-margin">User Profile</h3>
            </div>
        </div>
        <div id="form-heading-1">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        basic profile details
                    </div>
                </div>
            </div>
        </div>
        <!--Form-1-->
        <form action="user-profile-page.php" method="POST" enctype="multipart/form-data">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>First Name *</label>
                                <input type="text" name="fname" <?php echo "value='$fname'"; ?>
                                    class="form-control input-light-color" placeholder="Enter your first name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="right-content">Last Name *</label>
                                <input type="text" name="lname" <?php echo "value='$lname'"; ?>
                                    class="form-control input-light-color right-content"
                                    placeholder="Enter your last name" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Email *</label>
                                <input type="email" <?php echo "value='$email'"; ?>
                                    class="form-control input-light-color" placeholder="Enter your email address"
                                    disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="right-content">Date Of Birth</label>
                                <?php
                                $result = mysqli_query($con, "SELECT dob FROM userprofile WHERE userid=$userid");
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $dob = $row['dob'];
                                }
                                echo ($exist != 0) ? "<input name='dob' value='$dob' type='date' class='form-control input-light-color right-content'>" : "<input name='dob' type='date' class='form-control input-light-color right-content'>";
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <div class="form-group">
                                    <label>Gender *</label>
                                    <select name="gender" class="form-control options-arrow-down input-light-color"
                                        required>
                                        <?php
                                        $gender_getter = mysqli_query($con, "SELECT * FROM referencedata WHERE refcategory='Gender'");
                                        echo " <option value='' disabled selected>Select your gender</option>";
                                        while ($row = mysqli_fetch_assoc($gender_getter)) {
                                            $gender_id = $row['refdataid'];
                                            $gender_name = $row['value'];
                                            if ($exist != 0) {
                                                if ($gender_id == $current_gender_id)
                                                    echo " <option value='$gender_id' selected >$gender_name</option>";
                                                else
                                                    echo " <option value='$gender_id'>$gender_name</option>";
                                            } else
                                                echo " <option value='$gender_id'>$gender_name</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="right-content">Phone Number *</label>
                                <div class="form-row">
                                    <div class="col-4">
                                        <select name="number_code"
                                            class="form-control input-light-color options-arrow-down right-content">
                                            <?php
                                            $code_getter = mysqli_query($con, "SELECT * FROM countries");
                                            while ($row = mysqli_fetch_assoc($code_getter)) {
                                                $country_code = $row['countrycode'];
                                                $countryid = $row['countryid'];
                                                if ($exist != 0) {
                                                    if ($countryid == $current_phone_country_code)
                                                        echo "<option value='$countryid' selected>+$country_code</option>";
                                                    else
                                                        echo "<option value='$countryid'>+$country_code</option>";
                                                } else
                                                    echo "<option value='$countryid'>+$country_code</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <?php
                                        $query = mysqli_query($con, "SELECT phone_no FROM userprofile WHERE userid=$userid");
                                        while ($row = mysqli_fetch_assoc($query)) {
                                            $number = $row['phone_no'];
                                        }
                                        echo ($exist != 0) ? "  <input type='tel' required value='$number' name='phone_no' class='form-control right-content' placeholder='Enter your phone number'>" : "  <input type='tel' name='phone_no' class='form-control right-content' placeholder='Enter your phone number' required>";
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Profile Picture</label>
                                <div class="user-profile-photo-uploader">
                                    <label for="image-uploader"><img src="images/upload-file.png"
                                            title="Click here to upload your photo"
                                            alt="Upload your photo here"></label>
                                    <input name="profile_pic" id="image-uploader" class="form-control input-light-color"
                                        type="file">
                                    <div style="font-size: 14px;margin-top:23px;font-weight: 600;"
                                        id="file-upload-filename3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Address part-->
            <div id="form-heading-2">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            Address details
                        </div>
                    </div>
                </div>
            </div>

            <!--Form-2-->
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Address Line 1 *</label>
                                <?php
                                $query = mysqli_query($con, "SELECT address_line1 FROM userprofile WHERE userid=$userid");
                                while ($row = mysqli_fetch_assoc($query)) {
                                    $add1 = $row['address_line1'];
                                }
                                echo ($exist != 0) ? "<input name='add_line1' required value='$add1' type='text' class='form-control input-light-color'
                                placeholder='Enter your address'>" : "<input name='add_line1' type='text' class='form-control input-light-color'
                                placeholder='Enter your address' required>";
                                ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="right-content">Address Line 2 *</label>
                                <?php
                                $query = mysqli_query($con, "SELECT address_line2 FROM userprofile WHERE userid=$userid");
                                while ($row = mysqli_fetch_assoc($query)) {
                                    $add2 = $row['address_line2'];
                                }
                                echo ($exist != 0) ? "<input name='add_line2' required value='$add2' type='text' class='form-control input-light-color right-content'
                                placeholder='Enter your address'>" : "<input name='add_line2' type='text' class='form-control input-light-color right-content'
                                placeholder='Enter your address' required>";
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>City *</label>
                                <?php
                                $query = mysqli_query($con, "SELECT city FROM userprofile WHERE userid=$userid");
                                while ($row = mysqli_fetch_assoc($query)) {
                                    $city_temp = $row['city'];
                                }
                                echo ($exist != 0) ? "<input type='text' name='city' required value='$city_temp' class='form-control input-light-color'
                                placeholder='Enter your city'>" : "<input type='text' name='city' class='form-control input-light-color'
                                placeholder='Enter your city' required>";
                                ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="right-content">State *</label>
                                <?php
                                $query = mysqli_query($con, "SELECT state FROM userprofile WHERE userid=$userid");
                                while ($row = mysqli_fetch_assoc($query)) {
                                    $state = $row['state'];
                                }
                                echo ($exist != 0) ? "<input name='state' value='$state' required type='text' class='form-control input-light-color right-content'
                                placeholder='Enter your state'>" : "<input name='state' type='text' class='form-control input-light-color right-content'
                                placeholder='Enter your state' required>";
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>ZipCode *</label>
                                <?php
                                $query = mysqli_query($con, "SELECT zipcode FROM userprofile WHERE userid=$userid");
                                while ($row = mysqli_fetch_assoc($query)) {
                                    $zipcode = $row['zipcode'];
                                }
                                echo ($exist != 0) ? "<input name='zip_code' value='$zipcode' required type='number' class='form-control input-light-color'
                                placeholder='Enter your zipcode'>" : "<input name='zip_code' type='number' class='form-control input-light-color'
                                placeholder='Enter your zipcode' required>";
                                ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="right-content">Country *</label>
                                <select name="country" required
                                    class="form-control input-light-color options-arrow-down right-content">
                                    <?php
                                    $get_country = mysqli_query($con, "SELECT * FROM countries");
                                    if ($current_country_id == 0)
                                        echo " <option selected>Select your country</option>";
                                    while ($row = mysqli_fetch_assoc($get_country)) {
                                        $country = $row['name'];
                                        $country_id = $row['countryid'];
                                        if ($exist != 0) {
                                            if ($country_id == $current_country_id)
                                                echo "<option selected value='$country_id'>$country</option>";
                                            else
                                                echo "<option value='$country_id'>$country</option>";
                                        } else
                                            echo "<option value='$country_id'>$country</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--University infomation-->
            <div id="form-heading-3">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            university and college infomation
                        </div>
                    </div>
                </div>
            </div>

            <!--Form-3-->
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>University</label>
                                <?php
                                $query = mysqli_query($con, "SELECT university FROM userprofile WHERE userid=$userid");
                                while ($row = mysqli_fetch_assoc($query)) {
                                    $university = $row['university'];
                                }
                                echo ($exist != 0) ? " <input name='university' value='$university' type='text' class='form-control input-light-color'
                                placeholder='Enter your university'>" : " <input name='university' type='text' class='form-control input-light-color'
                                placeholder='Enter your university'>";
                                ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="right-content">College</label>
                                <?php
                                $query = mysqli_query($con, "SELECT college FROM userprofile WHERE userid=$userid");
                                while ($row = mysqli_fetch_assoc($query)) {
                                    $college = $row['college'];
                                }
                                echo ($exist != 0) ? " <input name='college' value='$college' type='text' class='form-control input-light-color right-content'
                                placeholder='Enter your college'>" : " <input name='college' type='text' class='form-control input-light-color right-content'
                                placeholder='Enter your college'>";
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" name="submit" id="user-profile-submit-btn" class="btn btn-primary">Submit</button>
            </div>
        </form>

        <!--footer-->
        <?php include "footer.php"; ?>
        <!--footer end-->

    </div>


    <!--popper js-->
    <script src="js/popper/popper.min.js"></script>

    <!--jquery js-->
    <script src="js/jquery/jquery.min.js"></script>

    <!--bootstrap js-->
    <script src="js/bootstrap/bootstrap.min.js"></script>

    <!--Custom Script-->
    <script src="js/script.js"></script>
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

</body>

</html>