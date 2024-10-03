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
$staffPass = $_POST['staffPass'];
$staffAccess = $_POST['staffAccess'];
$hash = password_hash(
    $staffPass,
    PASSWORD_DEFAULT
);

// echo ($bookingName . "-" . $bookingAD . "-" . $bookingDate . "-" . $bookingTime . "-" . $bookingStatus . "-" . $roomID . "-" . $staffID);

$sql = "INSERT INTO `staff` (`staff_ID`, `staff_Name`, `staff_Email`, `staff_Password`, `staff_Department`, `admin_Access`) VALUES ('$staffID', '$staffName', '$staffEmail', '$hash', '$staffDept', '$staffAccess')";
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
