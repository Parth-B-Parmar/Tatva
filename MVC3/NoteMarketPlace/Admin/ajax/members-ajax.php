<?php
include "../db.php";
$query_appender = "";

//search string getter
$search = (isset($_GET['search']) && $_GET['search'] && $_GET['search'] != "") ? $_GET['search'] : "";
$query_appender = ($search != "" && !empty($search))
    ? " AND (firstname LIKE '%$search%' OR lastname LIKE '%$search%' OR emailid LIKE '%$search%' OR createddate LIKE '%$search%')" : "";

//main query
$member_query = "SELECT userid,firstname,lastname,emailid,createddate
                 FROM users WHERE isactive=1 AND roleid=1";

//search query
$member_query .= $query_appender . " ORDER BY createddate";

?>
<div class="container">
    <div class="row">
        <div class="col-md-12 column-padding-remover margin-top-15">
            <table id="myTable" class="table entire-table table-e-large member-t">
                <thead>
                    <tr class="table-heading text-center">
                        <th>sr no.</th>
                        <th>first name</th>
                        <th>last name</th>
                        <th>email</th>
                        <th>joining date</th>
                        <th>notes under review</th>
                        <th>published notes</th>
                        <th>downlaoded notes</th>
                        <th>total expenses</th>
                        <th>total earnings</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $member_query_result = mysqli_query($con, $member_query);

                    $sr_no = 0;
                    while ($row = mysqli_fetch_assoc($member_query_result)) {

                        $sr_no++;
                        $userid = $row['userid'];
                        $fname = $row['firstname'];
                        $lname = $row['lastname'];
                        $email_user = $row['emailid'];
                        $join_date = $row['createddate'];

                        //under review notes count
                        $under_review_notes = mysqli_num_rows(mysqli_query($con, "SELECT 1 FROM sellernotes WHERE status IN (4,5) AND sellerid=$userid AND isactive=1"));

                        //published notes count
                        $published_notes = mysqli_num_rows(mysqli_query($con, "SELECT 1 FROM sellernotes WHERE status=6 AND sellerid=$userid AND isactive=1"));

                        //downloladed notes counts
                        $downloaded_count = mysqli_num_rows(mysqli_query($con, "SELECT DISTINCT noteid FROM downloads WHERE downloader=$userid AND sellerhasalloweddownload=1"));

                        //total expensis
                        $total_expensis = 0;
                        $expensis = mysqli_query($con, "SELECT DISTINCT noteid,purchasedprice FROM downloads WHERE downloader=$userid AND ispaid=1 AND sellerhasalloweddownload=1");
                        while ($row = mysqli_fetch_assoc($expensis)) {
                            $note_price = $row['purchasedprice'];

                            //total expensis per user
                            $total_expensis += $note_price;
                        }

                        //total earnings
                        $total_earnings = 0;
                        $earnings = mysqli_query($con, "SELECT DISTINCT noteid,downloader,purchasedprice FROM downloads WHERE seller=$userid AND ispaid=1 AND sellerhasalloweddownload=1");
                        while ($row = mysqli_fetch_assoc($earnings)) {
                            $profit_per_note = $row['purchasedprice'];

                            //total earnings price per user
                            $total_earnings += $profit_per_note;
                        }

                    ?>
                        <tr class="text-center">

                            <!-- td elements -->
                            <td class="sr-setter"><?php echo $sr_no ?></td>
                            <td class="table-name-setter-sm"><?php echo $fname ?>
                                <a href="member-details-page.php?id=<?php echo $userid ?>" title="click to view more about <?php echo $fname . ' ' . $lname ?>"><img src="images/eye.png" alt="view">
                                </a>
                            </td>
                            <td class="table-name-setter-sm"><?php echo $lname ?>
                                <a href="member-details-page.php?id=<?php echo $userid ?>" title="click to view more about <?php echo $fname . ' ' . $lname ?>"><img src="images/eye.png" alt="view">
                                </a>
                            </td>
                            <td class="text-samller"><?php echo $email_user ?></td>
                            <td class="table-date-setter"><?php echo date("d-m-y, H:i", strtotime($join_date)) ?></td>
                            <td>
                                <a href="notes-under-review-page.php?id=<?php echo $userid ?>" title="click to view notes under review of <?php echo $fname . ' ' . $lname ?>">
                                    <?php echo $under_review_notes ?>
                                </a>
                            </td>
                            <td>
                                <a href="published-notes-page.php?id=<?php echo $userid ?>" title="click to view published notes of <?php echo $fname . ' ' . $lname ?>">
                                    <?php echo $published_notes ?>
                                </a>
                            </td>
                            <td>
                                <a href="downloaded-notes-page.php?id=<?php echo $userid ?>" title="click to view downloaded notes by <?php echo $fname . ' ' . $lname ?>">
                                    <?php echo $downloaded_count ?>
                                </a>
                            </td>
                            <td>&#36;
                                <a href="downloaded-notes-page.php?id=<?php echo $userid ?>" title="click to view downloaded notes by <?php echo $fname . ' ' . $lname ?>">
                                    <?php echo $total_expensis ?>
                                </a>
                            </td>
                            <td>&#36;<?php echo $total_earnings ?></td>
                            <td>
                                <div class="dropdown dropleft">
                                    <a class="btn" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="images/dots.png" alt="open menu">
                                    </a>
                                    <ul class="dropdown-menu shadow-drop dropdowncustom-width dropdowncustom">

                                        <!-- more details of user -->
                                        <li>
                                            <a href="member-details-page.php?id=<?php echo $userid ?>">
                                                <h6 class="dropdown-first-option">View More Details</h6>
                                            </a>
                                        </li>

                                        <!-- pop up deactive -->
                                        <li>
                                            <a id="dissabler" data-target="#disable-popup" data-toggle="modal" data-id="<?php echo $userid ?>" data-name="<?php echo $fname . ' ' . $lname ?>">
                                                <h4 class="dropdown-first-option">Deactive</h4>
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

<!-- deactive Pop up -->
<div class="review-box">
    <div style="margin-top: 170px;" id="disable-popup" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close text-right popup-close-btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body">

                    <!-- form to submit the data -->
                    <form action="" method="POST">

                        <!-- display warn -->
                        <h4 id="popup_display_name" class="title_for_unpublish blue-font-20">Are you sure you want to
                            make '<span class="note-dark-font"></span>' inactive?
                        </h4>
                        <h4 class="blue-font-20 title-setter">
                            Please press yes to continue.
                        </h4>

                        <!-- hidden id -->
                        <input id="popup_display_id" name="popup_id" type="hidden">

                        <!-- approve button -->
                        <button type="submit" name="popup_submit" class="btn btn-primary red-button-hover-white review-btn">yes</button>

                        <!-- cancel button -->
                        <button class="btn btn-primary blue-button-hover-white btn-upper" data-dismiss="modal">no</button>
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

    //data getter via data-id
    $(document).on("click", "#dissabler", function() {
        $("#popup_display_name span").html($(this).data("name"));
        $("#popup_display_id").val($(this).data("id"));
    });

    //table resizer for single entry
    $('#myTable').on('show.bs.dropdown', function() {
        $('#myTable').css("min-height", "90px");
    });

    $('#myTable').on('hide.bs.dropdown', function() {
        $('#myTable').css("min-height", "0");
    });
</script>