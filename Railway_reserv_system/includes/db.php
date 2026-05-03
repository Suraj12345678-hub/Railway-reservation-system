<?php
$host = "127.0.0.1:3309";
$user = "root";
$pass = "";
$dbname = "rail_db";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>