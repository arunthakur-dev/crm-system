<?php
require_once __DIR__ . '/../../controllers/companies-controller.php';
session_start();

if (!isset($_GET['id'], $_SESSION['user_id'])) {
    http_response_code(403);
    exit("Unauthorized access");
}

$companyId = (int) $_GET['id'];
$userId = $_SESSION['user_id'];

$controller = new CompaniesController();
$company = $controller->getCompanyById($companyId, $userId);

if (!$company) {
    http_response_code(404);
    exit("Company not found or access denied.");
}
?>

<div class="sidebar visible" id="edit-company-sidebar">
    <div class="sidebar-header blue-header">
        <h2>Edit Company - <?= htmlspecialchars($company['name']) ?></h2>
        <button class="close-sidebar-btn" onclick="closeSidebar()">✖</button>
    </div>
    <form action="/includes/update-company-inc.php" method="POST">
        <input type="hidden" name="company_id" value="<?= $company['company_id'] ?>">

        <label>Company Domain</label>
        <input type="text" name="company_domain" value="<?= htmlspecialchars($company['company_domain']) ?>">

        <label>Company Name *</label>
        <input type="text" name="name" required value="<?= htmlspecialchars($company['name']) ?>">

        <label>Owner</label>
        <input type="text" name="owner" value="<?= htmlspecialchars($company['owner']) ?>">

        <label>Industry</label>
        <input type="text" name="industry" value="<?= htmlspecialchars($company['industry']) ?>">

        <label>Country</label>
        <input type="text" name="country" value="<?= htmlspecialchars($company['country']) ?>">

        <label>State</label>
        <input type="text" name="state" value="<?= htmlspecialchars($company['state']) ?>">

        <label>Postal Code</label>
        <input type="text" name="postal_code" value="<?= htmlspecialchars($company['postal_code']) ?>">

        <label>Employees</label>
        <input type="number" name="employees" value="<?= htmlspecialchars($company['employees']) ?>">

        <label>Notes</label>
        <textarea name="notes"><?= htmlspecialchars($company['notes']) ?></textarea>

        <br>
        <button type="submit" name="update_company">Update Company</button>
    </form>
</div>
