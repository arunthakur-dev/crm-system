<?php

// Database handler connected with "crm-system" database
class Dbh {
    private $pdo;

    public function connect() {
        if ($this->pdo === null) {
            try {
                $username = "root";
                $password = "";
                $this->pdo = new PDO("mysql:host=localhost;dbname=crm_system", $username, $password);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }

        return $this->pdo;
    }
}

