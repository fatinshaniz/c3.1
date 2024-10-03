<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    
    // Check if email exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Generate a new password
        $new_password = bin2hex(random_bytes(4)); // Generate a random password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        // Update password in database
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashed_password, $email);
        $stmt->execute();
        
        // Send new password via email
        $subject = "Your New Password";
        $message = "Your new password is: $new_password";
        $headers = "From: no-reply@yourdomain.com";
        mail($email, $subject, $message, $headers);
        
        echo "A new password has been sent to your email.";
    } else {
        echo "No account found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Password</h2>
    <form method="post" action="">
        <label>Email: <input type="email" name="email" required></label><br>
        <button type="submit">Reset Password</button>
    </form>
    <a href="login.php">Back to Login</a>
</body>
</html>
