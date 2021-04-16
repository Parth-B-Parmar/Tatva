<?php
include "db.php";
session_start();

$login = true;
if (isset($_SESSION['email']))
    $email = $_SESSION['email'];
else
    $login = false;

// get the seller id
$seller_id_getter = mysqli_query($con, "SELECT userid FROM users WHERE emailid='$email'");
while ($row = mysqli_fetch_assoc($seller_id_getter))
    $userid = $row['userid'];

if (isset($_POST['search_1'])) {

    $search_result = $_POST['search_result'];

    $query = "SELECT sellernotes.noteid,sellernotes.modifieddate,sellernotes.title,notecategories.name,referencedata.value 
              FROM sellernotes 
              LEFT JOIN notecategories 
              ON sellernotes.category=notecategories.categoryid 
              LEFT JOIN referencedata 
              ON sellernotes.status=referencedata.refdataid 
              WHERE sellerid=$userid AND sellernotes.isactive=1 AND referencedata.refdataid IN (3,4,5) 
              AND (sellernotes.title LIKE '%$search_result%' OR sellernotes.modifieddate LIKE '%$search_result%' 
              OR notecategories.name LIKE '%$search_result%'
              OR referencedata.value LIKE '%$search_result%')
              ORDER BY sellernotes.modifieddate DESC";

    $result = mysqli_query($con, $query);
} else {

    $query = "SELECT sellernotes.noteid,sellernotes.modifieddate,sellernotes.title,notecategories.name,referencedata.value 
              FROM sellernotes 
              LEFT JOIN notecategories 
              ON sellernotes.category=notecategories.categoryid 
              LEFT JOIN referencedata 
              ON sellernotes.status=referencedata.refdataid 
              WHERE sellerid=$userid AND referencedata.refdataid IN (3,4,5) 
              AND sellernotes.isactive=1 ORDER BY sellernotes.modifieddate DESC";

    $result = mysqli_query($con, $query);
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

    <!--Custom css-->
    <link rel="stylesheet" href="css/style.css">

    <!-- data table css -->
    <link rel="stylesheet" href="css/datatables.min.css">

    <!--Responsive css-->
    <link rel="stylesheet" href="css/responsive.css">

</head>

<body class="sticky-header">
    <!--header -->
    <?php include "header.php" ?>
    <!--header end-->

    <div id="search-all-font">
        <div id="dashboard-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-6">
                        <h3 class="blue-font-34 dashboard-title">Dashboard</h3>
                    </div>
                    <div class="col-md-6 col-6 column-padding-remover text-right ">
                        <a href="add-notes-page.php"><button
                                class="btn btn-primary dashboard-title-r blue-button-hover-white">Add note</button></a>
                    </div>
                </div>
            </div>
        </div>

        <div id="dashboard-statistics">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-12 col-12 dashboard-left-res">
                        <div class="row">
                            <div class="col-md-3 col-sm-3 text-center dashboard-my-earnings">
                                <div class="dashboard-left-statistics-inner">
                                    <img src="images/my-earning.png" title="Detailed View of Earning" alt="My Earnings"
                                        class="img-fluid">
                                    <h4 class="blue-font-30 text-center">My Earning</h4>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 dashboard-sold-note text-center">
                                <div class="dashboard-left-statistics-inner">
                                    <div class="dashboard-sold-note-inner">
                                        <?php
                                        $note_sold = mysqli_query($con, "SELECT DISTINCT noteid FROM downloads WHERE seller=$userid AND sellerhasalloweddownload=1");
                                        $note_sold_count = mysqli_num_rows($note_sold);
                                        ?>
                                        <h3 class="blue-font-30"><?php echo $note_sold_count ?></h3>
                                        <h3 class="dark-font-18">Number of Notes Sold</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-5 text-center dashboard-earned-money">
                                <?php

                                $note_id_getter = mysqli_query($con, "SELECT noteid,purchasedprice FROM downloads WHERE ispaid=1 AND sellerhasalloweddownload=1 AND seller=$userid");
                                $final_price = 0;
                                while ($row = mysqli_fetch_assoc($note_id_getter)) {
                                    $all_note_id = $row['noteid'];
                                    $price_all_note = $row['purchasedprice'];

                                    //select notes with first attachment
                                    $select_attach = mysqli_query($con, "SELECT attactmentpath FROM downloads WHERE noteid=$all_note_id");
                                    $count_attach = mysqli_num_rows($select_attach);
                                    $final_price = $final_price + ($price_all_note / $count_attach);
                                    $final_price = round($final_price, 2);
                                }
                                ?>

                                <div id="dashboard-earned-money-inner">
                                    <h3 class="blue-font-30">&#36;<?php echo $final_price ?></h3>
                                    <h3 class="dark-font-18">Money Earned</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 col-12 column-padding-remover text-center">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 dashboard-right-statistics">
                                <?php
                                $mydownload = mysqli_query($con, "SELECT DISTINCT noteid FROM downloads WHERE downloader=$userid AND sellerhasalloweddownload=1");
                                $mydownload_count = mysqli_num_rows($mydownload);
                                ?>
                                <div class="dashboard-right-statistics-inner">
                                    <h3 class="blue-font-30"><?php echo $mydownload_count ?></h3>
                                    <h3 class="dark-font-18">My Downloads</h3>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 dashboard-right-statistics">
                                <div class="dashboard-right-statistics-inner">
                                    <?php
                                    $rejected_note = mysqli_query($con, "SELECT noteid FROM sellernotes WHERE status=7 AND sellerid=$userid");
                                    $rejected_note_count = mysqli_num_rows($rejected_note);
                                    ?>
                                    <h3 class="blue-font-30"><?php echo $rejected_note_count ?></h3>
                                    <h3 class="dark-font-18">My Rejected Notes</h3>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 dashboard-right-statistics">
                                <?php
                                $buyer_req = mysqli_query($con, "SELECT DISTINCT noteid FROM downloads WHERE ispaid=1 AND sellerhasalloweddownload=0 AND seller=$userid");
                                $buyer_req_count = mysqli_num_rows($buyer_req);
                                ?>
                                <div class="dashboard-right-statistics-inner">
                                    <h3 class="blue-font-30"><?php echo $buyer_req_count ?></h3>
                                    <h3 class="dark-font-18">Buyer Requests</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-in-progress-notes">
            <div class="container">
                <form action="dashboard-page.php" method="post">
                    <div class="row">
                        <div class="col-md-6 col-12 column-padding-remover">
                            <h3 class="blue-font-24 dashboard-title">In Progress Notes</h3>
                        </div>
                        <div class="col-md-2 col-0">
                        </div>
                        <div id="dashboard-search-btn-2" class="col-md-4 column-padding-remover">
                            <div class="dashboard-search-jointer dashboard-title">
                                <input type="text" name="search_result"
                                    class="form-control dashboard-search-icon search-icon"
                                    placeholder="&#xf002; Search">
                                <button name="search_1" type="submit"
                                    class="btn btn-primary blue-button-hover-white dashboard-title-r">search
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="dashboard-table-1">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 column-padding-remover">
                        <table id="myTable1" class="table entire-table table-small">
                            <thead>
                                <tr class="table-heading">
                                    <th scope="col"> added date </th>
                                    <th scope="col">title </th>
                                    <th scope="col">category</th>
                                    <th scope="col">status</th>
                                    <th scope="col">actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $date =  date("d-m-y, H:i", strtotime($row['modifieddate']));
                                    $title = $row['title'];
                                    $category_name = $row['name'];
                                    $refe_data = $row['value'];
                                    $noteid = $row['noteid'];
                                    echo "<tr>
                                        <td>$date</td>
                                        <td><a title='click to view $title' href='notes-details-page.php?id=$noteid'>$title</a></td>
                                        <td>$category_name</td>
                                        <td>$refe_data</td>";
                                    if ($refe_data == 'Draft') {
                                        echo " <td>
                                            <a href='delete_draft.php?id=$noteid'>
                                            <img src='images/delete.png' title='Click to delete $title' alt='Delete'></a>
                                            <a href='add-notes-page.php?id=$noteid'>
                                            <img src='images/edit.png' title='Click to Edit $title' alt='edit'></a>
                                        </td>
                                    </tr>";
                                    } else {
                                        echo " <td>
                                       <a href='notes-details-page.php?id=$noteid'>
                                            <img src='images/eye.png' title='Click to View $title' alt='View'>
                                            </a>
                                        </td>
                                    </tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-in-progress-notes">
            <div class="container">
                <form action="dashboard-page.php" method="post">
                    <div class="row">
                        <div class="col-md-6 column-padding-remover">
                            <h3 class="blue-font-24 dashboard-title dashboard-title">Published Notes</h3>
                        </div>
                        <div class="col-md-2">
                        </div>
                        <div id="dashboard-search-btn" class="col-md-4 column-padding-remover">
                            <div class="dashboard-search-jointer dashboard-title">
                                <input type="text" name="search_result2"
                                    class="form-control dashboard-search-icon search-icon"
                                    placeholder="&#xf002; Search">
                                <button type="submit" name="search_2"
                                    class="btn btn-primary blue-button-hover-white dashboard-title-r">search</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <?php
        if (isset($_POST['search_2'])) {

            $search_result2 = $_POST['search_result2'];

            $query2 = "SELECT sellernotes.noteid,sellernotes.publisheddate,sellernotes.title,notecategories.name,
                       referencedata.value,sellernotes.selling_price 
                       FROM sellernotes 
                       LEFT JOIN notecategories 
                       ON sellernotes.category=notecategories.categoryid 
                       LEFT JOIN referencedata 
                       ON sellernotes.ispaid=referencedata.refdataid 
                       WHERE sellerid=$userid AND sellernotes.status=6 
                       AND (sellernotes.title LIKE '%$search_result2%' OR sellernotes.publisheddate LIKE '%$search_result2%'
                       OR notecategories.name LIKE '%$search_result2%' OR referencedata.value LIKE '%$search_result2%'
                       OR sellernotes.selling_price LIKE '%$search_result2%')
                       ORDER BY sellernotes.modifieddate DESC";

            $result2 = mysqli_query($con, $query2);
        } else {
            $query2 = "SELECT sellernotes.noteid,sellernotes.publisheddate,sellernotes.title,notecategories.name,
                       referencedata.value,sellernotes.selling_price 
                       FROM sellernotes 
                       LEFT JOIN notecategories
                       ON sellernotes.category=notecategories.categoryid 
                       LEFT JOIN referencedata 
                       ON sellernotes.ispaid=referencedata.refdataid 
                       WHERE sellerid=$userid 
                       AND sellernotes.status=6 
                       ORDER BY sellernotes.modifieddate DESC";

            $result2 = mysqli_query($con, $query2);
        }

        ?>
        <div id="dashboard-table-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 column-padding-remover">
                        <table id="myTable2" class="table entire-table table-small">
                            <thead>
                                <tr class="table-heading">
                                    <th scope="col">added date </th>
                                    <th scope="col">title</th>
                                    <th scope="col">category</th>
                                    <th scope="col">sell type </th>
                                    <th scope="col">price</th>
                                    <th scope="col">actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($result2)) {
                                    $noteid = $row['noteid'];
                                    $date2 = date("d-m-y, H:i", strtotime($row['publisheddate']));
                                    $title2 = $row['title'];
                                    $category_name2 = $row['name'];
                                    $refe_data2 = $row['value'];
                                    $sell_price = $row['selling_price'];
                                    echo "<tr>
                                        <td>$date2</td>
                                        <td><a title='click to view $title2' href='notes-details-page.php?id=$noteid'>$title2</a></td>
                                        <td>$category_name2</td>
                                        <td>$refe_data2</td> 
                                        <td>$sell_price</td>
                                        <td> <a href='notes-details-page.php?id=$noteid'><img src='images/eye.png' title='Click to View $title2' alt='View'></a> </td>
                                         </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
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

    <!--bootstrap js-->
    <script src="js/bootstrap/bootstrap.min.js"></script>

    <!-- Data table js-->
    <script src="js/datatables.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#myTable1').DataTable({
            "scrollX": true,
            "pageLength": 5,
            "order": [
                [0, "desc"]
            ]
        });
    });
    </script>

    <script>
    $(document).ready(function() {
        $('#myTable2').DataTable({
            "scrollX": true,
            "pageLength": 5,
            "order": [
                [0, "desc"]
            ]
        });
    });
    </script>

    <!--Custom Script-->
    <script src="js/script.js"></script>

</body>

</html>