<?php
include "db.php";
session_start();

//value get from session
$login = true;
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $loggerid = $_SESSION['loggerid'];
} else
    $login = false;

//deactive the country
if (isset($_POST['popup_submit'])) {
    $countryid = $_POST['popup_id'];

    //modify the country table to inactive the country
    $deactive_country = mysqli_query($con, "UPDATE countries SET isactive=0 WHERE countryid=$countryid");
    header("Location:manage-country-page.php");
}

//log-in failed
if (!$login) { ?>
<script>
alert("Please sign in/register to gain access to this page\npressing OK you will be redirect to login page");
window.location.replace("log-in-page.php");
</script>
<?php } ?>

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

    <!--Font-Awesome-->
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">

    <!--bootstrap css-->
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">

    <!-- data table css -->
    <link rel="stylesheet" href="css/datatables.min.css">

    <!--Custom css-->
    <link rel="stylesheet" href="css/style.css">

    <!--Responsive css-->
    <link rel="stylesheet" href="css/responsive.css">

    <!--popper js-->
    <script src="js/popper/popper.min.js"></script>

    <!--jquery js-->
    <script src="js/jquery/jquery.min.js"></script>

    <!--bootstrap js-->
    <script src="js/bootstrap/bootstrap.min.js"></script>

    <!-- data table js -->
    <script src="js/datatables.min.js"></script>

</head>

<body class="sticky-header">

    <div class="above-footer">

        <!--header -->
        <?php include "header.php" ?>
        <!--header end-->

        <div class="container">
            <div class="row">
                <div class="col-md-12 column-padding-remover">
                    <h4 class="blue-font-30 heading-margin">Manage Country</h4>
                </div>
                <div class="col-md-6 column-padding-remover">
                    <a role="button" href="add-country-page.php" type="submit"
                        class="btn btn-primary blue-button-hover-white margin-top-15">add
                        country</a>
                </div>
                <div class="col-md-2"></div>
                <div id="dashboard-search-btn-2" class="col-md-4 column-padding-remover margin-top-15">
                    <div class="dashboard-search-jointer">
                        <input type="text" id="search_data" class="form-control dashboard-search-icon search-icon"
                            placeholder="&#xf002; Search">
                        <button class="btn btn-primary blue-button-hover-white" onclick="showData()">search</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ajax call -->
        <script>
        function showData() {

            let search_string = $("#search_data").val();
            $.ajax({
                url: "ajax/manage-country-ajax.php",
                method: "GET",
                data: {
                    search: search_string,
                },
                success: function(result) {
                    $("#country_data").html(result);
                }
            });
        }
        showData();
        </script>

        <!-- data will display here -->
        <div id="country_data"></div>

    </div>

    <!--footer-->
    <?php include "footer.php"; ?>
    <!--footer end-->

    <!--Custom Script-->
    <script src="js/script.js"></script>

</body>

</html>