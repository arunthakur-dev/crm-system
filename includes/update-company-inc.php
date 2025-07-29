<?php
require_once __DIR__ . '/../config/session-config.php';
require_once __DIR__ . '/../controllers/companies-controller.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_company'])) {

    // Validate required fields
    if (empty($_POST['company_id']) || empty($_POST['name'])) {
        die("Company ID and Name are required.");
    }

    // Sanitize inputs
    $company_id     = (int) $_POST['company_id'];
    $user_id        = $_SESSION['user_id']; // Assuming you're storing user_id in session

    $company_domain = trim($_POST['company_domain'] ?? '');
    $name           = trim($_POST['name']);
    $owner          = trim($_POST['owner'] ?? '');
    $industry       = trim($_POST['industry'] ?? '');
    $country        = trim($_POST['country'] ?? '');
    $state          = trim($_POST['state'] ?? '');
    $postal_code    = trim($_POST['postal_code'] ?? '');
    $employees      = is_numeric($_POST['employees']) ? (int) $_POST['employees'] : null;
    $notes          = trim($_POST['notes'] ?? '');

    // Create controller and call update
    $companyController = new CompaniesController();
    $companyController->updateCompany(
        $company_id,
        $user_id,
        $company_domain,
        $name,
        $owner,
        $industry,
        $country,
        $state,
        $postal_code,
        $employees,
        $notes
    );

    // Redirect back to companies list
    header("Location: /views/companies/companies.php?updated=1");
    exit;
} else {
    die("Invalid request.");
}
