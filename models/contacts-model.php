<?php
require_once __DIR__ . '/../config/dbh.php'; // adjust path as per your project

class ContactsModel extends Dbh {

    protected function insertContact($user_id, $email, $first_name, $last_name,
                                 $contact_owner, $phone, $lifecycle_stage, $lead_status) {
        $sql = "INSERT INTO contacts (
                    user_id, email, first_name, last_name,
                    contact_owner, phone, lifecycle_stage, lead_status
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([
            $user_id, $email, $first_name, $last_name,
            $contact_owner, $phone, $lifecycle_stage, $lead_status
        ]);

        return $this->connect()->lastInsertId();  
    }


    public function linkContactToCompany($contact_id, $company_id) {
        $sql = "INSERT INTO company_contacts (contact_id, company_id) VALUES (?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$contact_id, $company_id]);
    }

    public function createAndLinkContact(
        $user_id, $company_id,
        $email, $first_name, $last_name,
        $contact_owner, $phone, $lifecycle_stage, $lead_status
    ) {
        $this->connect()->beginTransaction();

        try {
            $new_contact_id = $this->insertContact(
                $user_id, $email, $first_name, $last_name,
                $contact_owner, $phone, $lifecycle_stage, $lead_status
            );

            $this->linkContactToCompany($new_contact_id, $company_id);

            $this->connect()->commit();

            return $new_contact_id;
        } catch (Exception $e) {
            $this->connect()->rollBack();
            throw $e;
        }
    }


    public function fetchContactsByUser($user_id) {
        $sql = "SELECT * FROM contacts WHERE user_id = :user_id ORDER BY first_name ASC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
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


//     public function fetchCompaniesByUser($user_id) {
//         $sql = "SELECT * 
//                 FROM companies 
//                 WHERE user_id = ? 
//                 ORDER BY created_at DESC";

//         $stmt = $this->connect()->prepare($sql);
//         $stmt->execute([$user_id]);

//         return $stmt->fetchAll(PDO::FETCH_ASSOC);
//     }

    public function fetchContactById($contact_id, $user_id) {
        $stmt = $this->connect()->prepare(
            "SELECT * FROM contacts WHERE contact_id = ? AND user_id = ?"
        );
        $stmt->execute([$contact_id, $user_id]);

        if ($stmt->rowCount() === 0) {
            return null; // No such contact or not owned by user
        }

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchSortedContacts($user_id, $sort, $order) {
        $allowedFields = ['email', 'first_name', 'last_name', 'contact_owner', 'phone', 'lifecycle_stage', 'lead_status', 'created_at'];
        $allowedOrder = ['asc', 'desc'];

        // Validate and sanitize input
        if (!in_array($sort, $allowedFields)) $sort = 'created_at';
        if (!in_array(strtolower($order), $allowedOrder)) $order = 'desc';

        $sql = "SELECT * FROM contacts 
                WHERE user_id = :user_id 
                ORDER BY $sort $order";

        $stmt = $this->connect()->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchRecentSortedContacts($user_id, $limit = 10, $sort = 'created_at', $order = 'desc') {
    $validSortFields = ['email', 'first_name', 'last_name', 'contact_owner', 'phone', 'lifecycle_stage', 'lead_status', 'created_at'];
    $validOrders = ['asc', 'desc'];

    // Sanitize
    if (!in_array($sort, $validSortFields)) {
        $sort = 'created_at';
    }
    if (!in_array(strtolower($order), $validOrders)) {
        $order = 'desc';
    }

    $stmt = $this->connect()->prepare("SELECT * FROM contacts WHERE  user_id = :user_id ORDER BY $sort $order LIMIT :limit");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function fetchSortedMyContacts( $user_id, $sort = 'created_at', $order = 'desc') {
        $stmt = $this->connect()->prepare("
            SELECT * FROM contacts 
            WHERE  user_id = :user_id 
            ORDER BY $sort $order
        ");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

//     // In CompaniesModel
//     public function fetchMyCompanies($user_id) {
//         $sql = "SELECT * FROM companies 
//                 WHERE user_id = :user_id 
//                 ORDER BY created_at DESC";

//         $stmt = $this->connect()->prepare($sql);
//         $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
//         $stmt->execute();

//         return $stmt->fetchAll(PDO::FETCH_ASSOC);
//     }

//     // Update contact
//     public function updatecontact($contact_id, $user_id, $contact_domain, $name, $owner,
//                                 $industry, $country, $state, $postal_code, $employees, $notes) {
//         $sql = "UPDATE companies SET 
//                     contact_domain = ?, name = ?, owner = ?, industry = ?, country = ?,
//                     state = ?, postal_code = ?, employees = ?, notes = ?
//                 WHERE contact_id = ? ANDuser_id = ?";
//         $stmt = $this->connect()->prepare($sql);
//         $stmt->execute([
//             $contact_domain, $name, $owner, $industry, $country,
//             $state, $postal_code, $employees, $notes, $contact_id, $user_id
//         ]);
//     }

    public function searchContacts($user_id, $searchTerm, $filter = 'all', $sort = 'created_at', $order = 'desc') {
        $searchTerm = '%' . $searchTerm . '%';

        $allowedSortFields = ['email', 'first_name', 'last_name', 'contact_owner', 'phone', 'lifecycle_stage', 'lead_status', 'created_at'];
        if (!in_array($sort, $allowedSortFields)) $sort = 'created_at';
        $order = strtolower($order) === 'asc' ? 'ASC' : 'DESC';

        $sql = "
            SELECT contacts.*
            FROM contacts
            WHERE (
                contacts.email LIKE ?
                OR contacts.first_name LIKE ?
                OR contacts.last_name LIKE ?
                OR contacts.contact_owner LIKE ?
                OR contacts.phone LIKE ?
                OR contacts.lifecycle_stage LIKE ?
                OR contacts.lead_status LIKE ?
            )
        ";

        $params = array_fill(0, 7, $searchTerm); // 7 placeholders

        // Restrict to logged-in user's data if 'my' filter
        if ($filter === 'my') {
            $sql .= " AND contacts.user_id = ?";
            $params[] = $user_id;
        }

        $sql .= " ORDER BY `$sort` $order LIMIT 100";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

//     // Delete contact
//     public function deletecontact($contact_id, $user_id) {
//         $sql = "DELETE FROM companies WHERE contact_id = ? ANDuser_id = ?";
//         $stmt = $this->connect()->prepare($sql);
//         $stmt->execute([$contact_id, $user_id]);
//     }

//     // models/contactModel.php

    
}
