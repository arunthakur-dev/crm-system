<?php
require_once __DIR__ . '/../config/dbh.php';

class ContactModel extends Dbh {
    public function getUserContacts($userId) {
        $pdo = $this->connect();
        $stmt = $pdo->prepare("SELECT contacts.*, companies.name AS company_name 
                               FROM contacts 
                               JOIN companies ON contacts.company_id = companies.company_id 
                               WHERE contacts.user_id = :uid 
                               ORDER BY contacts.created_at DESC");
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecentContacts($user_id, $limit = 5) {
        $pdo = $this->connect();
        $stmt = $pdo->prepare("SELECT * FROM contacts WHERE user_id = :uid ORDER BY created_at DESC LIMIT :lim");
        $stmt->bindValue(':uid', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
