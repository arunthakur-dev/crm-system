<?php
require_once __DIR__ . '/../config/session-config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../views/auth/login.php');
    exit();
}

$username = htmlspecialchars($_SESSION['username']);
$userId = $_SESSION['user_id'];

// Load Models
require_once __DIR__ . '/../models/companies-model.php';
require_once __DIR__ . '/../models/contacts-model.php';
require_once __DIR__ . '/../models/deals-model.php';

$companyModel = new CompanyModel();
$contactModel = new ContactModel();
$dealModel    = new DealModel();

$recentCompanies = $companyModel->getRecentCompanies($userId, 5);
$recentContacts  = $contactModel->getRecentContacts($userId, 5);
$recentDeals     = $dealModel->getRecentDeals($userId, 5);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | CRM</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>

<header class="navbar">
    <h1>CRM Dashboard</h1>
    <div class="navbar-right">
        <div class="username-box">Welcome, <strong><?php echo $username; ?></strong></div>
        <a href="/../views/auth/logout.php" class="logout-box">Logout</a>
    </div>
</header><br><hr>

<div class="container">
    <aside class="sidebar">
        <nav class="nav">
            <ul>
                <li><a href="/../views/companies/companies.php">Companies</a></li>
                <li><a href="/../views/contacts/contacts.php">Contacts</a></li>
                <li><a href="/../views/deals/deals.php">Deals</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main-content" id="main-content">
        <h2>Welcome, <?php echo $username; ?></h2>

        <section class="dashboard-section">
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

        <section class="dashboard-section">
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

        <section class="dashboard-section">
            <h3>Recent Deals</h3>
            <ul class="item-list">
                <?php foreach ($recentDeals as $deal): ?>
                    <li><?= htmlspecialchars($deal['title']) ?> - ₹<?= $deal['value'] ?></li>
                <?php endforeach; ?>
                <?php if (empty($recentDeals)): ?>
                    <li>No deals found.</li>
                <?php endif; ?>
            </ul>
        </section>
    </main>
</div>

<footer class="footer">
    <p>&copy; <?= date('Y') ?> CRM System. All rights reserved.</p>
</footer>

<script>
document.querySelectorAll('.nav a').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        fetch(this.getAttribute('href'))
            .then(res => res.text())
            .then(html => {
                document.getElementById('main-content').innerHTML = html;
            })
            .catch(err => {
                console.error("Error loading content:", err);
            });
    });
});
</script>

</body>
</html>
