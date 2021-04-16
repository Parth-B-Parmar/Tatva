<?php
include "db.php";
session_start();

//to get member userid
$memberid = (isset($_GET['id'])) ? $_GET['id'] : "";

//value get from session
$login = true;
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $loggerid = $_SESSION['loggerid'];
} else
    $login = false;

//to get all the members info
$member_getter = mysqli_query($con, "SELECT u.firstname,u.lastname,u.emailid,p.dob,p.phone_no,p.profile_pic,
                                     p.college,p.university,p.address_line1,p.address_line2,p.city,p.state,c.name,p.zipcode
                                     FROM users u
                                     LEFT JOIN userprofile p
                                     ON u.userid=p.userid 
                                     LEFT JOIN countries c
                                     ON c.countryid=p.country WHERE u.userid=$memberid");

//to get all the user data
while ($row = mysqli_fetch_assoc($member_getter)) {

    $fname = $row['firstname'];
    $lname = $row['lastname'];
    $email_member = $row['emailid'];
    $dob = $row['dob'];
    $college = $row['college'];
    $university = $row['university'];
    $phone_no = $row['phone_no'];
    $address_1 = $row['address_line1'];
    $address_2 = $row['address_line2'];
    $city = $row['city'];
    $state = $row['state'];
    $counrty = $row['name'];
    $zipcode = $row['zipcode'];
    $profile_pic = (!empty($row['profile_pic'])) ? $row['profile_pic'] : "../Members/default/PP_default.jpg";
}

//to download the note
if (isset($_GET['title'])) {
    $title = $_GET['title'];
    $noteid = $_GET['noteid'];

    //to get attachments
    $download_query = mysqli_query($con, "SELECT filepath FROM sellernotesattachements WHERE noteid=$noteid");
    while ($row = mysqli_fetch_assoc($download_query)) {
        $note_path = $row['filepath'];

        //counter for attachments
        $download_count = mysqli_num_rows($download_query);

        //single attachments
        if ($download_count == 1) {
            header('Cache-Control: public');
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename=' . $title . '.pdf');
            header('Content-Type: application/pdf');
            header('Content-Transfer-Encoding:binary');
            readfile($note_path);
        }

        //multiple attachments
        if ($download_count > 1) {
            $zipname = $title . '.zip';
            $zip = new ZipArchive;
            $zip->open($zipname, ZipArchive::CREATE);
            $zip->addFile($note_path);
            $zip->close();

            header('Content-Type: application/zip');
            header('Content-disposition: attachment; filename=' . $zipname);
            header('Content-Length: ' . filesize($zipname));
            readfile($zipname);
        }
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

    <!-- data table css -->
    <link rel="stylesheet" href="css/datatables.min.css">

    <!--Custom css-->
    <link rel="stylesheet" href="css/style.css">

    <!--Responsive css-->
    <link rel="stylesheet" href="css/responsive.css">

    <!--popper js-->
    <script src="js/popper/popper.min.js"></script>

    <!--jquery js-->
    <script src="js/jquery/jquery.min.js"></script>

    <!--bootstrap js-->
    <script src="js/bootstrap/bootstrap.min.js"></script>

    <!-- data table js -->
    <script src="js/datatables.min.js"></script>

</head>

<body class="sticky-header">

    <div class="above-footer">

        <!--header -->
        <?php include "header.php" ?>
        <!--header end-->

        <div class="container column-padding-remover">
            <div class="row padding-b-30 member-bottom-border">
                <div class="col-md-12 col-12 member-name">
                    <h3 class="blue-font-34 heading-margin margin-b-15 margin-l">Member Details</h3>
                </div>
                <div id="member-photo" class="col-md-3 col-lg-2 col-12">
                    <img src="<?php echo $profile_pic ?>" title="<?php echo $fname . ' ' . $lname ?>" class="img-fluid"
                        alt="Member Photo-<?php echo $fname . ' ' . $lname ?>">
                </div>
                <div class="col-md-9 col-lg-5 col-sm-12 member-deatils-spacer-res">
                    <div class="row">
                        <div class="col-md-5 col-lg-5 col-sm-6 col-6 space-remover-1">
                            <h4 class="member-dark-font">First Name:</h4>
                            <h4 class="member-dark-font">Last Name:</h4>
                            <h4 class="member-dark-font">Email:</h4>
                            <h4 class="member-dark-font">DOB:</h4>
                            <h4 class="member-dark-font">Phone Number:</h4>
                            <h4 class="member-dark-font">College/University:</h4>
                        </div>
                        <div class="col-md-7 col-lg-7 col-sm-6 col-6 space-remover-2">
                            <div id="member-center-border">
                                <h4 class="member-blue-font"><?php echo $fname ?></h4>
                                <h4 class="member-blue-font"><?php echo $lname ?></h4>
                                <h4 class="member-blue-font"><?php echo $email_member ?></h4>
                                <h4 class="member-blue-font"><?php echo $dob ?></h4>
                                <h4 class="member-blue-font"><?php echo $phone_no ?></h4>
                                <h4 class="member-blue-font"><?php echo $college . '/' . $university ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-lg-4 col-12 member-deatils-spacer-res-2">
                    <div class="row">
                        <div class="col-md-5 col-lg-5 col-sm-6 col-6 space-remover-1">
                            <h4 class="member-dark-font">Address 1:</h4>
                            <h4 class="member-dark-font">Address 2:</h4>
                            <h4 class="member-dark-font">City:</h4>
                            <h4 class="member-dark-font">State:</h4>
                            <h4 class="member-dark-font">Country:</h4>
                            <h4 class="member-dark-font">Zip Code:</h4>
                        </div>
                        <div class="col-md-7 col-lg-7 col-sm-6 col-6 space-remover-2">
                            <h4 class="member-blue-font"><?php echo $address_1 ?></h4>
                            <h4 class="member-blue-font"><?php echo $address_2 ?></h4>
                            <h4 class="member-blue-font"><?php echo $city ?></h4>
                            <h4 class="member-blue-font"><?php echo $state ?></h4>
                            <h4 class="member-blue-font"><?php echo $counrty ?></h4>
                            <h4 class="member-blue-font"><?php echo $zipcode ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 col-lg-1"></div>
            </div>
        </div>

        <!-- ajax call -->
        <script>
        function showData() {
            $.ajax({
                url: "ajax/member-details-ajax.php",
                method: "GET",
                data: {
                    id: <?php echo $memberid ?>,
                },
                success: function(data) {
                    $("#member_detail").html(data);
                }
            });
        };

        // function call
        $(function() {
            showData();
        })
        </script>

        <!-- here data will be fetched for ajax-->
        <div id="member_detail"></div>
    </div>

    <!--footer-->
    <?php include "footer.php"; ?>
    <!--footer end-->

    <!--Custom Script-->
    <script src="js/script.js"></script>

</body>

</html>