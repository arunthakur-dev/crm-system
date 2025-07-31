<div id="companySidebar" class="sidebar hidden">
    <div class="sidebar-header blue-header">
        <h2>Create New Company</h2>
        <button class="close-sidebar-btn" data-target="companySidebar">✖</button>
    </div>
    <form action="/../../includes/companies/create-company-inc.php" method="POST" class="sidebar-form">
        
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

        <button type="submit">Create</button><br><br><br>
    </form>
</div>
