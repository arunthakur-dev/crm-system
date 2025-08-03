<?php
require_once __DIR__ . '/../../config/dbh.php';
require_once __DIR__ . '/../../config/session-config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['contact_id'], $_SESSION['user_id'])) {
        die("Unauthorized or invalid request.");
    }

    $contact_id = (int) $_POST['contact_id'];
    $user_id = (int) $_SESSION['user_id'];

    $db = new Dbh();
    $pdo = $db->connect();

    try {
        $stmt = $pdo->prepare("DELETE FROM contacts WHERE contact_id = :contact_id AND user_id = :user_id");
        $stmt->bindParam(':contact_id', $contact_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            unset($_SESSION['contact_id']);  
            header("Location: /../../views/contacts/contacts.php?deleted=1");
            exit();
        } else {
            die("Failed to delete company.");
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
