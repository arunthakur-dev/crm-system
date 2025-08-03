<?php
require_once __DIR__ . '/../../config/dbh.php';  
require_once __DIR__ . '/../../config/session-config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $company_id = $_POST['company_id'];
    $field = $_POST['field_name'];
    $value = $_POST['field_value'];

    $allowedFields = ['name', 'industry', 'employees', 'owner', 'country', 'state', 'postal_code', 'notes'];

    if (!in_array($field, $allowedFields)) {
        http_response_code(400);
        exit('Invalid Field');
    }

    $dbh = new Dbh();
    $pdo = $dbh->connect();
    $stmt = $pdo->prepare("UPDATE companies SET `$field` = :value WHERE company_id = :id AND user_id = :uid");
    $stmt->execute([
        'value' => $value,
        'id' => $company_id,
        'uid' => $_SESSION['user_id']
    ]);
    header("Location: /../../views/companies/view-company.php?company_id=" . $company_id);
    exit();
} else {
    http_response_code(405);
    exit('Method Not Allowed');
}

