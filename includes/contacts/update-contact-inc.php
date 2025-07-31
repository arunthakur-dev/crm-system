<?php
session_start();
require_once __DIR__ . '/../../config/dbh.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contact_id = $_POST['contact_id'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$contact_id || !$user_id) {
        die("Missing data.");
    }

    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $removeLogo = isset($_POST['remove_logo']) && $_POST['remove_logo'] == '1';

    $dbh = new Dbh();
    $pdo = $dbh->connect();

    // Get current contact info
    $stmt = $pdo->prepare("SELECT logo FROM contacts WHERE contact_id = ? AND user_id = ?");
    $stmt->execute([$contact_id, $user_id]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$contact) {
        die("Contact not found or access denied.");
    }

    $newLogo = $contact['logo'];

    // Handle logo removal
    if ($removeLogo && $contact['logo']) {
        $logoPath = __DIR__ . '/../../uploads/contacts/' . $contact['logo'];
        if (file_exists($logoPath)) unlink($logoPath);
        $newLogo = null;
    }

    // Handle new logo upload
    if (isset($_FILES['contact_logo']) && $_FILES['contact_logo']['error'] === UPLOAD_ERR_OK) {
        $fileTmp = $_FILES['contact_logo']['tmp_name'];
        $fileName = basename($_FILES['contact_logo']['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowed = ['png', 'jpg', 'jpeg', 'gif', 'webp'];
        if (!in_array($fileExt, $allowed)) die("Unsupported image format.");

        $uploadDir = __DIR__ . '/../../uploads/contacts/';
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

        $newFileName = 'contact_' . time() . '_' . rand(100, 999) . '.' . $fileExt;
        $destination = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmp, $destination)) {
            if ($contact['logo'] && !$removeLogo) {
                $oldPath = $uploadDir . $contact['logo'];
                if (file_exists($oldPath)) unlink($oldPath);
            }
            $newLogo = $newFileName;
        } else {
            die("Profile image upload failed.");
        }
    }

    // Update contact info
    $updateStmt = $pdo->prepare("
        UPDATE contacts 
        SET first_name = ?, last_name = ?, email = ?, phone = ?, logo = ?
        WHERE contact_id = ? AND user_id = ?
    ");
    $updated = $updateStmt->execute([
        $first_name, $last_name, $email, $phone, $newLogo,
        $contact_id, $user_id
    ]);

    $_SESSION['flash_message'] = $updated ? "Contact updated successfully." : "Update failed. Please try again.";
    header("Location: /../../views/contacts/view-contact.php?contact_id=" . $contact_id);
    exit;
} else {
    http_response_code(405);
    echo "Method not allowed.";
}
