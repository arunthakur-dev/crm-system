<?php
require_once __DIR__ . '/../../config/session-config.php';
require_once __DIR__ . '/../../includes/contacts/contacts-inc.php';
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
                <a href="../companies/companies.php" class="<?= $currentPage == 'companies.php' ? 'active' : '' ?>">Companies</a>
                <a href="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="<?= $currentPage == 'contacts.php' ? 'active' : '' ?>">Contacts</a>
                <a href="../deals/deals.php" class="<?= $currentPage == 'deals.php' ? 'active' : '' ?>">Deals</a>
                <a href="../auth/logout.php" class="logout-box" style="color: #ff4d4d;">Logout</a>
            </nav>
    </header>
    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert success">
            Contact deleted successfully.
            <button class="close-btn" onclick="this.parentElement.style.display='none';">×</button>
        </div>
    <?php endif; ?>
    <main class="main-content" id="main-content">
        <header>
            <h1>Contacts</h1>
            <div class="actions">
                <form method="GET" action="" class="search-form" style="display: flex; gap: 10px;">
                    <input 
                        type="text" 
                        name="search" 
                        value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" 
                        placeholder="Search by email, name, phone no..." 
                        class="search-input"
                    >
                    <input type="hidden" name="filter" value="<?= htmlspecialchars($filter) ?>">
                    <input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>">
                    <input type="hidden" name="order" value="<?= htmlspecialchars($order) ?>">
                    <button type="submit" class="btn ">Search</button>
                </form>

                <button class="btn open-sidebar-btn" data-target="contactSidebar">+ Create Contact</button>
                <?php include __DIR__ . '/_create-contact-form.php'; ?>
            </div>
        </header>
        <div class="company-tabs-wrapper">
        <div class="record-count">
            <span class="badge"><strong>Showing: </strong><?= ucfirst($filter) ?> Contacts (<?= count($contacts) ?> records)</span>
        </div>
        <div class="company-tabs-wrapper">
            <div class="company-tabs">
                <a href="?filter=all" class="tab-link <?= (!isset($_GET['filter']) || $_GET['filter'] === 'all') ? 'active' : '' ?>">All Conatcts</a>
                <a href="?filter=my" class="tab-link <?= ($_GET['filter'] ?? '') === 'my' ? 'active' : '' ?>">My Contacts</a>
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
                            'first_name.last_name'=> 'Name',
                            'first_name' => 'First Name',
                            'last_name' => 'Last Name',
                            'email' => 'Email',
                            'contact_owner' => 'Owner',
                            'phone' => 'Phone',
                            'lifecycle_stage' => 'Lifecycle Stage',
                            'lead_status' => 'Lead Status',
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
                    <?php if (empty($contacts)): ?>
                        <tr><td colspan="9">No contacts found.</td></tr>
                    <?php else: ?>
                        <?php foreach ($contacts as $contact): ?>
                            <tr>
                                <td>
                                    <form method="POST" action="view-contact.php" style="display:inline;">
                                        <input type="hidden" name="contact_id" value="<?= $contact['contact_id'] ?>">
                                        <button type="submit" class="link-button">
                                            <strong><?= htmlspecialchars($contact['first_name'] . ' ' . $contact['last_name']) ?></strong>
                                        </button>
                                    </form>
                                </td>
                                <td><?= htmlspecialchars($contact['email']) ?></td>
                                <td><?= htmlspecialchars($contact['first_name']) ?></td>
                                <td><?= htmlspecialchars($contact['last_name']) ?></td>
                                <td><?= htmlspecialchars($contact['contact_owner']) ?></td>
                                <td><?= htmlspecialchars($contact['phone']) ?></td>
                                <td><?= htmlspecialchars($contact['lifecycle_stage']) ?></td>
                                <td><?= htmlspecialchars($contact['lead_status']) ?></td>
                                <td><?= date('d M Y, h:i A', strtotime($contact['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
<?php
if (isset($contact)) {
    // Store contact ID in session for later use
    $_SESSION['contact_id'] = $contact['contact_id'];
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