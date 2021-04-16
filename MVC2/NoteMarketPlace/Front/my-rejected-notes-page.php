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
    $note_title = $_GET['title'];

    $download_query = mysqli_query($con, "SELECT filepath FROM sellernotesattachements WHERE noteid=$noteid");
    while ($row = mysqli_fetch_assoc($download_query)) {

        $note_path = $row['filepath'];
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
    $query_appender = " AND (title LIKE '%$search_result%' OR name LIKE '%$search_result%' OR admin_remarks LIKE '%$search_result%')";
}

$rejected_query = "SELECT sellernotes.title,notecategories.name,sellernotes.admin_remarks,
                   sellernotes.noteid FROM sellernotes 
                   LEFT JOIN notecategories ON notecategories.categoryid=sellernotes.category
                   WHERE sellernotes.status=7 AND sellerid=$seller_id";

$rejected_query .= $query_appender . " ORDER BY sellernotes.modifieddate DESC";

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
                                <h3 class="blue-font-24 dashboard-title">My Rejected Notes</h3>
                            </div>
                            <div class="col-md-2">
                            </div>
                            <div id="dashboard-search-btn-2" class="col-md-4 column-padding-remover">
                                <div class="dashboard-search-jointer dashboard-title">
                                    <input type="text" name="search_result"
                                        class="form-control dashboard-search-icon search-icon"
                                        placeholder="&#xf002; Search">
                                    <button class="btn btn-primary blue-button-hover-white dashboard-title-r"
                                        name="search">search</button>
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
                    <table id="myTable" class="table entire-table table-small">
                        <thead>
                            <tr class="table-heading">
                                <th>SR no.</th>
                                <th>note title</th>
                                <th>category</th>
                                <th>remarks</th>
                                <td>clone</td>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $rejected_note_result = mysqli_query($con, $rejected_query);
                            $sr_no = 1;
                            while ($row = mysqli_fetch_assoc($rejected_note_result)) {
                                $noteid = $row['noteid'];
                                $title = $row['title'];
                                $category = $row['name'];
                                $remark_admin = (!empty($remark_admin)) ? $row['admin_remarks'] : "not specified";
                            ?>
                            <tr>
                                <td><?php echo $sr_no ?></td>
                                <td><a title="click to view <?php echo $title ?>" class="deco-none"
                                        href="notes-details-page.php?id=<?php echo $noteid; ?>"><?php echo $title ?></a>
                                </td>
                                <td><?php echo $category ?></td>
                                <td><?php echo $remark_admin ?></td>
                                <td>
                                    <a href="add-notes-page.php?id=<?php echo $noteid; ?>&clone=1"
                                        title="click to view <?php echo $title ?>" class="deco-none"
                                        title="click here to clone <?php echo $title ?>">clone
                                    </a>
                                </td>
                                <td>
                                    <div class="dropdown dropleft">
                                        <a class="btn" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <img src="images/dots.png" alt="open menu">
                                        </a>
                                        <ul class="dropdown-menu shadow-drop dropdowncustom-width dropdowncustom">
                                            <li>
                                                <a
                                                    href="my-rejected-notes-page.php?noteid=<?php echo $noteid ?>&title=<?php echo $title ?>">
                                                    <h6 class="dropdown-first-option">Download Note</h6>
                                                </a>
                                            </li>
                                        </ul>
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
    </div>
    <!--footer-->
    <?php include "footer.php"; ?>
    <!--footer end-->



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