<?php
require_once __DIR__ . '/../../config/session-config.php';
require_once __DIR__ . '/../../controllers/companies-controller.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

$companyController = new CompaniesController();
$companies = $companyController->getCompanies($_SESSION['user_id']);
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
    <script defer src="/../../public/assets/js/sidebar-toggle.js"></script> <!-- optional -->
</head>
<body>

<div class="wrapper">
<?php require_once __DIR__ . '/../../public/layouts/header.php'; ?>
<main class="main-content" id="main-content">
    <div class="page-wrapper">
        <header>
            <h1>Companies</h1>
            <div class="actions">
                <input type="text" placeholder="Search name, industry..." class="search-input">
                <button class="btn open-sidebar-btn" data-target="companySidebar">+ Create Company</button>
                <?php include __DIR__ . '/_create-company-form.php'; ?>
            </div>
        </header>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Company Domain</th>
                        <th>Owner</th>
                        <th>Industry</th>
                        <th>Country</th>
                        <th>State/Region</th>
                        <th>Postal Code</th>
                        <th>Employees</th>
                        <th>Notes</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($companies as $company): ?>
                    <tr>
                        <td>
                            <a href="view-company.php?id=<?= $company['company_id'] ?>">
                                <?= htmlspecialchars($company['name']) ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($company['company_domain']) ?></td>
                        <td><?= htmlspecialchars($company['owner']) ?></td>
                        <td><?= htmlspecialchars($company['industry']) ?></td>
                        <td><?= htmlspecialchars($company['country']) ?></td>
                        <td><?= htmlspecialchars($company['state']) ?></td>
                        <td><?= htmlspecialchars($company['postal_code']) ?></td>
                        <td><?= htmlspecialchars($company['employees']) ?></td>
                        <td><?= htmlspecialchars($company['notes']) ?></td>
                        <td><?= date('d M Y', strtotime($company['created_at'])) ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($companies)): ?>
                    <tr><td colspan="6">No companies found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>


<?php require_once __DIR__ . '/../../public/layouts/footer.php'; ?>

</div>