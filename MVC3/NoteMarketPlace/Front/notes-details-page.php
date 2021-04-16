<?php
include "db.php";
session_start();

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

if (isset($_GET['id']))
    $noteid = $_GET['id'];
else $noteid = 1;
$mail_sent = false;
$login = true;

//data from session
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $buyergetter = mysqli_query($con, "SELECT userid,lastname,firstname FROM users WHERE emailid='$email'");
    while ($row = mysqli_fetch_assoc($buyergetter)) {

        //buyer info getter
        $buyerid = $row['userid'];
        $full_name_buyer = $row['firstname'] . " " . $row['lastname'];

        //seller info getter
        $seller_getter = mysqli_query($con, "SELECT sellerid,selling_price,title,category FROM sellernotes WHERE noteid=$noteid");
        while ($row = mysqli_fetch_assoc($seller_getter)) {
            $sellerid = $row['sellerid'];
            $note_price = $row['selling_price'];
            $note_title = $row['title'];
            $category_id = $row['category'];
        }
    }
    $category_getter = mysqli_query($con, "SELECT name FROM notecategories WHERE categoryid='$category_id'");
    while ($row = mysqli_fetch_assoc($category_getter)) {
        $category_name = $row['name'];
    }
    $download_entry_checker = mysqli_query($con, "SELECT 1 FROM downloads WHERE noteid=$noteid AND downloader=$buyerid");
}

//single attachment
if (isset($_POST['single_download'])) {

    $attactments_getter = mysqli_query($con, "SELECT filepath,filename,noteid FROM sellernotesattachements WHERE noteid=$noteid");
    while ($row = mysqli_fetch_array($attactments_getter)) {
        $filepath = $row['filepath'];
    }
    $file_getter = mysqli_query($con, "SELECT title FROM sellernotes WHERE noteid=$noteid");
    while ($row = mysqli_fetch_array($file_getter)) {
        $title = $row['title'];
    }

    header('Cache-Control: public');
    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename=' . $title . '.pdf');
    header('Content-Type: application/pdf');
    header('Content-Transfer-Encoding:binary');
    readfile($filepath);

    $download_entry_number = mysqli_num_rows($download_entry_checker);
    if ($download_entry_number == 0 && $buyerid != $sellerid) {

        //insert query
        $attact_path_getter = mysqli_query($con, "SELECT filepath FROM sellernotesattachements WHERE noteid=$noteid");

        while ($row = mysqli_fetch_assoc($attact_path_getter)) {
            $path = $row['filepath'];

            $download_entry = mysqli_query($con, "INSERT INTO downloads(noteid,seller,downloader,
                           sellerhasalloweddownload,attactmentpath,isattachmentdownloaded,
                           attactmentdownloadeddate,ispaid,purchasedprice,notetitle,notecategory,
                           createddate,createdby,modifieddate,modifiedby)
                           VALUES($noteid,$sellerid,$buyerid,1,'$path',1,NOW(),2,'$note_price',
                           '$note_title','$category_name',NOW(),$buyerid,NOW(),$buyerid)");
        }
    }
}

