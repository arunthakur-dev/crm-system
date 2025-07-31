<?php
require_once __DIR__ . '/../../config/db-config.php'; // DB connection
require_once __DIR__ . '/../../config/session-config.php'; // Session
require_once __DIR__ . '/../../helpers/redirect.php'; // Optional helper

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $companyId = $_POST['company_id'] ?? null;
    $contactId = $_POST['existing_contact_id'] ?? null;

    if (!$companyId || !$contactId || !is_numeric($companyId) || !is_numeric($contactId)) {
        die("Invalid form data.");
    }

    try {
        $pdo = new PDO($dsn, $dbUser, $dbPass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // Optional: check if already linked
        $check = $pdo->prepare("SELECT * FROM company_contacts WHERE company_id = ? AND contact_id = ?");
        $check->execute([$companyId, $contactId]);

        if ($check->rowCount() > 0) {
            echo "This contact is already linked to the company.";
            exit();
        }

        // Insert link
        $stmt = $pdo->prepare("INSERT INTO company_contacts (user_id, company_id, contact_id) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $companyId, $contactId]);

        // Redirect or success
        header("Location: /views/companies/view-company.php?id=" . $companyId);
        exit();

    } catch (PDOException $e) {
        echo "Error linking contact: " . $e->getMessage();
        exit();
    }
} else {
    echo "Invalid request method.";
}
