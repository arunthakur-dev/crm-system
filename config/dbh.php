<?php

class Dbh {
     public function connect() {
        try {
            $username = "root";
            $password = "";
            $pdo = new PDO("mysql:host=localhost;dbname=crm_system", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}