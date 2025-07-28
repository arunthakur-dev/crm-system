<?php

require_once __DIR__ . '/../config/dbh.php';

class CompanyModel extends Dbh {
    public function getUserCompanies($user_id) {
        $pdo = $this->connect(); // ✅ connect() is accessible here because it's protected

        $stmt = $pdo->prepare("SELECT * FROM companies WHERE user_id = :uid ORDER BY created_at DESC");
        $stmt->execute(['uid' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecentCompanies($user_id, $limit = 5) {
    $stmt = $this->connect()->prepare("SELECT * FROM companies WHERE user_id = :uid ORDER BY created_at DESC LIMIT :lim");
    $stmt->bindValue(':uid', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}