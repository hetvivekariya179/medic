<?php
$conn = mysqli_connect("localhost", "root", "", "medicare");

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}
?>
