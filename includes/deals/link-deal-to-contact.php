<?php
require_once __DIR__ . '/../../config/session-config.php';
require_once __DIR__ . '/../../config/dbh.php';
require_once __DIR__ . '/../../controllers/deals-controller.php';
require_once __DIR__ . '/../../models/deals-model.php';
require_once __DIR__ . '/../../models/contacts-model.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /error.php");
    exit;
}

$deal_id = $_POST['deal_id'] ?? null;
$user_id = $_SESSION['user_id'] ?? null;

try {
    $dealController = new DealsController();
    $contactModel = new ContactsModel();
    $dealModel = new DealsModel();

    // If adding an existing contact
    if (isset($_POST['existing_contact_id']) && !empty($_POST['existing_contact_id'])) {
        $contact_id = $_POST['existing_contact_id'];
        $dealController->linkDealToContact($deal_id, $contact_id); 

    } else {
        // Creating and linking new contact
        $email = trim($_POST['email']);
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $contact_owner = trim($_POST['contact_owner']);
        $phone = trim($_POST['phone']);
        $lifecycle_stage = trim($_POST['lifecycle_stage']);
        $lead_status = trim($_POST['lead_status']);

        // Create contact
        $contact_id = $contactModel->insertContact(
            $user_id, $email, $first_name, $last_name,
            $contact_owner, $phone, $lifecycle_stage, $lead_status
        );

        var_dump($contact_id);
        // Link it to the deal
        $dealModel->linkDealToContact($deal_id, $contact_id);
    }
    var_dump($contact_id);

    header("Location: /views/deals/view-deal.php?contact_id=$contact_id&success=1");
    exit;

} catch (Exception $e) {
    header("Location: /views/deals/view-deal.php?error=" . urlencode($e->getMessage()));
    exit;
}
