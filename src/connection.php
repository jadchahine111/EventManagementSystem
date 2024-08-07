<?php 
$con = mysqli_connect('localhost', 'jadchahine', 'jadali123');
if ($con) {
    mysqli_select_db($con, "evlu");
} else {
    die("Connection failed: " . mysqli_connect_error());
}
?>