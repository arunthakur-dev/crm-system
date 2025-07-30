<?php
require_once __DIR__ . '/../config/session-config.php';
require_once __DIR__ . '/../controllers/companies-controller.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

// When arriving via POST, store the company ID in session
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['company_id'])) {
    $_SESSION['company_id'] = (int) $_POST['company_id'];
}

// Fallback check
if (!isset($_SESSION['company_id']) || !is_numeric($_SESSION['company_id'])) {
    die("No company selected or invalid session.");
}

$companyId = $_SESSION['company_id'];
$userId = $_SESSION['user_id'];

// Fetch company details
$companyController = new CompaniesController();
$company = $companyController->getCompanyDetails($companyId, $userId);

if (!$company) {
    die("Company not found or access denied.");
}