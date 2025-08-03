<?php
require_once __DIR__ . '/../../config/session-config.php';
require_once __DIR__ . '/../../models/companies-model.php';
require_once __DIR__ . '/../../controllers/companies-controller.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /../../veiws/auth/login.php');
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

$companiesModel = new CompaniesModel();
$companyContacts = $companiesModel->fetchContactsForCompany($_SESSION['company_id'], $_SESSION['user_id']);
$companyDeals = $companiesModel->fetchDealsForCompany($_SESSION['company_id'], $_SESSION['user_id']);

$company_id = $_SESSION['company_id'];
$user_id = $_SESSION['user_id'];

// Fetch company details
$companyController = new CompaniesController();
$company = $companyController->getCompanyDetails($company_id, $user_id);

if (!$company) {
    die("Company not found or access denied.");
}