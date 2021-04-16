<?php
include "../db.php";
$query_appender = "";

//search getter
$search_val = (isset($_GET['search']) && $_GET['search'] != "" && !empty($_GET['search'])) ? $_GET['search'] : "";

//search query appender
$query_appender = ($search_val != "" && !empty($search_val))
    ? " AND (title LIKE '%$search_val%' OR nc.name LIKE '%$search_val%' OR firstname LIKE '%$search_val%' OR lastname LIKE '%$search_val%' OR sn.createddate LIKE '%$search_val%' OR ref.value LIKE '%$search_val%')" : "";

//filter via seller name
$filter_seller = (isset($_GET['seller_name']) && $_GET['seller_name'] != "" && !empty($_GET['seller_name'])) ? $_GET['seller_name'] : "";

//storing seller id in query appender
$query_appender .= ($filter_seller != "" && $filter_seller != 0 && !empty($filter_seller)) ? " AND sellerid=$filter_seller " : "";

$review_query = "SELECT DISTINCT sn.noteid,sn.noteid,sn.title,nc.name,u.userid,u.firstname,u.lastname,sn.createddate,ref.value
                 FROM sellernotes sn LEFT JOIN notecategories nc 
                 ON sn.category=nc.categoryid
                 LEFT JOIN users u
                 ON u.userid=sn.sellerid
                 LEFT JOIN referencedata ref
                 ON sn.status=ref.refdataid 
                 WHERE sn.status IN (4,5) AND sn.isactive=1";

//fianl query
$review_query .= $query_appender . " ORDER BY sn.createddate";

?>

<div id="dashboard-table-1">
    <div class="container">
        <div class="row">
            <div class="col-md-12 column-padding-remover">
                <table id="myTable" class="table entire-table table-small-xs text-center notes-review-t">
                    <thead>
                        <tr class="table-heading">
                            <th>sr no.</th>
                            <th>note title</th>
                            <th>category</th>
                            <th>seller</th>
                            <th>date added</th>
                            <th>status</th>
                            <th class="text-center">action</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $sr_no = 0;
                        $review_result = mysqli_query($con, $review_query);
                        while ($row = mysqli_fetch_assoc($review_result)) {
                            $sr_no++;
                            $noteid = $row['noteid'];
                            $title = $row['title'];
                            $category = $row['name'];
                            $seller_name = $row['firstname'] . ' ' . $row['lastname'];
                            $seller_id = $row['userid'];
                            $date = $row['createddate'];
                            $status = $row['value'];

                        ?>
                            <tr>
                                <td class="sr-setter"><?php echo $sr_no ?></td>
                                <td>
                                    <a href="notes-details-page.php?id=<?php echo $noteid ?>" title="click to open <?php echo $title ?>">
                                        <?php echo $title ?>
                                    </a>
                                </td>
                                <td><?php echo $category ?></td>
                                <td class="table-name-setter"><?php echo $seller_name ?>
                                    <a href="member-details-page.php?id=<?php echo $seller_id ?>" title="click to view more about <?php echo $seller_name ?>"><img src="images/eye.png" alt="view">
                                    </a>
                                </td>
                                <td class="table-date-setter"><?php echo date("d-m-y, H:i", strtotime($date)) ?>
                                </td>
                                <td><?php echo $status ?></td>
                                <td class="three-button-setter">

                                    <!-- Approve -->
                                    <button data-id="<?php echo $noteid ?>" data-title="<?php echo $title ?>" data-target="#approve-popup" data-toggle="modal" id="approver" class="btn btn-success">Approve</button>

                                    <!-- Reject -->
                                    <button data-id="<?php echo $noteid ?>" data-title="<?php echo $title ?>" data-target="#reject-popup" data-toggle="modal" id="rejecter" class="btn btn-danger">Reject</button>

                                    <!-- InReview -->
                                    <button data-id="<?php echo $noteid ?>" data-title="<?php echo $title ?>" data-target="#review-popup" data-toggle="modal" id="reviewer" class="btn btn-light inreview-btn">InReview</button>

                                </td>
                                <td>
                                    <div class="dropdown dropleft">
                                        <a class="btn" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <img src="images/dots.png" alt="open menu">
                                        </a>
                                        <ul class="dropdown-menu shadow-drop dropdowncustom-width dropdowncustom">
                                            <li><a href="notes-under-review-page.php?noteid=<?php echo $noteid ?>&title=<?php echo $title ?>">
                                                    <h6 class="dropdown-first-option">Download Notes</h6>
                                                </a></li>
                                            <li><a href="notes-details-page.php?id=<?php echo $noteid ?>">
                                                    <h6 class="dropdown-first-option">View More Details</h6>
                                                </a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php  }
                        ?>
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
                        <button type="submit" name="Approve_submit" class="btn btn-primary blue-button-hover-white review-btn">yes</button>
                        <button class="btn btn-primary red-button-hover-white btn-upper" data-dismiss="modal">no</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- InReview Pop up -->
<div class="review-box">
    <div style="margin-top: 120px;" id="review-popup" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close text-right popup-close-btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body">
                    <form action="" method="POST">
                        <h4 id="title_review" class="blue-font-20 title_for_unpublish">Via marking
                            '<span class="note-dark-font"></span>' In
                            Review user know that review process has been initiated
                        </h4>
                        <h4 class="blue-font-20 title-setter">
                            Please press yes to continue.
                        </h4>
                        <input id="note_id_review" name="review_noteid" type="hidden">
                        <button type="submit" name="review_submit" class="btn btn-primary blue-button-hover-white review-btn">yes</button>
                        <button class="btn btn-primary red-button-hover-white btn-upper" data-dismiss="modal">no</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Pop up -->
<div class="review-box">
    <div style="margin-top: 120px;" id="reject-popup" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close text-right popup-close-btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body">
                    <form action="" method="POST">
                        <h4 id="title_reject" class="title_for_unpublish blue-font-26"></h4>
                        <div class="form-group">
                            <label id="review-label2" class="review-label">Remarks *</label>
                            <textarea id="review-comment-box2" name="unpublish_review" placeholder="Remarks..." class="form-control review-comment" required></textarea>
                        </div>
                        <input id="note_id_reject" name="reject_noteid" type="hidden">
                        <button type="submit" name="unpublish_submit" class="btn red-button-hover-white review-btn">reject</button>
                        <button class="btn btn-primary blue-button-hover-white btn-upper" data-dismiss="modal">cancel</button>
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
</script>

<script>
    // title and note id getter for approve
    $(document).on("click", "#approver", function() {
        $("#note_id_approve").val($(this).data("id"));
        $("#title_approve span").html($(this).data("title"));
    });

    // title and note id getter for review
    $(document).on("click", "#reviewer", function() {
        $("#title_review span").html($(this).data("title"));
        $("#note_id_review").val($(this).data("id"));
    });

    // title and note id getter for reject
    $(document).on("click", "#rejecter", function() {
        $("#title_reject").html($(this).data("title"));
        $("#note_id_reject").val($(this).data("id"));
    });
</script>

<script>
    //table resizer for less entries
    $('#myTable').on('show.bs.dropdown', function() {
        $('#myTable').css("min-height", "90px");
    });

    $('#myTable').on('hide.bs.dropdown', function() {
        $('#myTable').css("min-height", "0");
    });
</script>