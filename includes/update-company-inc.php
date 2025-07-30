<?php
session_start();
require_once __DIR__ . '/../config/dbh.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $companyId = $_POST['company_id'] ?? null;
    $userId = $_SESSION['user_id'] ?? null;

    if (!$companyId || !$userId) {
        die("Missing data.");
    }

    $name = trim($_POST['company_name']);
    $domain = trim($_POST['company_domain']);
    $phone = trim($_POST['phone']);
    $removeLogo = isset($_POST['remove_logo']) && $_POST['remove_logo'] == '1';

    $dbh = new Dbh();
    $pdo = $dbh->connect();

    $stmt = $pdo->prepare("SELECT logo FROM companies WHERE company_id = ? AND user_id = ?");
    $stmt->execute([$companyId, $userId]);
    $company = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$company) {
        die("Company not found or access denied.");
    }

    $newLogo = $company['logo'];

    if ($removeLogo && $company['logo']) {
        $logoPath = __DIR__ . '/../uploads/logos/' . $company['logo'];
        if (file_exists($logoPath)) unlink($logoPath);
        $newLogo = null;
    }

    if (isset($_FILES['company_logo']) && $_FILES['company_logo']['error'] === UPLOAD_ERR_OK) {
        $fileTmp = $_FILES['company_logo']['tmp_name'];
        $fileName = basename($_FILES['company_logo']['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowed = ['png', 'jpg', 'jpeg', 'gif', 'webp'];
        if (!in_array($fileExt, $allowed)) die("Unsupported image format.");

        $uploadDir = __DIR__ . '/../uploads/logos/';
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

        $newFileName = 'logo_' . time() . '_' . rand(100, 999) . '.' . $fileExt;
        $destination = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmp, $destination)) {
            if ($company['logo'] && !$removeLogo) {
                $oldPath = $uploadDir . $company['logo'];
                if (file_exists($oldPath)) unlink($oldPath);
            }
            $newLogo = $newFileName;
        } else {
            die("Logo upload failed.");
        }
    }

    $updateStmt = $pdo->prepare("UPDATE companies SET name = ?, company_domain = ?, phone = ?, logo = ? WHERE company_id = ? AND user_id = ?");
    $updated = $updateStmt->execute([$name, $domain, $phone, $newLogo, $companyId, $userId]);

    $_SESSION['flash_message'] = $updated ? "Company updated successfully." : "Update failed. Please try again.";
    header("Location: ../views/companies/view-company.php?company_id=" . $companyId);
    exit;
} else {
    http_response_code(405);
    echo "Method not allowed.";
}
