<?php
session_start();
if (!isset($_SESSION["staffID"])) {
	echo "<script type='text/javascript'>alert('Please login first'); window.location.replace('../index.php');</script>";
}
require 'database_connection.php';
$display_query = "SELECT b.booking_ID, b.booking_Title, b.booking_AllDay, b.booking_Date, b.booking_Time, b.booking_Status, r.room_ID, r.room_Name, s.staff_ID ,s.staff_Name  FROM `staff`AS s JOIN `booking` AS b ON s.staff_ID = b.staff_ID JOIN `room` AS r ON b.room_ID = r.room_ID WHERE b.booking_Status = 1";
$results = mysqli_query($con, $display_query);
$count = mysqli_num_rows($results);
if ($count > 0) {
	$data_arr = array();
	$i = 1;
	while ($data_row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {

		// Split Time Into Start & End
		$time = $data_row['booking_Time'];
		$tArray = explode('-', $time);

		// Set colour for each room
		$color = null;
		if ($data_row['room_Name'] == "Room 1") {
			$color = "#80C44F";
		} else {
			$color = "#F17B2E";
		}

		// Convert allDay (integer) to boolean
		$bookingAD = null;
		if ($data_row['booking_AllDay'] == 0) {
			$bookingAD = false;
			$data_arr[$i]['start'] = ($data_row['booking_Date']) . "T" . $tArray[0] . ":00";
			$data_arr[$i]['end'] = ($data_row['booking_Date']) . "T" . $tArray[1] . ":00";
		} else {
			$bookingAD = true;
			$data_arr[$i]['start'] = ($data_row['booking_Date']);
			$data_arr[$i]['end'] = null;
		}
		$data_arr[$i]['event_id'] = $data_row['booking_ID'];
		$data_arr[$i]['title'] = $data_row['booking_Title'];
		// $data_arr[$i]['start'] = date("Y-m-d", strtotime($data_row['booking_Date']));
		// $data_arr[$i]['end'] = date("Y-m-d", strtotime($data_row['booking_Date']));
		$data_arr[$i]['allDay'] = $bookingAD;
		$data_arr[$i]['bTime'] = $data_row['booking_Time'];
		$data_arr[$i]['bStatus'] = $data_row['booking_Status'];
		$data_arr[$i]['rID'] = $data_row['room_ID'];
		$data_arr[$i]['rName'] = $data_row['room_Name'];
		$data_arr[$i]['sID'] = $data_row['staff_ID'];
		$data_arr[$i]['sName'] = $data_row['staff_Name'];
		$data_arr[$i]['color'] = $color;
		// $data_arr[$i]['end'] = date("Y-m-d", strtotime($data_row['event_end_date']));
		// $data_arr[$i]['color'] = '#'.substr(uniqid(),-6); // 'green'; pass colour name
		// $data_arr[$i]['url'] = "#";
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
