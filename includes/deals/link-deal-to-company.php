<?php
require_once __DIR__ . '/../../config/session-config.php';
require_once __DIR__ . '/../../config/dbh.php';
require_once __DIR__ . '/../../controllers/deals-controller.php';
require_once __DIR__ . '/../../models/deals-model.php';
require_once __DIR__ . '/../../models/companies-model.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /error.php");
    exit;
}

$deal_id = $_POST['deal_id'] ?? null;
$user_id = $_SESSION['user_id'] ?? null;


try {

    $dealController = new DealsController();
    $dealModel = new DealsModel();

    if (isset($_POST['existing_company_id'])) {
        $company_id = $_POST['existing_company_id'] ?? null;
        $dealController->linkDealToCompany($deal_id, $company_id);
    } else {
        // Logic for creating a new company and linking it
        $company_domain = trim($_POST['company_domain'] ?? '');
        $name           = trim($_POST['name'] ?? '');
        $industry       = trim($_POST['industry'] ?? '');
        $country        = trim($_POST['country'] ?? '');
        $state          = trim($_POST['state'] ?? '');
        $postal_code    = trim($_POST['postal_code'] ?? '');
        $employees      = intval($_POST['employees'] ?? 0);
        $owner          = trim($_POST['owner'] ?? '');
        $notes          = trim($_POST['notes'] ?? '');

        $companiesModel = new CompaniesModel();
        $new_company_id = $companiesModel->insertCompany($user_id, $company_domain, $name, $owner,
                                     $industry, $country, $state,
                                     $postal_code, $employees, $notes);

        $dealModel->linkDealToCompany($deal_id, $new_company_id);
    }

    header("Location: /views/deals/view-deal.php?company_id=$company_id&success=1");
    exit;

} catch (Exception $e) {
    header("Location: /views/deals/view-deal.php?company_id=$company_id&error=" . urlencode($e->getMessage()));
    exit;
}
