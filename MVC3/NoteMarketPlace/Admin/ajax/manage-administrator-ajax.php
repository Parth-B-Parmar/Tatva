<?php
include "../db.php";
$query_appender = "";

//search string getter
$search = (isset($_GET['search']) && !empty($_GET['search']) && $_GET['search'] != "") ? $_GET['search'] : "";
$query_appender = ($search != "" && !empty($search)) ? " AND (u.firstname LIKE '%$search%' OR u.lastname LIKE '%$search%' OR u.emailid LIKE '%$search%' OR phone_no LIKE '%$search%' OR u.createddate LIKE '%$search%')" : "";

$admin_query = "SELECT u.userid,u.firstname,u.lastname,u.emailid,up.phone_no,u.createddate AS createddate_user,u.isactive 
                FROM users u
                LEFT JOIN userprofile up
                ON up.userid=u.userid
                WHERE u.roleid=2";

$admin_query .= $query_appender . " ORDER BY u.createddate DESC";

?>

<div class="container">
    <div class="row">
        <div class="col-md-12 column-padding-remover margin-top-15">
            <table id="myTable" class="table entire-table text-center table-small">
                <thead>
                    <tr class="table-heading">
                        <th>sr no.</th>
                        <th>first name</th>
                        <th>last name</th>
                        <th>email</th>
                        <th>phone no.</th>
                        <th>data added</th>
                        <th>active</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $admin_query_result = mysqli_query($con, $admin_query);
                    $sr_no = 0;
                    while ($row = mysqli_fetch_assoc($admin_query_result)) {

                        $sr_no++;
                        $userid = $row['userid'];
                        $fname = $row['firstname'];
                        $lname = $row['lastname'];
                        $email_user = $row['emailid'];
                        $phone_no = $row['phone_no'];
                        $date = $row['createddate_user'];
                        $active = $row['isactive'];

                    ?>
                        <tr>
                            <td><?php echo $sr_no ?></td>
                            <td><?php echo $fname ?></td>
                            <td><?php echo $lname ?></td>
                            <td class="text-samller"><?php echo $email_user ?></td>
                            <td class="text-samller"><?php echo (!empty($phone_no)) ? $phone_no : "havn't enrolled yet!" ?>
                            </td>
                            <td class="table-date-setter"><?php echo date("d-m-y, H:i", strtotime($date)) ?></td>
                            <td><?php echo ($active == 1) ? "Yes" : "No"; ?> </td>

                            <td>

                                <!-- edit admin -->
                                <a href="add-administrator-page.php?id=<?php echo $userid ?>"><img src="images/edit.png" alt="edit" title="click to edit <?php echo $fname . ' ' . $lname ?>">
                                </a>

                                <!-- remove admin -->
                                <a id="dissabler" data-target="#disable-popup" data-toggle="modal" role="button" data-id="<?php echo $userid ?>" data-name="<?php echo $fname . ' ' . $lname ?>"> <img src="images/delete.png" alt="delete" title="click to remove <?php echo $fname . ' ' . $lname ?>">
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

    //table resizer for single entry
    $('#myTable').on('show.bs.dropdown', function() {
        $('#myTable').css("min-height", "90px");
    });

    $('#myTable').on('hide.bs.dropdown', function() {
        $('#myTable').css("min-height", "0");
    });
</script>