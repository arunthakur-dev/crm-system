<?php
require_once __DIR__ . '/../config/dbh.php';

class DealModel extends Dbh {
    public function getUserDeals($user_id) {
        $pdo = $this->connect();
        $stmt = $pdo->prepare("SELECT deals.*, contacts.full_name AS contact_name, companies.name AS company_name 
                               FROM deals 
                               JOIN contacts ON deals.contact_id = contacts.contact_id 
                               JOIN companies ON deals.company_id = companies.company_id 
                               WHERE  deals.user_id = :uid 
                               ORDER BY deals.created_at DESC");
        $stmt->execute(['uid' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecentDeals($user_id, $limit = 5) {
        $pdo = $this->connect();
        $stmt = $pdo->prepare("SELECT * FROM deals WHERE user_id = :uid ORDER BY created_at DESC LIMIT :lim");
        $stmt->bindValue(':uid', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
