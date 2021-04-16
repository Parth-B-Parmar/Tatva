<?php
include "db.php";
session_start();

//value get from session
$login = true;
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $loggerid = $_SESSION['loggerid'];
} else
    $login = false;

//deactive the review
if (isset($_POST['popup_submit'])) {

    //id getter
    $nri_id = $_POST['popup_id'];

    //modify the NRI table and delete the review
    $del_review = mysqli_query($con, "DELETE FROM sellernotesreportedissues WHERE note_reportid=$nri_id");
    header("Location:spam-report-page.php");
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

        <div class="container">
            <div class="row heading-margin">
                <div class="col-md-6 column-padding-remover">
                    <h4 class="blue-font-30 margin-l">Spam Reports</h4>
                </div>
                <div class="col-md-2"></div>
                <div id="dashboard-search-btn-2" class="col-md-4 column-padding-remover">
                    <div class="dashboard-search-jointer">
                        <input type="text" id="search_data"
                            class="form-control margin-l dashboard-search-icon search-icon"
                            placeholder="&#xf002; Search">
                        <button class="btn btn-primary blue-button-hover-white margin-r"
                            onclick="showData()">search</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ajax call -->
        <script>
        function showData() {

            let search_string = $("#search_data").val();
            $.ajax({
                url: "ajax/spam-report-ajax.php",
                method: "GET",
                data: {
                    search: search_string,
                },
                success: function(result) {
                    $("#spam_data").html(result);
                }
            });
        }
        showData();
        </script>

        <!-- data from ajax will display here -->
        <div id="spam_data"></div>

    </div>

    <!--footer-->
    <?php include "footer.php"; ?>
    <!--footer end-->

    <!--Custom Script-->
    <script src="js/script.js"></script>

</body>

</html>