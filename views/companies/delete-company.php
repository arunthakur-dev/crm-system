<?php
require_once __DIR__ . '/../../config/session-config.php';
require_once __DIR__ . '/../../controllers/companies-controller.php';

if (!isset($_GET['id'])) {
    die("Missing company ID.");
}

$controller = new CompaniesController();
$controller->deleteCompany($_GET['id'], $_SESSION['user_id']);

header("Location: companies.php");
exit();