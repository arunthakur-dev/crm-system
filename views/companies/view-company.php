<?php
require_once __DIR__ . '/../../config/session-config.php';
require_once __DIR__ . '/../../includes/view-company-inc.php';
require_once __DIR__ . '/_edit-company-form.php';
require_once __DIR__ . '/_delete-company-form.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($company['name']) ?> | Company Details</title>
    <link rel="stylesheet" href="/../../public/assets/css/view-company.css">
    <link rel="stylesheet" href="/../../public/assets/css/dashboard.css">
    <script defer src="/../../public/assets/js/edit-company.js"></script>
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
                <a href="companies.php" class="<?= $currentPage == 'view-company.php' ? 'active' : '' ?>">Companies</a>
                <a href="../contacts/contacts.php" class="<?= $currentPage == 'contacts.php' ? 'active' : '' ?>">Contacts</a>
                <a href="../deals/deals.php" class="<?= $currentPage == 'deals.php' ? 'active' : '' ?>">Deals</a>
                <a href="../auth/logout.php" class="logout-box" style="color: #ff4d4d;">Logout</a>
            </nav>
        </header>
        <div class="company-view-container">
        <!-- Sidebar -->
        <aside class="company-sidebar">
        <!-- Header -->
        <div class="company-header" id="companyHeader">
            <div class="company-logo-wrapper">
                <?php if (!empty($company['logo'])): ?>
                    <img src="/uploads/logos/<?= htmlspecialchars($company['logo']) ?>" alt="Logo" class="company-logo">
                <?php else: ?>
                    <img src="/public/assets/images/company-default.png" alt="Default Logo" class="company-logo">
                <?php endif; ?>
            </div>

            <div class="company-info">
                <h2 class="company-name"><?= htmlspecialchars($company['name']) ?></h2>
                <a href="http://<?= htmlspecialchars($company['company_domain']) ?>" target="_blank" class="company-domain">
                    <?= htmlspecialchars($company['company_domain']) ?>
                </a>
                <h2 class="phone"><?= htmlspecialchars($company['phone']) ?></h2>
            </div>

            <!-- Floating edit button (visible on hover over ) -->
            <button class="edit-company-btn" title="Edit Company Info">+ Edit</button>
        </div>

        <!-- Actions -->
        <div class="company-actions">
            <button title="Note">📝</button>
            <button title="Email">✉️</button>
            <button title="Call">📞</button>
            <button title="Task">✅</button>
            <button title="Meeting">📅</button>
            <button title="More">⋯</button>
        </div>

        <!-- About Section -->
        <section class="company-sidebar-details">
            <div class="company-about-section">
            <h3>About this company</h3>

            <?php
            $fields = [
                'owner' => 'Owner',
                'industry' => 'Industry',
                'country' => 'Country',
                'state' => 'State',
                'postal_code' => 'Postal Code',
                'employees' => 'Number of Employees',
            ];

            foreach ($fields as $field => $label):
                $value = htmlspecialchars($company[$field]) ?: '--';
            ?>
            <div class="editable-field" data-field="<?= $field ?>" data-value="<?= htmlspecialchars($company[$field]) ?>">
                <label><?= $label ?></label>
                <div class="field-value">
                    <?= $value ?>
                    <button class="inline-edit-btn" title="Edit <?= $label ?>">Edit</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Delete Button -->
        <form id="deleteCompanyForm" action="/../../includes/delete-company-inc.php" method="POST" style="margin-top: 20px; text-align: center;">
            <input type="hidden" name="company_id" value="<?= $company['company_id'] ?>">
            <button type="button" class="delete-company-btn" id="triggerDeleteModal">Delete Company</button>
        </form>
        </section>
    </aside>

    <!-- Main Content -->
    <main class="company-main-content">
        <div class="company-tabs">
            <button class="active-tab">Overview</button>
        </div>

        <div class="summary-grid">
            <div><strong>Create Date:</strong><br><hr><?= date('d M Y h:i A', strtotime($company['created_at'])) ?></div>
            <div><strong>Lifecycle Stage:</strong><br><hr>Lead</div>
            <div><strong>Last Activity Date:</strong><br><hr>----</div>
        </div>
        <div class="linked-section">
            <h3>Contacts</h3>
            <p>No associated contacts yet.</p>
        </div>

        <div class="linked-section">
            <h3>Companies</h3>
            <p>No associated deals yet.</p>
        </div>
        

        <div class="linked-section">
            <h3>Deals</h3>
            <p>No associated deals yet.</p>
        </div>
        
    </main>
</div>
<!-- Footer -->
    <footer class="footer">
        <p>&copy; <?= date('Y') ?> CRM System. All rights reserved.</p>
    </footer>
</div>

</body>
</html>




