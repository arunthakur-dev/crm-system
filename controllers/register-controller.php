<?php

require_once __DIR__ . '/../models/register-model.php';

class RegisterController extends RegisterModel {
    private $username;
    private $email;
    private $pwd;
    private $confirmPwd;
    private $company_name;

    public function __construct($username, $email, $pwd, $confirmPwd, $company_name) {
        parent::__construct();
        $this->username = htmlspecialchars(trim($username));
        $this->email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
        $this->company_name = htmlspecialchars(trim($company_name));
        $this->pwd = htmlspecialchars(trim($pwd));
        $this->confirmPwd = htmlspecialchars(trim($confirmPwd));
    }

    public function registerUser() {
    $fieldErrors = [];

    // Sanitize confirm password before use
    $confirmPwd = htmlspecialchars(trim($_POST['confirmpwd']));

    // Username validation
    if (empty($this->username)) {
        $fieldErrors['username'] = "Username is required.";
    } elseif ($this->doesUsernameExist()) {
        $fieldErrors['username'] = "Username already exists.";
    }

    // Email format validation
    if (empty($this->email)){
        $fieldErrors["email"] = "Email is required.";
    } elseif (!$this->isEmailValid()) {
        $fieldErrors['email'] = "Invalid email format.";
    } if ($this->doesEmailExist()) {
        $fieldErrors['email'] = "Email already exists.";
    }

    // Password strength check
    if (empty($this->pwd)){
        $fieldErrors["pwd"] = "Password is required.";
    } elseif (!$this->isPasswordStrong()) {
        $fieldErrors['pwd'] = "Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.";
    }

    // Match confirm password
    if (empty($this->confirmPwd)){
        $fieldErrors["confirmpwd"] = "Password is required.";
    } elseif ($this->pwd !== $this->confirmPwd) {
        $fieldErrors['confirmpwd'] = "Passwords do not match.";
    }    

    // Save form data and errors in session if any
    if (!empty($fieldErrors)) {
        $_SESSION['form_data'] = [
            'username' => $this->username,
            'email' => $this->email,
            'company_name' => $this->company_name,
        ];
        $_SESSION['field_errors'] = array_filter($fieldErrors); 
        header("location: ../views/auth/register.php");
        exit();
    }

    // All good, insert user
    $hashedPwd = password_hash($this->pwd, PASSWORD_DEFAULT);
    $this->setUser($this->username, $this->email, $hashedPwd, $this->company_name);
    $_SESSION['success_register'] = "Registration successful! You can now login.";
    header("location: ../views/auth/login.php"); // Redirect after successful registration
    exit();
    }
    private function doesUsernameExist() {
        return $this->checkUsername($this->username);
    }
     private function doesEmailExist() {
        return $this->checkEmail($this->email);
    }

    private function isPasswordStrong() {
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $this->pwd);
    }

    private function isEmailValid() {
        return preg_match('/^[\w\.-]+@[\w\.-]+\.\w{2,}$/', $this->email);
    }
}