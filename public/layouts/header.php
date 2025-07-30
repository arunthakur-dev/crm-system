<?php require_once __DIR__ . '/../../config/config.php'; ?>

<header class="navbar">
    <h2>CRM Dashboard</h2>
    <nav class="nav">
        <a href="<?php echo BASE_URL; ?>/dashboard.php">Dashboard</a>
        <a href="<?php echo VIEWS_URL; ?>/companies/companies.php">Companies</a>
        <a href="<?php echo VIEWS_URL; ?>/contacts/contacts.php">Contacts</a>
        <a href="<?php echo VIEWS_URL; ?>/deals/deals.php">Deals</a>
        <a href="<?php echo VIEWS_URL; ?>/auth/logout.php" class="logout-box" style="color: #ff4d4d;">Logout</a>
    </nav>
</header>
