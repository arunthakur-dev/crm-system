<?php
require_once __DIR__ . '/../models/deals-model.php';

class DealsController extends DealsModel {
    private $deal_id, $user_id, $deal_name, $deal_stage, $amount,
            $deal_owner, $pipeline, $close_date;

    public function __construct(
        $deal_id = null, $user_id = null, $deal_name = null, $deal_stage = null,
        $amount = null, $deal_owner = null, $pipeline = null, $close_date = null
    ) {
        $this->deal_id = $deal_id;
        $this->user_id = $user_id;
        $this->deal_name = $deal_name;
        $this->deal_stage = $deal_stage;
        $this->amount = $amount;
        $this->deal_owner = $deal_owner;
        $this->pipeline = $pipeline;
        $this->close_date = $close_date;
    }

    public function createDeal($user_id, $title, $deal_stage, $amount, $close_date, $deal_owner, $deal_type, $priority) {
        // if (empty($deal_name) || empty($deal_stage)) {
        //     throw new Exception("Deal name and stage are required.");
        // }
        var_dump($_POST);
        return $this->insertDeal($user_id, $title, $deal_stage, $amount, $close_date, $deal_owner, $deal_type, $priority);
    }

    public function getDealDetails($deal_id, $user_id) {
        return $this->fetchDealById($deal_id, $user_id);
    }

    public function getDealsByUser($user_id) {
        return $this->fetchDealsByUser($user_id);
    }

    public function getRecentSortedDeals($user_id, $limit = 10, $sort = 'created_at', $order = 'desc') {
        return $this->fetchRecentSortedDeals($user_id, $limit, $sort, $order);
    }

    public function getSortedDeals($user_id, $sort, $order) {
        return $this->fetchSortedDeals($user_id, $sort, $order);
    }

    public function getSortedMyDeals($user_id, $sort, $order) {
        return $this->fetchSortedMyDeals($user_id, $sort, $order);
    }

    public function getSearchedDeals($user_id, $searchTerm, $filter = 'all', $sort = 'created_at', $order = 'desc') {
        return $this->searchDeals($user_id, $searchTerm, $filter, $sort, $order);
    }

    public function getContactsForDeal($deal_id, $user_id) {
        return $this->fetchContactsForDeal($deal_id, $user_id);
    }

    public function getCompaniesForDeal($deal_id, $user_id) {
        return $this->fetchCompaniesForDeal($deal_id, $user_id);
    }

    public function linkContactToDeal($deal_id, $contact_id) {
        return $this->linkContactToDeal($deal_id, $contact_id);
    }

    public function linkCompanyToDeal($deal_id, $company_id) {
        return $this->linkCompanyToDeal($deal_id, $company_id);
    }

    public function deleteDeal($deal_id, $user_id) {
        return $this->removeDeal($deal_id, $user_id);
    }
}
