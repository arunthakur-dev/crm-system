<!-- Edit Company Modal (Name, Domain, Phone) -->
<div id="editCompanyModal" class="modal">
    <div class="modal-content">   
        <h2>Edit Company Details</h2>
        <form action="/../../includes/update-company-inc.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="company_id" value="<?= $company['company_id'] ?>">

            <label for="company_name">Company Name</label>
            <input type="text" id="company_name" name="company_name" value="<?= htmlspecialchars($company['name']) ?>" required>

            <label for="company_domain">Domain</label>
            <input type="text" id="company_domain" name="company_domain" value="<?= htmlspecialchars($company['company_domain']) ?>">

            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($company['phone'] ?? '') ?>">

            <label for="company_logo">Upload New Logo</label>
            <input type="file" id="company_logo" name="company_logo">

            <?php if (!empty($company['logo'])): ?>
                <button type="submit" name="remove_logo" value="1" class="remove-logo-btn">Remove Logo</button>
            <?php endif; ?>

            <button type="submit" class="submit-btn">Save</button>
            <button type="button" class="cancel-btn close-modal">Cancel</button>
        </form>
    </div>
</div>

<!-- Edit Single Field Modal -->
<div id="editAboutFieldModal" class="modal">
    <div class="modal-content">
        <h2>Edit Field</h2>
        <form id="aboutFieldForm" action="/../../includes/update-company-field-inc.php" method="POST">
            <input type="hidden" name="company_id" value="<?= $company['company_id'] ?>">
            <input type="hidden" name="field_name" id="field_name">
            <label id="field_label" for="field_value">Field</label>
            <input type="text" name="field_value" id="field_value" required>

            <button type="submit" class="submit-btn">Save</button>
            <button type="button" class="cancel-btn close-about-modal">Cancel</button>
        </form>
    </div>
</div>