//multiple attachement
if (isset($_POST['download_all'])) {
    $file_getter = mysqli_query($con, "SELECT DISTINCT title FROM sellernotes WHERE noteid=$noteid");
    while ($row = mysqli_fetch_array($file_getter)) {
        $title = $row['title'];
    }
    $zipname = $title . '.zip';
    $zip = new ZipArchive;
    $zip->open($zipname, ZipArchive::CREATE);
    $query = mysqli_query($con, "SELECT	filepath FROM sellernotesattachements WHERE noteid=$noteid");
    while ($row = mysqli_fetch_assoc($query)) {
        $attact_id = $row['filepath'];
        $zip->addFile($attact_id);
    }
    $zip->close();
    header('Content-Type: application/zip');
    header('Content-disposition: attachment; filename=' . $zipname);
    header('Content-Length: ' . filesize($zipname));
    readfile($zipname);

    $download_entry_number = mysqli_num_rows($download_entry_checker);
    if ($download_entry_number == 0 && $buyerid != $sellerid) {

        //insert query
        $attact_path_getter = mysqli_query($con, "SELECT filepath FROM sellernotesattachements WHERE noteid=$noteid");

        while ($row = mysqli_fetch_assoc($attact_path_getter)) {
            $path = $row['filepath'];
            $download_entry = mysqli_query($con, "INSERT INTO downloads(noteid,seller,downloader,
                             sellerhasalloweddownload,attactmentpath,isattachmentdownloaded,
                             attactmentdownloadeddate,ispaid,purchasedprice,notetitle,notecategory,
                             createddate,createdby,modifieddate,modifiedby)
                             VALUES($noteid,$sellerid,$buyerid,1,'$path',1,NOW(),2,'$note_price',
                             '$note_title','$category_name',NOW(),$buyerid,NOW(),$buyerid)");
        }
    }
}

//if note is paid
if (isset($_POST['purchase_yes_box'])) {
    $download_entry_number = mysqli_num_rows($download_entry_checker);
    if ($download_entry_number == 0 && $buyerid != $sellerid) {
        //insert query
        // sleep(2);
        $attact_path_getter = mysqli_query($con, "SELECT filepath FROM sellernotesattachements WHERE noteid=$noteid");

        while ($row = mysqli_fetch_assoc($attact_path_getter)) {
            $path = $row['filepath'];
            $download_entry = mysqli_query($con, "INSERT INTO downloads(noteid,seller,downloader,
                             sellerhasalloweddownload,attactmentpath,isattachmentdownloaded,
                             attactmentdownloadeddate,ispaid,purchasedprice,notetitle,notecategory,
                             createddate,createdby,modifieddate,modifiedby)
                             VALUES($noteid,$sellerid,$buyerid,0,'$path',0,NOW(),1,'$note_price',
                             '$note_title','$category_name',NOW(),$buyerid,NOW(),$buyerid)");
        }

        //seller nane getter
        $seller_id_getter = mysqli_query($con, "SELECT sellerid FROM sellernotes WHERE noteid=$noteid");
        while ($row = mysqli_fetch_assoc($seller_id_getter))
            $seller_id = $row['sellerid'];
        $seller_name_getter = mysqli_query($con, "SELECT firstname,lastname,emailid FROM users WHERE userid=$seller_id");
        while ($row = mysqli_fetch_assoc($seller_name_getter)) {
            $full_name_seller = $row['firstname'] . " " . $row['lastname'];
            $email_seller = $row['emailid'];
        }
        
        $to = $email_seller;
        $subject =  $full_name_buyer . " wants to purchase your notes";
        $body = "Hello <br>$full_name_seller</b><br><br> ";
        $body.= "We would like to inform you that,<b>$full_name_buyer</b> wants to purchase your notes. Please see Buyer Requests tab and allow download access to Buyer if you have received the payment from him. <br><br>";
        $body.= "Regards, <br> ";
        $body.= "Notes Marketplace";

        $headers = "From: pp895131@gmail.com" ;
        $headers .= "MIME-Version: 1.0" . "\r\n" ;
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n" ;
        if(mail($to, $subject, $body, $headers))  {
            echo "Sent";
        } else {
            echo "failed";
        }
    }
}
if (isset($_POST['no-login']))
    $login = false;

//contact_us_phone_ getter
//if systemconfiguration table has null entry
$contact_us_phone_no = "91 9106985141";
$contact_us_phone_getter = mysqli_query($con, "SELECT value FROM systemconfiguration WHERE key_info='support_phone_no'");
while ($row = mysqli_fetch_assoc($contact_us_phone_getter))
    $contact_us_phone_no = $row['value'];
?>

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

    <!-- jsRapstar css -->
    <link rel="stylesheet" href="css/jsRapStarSmall.css">

    <!--Responsive css-->
    <link rel="stylesheet" href="css/responsive.css">

    <!--popper js-->
    <script src="js/popper/popper.min.js"></script>

    <!--jquery js-->
    <script src="js/jquery/jquery.min.js"></script>

    <!-- JsRapstar js -->
    <script src="js/jsRapStar.js"></script>

