<?php
include "db.php";

$id = $_GET['id'];
$id = mysqli_real_escape_string($con, $id);

$query = "UPDATE users SET isemailverified=1 WHERE userid=$id";
$update_query = mysqli_query($con, $query);
if($update_query) {
    header("Location: log-in-page.php");
} else {
    die(mysqli_error($con));
}
?>

