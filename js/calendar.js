var events = new Array();
var today = new Date();
var dd = String(today.getDate()).padStart(2, "0");
var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
var yyyy = today.getFullYear();
today = yyyy + "-" + mm + "-" + dd;
// var today = "2024-08-17";

//start ajax block
$.ajax({
  url: "./process/display_booking.php",
  dataType: "json",
  async: false,
  cache: false,
  success: function (res) {
    var result = res.data;
    $.each(result, function (i, item) {
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
      });
    });
  },
  error: function (xhr, status) {
    alert(response.msg);
  },
}); //end ajax block

document.addEventListener("DOMContentLoaded", function () {
  var calendarEl = document.getElementById("calendar");

  var calendar = new FullCalendar.Calendar(calendarEl, {
    themeSystem: "bootstrap5",
    initialView: "timeGridWeek",
    timeZone: "local",
    nowIndicator: true,
    headerToolbar: {
      left: "prev,next today",
      center: "title",
      right:
        "addRoom1Button,addRoom2Button dayGridMonth,timeGridWeek,timeGridDay,listWeek",
    },
    customButtons: {
      addRoom1Button: {
        text: "Room 1",
        click: function () {
          $("#roomBtnVal").val("1");
        },
      },
      addRoom2Button: {
        text: "Room 2",
        click: function () {
          $("#roomBtnVal").val("2");
        },
      },
    },
    navLinks: true, // can click day/week names to navigate views
    editable: false,
    selectMirror: true,
    droppable: false,
    eventStartEditable: false,
    selectLongPressDelay: 1,
    // validRange: {
    //   start: today,
    // },
    eventTimeFormat: {
      hour: "numeric",
      minute: "2-digit",
      meridiem: true,
    },
    selectable: true,
    selectAllow: function (info) {
      return bookingSelectAllow(info);
    },
    select: function (info) {
      tempBool = bookingSelect(info);
      arrBool = tempBool.split("-");
      if (arrBool[0] == "true") {
        if (arrBool[2] == "1") {
          // == allday
          if (arrBool[1] != "3") {
            $("#add_Room_Name").find("option").remove();
            $("#add_Room_Name").attr("disabled", false);
            if (arrBool[1] == "0") {
              $("#add_Room_Name").append('<option value="1">Room 1</option>');
              $("#add_Room_Name").append('<option value="2">Room 2</option>');
            } else if (arrBool[1] == "1") {
              $("#add_Room_Name").append('<option value="2">Room 2</option>');
            } else if (arrBool[1] == "2") {
              $("#add_Room_Name").append('<option value="1">Room 1</option>');
            }

            // Set value to input
            $("#add_Booking_Date").val(moment(info.start).format("YYYY-MM-DD"));
            $("#add_Booking_Time").val("Entire Day");
            // Open modal
            $("#event_add_modal").modal("show");
          }
        } else if (arrBool[2] == "0") {
          // != allday
          $("#add_Room_Name").find("option").remove();
          $("#add_Room_Name").attr("disabled", true);
          if ($("#roomBtnVal").val() == "1") {
            $("#add_Room_Name").append('<option value="1">Room 1</option>');
          } else if ($("#roomBtnVal").val() == "2") {
            $("#add_Room_Name").append('<option value="2">Room 2</option>');
          }

          // Set value to input
          $("#add_Booking_Date").val(moment(info.start).format("YYYY-MM-DD"));
          $("#add_Booking_Time").val(
            moment(info.start)
              .format("hh:mm A")
              .concat(" - ", moment(info.end).format("hh:mm A"))
          );
          // Open modal
          $("#event_add_modal").modal("show");
        }
      }
    },
    allDaySlot: true,
    dayMaxEventRows: true, // allow "more" link when too many events
    events: events,
    eventClick: function (info) {
      console.log(info);
      // Show view modal
      if (chechkUserView(events, info) == true) {
        $("#event_update_modal").modal("show");
        $("#update_Booking_Name").val(info.event.title);
        $("#update_Room_Name").val(info.event.extendedProps.rName);
        if (info.event.allDay == 0) {
          $("#update_Booking_Time").val(
            moment(info.event.start, ["h.mm"])
              .format("h:mm A")
              .concat(" - ", moment(info.event.end, ["h.mm"]).format("h:mm A"))
          );
        } else {
          $("#update_Booking_Time").val("Entire Day");
        }
        $("#update_Booking_sName").val(info.event.extendedProps.sName);
        $("#update_Booking_Date").val(
          moment(info.event.start).format("YYYY-MM-DD dddd")
        );
        $("#update_Booking_ID").val(info.event.extendedProps.event_id);
      } else {
        $("#event_view_modal").modal("show");
        // Set value to input
        $("#view_Booking_Name").val(info.event.title);
        $("#view_Room_Name").val(info.event.extendedProps.rName);
        if (info.event.allDay == 0) {
          $("#view_Booking_Time").val(
            moment(info.event.start, ["h.mm"])
              .format("h:mm A")
              .concat(" - ", moment(info.event.end, ["h.mm"]).format("h:mm A"))
          );
        } else {
          $("#view_Booking_Time").val("Entire Day");
        }
        $("#view_Booking_sName").val(info.event.extendedProps.sName);
        $("#view_Booking_Date").val(
          moment(info.event.start).format("YYYY-MM-DD dddd")
        );
      }
    },
  });

  calendar.render();
});

