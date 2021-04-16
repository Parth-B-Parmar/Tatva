<?php
include "db.php";
session_start();

$login = true;
$query_insert = false;
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $loggerid = $_SESSION['loggerid'];
} else
    $login = false;

//store values in db
if (isset($_POST['submit'])) {

    // data from form
    $type_name = $_POST['type'];
    $des = $_POST['des'];

    if (isset($_GET['id'])) {
        $type_id = $_GET['id'];
        $update_type = mysqli_query($con, "UPDATE notetypes SET name='$type_name',description='$des',modifieddate=NOW(),modifiedby=$loggerid WHERE typeid=$type_id");
        header("Location:manage-type-page.php");
    } else {
        $insert_query = mysqli_query($con, "INSERT INTO notetypes(name,description,createddate,createdby,modifieddate,modifiedby,isactive) 
    VALUES('$type_name','$des',NOW(),$loggerid,NOW(),$loggerid,1)");

        $query_insert = true;
    }
}

//type data getter
if (isset($_GET['id'])) {
    $type_id = $_GET['id'];

    $type_getter = mysqli_query($con, "SELECT name,description FROM notetypes WHERE typeid=$type_id");
    while ($row = mysqli_fetch_assoc($type_getter)) {

        $new_type = $row['name'];
        $new_description = $row['description'];
    }
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

    <!--Custom css-->
    <link rel="stylesheet" href="css/style.css">

    <!--Responsive css-->
    <link rel="stylesheet" href="css/responsive.css">

</head>

<body class="sticky-header">
    <div class="above-footer">

        <!--header -->
        <?php include "header.php" ?>
        <!--header end-->

        <div id="user-profile">

            <div class="container">
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="blue-font-30 heading-margin margin-b-15">Add Type</h4>
                        </div>
                        <div class="form-group col-md-6">

                            <!-- type -->
                            <label>Type *</label>
                            <input type="text" name="type" <?php echo (isset($_GET['id'])) ? "value='$new_type'" : "" ?>
                                class="form-control input-light-color" placeholder="Enter your type" required>

                            <!-- Description -->
                            <label>Description *</label>
                            <textarea id="textaera-height" name="des" class="form-control input-light-color"
                                placeholder="Enter your description"
                                required><?php echo (isset($_GET['id'])) ? $new_description : "" ?></textarea>

                        </div>
                        <div class="col-md-12">
                            <button type="submit" name="submit"
                                class="btn btn-primary blue-button-hover-white margin-top-15">submit</button>
                            <div class="suc-msg">
                                <?php
                                if ($query_insert)
                                    echo $insert_query ? "New type $type_name has been added successfully!" : "";
                                ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--footer-->
    <?php include "footer.php"; ?>
    <!--footer end-->

    <!--popper js-->
    <script src="js/popper/popper.min.js"></script>

    <!--jquery js-->
    <script src="js/jquery/jquery.min.js"></script>

    <!--bootstrap js-->
    <script src="js/bootstrap/bootstrap.min.js"></script>

    <!--Custom Script-->
    <script src="js/script.js"></script>

</body>

</html>