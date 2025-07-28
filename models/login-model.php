<?php
require_once __DIR__ . '/../config/dbh.php';

class LoginModel extends Dbh {
    protected $pdo;

    public function __construct() {
        $this->pdo = $this->connect();
    }

    public function getUserByUsernameOrEmail($usernameOrEmail) {
        $query = "SELECT * FROM users WHERE username = :ue OR email = :ue";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':ue', $usernameOrEmail);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