function chechkUserView(events, info) {
  arrTextSplit = info.el.innerText.split("\n");
  arrTimeSplit = arrTextSplit[0].split(" - ");
  infoTime = moment(arrTimeSplit[0], "hh:mm A")
    .format("HH:mm")
    .concat("-", moment(arrTimeSplit[1], "hh:mm A").format("HH:mm"));
  tempEdit = false;

  for (var key in events) {
    if (events.hasOwnProperty(key)) {
      if (
        events[key].allDay == 0 &&
        info.event._def.allDay == 0 &&
        events[key].sID == tempSID &&
        moment(info.el.fcSeg.start).format("YYYY-MM-DD") ==
          moment(events[key].start).format("YYYY-MM-DD") &&
        moment(info.el.fcSeg.start).format("YYYY-MM-DD") >= today &&
        events[key].bTime == infoTime &&
        info.event.extendedProps.rID == events[key].rID
      ) {
        tempEdit = true;
      } else if (
        events[key].allDay == 1 &&
        info.event._def.allDay == 1 &&
        events[key].sID == tempSID &&
        moment(info.el.fcSeg.eventRange.range.start).format("YYYY-MM-DD") ==
          moment(events[key].start).format("YYYY-MM-DD") &&
        moment(info.el.fcSeg.eventRange.range.start).format("YYYY-MM-DD") >=
          today &&
        events[key].bTime == "" &&
        info.event.extendedProps.rID == events[key].rID
      ) {
        tempEdit = true;
      }
    }
  }
  return tempEdit;
}

function bookingSelectAllow(info) {
  var result = null;
  if (
    moment(info.start).format("DD") ==
      moment(info.end).subtract(1, "days").format("DD") &&
    info.allDay == true
  ) {
    // && (moment(info.start).format("YYYY-MM-DD") >= today)

    longEventVal = checkForLongEvent(info);
    dayBookVal = checkIfDayHasBooking(info);

    if (
      longEventVal == 0 &&
      (dayBookVal == 0 || dayBookVal == 1 || dayBookVal == 2)
    ) {
      result = true;
    } else if (
      longEventVal == 1 &&
      (dayBookVal == 0 || dayBookVal == 1 || dayBookVal == 2)
    ) {
      result = true;
    } else if (
      longEventVal == 2 &&
      (dayBookVal == 0 || dayBookVal == 1 || dayBookVal == 2)
    ) {
      result = true;
    } else if (longEventVal == 3 && dayBookVal == 3) {
      result = false;
    }
  } else if (
    moment(info.start).format("YYYY-MM-DD") ==
      moment(info.end).format("YYYY-MM-DD") &&
    info.allDay == false
  ) {
    timeClash = checkIfTimeClash(info);
    if (timeClash == 0 || timeClash == 1 || timeClash == 2) {
      result = true;
    } else if (timeClash == 3) {
      result = false;
    }
  } else result = false;

  return result;
}
// End bookingSelectAllow()

