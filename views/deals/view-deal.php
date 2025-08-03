<?php
require_once __DIR__ . '/../../config/session-config.php';
require_once __DIR__ . '/../../includes/deals/view-deal-inc.php';
require_once __DIR__ . '/_edit-deal-form.php';
require_once __DIR__ . '/_delete-deal-form.php';

require_once __DIR__ . '/add-company-form.php';
require_once __DIR__ . '/add-contact-form.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($deal['title']) ?> | Deal Details</title>
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
        <?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
        <nav class="nav">
            <a href="/../../public/dashboard.php" class="<?= $currentPage == 'dashboard.php' ? 'active' : '' ?>">Dashboard</a>
            <a href="../companies/companies.php" class="<?= $currentPage == 'companies.php' ? 'active' : '' ?>">Companies</a>
            <a href="../contacts/contacts.php" class="<?= $currentPage == 'contacts.php' ? 'active' : '' ?>">Contacts</a>
            <a href="deals.php" class="<?= $currentPage == 'view-deal.php' ? 'active' : '' ?>">Deals</a>
            <a href="../auth/logout.php" class="logout-box" style="color: #ff4d4d;">Logout</a>
        </nav>
    </header>

    <div class="company-view-container">
        <!-- Sidebar -->
        <aside class="company-sidebar">
            <div class="company-header">
                <div class="company-info">
                    <h2 class="company-name"><?= htmlspecialchars($deal['title']) ?></h2>
                    <h4 class="company-domain"><?= htmlspecialchars($deal['deal_type']) ?> | ₹<?= number_format($deal['amount'], 2) ?></h4>
                    <p class="phone">Close Date: <?= htmlspecialchars($deal['close_date']) ?></p>
                </div>
                <button class="edit-company-btn" title="Edit Deal Info">+ Edit</button>
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

            <!-- About -->
            <section class="company-sidebar-details">
                <div class="company-about-section">
                    <h3>About this deal</h3>
                    <?php
                        $fields = [
                            'deal_stage' => 'Stage',
                            'deal_owner' => 'Owner',
                            'priority' => 'Priority',
                            'created_at' => 'Created At'
                        ];

                        foreach ($fields as $key => $label):
                            $value = htmlspecialchars($deal[$key]) ?: '--';

                            if ($key === 'priority') {
                                $value = match((int)$deal[$key]) {
                                    0 => 'Low',
                                    1 => 'Medium',
                                    2 => 'High',
                                    default => '--'
                                };
                            }

                            if ($key === 'created_at') {
                                $value = date('d M Y, h:i A', strtotime($deal[$key]));
                            }
                        ?>
                        <div class="editable-field" data-field="<?= $key ?>" data-value="<?= htmlspecialchars($deal[$key]) ?>">
                            <label><?= $label ?></label>
                            <div class="field-value">
                                <?= $value ?>
                                    <button class="inline-edit-btn" title="Edit <?= $label ?>">Edit</button>
                            </div>
                        </div>
                        <?php endforeach; ?>

                </div>

                <form id="deleteCompanyForm" action="../../includes/deals/delete-deal-inc.php" method="POST" style="margin-top: 20px; text-align: center;">
                    <input type="hidden" name="deal_id" value="<?= $deal['deal_id'] ?>">
                    <button type="button" class="delete-company-btn" id="triggerDeleteModal">Delete Deal</button>
                </form>
            </section>
        </aside>

        <!-- Main content -->
        <main class="company-main-content">
            <div class="company-tabs">
                <button class="active-tab">Overview</button>
            </div>

            <div class="summary-grid">
                <div><strong>Create Date:</strong><br><hr><?= date('d M Y h:i A', strtotime($deal['created_at'])) ?></div>
                <div><strong>Stage:</strong><br><hr><?= htmlspecialchars($deal['deal_stage']) ?></div>
                <div><strong>Type:</strong><br><hr><?= htmlspecialchars($deal['deal_type']) ?></div>
            </div>

            <div class="linked-section">
                <div class="section-header">
                    <h3><strong>Associated Contacts</strong></h3>
                    <button class="add-btn" data-target="contactSidebar">+ Add</button>
                </div>
                <?php if (empty($dealContacts)): ?>
                    <p>No associated contacts yet.</p>
                <?php else: ?>
                    <div class="table-wrapper">
                        <table class="linked-table">
                            <thead>
                                <tr>
                                    <th>NAME</th>
                                    <th>EMAIL</th>
                                    <th>PHONE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dealContacts as $contact): ?>
                                    <tr>
                                        <td>
                                            <div class="avatar-name">
                                                <div class="avatar-circle">
                                                    <?= strtoupper(substr($contact['first_name'], 0, 1)) ?>
                                                </div>
                                                <form method="POST" action="../contacts/view-contact.php" style="display:inline;">
                                                    <input type="hidden" name="contact_id" value="<?= $contact['contact_id'] ?>">
                                                    <button type="submit" class="link-button">
                                                        <strong><?= htmlspecialchars($contact['first_name'] . ' ' . $contact['last_name'] ?? '') ?></strong>
                                                    </button>
                                                </form>
                                        </td>
                                        
                                        <td><?= htmlspecialchars($contact['email']) ?></td>
                                        <td><?= htmlspecialchars($contact['phone']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <div class="linked-section">
                <div class="section-header">
                    <h3><strong>Associated Companies</strong></h3>
                    <button class="add-btn" data-target="companySidebar">+ Add</button>
                </div>
                <?php if (empty($dealCompanies)): ?>
                    <p>No associated companies yet.</p>
                <?php else: ?>
                    <div class="table-wrapper">
                        <table class="linked-table">
                            <thead>
                                <tr>
                                    <th>COMPANY</th>
                                    <th>INDUSTRY</th>
                                    <th>COUNTRY</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dealCompanies as $company): ?>
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
                                        <td><?= htmlspecialchars($company['industry']) ?: '--' ?></td>
                                        <td><?= htmlspecialchars($company['country']) ?: '--'?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <footer class="footer">
        <p>&copy; <?= date('Y') ?> CRM System. All rights reserved.</p>
    </footer>
