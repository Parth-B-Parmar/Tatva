<?php
include "db.php";
session_start();
$login = true;

//value get from session
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $loggerid = $_SESSION['loggerid'];
} else
    $login = false;

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

//unpublish
if (isset($_POST['unpublish_submit'])) {
    $noteid = $_POST['reject_noteid'];
    $remark = $_POST['unpublish_review'];

    $unpublish_query = mysqli_query($con, "UPDATE sellernotes SET status=7,actionedby='$loggerid',admin_remarks='$remark',modifieddate=NOW(),modifiedby=$loggerid WHERE noteid=$noteid");
    header("Location:notes-under-review-page.php");
}

//Approve
if (isset($_POST['Approve_submit'])) {
    $noteid = $_POST['approve_noteid'];

    $Approve_query = mysqli_query($con, "UPDATE sellernotes SET status=6,publisheddate=NOW(),actionedby='$loggerid',modifieddate=NOW(),modifiedby=$loggerid WHERE noteid=$noteid");
    header("Location:notes-under-review-page.php");
}

//review
if (isset($_POST['review_submit'])) {
    $noteid = $_POST['review_noteid'];
    $Review_query = mysqli_query($con, "UPDATE sellernotes SET status=5,actionedby='$loggerid',modifieddate=NOW(),modifiedby=$loggerid WHERE noteid=$noteid");
    header("Location:notes-under-review-page.php");
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

    <!-- data table js -->
    <script src="js/datatables.min.js"></script>

    <!--bootstrap js-->
    <script src="js/bootstrap/bootstrap.min.js"></script>

</head>

<body class="sticky-header">
    <div class="above-footer">

        <!--header -->
        <?php include "header.php" ?>
        <!--header end-->

        <div class="dashboard-in-progress-notes">
            <div class="container heading-margin">
                <div class="row">
                    <div class="col-md-12 column-padding-remover">
                        <h3 class="blue-font-30 margin-b-10 margin-l">Notes Under Review</h3>
                        <h3 class="dark-font-16 margin-l">Seller</h3>
                    </div>
                    <div class="col-md-6 column-padding-remover">
                        <select id="notes-seller-picker" onchange="showData()"
                            class="form-control margin-l text-hidden under-review-res options-arrow-down input-light-color">
                            <option value="0" selected>Select Seller</option>
                            <?php
                            $name_getter = mysqli_query($con, "SELECT DISTINCT sn.sellerid,u.firstname,u.lastname 
                                                               FROM sellernotes sn 
                                                               LEFT JOIN users u 
                                                               ON u.userid=sn.sellerid
                                                               WHERE sn.status IN (4,5) AND sn.isactive=1");
                            while ($row = mysqli_fetch_assoc($name_getter)) {
                                $seller_full_name = $row['firstname'] . ' ' . $row['lastname'];
                                $selerid = $row['sellerid'];
                                echo "<option value='$selerid'>$seller_full_name</option>";
                                if (isset($_GET['id']) && !empty($_GET['id'])) {
                                    $id = $_GET['id'];
                                    if ($id == $selerid)
                                        echo "<option selected value='$selerid'>$seller_full_name</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2"></div>
                    <div id="dashboard-search-btn-2" class="col-md-4 column-padding-remover ">
                        <div class="dashboard-search-jointer">
                            <input type="text" id="search_val"
                                class="form-control margin-l dashboard-search-icon search-icon"
                                placeholder="&#xf002; Search">
                            <button onclick="showData()"
                                class="btn btn-primary margin-r blue-button-hover-white">search</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
        function showData() {
            let search = $("#search_val").val();
            let sellerid = $("#notes-seller-picker").val();

            $.ajax({
                url: "ajax/notes-under-review-ajax.php",
                method: "GET",
                data: {
                    search: search,
                    seller_name: sellerid,
                },
                success: function(data) {
                    $("#review_data").html(data);
                }
            });
        };
        $(function() {
            showData();
        })
        </script>

        <div id="review_data"></div>
    </div>

    <!--footer-->
    <?php include "footer.php"; ?>
    <!--footer end-->

    <!--Custom Script-->
    <script src="js/script.js"></script>

</body>

</html>