// Start bookingSelect()
function bookingSelect(info) {
  var result = null;
  if (
    moment(info.start).format("DD") ==
      moment(info.end).subtract(1, "days").format("DD") &&
    moment(info.start).format("YYYY-MM-DD") >= today &&
    info.allDay == true
  ) {
    longEventVal = checkForLongEvent(info);
    dayBookVal = checkIfDayHasBooking(info);
    if (
      (longEventVal == 0 ||
        longEventVal == 1 ||
        longEventVal == 2 ||
        longEventVal == 3) &&
      (dayBookVal == 0 || dayBookVal == 1 || dayBookVal == 2 || dayBookVal == 3)
    ) {
      if (longEventVal == 3 || dayBookVal == 3) {
        result = "false";
      } else {
        result = "true-" + dayBookVal + "-1";
      }
    }
  } else if (
    moment(info.start).format("YYYY-MM-DD") ==
      moment(info.end).format("YYYY-MM-DD") &&
    moment(info.start).format("YYYY-MM-DD") >= today &&
    info.allDay == false
  ) {
    timeClash = checkIfTimeClash(info);
    if (timeClash == 0 || timeClash == 1 || timeClash == 2) {
      result = "true-" + timeClash + "-0";
    } else if (timeClash == 3) {
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
      if (
        moment(events[key].start).format("YYYY-MM-DD") ==
          moment(info.start).format("YYYY-MM-DD") &&
        events[key].rID == 1
      ) {
        tempIfDayHasBooking1 = 1;
      }
      if (
        moment(events[key].start).format("YYYY-MM-DD") ==
          moment(info.start).format("YYYY-MM-DD") &&
        events[key].rID == 2
      ) {
        tempIfDayHasBooking2 = 2;
      }
    }
  }

  if (tempIfDayHasBooking1 == 1 && tempIfDayHasBooking2 == 0) {
    return tempIfDayHasBooking1;
  } else if (tempIfDayHasBooking2 == 2 && tempIfDayHasBooking1 == 0) {
    return tempIfDayHasBooking2;
  } else if (tempIfDayHasBooking1 + tempIfDayHasBooking2 == 3) {
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
      if (
        moment(events[key].start).format("YYYY-MM-DD") ==
          moment(info.start).format("YYYY-MM-DD") &&
        events[key].rID == 1 &&
        events[key].allDay == 1
      ) {
        longEventRoom1 = 1;
      }
      if (
        moment(events[key].start).format("YYYY-MM-DD") ==
          moment(info.start).format("YYYY-MM-DD") &&
        events[key].rID == 2 &&
        events[key].allDay == 1
      ) {
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
function checkIfTimeClash(info) {
  result = 3;
  room1 = 0;
  room2 = 0;
  tempText = "";
  btnValRoom = $("#roomBtnVal").val();
  for (let i = 0; i < events.length; i++) {
    input = new Date(moment(events[i].start).format("YYYY-MM-DD"));
    db = new Date(moment(info.start).format("YYYY-MM-DD"));
    diffTime = input.getTime() - db.getTime();
    diffDays = Math.round(diffTime / (1000 * 3600 * 24));
    if (diffDays == 0) {
      if (
        diffDays == 0 &&
        btnValRoom == 1 &&
        events[i].rID == 1 &&
        moment(events[i].start).format("YYYY-MM-DD") ==
          moment(info.start).format("YYYY-MM-DD")
      ) {
        if (
          moment(info.start).format("HH:mm") != "" &&
          moment(events[i].start).format("HH:mm") != ""
        ) {
          if (
            moment(info.start).format("HH:mm") <=
              moment(events[i].end).format("HH:mm") &&
            moment(info.end).format("HH:mm") >=
              moment(events[i].start).format("HH:mm")
          ) {
            tempText += "a";
            room1 = 1;
            if (
              moment(info.end).format("HH:mm") ==
                moment(events[i].start).format("HH:mm") ||
              moment(info.start).format("HH:mm") ==
                moment(events[i].end).format("HH:mm")
            ) {
              tempText += "b,";
              room1 = 0;
            }
          }
        } else {
          tempText += "ab,";
          room1 = 0;
        }
      }
    }
    if (diffDays == 0) {
      if (
        diffDays == 0 &&
        btnValRoom == 2 &&
        events[i].rID == 2 &&
        moment(events[i].start).format("YYYY-MM-DD") ==
          moment(info.start).format("YYYY-MM-DD")
      ) {
        if (
          moment(info.start).format("HH:mm") != "" &&
          moment(events[i].start).format("HH:mm") != ""
        ) {
          if (
            moment(info.start).format("HH:mm") <=
              moment(events[i].end).format("HH:mm") &&
            moment(info.end).format("HH:mm") >=
              moment(events[i].start).format("HH:mm")
          ) {
            tempText += "a";
            room2 = 2;
            if (
              moment(info.end).format("HH:mm") ==
                moment(events[i].start).format("HH:mm") ||
              moment(info.start).format("HH:mm") ==
                moment(events[i].end).format("HH:mm")
            ) {
              tempText += "b,";
              room2 = 0;
            }
          }
        } else {
          tempText += "ab,";
          room2 = 0;
        }
      }
      tempText += "ab,";
    }
    tempText += "ab,";
  }

  tempCount = 0;
  tempResult = 3;
  tempText = tempText.replace(/,\s*$/, "");
  tempText = tempText.split(",");

  for (const txt of tempText) {
    if (txt == "ab") {
      tempCount++;
    }
  }

  if (tempText.length == tempCount) {
    if (room1 == 1 && room2 == 0) {
      tempResult = 1;
    } else if (room2 == 2 && room1 == 0) {
      tempResult = 2;
    } else if (room1 == 1 && room2 == 2) {
      tempResult = 3;
    } else tempResult = 0;
  }
  return tempResult;
}
// End checkIfTimeClash()

$("#addBookingBtn").on("click", function (e) {
  e.preventDefault();
  var bookingName = $("#add_Booking_Name").val();
  var bookingDate = $("#add_Booking_Date").val();
  bookingDate = moment(bookingDate).format("YYYY-MM-DD");
  var bookingTime = $("#add_Booking_Time").val();
  var bookingAD = 0;
  var bookingStatus = 1;
  var roomID = $("#add_Room_Name").val();
  var staffID = tempSID;

  if (bookingTime == "Entire Day") {
    bookingAD = 1;
    bookingTime = "";
  } else {
    bookingAD = 0;
    var temp = bookingTime.split(" - ");
    tempTime1 = moment(temp[0], "h:mmA").format("HH:mm");
    tempTime2 = moment(temp[1], "h:mmA").format("HH:mm");
    bookingTime = tempTime1 + "-" + tempTime2;
  }

  $.ajax({
    url: "./process/save_booking.php",
    type: "POST",
    data: {
      bookingName: bookingName,
      bookingAD: bookingAD,
      bookingDate: bookingDate,
      bookingTime: bookingTime,
      bookingStatus: bookingStatus,
      roomID: roomID,
      staffID: staffID,
    },
    success: function (data) {
      $("#event_add_modal").modal("hide");
      Swal.fire({
        title: "Success",
        text: "Booking has been confirmed",
        toast: true,
        position: "top-end",
        icon: "success",
        color: "#ffff",
        background: "#9CCC65",
        iconColor: "white",
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
      });
      setTimeout(function () {
        location.reload();
      }, 3500);
    },
  });
});

$("#updateBookingBtn").on("click", function (e) {
  e.preventDefault();
  var bookingID = $("#update_Booking_ID").val();
  // console.log(bookingID);
  Swal.fire({
    title: "Are you sure you want to cancel the booking?",
    showDenyButton: true,
    // showCancelButton: true,
    confirmButtonText: "No",
    denyButtonText: `Yes`,
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      $("#event_update_modal").modal("hide");
    } else if (result.isDenied) {
      $.ajax({
        url: "./process/cancel_booking.php",
        type: "POST",
        data: {
          bookingID: bookingID,
        },
        success: function (data) {
          console.log(data);
          $("#event_update_modal").modal("hide");
          Swal.fire({
            title: "Success",
            text: "Booking has been cancelled",
            toast: true,
            position: "top-end",
            icon: "success",
            color: "#ffff",
            background: "#9CCC65",
            iconColor: "white",
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
          });
          setTimeout(function () {
            location.reload();
          }, 3500);
        },
      });
    }
  });
});
