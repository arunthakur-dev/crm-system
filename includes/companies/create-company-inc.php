<?php
require_once '/../../models/companies-model.php';
require_once '/../../controllers/companies-controller.php';
require_once '/../../config/session-config.php'; // using session-baseduser_id

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize form data
    $company_domain = trim($_POST['company_domain'] ?? '');
    $name           = trim($_POST['name'] ?? '');
    $industry       = trim($_POST['industry'] ?? '');
    $country        = trim($_POST['country'] ?? '');
    $state          = trim($_POST['state'] ?? '');
    $postal_code    = trim($_POST['postal_code'] ?? '');
    $employees      = intval($_POST['employees'] ?? 0);
    $owner          = trim($_POST['owner'] ?? '');
    $notes          = trim($_POST['notes'] ?? '');
    $user_id        = $_SESSION['user_id']; // from logged-in user session

    // Pass to controller
    $companyController = new CompaniesController(
        $user_id, $company_domain, $name, $owner,
        $industry, $country, $state, $postal_code, $employees, $notes
    );
    $companyController->createCompany();

    // Redirect after success (optional)
    header('Location: /../../views/companies/companies.php?status=success');
    exit;
}
