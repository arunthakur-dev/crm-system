<?php
require_once __DIR__ . '/../../config/dbh.php'; // adjust as needed
require_once __DIR__ . '/../../config/session-config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $contact_id = $_POST['contact_id'];
    $field = $_POST['field_name'];
    $value = $_POST['field_value'];

    $allowedFields = ['email', 'contact_owner', 'phone', 'lifecycle_stage', 'lead_status',];

    if (!in_array($field, $allowedFields)) {
        http_response_code(400);
        exit('Invalid Field');
    }

    $dbh = new Dbh();
    $pdo = $dbh->connect();
    $stmt = $pdo->prepare("UPDATE contacts SET `$field` = :value WHERE contact_id = :contact_id AND user_id = :uid");
    $stmt->execute([
        'value' => $value,
        'contact_id' => $contact_id,
        'uid' => $_SESSION['user_id']
    ]);

    header("Location: /../../views/contacts/view-contact.php?contact_id=" . $contact_id);
    exit();
} else {
    http_response_code(405);
    exit('Method Not Allowed');
}

