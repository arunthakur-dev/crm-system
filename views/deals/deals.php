<?php
require_once __DIR__ . '/../../config/session-config.php';
require_once __DIR__ . '/../../config/dbh.php';
require_once __DIR__ . '/../../models/deals-model.php';

$dealModel = new DealModel();
$deals = $dealModel->getUserDeals($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Deals</title>
    <link rel="stylesheet" href="../../assets/css/deals.css">
</head>
<body>

<div class="page-wrapper">
    <header>
        <h1>Deals</h1>
        <div class="actions">
            <input type="text" placeholder="Search deal title, value..." class="search-input">
            <a href="create-deal.php" class="btn">+ Create Deal</a>
        </div>
    </header>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Value</th>
                    <th>Stage</th>
                    <th>Company</th>
                    <th>Contact</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($deals as $deal): ?>
                <tr>
                    <td><?= htmlspecialchars($deal['title']) ?></td>
                    <td>₹<?= number_format($deal['value']) ?></td>
                    <td><?= htmlspecialchars($deal['stage']) ?></td>
                    <td><?= htmlspecialchars($deal['company_name']) ?></td>
                    <td><?= htmlspecialchars($deal['contact_name']) ?></td>
                    <td><?= date('d M Y', strtotime($deal['created_at'])) ?></td>
                    <td>
                        <a href="view-deal.php?id=<?= $deal['deal_id'] ?>">👁 View</a> |
                        <a href="edit-deal.php?id=<?= $deal['deal_id'] ?>">✏️ Edit</a> |
                        <a href="delete-deal.php?id=<?= $deal['deal_id'] ?>" onclick="return confirm('Delete this deal?');">❌ Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($deals)): ?>
                <tr><td colspan="7">No deals found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
