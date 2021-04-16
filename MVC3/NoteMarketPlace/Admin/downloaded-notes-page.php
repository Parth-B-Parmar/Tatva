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

        <div class="dashboard-in-progress-notes">
            <div class="container heading-margin">
                <div class="row">
                    <div class="col-md-12 column-padding-remover">
                        <h3 class="blue-font-30 margin-b-10 margin-l">Downloaded Notes</h3>

                    </div>
                    <div class="col-lg-6 margin-top-10 column-padding-remover">
                        <div id="download-merge-options">
                            <div class="download-row-flexer">
                                <h3 class="dark-font-16 margin-l">Note</h3>

                                <!-- to get all the note details -->
                                <select id="notes-seller-picker" onchange="showData()"
                                    class="form-control text-hidden options-arrow-down  input-light-color">
                                    <option selected value="0">Select Notes</option>
                                    <?php
                                    $note_title_getter = mysqli_query($con, "SELECT title,noteid FROM sellernotes WHERE status=6 AND isactive=1 ORDER BY title");
                                    while ($row = mysqli_fetch_assoc($note_title_getter)) {
                                        $noteid = $row['noteid'];
                                        $title = $row['title'];
                                        echo "<option value='$noteid'>$title</option>";
                                        if (isset($_GET['noteid']) && !empty($_GET['noteid'])) {
                                            $id = $_GET['noteid'];
                                            if ($id == $noteid)
                                                echo "<option selected value='$noteid'>$title</option>";
                                        }
                                    }
                                    ?>
                                </select>

                            </div>
                            <div class="download-row-flexer">
                                <h3 class="dark-font-16">Seller</h3>

                                <!-- to get all the seller name -->
                                <select id="notes-seller-picker-1" onchange="showData()"
                                    class="form-control text-hidden options-arrow-down input-light-color">
                                    <option selected value="0">Select Seller</option>
                                    <?php
                                    $seller_name_getter = mysqli_query($con, "SELECT DISTINCT u.userid,u.firstname,u.lastname FROM users u
                                                                              JOIN downloads ON downloads.seller=u.userid WHERE isactive=1");

                                    while ($row = mysqli_fetch_assoc($seller_name_getter)) {
                                        $name = $row['firstname'] . ' ' . $row['lastname'];
                                        $userid = $row['userid'];
                                        echo "<option value='$userid'>$name</option>";
                                    }
                                    ?>
                                </select>

                            </div>
                            <div class="download-row-flexer">
                                <h3 class="dark-font-16">Buyer</h3>

                                <!-- to get all the buyers -->
                                <select id="notes-seller-picker-2" onchange="showData()"
                                    class="form-control text-hidden options-arrow-down input-light-color">
                                    <option selected value="0">Select Buyer</option>
                                    <?php
                                    $seller_name_getter = mysqli_query($con, "SELECT DISTINCT u.userid,u.firstname,u.lastname FROM users u
                                                                              JOIN downloads ON downloads.downloader=u.userid WHERE isactive=1");

                                    while ($row = mysqli_fetch_assoc($seller_name_getter)) {

                                        $name = $row['firstname'] . ' ' . $row['lastname'];
                                        $userid = $row['userid'];
                                        echo "<option value='$userid'>$name</option>";
                                        if (isset($_GET['id']) && !empty($_GET['id'])) {
                                            $id = $_GET['id'];
                                            if ($id == $userid)
                                                echo "<option selected value='$userid'>$name</option>";
                                        }
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                    <div id="dashboard-search-btn-2"
                        class="col-lg-4 column-padding-remover downloaded-notes-fixer margin-top-40">
                        <div class="dashboard-search-jointer">
                            <input id="downloaded-notes-search-controller" type="text"
                                class="form-control dashboard-search-icon column-padding-remover margin-l search-icon"
                                placeholder="&#xf002; Search">
                            <button onclick="showData()"
                                class="btn btn-primary blue-button-hover-white margin-r">search</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
        function showData() {

            let note_id = $("#notes-seller-picker").val();
            let seller_id = $("#notes-seller-picker-1").val();
            let buyer_id = $("#notes-seller-picker-2").val();
            let search_data = $("#downloaded-notes-search-controller").val();

            $.ajax({
                url: "ajax/downloaded-notes-ajax.php",
                method: "GET",
                data: {
                    search: search_data,
                    noteid: note_id,
                    sellerid: seller_id,
                    buyerid: buyer_id
                },
                success: function(data) {
                    $("#downloaded_note_data").html(data);
                }
            });
        }
        $(function() {
            showData();
        })
        </script>

        <div id="downloaded_note_data"></div>
    </div>

    <!--footer-->
    <?php include "footer.php"; ?>
    <!--footer end-->

    <!--Custom Script-->
    <script src="js/script.js"></script>

</body>

</html>