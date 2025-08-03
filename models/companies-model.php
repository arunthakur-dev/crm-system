<?php
require_once __DIR__ . '/../config/dbh.php'; // adjust path as per your project

class CompaniesModel extends Dbh {
    public function insertCompany($user_id, $company_domain, $name, $owner,
                                     $industry, $country, $state,
                                     $postal_code, $employees, $notes) {
        $sql = "INSERT INTO companies (
                   user_id, company_domain, name, owner, industry,
                    country, state, postal_code, employees, notes
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
                )";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([
            $user_id, $company_domain, $name, $owner,
            $industry, $country, $state, $postal_code,
            $employees, $notes
        ]);
        return $this->connect()->lastInsertId();  
    }

    public function linkCompanyToContact($company_id, $contact_id) {
        $sql = "INSERT INTO company_contacts (company_id, contact_id) VALUES (?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$company_id, $contact_id]);
    }

    public function createAndLinkCompany(
        $user_id, $contact_id, $company_domain, $name, $owner,
        $industry, $country, $state, $postal_code,
        $employees, $notes
    ) {
        $this->connect()->beginTransaction();

        try {
            // Step 1: Create new company and get its ID
            $new_company_id = $this->insertCompany($user_id, $company_domain, $name, $owner,
            $industry, $country, $state, $postal_code,
            $employees, $notes);

            // Step 2: Link it to the contact
            $this->linkCompanyToContact($new_company_id, $contact_id);

            // Step 3: Commit
            $this->connect()->commit();

            return $new_company_id;
        } catch (Exception $e) {
            $this->connect()->rollBack();
            throw $e;
        }
    }

    public function fetchCompaniesByUser($user_id) {
        $sql = "SELECT * FROM companies WHERE user_id = :user_id ORDER BY name ASC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchCompanyById($company_id, $user_id) {
        $stmt = $this->connect()->prepare(
            "SELECT * FROM companies WHERE  company_id = ? AND user_id = ?"
        );
        $stmt->execute([$company_id, $user_id]);

        if ($stmt->rowCount() === 0) {
            return null; // No such company or not owned by user
        }

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchSortedCompanies($user_id, $sort, $order) {
        $allowedFields = ['name', 'company_domain', 'owner', 'industry', 'country', 'state', 'postal_code', 'employees', 'created_at'];
        $allowedOrder = ['asc', 'desc'];

        if (!in_array($sort, $allowedFields)) $sort = 'created_at';
        if (!in_array(strtolower($order), $allowedOrder)) $order = 'desc';

        $sql = "SELECT * FROM companies 
                WHERE  user_id = :user_id 
                ORDER BY $sort $order";

        $stmt = $this->connect()->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update company
    public function updateCompany($company_id, $user_id, $company_domain, $name, $owner,
                                $industry, $country, $state, $postal_code, $employees, $notes) {
        $sql = "UPDATE companies SET 
                    company_domain = ?, name = ?, owner = ?, industry = ?, country = ?,
                    state = ?, postal_code = ?, employees = ?, notes = ?
                WHERE company_id = ? ANDuser_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([
            $company_domain, $name, $owner, $industry, $country,
            $state, $postal_code, $employees, $notes, $company_id, $user_id
        ]);
    } 

    public function searchCompanies($user_id, $searchTerm, $filter = 'all', $sort = 'created_at', $order = 'desc') {
        $searchTerm = '%' . $searchTerm . '%';

        $sql = "
            SELECT companies.* 
            FROM companies
            WHERE  (
                companies.name LIKE ?
                OR companies.industry LIKE ?
                OR companies.company_domain LIKE ?
                OR companies.country LIKE ?
                OR companies.state LIKE ?
                OR companies.postal_code LIKE ?
                OR companies.owner LIKE ?
            )
        ";

        $params = array_fill(0, 7, $searchTerm); // 7 placeholders

        // Restrict to logged-in user's data if 'my' filter
        if ($filter === 'my') {
            $sql .= " AND companies.user_id = ?";
            $params[] = $user_id;
        }

        $sql .= " ORDER BY `$sort` $order LIMIT 100";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Delete company
    public function deleteCompany($company_id, $user_id) {
        $sql = "DELETE FROM companies WHERE company_id = ? ANDuser_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$company_id, $user_id]);
    }

    public function fetchRecentSortedCompanies($user_id, $limit = 10, $sort = 'created_at', $order = 'desc') {
        $validSortFields = ['name', 'company_domain', 'owner', 'industry', 'country', 'state', 'postal_code', 'employees', 'created_at'];
        $validOrders = ['asc', 'desc'];

        // Sanitize
        if (!in_array($sort, $validSortFields)) {
            $sort = 'created_at';
        }
        if (!in_array(strtolower($order), $validOrders)) {
            $order = 'desc';
        }

        $stmt = $this->connect()->prepare("SELECT * FROM companies WHERE  user_id = :user_id ORDER BY $sort $order LIMIT :limit");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchContactsForCompany($company_id, $user_id) {
        $sql = "SELECT c.contact_id, c.first_name, c.last_name, c.email, c.phone
                FROM contacts c
                INNER JOIN company_contacts cc ON c.contact_id = cc.contact_id
                WHERE cc.company_id = :company_id AND c.user_id = :user_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':company_id', $company_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchDealsForCompany($company_id, $user_id) {
        $sql = "SELECT d.deal_id, d.title, d.amount, d.deal_stage, d.close_date
                FROM deals d
                INNER JOIN company_deals cd ON d.deal_id = cd.deal_id
                WHERE cd.company_id = :company_id AND d.user_id = :user_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':company_id', $company_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
