<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="./css/bootstrap.min.css" />
  <script src="./js/jquery.min.js"></script>
  <script src="./js/moment.min.js"></script>
  <script src="./js/bootstrap.min.js"></script>
  <script src="./js/popper.min.js"></script>
  <script src="./js/index.global.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      margin: 40px 10px;
      padding: 0;
      font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
      font-size: 14px;
    }

    #calendar {
      max-width: 1100px;
      margin: 0 auto;
    }

    .fc-day-past {
      background: repeating-linear-gradient(-45deg,
          #FFFFFF,
          #FFFFFF 17px,
          #FCE4EC 17px,
          #FCE4EC 20px);
    }
  </style>
</head>

<body>


  <?php include "./modal/calendarModal.php" ?>
  <div id="calendar"></div>

  <script>
    var events = new Array();
    // var today = new Date();
    // var dd = String(today.getDate()).padStart(2, "0");
    // var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
    // var yyyy = today.getFullYear();
    // today = yyyy + "-" + mm + "-" + dd;
    var today = "2024-08-17";

    //start ajax block
    $.ajax({
      url: "./process/display_booking.php",
      dataType: "json",
      async: false,
      cache: false,
      success: function(res) {
        var result = res.data;
        $.each(result, function(i, item) {
          events.push({
            event_id: result[i].event_id,
            title: result[i].title,
            allDay: result[i].allDay,
            start: result[i].start,
            end: result[i].end,
            bTime: result[i].bTime,
            bStatus: result[i].bStatus,
            rID: result[i].rID,
            rName: result[i].rName,
            sID: result[i].sID,
            sName: result[i].sName,
            color: result[i].color,
            // url: result[i].url,
          });
        });
      },
      error: function(xhr, status) {
        alert(response.msg);
      },
    }); //end ajax block

    document.addEventListener("DOMContentLoaded", function() {
      var calendarEl = document.getElementById("calendar");

      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "timeGridWeek",
        timeZone: "local",
        nowIndicator: true,
        headerToolbar: {
          left: "prev,next today",
          center: "title",
          right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek",
        },
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        selectMirror: true,
        droppable: false,
        eventStartEditable: false,
        selectLongPressDelay: 1,
        validRange: {
          start: today,
        },
        eventTimeFormat: {
          hour: "numeric",
          minute: "2-digit",
          meridiem: true,
        },
        selectable: true,
        selectAllow: function(info) {
          bsa = bookingSelectAllow(info);
          console.log("Sel allow: " + bsa);
          return bookingSelectAllow(info);
        },
        select: function(info) {
          tempBool = bookingSelect(info);
          console.log(tempBool);
          arrBool = tempBool.split("-");
          console.log(arrBool[0]);
          if (arrBool[0] == "true") {
            if (arrBool[2] == "1") { // == allday
              if (arrBool[1] != "3") {
                $('#add_Room_Name').find('option').remove();
                if (arrBool[1] == "0") {
                  $('#add_Room_Name').append('<option value="1">Room 1</option>');
                  $('#add_Room_Name').append('<option value="2">Room 2</option>');
                } else if (arrBool[1] == "1") {
                  $('#add_Room_Name').append('<option value="2">Room 2</option>');
                } else if (arrBool[1] == "2") {
                  $('#add_Room_Name').append('<option value="1">Room 1</option>');
                }
                // Set value to input
                $("#add_Booking_Date").val(
                  moment(info.start).format("YYYY-MM-DD")
                );
                $("#add_Booking_Time").val("Entire Day");
                // Open modal
                $("#event_add_modal").modal("show");
              }
            } else if (arrBool[2] == "0") { // != allday
              if (arrBool[1] != "3") {
                $('#add_Room_Name').find('option').remove();
                if (arrBool[1] == "0") {
                  $('#add_Room_Name').append('<option value="1">Room 1</option>');
                  $('#add_Room_Name').append('<option value="2">Room 2</option>');
                } else if (arrBool[1] == "1") {
                  $('#add_Room_Name').append('<option value="2">Room 2</option>');
                } else if (arrBool[1] == "2") {
                  $('#add_Room_Name').append('<option value="1">Room 1</option>');
                }
                // Set value to input
                $("#add_Booking_Date").val(
                  moment(info.start).format("YYYY-MM-DD")
                );
                $("#add_Booking_Time").val(
                  moment(info.start, ["h.mm"])
                  .format("h:mmA")
                  .concat(" - ", moment(info.end, ["h.mm"]).format("h:mmA"))
                );
                // Open modal
                $("#event_add_modal").modal("show");
              }
            }
          }
        },
        allDaySlot: true,
        dayMaxEventRows: true, // allow "more" link when too many events
        events: events,
        eventClick: function(info) {

          // Show view modal
          $("#event_view_modal").modal("show");

          function clsMdl() {
            $("#event_view_modal").modal("hide");
          }

          // Set value to input
          $("#view_Booking_Name").val(info.event.title);
          $("#view_Room_Name").val(info.event.extendedProps.rName);
          $("#view_Booking_Time").val(
            moment(info.event.start, ["h.mm"])
            .format("h:mm A")
            .concat(" - ", moment(info.event.end, ["h.mm"]).format("h:mmA"))
          );
          $("#view_Booking_sName").val(info.event.extendedProps.sName);
          $("#view_Booking_Date").val(
            moment(info.event.start).format("YYYY-MM-DD dddd")
          );
        },
      });

      calendar.render();
    });

    // Start bookingSelectAllow()
    // function bookingSelectAllow(info) {
    //   console.log(info);
    //   var result = null;
    //   if ((moment(info.start).format("DD") == moment(info.end).subtract(1, "days").format("DD")) && (moment(info.start).format("YYYY-MM-DD") >= today)) {
    //     if (info.allDay == true) {
    //       longEventVal = checkForLongEvent(info);
    //       dayBookVal = checkIfDayHasBooking(info);

    //       if ((longEventVal == 0) && (dayBookVal == 0 || dayBookVal == 1 || dayBookVal == 2)) {
    //         result = true;
    //       } else if ((longEventVal == 1) && (dayBookVal == 0 || dayBookVal == 1 || dayBookVal == 2)) {
    //         result = true;
    //       } else if ((longEventVal == 2) && (dayBookVal == 0 || dayBookVal == 1 || dayBookVal == 2)) {
    //         result = true;
    //       } else if ((longEventVal == 3) && (dayBookVal == 3)) {
    //         result = false;
    //       }
    //     }
    //   } else if ((moment(info.start).format("YYYY-MM-DD") == moment(info.end).format("YYYY-MM-DD")) && (moment(info.start).format("YYYY-MM-DD") >= today)) {
    //     if (info.allDay == false) {
    //       timeClash = checkIfTimeClash(info);
    //       // console.log(timeClash);
    //       if ((timeClash == 0) || (timeClash == 1) || (timeClash == 2)) {
    //         result = true;
    //       } else if ((timeClash == 3)) {
    //         result = false;
    //       }
    //     }
    //   } else return false;
    //   return result;
    // }

    function bookingSelectAllow(info){
      var result = null;
      console.log(info);
      if ((moment(info.start).format("DD") == moment(info.end).subtract(1, "days").format("DD")) && (info.allDay == true)) { // && (moment(info.start).format("YYYY-MM-DD") >= today)
      
          longEventVal = checkForLongEvent(info);
          dayBookVal = checkIfDayHasBooking(info);

          if ((longEventVal == 0) && (dayBookVal == 0 || dayBookVal == 1 || dayBookVal == 2)) {
            result = true;
          } else if ((longEventVal == 1) && (dayBookVal == 0 || dayBookVal == 1 || dayBookVal == 2)) {
            result = true;
          } else if ((longEventVal == 2) && (dayBookVal == 0 || dayBookVal == 1 || dayBookVal == 2)) {
            result = true;
          } else if ((longEventVal == 3) && (dayBookVal == 3)) {
            result = false;
          }
        
      } else if ((moment(info.start).format("YYYY-MM-DD") == moment(info.end).format("YYYY-MM-DD")) && (info.allDay == false)) { // && (moment(info.start).format("YYYY-MM-DD") >= today)
          timeClash = checkIfTimeClash(info);
          console.log(timeClash);
          if((timeClash == 0) || (timeClash == 1) || (timeClash == 2) ){
            result = true;
          } else if((timeClash == 3)){
            result = false;
          }   
        
      } else result = false;

      return result;
    }
    // End bookingSelectAllow()

    // Start bookingSelect()
    function bookingSelect(info) {
      var result = null;
      if ((moment(info.start).format("DD") == moment(info.end).subtract(1, "days").format("DD")) && (moment(info.start).format("YYYY-MM-DD") >= today) && (info.allDay == true)) {
        longEventVal = checkForLongEvent(info);
        dayBookVal = checkIfDayHasBooking(info);
        console.log("Day" + dayBookVal);

        if (((longEventVal == 0) || (longEventVal == 1) || (longEventVal == 2) || (longEventVal == 3)) && ((dayBookVal == 0) || (dayBookVal == 1) || (dayBookVal == 2) || (dayBookVal == 3))) {
          if ((longEventVal == 3) || (dayBookVal == 3)) {
            result = "false";
          } else {
            result = "true-" + dayBookVal + "-1";
          }

        }

      } else if ((moment(info.start).format("YYYY-MM-DD") == moment(info.end).format("YYYY-MM-DD")) && (moment(info.start).format("YYYY-MM-DD") >= today && (info.allDay == false))) {
        timeClash = checkIfTimeClash(info);
        console.log(timeClash);
        if ((timeClash == 0) || (timeClash == 1) || (timeClash == 2)) {
          result = "true-" + timeClash + "-0";
        } else if ((timeClash == 3)) {
          result = "false";
        }
      } else result = "false";

      return result;
    }
    // End bookingSelect()

    // Start checkIfDayHasBooking()
    function checkIfDayHasBooking(info) {
      tempIfDayHasBooking1 = 0;
      tempIfDayHasBooking2 = 0;
      for (var key in events) {
        if (events.hasOwnProperty(key)) {
          if ((moment(events[key].start).format("YYYY-MM-DD") == (moment(info.start).format("YYYY-MM-DD"))) && (events[key].rID == 1)) {
            tempIfDayHasBooking1 = 1;
          }
          if ((moment(events[key].start).format("YYYY-MM-DD") == (moment(info.start).format("YYYY-MM-DD"))) && (events[key].rID == 2)) {
            tempIfDayHasBooking2 = 2;
          }
        }
      }

      if ((tempIfDayHasBooking1 == 1) && (tempIfDayHasBooking2 == 0)) {
        return tempIfDayHasBooking1;
      } else if ((tempIfDayHasBooking2 == 2) && (tempIfDayHasBooking1 == 0)) {
        return tempIfDayHasBooking2;
      } else if ((tempIfDayHasBooking1 + tempIfDayHasBooking2) == 3) {
        return 3;
      } else return 0;
      return tempIfDayHasBooking;
    }
    // End checkIfDayHasBooking()

    // Start checkForLongEvent()
    function checkForLongEvent(info) {
      longEventRoom1 = 0;
      longEventRoom2 = 0;
      for (var key in events) {
        if (events.hasOwnProperty(key)) {
          if ((moment(events[key].start).format("YYYY-MM-DD") == (moment(info.start).format("YYYY-MM-DD"))) && (events[key].rID == 1) && (events[key].allDay == 1)) {
            longEventRoom1 = 1;
          }
          if ((moment(events[key].start).format("YYYY-MM-DD") == (moment(info.start).format("YYYY-MM-DD"))) && (events[key].rID == 2) && (events[key].allDay == 1)) {
            longEventRoom2 = 2;
          }
        }
      }

      if (longEventRoom1 == 1 && longEventRoom2 == 0) {
        return longEventRoom1;
      } else if (longEventRoom1 == 0 && longEventRoom2 == 2) {
        return longEventRoom2;
      } else if (longEventRoom1 == 1 && longEventRoom2 == 2) {
        return 3;
      } else return 0;
    }
    // End checkForLongEvent()

    // Start checkIfTimeClash()
    // function checkIfTimeClash(info) {
    //   room1 = 0;
    //   room2 = 0;
    //   tempRoom1Start = 0;
    //   tempRoom1End = 0;
    //   tempRoom2Start = 0;
    //   tempRoom2End = 0;
    //   tempCount1 = 0;
    //   tempCount1 = 0;

    //   for (var key in events) {
    //     if (events.hasOwnProperty(key)) {
    //       if ((moment(events[key].start).format("YYYY-MM-DD") == (moment(info.start).format("YYYY-MM-DD"))) && (events[key].rID == 1) && moment(events[key].start).format("HH:mm") == (moment(info.start).format("HH:mm")) && (moment(events[key].end).format("HH:mm") == (moment(info.end).format("HH:mm")))) {
    //           room1 = 1;
    //           if (events[key].allDay == 1) {
    //             console.log("BBBB");
    //             room1 = 1;
    //           } else if (events[key].allDay == 0) {
    //             console.log("CCCC");
    //             if ((events[key].bTime != "")) {
    //               console.log("DDDD");
    //               if ((((moment(info.start).format("HH:mm")) <= (moment(events[key].end).format("HH:mm"))) && ((moment(info.end).format("HH:mm")) >= (moment(events[key].start).format("HH:mm")))) == 1) {
    //                 console.log("EEEE");
    //                 room1 = 1;
    //                 if (((moment(info.end).format("HH:mm")) == (moment(events[key].start).format("HH:mm"))) || ((moment(info.start).format("HH:mm")) == (moment(events[key].end).format("HH:mm")))) {
    //                   console.log("FFFF");
    //                   room1 = 0;
    //                 }
    //               } else if(1){ // check all (beginning time - end time) room 1 for clash

    //               }
    //             } else {
    //               console.log("GGGG");
    //               room1 = 0;
    //             }
    //           }
    //       } 
    //        if ((moment(events[key].start).format("YYYY-MM-DD") == (moment(info.start).format("YYYY-MM-DD"))) && (events[key].rID == 2) && moment(events[key].start).format("HH:mm") == (moment(info.start).format("HH:mm")) && (moment(events[key].end).format("HH:mm") == (moment(info.end).format("HH:mm")))) {
    //         if (events[key].allDay == 1) {
    //           room2 = 2;
    //         } else if (events[key].allDay == 0) {
    //           if ((events[key].bTime != "")) {
    //             if ((((moment(info.start).format("HH:mm")) <= (moment(events[key].end).format("HH:mm"))) && ((moment(info.end).format("HH:mm")) >= (moment(events[key].start).format("HH:mm")))) == 1) {
    //               room2 = 2;
    //               if (((moment(info.end).format("HH:mm")) == (moment(events[key].start).format("HH:mm"))) || ((moment(info.start).format("HH:mm")) == (moment(events[key].end).format("HH:mm")))) {
    //                 room2 = 0;
    //               }
    //             }
    //           } else {
    //             room2 = 0;
    //           }
    //         }
    //       }
    //     }
    //   }
    //   if (room1 == 1 && room2 == 0) {
    //     return room1;
    //   } else if (room2 == 2 && room1 == 0) {
    //     return room2;
    //   } else if (room1 == 1 && room2 == 2) {
    //     return 3;
    //   } else return 0;
    // }

    function checkIfTimeClash(info) {
            room1 = 0;
            room2 = 0;
            for (var key in events) {
              if (events.hasOwnProperty(key)) {
                if ((moment(events[key].start).format("YYYY-MM-DD") == (moment(info.start).format("YYYY-MM-DD"))) && (events[key].rID == 1)) {
                  if (events[key].allDay == 1) {
                    room1 = 1;
                  } else if (events[key].allDay == 0) {
                    if ((events[key].bTime != "")) {
                      if ((((moment(info.start).format("HH:mm")) <= (moment(events[key].end).format("HH:mm"))) && ((moment(info.end).format("HH:mm")) >= (moment(events[key].start).format("HH:mm")))) == 1) {
                        room1 = 1;
                        if (((moment(info.end).format("HH:mm")) == (moment(events[key].start).format("HH:mm"))) || ((moment(info.start).format("HH:mm")) == (moment(events[key].end).format("HH:mm")))) {
                          room1 = 0;
                        }
                      }
                    } else {
                      room1 = 0;
                    }
                  }
                } else if ((moment(events[key].start).format("YYYY-MM-DD") == (moment(info.start).format("YYYY-MM-DD"))) && (events[key].rID == 2)) {
                  if (events[key].allDay == 1) {
                    room2 = 2;
                  } else if (events[key].allDay == 0) {
                    if ((events[key].bTime != "")) {
                      if ((((moment(info.start).format("HH:mm")) <= (moment(events[key].end).format("HH:mm"))) && ((moment(info.end).format("HH:mm")) >= (moment(events[key].start).format("HH:mm")))) == 1) {
                        room2 = 2;
                        if (((moment(info.end).format("HH:mm")) == (moment(events[key].start).format("HH:mm"))) || ((moment(info.start).format("HH:mm")) == (moment(events[key].end).format("HH:mm")))) {              
                          room2 = 0;
                        }
                      }
                    } else {
                      room2 = 0;
                    }
                  }
                }
              }
            }
            if (room1 == 1 && room2 == 0) {
              return room1;
            } else if (room2 == 2 && room1 == 0) {
              return room2;
            } else if (room1 == 1 && room2 == 2) {
              return 3;
            } else return 0;
            // return result;
          }
    // End checkIfTimeClash()


    $("#addBookingBtn").on('click', function(e) {
      e.preventDefault();
      var a = $(this).val();

      var bookingName = $("#add_Booking_Name").val();
      var bookingDate = $("#add_Booking_Date").val();
      bookingDate = moment(bookingDate).format("YYYY-MM-DD");
      var bookingTime = $("#add_Booking_Time").val();
      var bookingAD = 0;
      var bookingStatus = 1;
      var roomID = $("#add_Room_Name").val();
      var staffID = "HL00176";

      if (bookingTime == "Entire Day") {
        bookingAD = 1;
        bookingTime = "";
      } else {
        bookingAD = 0;
        var temp = bookingTime.split(" - ");
        // console.log(temp);
        tempTime1 = moment(temp[0], "h:mmA").format("HH:mm");
        tempTime2 = moment(temp[1], "h:mmA").format("HH:mm");
        bookingTime = tempTime1 + "-" + tempTime2;
      }

      // console.log(bookingName + "-" + bookingAD + "-" + bookingDate + "-" + bookingTime + "-" + bookingStatus + "-" + roomID + "-" + staffID);
      // var staffID = $("#add_Booking_sID").val();
      // if (bookingName == "" || bookingDate == "" || bookingAD == "" || staffID == "" || roomID == "") {
      //     alert("Please enter all required details.");
      //     return false;
      // }
      // $.ajax({
      //   url: './process/save_booking.php',
      //   type: 'POST',
      //   data: {
      //     bookingName: bookingName,
      //     bookingAD: bookingAD,
      //     bookingDate: bookingDate,
      //     bookingTime: bookingTime,
      //     bookingStatus: bookingStatus,
      //     roomID: roomID,
      //     staffID: staffID,
      //   },
      //   success: function(data) {
      //     $("#event_add_modal").modal("hide");
      //     Swal.fire({
      //       title: "Success",
      //       text: "Booking has been confirmed",
      //       toast: true,
      //       position: 'top-end',
      //       icon: 'success',
      //       color: "#ffff",
      //       background: "#9CCC65",
      //       iconColor: 'white',
      //       showConfirmButton: false,
      //       timer: 3500,
      //       timerProgressBar: true,
      //     })
      //     // alert("Successully add ");
      //     setTimeout(function() {
      //       location.reload();
      //     }, 3500);
      //   }
      // });


    });


    // window.addEventListener('load', function() {
    //   var xhr = null;

    //   getXmlHttpRequestObject = function() {
    //     if (!xhr) {
    //       // Create a new XMLHttpRequest object 
    //       xhr = new XMLHttpRequest();
    //     }
    //     return xhr;
    //   };

    //   updateLiveData = function() {
    //     var now = new Date();
    //     // Date string is appended as a query with live data 
    //     // for not to use the cached version 
    //     var url = './timegrid-views.php?' + now.getTime();
    //     xhr = getXmlHttpRequestObject();
    //     xhr.onreadystatechange = evenHandler;
    //     // asynchronous requests
    //     xhr.open("GET", url, true);
    //     // Send the request over the network
    //     xhr.send(null);
    //   };

    //   updateLiveData();

    //   function evenHandler() {
    //     // Check response is ready or not
    //     if (xhr.readyState == 4 && xhr.status == 200) {
    //       dataDiv = document.getElementById('calendar');
    //       // Set current data text
    //       dataDiv.innerHTML = xhr.responseText;
    //       // Update the live data every 1 sec
    //       setTimeout(updateLiveData(), 10000);
    //     }
    //   }
    // });
  </script>
</body>

</html>