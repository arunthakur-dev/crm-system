<?php
require_once __DIR__ . '/../models/contacts-model.php'; 
class ContactsController extends ContactsModel {
    private $contact_id, $user_id, $email, $first_name, $last_name,
            $contact_owner, $phone, $lifecycle_stage, $lead_status;

    public function __construct(
        $contact_id = null, $user_id = null, $email = null, $first_name = null,
        $last_name = null, $contact_owner = null, $phone = null,
        $lifecycle_stage = null, $lead_status = null
    ) {
        $this->contact_id = $contact_id; $this->user_id = $user_id;
        $this->email = $email; $this->first_name = $first_name;
        $this->last_name = $last_name; $this->contact_owner = $contact_owner;
        $this->phone = $phone; $this->lifecycle_stage = $lifecycle_stage;
        $this->lead_status = $lead_status;
    }

    public function createContact($user_id, $email, $first_name, $last_name, $contact_owner, $phone, $lifecycle_stage, $lead_status) {
        if (empty($email) || empty($first_name) || empty($last_name)) {
            throw new Exception("Email, First Name, and Last Name are required.");
        }

        return $this->insertContact(
            $user_id, $email, $first_name, $last_name,
            $contact_owner, $phone, $lifecycle_stage, $lead_status
        );
    }


    public function getContactDetails($contact_id, $user_id) {
        return $this->fetchContactById($contact_id, $user_id);
    }

    public function getRecentSortedContacts($user_id, $limit = 10, $sort = 'created_at', $order = 'desc') {
        return $this->fetchRecentSortedContacts($user_id, $limit, $sort, $order);
    }

    public function getSortedContacts($user_id, $sort, $order) {
        return $this->fetchSortedContacts($user_id,  $sort, $order);
    }

    public function getSearchedContacts($user_id, $searchTerm, $filter = 'all', $sort = 'created_at', $order = 'desc') {
        return $this->searchContacts($user_id, $searchTerm, $filter, $sort, $order);
    }

    public function getContactsByUser($user_id) {
        return $this->fetchContactsByUser($user_id);
    }
}
