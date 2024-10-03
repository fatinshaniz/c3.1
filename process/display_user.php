<?php
session_start();
if (!isset($_SESSION["staffID"])) {
    echo "<script type='text/javascript'>alert('Please login first'); window.location.replace('../index.php');</script>";
}
require 'database_connection.php';
$staffID = $_POST['staffID'];
// echo $staffID;
$display_query = "SELECT *  FROM `staff` WHERE staff_ID = '$staffID'";
$results = mysqli_query($con, $display_query);
$count = mysqli_num_rows($results);
if ($count > 0) {
    $data_arr = array();
    $i = 1;
    while ($data_row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        $data_arr[$i]['staff_ID'] = $data_row['staff_ID'];
        $data_arr[$i]['staff_Name'] = $data_row['staff_Name'];
        $data_arr[$i]['staff_Email'] = $data_row['staff_Email'];
        $data_arr[$i]['staff_Password'] = $data_row['staff_Password'];
        $data_arr[$i]['staff_Department'] = $data_row['staff_Department'];
        $i++;
    }
    $data = array(
        'status' => true,
        'msg' => 'successfully!',
        'data' => $data_arr
    );
} else {
    $data = array(
        'status' => false,
        'msg' => 'Error!'
    );
}
echo json_encode($data);
