<?php include "db.php";

if (isset($_GET['noteid']))
    $noteid = $_GET['noteid'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <!--Custom css-->
    <link rel="stylesheet" href="css/style.css">

    <!-- jsRapstar css -->
    <link rel="stylesheet" href="css/jsRapStarSmall.css">

    <!--Responsive css-->
    <link rel="stylesheet" href="css/responsive.css">

    <!--popper js-->
    <script src="js/popper/popper.min.js"></script>

    <!--jquery js-->
    <script src="js/jquery/jquery.min.js"></script>

    <!-- JsRapstar js -->
    <script src="js/jsRapStar.js"></script>

    <title>Customer Review</title>
</head>

<body>

    <div id="notes-details-reviews">
        <?php

        //count decider
        $review_decide = mysqli_query($con, "SELECT * from sellernotesreview where noteid=$noteid");
        if (mysqli_num_rows($review_decide) > 0) {

            //if has review it will execute this block
            $rate_counter = 1;
            $review_getter = mysqli_query($con, "SELECT users.firstname,users.lastname,sellernotesreview.ratings,sellernotesreview.comments,userprofile.profile_pic FROM users 
                                        LEFT JOIN sellernotesreview ON users.userid=sellernotesreview.reviewer_id 
                                        LEFT JOIN userprofile ON userprofile.userid=sellernotesreview.reviewer_id
                                        WHERE noteid=$noteid");

            while ($row = mysqli_fetch_assoc($review_getter)) {
                $rate_counter++;
                $full_name = $row['firstname'] . " " . $row['lastname'];
                $rate_val = $row['ratings'];
                $rate_cmnt = $row['comments'];
                $member_pic = $row['profile_pic'];
                $review_count = mysqli_num_rows($review_getter); ?>

        <div class="row notes-review-ender-line">

            <?php if ($review_count > 0) { ?>
            <div class="col-md-2 col-3">

                <!-- Profile-pic -->
                <?php if (empty($member_pic)) { ?>
                <img src="../Members/default/PP_default.jpg"
                    title="The honest review by our customers <?php echo $full_name ?>"
                    class="img-fluid rounded-circle img-review-setter" alt="Customer Photo <?php echo $full_name ?>">
                <?php } ?>
                <?php if ($member_pic != "") { ?>
                <img src="<?php echo $member_pic ?>" title="The honest review by our customers <?php echo $full_name ?>"
                    class="img-fluid rounded-circle img-review-setter" alt="Customer Photo <?php echo $full_name ?>">
                <?php } ?>
            </div>
            <div class="col-md-10 col-9">
                <div class="notes-details-name-rating-review">

                    <!-- full name  -->
                    <h4><?php echo $full_name ?></h4>
                    <div class="notes-details-rating">
                        <div id="<?php echo $rate_counter ?>"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-10">
                <div class="notes-details-name-rating-review">
                    <h5><?php echo $rate_cmnt ?></h5>
                </div>
            </div>
        </div>
        <?php  } ?>

        <script>
        $('#<?php echo $rate_counter ?>').jsRapStar({
            length: 5,
            starHeight: 30,
            colorFront: 'yellow',
            enabled: false,
            value: '<?php echo $rate_val ?>',
        });
        </script>

        <?php
            }
        } else {
        ?>
        <div>
            <h3 class="blue-font-24 ">No Reviews Yet!</h3>
            <h6 class="first-reviewer no-review-h6">(be the first to review it!)</h6>
        </div>
        <?php } ?>
    </div>
</body>

</html>