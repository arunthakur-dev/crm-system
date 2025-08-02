<?php
require_once '../../models/contacts-model.php';
require_once '../../controllers/contacts-controller.php';
require_once '../../config/session-config.php';  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize form data
    $email = trim($_POST['email'] ?? '');
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $contact_owner = trim($_POST['contact_owner'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $lifecycle_stage = trim($_POST['lifecycle_stage'] ?? '');
    $lead_status = trim($_POST['lead_status'] ?? '');
    $contact_id = $_SESSION['contact_id'];
    $user_id        = $_SESSION['user_id']; // from logged-in user session

    // Pass to controller
    $contactController = new ContactsController();
    $contactController->createContact($user_id, $email, $first_name, $last_name, $contact_owner, $phone, $lifecycle_stage, $lead_status);

    // Redirect after success (optional)
    header('Location: /../views/contacts/contacts.php?status=success');
    exit;
}
