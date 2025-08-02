<?php
require_once __DIR__ . '/../../config/session-config.php';
require_once __DIR__ . '/../../config/dbh.php';
require_once __DIR__ . '/../../controllers/companies-controller.php';
require_once __DIR__ . '/../../models/companies-model.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /error.php");
    exit;
}

$contact_id = $_POST['contact_id'] ?? null;
$user_id = $_SESSION['user_id'] ?? null;

try {
    if (!$contact_id || !$user_id) {
        throw new Exception("Missing contact or user ID.");
    }

    $companyController = new CompaniesController();

    if (isset($_POST['existing_company_id'])) {
        $company_id = $_POST['existing_company_id'];
        $companyController->linkCompanyToContact($company_id, $contact_id);
    } else {
        // Create and link new company
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

        if (!$name) { 
            throw new Exception("Company name is required.");
        }

        $new_company_id = $companyController->createAndLinkCompany(
            $user_id, $contact_id, $company_domain, $name, $owner,
            $industry, $country, $state, $postal_code,
            $employees, $notes
            );
    }

    header("Location: /views/contacts/view-contact.php?contact_id=$contact_id&success=1");
    exit;

} catch (Exception $e) {
    header("Location: /views/contacts/view-contact.php?contact_id=$contact_id&error=" . urlencode($e->getMessage()));
    exit;
}
