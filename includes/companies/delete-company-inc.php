<?php
require_once __DIR__ . '/../../config/dbh.php';
require_once __DIR__ . '/../../config/session-config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['company_id'], $_SESSION['user_id'])) {
        die("Unauthorized or invalid request.");
    }

    $company_id = (int) $_POST['company_id'];
    $user_id = (int) $_SESSION['user_id'];

    $db = new Dbh();
    $pdo = $db->connect();

    try {
        $stmt = $pdo->prepare("DELETE FROM companies WHERE company_id = :company_id AND user_id = :user_id");
        $stmt->bindParam(':company_id', $company_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            unset($_SESSION['company_id']); 
            header("Location: /../../views/companies/companies.php?deleted=1");
            exit();
        } else {
            die("Failed to delete company.");
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
