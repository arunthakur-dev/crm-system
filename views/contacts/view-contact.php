<?php
require_once __DIR__ . '/../../config/session-config.php';
require_once __DIR__ . '/../../includes/contacts/view-contact-inc.php';
require_once __DIR__ . '/../../includes/companies/view-company-inc.php';
require_once __DIR__ . '/_edit-contact-form.php';
require_once __DIR__ . '/_delete-contact-form.php';

require_once __DIR__ . '/add-deal-form.php';
require_once __DIR__ . '/add-company-form.php';

$contactController = new ContactsController();
$contact = $contactController->getContactDetails($contact_id, $user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($contact['first_name'] . ' ' . $contact['last_name']) ?> | Contact Details</title>
    <link rel="stylesheet" href="/../../public/assets/css/view-company.css">
    <link rel="stylesheet" href="/../../public/assets/css/dashboard.css">
    <link rel="stylesheet" href="/../../public/assets/css/add-contact.css">
    <link rel="stylesheet" href="/../../public/assets/css/associated-tables.css">
    <script defer src="/../../public/assets/js/edit-company.js"></script>
    <script defer src="/../../public/assets/js/sidebar-forms.js"></script>
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
                <a href="../companies/companies.php" class="<?= $currentPage == 'companies.php.php' ? 'active' : '' ?>">Companies</a>
                <a href="contacts.php" class="<?= $currentPage == 'view-contact.php' ? 'active' : '' ?>">Contacts</a>
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
                <?php if (!empty($contact['logo'])): ?>
                    <img src="/uploads/contacts/<?= htmlspecialchars($contact['logo']) ?>" alt="Logo" class="company-logo">
                <?php else: ?>
                    <img src="/uploads/contacts/contacts-default.jpg" alt="Default Logo" class="company-logo">
                <?php endif; ?>
            </div>

            <div class="company-info">
                <h2 class="company-name"><?= htmlspecialchars($contact['first_name'] . ' ' . $contact['last_name']) ?></h2>
                <a href="http://<?= htmlspecialchars($contact['email']) ?>" target="_blank" class="company-domain">
                    <?= htmlspecialchars($contact['email']) ?>
                </a>
                <h2 class="phone"><?= htmlspecialchars($contact['phone']) ?></h2>
            </div>

            <!-- Floating edit button (visible on hover over ) -->
            <button class="edit-company-btn" title="Edit Company Info">+ Edit</button>
        </div>

        <!-- Actions -->
        <div class="company-actions">
            <button title="Note">🗒</button>
            <button title="Email">&#9993;</button>
            <button title="Call">&#9742;</button>
            <button title="Task">&#10004;</button>
            <button title="Meeting">&#128197;</button>
            <button title="More">&#8942;</button>
        </div>

        <!-- About Section -->
        <section class="company-sidebar-details">
            <div class="company-about-section">
            <h3>About this company</h3>

            <?php
            $fields = [
                'email' => 'Email',
                'contact_owner' => 'Owner',
                'phone' => 'Phone',
                'lifecycle_stage' => 'LifecycleStage',
                'lead_status' => 'Lead Status',
            ];

            foreach ($fields as $field => $label):
                $value = htmlspecialchars($contact[$field]) ?: '--';
            ?>
            <div class="editable-field" data-field="<?= $field ?>" data-value="<?= htmlspecialchars($contact[$field]) ?>">
                <label><?= $label ?></label>
                <div class="field-value">
                    <?= $value ?>
                    <button class="inline-edit-btn" title="Edit <?= $label ?>">Edit</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Delete Button -->
        <form id="deleteCompanyForm" action="/../../includes/contacts/delete-contact-inc.php" method="POST" style="margin-top: 20px; text-align: center;">
            <input type="hidden" name="contact_id" value="<?= $contact['contact_id'] ?>">
            <button type="button" class="delete-company-btn" id="triggerDeleteModal">Delete contact</button>
        </form>
        </section>
    </aside>

    <!-- Main Content -->
    <main class="company-main-content">
        <div class="company-tabs">
            <button class="active-tab">Overview</button>
        </div>

        <div class="summary-grid">
            <div><strong>Create Date:</strong><br><hr><?= date('d M Y h:i A', strtotime($contact['created_at'])) ?></div>
            <div><strong>Lifecycle Stage:</strong><br><hr>Lead</div>
            <div><strong>Last Activity Date:</strong><br><hr>----</div>
        </div>
        <div class="linked-section">
            <div class="section-header">
                <h3><strong>Associated Companies</strong></h3>
                <button class="add-btn" data-target="companySidebar">+ Add</button>
            </div>

            <?php if (empty($contactCompanies)): ?>
                <p>No associated contacts yet.</p>
            <?php else: ?>
                <div class="table-wrapper">
                    <table class="linked-table">
                        <thead>
                            <tr>
                                <th>COMPANY NAME</th>
                                <th>DOMAIN</th>
                                <th>INDUSTRY</th>
                                <th>COUNTRY</th>
                                <th>PHONE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contactCompanies as $company): ?>
                                <tr>
                                    <td>
                                        <div class="avatar-name">
                                            <div class="avatar-circle">
                                                <?= strtoupper(substr($company['name'], 0, 1)) ?>
                                            </div>
                                            <form method="POST" action="../companies/view-company.php" style="display:inline;">
                                                <input type="hidden" name="company_id" value="<?= $company['company_id'] ?>">
                                                <button type="submit" class="link-button">
                                                    <strong><?= htmlspecialchars($company['name']  ?? '') ?></strong>
                                                </button>
                                            </form>
                                    </td>
                                    <td><?= $company['company_domain'] ?: '--' ?></td>
                                    <td><?= $company['industry'] ?: '--' ?></td>
                                    <td><?= $company['country'] ?: '--' ?></td>
                                    <td><?= $contact['phone'] ?: '--' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="linked-section">
            <div class="section-header">
                    <h3><strong>Associated Deals</strong></h3>
                    <button class="add-btn" data-target="dealSidebar">+ Add</button>
                </div>
            <?php if (empty($contactDeals)): ?>
                <p>No associated contacts yet.</p>
            <?php else: ?>
                <div class="table-wrapper">
                    <table class="linked-table">
                        <thead>
                            <tr>
                                <th>TITLE</th>
                                <th>AMOUNT</th>
                                <th>CLOSE DATE</th>
                                <th>DEAL STAGE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contactDeals as $deal): ?>
                                <tr>
                                    <td>
                                        <div class="avatar-name">
                                            <div class="avatar-circle">
                                                <?= strtoupper(substr($deal['title'], 0, 1)) ?>
                                            </div>
                                            <form method="POST" action="../deals/view-deal.php" style="display:inline;">
                                                <input type="hidden" name="deal_id" value="<?= $deal['deal_id'] ?>">
                                                <button type="submit" class="link-button">
                                                    <strong><?= htmlspecialchars($deal['title']  ?? '') ?></strong>
                                                </button>
                                            </form>
                                    </td>
                                    <td><?= $deal['amount'] ?: '--' ?></td>
                                    <td><?= $deal['close_date'] ?: '--' ?></td>
                                    <td><?= $deal['deal_stage'] ?: '--' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

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




