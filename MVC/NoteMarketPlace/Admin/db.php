<?php
$server = "localhost";
$user = "root";
$password = "";
$database = "notesmarketplace";

$con = mysqli_connect($server, $user, $password, $database);

if (!$con) {
    die('Connect Error: ' . mysqli_connect_error());
}
