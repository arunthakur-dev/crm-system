<?php
require_once '../../models/deals-model.php';
require_once '../../controllers/deals-controller.php';
require_once '../../config/session-config.php';  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize form data
    $title = trim($_POST['title'] ?? '');
    $deal_stage = trim($_POST['deal_stage'] ?? '');
    $amount = trim($_POST['amount'] ?? '');
    $close_date = trim($_POST['close_date'] ?? '');
    $deal_owner = trim($_POST['deal_owner'] ?? '');
    $deal_type = trim($_POST['deal_type'] ?? '');
    $priority = trim($_POST['priority'] ?? '');
    $associated_contact_id = $_POST['company_id'] ?? null;
    $associated_contact_id = $_POST['contact_id'] ?? null;
    $user_id = $_SESSION['user_id'];

    try {
        $dealsController = new DealsController();
        $dealsController->createDealAndLink(
            $user_id, $title, $deal_stage, $amount,
            $close_date, $deal_owner, $deal_type, $priority,
            $associated_contact_id, $associated_company_id
        );

        header('Location: /../views/deals/deals.php?status=success');
        exit;
    } catch (Exception $e) {
        header('Location: /../views/deals/deals.php?error=' . urlencode($e->getMessage()));
        exit;
    }
}
