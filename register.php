<?php
session_start();
include 'database_connection.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $staff_id = $_POST['staff_id'];
    $staff_department = $_POST['staff_department'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM staff WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Username already exists.";
    } else {
        
        $stmt = $conn->prepare("INSERT INTO staff (staff_id, staff_department, username, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $staff_id, $staff_department, $username, $password);

        if ($stmt->execute()) {
            $success = "Successfully registered!";
        } else {
            $error = "Error registering user.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome CDN -->
    <script>
        function handleLogout() {
            if (confirm("You are successfully logout")) {
                window.location.href = "index.php"; 
            }
        }
    </script>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            display: flex;
            flex-direction: column;
            font-family: Arial, sans-serif;
            background-color: #e6e8e8;
        }

        header {
            width: 100%;
            height: 90px; 
            display: flex;
            justify-content: space-between;
            align-items: center;
            top: 0; 
            left: 0; 
            background: rgb(175, 226, 224); 
            padding: 0 20px; 
        }

        header .logo {
            max-height: 70px; 
            width: auto;
        }

        nav{
            height: 80px;
            overflow: hidden;
        }
        nav ul {
            display: flex;
            margin-right: 80px;
            float: right;
            list-style: none;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            color: rgb(31, 15, 75);
            font-size: 18px;
            text-decoration: none;
            padding: 10px;
            display: inline-block;
            border-radius: 5px;
        }

        nav ul li a:hover {
            background-color: rgba(70, 16, 16, 0.1); 
            color: rgb(75, 155, 155);
        }

        main {
            flex: 1;
            padding: 70px 30px 30px; 
            max-width: 1200px;
            margin: 0 auto; 
            text-align: center;
        }

        .box {
            width: 300px;
            padding: 40px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
            margin: 0 auto; /* Centered box */
        }

        .box h2 {
            margin-bottom: 15px;
        }

        .box label {
            margin-bottom: 10px;
            font-weight: bold;
        }

        .box input[type="text"],
        .box input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 6px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .box button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        .box button:hover {
            background-color: #0056b3;
        }

        .box .links {
            margin-top: 20px;
        }

        .box .links a {
            display: block;
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
            margin-bottom: 10px;
            transition: color 0.3s;
        }

        .box .links a:hover {
            color: #1e636a;
        }

        .error {
            color: red;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .success {
            color: green;
            margin-bottom: 10px;
            font-size: 14px;
        }

        footer {
            background-color: #4d5655;
            color: white;
            text-align: center;
            padding: 10px 20px;
            margin-top: auto;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <header>
        <img src="image/logo.png" alt="Logo" class="logo">
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="timegrid-views.php">Booking</a></li>
                <li><a href="user.php">User</a></li>
                <li><a href="javascript:void(0);" class="logout-icon" onclick="handleLogout()"><i class="fas fa-sign-out-alt"></i></a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="box">
            <h2>REGISTER</h2>
            <?php
            if (isset($error)) echo "<p class='error'>$error</p>";
            if (isset($_SESSION['registration_success'])) {
                echo "<p class='success'>{$_SESSION['registration_success']}</p>";
                unset($_SESSION['registration_success']); 
            }
            ?>
            <form method="post" action="">
                <label for="staff_id">Staff ID:</label>
                <input type="text" id="staff_id" name="staff_id" required>

                <label for="staff_department">Department:</label>
                <input type="text" id="staff_department" name="staff_department" required>
                
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                
                <button type="submit">REGISTER</button>
            </form>
            <div class="links">
                <a href="login.php">Already have an account? Please login</a>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Honda Logistics Malaysia | All rights reserved.</p>
    </footer>
</body>
</html>
