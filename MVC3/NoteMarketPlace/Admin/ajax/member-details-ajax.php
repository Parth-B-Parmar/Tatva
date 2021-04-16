<?php
include "../db.php";

//to get member userid from ajax
$memberid = (isset($_GET['id']) && !empty($_GET['id'])) ? $_GET['id'] : "";

?>
<!--Table start here-->
<div class="container">
    <div class="row">
        <div class="col-md-12 column-padding-remover">
            <h4 class="blue-font-24 margin-top-40 margin-l">Notes</h4>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12 column-padding-remover margin-top-15">
            <table id="myTable" class="table entire-table text-center table-large member-d-t">
                <thead>
                    <tr class="table-heading">
                        <th>sr no.</th>
                        <th>note title</th>
                        <th>category</th>
                        <th>status</th>
                        <th>downloaded notes</th>
                        <th>total earnings</th>
                        <th>date added</th>
                        <th>published date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $member_data = "SELECT sn.noteid,sn.title,nc.name,ref.value,sn.publisheddate,sn.createddate
                    FROM sellernotes sn
                    LEFT JOIN notecategories nc
                    ON nc.categoryid=sn.category
                    LEFT JOIN referencedata ref
                    ON ref.refdataid=sn.status
                    WHERE sn.isactive=1 AND sn.status NOT IN (3) AND sellerid=$memberid ORDER BY sn.createddate DESC";

                    $sr_no = 0;
                    $member_data_result = mysqli_query($con, $member_data);

                    while ($row = mysqli_fetch_assoc($member_data_result)) {

                        $sr_no++;
                        $noteid = $row['noteid'];
                        $title = $row['title'];
                        $category = $row['name'];
                        $status = $row['value'];
                        $added_date = $row['createddate'];
                        $pub_date = $row['publisheddate'];

                        //number of downlaods of notes
                        $number_of_notes = mysqli_num_rows(mysqli_query($con, "SELECT DISTINCT noteid,downloader FROM downloads WHERE noteid=$noteid AND sellerhasalloweddownload=1"));

                        //total earnings each notes
                        $earn = mysqli_query($con, "SELECT selling_price FROM sellernotes WHERE noteid=$noteid");
                        while ($row = mysqli_fetch_assoc($earn))
                            $total_earn = $row['selling_price'] * $number_of_notes;

                    ?>
                        <tr>
                            <td><?php echo $sr_no ?></td>
                            <td>
                                <a href="notes-details-page.php?id=<?php echo $noteid ?>" title="click to open <?php echo $title ?>">
                                    <?php echo $title ?>
                                </a>
                            </td>
                            <td><?php echo $category ?></td>
                            <td><?php echo $status ?></td>
                            <td>
                                <a href="downloaded-notes-page.php?noteid=<?php echo $noteid ?>" title="click to view downloaders of <?php echo $title ?>">
                                    <?php echo $number_of_notes ?>
                                </a>
                            </td>
                            <td>&#36;<?php echo $total_earn ?></td>
                            <td class="table-date-setter"><?php echo date("d-m-y, H:i", strtotime($added_date)) ?></td>
                            <td class="table-date-setter"><?php echo date("d-m-y, H:i", strtotime($pub_date)) ?></td>
                            <td>
                                <div class="dropdown dropleft">
                                    <a class="btn" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="images/dots.png" alt="open menu">
                                    </a>
                                    <ul class="dropdown-menu shadow-drop dropdowncustom-width dropdowncustom">
                                        <li><a href="member-details-page.php?id=<?php echo $memberid ?>&noteid=<?php echo $noteid ?>&title=<?php echo $title ?>">
                                                <h6 class="dropdown-first-option">Download Notes</h6>
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

<script>
    //data table
    $(document).ready(function() {
        $('#myTable').DataTable({
            "scrollX": true,
            "pageLength": 5
        });
    });
</script>