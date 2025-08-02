<?php
require_once __DIR__ . '/../../controllers/companies-controller.php';

$companyController = new CompaniesController();
$user_id = $_SESSION['user_id'];
$allCompanies = $companyController->getCompaniesByUser($user_id);  
?>

<!-- Company Sidebar -->
<div id="companySidebar" class="sidebar sidebar-form hidden">
    <div class="sidebar-header blue-header">
        <h3>Add New Company</h3>
        <button class="close-sidebar">&times;</button>
    </div>

    <!-- Tab Buttons -->
    <div class="tab-buttons">
        <button type="button" class="tab-btn active" data-tab="new-company"><strong>Create new</strong></button>
        <button type="button" class="tab-btn" data-tab="existing-company"><strong>Add existing</strong></button>
    </div>

    <!-- Tab Content Wrapper -->
    <div class="tab-content-wrapper">
        <!-- Create New Company Form -->
        <form action="/includes/companies/link-company-to-contact.php" method="POST" class="tab-content active" id="new-company" enctype="multipart/form-data">
            <input type="hidden" name="contact_id" value="<?= $contact['contact_id'] ?>">
            <label for="company_domain">Company Domain</label>
            <input type="text" id="company_domain" name="company_domain" placeholder="e.g. example.com"  >

            <label for="name">Company Name</label>
            <input type="text" id="name" name="name" placeholder="Company Name" >

            <label for="owner">Company Owner</label>
            <input type="text" id="owner" name="owner" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" placeholder="Owner's Name">

            <label for="industry">Industry</label>   
            <select id="industry" name="industry"  >
                <option value="">Select Industry</option>
                <option value="Computer Software">Computer Software</option>
                <option value="Computer Hardware">Computer Hardware</option>
                <option value="Computer Networks">Computer Networks</option>
                <option value="Arts and Crafts">Arts and Crafts</option>
                <option value="Education">Education</option>
                <option value="Healthcare">Healthcare</option>
                <option value="Finance">Finance</option>
                <option value="E-commerce">E-commerce</option>
            </select>

            <label for="country">Country</label>
            <input type="text" id="country" name="country" placeholder="Country">

            <label for="state">State/Region</label>
            <input type="text" id="state" name="state" placeholder="State or Region">

            <label for="postal_code">Postal Code</label>
            <input type="text" id="postal_code" name="postal_code" placeholder="Postal Code">

            <label for="employees">Number of Employees</label>
            <input type="number" id="employees" name="employees" placeholder="e.g. 100">

            <label for="notes">Notes</label>
            <textarea id="notes" name="notes" placeholder="Any additional notes..."></textarea> 

            <div class="form-actions">
                <button type="submit" class="btn">Create</button>
            </div>
        </form>

        <!-- Add Existing Company Form -->
        <form action="/includes/companies/link-company-to-contact.php" method="POST" class="tab-content" id="existing-company">
            <label for="existing_company_id">Select Existing Company</label>
            <select name="existing_company_id" required>
                <option value="">Select a company</option>
                <?php foreach ($allCompanies as $company): ?>
                    <option value="<?= $company['company_id'] ?>">
                        <strong><?= htmlspecialchars($company['name']) ?> - <?= htmlspecialchars($company['company_domain']) ?> 
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="contact_id" value="<?= $contact['contact_id'] ?>">

            <div class="form-actions">
                <button type="submit" class="btn">Link</button>
            </div>
        </form>
    </div>
</div>
