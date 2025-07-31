<?php

require_once __DIR__ . '/../config/dbh.php';

class RegisterModel extends Dbh {
    protected $pdo;
    public function __construct() {
        $this->pdo = $this->connect();  
    }
    
    public function setUser($username, $email, $pwd, $company_name) {
        $query = "INSERT INTO users (username, email, pwd, company_name) 
                  VALUES (:username, :email, :pwd, :company_name)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pwd', $pwd);
        $stmt->bindParam(':company_name', $company_name);
        return $stmt->execute();
    }

    public function checkUsername($username) {
        $query = "SELECT user_id FROM users WHERE  username = :username ";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function checkEmail($email) {
        $query = "SELECT user_id FROM users WHERE  email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
