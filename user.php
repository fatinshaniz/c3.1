<?php
// Check if user is valid or not
session_start();
if (!isset($_SESSION["staffID"])) {
    echo "<script type='text/javascript'>alert('Please login first'); window.location.replace('./index.php');</script>";
} else {
    $staffID = $_SESSION["staffID"];
    $staffAcc = $_SESSION["userAccess"];
}
?>
<!DOCTYPE html>
<html>

<head>
    <?php include "./component/head.php" ?>
</head>

<body>
    <?php include "./component/header.php" ?>
    <div class="container-fluid mx-auto my-4">
        <div class="box">
            <h2 class="text-center fw-bold">User Profile</h2>
            <div class="text-center mb-4">
                <i class="fa-regular fa-user fa-4x mb-4"></i>
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="staff_Name">Name</label>
                                    <input type="text" name="staffName" id="staff_Name" class="form-control" required />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="staff_Email">Email</label>
                                    <input type="email" name="staffName" id="staff_Email" class="form-control" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="staff_ID">Staff ID</label>
                                    <input type="text" name="staffID" id="staff_ID" class="form-control" disabled />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="staff_Dept">Department</label>
                                    <select id="staff_Dept" name="staffDept" class="form-select" required>
                                        <option value="BM">BM</option>
                                        <option value="FAC">FAC</option>
                                        <option value="HRGA">HRGA</option>
                                        <option value="BP/SM">BP/SM</option>
                                        <option value="SHIP">SHIP</option>
                                        <option value="KD">KD</option>
                                        <option value="LP">LP</option>
                                        <option value="HSEQ">HSEQ</option>
                                        <option value="PPC/IT">PPC/IT</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-sm-12">
                                <button type="button" class="btn btn-primary" id="updateDetailBtn">Update Details</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <a href="#" data-bs-toggle="collapse" data-bs-target="#changePasswordForm">Change Password</a>
                                </div>
                                <!-- <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#changePasswordForm">Change Password</button> -->
                            </div>
                        </div>

                    </div>
                </div>
                <div id="changePasswordForm" class="collapse">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title fw-bolder">Change Password</h5>
                            <form method="post">
                                <div class="form-group">
                                    <label for="current_password">Current Password</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password" autocomplete="on" required>
                                </div>
                                <div class="form-group">
                                    <label for="new_password">New Password</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password" autocomplete="on" required>
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" autocomplete="on" required>
                                </div>
                                <button type="submit" class="btn btn-primary" id="changePassBtn" name="change_password">Update Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "./component/footer.php" ?>
    <script>
        var temp = "<?php echo $staffID ?>";
        $("#staff_ID").val(temp);
    </script>
    <script src=" ./js/user.js"></script>
    <script src=" ./js/logout.js"></script>
</body>

</html>