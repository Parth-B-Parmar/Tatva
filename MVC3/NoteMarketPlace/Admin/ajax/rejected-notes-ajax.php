<?php
include "../db.php";

$query_appender = "";

//append query for search 
$search = (isset($_GET['search']) && !empty($_GET['search']) && $_GET != "") ? $_GET['search'] : "";
$query_appender = ($search != "" && !empty($search))
    ? " AND (sn.title LIKE '%$search%' OR nc.name LIKE '%$search%' OR u.firstname LIKE '%$search%' OR u.lastname LIKE '%$search%' OR us.firstname LIKE '%$search%' OR us.lastname LIKE '%$search%' OR sn.createddate LIKE '%$search%' OR sn.admin_remarks LIKE '%$search%')" : "";

//filter by seller name
$sellerid = (isset($_GET['sellerid']) && $_GET['sellerid'] != "" && !empty($_GET['sellerid'])) ? $_GET['sellerid'] : "";

$query_appender .= ($sellerid != 0 && $sellerid != "" && !empty($sellerid)) ? " AND sn.sellerid=$sellerid" : "";

$rejected_query = "SELECT DISTINCT sn.noteid,sn.title,nc.name,u.userid,u.firstname AS sellerfname,u.lastname AS sellerlname,us.firstname AS rejectedfname,us.lastname AS rejectedlname,sn.createddate,sn.admin_remarks
                   FROM sellernotes sn
                   LEFT JOIN users u
                   ON u.userid=sn.sellerid
                   LEFT JOIN users us
                   ON us.userid=sn.actionedby
                   LEFT JOIN notecategories nc
                   ON nc.categoryid=sn.category
                   WHERE sn.status=7 AND sn.isactive=1";

$rejected_query .= $query_appender . " ORDER BY sn.createddate";

?>

<div id="dashboard-table-1">
    <div class="container">
        <div class="row">
            <div class="col-md-12 column-padding-remover">
                <table id="myTable" class="table entire-table text-center table-small rejected-t">
                    <thead>
                        <tr class="table-heading">
                            <th>sr no.</th>
                            <th>note title</th>
                            <th>category</th>
                            <th>seller</th>
                            <th>date added</th>
                            <th>rejected by</th>
                            <th>remark</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php

                        $sr_no = 0;
                        $rejected_note_result = mysqli_query($con, $rejected_query);
                        while ($row = mysqli_fetch_assoc($rejected_note_result)) {
                            $noteid = $row['noteid'];
                            $title = $row['title'];
                            $category = $row['name'];
                            $seller = $row['sellerfname'] . " " . $row['sellerlname'];
                            $sellerid = $row['userid'];
                            $rejecter_name = $row['rejectedfname'] . " " . $row['rejectedlname'];
                            $date = $row['createddate'];
                            $remark = $row['admin_remarks'];

                            //admin name getter
                            $rejecter_query = mysqli_query($con, "SELECT u.firstname,u.lastname 
                                                                  FROM users u  LEFT JOIN sellernotes sn
                                                                  ON u.userid=sn.actionedby WHERE sn.noteid=$noteid");

                            while ($row = mysqli_fetch_assoc($rejecter_query))
                                $rejecter_name = $row['firstname'] . ' ' . $row['lastname'];
                            $sr_no++;
                        ?>
                            <tr>
                                <td><?php echo $sr_no ?></td>
                                <td>
                                    <a href="notes-details-page.php?id=<?php echo $noteid ?>" title="click to open <?php echo $title ?>">
                                        <?php echo $title ?>
                                    </a>
                                </td>
                                <td><?php echo $category ?></td>
                                <td class="table-name-setter"><?php echo $seller ?>
                                    <a href="member-details-page.php?id=<?php echo $sellerid ?>" title="click to view more about <?php echo $seller ?>"><img src="images/eye.png" alt="view">
                                    </a>
                                </td>
                                <td class="table-date-setter"><?php echo date("d-m-y, H:i", strtotime($date)) ?></td>
                                <td><?php echo $rejecter_name ?></td>
                                <td><?php echo $remark ?></td>
                                <td>
                                    <div class="dropdown dropleft">
                                        <a class="btn" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <img src="images/dots.png" alt="open menu">
                                        </a>
                                        <ul class="dropdown-menu shadow-drop dropdowncustom-width dropdowncustom">

                                            <!-- approve pop up -->
                                            <li>
                                                <a data-id="<?php echo $noteid ?>" data-title="<?php echo $title ?>" data-target="#approve-popup" data-toggle="modal" id="approver">
                                                    <h6 class="dropdown-first-option">Approve</h6>
                                                </a>
                                            </li>

                                            <!-- download note -->
                                            <li>
                                                <a href="rejected-notes-page.php?noteid=<?php echo $noteid ?>&title=<?php echo $title ?>">
                                                    <h6 class="dropdown-first-option">Download Notes</h6>
                                                </a>
                                            </li>

                                            <!-- more details of notes -->
                                            <li>
                                                <a href="notes-details-page.php?id=<?php echo $noteid ?>">
                                                    <h6 class="dropdown-first-option">View More Details</h6>
                                                </a>
                                            </li>

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

<!-- Approve Pop up -->
<div class="review-box">
    <div style="margin-top: 120px;" id="approve-popup" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close text-right popup-close-btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body">
                    <form action="" method="POST">
                        <h4 id="title_approve" class="title_for_unpublish blue-font-20">If you approve
                            '<span class="note-dark-font"></span>'
                            System will publish the notes over portal.
                        </h4>
                        <h4 class="blue-font-20 title-setter">
                            Please press yes to continue.
                        </h4>
                        <input id="note_id_approve" name="approve_noteid" type="hidden">
                        <button type="submit" name="approve_submit" class="btn btn-primary blue-button-hover-white review-btn">yes</button>
                        <button class="btn btn-primary red-button-hover-white btn-upper" data-dismiss="modal">no</button>
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
    $(document).on("click", "#approver", function() {
        $("#note_id_approve").val($(this).data("id"));
        $("#title_approve span").html($(this).data("title"));
    });

    //table resizer for less entries
    $('#myTable').on('show.bs.dropdown', function() {
        $('#myTable').css("min-height", "135px");
    });

    $('#myTable').on('hide.bs.dropdown', function() {
        $('#myTable').css("min-height", "0");
    });
</script>