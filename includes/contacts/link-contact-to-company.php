<?php
require_once __DIR__ . '/../../config/session-config.php';
require_once __DIR__ . '/../../config/dbh.php';
require_once __DIR__ . '/../../controllers/contacts-controller.php';
require_once __DIR__ . '/../../models/contacts-model.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /error.php");
    exit;
}

$company_id = $_POST['company_id'] ?? null;
$user_id = $_SESSION['user_id'] ?? null; 

try {
    if (!$company_id || !$user_id) {
        throw new Exception("Missing company or user ID.");
    }

    $contactController = new ContactsController();

    if (isset($_POST['existing_contact_id'])) {
        $contact_id = $_POST['existing_contact_id'];
        $contactController->linkContactToCompany($contact_id, $company_id);
    } else {
        $email = trim($_POST['email']);
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $contact_owner = trim($_POST['contact_owner']);
        $phone = trim($_POST['phone']);
        $lifecycle_stage = trim($_POST['lifecycle_stage']);
        $lead_status = trim($_POST['lead_status']);

        if (!$email || !$first_name || !$last_name) {
            throw new Exception("Email, First Name, and Last Name are required.");
        }

        $new_contact_id = $contactController->createAndLinkContact(
            $user_id, $company_id, $email, $first_name, $last_name,
            $contact_owner, $phone, $lifecycle_stage, $lead_status
        );
    }

    header("Location: /views/companies/view-company.php?company_id=$company_id&success=1");
    exit;

} catch (Exception $e) {
    header("Location: /views/companies/view-company.php?company_id=$company_id&error=" . urlencode($e->getMessage()));
    exit;
}