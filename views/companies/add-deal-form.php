<!-- In add-deal-form.php -->
<div id="dealSidebar" class="sidebar-form hidden">
    <div class="sidebar-header">
        <h3>Add Deal</h3>
        <button class="close-sidebar">&times;</button>
    </div>
    <form action="/includes/deals/create-deal-inc.php" method="POST">
        <input type="text" name="deal_name" placeholder="Deal Name" required>
        <input type="hidden" name="company_id" value="<?= $company['company_id'] ?>">
        <!-- Add more deal fields -->
        <button type="submit">Save</button>
    </form>
</div>
