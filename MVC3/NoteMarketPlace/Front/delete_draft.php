<?php
include "db.php";
$id = $_GET['id'];
$id = mysqli_real_escape_string($con, $id);
$delete_note = mysqli_query($con, "UPDATE sellernotes SET isactive=0 WHERE noteid=$id");

if ($delete_note) {
    header('Location:dashboard-page.php');
} else {
    echo "Query Failed for Id=" . $id . "<br>Refresh the page<br>" . "<a href='dashboard-page.php'>dashboard</a>";
    echo "<br><br><a href='http://localhost/NotesMarketPlace/front/delete_draft.php?id=$id'>Retry!</a>";
}

?>