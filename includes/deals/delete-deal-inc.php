<?php
require_once __DIR__ . '/../../config/dbh.php';
require_once __DIR__ . '/../../config/session-config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['deal_id'], $_SESSION['user_id'])) {
        die("Unauthorized or invalid request.");
    }

    $deal_id = (int) $_POST['deal_id'];
    $user_id = (int) $_SESSION['user_id'];

    $db = new Dbh();
    $pdo = $db->connect();

    try {
        $stmt = $pdo->prepare("DELETE FROM deals WHERE deal_id = :deal_id AND user_id = :user_id");
        $stmt->bindParam(':deal_id', $deal_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            unset($_SESSION['deal_id']); // Optional cleanup
            header("Location: /../../views/deals/deals.php?deleted=1");
            exit();
        } else {
            die("Failed to delete deal.");
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
