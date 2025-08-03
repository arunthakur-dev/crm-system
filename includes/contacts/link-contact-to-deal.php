<?php
require_once __DIR__ . '/../../config/session-config.php';
require_once __DIR__ . '/../../config/dbh.php';
require_once __DIR__ . '/../../controllers/deals-controller.php';
require_once __DIR__ . '/../../models/deals-model.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /error.php");
    exit;
}

$user_id    = $_SESSION['user_id'] ?? null;
$contact_id = $_POST['contact_id'] ?? null;

try {
    if (!$user_id || !$contact_id) {
        throw new Exception("Missing contact or user ID.");
    }

    $dealController = new DealsController();

    if ($_POST['action'] === 'link_existing') {
        $existing_deal_id = $_POST['existing_deal_id'] ?? null;

        if (!$existing_deal_id) {
            throw new Exception("No deal selected.");
        }

        $dealController->linkDealToContact($existing_deal_id, $contact_id);

    } elseif ($_POST['action'] === 'create_new') {
        // Gather form inputs
        $title      = trim($_POST['title'] ?? '');
        $deal_stage      = trim($_POST['deal_stage'] ?? '');
        $amount     = trim($_POST['amount'] ?? '');
        $close_date = trim($_POST['close_date'] ?? '');
        $owner      = trim($_POST['deal_owner'] ?? '');
        $type       = trim($_POST['deal_type'] ?? '');
        $priority   = trim($_POST['priority'] ?? '');

        $new_deal_id = $dealController->createDealAndLink(
            $user_id, $title, $deal_stage, $amount,
            $close_date, $deal_owner, $deal_type, $priority,
        );

        if (!$new_deal_id) {
            throw new Exception("Failed to create new deal.");
        }

        $dealController->linkDealToContact($new_deal_id, $contact_id);
    }

    header("Location: /views/contacts/view-contact.php?contact_id=$contact_id&success=1");
    exit;

} catch (Exception $e) {
    header("Location: /views/contacts/view-contact.php?contact_id=$contact_id&error=" . urlencode($e->getMessage()));
    exit;
}
