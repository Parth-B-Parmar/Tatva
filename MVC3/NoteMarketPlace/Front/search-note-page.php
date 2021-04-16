<?php
include "db.php";
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <!--Meta tags-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0 ,user-scalable=no">
    <meta charset="UTF-8">

    <!--Title-->
    <title>Notes Marketplace</title>

    <!--Fevicon-->
    <link rel="icon" href="images/favicon.ico">

    <!--Google Fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!--popper js-->
    <script src="js/popper/popper.min.js"></script>

    <!--jquery js-->
    <script src="js/jquery/jquery.min.js"></script>

    <!--bootstrap js-->
    <script src="js/bootstrap/bootstrap.min.js"></script>

    <!-- Rapstar js -->
    <script src="js/jsRapStar.js"></script>

    <!--Custom Script-->
    <script src="js/script.js"></script>

    <!--Font-Awesome-->
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">

    <!--bootstrap css-->
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">

    <!-- Rapstar css -->
    <link rel="stylesheet" href="css/jsRapStarSmall.css">

    <!--Custom css-->
    <link rel="stylesheet" href="css/style.css">

    <!--Responsive css-->
    <link rel="stylesheet" href="css/responsive.css">

</head>

<body class="sticky-header">

    <!--header -->
    <?php include "header.php" ?>
    <!--header end-->

    <div id="search-all-font">
        <div id="search-top-img">
            <img src="images/banner-with-overlay-user-profile.jpg" alt="Banner image" class="img-fluid">
            <div id="search-home-heading" class="text-center">
                <h3 class="heading-margin">Search Notes</h3>
            </div>
        </div>
        <div id="search-filter-heading">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-12">
                        <h4>Search and Filter notes</h4>
                    </div>
                </div>
            </div>
        </div>
        <div id="search-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-md-12 col-sm-12 col-12">
                        <div id="search-icon">
                            <i class="fa fa-search"></i>
                            <input id="search-note-main" onkeyup="showNotes()" type="text"
                                class="form-control input-light-color" placeholder="Search your notes here...">
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-12">
                        <div id="search-filters">
                            <div class="row">

                                <!-- type getter -->
                                <div class="col-lg-2 col-md-4 col-sm-4 col-6 search-type-gap">
                                    <select id="search_type" onchange="showNotes()"
                                        class="text-hidden form-control options-arrow-down">
                                        <option value="0" selected>Select type</option>
                                        <?php
                                        $result = mysqli_query($con, "SELECT typeid,name FROM notetypes WHERE isactive=1");
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $type_id = $row['typeid'];
                                            $type_name = $row['name'];
                                            echo "<option value='$type_id'>$type_name</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- category getter -->
                                <div class="col-lg-2 col-md-4 col-sm-4 col-6 search-type-gap">
                                    <select id="search_category" onchange="showNotes()"
                                        class="text-hidden form-control options-arrow-down">
                                        <option value="0" selected>Select category</option>
                                        <?php
                                        $result = mysqli_query($con, "SELECT categoryid,name FROM notecategories WHERE isactive=1");
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $category_id = $row['categoryid'];
                                            $category_name = $row['name'];
                                            echo "<option value='$category_id'>$category_name</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- university getter -->
                                <div class="col-lg-2 col-md-4 col-sm-4 col-6 search-type-gap">
                                    <select id="search_university" onchange="showNotes()"
                                        class="text-hidden form-control options-arrow-down">
                                        <option value="0" selected>Select college university</option>
                                        <?php
                                        $result = mysqli_query($con, "SELECT DISTINCT university_name FROM sellernotes WHERE isactive=1");
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $university_name = $row['university_name'];
                                            echo (!empty($university_name) && $university_name != "")
                                                ? "<option value='$university_name'>$university_name</option>" : "";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- course getter -->
                                <div class="col-lg-2 col-md-4 col-sm-4 col-6 search-type-gap">
                                    <select id="search_course" onchange="showNotes()"
                                        class="text-hidden form-control options-arrow-down">
                                        <option value="0" selected>Select course</option>
                                        <?php
                                        $result = mysqli_query($con, "SELECT DISTINCT course FROM sellernotes WHERE isactive=1");
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $course = $row['course'];
                                            echo (!empty($course) && $course != "")
                                                ? "<option value='$course'>$course</option>" : "";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- country getter -->
                                <div class="col-lg-2 col-md-4 col-sm-4 col-6 search-type-gap">
                                    <select id="search_country" onchange="showNotes()"
                                        class="text-hidden form-control options-arrow-down">
                                        <option value="0" selected>Select country</option>
                                        <?php
                                        $result = mysqli_query($con, "SELECT countryid,name FROM countries WHERE isactive=1");
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $country_id = $row['countryid'];
                                            $country_name = $row['name'];
                                            echo "<option value='$country_id'>$country_name</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- rattings getter -->
                                <div class="col-lg-2 col-md-4 col-sm-4 col-6 search-type-gap">
                                    <select id="search_rating" onchange="showNotes()"
                                        class="text-hidden form-control options-arrow-down">
                                        <option value="0" selected>Select rating</option>
                                        <option value="5">5</option>
                                        <option value="4">4</option>
                                        <option value="3">3</option>
                                        <option value="2">2</option>
                                        <option value="1">1</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
        function showNotes(page_current) {
            let search_str = $("#search-note-main").val();
            let search_type = $("#search_type").val();
            let search_category = $("#search_category").val();
            let search_university = $("#search_university").val();
            let search_course = $("#search_course").val();
            let search_country = $("#search_country").val();
            let search_rating = $("#search_rating").val();

            $.ajax({
                url: "ajax/search-note-ajax.php",
                method: "GET",
                data: {
                    selected_search: search_str,
                    selected_type: search_type,
                    selected_category: search_category,
                    selected_university: search_university,
                    selected_course: search_course,
                    selected_country: search_country,
                    selected_rating: search_rating,
                    page: page_current
                },
                success: function(search_data) {
                    $("#dynamic_result").html(search_data);
                }
            });
        }
        $(function() {
            showNotes(1);
        });
        </script>

        <!-- data from ajax will display in this  -->
        <div id="dynamic_result"></div>

        <!--footer-->
        <?php include "footer.php"; ?>
    </div>
    <!--footer end-->

</body>

</html>