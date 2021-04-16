<?php
include "db.php";
session_start();

$login = true;
if (isset($_SESSION['email']))
    $email = $_SESSION['email'];
else
    $login = false;

//seller getter
$seller_id_getter = mysqli_query($con, "SELECT userid,firstname,lastname FROM users WHERE emailid='$email'");
while ($row = mysqli_fetch_assoc($seller_id_getter)) {
    $sellerid = $row['userid'];
    $full_name_seller = $row['firstname'] . " " . $row['lastname'];
}

//this will enable alloweddownload
if (isset($_GET['noteid'])) {
    $noteid_allow = $_GET['noteid'];
    $downloader_allow = $_GET['downloader'];
    $allow_download_enable = mysqli_query($con, "UPDATE downloads SET sellerhasalloweddownload=1,attactmentdownloadeddate=NOW() WHERE noteid=$noteid_allow AND downloader=$downloader_allow");

    //buyer nane getter
    $buyer_name_getter = mysqli_query($con, "SELECT firstname,lastname,emailid FROM users WHERE userid=$downloader_allow");
    while ($row = mysqli_fetch_assoc($buyer_name_getter)) {
        $full_name_buyer = $row['firstname'] . " " . $row['lastname'];
        $email_buyer = $row['emailid'];
    }
    
    $to = $email_buyer;
    $subject = " '$full_name_seller' .  Allows you to download a note";
    $body = "Hello <b>$full_name_buyer</b>,<br><br> ";
    $body.= "Hello <b>$full_name_buyer</b>,<br>We would like to inform you that,<b>$full_name_seller</b> Allows you to download a note.Please login and see My Download tabs to download particular note. <br><br>";
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
    header("Location:buyer-request-page.php");
}

$query_appender = "";

//search button
if (isset($_POST['search'])) {
    $search_result = $_POST['search_result'];
    $query_appender = " AND (notetitle like '%$search_result%' OR notecategory like '%$search_result%' OR emailid like '%$search_result%' 
                        OR phone_no like '%$search_result%' OR purchasedprice like '%$search_result%' OR ispaid like '%$search_result%' 
                        OR downloads.createddate like '%$search_result%' OR countrycode like '%$search_result%')";
}

$query = "SELECT DISTINCT downloads.noteid,downloads.downloader,downloads.notetitle,downloads.notecategory,users.emailid,
          userprofile.phone_no,downloads.ispaid,downloads.purchasedprice,downloads.createddate,countries.countrycode FROM downloads 
          LEFT JOIN users ON downloads.downloader=users.userid 
          LEFT JOIN userprofile ON userprofile.userid=downloads.downloader
          LEFT JOIN countries ON userprofile.country=countries.countryid 
          WHERE seller=$sellerid AND ispaid=1 AND sellerhasalloweddownload=0";

$query .= $query_appender . " ORDER BY downloads.createddate DESC";


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
    <link rel="stylesheet" type="text/css" href="css/datatables.min.css" />

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
                    <form action="buyer-request-page.php" method="post">
                        <div class="row">
                            <div class="col-md-6 column-padding-remover">
                                <h3 class="blue-font-24 dashboard-title">Buyer Reqests</h3>
                            </div>
                            <div class="col-md-2">
                            </div>
                            <div id="dashboard-search-btn-2" class="col-md-4 column-padding-remover">
                                <div class="dashboard-search-jointer dashboard-title">
                                    <input type="search" name="search_result" placeholder="&#xf002; Search"
                                        class="form-control dashboard-search-icon search-icon">
                                    <button type="submit" name="search"
                                        class="btn btn-primary blue-button-hover-white dashboard-title-r">search</button>
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
                    <table id="myTable" class="table entire-table-for-buyer-req table-medium">
                        <thead>
                            <tr class="table-heading">
                                <th>SR no.</th>
                                <th>note title</th>
                                <th>category</th>
                                <th>buyer</th>
                                <th>phone no.</th>
                                <th>sell type</th>
                                <th>price</th>
                                <th>download time</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = mysqli_query($con, $query);
                            $sr_no = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $noteid = $row['noteid'];
                                $downloader = $row['downloader'];
                                $title = $row['notetitle'];
                                $category = $row['notecategory'];
                                $buyer_email = $row['emailid'];
                                $phone_code = "+" . $row['countrycode'];
                                $phone_no = $row['phone_no'];
                                if (empty($phone_no)) {
                                    $phone_no = "not enrolled yet";
                                    $phone_code = '';
                                }
                                $type = $row['ispaid'];
                                $price = $row['purchasedprice'];
                                $time = $row['createddate'];
                                $time = date("d-m-y, H:i", strtotime($time));
                                if ($type == 1)
                                    $type = 'Paid';
                                else
                                    $type = 'Free';
                                echo " 
                                    <tr>
                                        <td>$sr_no</td>
                                        <td><a title='click to view $title' href='notes-details-page.php?id=$noteid'>$title</a></td>
                                        <td>$category</td>
                                        <td>$buyer_email</td>
                                        <td>$phone_code $phone_no</td>
                                        <td>$type</td>
                                        <td>&#36;$price</td>
                                        <td>$time</td>
                                        <td>
                                            <div class='table-pic-combiner'>
                                                <a href='notes-details-page.php?id=$noteid'><img src='images/eye.png' title='click to view $title' class='table-first-img' alt='View'></a>
                                                <div class='dropdown dropleft'>
                                                    <a class='btn' href='#' role='button' id='dropdownMenuLink'
                                                        data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                        <img src='images/dots.png' alt='open menu'></a>
                                                    <ul class='dropdown-menu shadow-drop dropdowncustom-width dropdowncustom'>
                                                        <li><a href='buyer-request-page.php?noteid=$noteid&downloader=$downloader'>
                                                                <h6 class='dropdown-first-option'>Allow Download</h6></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>";
                                $sr_no++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Table end-->

        <!--footer-->
        <?php include "footer.php" ?>
        <!--footer end-->
    </div>


    <!--popper js-->
    <script src="js/popper/popper.min.js"></script>

    <!--jquery js-->
    <script src="js/jquery/jquery.min.js"></script>

    <!--bootstrap js-->
    <script src="js/bootstrap/bootstrap.min.js"></script>

    <script type="text/javascript" src="js/datatables.min.js"></script>

    <!--Custom Script-->
    <script src="js/script.js"></script>
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            "scrollX": true,
            "pageLength": 8
        });
    });
    </script>

</body>

</html>