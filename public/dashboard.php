<?php
require_once __DIR__ . '/../config/session-config.php';

// Block caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Block access without login
if (!isset($_SESSION['user_id'])) {
    header('Location: /public/index.php');
    exit();
}

$username = htmlspecialchars($_SESSION['username']);
$userId = $_SESSION['user_id'];

require_once __DIR__ . '/../models/companies-model.php';
require_once __DIR__ . '/../models/contacts-model.php';
require_once __DIR__ . '/../models/deals-model.php';
// // $companyModel = new CompanyModel();
// $contactModel = new ContactModel();
// $dealModel    = new DealModel();

//$recentCompanies = $companyModel->getRecentCompanies($userId, 5);
// $recentContacts  = $contactModel->getRecentContacts($userId, 5);
// $recentDeals     = $dealModel->getRecentDeals($userId, 5);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | CRM</title>
    <link rel="stylesheet" href="../public/assets/css/dashboard.css">
    <link rel="stylesheet" href="/../../public/assets/css/create-company-form.css">
    <script src="/assets/js/sidebar-toggle.js"></script>
</head>
<body>

<div class="wrapper">
    <!-- Navbar with menu -->
    <?php require_once __DIR__ . '/layouts/header.php'; ?>


    <main class="main-content" id="main-content">
        <!-- Centered Welcome Box -->
        <section class="welcome-box">
            <h2>Welcome, <?= $username ?>!</h2>
            <p>This is your personalized CRM dashboard. From here, you can manage companies, contacts, and deals.</p>
            <button class="create-btn open-sidebar-btn" data-target="companySidebar">+ Create Company</button>
        </section>
        <!-- Company Sidebar -->
        <?php include __DIR__ . '/../views/companies/_create-company-form.php'; ?>
        
        <!-- Grid Layout -->
        <div class="dashboard-grid">
            <section class="dashboard-box">
                <h3>Recent Companies</h3>
                <ul class="item-list">
                    <?php foreach ($recentCompanies as $company): ?>
                        <li><?= htmlspecialchars($company['name']) ?> - <?= htmlspecialchars($company['industry']) ?></li>
                    <?php endforeach; ?>
                    <?php if (empty($recentCompanies)): ?>
                        <li>No companies yet.</li>
                    <?php endif; ?>
                </ul>
            </section>
            <section class="dashboard-box">
                <h3>Recent Contacts</h3>
                <ul class="item-list">
                    <?php foreach ($recentContacts as $contact): ?>
                        <li><?= htmlspecialchars($contact['full_name']) ?> - <?= htmlspecialchars($contact['email']) ?></li>
                    <?php endforeach; ?>
                    <?php if (empty($recentContacts)): ?>
                        <li>No contacts added.</li>
                    <?php endif; ?>
                </ul>
            </section>
        </div>
        <br>
        <div class="dashboard-grid">
            <section class="dashboard-box">
                <h3>Recent Deals</h3>
                <ul class="item-list">
                    <?php foreach ($recentDeals as $deal): ?>
                        <li><?= htmlspecialchars($deal['title']) ?> - ₹<?= number_format($deal['value'], 2) ?></li>
                    <?php endforeach; ?>
                    <?php if (empty($recentDeals)): ?>
                        <li>No deals found.</li>
                    <?php endif; ?>
                </ul>
            </section>
            <section class="dashboard-box">
                <h3>+ Add new Section</h3>
                <a href="/../views/companies/create-company.php" class="create-btn">+ Create New Section</a>
            </section>
        </div>     
    </main>

    <?php require_once __DIR__ . '/layouts/footer.php'; ?>

</div>
</body>
</html>
