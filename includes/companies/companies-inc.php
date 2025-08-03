<?php
require_once __DIR__ . '/../../controllers/companies-controller.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /../../views/auth/login.php');
    exit();
} 

$sort = $_GET['sort'] ?? 'created_at'; // default sort
$order = strtolower($_GET['order'] ?? 'desc'); // default order

// Whitelist to avoid SQL injection
$validSortFields = ['name', 'company_domain', 'owner', 'industry', 'country', 'state', 'postal_code', 'employees', 'created_at'];
$validOrder = ['asc', 'desc'];

if (!in_array($sort, $validSortFields)) {
    $sort = 'created_at';
}
if (!in_array($order, $validOrder)) {
    $order = 'desc';
}

$companyController = new CompaniesController();
$filter = $_GET['filter'] ?? 'all';
$search = trim($_GET['search'] ?? '');

if (!empty($search)) {
    $companies = $companyController->getSearchedCompanies($_SESSION['user_id'], $search, $filter, $sort, $order);
} else {
    switch ($filter) {
        case 'recent':
            $companies = $companyController->getRecentSortedCompanies($_SESSION['user_id'], 10, $sort, $order);
            break;
        case 'all':
        default:
            $companies = $companyController->getSortedCompanies($_SESSION['user_id'], $sort, $order);
            break;
    }
}
?>