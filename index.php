<!DOCTYPE html>
<html>

<head>
    <?php include "./component/head.php" ?>
    <style>
        body {
            background-image: url('image/background.jpg');
            background-size: cover;
            background-attachment: fixed;
            color: #333;
        }

        .navbar .d-xxl-flex {
            display: none !important;
        }

        .navbar .d-flex {
            margin-right: 4%;
        }

        .navbar .navbar-brand {
            margin-left: 3%;
        }
    </style>
</head>

<body>
    <?php include "./component/header.php" ?>
    <div class="container-fluid my-auto">
        <div class="box" style="margin-right: 10%!important;">
            <div class="row">
                <!-- <div class="col-sm-6">
                    <p style="font-size: 2.8rem">Welcome to the</p>
                    <p style="font-size: 2.8rem">Meeting Room Booking System</p>
                    <p style="font-size: 1.5rem">Please log in or register to book a room.</p>
                    <h2>LOGIN</h2>
                </div> -->
                <div class="col-sm-12">
                    <div class="form-group">
                    <form method="post" action="">
                        <label for="staff_ID">Staff ID:</label>
                        <input type="text" id="staff_ID" name="staffID" required>

                        <label for="staff_Pass">Password:</label>
                        <input type="password" id="staff_Pass" name="staffPass" required>

                        <button type="submit" id="submit">LOGIN</button>
                    </form>
                    <!-- <div class="links">
                        <a href="register.php">Create New Account</a>
                        <a href="forgotpassword.php">Forgot Password?</a>
                    </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "./component/footer.php" ?>
    <script>
        $("#submit").on("click", function(e) {
            e.preventDefault();
            var staffID = $("#staff_ID").val();
            var staffPass = $("#staff_Pass").val();

            $.ajax({
                url: "./process/login.php",
                type: "POST",
                data: {
                    staffID: staffID,
                    staffPass: staffPass,
                },
                success: function(data) {
                    var obj = JSON.parse(data);
                    console.log(obj);
                    if (obj.status == true) {
                        window.location.replace("./booking.php");
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "Staff ID or password not valid",
                            toast: true,
                            position: "top-end",
                            icon: "error",
                            color: "#ffff",
                            background: "#E91E63",
                            iconColor: "white",
                            showConfirmButton: false,
                            timer: 3500,
                            timerProgressBar: true,
                        });
                    }
                },
            });
        });

        $(document).ready(function() {
            $.ajax({
                url: "./process/logout.php",
                type: "POST",
                datatype: 'json',
                cache: false,
                success: function(data) {
                    var obj = JSON.parse(data);
                    if (obj.status == true && obj.msg == "logout") {
                        Swal.fire({
                            title: "Logout",
                            text: "Successfully logout!",
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
                    }
                },
            });
        });
    </script>

</body>

</html>