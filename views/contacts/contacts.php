<?php
require_once __DIR__ . '/../../config/session-config.php';
require_once __DIR__ . '/../../config/dbh.php';
require_once __DIR__ . '/../../models/contacts-model.php';

$contactModel = new ContactModel();
$contacts = $contactModel->getUserContacts($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Contacts</title>
    <link rel="stylesheet" href="../../assets/css/contacts.css">
</head>
<body>

<div class="page-wrapper">
    <header>
        <h1>Contacts</h1>
        <div class="actions">
            <input type="text" placeholder="Search name, email..." class="search-input">
            <a href="create-contact.php" class="btn">+ Create Contact</a>
        </div>
    </header>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Company</th>
                    <!-- <th>Notes</th> -->
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><?= htmlspecialchars($contact['full_name']) ?></td>
                    <td><?= htmlspecialchars($contact['email']) ?></td>
                    <td><?= htmlspecialchars($contact['phone']) ?></td>
                    <td><?= htmlspecialchars($contact['company_name']) ?></td>
                    <!-- <td><?= htmlspecialchars($contact['notes']) ?></td> -->
                    <td><?= date('d M Y', strtotime($contact['created_at'])) ?></td>
                    <td>
                        <a href="view-contact.php?id=<?= $contact['contact_id'] ?>">👁 View</a> |
                        <a href="edit-contact.php?id=<?= $contact['contact_id'] ?>">✏️ Edit</a> |
                        <a href="delete-contact.php?id=<?= $contact['contact_id'] ?>" onclick="return confirm('Delete this contact?');">❌ Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($contacts)): ?>
                <tr><td colspan="7">No contacts found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
