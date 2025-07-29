<?php
require_once __DIR__ . '/../config/dbh.php'; // adjust path as per your project

class CompaniesModel extends Dbh {
    protected function insertCompany($user_id, $company_domain, $name, $owner,
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
    }

    public function fetchCompaniesByUser($user_id) {
        $sql = "SELECT * 
                FROM companies 
                WHERE user_id = ? 
                ORDER BY created_at DESC";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$user_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchCompanyById($companyId, $userId) {
        $stmt = $this->connect()->prepare(
            "SELECT * FROM companies WHERE company_id = ? AND user_id = ?"
        );
        $stmt->execute([$companyId, $userId]);

        if ($stmt->rowCount() === 0) {
            return null; // No such company or not owned by user
        }

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update company
    public function updateCompany($company_id, $user_id, $company_domain, $name, $owner,
                                $industry, $country, $state, $postal_code, $employees, $notes) {
        $sql = "UPDATE companies SET 
                    company_domain = ?, name = ?, owner = ?, industry = ?, country = ?,
                    state = ?, postal_code = ?, employees = ?, notes = ?
                WHERE company_id = ? AND user_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([
            $company_domain, $name, $owner, $industry, $country,
            $state, $postal_code, $employees, $notes, $company_id, $user_id
        ]);
    }

    // Delete company
    public function deleteCompany($company_id, $user_id) {
        $sql = "DELETE FROM companies WHERE company_id = ? AND user_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$company_id, $user_id]);
    }
}
