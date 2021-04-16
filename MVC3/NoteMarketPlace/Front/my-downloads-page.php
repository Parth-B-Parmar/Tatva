<?php
include "db.php";
session_start();

//for mailer
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$login = true;
if (isset($_SESSION['email']))
    $email_buyer = $_SESSION['email'];
else
    $login = false;

//downloader id
$buyer_id_getter = mysqli_query($con, "SELECT userid,firstname,lastname FROM users WHERE emailid='$email_buyer'");
while ($row = mysqli_fetch_assoc($buyer_id_getter)) {
    $buyer_id = $row['userid'];
    $full_name_reporter = $row['firstname'] . " " . $row['lastname'];
}

//for downloading
if (isset($_GET['noteid'])) {
    $noteid = $_GET['noteid'];
    $download_query = mysqli_query($con, "SELECT notetitle,attactmentpath FROM downloads WHERE noteid=$noteid AND downloader=$buyer_id");
    while ($row = mysqli_fetch_assoc($download_query)) {
        $note_path = $row['attactmentpath'];
        $note_title = $row['notetitle'];

        $download_count = mysqli_num_rows($download_query);
        if ($download_count == 1) {
            header('Cache-Control: public');
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename=' . $note_title . '.pdf');
            header('Content-Type: application/pdf');
            header('Content-Transfer-Encoding:binary');
            readfile($note_path);

            $attached_downloaded = mysqli_query($con, "UPDATE downloads SET isattachmentdownloaded=1,attactmentdownloadeddate=NOW() WHERE noteid=$noteid AND downloader=$buyer_id");
        }
        if ($download_count > 1) {
            $zipname = $note_title . '.zip';
            $zip = new ZipArchive;
            $zip->open($zipname, ZipArchive::CREATE);
            $zip->addFile($note_path);
            $zip->close();

            header('Content-Type: application/zip');
            header('Content-disposition: attachment; filename=' . $zipname);
            header('Content-Length: ' . filesize($zipname));
            readfile($zipname);

            $attached_downloaded = mysqli_query($con, "UPDATE downloads SET isattachmentdownloaded=1,attactmentdownloadeddate=NOW() WHERE noteid=$noteid AND downloader=$buyer_id");
        }
    }
}

$query_appender = "";

//search button
if (isset($_POST['search'])) {
    $search_result = $_POST['search_result'];
    $query_appender = " AND (notetitle LIKE '%$search_result%' OR notecategory LIKE '%$search_result%' 
                        OR emailid LIKE '%$search_result%' OR ispaid LIKE '%$search_result%' 
                        OR purchasedprice LIKE '%$search_result%')";
}

//main query
$query_data_getter = "SELECT DISTINCT downloads.noteid,downloads.seller,downloads.notetitle,downloads.notecategory,users.emailid,downloads.ispaid,
                      downloads.purchasedprice,downloads.createddate FROM downloads 
                      LEFT JOIN users ON downloads.seller=users.userid 
                      WHERE sellerhasalloweddownload=1 AND downloader=$buyer_id";

$query_data_getter .= $query_appender . " ORDER BY downloads.createddate DESC";

