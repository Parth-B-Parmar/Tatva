<?php
include "../db.php";
$query_appender = "";

//search string getter
$search = (isset($_GET['search']) && !empty($_GET['search']) && $_GET['search'] != "") ? $_GET['search'] : "";
$query_appender = ($search != "" && !empty($search)) ? " WHERE (u.firstname LIKE '%$search%' OR u.lastname LIKE '%$search%' OR nt.description LIKE '%$search%' OR nt.name LIKE '%$search%' OR nt.createddate LIKE '%$search%')" : "";

//main query
$type_query = "SELECT nt.typeid,nt.name,nt.description,nt.createddate,u.firstname,u.lastname,nt.isactive 
FROM notetypes nt
LEFT JOIN users u
ON u.userid=nt.createdby";

$type_query .= $query_appender . " ORDER BY nt.createddate DESC";

?>

<div class="container">
    <div class="row">
        <div class="col-md-12 column-padding-remover margin-top-15">
            <table id="myTable" class="table entire-table text-center table-small">
                <thead>
                    <tr class="table-heading">
                        <th>sr no.</th>
                        <th>type</th>
                        <th>description</th>
                        <th>date added</th>
                        <th>added by</th>
                        <th>active</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $sr_no = 0;
                    $type_query_result = mysqli_query($con, $type_query);
                    while ($row = mysqli_fetch_assoc($type_query_result)) {

                        $sr_no++;
                        $typeid = $row['typeid'];
                        $type = $row['name'];
                        $description = $row['description'];
                        $date = $row['createddate'];
                        $approver = $row['firstname'] . " " . $row['lastname'];
                        $active = $row['isactive'];

                    ?>
                        <tr>
                            <td class="sr-setter"><?php echo $sr_no ?></td>
                            <td class="table-name-setter"><?php echo $type ?></td>
                            <td><?php echo $description ?></td>
                            <td class="table-date-setter"><?php echo date("d-m-y, H:i", strtotime($date)) ?></td>
                            <td class="table-name-setter"><?php echo $approver ?></td>
                            <td><?php echo ($active == 1) ? "Yes" : "No" ?></td>
                            <td class="table-name-setter-sm">

                                <!-- edit type -->
                                <a href="add-type.php?id=<?php echo $typeid ?>"><img src="images/edit.png" alt="edit" title="click to edit <?php echo $type ?>">
                                </a>

                                <!-- disable type -->
                                <a role="button" id="dissabler" data-target="#disable-popup" data-toggle="modal" role="button" data-id="<?php echo $typeid ?>" data-name="<?php echo $type ?>"> <img src="images/delete.png" alt="delete" title="click to remove <?php echo $type ?>">
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
</script>