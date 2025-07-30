<?php
require_once __DIR__ . '/../config/dbh.php';
require_once __DIR__ . '/../config/session-config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['company_id'], $_SESSION['user_id'])) {
        die("Unauthorized or invalid request.");
    }

    $companyId = (int) $_POST['company_id'];
    $userId = (int) $_SESSION['user_id'];

    $db = new Dbh();
    $pdo = $db->connect();

    try {
        $stmt = $pdo->prepare("DELETE FROM companies WHERE company_id = :companyId AND user_id = :userId");
        $stmt->bindParam(':companyId', $companyId, PDO::PARAM_INT);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            unset($_SESSION['company_id']); // Optional cleanup
            header("Location: ../views/companies/companies.php?deleted=1");
            exit();
        } else {
            die("Failed to delete company.");
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
