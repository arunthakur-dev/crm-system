<div id="contactSidebar" class="sidebar hidden">
    <div class="sidebar-header blue-header">
        <h2>Create New Deal</h2>
        <button class="close-sidebar-btn" data-target="contactSidebar">✖</button>
    </div>
    <form action="/../../includes/deals/create-deal-inc.php" method="POST" class="sidebar-form">
         
        <label for="title">Deal Name</label>
        <input type="text" id="title" name="title" placeholder="Deal Name" >

        <label for="deal_stage">Deal Stage</label>
        <select id="deal_stage" name="deal_stage"  >
            <option value="">--Select Stage--</option>
            <option value="Visitor Engaged">Visitor Engaged</option>
            <option value="Lead Captured">Lead Captured</option>
            <option value="Demo Delivered">Demo Delivered</option>
            <option value="In Negotiation">In Negotiation</option>
            <option value="Deal Won">Deal Won</option>
            <option value="Deal Lost">Deal Lost</option>
        </select>

        <label for="amount">Amount</label>
        <input type="number" id="amount" name="amount" placeholder="Deal Amount">

        <label for="close_date">Close Date</label>
        <input type="date" id="close_date" name="close_date" placeholder="YYYY-MM-DD" >

        <label for="deal_owner">Deal Owner</label>
        <input type="text" id="deal_owner" name="deal_owner" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" placeholder="Owner's Name">

        <label for="deal_type">Deal Type</label>
        <select id="deal_type" name="deal_type"  >
            <option value="">--Select Deal Type--</option>
            <option value="New">New Bussiness</option>
            <option value="Existing">Existing Bussiness</option>
        </select>


        <label for="priority">Priority</label>
        <select id="priority" name="priority"  >
            <option value="">--Select Deal Type--</option>
            <option value="0">Low</option>
            <option value="1">Medium</option>
            <option value="2">High</option>
        </select>

        <hr>
        <div class="sidebar-header ">
            <h2>Associated Deal with</h2>
        </div>

        <label for="associated_contact">Contact</label>
        <select id="associated_contact" name="associated_contact">
            <option value="">--Select Contact--</option>
            <?php foreach ($contacts as $contact): ?>
                <option value="<?= htmlspecialchars($contact['contact_id']) ?>">
                    <?= htmlspecialchars($contact['first_name'] . ' ' . $contact['last_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="associated_company">Company</label>
        <select id="associated_company" name="associated_company">
            <option value="">--Select Company--</option>
            <?php foreach ($companies as $company): ?>
                <option value="<?= htmlspecialchars($company['company_id']) ?>">
                    <?= htmlspecialchars($company['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Create</button><br><br><br>
    </form>
</div>
