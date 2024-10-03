<?php
session_start();
if (!isset($_SESSION["staffID"])) {
    echo "<script type='text/javascript'>alert('Please login first'); window.location.replace('../index.php');</script>";
}
require './database_connection.php';

$staffID = $_POST['staffID'];
$staffPass = $_POST['staffPass'];
$hash = password_hash(
    $staffPass,
    PASSWORD_DEFAULT
);

$display_query = "SELECT * FROM `staff` WHERE `staff`.`staff_ID` = '$staffID'";
$results = mysqli_query($con, $display_query);
$count = mysqli_num_rows($results);
if ($count > 0) {
    $sql = "UPDATE `staff` SET `staff_Password` = '$hash' WHERE `staff`.`staff_ID` = '$staffID'";
    if (mysqli_query($con, $sql)) {
        $data = array(
            'status' => true,
            'msg' => 'success'
        );
    }
} else {
    $data = array(
        'status' => false,
        // 'msg' => "Error: " . $sql . "<br>" . mysqli_error($con)
        // 'msg' => 'Sorry, Booking not added.'
    );
}


echo json_encode($data);
