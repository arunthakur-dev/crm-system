<!-- Edit contact Modal (Name, Domain, Phone) -->
<div id="editCompanyModal" class="modal">
    <div class="modal-content">   
        <h2>Edit contact Details</h2>
        <form action="/../../includes/contacts/update-contact-inc.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="contact_id" value="<?= $contact['contact_id'] ?>">

            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($contact['first_name']) ?>">
            
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($contact['last_name']) ?>">

            <label for="email">Email</label>
            <input type="text" id="email" name="email" value="<?= htmlspecialchars($contact['email']) ?>">

            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($contact['phone'] ?? '') ?>">

            <label for="contact_logo">Upload Profile Image</label>
            <input type="file" id="contact_logo" name="contact_logo">

            <button type="submit" class="submit-btn">Save</button>
            <?php if (!empty($contact['logo'])): ?>
                <button type="submit" name="remove_logo" value="1" class="remove-logo-btn">Remove Logo</button>
            <?php endif; ?>
            <button type="button" class="cancel-btn close-modal">Cancel</button>
        </form>
    </div>
</div>

<!-- Edit Single Field Modal -->
<div id="editAboutFieldModal" class="modal">
    <div class="modal-content">
        <h2>Edit Field</h2>
        <form id="aboutFieldForm" action="/../../includes/contacts/update-contact-field-inc.php" method="POST">
            <input type="hidden" name="contact_id" value="<?= $contact['contact_id'] ?>">
            <input type="hidden" name="field_name" id="field_name">
            <label id="field_label" for="field_value">Field</label>
            <input type="text" name="field_value" id="field_value" required>

            <button type="submit" class="submit-btn">Save</button>
            <button type="button" class="cancel-btn close-about-modal">Cancel</button>
        </form>
    </div>
</div>