//review pop up
if (isset($_POST['submit_review'])) {
    $cmnt_review = $_POST['cmnt_review'];
    $rating_value = $_POST['starVal'];
    $noteid = $_POST['noteid_for_review'];

    $seller_id_getter = mysqli_query($con, "SELECT sellerid FROM sellernotes WHERE noteid=$noteid");
    while ($row = mysqli_fetch_assoc($seller_id_getter))
        $sellerid = $row['sellerid'];

    $exist_review = mysqli_query($con, "SELECT COUNT(1) FROM sellernotesreview WHERE reviewer_id=$buyer_id AND noteid=$noteid");
    while ($row = mysqli_fetch_assoc($exist_review))
        $count_review = $row['COUNT(1)'];

    if ($count_review == 0)
        $ratting_getter = mysqli_query($con, "INSERT INTO sellernotesreview(noteid,reviewer_id,againstdownloadsid,comments,ratings,createdby,createddate,modifiedby,modifieddate,isactive) 
                          VALUES($noteid,$buyer_id,$sellerid,'$cmnt_review','$rating_value',$buyer_id,NOW(),$buyer_id,NOW(),1)");
}

//mark as an inappropriate pop up
if (isset($_POST['inappropriate_submit'])) {

    $noteid_inappropriate = $_POST['inappropriate_noteid'];
    $sellerid_inappropriate = $_POST['inappropriate_seller'];
    $remark_inappropriate = $_POST['inappropriate_review'];

    $exist_inappropriate = mysqli_query($con, "SELECT COUNT(1),note_reportid  FROM sellernotesreportedissues WHERE reprotedbyid=$buyer_id AND noteid=$noteid_inappropriate");
    while ($row = mysqli_fetch_assoc($exist_inappropriate))
        $count_inappropriate = $row['COUNT(1)'];

    if ($count_inappropriate == 0) {
        $report_query = mysqli_query($con, "INSERT INTO sellernotesreportedissues(noteid,reprotedbyid,againstdownloaderid,remarks,createddate,createdby) 
        VALUES($noteid_inappropriate,$buyer_id,$sellerid_inappropriate,'$remark_inappropriate',NOW(),$buyer_id)");

        $title_selector = mysqli_query($con, "SELECT title,firstname,lastname,emailid FROM sellernotes LEFT JOIN users ON users.userid=sellernotes.sellerid WHERE noteid=$noteid_inappropriate");
        while ($row = mysqli_fetch_assoc($title_selector)) {
            $title_inappropriate = $row['title'];
            $full_name_reporter_againts = $row['firstname'] . " " . $row['lastname'];
            $reporter_againts_email = $row['emailid'];
        }
        
        $to = "pp895131@gmail.com";
        $subject = $full_name_reporter . "  Reported an issue for " . $title_inappropriate;
        $body = "Hello Admins, We want to inform you that,<b>$full_name_reporter</b> Reported an issue for <b>$full_name_reporter_againts</b><b>’s</b> Note with title <b>$title_inappropriate</b>. Please look at the notes and take required actions.<br><br>";
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

    <!-- jsRapStar css -->
    <link rel="stylesheet" href="css/jsRapStar.css">

    <!-- data table css -->
    <link rel="stylesheet" href="css/datatables.min.css">

    <!--Custom css-->
    <link rel="stylesheet" href="css/style.css">

    <!--Responsive css-->
    <link rel="stylesheet" href="css/responsive.css">

</head>

<body class="sticky-header">

    <!--header -->
    <?php include "header.php" ?>
    <!--header end-->

    <div id="search-all-font">
        <div id="my-downloads-heading">
            <div class="dashboard-in-progress-notes">
                <div class="container">
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-md-6 column-padding-remover">
                                <h3 class="blue-font-24 dashboard-title">My Downloads</h3>
                            </div>
                            <div class="col-md-2">
                            </div>
                            <div id="dashboard-search-btn-2" class="col-md-4 column-padding-remover">
                                <div class="dashboard-search-jointer dashboard-title">
                                    <input type="text" name="search_result" class="form-control dashboard-search-icon search-icon" placeholder="&#xf002; Search">
                                    <button class="btn btn-primary blue-button-hover-white dashboard-title-r" name="search">search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="container my-download-table">
            <div class="row">
                <div class="col-md-12 column-padding-remover">
                    <table id="myTable" class="table entire-table-for-buyer-req table-small">
                        <thead>
                            <tr class="table-heading">
                                <th>SR no.</th>
                                <th>note title</th>
                                <th>category</th>
                                <th>buyer</th>
                                <th>sell type</th>
                                <th>price</th>
                                <th>downloaded date/time</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $downlaods_data_getter = mysqli_query($con, $query_data_getter);
                            $sr_no = 1;
                            while ($row = mysqli_fetch_assoc($downlaods_data_getter)) {
                                $seller_id = $row['seller'];
                                $noteid = $row['noteid'];
                                $notetitle = $row['notetitle'];
                                $notecategory = $row['notecategory'];
                                $emailid_seller = $row['emailid'];
                                $ispaid = $row['ispaid'];
                                $purchasedprice = $row['purchasedprice'];
                                $createddate = $row['createddate'];
                            ?>
                                <tr>
                                    <td><?php echo $sr_no ?></td>
                                    <td><a class="deco-none" title="click to view <?php echo $notetitle ?>" href="notes-details-page.php?id=<?php echo $noteid ?>"><?php echo $notetitle ?></a>
                                    </td>
                                    <td><?php echo $notecategory ?></td>
                                    <td><?php echo $emailid_seller ?></td>
                                    <td><?php if ($ispaid == 2) echo "Free";
                                        else if ($ispaid == 1) echo "Paid" ?></td>
                                    <td><?php if ($ispaid == 2) echo "&#36;0";
                                        else if ($ispaid == 1) echo "&#36;" . $purchasedprice ?></td>
                                    <td><?php echo date("d-m-y, H:i", strtotime($createddate)); ?></td>
                                    <td>
                                        <div class="table-pic-combiner">
                                            <a href="notes-details-page.php?id=<?php echo $noteid ?>"> <img src="images/eye.png" title="Click to view <?php echo $notetitle ?>" class="table-first-img" alt="View"></a>
                                            <div class="dropdown dropleft">
                                                <a class="btn" href="" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <img src="images/dots.png" alt="open menu">
                                                </a>
                                                <ul class="dropdown-menu shadow-drop dropdowncustom-width dropdowncustom">
                                                    <li><a href="my-downloads-page.php?noteid=<?php echo $noteid; ?>">
                                                            <h6 class="dropdown-first-option">Download Note</h6>
                                                        </a></li>
                                                    <li><a role="button" data-id="<?php echo $noteid; ?>" id="add-review-star" data-toggle="modal" data-target="#add-review-popup">
                                                            <h6>Add Review/feedback</h6>
                                                        </a></li>
                                                    <li><a role="button" data-toggle="modal" data-title="<?php echo $notetitle ?>" data-noteid="<?php echo $noteid ?>" data-seller_id="<?php echo $seller_id ?>" data-target="#mark-as-inappropriate" id="inappropriate">
                                                            <h6 class="report-my-downloads">Report as inappropriate</h6>
                                                        </a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                                $sr_no++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Table end-->

        <!-- Add review Pop up -->
        <div class="review-box">
            <div style="margin-top: 120px;" id="add-review-popup" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <button type="button" class="close text-right popup-close-btn" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="modal-body">
                            <form action="" method="POST">
                                <h4 class="blue-font-26">Add Review</h4>
                                <div id="review-popup-rating"></div>
                                <div class="form-group">
                                    <label id="review-label">Comments *</label>
                                    <textarea id="review-comment-box" name="cmnt_review" placeholder="Comments..." class="form-control" required></textarea>
                                    <input name="starVal" id="starVal" type="hidden">
                                    <input name="noteid_for_review" id="noteid_for_review" type="hidden">
                                </div>
                                <button id="review-popup-btn" type="submit" name="submit_review" class="btn btn-primary blue-button-hover-white">submit</button>
                                <button class="btn btn-primary blue-button-hover-white btn-upper">cancel</button>
                                <h6 class="one-time-only">(you can review it only once!)</h6>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mark as an inapropriate Pop up -->
        <div class="review-box">
            <div style="margin-top: 120px;" id="mark-as-inappropriate" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <button type="button" class="close text-right popup-close-btn" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="modal-body">
                            <form action="" method="POST">
                                <h4 id="title_for_inappropriate" class="blue-font-26"></h4>
                                <div class="form-group">
                                    <label id="review-label2">Remarks *</label>
                                    <textarea id="review-comment-box2" name="inappropriate_review" placeholder="Remarks..." class="form-control" required></textarea>
                                </div>
                                <input id="note_id_inappropriate" name="inappropriate_noteid" type="hidden">
                                <input id="note_seller_inappropriate" name="inappropriate_seller" type="hidden">
                                <button id="review-popup-btn2" type="submit" name="inappropriate_submit" class="btn red-button-hover-white">Report</button>
                                <button class="btn btn-primary blue-button-hover-white btn-upper">cancel</button>
                                <h6 class="one-time-only">(you can review it only once!)</h6>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--footer-->
        <?php include "footer.php"; ?>
        <!--footer end-->
    </div>


    <!--popper js-->
    <script src="js/popper/popper.min.js"></script>

    <!--jquery js-->
    <script src="js/jquery/jquery.min.js"></script>

    <!-- data table js -->
    <script src="js/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "scrollX": true,
                "pageLength": 8
            });
        });
    </script>

    <!-- jsRapStar js -->
    <script src="js/jsRapStar.js"></script>
    <script>
        $("#review-popup-rating").jsRapStar({
            step: false,
            value: 0,
            length: 5,
            starHeight: 64,
            colorFront: '#d8d8d8',
            onClick: function(score) {
                this.StarF.css({
                    color: '#ffff00',
                    'text-shadow': '0 0 10px #13a2d1'
                });
                $("#starVal").val(score);
            },
            onMousemove: function(score) {
                $(this).attr('title', 'Rate ' + score);
            }
        });

        $(function() {

            //note id getter via data id
            $(document).on("click", "#add-review-star", function() {
                $('#noteid_for_review').val($(this).data('id'));
                $('#add-review-popup').modal('show');
            });

            //note title getter via data id
            $(document).on("click", "#inappropriate", function() {
                $("#title_for_inappropriate").text($(this).data('title'));
                $("#note_id_inappropriate").val($(this).data('noteid'));
                $("#note_seller_inappropriate").val($(this).data('seller_id'));
                $("#mark-as-inappropriate").modal('show');
            })

            //table resizer for less entries
            $('#myTable').on('show.bs.dropdown', function() {
                $('#myTable').css("min-height", "135px");
            });

            $('#myTable').on('hide.bs.dropdown', function() {
                $('#myTable').css("min-height", "0");
            });
        });
    </script>

    <!--bootstrap js-->
    <script src="js/bootstrap/bootstrap.min.js"></script>

    <!--Custom Script-->
    <script src="js/script.js"></script>

</body>

</html>