</div>
</body>
</html>
<script>
// ===== Deal Field Modal Logic =====

const dealFieldModal = document.getElementById('deal-editable-field');
const dealFieldForm = document.getElementById('dealFieldForm');
const fieldNameInput = document.getElementById('deal_field_name');
const fieldValueInput = document.getElementById('deal_field_value');
const fieldLabel = document.getElementById('deal_field_label');

// Trigger modal on inline-edit-btn click
document.querySelectorAll('.editable-field').forEach(field => {
    const editBtn = field.querySelector('.inline-edit-btn');

    if (!editBtn) return; // Defensive

    editBtn.addEventListener('click', function (e) {
        e.stopPropagation();

        const fieldKey = field.dataset.field;
        const rawValue = field.dataset.value || '';
        const label = field.querySelector('label')?.innerText || 'Field';

        // Set form values
        fieldNameInput.value = fieldKey;
        fieldValueInput.value = rawValue;
        fieldLabel.innerText = label;

        // Optional: Adjust input type based on field type
        if (fieldKey === 'created_at') {
            fieldValueInput.type = 'datetime-local';
            // Convert PHP date string to input format if needed
            try {
                const isoString = new Date(rawValue).toISOString().slice(0, 16);
                fieldValueInput.value = isoString;
            } catch {}
        } else {
            fieldValueInput.type = 'text';
        }

        // Show modal
        dealFieldModal.style.display = 'flex';
    });
});

// Close modal logic
document.querySelectorAll('.close-about-modal').forEach(btn => {
    btn.addEventListener('click', () => {
        dealFieldModal.style.display = 'none';
    });
});

// Dismiss modal when clicking outside
window.addEventListener('click', function (e) {
    if (e.target === dealFieldModal) {
        dealFieldModal.style.display = 'none';
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const editBtn = document.querySelector('.edit-deal-btn');
    const modal = document.getElementById('editDealModal');
    const closeBtn = modal?.querySelector('.close-modal');

    if (!editBtn || !modal || !closeBtn) {
        console.warn('Edit modal elements not found. Is _edit-deal-form.php loaded correctly?');
        return;
    }

    editBtn.addEventListener('click', () => {
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    });

    closeBtn.addEventListener('click', () => {
        modal.classList.remove('show');
        document.body.style.overflow = '';
    });

    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('show');
            document.body.style.overflow = '';
        }
    });
});


</script>