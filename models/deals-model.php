<?php
require_once __DIR__ . '/../config/dbh.php';
require_once __DIR__ . '/companies-model.php';
require_once __DIR__ . '/contacts-model.php';


class DealsModel extends Dbh {

    protected function insertDeal($user_id, $title, $deal_stage, $amount, $close_date, $deal_owner, $deal_type, $priority) {
        
        $sql = "INSERT INTO deals (
                    user_id, title, deal_stage, amount, close_date, 
                    deal_owner, deal_type, priority
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->connect()->prepare($sql);
        $success = $stmt->execute([
            $user_id, $title, $deal_stage, $amount, $close_date,
            $deal_owner, $deal_type, $priority
        ]);

        if (!$success) {
            throw new Exception("Failed to insert deal.");
        }

        $deal_id = $this->connect()->lastInsertId();
        if (!$deal_id) {
            throw new Exception("Failed to retrieve last insert ID for deal.");
        }

        return $deal_id;
    }

    public function linkDealToContact($deal_id, $contact_id) {
        $sql = "INSERT INTO contact_deals (deal_id, contact_id) VALUES (?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$deal_id, $contact_id]);
    }

    public function linkDealToCompany($deal_id, $company_id) {
        $sql = "INSERT INTO company_deals (deal_id, company_id) VALUES (?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$deal_id, $company_id]);
    }

    public function createDealAndLink(
        $user_id, $title, $deal_stage, $amount, $close_date,
        $deal_owner, $deal_type, $priority,
        $contact_id = null, $company_id = null
        ) {
        $this->connect()->beginTransaction();

        try {
            $deal_id = $this->insertDeal(
                $user_id, $title, $deal_stage, $amount, $close_date,
                $deal_owner, $deal_type, $priority
            );

            if ($contact_id) {
                $this->linkDealToContact($deal_id, $contact_id);
            }

            if ($company_id) {
                $this->linkDealToCompany($deal_id, $company_id);
            }

            $this->connect()->commit();
            return $deal_id;

        } catch (Exception $e) {
            $this->connect()->rollBack();
            throw $e;
        }
    }

    public function fetchDealsByUser($user_id) {
        $sql = "SELECT * FROM deals WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchContactsForDeal($deal_id, $user_id) {
        $sql = "SELECT c.contact_id, c.first_name, c.last_name, c.email, c.phone
                FROM contacts c
                INNER JOIN contact_deals cd ON c.contact_id = cd.contact_id
                WHERE cd.deal_id = :deal_id AND c.user_id = :user_id";

        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':deal_id', $deal_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchCompaniesForDeal($deal_id, $user_id) {
        $sql = "SELECT c.company_id, c.name, c.industry, c.country
                FROM companies c
                INNER JOIN company_deals cd ON c.company_id = cd.company_id
                WHERE cd.deal_id = :deal_id AND c.user_id = :user_id";

        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':deal_id', $deal_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchRecentSortedDeals($user_id, $limit = 10, $sort = 'created_at', $order = 'desc') {
        $validSortFields = ['title', 'deal_stage', 'amount', 'deal_owner', 'close_date', 'created_at'];
        $validOrders = ['asc', 'desc'];

        if (!in_array($sort, $validSortFields)) {
            $sort = 'created_at';
        }
        if (!in_array(strtolower($order), $validOrders)) {
            $order = 'desc';
        }

        $stmt = $this->connect()->prepare("SELECT * FROM deals WHERE user_id = :user_id ORDER BY $sort $order LIMIT :limit");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchSortedDeals($user_id, $sort, $order) {
        $allowedFields = ['title', 'deal_stage', 'amount', 'deal_owner', 'close_date', 'created_at'];
        $allowedOrder = ['asc', 'desc'];

        if (!in_array($sort, $allowedFields)) $sort = 'created_at';
        if (!in_array(strtolower($order), $allowedOrder)) $order = 'desc';

        $stmt = $this->connect()->prepare("SELECT * FROM deals WHERE user_id = :user_id ORDER BY $sort $order");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchDeals($user_id, $searchTerm, $filter = 'all', $sort = 'created_at', $order = 'desc') {
        $searchTerm = '%' . $searchTerm . '%';

        $allowedSortFields = ['title', 'deal_stage', 'amount', 'deal_owner', 'close_date', 'created_at'];
        if (!in_array($sort, $allowedSortFields)) $sort = 'created_at';
        $order = strtolower($order) === 'asc' ? 'ASC' : 'DESC';

        $sql = "
            SELECT * FROM deals
            WHERE (
                title LIKE ?
                OR deal_stage LIKE ?
                OR deal_owner LIKE ?
                OR close_date LIKE ?
            )
        ";

        $params = array_fill(0, 4, $searchTerm);

        if ($filter === 'my') {
            $sql .= " AND user_id = ?";
            $params[] = $user_id;
        }

        $sql .= " ORDER BY `$sort` $order LIMIT 100";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchDealById($deal_id, $user_id) {
        $stmt = $this->connect()->prepare(
            "SELECT * FROM deals WHERE deal_id = ? AND user_id = ?"
        );
        $stmt->execute([$deal_id, $user_id]);

        if ($stmt->rowCount() === 0) {
            return null; // No such contact or not owned by user
        }

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getSortedRecentDeals($user_id, $limit = 5, $sort = 'created_at', $order = 'desc') {
        $validSortFields = ['title', 'amount', 'deal_stage', 'deal_owner', 'deal_type', 'priority', 'close_date', 'created_at'];
        $validOrders = ['asc', 'desc'];

        // Sanitize inputs
        if (!in_array($sort, $validSortFields)) {
            $sort = 'created_at';
        }
        if (!in_array(strtolower($order), $validOrders)) {
            $order = 'desc';
        }

        $sql = "SELECT * FROM deals WHERE user_id = :user_id ORDER BY $sort $order LIMIT :limit";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
