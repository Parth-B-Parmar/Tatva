<?php
include "../db.php";

//ternary operator to store data
(!empty(isset($_GET['selected_search'])))
    ? $selected_search = $_GET['selected_search'] : $selected_search = "";

(!empty(isset($_GET['selected_type'])))
    ? $selected_type = $_GET['selected_type'] : $selected_type = "";

(!empty(isset($_GET['selected_category'])))
    ? $selected_category = $_GET['selected_category'] : $selected_category = "";

(!empty(isset($_GET['selected_university'])))
    ? $selected_university = $_GET['selected_university'] : $selected_university = "";

(!empty(isset($_GET['selected_course'])))
    ? $selected_course = $_GET['selected_course'] : $selected_course = "";

(!empty(isset($_GET['selected_country'])))
    ? $selected_country = $_GET['selected_country'] : $selected_country = "";

(!empty(isset($_GET['selected_rating'])))
    ? $selected_rating = $_GET['selected_rating'] : $selected_rating = "";

//to get all the notes
$all_note_query = "SELECT DISTINCT sellernotes.noteid,sellernotes.title,sellernotes.publisheddate,
                   sellernotes.displaypic,sellernotes.page_no,sellernotes.university_name 
                   FROM sellernotes 
                   LEFT JOIN sellernotesreview 
                   ON sellernotesreview.noteid=sellernotes.noteid 
                   WHERE sellernotes.status=6 AND sellernotes.isactive=1 
                   AND title LIKE '%$selected_search%'";

$query_append = "";

//to append all the query
($selected_type != 0 && $selected_type != "")
    ? $query_append .= " AND notetype='$selected_type'" : "";

($selected_category != 0 && $selected_category != "")
    ? $query_append .= " AND category='$selected_category'" : "";

($selected_university != 0 && $selected_university != "")
    ? $query_append .= " AND university_name='$selected_university'" : "";

($selected_course != 0 && $selected_course != "")
    ? $query_append .= " AND course='$selected_course'" : "";

($selected_country != 0 && $selected_country != "")
    ? $query_append .= " AND country='$selected_country'" : "";

($selected_rating != 0 && $selected_rating != "")
    ? $query_append .= " AND ratings>$selected_rating " : "";


//display total count
$filter_search_result_all = mysqli_num_rows(mysqli_query($con, $all_note_query . $query_append));

//pagination
(!empty(isset($_GET['page']))) && ($_GET['page'] != "") ? $page = $_GET['page'] : $page = 1;
$limit = 9;
$total_page = ceil($filter_search_result_all / $limit);
($page < 1) ? $page = 1 : "";
($filter_search_result_all > 0 && $total_page < $page) ? $page = $total_page : "";
$start_from = ($page - 1) * $limit;

//after the filter merge the query
$filter_search_query = $all_note_query . $query_append . " ORDER BY sellernotes.publisheddate DESC " . "LIMIT " . $start_from . "," . $limit;
$filter_search_result = mysqli_query($con, $filter_search_query);

