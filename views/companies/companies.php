<?php
require_once __DIR__ . '/../../config/session-config.php';
require_once __DIR__ . '/../../controllers/companies-controller.php';

$companyController = new CompanyController();
$companies = $companyController->getCompanies($_SESSION['user_id']);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Companies</title>
    <link rel="stylesheet" href="../../assets/css/companies.css">
</head>
<body>

<div class="page-wrapper">
    <header>
        <h1>Companies</h1>
        <div class="actions">
            <input type="text" placeholder="Search name, industry..." class="search-input">
            <a href="create-company.php" class="btn">+ Create Company</a>
        </div>
    </header>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Industry</th>
                    <th>Location</th>
                    <th>Notes</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($companies as $company): ?>
                <tr>
                    <td><?= htmlspecialchars($company['name']) ?></td>
                    <td><?= htmlspecialchars($company['industry']) ?></td>
                    <td><?= htmlspecialchars($company['location']) ?></td>
                    <td><?= htmlspecialchars($company['notes']) ?></td>
                    <td><?= date('d M Y', strtotime($company['created_at'])) ?></td>
                    <td>
                        <a href="view-company.php?id=<?= $company['company_id'] ?>">👁 View</a> |
                        <a href="edit-company.php?id=<?= $company['company_id'] ?>">✏️ Edit</a> |
                        <a href="delete-company.php?id=<?= $company['company_id'] ?>" onclick="return confirm('Delete this company?');">❌ Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($companies)): ?>
                <tr><td colspan="6">No companies found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
