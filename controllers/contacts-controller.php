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

    public function createContact() {
        // Basic validation
        if (empty($this->contact_id) || empty($this->user_id) || empty($this->email) || empty($this->first_name) || empty($this->last_name)) {
            die("Email, first name, and last name is required.");
        }

        // Call Model
        $this->insertContact(
            $this->contact_id, $this->user_id, $this->email, $this->first_name,
            $this->last_name, $this->contact_owner, $this->phone,
            $this->lifecycle_stage, $this->lead_status       );
    }

    public function getContactDetails($contact_id, $user_id) {
        return $this->fetchContactById($contact_id, $user_id);
    }

    // public function getcontactById($contact_id, $user_id) {
    //     return $this->fetchcontactById($contact_id, $user_id);
    // }

    public function getRecentSortedContacts($user_id, $limit = 10, $sort = 'created_at', $order = 'desc') {
        return $this->fetchRecentSortedContacts($user_id, $limit, $sort, $order);
    }

    public function getSortedContacts($user_id, $sort, $order) {
        return $this->fetchSortedContacts($user_id,  $sort, $order);
    }

    public function getSortedMyContacts($user_id, $sort, $order) {
        return $this->fetchSortedMyContacts($user_id, $sort, $order);
    }

    public function getSearchedContacts($user_id, $searchTerm, $filter = 'all', $sort = 'created_at', $order = 'desc') {
        return $this->searchContacts($user_id, $searchTerm, $filter, $sort, $order);
    }
    // public function getSortedMyCompanies($user_id, $sort, $order) {
    //     return $this->getMyCompanies($user_id, $sort, $order);
    // }


    // // Update contact 
    // public function updatecontact($contact_id, $user_id, $contact_domain, $name, $owner,
    //                           $industry, $country, $state, $postal_code, $employees, $notes) {
    //     if (empty($name)) {
    //         die("contact name is required.");
    //     }

    //     // Call the model function 
    //     $this->updatecontact(
    //         $contact_id, $user_id, $contact_domain, $name, $owner,
    //         $industry, $country, $state, $postal_code, $employees, $notes
    //     );
    // }

    // // Delete contact
    // public function deletecontact($contact_id, $user_id) {
    //     parent::deletecontact($contact_id, $user_id);
    // }
}
