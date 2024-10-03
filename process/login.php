<?php
session_start();
require './database_connection.php';

$staffID = $_POST['staffID'];
$staffPass = $_POST['staffPass'];

$display_query = "SELECT * FROM staff WHERE staff_ID = '$staffID'";
$results = mysqli_query($con, $display_query);
$count = mysqli_num_rows($results);
if ($count > 0) {
    $staffID = "";
    $staffLvl = "";
    $hash = "";
    while ($data_row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        $staffID = $data_row['staff_ID'];
        $hash = $data_row['staff_Password'];
        $staffLvl = $data_row['admin_Access'];
    }
    $verify = password_verify($staffPass, $hash);
    if ($verify) {
        $_SESSION["staffID"] = $staffID;
        if ($staffLvl == 1) {
            $_SESSION["userAccess"] = "userAdmin.php";
        } else {
            $_SESSION["userAccess"] = "user.php";
        }
        $data = array(
            'status' => true,
            'msg' => 'successful',
        );
    } else {
        $data = array(
            'status' => false,
            'msg' => 'Error!'
        );
    }
} else {
    $data = array(
        'status' => false,
        'msg' => 'Error!'
    );
}
echo json_encode($data);
