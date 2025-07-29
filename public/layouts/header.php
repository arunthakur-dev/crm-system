<?php require_once __DIR__ . '/../../config/config.php'; ?>

<header class="navbar">
    <h2>CRM Dashboard</h2>
    <nav class="nav">
        <a href="<?= BASE_URL ?>/dashboard.php">Dashboard</a>
        <a href="<?= BASE_URL ?>/../views/companies/companies.php">Companies</a>
        <a href="<?= BASE_URL ?>/../views/contacts/contacts.php">Contacts</a>
        <a href="<?= BASE_URL ?>/../views/deals/deals.php">Deals</a>
        <a href="<?= BASE_URL ?>/../views/auth/logout.php" class="logout-box" style="color: #ff4d4d;">Logout</a>
    </nav>
</header>