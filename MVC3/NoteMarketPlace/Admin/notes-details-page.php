<?php
include "db.php";
session_start();

if (isset($_GET['id']))
    $noteid = $_GET['id'];
else $noteid = 1;

//if note has single attachment
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
}

//if it has more then one attachments
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
}

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
                                    $attactments_getter = mysqli_query($con, "SELECT noteid FROM sellernotesattachements WHERE noteid=$noteid");
                                    $attact_count = mysqli_num_rows($attactments_getter);

                                    //if note has single attachement
                                    if ($attact_count <= 1) { ?>
                                    <form action='' method='POST'>
                                        <button type='submit' name='single_download' id='note-deatils-download-btn'
                                            class='btn btn-primary blue-button-hover-white'>
                                            <?php echo ($sell_type == 1) ? "Download / &#36;$sell_price" : "Download" ?>
                                        </button>
                                    </form>

                                    <!-- if note has multiple attachements -->
                                    <?php  } else if ($attact_count > 1) {  ?>
                                    <form action="" method="post">
                                        <button id='note-deatils-download-btn' name='download_all'
                                            class='btn btn-primary blue-button-hover-white'>
                                            <?php echo ($sell_type == 1) ? "Download / &#36;$sell_price" : "Download" ?>
                                        </button>
                                    </form>
                                    <?php
                                    }
                                    ?>

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
                                    $star_rating = mysqli_query($con, "SELECT AVG(ratings),COUNT(ratings) FROM sellernotesreview WHERE noteid=$noteid AND isactive=1");
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

    <!--bootstrap js-->
    <script src="js/bootstrap/bootstrap.min.js"></script>

    <!--Custom Script-->
    <script src="js/script.js"> </script>

</body>

</html>
