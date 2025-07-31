<?php
require_once __DIR__ . '/../../config/session-config.php';
require_once __DIR__ . '/../../includes/companies/companies-inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Companies | CRM</title>
    <link rel="stylesheet" href="/../../public/assets/css/companies.css">
    <link rel="stylesheet" href="/../../public/assets/css/create-company-form.css">
    <link rel="stylesheet" href="/../../public/assets/css/dashboard.css">
    <script defer src="/../../public/assets/js/sidebar-toggle.js"></script> 
</head>
<body>

<div class="wrapper">
    <header class="navbar">
        <h2>CRM Demo</h2>
        <?php
            $currentPage = basename($_SERVER['PHP_SELF']);
            ?>
        <nav class="nav">
                <a href="/../../public/dashboard.php" class="<?= $currentPage == 'dashboard.php' ? 'active' : '' ?>">Dashboard</a>
                <a href="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="<?= $currentPage == 'companies.php' ? 'active' : '' ?>">Companies</a>
                <a href="../contacts/contacts.php" class="<?= $currentPage == 'contacts.php' ? 'active' : '' ?>">Contacts</a>
                <a href="../deals/deals.php" class="<?= $currentPage == 'deals.php' ? 'active' : '' ?>">Deals</a>
                <a href="../auth/logout.php" class="logout-box" style="color: #ff4d4d;">Logout</a>
            </nav>
    </header>
    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert success">
            Company deleted successfully.
            <button class="close-btn" onclick="this.parentElement.style.display='none';">×</button>
        </div>
    <?php endif; ?>
    <main class="main-content" id="main-content">
        <header>
            <h1>Companies</h1>
            <div class="actions">
                <form method="GET" action="" class="search-form" style="display: flex; gap: 10px;">
                    <input 
                        type="text" 
                        name="search" 
                        value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" 
                        placeholder="Search by name, industry, domain, owner, location..." 
                        class="search-input"
                    >
                    <input type="hidden" name="filter" value="<?= htmlspecialchars($filter) ?>">
                    <input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>">
                    <input type="hidden" name="order" value="<?= htmlspecialchars($order) ?>">
                    <button type="submit" class="btn ">Search</button>
                </form>

                <button class="btn open-sidebar-btn" data-target="companySidebar">+ Create Company</button>
                <?php include __DIR__ . '/_create-company-form.php'; ?>
            </div>
        </header>
        <div class="company-tabs-wrapper">
        <div class="record-count">
            <span class="badge"><strong>Showing: </strong><?= ucfirst($filter) ?> Companies (<?= count($companies) ?> records)</span>
        </div>
        <div class="company-tabs">
            <a href="?filter=all" class="tab-link <?= (!isset($_GET['filter']) || $_GET['filter'] === 'all') ? 'active' : '' ?>">All companies</a>
            <a href="?filter=my" class="tab-link <?= (isset($_GET['filter']) && $_GET['filter'] === 'my') ? 'active' : '' ?>">My companies</a>
            <a href="?filter=recent" class="tab-link <?= (isset($_GET['filter']) && $_GET['filter'] === 'recent') ? 'active' : '' ?>">Recently Added</a>
        </div>
        </div><br>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>
                            <a href="?filter=<?= $filter ?>&sort=name&order=<?= ($sort == 'name' && $order == 'asc') ? 'desc' : 'asc' ?>">
                                Company Name <?= $sort === 'name' ? ($order === 'asc' ? '▲' : '▼') : '' ?>
                            </a>
                        </th>
                        <th>
                            <a href="?filter=<?= $filter ?>&sort=company_domain&order=<?= ($sort == 'company_domain' && $order == 'asc') ? 'desc' : 'asc' ?>">
                                Company Domain <?= $sort === 'company_domain' ? ($order === 'asc' ? '▲' : '▼') : '' ?>
                            </a>
                        </th>
                        <th>
                            <a href="?filter=<?= $filter ?>&sort=owner&order=<?= ($sort == 'owner' && $order == 'asc') ? 'desc' : 'asc' ?>">
                                Owner <?= $sort === 'owner' ? ($order === 'asc' ? '▲' : '▼') : '' ?>
                            </a>
                        </th>
                        <th>
                            <a href="?filter=<?= $filter ?>&sort=industry&order=<?= ($sort == 'industry' && $order == 'asc') ? 'desc' : 'asc' ?>">
                                Industry <?= $sort === 'industry' ? ($order === 'asc' ? '▲' : '▼') : '' ?>
                            </a>
                        </th>
                        <th>
                            <a href="?filter=<?= $filter ?>&sort=country&order=<?= ($sort == 'country' && $order == 'asc') ? 'desc' : 'asc' ?>">
                                Country <?= $sort === 'country' ? ($order === 'asc' ? '▲' : '▼') : '' ?>
                            </a>
                        </th>
                        <th>
                            <a href="?filter=<?= $filter ?>&sort=state&order=<?= ($sort == 'state' && $order == 'asc') ? 'desc' : 'asc' ?>">
                                State <?= $sort === 'state' ? ($order === 'asc' ? '▲' : '▼') : '' ?>
                            </a>
                        </th>
                        <th>
                            <a href="?filter=<?= $filter ?>&sort=postal_code&order=<?= ($sort == 'postal_code' && $order == 'asc') ? 'desc' : 'asc' ?>">
                                Postal Code <?= $sort === 'postal_code' ? ($order === 'asc' ? '▲' : '▼') : '' ?>
                            </a>
                        </th>
                        <th>
                            <a href="?filter=<?= $filter ?>&sort=employees&order=<?= ($sort == 'employees' && $order == 'asc') ? 'desc' : 'asc' ?>">
                                Employees <?= $sort === 'employees' ? ($order === 'asc' ? '▲' : '▼') : '' ?>
                            </a>
                        </th>
                        <th>Notes</th>
                        <th>
                            <a href="?filter=<?= $filter ?>&sort=created_at&order=<?= ($sort == 'created_at' && $order == 'asc') ? 'desc' : 'asc' ?>">
                                Created <?= $sort === 'created_at' ? ($order === 'asc' ? '▲' : '▼') : '' ?>
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($companies)): ?>
                        <tr><td colspan="10">No companies found.</td></tr>
                    <?php else: ?>
                        <?php foreach ($companies as $company): ?>
                            <tr>
                                <td>
                                    <form method="POST" action="view-company.php" style="display:inline;">
                                        <input type="hidden" name="company_id" value="<?= $company['company_id'] ?>">
                                        <button type="submit" class="link-button">
                                            <strong><?= htmlspecialchars($company['name']) ?></strong>
                                        </button>
                                    </form>
                                </td>
                                <td><?= htmlspecialchars($company['company_domain']) ?></td>
                                <td><?= htmlspecialchars($company['owner']) ?></td>
                                <td><?= htmlspecialchars($company['industry']) ?></td>
                                <td><?= htmlspecialchars($company['country']) ?></td>
                                <td><?= htmlspecialchars($company['state']) ?></td>
                                <td><?= htmlspecialchars($company['postal_code']) ?></td>
                                <td><?= htmlspecialchars($company['employees']) ?></td>
                                <td><?= htmlspecialchars($company['notes']) ?></td>
                                <td><?= date('d M Y, h:i A', strtotime($company['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
<?php
if (isset($company)) {
    // Store company ID in session for later use
    $_SESSION['company_id'] = $company['company_id'];
}  
?>
    <!-- Footer -->
    <footer class="footer">
        <p>&copy; <?= date('Y') ?> CRM System. All rights reserved.</p>
    </footer>
</div>
<script>
    setTimeout(() => {
        const alert = document.querySelector('.alert.success');
        if (alert) alert.style.display = 'none';
    }, 4000); // Auto-hides in 4 seconds
</script>