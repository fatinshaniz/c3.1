<?php
session_start();
if (!isset($_SESSION["staffID"])) {
    echo "<script type='text/javascript'>alert('Please login first'); window.location.replace('../index.php');</script>";
}
require './database_connection.php';

$bookingName = $_POST['bookingName'];
$bookingAD = $_POST['bookingAD'];
$bookingDate = $_POST['bookingDate'];
$bookingTime = $_POST['bookingTime'];
$bookingStatus = $_POST['bookingStatus'];
$roomID = $_POST['roomID'];
$staffID = $_POST['staffID'];

// echo ($bookingName . "-" . $bookingAD . "-" . $bookingDate . "-" . $bookingTime . "-" . $bookingStatus . "-" . $roomID . "-" . $staffID);

$sql = "INSERT INTO booking (booking_Title, booking_AllDay, booking_Date, booking_Time, booking_Status, room_ID, staff_ID) VALUES ('$bookingName', $bookingAD, '$bookingDate', '$bookingTime', $bookingStatus, $roomID, '$staffID')";
if (mysqli_query($con, $sql)) {
    $data = array(
        'status' => true,
        'msg' => 'Booking added successfully!'
    );
} else {
    $data = array(
        'status' => false,
        'msg' => "Error: " . $sql . "<br>" . mysqli_error($con)
        // 'msg' => 'Sorry, Booking not added.'
    );
}
echo json_encode($data);
