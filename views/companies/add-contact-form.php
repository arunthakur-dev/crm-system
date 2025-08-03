<?php
ob_start();

require_once __DIR__ . '/../../controllers/contacts-controller.php';

$contactController = new ContactsController();
$user_id = $_SESSION['user_id'];  
$allContacts = $contactController->getContactsByUser($user_id);

?>
<!-- Contact Sidebar -->
<div id="contactSidebar" class="sidebar sidebar-form hidden">
    <div class="sidebar-header blue-header">
        <h3>Add New Contact</h3>
        <button class="close-sidebar">&times;</button>
    </div>

    <!-- Tab Buttons -->
    <div class="tab-buttons">
        <button type="button" class="tab-btn active" data-tab="new"><strong>Create new</strong></button>
        <button type="button" class="tab-btn" data-tab="existing"><strong>Add existing</strong></button>
    </div>

    <!-- Tab Content Wrapper -->
    <div class="tab-content-wrapper">

        <!-- Create New Contact Form -->
        <form action="/includes/contacts/link-contact-to-company.php" method="POST" class="tab-content active" id="new">
            <input type="hidden" name="company_id" value="<?= $company['company_id'] ?>">
            <label for="email">Email </label>
            <input type="email" name="email" placeholder="Email">

            <label for="first_name">First Name</label>
            <input type="text" name="first_name" placeholder="First Name" >

            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" placeholder="Last Name">

            <label for="contact_owner">Contact Owner</label>
            <input type="text" name="contact_owner" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" placeholder="Contact Owner">

            <label for="phone">Phone</label>
            <input type="text" name="phone" placeholder="Phone Number">

            <label for="lifecycle_stage">Lifecycle Stage</label>
            <select id="lifecycle_stage" name="lifecycle_stage"  >
                <option value="">Select Stage</option>
                <option value="Lead">Lead</option>
                <option value="Qualified">Qualified</option>
                <option value="Opportunity">Opportunity</option>
                <option value="Customer">Customer</option>
                <option value="Subscriber">Subscriber</option>
                <option value="Evangelist">Evangelist</option>
                <option value="Other">Other</option>
            </select>

            <label for="lead_status">Lifecycle Status</label>
            <select id="lead_status" name="lead_status"  >
                <option value="">Select Status</option>
                <option value="New">New</option>
                <option value="Open">Open</option>
                <option value="In Progress">In Progress</option>
                <option value="Open Deal">Open Deal</option>
                <option value="Attempt to Contact">Attempt to Contact</option>
                <option value="Connected">Connected</option>
                <option value="Other">Other</option>
            </select>

            <div class="form-actions">
                <button type="submit" class="btn">Create</button>
            </div>
        </form>

        <!-- Add Existing Contact Form -->
        <form action="/includes/contacts/link-contact-to-company.php" method="POST" class="tab-content" id="existing">
            <select name="existing_contact_id" required>
                <option value="">Select existing contact</option>
                <?php foreach ($allContacts as $contact): ?>
                    <option value="<?= $contact['contact_id'] ?>"><?= htmlspecialchars($contact['first_name']) ?> <?= htmlspecialchars($contact['last_name']) ?> - <?= htmlspecialchars($contact['email']) ?></option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="company_id" value="<?= $company['company_id'] ?>">
            <div class="form-actions">
                <button type="submit">Add</button>
            </div>
        </form>
    </div>
</div>
