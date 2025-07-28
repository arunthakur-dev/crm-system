<?php
require_once __DIR__ . '/../models/contacts-model.php';

class ContactController {
    private $model;

    public function __construct() {
        $this->model = new ContactModel();
    }

    public function getAll($userId) {
        return $this->model->getUserContacts($userId);
    }
}
