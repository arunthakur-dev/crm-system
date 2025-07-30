<?php
require_once __DIR__ . '/../models/companies-model.php';
class CompaniesController extends CompaniesModel {
    private $user_id, $company_domain, $name, $owner,
            $industry, $country, $state, $postal_code, $employees, $notes;

    public function __construct(
        $user_id = null, $company_domain = null, $name = null, $owner = null,
        $industry = null, $country = null, $state = null, $postal_code = null,
        $employees = null, $notes = null
    ) {
        $this->user_id = $user_id; $this->company_domain = $company_domain;
        $this->name = $name; $this->owner = $owner; $this->industry = $industry;
        $this->country = $country; $this->state = $state; $this->postal_code = $postal_code;
        $this->employees = $employees; $this->notes = $notes;
    }

    public function createCompany() {
        // Basic validation
        if (empty($this->name)) {
            die("Company name is required.");
        }

        // Call Model
        $this->insertCompany(
            $this->user_id, $this->company_domain, $this->name, $this->owner,
            $this->industry, $this->country, $this->state,
            $this->postal_code, $this->employees, $this->notes
        );
    }

    public function getCompanyDetails($companyId, $userId) {
        return $this->fetchCompanyById($companyId, $userId);
    }

    public function getCompanyById($company_id, $user_id) {
        return $this->fetchCompanyById($company_id, $user_id);
    }

    public function getRecentSortedCompanies($userId, $limit = 10, $sort = 'created_at', $order = 'desc') {
        return $this->fetchRecentSortedCompanies($userId, $limit, $sort, $order);
    }

    public function getSortedCompanies($userId, $sort, $order) {
        return $this->fetchSortedCompanies($userId, $sort, $order);
    }

    public function getSortedMyCompanies($userId, $sort, $order) {
        return $this->getMyCompanies($userId, $sort, $order);
    }


    // Update company 
    public function updateCompany($company_id, $user_id, $company_domain, $name, $owner,
                              $industry, $country, $state, $postal_code, $employees, $notes) {
        if (empty($name)) {
            die("Company name is required.");
        }

        // Call the model function 
        $this->updateCompany(
            $company_id, $user_id, $company_domain, $name, $owner,
            $industry, $country, $state, $postal_code, $employees, $notes
        );
    }

    // Delete company
    public function deleteCompany($company_id, $user_id) {
        parent::deleteCompany($company_id, $user_id);
    }
}
