<?php
include "../db.php";
$query_appender = "";

//search string getter
$search = (isset($_GET['search']) && !empty($_GET['search']) && $_GET['search'] != "") ? $_GET['search'] : "";
$query_appender = ($search != "" && !empty($search)) ? " WHERE (u.firstname LIKE '%$search%' OR u.lastname LIKE '%$search%' OR nc.description LIKE '%$search%' OR nc.name LIKE '%$search%' OR nc.createddate LIKE '%$search%')" : "";

//main query
$category_query = "SELECT nc.categoryid,nc.name,nc.description,nc.createddate,u.firstname,u.lastname,nc.isactive 
FROM notecategories nc
LEFT JOIN users u
ON u.userid=nc.createdby";

$category_query .= $query_appender . " ORDER BY nc.createddate DESC";

?>

<div class="container">
    <div class="row">
        <div class="col-md-12 column-padding-remover margin-top-15">
            <table id="myTable" class="table entire-table table-small text-center">
                <thead>
                    <tr class="table-heading">
                        <th>sr no.</th>
                        <th>category</th>
                        <th>description</th>
                        <th>date added</th>
                        <th>added by</th>
                        <th>active</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $category_query_result = mysqli_query($con, $category_query);
                    $sr_no = 0;
                    while ($row = mysqli_fetch_assoc($category_query_result)) {

                        $sr_no++;
                        $categoryid = $row['categoryid'];
                        $category = $row['name'];
                        $description = $row['description'];
                        $date = $row['createddate'];
                        $approver = $row['firstname'] . " " . $row['lastname'];
                        $active = $row['isactive'];

                    ?>

                        <tr>
                            <td><?php echo $sr_no ?></td>
                            <td><?php echo $category ?></td>
                            <td><?php echo $description ?></td>
                            <td class="table-date-setter"><?php echo date("d-m-y, H:i", strtotime($date)) ?></td>
                            <td><?php echo $approver ?></td>
                            <td><?php echo ($active == 1) ? "Yes" : "No" ?></td>
                            <td>

                                <!-- edit admin -->
                                <a href="add-category-page.php?id=<?php echo $categoryid ?>"><img src="images/edit.png" alt="edit" title="click to edit <?php echo $category ?>">
                                </a>

                                <!-- disable category -->
                                <a id="dissabler" data-target="#disable-popup" data-toggle="modal" role="button" data-id="<?php echo $categoryid ?>" data-name="<?php echo $category ?>"> <img src="images/delete.png" alt="delete" title="click to remove <?php echo $category ?>">
                                </a>

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
                            make '<span class="note-dark-font"></span>' category inactive?
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
</script>