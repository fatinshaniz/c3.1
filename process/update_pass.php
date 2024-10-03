<?php
session_start();
if (!isset($_SESSION["staffID"])) {
    echo "<script type='text/javascript'>alert('Please login first'); window.location.replace('../index.php');</script>";
}
require './database_connection.php';


$staffID = $_POST['staffID'];
$staffPass = $_POST['staffPass'];
$currentPass = $_POST['currentPass'];
$newPass = $_POST['newPass'];
$confPass = $_POST['confPass'];


if ($newPass == $confPass) {
    if (password_verify($currentPass, $staffPass)) {
        $hash = password_hash(
            $confPass,
            PASSWORD_DEFAULT
        );
        $sql = "UPDATE `staff` SET `staff_Password` = '$hash' WHERE `staff`.`staff_ID` = '$staffID'";
        if (mysqli_query($con, $sql)) {
            $data = array(
                'status' => true,
                'msg' => 'success'
            );
        } else {
            $data = array(
                'status' => false,
                'msg' => "Error: " . $sql . "<br>" . mysqli_error($con)
            );
        }
    } else {
        $data = array(
            'status' => false,
            'msg' => "currNotSame",
        );
    }
} else {
    $data = array(
        'status' => false,
        'msg' => "passNotSame"
    );
}
echo json_encode($data);
