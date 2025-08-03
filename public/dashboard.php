<?php
require_once __DIR__ . '/../config/session-config.php';

// Block access without login
if (!isset($_SESSION['user_id'])) {
    header('Location: /public/index.php');
    exit();
}

$username = htmlspecialchars($_SESSION['username']);
$user_id = $_SESSION['user_id'];

require_once __DIR__ . '/../models/companies-model.php';
require_once __DIR__ . '/../models/contacts-model.php';
require_once __DIR__ . '/../models/deals-model.php';
$companyModel = new CompaniesModel();
$contactModel = new ContactsModel();
$dealModel    = new DealsModel();

$recentCompanies = $companyModel->fetchRecentSortedCompanies($user_id, 7);
$recentContacts  = $contactModel->getSortedRecentContacts($user_id, 7);
$recentDeals     = $dealModel->getSortedRecentDeals($user_id, 7);
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
    <header class="navbar">
        <h2>CRM Demo</h2>
        <?php
        $currentPage = basename($_SERVER['PHP_SELF']);
        ?>
        <nav class="nav">
            <a href="dashboard.php" class="<?= $currentPage == 'dashboard.php' ? 'active' : '' ?>">Dashboard</a>
            <a href="/../../views/companies/companies.php" class="<?= $currentPage == 'companies.php' ? 'active' : '' ?>">Companies</a>
            <a href="/../../views/contacts/contacts.php" class="<?= $currentPage == 'contacts.php' ? 'active' : '' ?>">Contacts</a>
            <a href="/../../views/deals/deals.php" class="<?= $currentPage == 'deals.php' ? 'active' : '' ?>">Deals</a>
            <a href="/../../views/auth/logout.php" class="logout-box" style="color: #ff4d4d;">Logout</a>
        </nav>

    </header>

    <main class="main-content" id="main-content"><br><br>        
        <!-- Grid Layout -->
        <div class="dashboard-grid">
            <section class="dashboard-box">
                <h3>Recent Companies</h3>
                <ol class="item-list">
                    <?php if (empty($recentCompanies)): ?>
                        <li>No companies yet.</li>
                    <?php endif; ?>
                    <?php foreach ($recentCompanies as $company): ?>
                        <li><strong>Company Name: </strong><?= htmlspecialchars($company['name'] ?: "--") ?>,   <strong>Industry: </strong><?= htmlspecialchars($company['industry'] ?: "--") ?></li>
                    <?php endforeach; ?>
                </ol>
            </section>
            <section class="dashboard-box">
                <h3>Recent Contacts</h3>
                <ul class="item-list">
                    <?php foreach ($recentContacts as $contact): ?>
                        <li><strong>Name: </strong><?= htmlspecialchars($contact['first_name'] ?: "--" . " " . $contact['last_name'] ?: "--" )?>,   <strong>Email: </strong> <?= htmlspecialchars($contact['email'] ?: "--") ?>,    <strong>Phone: </strong> <?= htmlspecialchars($contact['phone'] ?: "--") ?> </li>
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
                        <li><strong>Title: </strong><?= htmlspecialchars($deal['title']) ?>,    <strong>Amount: </strong> ₹<?= number_format($deal['amount'], 2) ?>,   <strong>Close Date: </strong><?= htmlspecialchars($deal['close_date']) ?></li>
                    <?php endforeach; ?>
                    <?php if (empty($recentDeals)): ?>
                        <li>No deals found.</li>
                    <?php endif; ?>
                </ul>
            </section>
            <section class="dashboard-box">
                <h3>+ Add new Section</h3>
                <a href="" class="create-btn">+ Create New Section</a>
            </section>
        </div>     
    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; <?= date('Y') ?> CRM System. All rights reserved.</p>
    </footer>

</div>
</body>
</html>