?>
<script>
</script>
<div id="search-result">
    <div class="container">
        <div class="row">
            <div id="search-result-heading">
                <div class="col-md-12 col-md-12 col-sm-12 col-12">
                    <?php
                    if ($filter_search_result_all != 0)
                        echo " <h2>Total " . $filter_search_result_all . " notes</h2>";
                    else
                        echo " <h2>No Record Found!</h2>";
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">

            <?php

            //to get all books data
            while ($row = mysqli_fetch_assoc($filter_search_result)) {
                $note_id = $row['noteid'];
                $note_pic = $row['displaypic'];
                $note_title = $row['title'];
                $university_name = $row['university_name'];
                $note_page = $row['page_no'];
                $note_pub_date = $row['publisheddate']; ?>

            <div class="col-lg-4 col-md-6 col-sm-6 col-12 single-book-selecter">
                <?php echo "<a href='notes-details-page.php?id=$note_id'>"; ?>

                <!-- display img -->
                <img src='<?php echo $note_pic ?>' class='img-fluid img-setter-search-result search-img-border'
                    title='Click to View <?php echo $note_title ?>' alt='Book Cover photo of <?php echo $note_title ?>'>
                <?php echo "</a>
                        <a href='notes-details-page.php?id=$note_id' title='Click to view $note_title'>";
                    ?>
                <div class="search-result-below-img">
                    <ul>
                        <li>
                            <!-- display title     -->
                            <h3> <?php echo $note_title; ?> </h3>
                        </li>
                    </ul>
                    <div class="search-result-data">

                        <!-- university name -->
                        <img class="search-icon-resizer" src="images/university-dark.png" alt="university">
                        <h6 class="search-result-data-body">
                            <?php echo (!empty($university_name) && $university_name != '') ? $university_name : 'Not specified' ?>
                        </h6>
                    </div>

                    <!-- notes pages -->
                    <div class="search-result-data">
                        <img class="search-icon-resizer" src="images/book_open.png" alt="book">
                        <h6 class="search-result-data-body"><?php echo $note_page; ?> Pages</h6>
                    </div>

                    <!-- note publish date -->
                    <div class="search-result-data">
                        <img class="search-icon-resizer" src="images/calender-blue.png" alt="calender">
                        <h6 class="search-result-data-body">
                            <?php echo date('D, F d Y', strtotime($note_pub_date)); ?></h6>
                    </div>

                    <!-- imappropriate count -->
                    <div class="search-result-data">
                        <?php $appropriate_query = mysqli_query($con, "SELECT 1 FROM sellernotesreportedissues WHERE noteid=$note_id");
                            $appropriate_count = mysqli_num_rows($appropriate_query);
                            if ($appropriate_count > 0) { ?>
                        <img class="search-icon-resizer" src="images/red-flag.png" alt="flag">
                        <h6 class="search-result-data-body search-result-red">
                            <?php echo $appropriate_count ?>&nbspUser(s) have marked this note as
                            inappropriate</h6>
                        <?php } ?>
                    </div>

                    <?php

                        // display rating
                        $ratiing_getter = mysqli_query($con, "SELECT AVG(ratings),COUNT(ratings) FROM sellernotesreview WHERE noteid=$note_id AND isactive=1");
                        while ($row = mysqli_fetch_assoc($ratiing_getter)) {
                            $ratiing_val = $row['AVG(ratings)'];
                            $total_rating = $row['COUNT(ratings)']; ?>

                    <!-- rating display -->
                    <div class="note-page-star-setter">
                        <div id="<?php echo $note_id ?>"></div>
                        <?php echo $total_rating > 0 ? "<h6>" . $total_rating . " Reviews</h6>" : "<h6>No reviews yet!</h6>"; ?>
                    </div>
                    <?php } ?>

                    <script>
                    $('#<?php echo $note_id ?>').jsRapStar({
                        length: 5,
                        starHeight: 30,
                        colorFront: 'yellow',
                        enabled: false,
                        value: '<?php echo $ratiing_val ?>',
                    });
                    </script>
                </div>
                </a>
            </div>
            <?php } ?>
        </div>
    </div>
</div>


<!-- pagination start -->
<div class="search-pagination">
    <ul class="pagination justify-content-center">
        <?php
        echo "<li class='page-item'><a onclick=" . "showNotes($page-1)" . " class='page-link' >❮</a></li>";
        for ($i = 1; $i <= $total_page; $i++) {
            if ($i == $page) {
                echo "<li class='page-item active'><a class='page-link' onclick=" . "showNotes($i)" . ">$i</a></li>";
            } else echo "<li class='page-item'><a class='page-link' onclick=" . "showNotes($i)" . ">$i</a></li>";
        }
        echo "<li class='page-item'><a onclick=" . "showNotes($page+1)" . " class='page-link'>❯</a></li>";
        ?>
    </ul>
</div>
<!-- pagination end -->
