<?php
include "../db.php";

$query_appender = "";

//to filter data with search
$search = (isset($_GET['search']) && $_GET['search'] != "" && !empty($_GET['search'])) ? $_GET['search'] : "";
$query_appender = ($search != "" && $search != 0 && !empty($search))
    ? " AND (d.notetitle LIKE '%$search%' OR d.notecategory LIKE '%$search%' OR u.firstname LIKE '%$search%' OR u.lastname LIKE '%$search%' OR us.firstname LIKE '%$search%' OR us.lastname LIKE '%$search%' OR ref.value LIKE '%$search%' OR d.purchasedprice LIKE '%$search%') OR d.attactmentdownloadeddate LIKE '%$search%'" : "";

//search to get filter notes
$noteid = (isset($_GET['noteid']) && $_GET['noteid'] != "" && !empty($_GET['noteid'])) ? $_GET['noteid'] : "";
$query_appender .= ($noteid != "" && $noteid != 0 && !empty($noteid)) ? " AND d.noteid=$noteid" : "";

//search to get filter sellers
$sellerid = (isset($_GET['sellerid']) && $_GET['sellerid'] != "" && !empty($_GET['sellerid'])) ? $_GET['sellerid'] : "";
$query_appender .= ($sellerid != "" && $sellerid != 0 && !empty($sellerid)) ? " AND d.seller=$sellerid" : "";

//search to get filter buyers
$buyerid = (isset($_GET['buyerid']) && $_GET['buyerid'] != "" && !empty($_GET['buyerid'])) ? $_GET['buyerid'] : "";
$query_appender .= ($buyerid != "" && $buyerid != 0 && !empty($buyerid)) ? " AND d.downloader=$buyerid" : "";

//main query
$downloaded_query = "SELECT DISTINCT d.noteid,d.notetitle,d.notecategory,u.firstname AS buyerfname,u.lastname AS buyerlname
                    ,u.userid AS buyer_id,us.firstname AS sellerfname,us.lastname AS sellerlname,us.userid AS seller_id,ref.value,d.purchasedprice,d.attactmentdownloadeddate 
                    FROM downloads d
                    LEFT JOIN users us
                    ON us.userid=d.seller
                    LEFT JOIN users u
                    ON u.userid=d.downloader
                    LEFT JOIN referencedata ref
                    ON ref.refdataid=d.ispaid
                    WHERE sellerhasalloweddownload=1";

$downloaded_query .= $query_appender . " ORDER BY d.attactmentdownloadeddate DESC ";
?>

<div id="dashboard-table-1">
    <div class="container">
        <div class="row">
            <div class="col-md-12 column-padding-remover">
                <table id="myTable" class="table entire-table text-center table-small download-t">
                    <thead>
                        <tr class="table-heading">
                            <th>sr no.</th>
                            <th>note title</th>
                            <th>category</th>
                            <th>buyer</th>
                            <th>seller</th>
                            <th>sell type</th>
                            <th>price</th>
                            <th>downloaded date/time</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $downloaded_query_result = mysqli_query($con, $downloaded_query);
                        $sr_no = 0;

                        while ($row = mysqli_fetch_assoc($downloaded_query_result)) {

                            $noteid = $row['noteid'];
                            $title = $row['notetitle'];
                            $category = $row['notecategory'];
                            $buyer = $row['buyerfname'] . ' ' . $row['buyerlname'];
                            $buyer_id = $row['buyer_id'];
                            $seller = $row['sellerfname'] . ' ' . $row['sellerlname'];
                            $seller_id = $row['seller_id'];
                            $sell_type = $row['value'];
                            $price = $row['purchasedprice'];
                            $date = $row['attactmentdownloadeddate'];
                            $sr_no++;

                        ?>

                            <tr>
                                <td class="sr-setter"><?php echo $sr_no ?></td>
                                <td>
                                    <a href="notes-details-page.php?id=<?php echo $noteid ?>" title="click to open <?php echo $title ?>">
                                        <?php echo $title ?>
                                    </a>
                                </td>
                                <td><?php echo $category ?></td>
                                <td class="table-name-setter"><?php echo $buyer ?>
                                    <a href="member-details-page.php?id=<?php echo $buyer_id ?>" title="click to view more about <?php echo $buyer ?>"><img src="images/eye.png" alt="view">
                                    </a>
                                </td>
                                <td class="table-name-setter"><?php echo $seller ?>
                                    <a href="member-details-page.php?id=<?php echo $seller_id ?>" title="click to view more about <?php echo $seller ?>"><img src="images/eye.png" alt="view">
                                    </a>
                                </td>
                                <td><?php echo $sell_type ?></td>
                                <td>&#36;<?php echo $price ?></td>
                                <td class="table-date-setter"><?php echo date("d-m-y, H:i", strtotime($date)) ?></td>
                                <td>
                                    <div class="dropdown dropleft">
                                        <a class="btn" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <img src="images/dots.png" alt="open menu">
                                        </a>
                                        <ul class="dropdown-menu shadow-drop dropdowncustom-width dropdowncustom">

                                            <!-- to download the note -->
                                            <li>
                                                <a href="downloaded-notes-page.php?noteid=<?php echo $noteid ?>&title=<?php echo $title ?>">
                                                    <h6 class="dropdown-first-option">Download Notes</h6>
                                                </a>
                                            </li>

                                            <!-- open notes details -->
                                            <li>
                                                <a href="notes-details-page.php?id=<?php echo $noteid ?>">
                                                    <h6 class="dropdown-first-option">View More Details</h6>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    //data table
    $(document).ready(function() {
        $('#myTable').DataTable({
            "scrollX": true,
            "pageLength": 5
        });
    });

    //table resizer for less entries
    $('#myTable').on('show.bs.dropdown', function() {
        $('#myTable').css("min-height", "135px");
    });

    $('#myTable').on('hide.bs.dropdown', function() {
        $('#myTable').css("min-height", "0");
    });
</script>