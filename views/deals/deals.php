<?php
require_once __DIR__ . '/../../config/session-config.php';
require_once __DIR__ . '/../../includes/deals/deals-inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deals | CRM</title>
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
                <a href="../companies/companies.php" class="<?= $currentPage == 'companies.php' ? 'active' : '' ?>">Companies</a>
                <a href="../contacts/contacts.php" class="<?= $currentPage == 'contacts.php' ? 'active' : '' ?>">Contacts</a>
                <a href="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="<?= $currentPage == 'deals.php' ? 'active' : '' ?>">Deals</a>
                
                <a href="../auth/logout.php" class="logout-box" style="color: #ff4d4d;">Logout</a>
            </nav>
    </header>
    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert success">
            Success: Deal deleted successfully.
            <button class="close-btn" onclick="this.parentElement.style.display='none';">×</button>
        </div>
    <?php endif; ?>
    <main class="main-content" id="main-content">
        <header>
            <h1>Deals</h1>
            <div class="actions">
                <form method="GET" action="" class="search-form" style="display: flex; gap: 10px;">
                    <input 
                        type="text" 
                        name="search" 
                        value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" 
                        placeholder="Search by title, type, stage..." 
                        class="search-input"
                    >
                    <input type="hidden" name="filter" value="<?= htmlspecialchars($filter) ?>">
                    <input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>">
                    <input type="hidden" name="order" value="<?= htmlspecialchars($order) ?>">
                    <button type="submit" class="btn ">Search</button>
                </form>

                <button class="btn open-sidebar-btn" data-target="contactSidebar">+ Create Deal</button>
                <?php include __DIR__ . '/_create-deal-form.php'; ?>
            </div>
        </header>
        <div class="company-tabs-wrapper">
        <div class="record-count">
            <span class="badge"><strong>Showing: </strong><?= ucfirst($filter) ?> Deals (<?= count($deals) ?> records)</span>
        </div>
        <div class="company-tabs-wrapper">
            <div class="company-tabs">
                <a href="?filter=all" class="tab-link <?= (!isset($_GET['filter']) || $_GET['filter'] === 'all') ? 'active' : '' ?>">All Deals</a>
                <a href="?filter=recent" class="tab-link <?= ($_GET['filter'] ?? '') === 'recent' ? 'active' : '' ?>">Recently Added</a>
            </div>
        </div>
        </div><br>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <?php
                        $fields = [
                            'title' => 'Title',
                            'deal_stage' => 'Stage',
                            'amount' => 'Amount',
                            'close_date' => 'Close Date',
                            'deal_owner' => 'Owner',
                            'deal_type' => 'Type',
                            'priority' => 'Priority',
                            'created_at' => 'Created'
                        ];

                        foreach ($fields as $key => $label):
                            $arrow = ($sort === $key) ? ($order === 'asc' ? '▲' : '▼') : '';
                            $newOrder = ($sort === $key && $order === 'asc') ? 'desc' : 'asc';
                        ?>
                            <th>
                                <a href="?filter=<?= $filter ?>&sort=<?= $key ?>&order=<?= $newOrder ?>">
                                    <?= $label ?> <?= $arrow ?>
                                </a>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($deals)): ?>
                        <tr><td colspan="8">No deals found.</td></tr>
                    <?php else: ?>
                        <?php foreach ($deals as $deal): ?>
                            <tr>
                                <td>
                                    <form method="POST" action="view-deal.php" style="display:inline;">
                                        <input type="hidden" name="deal_id" value="<?= $deal['deal_id'] ?>">
                                        <button type="submit" class="link-button">
                                            <strong><?= htmlspecialchars($deal['title']) ?></strong>
                                        </button>
                                    </form>
                                </td>
                                <td><?= htmlspecialchars($deal['deal_stage']) ?: '--'?></td>
                                <td>₹<?= number_format($deal['amount'], 2) ?: '--' ?></td>
                                <td><?= htmlspecialchars($deal['close_date']) ?: '--'?></td>
                                <td><?= htmlspecialchars($deal['deal_owner']) ?: '--'?></td>
                                <td><?= htmlspecialchars($deal['deal_type']) ?: '--'?></td>
                                <td>
                                    <?php
                                    switch ($deal['priority']) {
                                        case 0: echo 'Low'; break;
                                        case 1: echo 'Medium'; break;
                                        case 2: echo 'High'; break;
                                        default: echo '—';
                                    }
                                    ?>
                                </td>
                                <td><?= date('d M Y, h:i A', strtotime($deal['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
<?php
if (isset($deal)) {
    // Store deal ID in session for later use
    $_SESSION['deal_id'] = $deal['deal_id'];
}  
?>
<!-- Footer -->
<footer class="footer">
    <p>&copy; <?= date('Y') ?> CRM System. All rights reserved.</p>
</footer>
</div>

<!-- Script to auto-hide success alert after 4 seconds -->
<script>
    setTimeout(() => {
        const alert = document.querySelector('.alert.success');
        if (alert) alert.style.display = 'none';
    }, 4000); // Auto-hides in 4 seconds
</script>