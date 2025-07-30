<div id="companySidebar" class="sidebar hidden">
    <div class="sidebar-header blue-header">
        <h2>Create New Contact</h2>
        <button class="close-sidebar-btn" data-target="companySidebar">✖</button>
    </div>
    <form action="/../../includes/create-company-inc.php" method="POST" class="sidebar-form">
        
        <label for="company_domain">Email </label>
        <input type="email" id="company_domain" name="company_domain" placeholder="e.g. example@gmail.com"  >

        <label for="name">First Name</label>
        <input type="text" id="name" name="name" placeholder="First Name" >

        <label for="last_name">Last Name</label>
        <input type="text" id="last_name" name="last_name" placeholder="Last Name" >

        <label for="owner">Contact Owner</label>
        <input type="text" id="owner" name="owner" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" placeholder="Owner's Name">

        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" placeholder="e.g. 123-456-7890">

        <label for="stage">Lifecycle Stage</label>
        <select id="stage" name="stage"  >
            <option value="">Select Stage</option>
            <option value="Lead">Lead</option>
            <option value="Qualified">Qualified</option>
            <option value="Opportunity">Opportunity</option>
            <option value="Customer">Customer</option>
            <option value="Subscriber">Subscriber</option>
            <option value="Evangelist">Evangelist</option>
            <option value="Other">Other</option>
        </select>

        <label for="status">Lifecycle Status</label>
        <select id="status" name="status"  >
            <option value="">Select Status</option>
            <option value="New">New</option>
            <option value="Open">Open</option>
            <option value="In Progress">In Progress</option>
            <option value="Open Deal">Open Deal</option>
            <option value="Attempt to Contact">Attempt to Contact</option>
            <option value="Connected">Connected</option>
            <option value="Other">Other</option>
        </select>
        <button type="submit">Create</button><br><br><br>
    </form>
</div>
