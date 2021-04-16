<?php
include "db.php";

//get id from url
$id = (isset($_GET['id'])) ? $_GET['id'] : "";
$noteid = (isset($_GET['noteid'])) ? $_GET['noteid'] : "";

//del review query
mysqli_query($con, "UPDATE sellernotesreview SET isactive=0 WHERE note_review_id=$id");

//to redirection
header("Refresh:0");
header("Location:notes-details-customer-review.php?noteid=$noteid");