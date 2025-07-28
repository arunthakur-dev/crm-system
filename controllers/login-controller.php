<?php

require_once __DIR__ . '/../models/login-model.php';

class LoginController extends LoginModel {
    private $usernameOrEmail;
    private $pwd;

    public function __construct($usernameOrEmail, $pwd) {
        parent::__construct();  // Connection to DB
        $this->usernameOrEmail = trim($usernameOrEmail);
        $this->pwd = trim($pwd);
    }

   public function loginUser() {
    $errors = [];

    // 1. Validate empty input
    if (empty($this->usernameOrEmail)) {
        $errors['user'] = "Username or email is required.";
    }

    if (empty($this->pwd)) {
        $errors['pwd'] = "Password is required.";
    }

    // 2. If inputs are filled, try to get the user
    if (empty($errors)) {
        $user = $this->getUserByUsernameOrEmail($this->usernameOrEmail);

        if (!$user) {
            $errors['user'] = "Invalid username or email.";
        } elseif (!password_verify($this->pwd, $user['pwd'])) {
            $errors['pwd'] = "Incorrect password.";
        }
    }

    // 3. Error handling
    if (!empty($errors)) {
        $_SESSION['field_errors'] = $errors;
        $_SESSION['login_data'] = ['usernameOrEmail' => $this->usernameOrEmail];
        return false;
    }

    // 4. Login success
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    unset($_SESSION['login_data']);
    return true;
    }
}
