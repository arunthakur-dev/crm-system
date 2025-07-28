<?php
require_once __DIR__ . '/../models/companies-model.php';

class CompanyController {
    private $model;

    public function __construct() {
        $this->model = new CompanyModel();
    }

    // Get all companies for a specific user
    public function getCompanies($userId) {
        return $this->model->getUserCompanies($userId);
    }

    // // Add new company
    // public function addCompany($userId, $name, $industry, $location, $notes) {
    //     return $this->model->createCompany($userId, $name, $industry, $location, $notes);
    // }

    // // Get single company by ID
    // public function getCompanyById($userId, $companyId) {
    //     return $this->model->getCompany($userId, $companyId);
    // }

    // // Update company
    // public function updateCompany($userId, $companyId, $name, $industry, $location, $notes) {
    //     return $this->model->updateCompany($userId, $companyId, $name, $industry, $location, $notes);
    // }

    // // Delete company
    // public function deleteCompany($userId, $companyId) {
    //     return $this->model->deleteCompany($userId, $companyId);
    // }
}
