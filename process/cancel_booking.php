<?php
session_start();
if (!isset($_SESSION["staffID"])) {
    echo "<script type='text/javascript'>alert('Please login first'); window.location.replace('../index.php');</script>";
}
require './database_connection.php';

$bookingID = $_POST['bookingID'];

// echo ($bookingName . "-" . $bookingAD . "-" . $bookingDate . "-" . $bookingTime . "-" . $bookingStatus . "-" . $roomID . "-" . $staffID);
$sql = "UPDATE `booking` SET `booking_Status` = '0' WHERE `booking`.`booking_ID` = '$bookingID'";
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
