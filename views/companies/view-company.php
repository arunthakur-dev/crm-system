<?php
require_once __DIR__ . '/../../config/session-config.php';
require_once __DIR__ . '/../../controllers/companies-controller.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid Company ID.");
}

$companyId = (int) $_GET['id'];
$userId = $_SESSION['user_id'];

$companyController = new CompaniesController();
$company = $companyController->getCompanyDetails($companyId, $userId);

if (!$company) {
    die("Company not found or access denied.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($company['name']) ?> | Company Details</title>
    <link rel="stylesheet" href="/../../public/assets/css/view-company.css">
</head>
<body>
<div class="company-view-container">
    <!-- Sidebar -->
    <aside class="company-sidebar">
        <div class="company-header">
            <img src="/assets/images/company-default.jpg" alt="Logo" class="company-logo">
            <h2><?= htmlspecialchars($company['name']) ?></h2>
            <a href="http://<?= htmlspecialchars($company['company_domain']) ?>" target="_blank"><?= htmlspecialchars($company['company_domain']) ?></a>
        </div>
        <div class="company-actions">
            <button>📞</button>
            <button>✉️</button>
            <button>📝</button>
            <button>📅</button>
            <button>⋯</button>
        </div>

        <section class="company-sidebar-details">
            <h3>About this company</h3>
            <p><strong>Industry:</strong> <?= htmlspecialchars($company['industry']) ?></p>
            <p><strong>Employees:</strong> <?= htmlspecialchars($company['employees']) ?></p>
            <p><strong>Country:</strong> <?= htmlspecialchars($company['country']) ?></p>
            <p><strong>State:</strong> <?= htmlspecialchars($company['state']) ?></p>
            <p><strong>Postal Code:</strong> <?= htmlspecialchars($company['postal_code']) ?></p>
            <p><strong>Owner:</strong> <?= htmlspecialchars($company['owner']) ?></p>
            <p><strong>Notes:</strong><br><?= nl2br(htmlspecialchars($company['notes'])) ?></p>
        </section>
    </aside>

    <!-- Main Content -->
    <main class="company-main-content">
        <div class="company-tabs">
            <button class="active-tab">Overview</button>
            <button>Activities</button>
            <button>Deals</button>
        </div>

        <div class="summary-grid">
            <div><strong>Create Date:</strong><br><?= date('d M Y h:i A', strtotime($company['created_at'])) ?></div>
            <div><strong>Lifecycle Stage:</strong><br>Lead</div>
            <div><strong>Last Activity Date:</strong><br>--</div>
        </div>

        <div class="activity-section">
            <h3>Recent activities</h3>
            <input type="text" placeholder="Search activities" />
            <div class="activity-empty">
                <img src="/assets/images/empty-state.svg" alt="No Activity" />
                <p>No activities.</p>
            </div>
        </div>

        <div class="linked-section">
            <h3>Contacts</h3>
            <p>No associated contacts yet.</p>
        </div>

        <div class="linked-section">
            <h3>Deals</h3>
            <p>No associated deals yet.</p>
        </div>
    </main>
</div>
</body>
</html>
