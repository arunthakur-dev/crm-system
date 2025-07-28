<?php
require_once __DIR__ . '/../config/session-config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $usernameOrEmail = $_POST['usernameOrEmail'] ?? '';
    $pwd = $_POST['pwd'] ?? '';

    require_once __DIR__ . '/../controllers/login-controller.php';

    $loginController = new LoginController($usernameOrEmail, $pwd);
    $isLoggedIn = $loginController->loginUser();

    if ($isLoggedIn) {
        header("location: ../public/dashboard.php");
    } else {
        header("location: ../views/auth/login.php");
    }
    exit();
} else {
    header("location: ../views/auth/login.php");
    exit();
}

