<!-- Start view popup dialog box -->
<div class="modal fade" id="event_view_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">View Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="view_Booking_Name">Booking Title</label>
                                <input type="text" name="viewBookingName" id="view_Booking_Name" class="form-control" disabled />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="view_Booking_Date">Date</label>
                                <input type="text" name="viewBookingDate" id="view_Booking_Date" class="form-control" disabled />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="view_Booking_Time">Time</label>
                                <input type="text" name="viewBookingTime" id="view_Booking_Time" class="form-control" disabled />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="view_Room_Name">Room</label>
                                <input type="text" name="viewRoomName" id="view_Room_Name" class="form-control" disabled />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="view_Booking_sName">Booked by</label>
                                <input type="text" name="viewBookingSName" id="view_Booking_sName" class="form-control" disabled />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>
<!-- End view popup dialog box -->

<!-- Start add popup dialog box -->
<form method="POST" id="addBooking">
    <div class="modal fade" id="event_add_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Add Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="add_Booking_Name">Booking Title</label>
                                    <input type="text" name="addBookingName" id="add_Booking_Name" class="form-control" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="add_Booking_Date">Date</label>
                                    <input id="add_Booking_Date" name="addBookingDate" class="form-control" type="date" placeholder="YYYY-MM-DD" required disabled />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="add_Booking_Time">Booking Time</label>
                                    <input type="text" class="form-control" id="add_Booking_Time" name="addBookingTime" required disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="add_Room_Name">Room</label>
                                    <select id="add_Room_Name" name="addBookingRoom" class="form-select" aria-label="Default select example" required>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="addBookingBtn" class="btn btn-primary">Book</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- End add popup dialog box -->

<!-- Start update popup dialog box -->
<div class="modal fade" id="event_update_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Update Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="update_Booking_Name">Booking Title</label>
                                <input type="text" name="updateBookingName" id="update_Booking_Name" class="form-control" disabled />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="update_Booking_Date">Date</label>
                                <input type="text" name="updateBookingDate" id="update_Booking_Date" class="form-control" disabled />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="update_Booking_Time">Time</label>
                                <input type="text" name="updateBookingTime" id="update_Booking_Time" class="form-control" disabled />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="update_Room_Name">Room</label>
                                <input type="text" name="updateRoomName" id="update_Room_Name" class="form-control" disabled />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="update_Booking_sName">Booked by</label>
                                <input type="text" name="updateBookingSName" id="update_Booking_sName" class="form-control" disabled />
                            </div>
                        </div>
                        <input class="d-none" type="text" name="updateBookingID" id="update_Booking_ID" class="form-control" disabled />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="updateBookingBtn" class="btn btn-danger">Cancel Booking</button>
            </div>
        </div>
    </div>
</div>
<!-- End update popup dialog box -->