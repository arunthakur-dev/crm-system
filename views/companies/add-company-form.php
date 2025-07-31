<!-- Example: add-company-form.php -->
<div id="companySidebar" class="sidebar-form hidden">
    <div class="sidebar-header">
        <h3>Add Company</h3>
        <button class="close-sidebar">&times;</button>
    </div>
    <form action="/includes/companies/create-company-inc.php" method="POST">
        <input type="text" name="name" placeholder="Company Name" required>
        <input type="text" name="industry" placeholder="Industry">
        <button type="submit">Save</button>
    </form>
</div>
