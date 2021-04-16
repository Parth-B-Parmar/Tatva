<?php
include "db.php";
session_start();
$login = true;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

//value get from session
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $loggerid = $_SESSION['loggerid'];
} else
    $login = false;

//remove query
if (isset($_POST['unpublish_submit'])) {
    $noteid = $_POST['unpublish_noteid'];
    $review_admin = $_POST['unpublish_review'];

    //remove query
    $query_remove = mysqli_query($con, "UPDATE sellernotes SET status=8,admin_remarks='$review_admin',actionedby=$loggerid WHERE noteid=$noteid");

    // seller name getter
    $seller_name_getter = mysqli_query($con, " SELECT u.firstname,u.lastname,u.emailid,sn.admin_remarks,sn.title FROM users u LEFT JOIN sellernotes sn ON sn.sellerid=u.userid WHERE sn.noteid=$noteid");

    while ($row = mysqli_fetch_assoc($seller_name_getter)) {
        $seller_name = $row['firstname'] . ' ' . $row['lastname'];
        $seller_email = $row['emailid'];
        $admin_remark = $row['admin_remarks'];
        $note_title = $row['title'];
    }

    //mail function
        $to = $seller_email;
        $subject = "Sorry! We need to remove your notes from our portal.";
        $body = "Hello $seller_name,<br><br> ";
        $body.= "We want to inform you that, your note $note_title has been removed from the portal.<br>
          Please find our remarks as below -<br>
          <b>$review_admin</b> <br><br>";
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
    header("Location:dashboard-page.php");
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

    <!--Custom css-->
    <link rel="stylesheet" href="css/style.css">

    <!-- datatable css -->
    <link rel="stylesheet" href="css/datatables.min.css">

    <!--Responsive css-->
    <link rel="stylesheet" href="css/responsive.css">

    <!--popper js-->
    <script src="js/popper/popper.min.js"></script>

    <!--jquery js-->
    <script src="js/jquery/jquery.min.js"></script>

    <!--bootstrap js-->
    <script src="js/bootstrap/bootstrap.min.js"></script>

</head>

<body class="sticky-header">
    <div class="above-footer">


        <!--header -->
        <?php include "header.php" ?>
        <!--header end-->

        <div id="dashboard-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 column-padding-remover">
                        <h3 class="blue-font-34 margin-l">Dashboard</h3>
                    </div>
                </div>
            </div>
        </div>

        <div id="dashboard-statistics">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 column-padding-remover text-center">
                        <div class="row">
                            <div class="col-md-4 dashboard-right-statistics">
                                <a href="notes-under-review-page.php" title="click to open notes under review">
                                    <div class="dashboard-right-statistics-inner margin-dash-l-r margin-l margin-r">
                                        <h3 class="blue-font-30">
                                            <?php echo mysqli_num_rows(mysqli_query($con, "SELECT 1 FROM sellernotes WHERE status IN (4,5)")); ?>
                                        </h3>
                                        <h3 class="dark-font-18">Number of Notes in Review for Publish</h3>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 dashboard-right-statistics">
                                <a href="downloaded-notes-page.php" title="click to open downloaded notes">
                                    <div class="dashboard-right-statistics-inner margin-dash-l-r margin-l margin-r">
                                        <h3 class="blue-font-30">
                                            <?php echo mysqli_num_rows(mysqli_query($con, "SELECT 1 FROM downloads WHERE isattachmentdownloaded=1 AND attactmentdownloadeddate > NOW() - INTERVAL 1 WEEK")); ?>
                                        </h3>
                                        <h3 class="dark-font-18 margin-b-0"> Number of New Notes Download</h3>
                                        <h3 class="dark-font-18">(last 7 days)</h3>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 dashboard-right-statistics">
                                <a href="members-page.php" title="click to open members page">
                                    <div class="dashboard-right-statistics-inner margin-dash-l-r margin-r margin-l">
                                        <h3 class="blue-font-30">
                                            <?php echo mysqli_num_rows(mysqli_query($con, "SELECT 1 FROM users WHERE roleid=1 AND createddate > NOW() - INTERVAL 1 WEEK")); ?>
                                        </h3>
                                        <h3 class="dark-font-18 margin-b-0">Numbers of New Registrations</h3>
                                        <h3 class="dark-font-18">(last 7 days)</h3>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-in-progress-notes">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 column-padding-remover">
                        <h3 class="blue-font-24 margin-l dashboard-pub">Published Notes</h3>
                    </div>
                    <div id="dashboard-search-btn-2" class="col-md-6 column-padding-remover">
                        <div class="dashboard-search-jointer">
                            <input type="text" id="search_value"
                                class="form-control margin-l dashboard-search-icon search-icon"
                                placeholder="&#xf002; Search">
                            <button onclick="showData()" class="btn btn-primary blue-button-hover-white">search</button>
                            <?php
                            for ($i = 0; $i < 6; $i++) {
                                $months[] = date("M Y", strtotime(date('') . " -$i months"));
                                $months_val[] = date("m-Y", strtotime(date('') . " -$i months"));
                            }
                            ?>
                            <select id="dashboard-month" onchange="showData()"
                                class="form-control margin-r text-hidden options-arrow-down input-light-color">
                                <?php
                                for ($j = 0; $j <= count($months) - 1; $j++) {
                                    echo "<option value='$months_val[$j]'>$months[$j]</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
        function showData() {
            let search_val = $("#search_value").val();
            let month = $("#dashboard-month").val();
            $.ajax({
                url: "ajax/dashboard-ajax.php",
                method: "GET",
                data: {
                    search: search_val,
                    month: month
                },
                success: function(data) {
                    $("#dashboard_data").html(data);
                },
            });
        }
        $(function() {
            showData();
        });
        </script>

        <div id="dashboard_data"></div>
    </div>

    <!--footer-->
    <?php include "footer.php"; ?>
    <!--footer end-->

    <!-- datatables js -->
    <script src="js/datatables.min.js"></script>

    <!--Custom Script-->
    <script src="js/script.js"></script>

</body>

</html>