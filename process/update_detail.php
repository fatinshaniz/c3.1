<?php
session_start();
if (!isset($_SESSION["staffID"])) {
    echo "<script type='text/javascript'>alert('Please login first'); window.location.replace('../index.php');</script>";
}
require './database_connection.php';

$staffID = $_POST['staffID'];
$staffName = $_POST['staffName'];
$staffDept = $_POST['staffDept'];
$staffEmail = $_POST['staffEmail'];


// echo ($bookingName . "-" . $bookingAD . "-" . $bookingDate . "-" . $bookingTime . "-" . $bookingStatus . "-" . $roomID . "-" . $staffID);

$sql = "UPDATE `staff` SET `staff_Name` = '$staffName', `staff_Email` = '$staffEmail', `staff_Department` = '$staffDept' WHERE `staff`.`staff_ID` = '$staffID'";
if (mysqli_query($con, $sql)) {
    $data = array(
        'status' => true,
        'msg' => 'success'
    );
} else {
    $data = array(
        'status' => false,
        'msg' => "Error: " . $sql . "<br>" . mysqli_error($con)
        // 'msg' => 'Sorry, Booking not added.'
    );
}
echo json_encode($data);