</head>

<body class="sticky-header">

    <!--header -->
    <?php include "header.php" ?>
    <!--header end-->

    <div id="search-all-font">

        <?php
        //to get all required infomation
        $data_fetch = mysqli_query($con, "SELECT * FROM sellernotes WHERE noteid=$noteid");
        while ($row = mysqli_fetch_assoc($data_fetch)) {
            $note_photo = $row['displaypic'];
            $note_title = $row['title'];
            $note_category = $row['category'];
            $note_des = $row['description'];
            $sell_type = $row['ispaid'];
            $sell_price = $row['selling_price'];
            $university = $row['university_name'];
            $country = $row['country'];
            $course = $row['course'];
            $course_code = $row['course_code'];
            $professor = $row['proffesor'];
            $note_page = $row['page_no'];
            $pubhlished_date = $row['publisheddate'];
        }

        $country_getter = mysqli_query($con, "SELECT name FROM countries WHERE countryid=$country");
        while ($row = mysqli_fetch_assoc($country_getter)) {
            $country_name = $row['name'];
        }

        $category_getter = mysqli_query($con, "SELECT name FROM notecategories WHERE categoryid =$note_category");
        while ($row = mysqli_fetch_assoc($category_getter)) {
            $category_name = $row['name'];
        }
        ?>
        <!--Upper part-->
        <div id="note-details-upper">
            <div class="container">
                <div class="row">
                    <div id="note-details-heading" class="col-md-12 blue-font-24">
                        Notes Details
                    </div>
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="row">
                            <div class="col-md-5 note-details-internal-spacing">
                                <?php echo " <img src='$note_photo' class='img-fluid' title='$note_title' alt='Book cover photo of $note_title'>" ?>
                            </div>
                            <div class="col-md-7 note-details-internal-spacing">
                                <div id="note-details-spacer-1" class="one-time-only-download">
                                    <div id="note-details-left-description">
                                        <h3 class="blue-font-30"><?php echo $note_title ?></h3>
                                    </div>
                                    <div id="note-details-book-type">
                                        <h4> <?php echo $category_name ?></h4>
                                    </div>
                                    <h5 style="margin-bottom: 20px;" class="dark-font-16" id="note-details-book-des">
                                        <?php echo $note_des ?>
                                    </h5>
                                    <?php

                                    //chcker wheather user log in or not
                                    if (isset($_SESSION['email'])) {

                                        //if note is paid
                                        if ($sell_type == 1) {
                                            echo " <button id='note-deatils-download-btn' data-toggle='modal'
                                        data-target='#confirm-purchase-popup'
                                        class='btn btn-primary blue-button-hover-white'>download / &#36;$sell_price</button>";
                                            if ($sellerid == $buyerid)
                                                echo "<h6>You Self own this note so downloading it won't display in the buyer request section</h6>";
                                        }

                                        //if note is free
                                        if ($sell_type == 2) {
                                            $attactments_getter = mysqli_query($con, "SELECT noteid FROM sellernotesattachements WHERE noteid=$noteid");
                                            $attact_count = mysqli_num_rows($attactments_getter);

                                            //if note has single attachement
                                            if ($attact_count <= 1) {
                                                echo "<form action='' method='POST'>";
                                                echo " <button type='submit' name='single_download' id='note-deatils-download-btn'
                                                class='btn btn-primary blue-button-hover-white'>download</button>";
                                                echo "</form>";
                                                if ($sellerid == $buyerid)
                                                    echo "<h6>You Self own this note so downloading it won't display in the buyer request section</h6>";

                                                //if note has multiple attachements
                                            } else if ($attact_count > 1) {
                                    ?>
                                    <form action="" method="post">
                                        <button id='note-deatils-download-btn' name='download_all'
                                            class='btn btn-primary blue-button-hover-white'>download</button>
                                    </form>
                                    <?php
                                                if ($sellerid == $buyerid)
                                                    echo "<h6>You Self own this note so downloading it won't display in the buyer request section</h6>";
                                            }
                                        }
                                    }

                                    //if user has not log-in
                                    else {
                                        echo "<form method='POST'>";
                                        echo " <button class='btn btn-primary blue-button-hover-white' name='no-login'>download</button>";
                                        echo "</form>";
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="row">
                            <div class="col-md-6 col-6 column-padding-remover-lite">
                                <div id="note-details-spacer-2">
                                    <div id="note-details-des-type">
                                        <h3>institution:</h3>
                                        <h3>country:</h3>
                                        <h3>course name:</h3>
                                        <h3>course code:</h3>
                                        <h3>professor:</h3>
                                        <h3>number of pages:</h3>
                                        <h3>approved date:</h3>
                                        <h3>rating:</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 text-right col-6 column-padding-remover">
                                <div id="note-details-des-ans">
                                    <h3><?php echo (!empty($university) && $university != '') ? $university : 'Not specified' ?></h3>
                                    <h3><?php echo (!empty($country_name) && $country_name != '') ? $country_name : 'Not specified' ?></h3>
                                    <h3><?php echo (!empty($course) && $course) ? $course : 'Not specified' ?></h3>
                                    <h3><?php echo (!empty($course_code) && $course_code != '') ? $course_code : 'Not specified' ?></h3>
                                    <h3><?php echo (!empty($professor) && $professor != '') ? $professor : 'Not specified' ?></h3>
                                    <h3><?php echo $note_page ?></h3>
                                    <h3><?php echo date('D,d F Y', strtotime($pubhlished_date)); ?></h3>
                                    <?php
                                    $star_rating = mysqli_query($con, "SELECT AVG(ratings),COUNT(ratings) FROM sellernotesreview WHERE noteid=$noteid");
                                    while ($row = mysqli_fetch_assoc($star_rating)) {
                                        $star_rating_val = $row['AVG(ratings)'];
                                        $star_rating_count = $row['COUNT(ratings)'];
                                    }
                                    if ($star_rating_count > 0) { ?>
                                    <div class="rating-merger">
                                        <div id="review_star"></div>
                                        <h3><?php echo $star_rating_count ?> reviews</h3>
                                    </div>
                                    <?php  } else { ?>
                                    <div>
                                        <h3>No ratings Yet!</h3>
                                        <h6 class="first-reviewer">(be the first to review it!)</h6>
                                    </div>
                                    <?php   } ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        $inappropriate = mysqli_query($con, "SELECT COUNT(1) FROM sellernotesreportedissues WHERE noteid=$noteid");
                        while ($row = mysqli_fetch_assoc($inappropriate))
                            $inappropriate_count = $row['COUNT(1)'];
                        if ($inappropriate_count > 0) { ?>
                        <h4 id="note-details-red-mark" class="note-details-internal-spacing">
                            <?php echo $inappropriate_count ?> User(s) marked this note as inappropriate</h4>
                        <?php }  ?>
                    </div>
                </div>
                <hr>
            </div>
        </div>
        <!--Upper part end-->

        <!--Lower part-->
        <div id="note-details-lower">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-12 col-12">
                        <h3 class="blue-font-24 note-details-internal-spacing">Notes Preview</h3>
                        <div id="Iframe-Cicis-Menu-To-Go"
                            class="set-margin-cicis-menu-to-go set-padding-cicis-menu-to-go set-border-cicis-menu-to-go set-box-shadow-cicis-menu-to-go center-block-horiz">
                            <div class="responsive-wrapper 
          responsive-wrapper-padding-bottom-90pct" style="-webkit-overflow-scrolling: touch; overflow: auto;">
                                <?php $notes_preview_getter = mysqli_query($con, "SELECT notespreview FROM sellernotes WHERE noteid=$noteid");
                                while ($row = mysqli_fetch_assoc($notes_preview_getter))
                                    $preview_path = $row['notespreview'];
                                ?>
                                <iframe src="<?php echo $preview_path; ?>">
                                    <p style="font-size: 110%;"><em><strong>ERROR: </strong>
                                            An &#105;frame should be displayed here but your browser version does not
                                            support &#105;frames.</em> Please update your browser to its most recent
                                        version and try again, or access the file <a
                                            href="<?php echo $preview_path; ?>">with
                                            this link.</a></p>
                                </iframe>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-12 col-12 customer-rating-res">
                        <h3 class="blue-font-24 note-details-internal-spacing">Customer Reviews</h3>
                        <iframe style="width: 100%;height:450px;border:2px solid #333"
                            src="notes-details-customer-review.php?noteid=<?php echo $noteid ?>"
                            frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <!--Lower part end-->

        <form action="" method="POST">
            <!-- Thanks Pop up -->
            <div class="popup-box">
                <div id="notes-deatils-purchase-popup" class="modal fade" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <button type="button" class="close text-right popup-close-btn" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="modal-body">
                                <img src="images/SUCCESS.png" alt="Success Purchase Message"
                                    class="img-fluid popup-success-img text-center"
                                    style="display: block; margin: 0 auto;transform: translateY(-20px);">
                                <h6 style="margin-top: -20px;" class="blue-font-26 text-center">Thank you for
                                    Purchasing!</h6>
                                <p class="dark-font-16 popup-buyer-name"><b><?php echo $full_name_buyer; ?>,</b></p>
                                <p class="dark-font-14">As this is paid notes-you need to pay to seller
                                    <?php echo $full_name_seller; ?>
                                    offline.We will send him an email that you want to download this note.He may contact
                                    you further for payment process completion.</p>
                                <p class="dark-font-14 popup-emergency">In case you have urgancy,</p>
                                <p class="dark-font-14">Please Contact us on <?php echo '+' . $contact_us_phone_no ?>.
                                </p>
                                <p class="dark-font-14">Once he receives the payment and acknowledge us-selected notes
                                    you can see over my download tab for download.</p>
                                <p class="dark-font-14">Have a good day.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- confirm Pop up -->
            <div class="popup-box">
                <div style="margin-top: 200px;" id="confirm-purchase-popup" class="modal fade" tabindex="-1"
                    role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <button type="button" class="close text-right popup-close-btn" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div style="margin-top: -20px;" class="modal-body">
                                <h6 class="blue-font-24">Are you sure you want to download this Paid note? </h6>
                                <h6 style="margin-top: 20px;" class="dark-font-22"> Please confirm. </h6>
                                <div style="margin-top:15px;">
                                    <button type="submit" data-toggle='modal' style="margin-right: 30px;"
                                        name="purchase_yes_box"
                                        class="btn btn-primary blue-button-hover-white">yes</button>
                                    <button id="purchase_no_box"
                                        class="btn btn-primary blue-button-hover-white">no</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!--footer-->
        <?php include "footer.php"; ?>
        <!--footer end-->

    </div>

    <script>
    $('#review_star').jsRapStar({
        length: 5,
        starHeight: 30,
        colorFront: 'yellow',
        enabled: false,
        value: '<?php echo $star_rating_val ?>',
    });
    </script>

    <!-- log-in failed -->
    <?php if (!$login) { ?>
    <script>
    alert(
        "Please sign in/register to download '<?php echo $note_title ?>' note\npressing OK you will be redirect to login page"
    );
    window.location.replace("log-in-page.php");
    </script>
    <?php } ?>

    <!--bootstrap js-->
    <script src="js/bootstrap/bootstrap.min.js"></script>

    <script>
    <?php
        if ($mail_sent) { ?>
    $("#confirm-purchase-popup").modal('hide');
    $("#notes-deatils-purchase-popup").modal('show');
    <?php } ?>
    </script>

    <!--Custom Script-->
    <script src="js/script.js"> </script>

</body>

</html>
