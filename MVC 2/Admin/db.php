<?php

$connection = mysqli_connect('localhost', 'root', '', 'NoteMarketPlace');

//checking connection
if(!$connection) {
    echo "error" . mysqli_error();
}
?>
