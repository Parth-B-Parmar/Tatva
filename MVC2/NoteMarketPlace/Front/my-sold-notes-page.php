<?php
include "db.php";
session_start();

$login = true;
if (isset($_SESSION['email']))
    $seller_email = $_SESSION['email'];
else
    $login = false;

//seller id getter
$seller_getter = mysqli_query($con, "SELECT userid FROM users WHERE emailid='$seller_email'");
while ($row = mysqli_fetch_assoc($seller_getter))
    $seller_id = $row['userid'];

//downloading mechanisum
if (isset($_GET['noteid'])) {
    $noteid = $_GET['noteid'];
    $downloader = $_GET['downloader'];

    $download_query = mysqli_query($con, "SELECT notetitle,attactmentpath FROM downloads WHERE noteid=$noteid AND seller=$seller_id AND downloader=$downloader");
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
        }
    }
}

$query_appender = "";

//search button
if (isset($_POST['search'])) {
    $search_result = $_POST['search_result'];
    $query_appender = " AND (notetitle like '%$search_result%' OR notecategory LIKE '%$search_result%' 
                        OR emailid LIKE '%$search_result%' OR ispaid LIKE '%$search_result%' OR purchasedprice LIKE '%$search_result%' 
                        OR downloads.modifieddate LIKE '%$search_result%')";
}

$query_sold_note = "SELECT DISTINCT downloads.noteid,downloads.notetitle,downloads.notecategory,users.emailid,downloads.ispaid,
                    downloads.purchasedprice,downloads.modifieddate,downloads.downloader FROM downloads 
                    LEFT JOIN users ON downloads.downloader=users.userid 
                    WHERE seller=$seller_id AND sellerhasalloweddownload=1";

$query_sold_note .= $query_appender . " ORDER BY downloads.createddate DESC";

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

    <!-- Datatable css -->
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
                                <h3 class="blue-font-24 dashboard-title">My Sold Notes</h3>
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
        <div class="container">
            <div class="row">
                <div class="col-md-12 column-padding-remover">
                    <table id="myTable" class="table entire-table-for-buyer-req table-small column-padding-remover">
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
                            $sr_no = 1;
                            $sold_note_result = mysqli_query($con, $query_sold_note);
                            while ($row = mysqli_fetch_array($sold_note_result)) {
                                $noteid = $row['noteid'];
                                $downloader = $row['downloader'];
                                $title = $row['notetitle'];
                                $category = $row['notecategory'];
                                $buyer_email = $row['emailid'];
                                $sell_type = $row['ispaid'];
                                $sell_type == 1 ? $sell_type = "Paid" : $sell_type = "Free";
                                $price = $row['purchasedprice'];
                                $time = $row['modifieddate'];
                            ?>
                                <tr>
                                    <td><?php echo $sr_no ?></td>
                                    <td><a class="deco-none" title="click to view <?php echo $title ?>" href="notes-details-page.php?id=<?php echo $noteid; ?>"><?php echo $title ?></a>
                                    </td>
                                    <td><?php echo $category ?></td>
                                    <td><?php echo $buyer_email ?></td>
                                    <td><?php echo $sell_type ?></td>
                                    <td><?php echo "&#36;" . $price ?></td>
                                    <td><?php echo date("d-m-y, H:i", strtotime($time)) ?></td>
                                    <td>
                                        <div class="table-pic-combiner">
                                            <a href="notes-details-page.php?id=<?php echo $noteid; ?>"> <img src="images/eye.png" class="table-first-img" title="Click to view <?php echo $title ?>" alt="View"></a>
                                            <div class="dropdown dropleft">
                                                <a class="btn" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <img src="images/dots.png" alt="open menu">
                                                </a>
                                                <ul class="dropdown-menu shadow-drop dropdowncustom-width dropdowncustom">
                                                    <li><a href="my-sold-notes-page.php?noteid=<?php echo $noteid; ?>&downloader=<?php echo $downloader; ?>">
                                                            <h6 class="dropdown-first-option">Download Note</h6>
                                                        </a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                                $sr_no++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Table end-->

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

    <!--bootstrap js-->
    <script src="js/bootstrap/bootstrap.min.js"></script>

    <!--Custom Script-->
    <script src="js/script.js"></script>

</body>

</html>