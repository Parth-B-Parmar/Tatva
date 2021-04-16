<?php include "../db.php";
$query_append = "";

//search getter
$search_val = (isset($_GET['search']) && !empty($_GET['search']) && $_GET['search'] != "") ? $_GET['search'] : "";
//search query append
$query_append = ($search_val != "" && !empty($search_val))
    ? " AND (title LIKE '%$search_val%' OR name LIKE '%$search_val%' OR value LIKE '%$search_val%' OR selling_price LIKE '%$search_val%' OR firstname LIKE '%$search_val%' OR lastname LIKE '%$search_val%' ) " : "";

//month getter
$selected_month = (isset($_GET['month']) && !empty($_GET['month']) && $_GET['month'] != "") ? $_GET['month'] : "";
$selected_month = explode("-", $selected_month);

//month query append
$query_append .= $selected_month != "" && !empty($selected_month)
    ? " AND MONTH(sn.publisheddate)=$selected_month[0] AND YEAR(sn.publisheddate)=$selected_month[1]" : "";

//main query
$note_getter = "SELECT DISTINCT sn.noteid,sn.title,nc.name,rd.value,sn.selling_price,u.userid,u.firstname,u.lastname,sn.publisheddate
                FROM sellernotes sn 
                LEFT JOIN notecategories nc ON sn.category=nc.categoryid
                LEFT JOIN referencedata rd ON rd.refdataid=sn.ispaid
                LEFT JOIN users u ON u.userid=sn.sellerid
                WHERE sn.status=6 AND sn.isactive=1 ";

//final query
$note_getter .= $query_append . " ORDER BY title";
$note_getter_result = mysqli_query($con, $note_getter);

?>
<div id="dashboard-table-1">
    <div class="container">
        <div class="row">
            <div class="col-md-12 column-padding-remover">
                <table id="myTable" class="table text-center table-small entire-table dashboard-t">
                    <thead>
                        <tr class="table-heading">
                            <th>sr no.</th>
                            <th>title </th>
                            <th>category</th>
                            <th>attachment size</th>
                            <th>sell type</th>
                            <th>price</th>
                            <th>publisher</th>
                            <th>Published date</th>
                            <th>total downlods</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        //to fetch thr note details
                        $sr_no = 0;
                        while ($row = mysqli_fetch_assoc($note_getter_result)) {
                            $noteid = $row['noteid'];
                            $title = $row['title'];
                            $category = $row['name'];
                            $sell_type = $row['value'];
                            $price = $row['selling_price'];
                            $publisher = $row['firstname'] . ' ' . $row['lastname'];
                            $publisher_id = $row['userid'];
                            $date = $row['publisheddate'];
                            $sr_no++;

                            //number_of_downloads
                            $total_download_count = mysqli_num_rows(mysqli_query($con, "SELECT DISTINCT noteid,downloader FROM downloads WHERE noteid=$noteid AND sellerhasalloweddownload=1"));

                        ?>
                        <tr>
                            <td class="sr-setter"><?php echo $sr_no ?></td>
                            <td>
                                <a href="notes-details-page.php?noteid=<?php echo $noteid ?>"
                                    title="click to open <?php echo $title ?>">
                                    <?php echo $title ?>
                                </a>
                            </td>
                            <td><?php echo $category ?></td>
                            <td><?php echo ($sr_no * 1.5) . 'KB' ?></td>
                            <td><?php echo $sell_type ?></td>
                            <td>&#36;<?php echo $price ?></td>
                            <td class="table-name-setter"><?php echo $publisher ?>
                                <a href="member-details-page.php?id=<?php echo $publisher_id ?>"
                                    title="click to view more about <?php echo $publisher ?>"><img src="images/eye.png"
                                        alt="view">
                                </a>
                            </td>
                            <td class="table-date-setter"><?php echo date("d-m-y, H:i", strtotime($date)) ?></td>
                            <td>
                                <a href="downloaded-notes-page.php?noteid=<?php echo $noteid ?>"
                                    title="click to view downloads of <?php echo $title ?>">
                                    <?php echo $total_download_count ?>
                                </a>
                            </td>
                            <td>
                                <div class="dropdown dropleft">
                                    <a class="btn" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <img src="images/dots.png" alt="open menu">
                                    </a>
                                    <ul class="dropdown-menu shadow-drop dropdowncustom-width dropdowncustom">
                                        <li><a
                                                href="dashboard-page.php?noteid=<?php echo $noteid ?>&title=<?php echo $title ?>">
                                                <h6 class="dropdown-first-option">Download Note</h6>
                                            </a>
                                        </li>
                                        <li><a href="notes-details-page.php?id=<?php echo $noteid ?>">
                                                <h6 class="dropdown-first-option">View More Details</h6>
                                            </a>
                                        </li>
                                        <li><a id="unpubhlisher" data-title="<?php echo $title ?>" data-toggle="modal"
                                                data-id="<?php echo $noteid ?>" data-target="#unpubhlisher-popup">
                                                <h4 class="dropdown-first-option">Unpublish</h4>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php   } ?>
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
                            <textarea id="review-comment-box2" name="unpublish_review" placeholder="Remarks..."
                                class="review-comment form-control" required></textarea>
                        </div>
                        <input id="note_id_unpublish" name="unpublish_noteid" type="hidden">
                        <button id="review-popup-btn2" type="submit" name="unpublish_submit"
                            class="btn red-button-hover-white review-btn">Unpublish</button>
                        <button class="btn btn-primary blue-button-hover-white btn-upper" data-dismiss="modal"
                            id="cancel-btn">cancel</button>
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