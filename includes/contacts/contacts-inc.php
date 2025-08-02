<?php
require_once __DIR__ . '/../../controllers/contacts-controller.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /../../views/auth/login.php');
    exit();
}

// $company_id = $_POST['company_id'] ?? $_SESSION['company_id'];
$sort = $_GET['sort'] ?? 'created_at'; // default sort
$order = strtolower($_GET['order'] ?? 'desc'); // default order

// Whitelist to avoid SQL injection
$validSortFields = ['email', 'first_name', 'last_name', 'contact_owner', 'phone', 'lifecycle_stage', 'lead_status', 'created_at'];
$validOrder = ['asc', 'desc'];

if (!in_array($sort, $validSortFields)) {
    $sort = 'created_at';
}
if (!in_array($order, $validOrder)) {
    $order = 'desc';
}

$contactsController = new ContactsController();
$filter = $_GET['filter'] ?? 'all';
$search = trim($_GET['search'] ?? '');

if (!empty($search)) {
    $contacts = $contactsController->getSearchedContacts($_SESSION['user_id'], $search, $filter, $sort, $order);
} else {
    switch ($filter) {
        case 'my':
            $contacts = $contactsController->getSortedMyContacts($_SESSION['user_id'], $sort, $order);
            break;
        case 'recent':
            $contacts = $contactsController->getRecentSortedContacts($_SESSION['user_id'], 10, $sort, $order);
            break;
        case 'all':
        default:
            $contacts = $contactsController->getSortedContacts($_SESSION['user_id'], $sort, $order);
            break;
    }
}