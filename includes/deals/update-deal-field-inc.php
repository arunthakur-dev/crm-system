<?php
require_once __DIR__ . '/../../config/dbh.php';
require_once __DIR__ . '/../../config/session-config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $deal_id = $_POST['deal_id'];
    $field = $_POST['field_name'];
    $value = $_POST['field_value'];

    // Only allow updating specific fields
    $allowedFields = ['deal_owner', 'deal_stage', 'priority'];

    if (!in_array($field, $allowedFields)) {
        http_response_code(400);
        exit('Invalid Field');
    }

    $dbh = new Dbh();
    $pdo = $dbh->connect();

    // Dynamically bind field and value safely
    $stmt = $pdo->prepare("
        UPDATE deals 
        SET `$field` = :value 
        WHERE deal_id = :deal_id AND user_id = :uid
    ");
    
    $stmt->execute([
        'value' => $value,
        'deal_id' => $deal_id,
        'uid' => $_SESSION['user_id']
    ]);

    // Redirect back to the view page for this deal
    header("Location: /../../views/deals/view-deal.php?deal_id=" . $deal_id);
    exit();
} else {
    http_response_code(405);
    exit('Method Not Allowed');
}
