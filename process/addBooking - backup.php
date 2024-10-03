<?php
require 'database_connection.php';
$data_arr = array();

// $bookingName = $_POST['bookingName'];
// $bookingAD = $_POST['bookingAD'];
// $bookingDate = $_POST['bookingDate'];
// $bookingTime = $_POST['bookingTime'];
// $bookingStatus = $_POST['bookingStatus'];
// $roomID = $_POST['roomID'];
// $staffID = $_POST['staffID'];


// Get booking data
$sql = "SELECT b.booking_ID, b.booking_Title, b.booking_AllDay, b.booking_Date, b.booking_Time, b.booking_Status, r.room_ID, r.room_Name, s.staff_ID ,s.staff_Name  FROM `staff`AS s JOIN `booking` AS b ON s.staff_ID = b.staff_ID JOIN `room` AS r ON b.room_ID = r.room_ID WHERE b.booking_Status = 1 ORDER BY b.booking_ID ASC";

$result = $con->query($sql);
if ($result->num_rows > 0) {
    // OUTPUT DATA OF EACH ROW 
    $i = 0;
    while ($data_row = $result->fetch_assoc()) {
        // Split Time Into Start & End
        $time = $data_row['booking_Time'];
        $tArray = explode('-', $time);

        // Set colour for each room
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
        $data_arr[$i]['time'] = $data_row['booking_Time'];
        $data_arr[$i]['bDate'] = $data_row['booking_Date'];
        $data_arr[$i]['allDay'] = $data_row['booking_AllDay'];
        $data_arr[$i]['bStatus'] = $data_row['booking_Status'];
        $data_arr[$i]['rID'] = $data_row['room_ID'];
        $data_arr[$i]['rName'] = $data_row['room_Name'];
        $data_arr[$i]['sID'] = $data_row['staff_ID'];
        $data_arr[$i]['sName'] = $data_row['staff_Name'];
        $i++;
    }
}

$length = count($data_arr);

// Testing data
$testDate = "2024-08-18";
$testTime = "";
$testAD = 1;
$testRoom = 1;
// Testing data

function checkForLongEvent($arr, $length, $date, $room){
    $tempHasLongEvent = 0;
    for ($i = 0; $i < $length; $i++) {
        if($date == $arr[$i]['bDate']){
            if($arr[$i]['allDay'] == 1){
                if($room == $arr[$i]['rID']){
                    $tempHasLongEvent = 1;
                }
            }    
        }
    }
    return $tempHasLongEvent;
}

function checkIfDayHasBooking($arr, $length, $date, $time, $room, $allDay){
    $tempIfDayHasBooking = 0;
    for ($i = 0; $i < $length; $i++) {
        if($date == $arr[$i]['bDate']){
            // if($arr[$i]['allDay'] == 0){
                if($room == $arr[$i]['rID']){
                    if($allDay == 0){
                        if($arr[$i]['time'] == ""){
                            $tempIfDayHasBooking = 1;
                        }
                    } else {
                        if($arr[$i]['time'] != ""){
                            $tempIfDayHasBooking = 1;
                        }
                    }
                   
                } 
            // }    
        }
    }
    return $tempIfDayHasBooking;
}

function checkIfTimeClash($arr, $length, $date, $time, $room, $allDay){
    $result = 2;
    $arrTime = explode("-", $time);
    for ($i = 0; $i < $length; $i++) {
       if(($date == $arr[$i]['bDate']) && ($room == $arr[$i]['rID'])){
            if($room == 1 && $arr[$i]['rID'] == 1){
                if($allDay == 1){
                    $result = 1;
                } else if($allDay == 0){
                    if($time != "" && $arr[$i]['time'] != ""){
                        $arrDBTime = explode("-", $arr[$i]['time']);
                       
                        if(($arrTime[0] <= $arrDBTime[1]) && ($arrTime[1] >= $arrDBTime[0]) == 1){
                            $result = 1;
                            echo "aaaa";
                            if($arrTime[1] == $arrDBTime[0] || $arrTime[0] == $arrDBTime[1]){
                                $result = 0;
                            }
                        } else $result = 0;
                    } else {
                        $result = 0;
                    }
                }
            } 
            else if($room == 2 && $arr[$i]['rID'] == 2){
                if($allDay == 1){
                    $result = 1;
                } else if($allDay == 0){
                    if($time != "" && $arr[$i]['time'] != ""){
                        $arrDBTime = explode("-", $arr[$i]['time']);
                        if(($arrTime[0] <= $arrDBTime[1]) && ($arrTime[1] >= $arrDBTime[0]) == 1){
                            $result = 1;
                            if($arrTime[1] == $arrDBTime[0] || $arrTime[0] == $arrDBTime[1]){
                                $result = 0;
                            }
                        }  else $result = 0;
                    } else {
                        $result = 0;
                    }
                }
            }
        }
    }
    return $result;
}

$bookResult = 0;
if($testAD == 1){
    if((checkForLongEvent($data_arr, $length, $testDate, $testRoom) == 0) && (checkIfDayHasBooking($data_arr, $length, $testDate, $testTime, $testRoom, $testAD) == 0)){
        $bookResult = 1;
    }
    else {
        $bookResult = 0;
    }
} else if ($testAD == 0){
    if(checkIfTimeClash($data_arr, $length, $testDate, $testTime, $testRoom, $testAD) == 0){
        $bookResult = 1;
    } else {
        $bookResult = 0;
    }
    // for ($i = 0; $i < $length; $i++) {
    //     if($testDate == $data_arr[$i]['bDate']){
    //         echo "1111";
    //         // $data_arr[$i]['time'] != ""
    //         if($testRoom == 1){
    //             // echo "Room 1";
    //             if((checkForLongEvent($data_arr, $length, $testDate, $testRoom) == 0) && (checkIfTimeClash($testTime, $length, $testDate, $testTime, $testRoom, $testAD) == 0)){
    //                 $book = 1;
    //             }
    //         } else {
    //             // echo "Room 2";
    //         }
    //         // echo "ini";
    //     }
    // }
}

if($bookResult == 1){
    echo "Can book room"; 
} else if($bookResult == 0){
    echo "Cannot book room";
}


// Check for time conflict for long event
// if ($bookingAD == 1) {
//     $sql = "SELECT * FROM `booking` WHERE `booking_Date` = $bookingDate AND `room_ID` = $roomID  AND `booking_AllDay` = $bookingAD AND `booking_Status` = $bookingStatus";
// } else { // Check for time conflict for every hour for each room
//     $sql = "SELECT * FROM `booking` WHERE `booking_Date` = $bookingDate AND `room_ID` = $roomID  AND `booking_AllDay` = $bookingAD AND `booking_Status` = $bookingStatus";
// }
// $sql = "INSERT INTO `booking` (`booking_Title`, `booking_AllDay`, `booking_Date`, `booking_Time`, `booking_Status`, `room_ID`, `staff_ID`) VALUES ($bookingName, $bookingAD, $bookingDate, $bookingTime, $bookingStatus, $roomID, $staffID))";
// if ($con->query($sql) === TRUE) {
//     echo "data inserted";
// } else {
//     echo "failed";
// }
