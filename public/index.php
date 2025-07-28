<?php
require_once __DIR__ . '/../config/session-config.php';

// If user is already logged in, redirect to the main dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="/../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to Our CRM System</h1><hr><br>
        <p>Please login to manage your customer relationships 
            or register for a new account.</p><br> 
        <div>
            <a href="/../views/auth/login.php" class="btn">Login</a>
            <a href="/../views/auth/register.php" class="btn">Register</a>
        </div>
    </div>
</body>
</html>
