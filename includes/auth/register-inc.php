<?php
require_once __DIR__ . '/../../config/session-config.php';

// Check if the user accessed this page by submitting the form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Get the form data
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $company_name = trim($_POST['company_name']);
    $pwd = $_POST['pwd'];
    $confirmpwd = $_POST['confirmpwd'];

    // Include controller and model
    require_once __DIR__ . '/../../controllers/register-controller.php';
    require_once __DIR__ . '/../../models/register-model.php';

    // Instantiate controller
    $register = new RegisterController($username, $email, $pwd, $confirmpwd, $company_name);

    // Run registration
    $register->registerUser();

    // Redirect based on success
    if (isset($_SESSION['success_register'])) {
        header("Location: /../views/auth/login.php"); 
    } else {
        header("Location: /../views/auth/register.php");  
    }

    exit();    
} else {
    header("location: /../views/auth/register.php");
    exit();
}

