<?php
include "../db.php";

$query_appender = " ";

//if search button invoked
$search_data = (isset($_GET['search']) && !empty($_GET['search']) && $_GET['search'] != "") ? $_GET['search'] : "";

$query_appender = ($search_data != "" && !empty($search_data))
    ? " AND (sn.title LIKE '%$search_data%' OR nc.name LIKE '%$search_data%' OR ref.value LIKE '%$search_data%' OR sn.selling_price LIKE '%$search_data%' OR us.firstname LIKE '%$search_data%' OR us.lastname LIKE '%$search_data%'  OR sn.publisheddate LIKE '%$search_data%')" : "";

//search by seller
$seller_id = (isset($_GET['sellerid']) && $_GET['sellerid'] != "" && !empty($_GET['sellerid'])) ? $_GET['sellerid'] : "";

$query_appender .= ($seller_id != "" && $seller_id != 0 && !empty($seller_id)) ? " AND sn.sellerid=$seller_id" : "";

//main query
$publish_note = "SELECT DISTINCT sn.noteid,sn.title,nc.name,ref.value,sn.selling_price,u.userid AS sellerid,u.firstname AS sellerfname,u.lastname AS sellerlname,
                sn.publisheddate,us.firstname AS approverfname,us.lastname AS approverlname
                 FROM sellernotes sn
                 LEFT JOIN notecategories nc
                 ON sn.category=nc.categoryid
                 LEFT JOIN referencedata ref
                 ON ref.refdataid=sn.ispaid
                 LEFT JOIN users u
                 ON u.userid=sn.sellerid
                 LEFT JOIN users us
                 ON us.userid=sn.actionedby
                 WHERE sn.isactive=1 AND sn.status=6";

$publish_note .= $query_appender . " ORDER BY sn.publisheddate";

?>
<div id="dashboard-table-1">
    <div class="container">
        <div class="row">
            <div class="col-md-12 column-padding-remover">
                <table id="myTable" class="table entire-table text-center table-medium published-t">
                    <thead>
                        <tr class="table-heading">
                            <th>sr no.</th>
                            <th>note title</th>
                            <th>category</th>
                            <th>sell type</th>
                            <th>price</th>
                            <th>seller</th>
                            <th>published date</th>
                            <th>approved by</th>
                            <th>number of downloads</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php

                        $publish_note_result = mysqli_query($con, $publish_note);
                        $sr_no = 0;
                        while ($row = mysqli_fetch_assoc($publish_note_result)) {

                            //variables to store the data
                            $sr_no++;
                            $noteid = $row['noteid'];
                            $title = $row['title'];
                            $category = $row['name'];
                            $sell_type = $row['value'];
                            $price = $row['selling_price'];
                            $seller = $row['sellerfname'] . ' ' . $row['sellerlname'];
                            $sellerid = $row['sellerid'];
                            $approver_name = $row['approverfname'] . ' ' . $row['approverlname'];
                            $date = $row['publisheddate'];

                            //total download getter
                            $total_downlaod = mysqli_num_rows(mysqli_query($con, "SELECT DISTINCT noteid,downloader FROM downloads WHERE noteid=$noteid"));

                        ?>
                            <tr>
                                <td class="sr-setter"><?php echo $sr_no ?></td>
                                <td>
                                    <a href="notes-details-page.php?id=<?php echo $noteid ?>" title="click to open <?php echo $title ?>">
                                        <?php echo $title ?>
                                    </a>
                                </td>
                                <td><?php echo $category ?></td>
                                <td><?php echo $sell_type ?></td>
                                <td>&#36;<?php echo $price ?></td>
                                <td class="table-name-setter"><?php echo $seller ?>
                                    <a href="member-details-page.php?id=<?php echo $sellerid ?>" title="click to view more about <?php echo $seller ?>"><img src="images/eye.png" alt="view">
                                    </a>
                                </td>
                                <td class="table-date-setter"><?php echo date("d-m-y, H:i", strtotime($date)) ?></td>
                                <td class="table-name-setter"><?php echo $approver_name ?> </td>
                                <td>
                                    <a href="downloaded-notes-page.php?noteid=<?php echo $noteid ?>" title="click to downloader of <?php echo $title ?>"><?php echo $total_downlaod ?>
                                    </a>
                                </td>
                                <td>
                                    <div class="dropdown dropleft">
                                        <a class="btn" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <img src="images/dots.png" alt="open menu">
                                        </a>
                                        <ul class="dropdown-menu shadow-drop dropdowncustom-width dropdowncustom">
                                            <li><a href="published-notes-page.php?noteid=<?php echo $noteid ?>&title=<?php echo $title ?>">
                                                    <h6 class="dropdown-first-option">Download Notes</h6>
                                                </a></li>
                                            <li><a href="notes-details-page.php?id=<?php echo $noteid ?>">
                                                    <h6 class="dropdown-first-option">View More Details</h6>
                                                </a></li>
                                            <li><a id="unpubhlisher" data-title="<?php echo $title ?>" data-toggle="modal" data-id="<?php echo $noteid ?>" data-target="#unpubhlisher-popup">
                                                    <h4 class="dropdown-first-option">Unpublish</h4>
                                                </a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php  } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Unpublish Pop up -->
<div class="review-box">
    <div style="margin-top: 120px;" id="unpubhlisher-popup" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close text-right popup-close-btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body">
                    <form action="" method="POST">
                        <h4 id="title_for_unpublish" class="title_for_unpublish blue-font-26"></h4>
                        <div class="form-group">
                            <label id="review-label2" class="review-label">Remarks *</label>
                            <textarea id="review-comment-box2" name="unpublish_review" placeholder="Remarks..." class="review-comment form-control" required></textarea>
                        </div>
                        <input id="note_id_unpublish" name="unpublish_noteid" type="hidden">
                        <button id="review-popup-btn2" type="submit" name="unpublish_submit" class="btn red-button-hover-white review-btn">Unpublish</button>
                        <button class="btn btn-primary blue-button-hover-white btn-upper" data-dismiss="modal" id="cancel-btn">cancel</button>
                    </form>
                </div>
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

    // data getter via data-id
    $(document).on("click", "#unpubhlisher", function() {
        $("#title_for_unpublish").html($(this).data("title"));
        $("#note_id_unpublish").val($(this).data("id"));
    })

    //table resizer for less entries
    $('#myTable').on('show.bs.dropdown', function() {
        $('#myTable').css("min-height", "135px");
    });

    $('#myTable').on('hide.bs.dropdown', function() {
        $('#myTable').css("min-height", "0");
    });
</script>