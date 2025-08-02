<?php
require_once __DIR__ . '/../../config/session-config.php';
require_once __DIR__ . '/../../config/dbh.php';
require_once __DIR__ . '/../../controllers/deals-controller.php';
require_once __DIR__ . '/../../models/deals-model.php';

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

    $dealController = new DealsController();

    if (isset($_POST['existing_deal_id'])) {
        // Link existing deal to contact
        $deal_id = $_POST['existing_deal_id'];
        $dealController->linkDealToContact($deal_id, $contact_id);
    } else {
        // Create and link new deal
        $deal_name = trim($_POST['deal_name']);
        $deal_stage = trim($_POST['deal_stage']);
        $amount = trim($_POST['amount']);
        $pipeline = trim($_POST['pipeline']);
        $deal_owner = trim($_POST['deal_owner']);
        $company_id = trim($_POST['company_id']);

        if (!$deal_name || !$deal_stage || !$pipeline) {
            throw new Exception("Deal Name, Stage, and Pipeline are required.");
        }

        $new_deal_id = $dealController->createDealAndLink(
            $user_id,
            $contact_id,
            $company_id,
            $deal_name,
            $deal_stage,
            $amount,
            $pipeline,
            $deal_owner
        );
    }

    header("Location: /views/contacts/view-contact.php?contact_id=$contact_id&success=1");
    exit;

} catch (Exception $e) {
    header("Location: /views/contacts/view-contact.php?contact_id=$contact_id&error=" . urlencode($e->getMessage()));
    exit;
}
