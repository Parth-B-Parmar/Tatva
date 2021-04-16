<?php
include "../db.php";
$query_appender = "";

//search string getter
$search = (isset($_GET['search']) && !empty($_GET['search']) && $_GET['search'] != "") ? $_GET['search'] : "";
$query_appender = ($search != "" && !empty($search)) ? " WHERE (u.firstname LIKE '%$search%' OR u.lastname LIKE '%$search%' OR c.countrycode LIKE '%$search%' OR c.name LIKE '%$search%' OR c.createddate LIKE '%$search%')" : "";

//main query
$country_query = "SELECT c.countryid,c.name,c.countrycode,c.createddate,u.firstname,u.lastname,c.isactive 
FROM countries c
LEFT JOIN users u
ON u.userid=c.createdby";

$country_query .= $query_appender . " ORDER BY c.createddate DESC";
?>

<!-- data tables starts here -->
<div class="container">
    <div class="row">
        <div class="col-md-12 column-padding-remover margin-top-15">
            <table id="myTable" class="table entire-table text-center table-small">
                <thead>
                    <tr class="table-heading">
                        <th>sr no.</th>
                        <th>country name</th>
                        <th>country code</th>
                        <th>date added</th>
                        <th>added by</th>
                        <th>active</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $country_query_result = mysqli_query($con, $country_query);
                    $sr_no = 0;

                    while ($row = mysqli_fetch_assoc($country_query_result)) {

                        $sr_no++;
                        $countryid = $row['countryid'];
                        $country = $row['name'];
                        $country_code = $row['countrycode'];
                        $date = $row['createddate'];
                        $approver = $row['firstname'] . " " . $row['lastname'];
                        $active = $row['isactive'];

                    ?>
                        <tr>
                            <td><?php echo $sr_no ?></td>
                            <td><?php echo $country ?></td>
                            <td><?php echo $country_code ?></td>
                            <td class="table-date-setter"><?php echo date("d-m-y, H:i", strtotime($date)) ?></td>
                            <td><?php echo $approver ?></td>
                            <td><?php echo ($active == 1) ? "Yes" : "No" ?></td>
                            <td>

                                <!-- edit country -->
                                <a href="add-country-page.php?id=<?php echo $countryid ?>"><img src="images/edit.png" alt="edit" title="click to edit <?php echo $country ?>">
                                </a>

                                <!-- disable country -->
                                <a id="dissabler" data-target="#disable-popup" data-toggle="modal" role="button" data-id="<?php echo $countryid ?>" data-name="<?php echo $country ?>"> <img src="images/delete.png" alt="delete" title="click to remove <?php echo $country ?>">
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
                            make '<span class="note-dark-font"></span>' country inactive?
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