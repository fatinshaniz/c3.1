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
  <?php include "./modal/calendarModal.php" ?>
  <div class="pt-4" style="background: #ffff">
    <div id="calendar" class="mb-4"></div>
    <div class="d-none">
      <input type="text" value="1" name="roomBtn" id="roomBtnVal" class="form-control" disabled />
    </div>
  </div>
  <?php include "./component/footer.php" ?>
  <script>
    var tempSID = "<?php echo $staffID ?>";
  </script>
  <script src=" ./js/calendar.js"></script>
  <script src=" ./js/logout.js"></script>
</body>

</html>