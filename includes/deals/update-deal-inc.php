<?php
session_start();
require_once __DIR__ . '/../../config/dbh.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deal_id = $_POST['deal_id'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$deal_id || !$user_id) {
        die("Missing required data.");
    }

    $title = trim($_POST['title'] ?? '');
    $deal_type = trim($_POST['deal_type'] ?? '');
    $amount = floatval($_POST['amount'] ?? 0);
    $close_date = $_POST['close_date'] ?? null;

    if ($title === '') {
        die("Title is required.");
    }

    $dbh = new Dbh();
    $pdo = $dbh->connect();

    // Fetch current deal to verify ownership
    $stmt = $pdo->prepare("SELECT * FROM deals WHERE deal_id = ? AND user_id = ?");
    $stmt->execute([$deal_id, $user_id]);
    $deal = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$deal) {
        die("Deal not found or access denied.");
    }

    // Update the deal
    $updateStmt = $pdo->prepare("
        UPDATE deals 
        SET title = ?, deal_type = ?, amount = ?, close_date = ?
        WHERE deal_id = ? AND user_id = ?
    ");
    $updated = $updateStmt->execute([
        $title, $deal_type, $amount, $close_date, $deal_id, $user_id
    ]);

    $_SESSION['flash_message'] = $updated ? "Deal updated successfully." : "Update failed. Please try again.";
    header("Location: /../../views/deals/view-deal.php?deal_id=" . $deal_id);
    exit;
} else {
    http_response_code(405);
    echo "Method Not Allowed.";
}
