<?php
require_once __DIR__ . '/../../controllers/deals-controller.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /../../views/auth/login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Sorting
$sort = $_GET['sort'] ?? 'created_at';
$order = strtolower($_GET['order'] ?? 'desc');

$validSortFields = ['title', 'deal_stage', 'deal_owner', 'deal_type', 'amount', 'close_date', 'priority', 'created_at'];
$validOrder = ['asc', 'desc'];

if (!in_array($sort, $validSortFields)) {
    $sort = 'created_at';
}
if (!in_array($order, $validOrder)) {
    $order = 'desc';
}

$deals = [];
// Filter and Search
$filter = $_GET['filter'] ?? 'all';
$search = trim($_GET['search'] ?? '');

$dealsController = new DealsController();
$deals = $deals ?? [];


if (!empty($search)) {
    $deals = $dealsController->getSearchedDeals($user_id, $search, $filter, $sort, $order);
} else {
    switch ($filter) {
        case 'my':
            $deals = $dealsController->getSortedMyDeals($user_id, $sort, $order);
            break;
        case 'recent':
            $deals = $dealsController->getRecentSortedDeals($user_id, 10, $sort, $order);
            break;
        case 'all':
        default:
            $deals = $dealsController->getSortedDeals($user_id, $sort, $order);
            break;
    }
}
