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

    public function createCompany($user_id, $company_domain, $name, $owner,
        $industry, $country, $state, $postal_code, $employees, $notes) {
         
        $this->insertCompany(
            $user_id, $company_domain, $name, $owner,
            $industry, $country, $state,
            $postal_code, $employees, $notes
        );
    }

    public function getCompanyDetails($company_id, $user_id) {
        return $this->fetchCompanyById($company_id, $user_id);
    }

    public function getRecentSortedCompanies($user_id, $limit = 10, $sort = 'created_at', $order = 'desc') {
        return $this->fetchRecentSortedCompanies($user_id, $limit, $sort, $order);
    }

    public function getSortedCompanies($user_id, $sort, $order) {
        return $this->fetchSortedCompanies($user_id, $sort, $order);
    }

    public function getSearchedCompanies($user_id, $searchTerm, $filter = 'all', $sort = 'created_at', $order = 'desc') {
        return $this->searchCompanies($user_id, $searchTerm, $filter, $sort, $order);
    }

    public function getCompaniesByUser($user_id) {
        return $this->fetchCompaniesByUser($user_id);
    }

    public function updateCompany($company_id, $user_id, $company_domain, $name, $owner,
                              $industry, $country, $state, $postal_code, $employees, $notes) {
        if (empty($name)) {
            die("Company name is required.");
        }

        $this->updateCompany(
            $company_id, $user_id, $company_domain, $name, $owner,
            $industry, $country, $state, $postal_code, $employees, $notes
        );
    }

    public function deleteCompany($company_id, $user_id) {
        parent::deleteCompany($company_id, $user_id);
    }
}
