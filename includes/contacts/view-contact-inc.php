<?php
require_once __DIR__ . '/../../config/session-config.php';
require_once __DIR__ . '/../../controllers/contacts-controller.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

// When arriving via POST, store the company ID in session
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_id'])) {
    $_SESSION['contact_id'] = (int) $_POST['contact_id'];
}

// Fallback check
if (!isset($_SESSION['contact_id']) || !is_numeric($_SESSION['contact_id'])) {
    die("No company selected or invalid session.");
}

$contact_id = $_SESSION['contact_id'];
$user_id = $_SESSION['user_id'];

// Fetch company details
$contactController = new ContactsController();
$contact = $contactController->getContactDetails($contact_id, $user_id);

if (!$contact) {
    die("Company not found or access denied.");
}