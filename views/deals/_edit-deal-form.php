<!-- Edit Deal Modal -->
<div id="editCompanyModal" class="modal">
    <div class="modal-content">
        <h2>Edit Deal Details</h2>
        <form action="/../../includes/deals/update-deal-inc.php" method="POST">
            <input type="hidden" name="deal_id" value="<?= $deal['deal_id'] ?>">

            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($deal['title']) ?>" required>

            <label for="deal_type">Deal Type</label>
            <input type="text" id="deal_type" name="deal_type" value="<?= htmlspecialchars($deal['deal_type']) ?>">

            <label for="amount">Amount</label>
            <input type="number" id="amount" name="amount" value="<?= htmlspecialchars($deal['amount']) ?>">

            <label for="close_date">Close Date</label>
            <input type="date" id="close_date" name="close_date" value="<?= htmlspecialchars($deal['close_date']) ?>"><br><br>

            <button type="submit" class="submit-btn">Save</button>
            <button type="button" class="cancel-btn close-modal">Cancel</button>
        </form>
    </div>
</div>


<!-- Edit Deal About Field Modal -->
<div id="editAboutFieldModal" class="modal">
    <div class="modal-content">
        <h2>Edit Field</h2>
        <form id="dealFieldForm" action="/../../includes/deals/update-deal-field-inc.php" method="POST">
            <input type="hidden" name="deal_id" value="<?= $deal['deal_id'] ?>">
            <input type="hidden" name="field_name" id="deal_field_name">
            <label id="deal_field_label" for="deal_field_value">Field</label>
            <input type="text" name="field_value" id="deal_field_value" required>

            <button type="submit" class="submit-btn">Save</button>
            <button type="button" class="cancel-btn close-about-modal">Cancel</button>
        </form>
    </div>
</div>
