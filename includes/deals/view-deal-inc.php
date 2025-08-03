<?php
require_once __DIR__ . '/../../config/session-config.php';
require_once __DIR__ . '/../../controllers/deals-controller.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

// Store the deal ID in session if coming from a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deal_id'])) {
    $_SESSION['deal_id'] = (int) $_POST['deal_id'];
}

// Fallback if no deal ID is found
if (!isset($_SESSION['deal_id']) || !is_numeric($_SESSION['deal_id'])) {
    die("No deal selected or invalid session.");
}


$dealController = new DealsController();
$dealContacts = $dealController->getContactsForDeal($_SESSION['deal_id'], $_SESSION['user_id']);
$dealCompanies = $dealController->getCompaniesForDeal($_SESSION['deal_id'], $_SESSION['user_id']);


$deal_id = $_SESSION['deal_id'];
$user_id = $_SESSION['user_id'];

$dealsController = new DealsController();
$deal = $dealsController->getDealDetails($deal_id, $user_id);

if (!$deal) {
    die("Deal not found or access denied.");
}
?>
