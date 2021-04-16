<?php
include "../db.php";
$query_appender = "";

//search string getter
$search = (isset($_GET['search']) && !empty($_GET['search']) && $_GET['search'] != "") ? $_GET['search'] : "";
$query_appender = ($search != "" && !empty($search)) ? " WHERE (u.firstname LIKE '%$search%' OR u.lastname LIKE '%$search%' OR sn.title LIKE '%$search%' OR nc.name LIKE '%$search%' OR nri.createddate LIKE '%$search%' OR nri.remarks LIKE '%$search%')" : "";

//main query
$spam_getter_query = "SELECT u.userid,u.firstname,u.lastname,sn.noteid,sn.title,nc.name,nri.createddate,nri.remarks,nri.note_reportid
                      FROM sellernotesreportedissues nri
                      LEFT JOIN users u
                      ON nri.reprotedbyid=u.userid 
                      LEFT JOIN sellernotes sn
                      ON sn.noteid=nri.noteid
                      LEFT JOIN notecategories nc
                      ON nc.categoryid=sn.category";

$spam_getter_query .= $query_appender . " ORDER BY nri.createddate DESC";
?>

<div class="container">
    <div class="row">
        <div class="col-md-12 column-padding-remover margin-top-15">
            <table id="myTable" class="table entire-table text-center table-small spam-r-t">
                <thead>
                    <tr class="table-heading">
                        <th>sr no.</th>
                        <th>reported by</th>
                        <th>note title</th>
                        <th>category</th>
                        <th>data added</th>
                        <th>remark</th>
                        <th>action</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    <!-- spam data getter -->
                    <?php
                    $spam_getter_query_result = mysqli_query($con, $spam_getter_query);
                    $sr_no = 0;
                    while ($row = mysqli_fetch_assoc($spam_getter_query_result)) {

                        $sr_no++;
                        $nri_id = $row['note_reportid'];
                        $reporter = $row['firstname'] . " " . $row['lastname'];
                        $reporter_id = $row['userid'];
                        $noteid = $row['noteid'];
                        $title = $row['title'];
                        $category = $row['name'];
                        $date = $row['createddate'];
                        $remark = $row['remarks'];

                    ?>
                        <tr>
                            <td class="sr-setter"><?php echo $sr_no ?></td>
                            <td class="table-name-setter-sm"><?php echo $reporter ?>
                                <a href="member-details-page.php?id=<?php echo $reporter_id ?>" title="click to view more about <?php echo $reporter ?>"><img src="images/eye.png" alt="view">
                                </a>
                            </td>
                            <td class="table-name-setter">
                                <a href="notes-details-page.php?id=<?php echo $noteid ?>" title="click to open <?php echo $title ?>">
                                    <?php echo $title ?>
                                </a>
                            </td>
                            <td class="table-name-setter"><?php echo $category ?></td>
                            <td class="table-date-setter"><?php echo date("d-m-y, H:i", strtotime($date)) ?></td>
                            <td><?php echo  $remark ?></td>
                            <td>

                                <!-- delete review -->
                                <a id="dissabler" data-target="#disable-popup" data-toggle="modal" role="button" data-id="<?php echo $nri_id ?>" data-name="<?php echo $reporter ?>" data-title="<?php echo $title ?>" title="click to delete review of <?php echo $title ?> by <?php echo $reporter ?>">
                                    <img src="images/delete.png" alt="Delete">
                                </a>

                            </td>
                            <td>

                                <!-- drop down -->
                                <div class="dropdown dropleft">
                                    <a class="btn" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="images/dots.png" alt="open menu">
                                    </a>
                                    <ul class="dropdown-menu shadow-drop dropdowncustom-width dropdowncustom">

                                        <!-- to downlaod the note -->
                                        <li><a href="spam-report-page.php?title=<?php echo $title ?>&noteid=<?php echo $noteid ?>" title="click to download <?php echo $title ?>">
                                                <h6 class="dropdown-first-option">Download Notes</h6>
                                            </a></li>

                                        <!-- to open note details -->
                                        <li><a href="notes-details-page.php?id=<?php echo $noteid ?>" title="click to view more about <?php echo $title ?>">
                                                <h6 class="dropdown-first-option">View More Details</h6>
                                            </a></li>

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
                            delete reported issue of '<span id="displayer_title" class="note-dark-font">
                            </span>' by '<span id="displayer_name" class="note-dark-font"></span>'?
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
        $("#popup_display_name #displayer_title").html($(this).data("title"));
        $("#popup_display_name #displayer_name").html($(this).data("name"));
        $("#popup_display_id").val($(this).data("id"));
    });
</script>