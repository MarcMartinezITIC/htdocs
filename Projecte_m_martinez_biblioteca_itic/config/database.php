<?php
$conn = mysqli_connect("localhost", "root", "", "biblioteca");
if (!$conn) {
    die("Error de connexió: " . mysqli_connect_error());
}
?>