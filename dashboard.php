<?php
session_start();
if (!isset($_SESSION["staffID"])) {
    echo "<script type='text/javascript'>alert('Please login first'); window.location.replace('./index.php');</script>";
    exit;
}

// Get current month and year
$currentMonth = date('Y-m');

// Query to get total bookings per staff member for the current month
$bookingsQuery= "SELECT staffID, COUNT(*) as totalBookings 
                  FROM bookings 
                  WHERE DATE_FORMAT(bookingDate, '%Y-%m') = '$currentMonth' 
                  GROUP BY staffID";
$result = $conn->query($bookingsQuery);

$bookings = [];
$totalBookings = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $totalBookings += $row['totalBookings'];
        $bookings[] = $row;
    }
}

// Fetch staff names for the bookings
if (!empty($bookings)) {
    $staffIds = array_column($bookings, 'staffID');
    $staffIdsString = implode(',', $staffIds);
    $staffQuery = "SELECT staffID, name FROM staff WHERE staffID IN ($staffIdsString)";
    $staffResult = $conn->query($staffQuery);

    $staffNames = [];
    while ($row = $staffResult->fetch_assoc()) {
        $staffNames[$row['staffID']] = $row['name'];
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Dashboard</h1>
        <h2>Total Bookings for <?php echo date('F Y'); ?>: <?php echo $totalBookings; ?></h2>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Staff ID</th>
                    <th>Staff Name</th>
                    <th>Bookings</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($bookings)): ?>
                    <tr>
                        <td colspan="3" class="text-center">No bookings found for this month.</td>
                    </tr>.
                <?php else: ?>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['staffID']); ?></td>
                            <td><?php echo htmlspecialchars($staffNames[$booking['staffID']] ?? 'Unknown'); ?></td>
                            <td><?php echo $booking['totalBookings']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
