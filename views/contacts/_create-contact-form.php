<div id="contactSidebar" class="sidebar hidden">
    <div class="sidebar-header blue-header">
        <h2>Create New Contact</h2>
        <button class="close-sidebar-btn" data-target="contactSidebar">✖</button>
    </div>
    <form action="/../../includes/contacts/create-contact-inc.php" method="POST" class="sidebar-form">
         
        <label for="email">Email </label>
        <input type="email" id="email" name="email" placeholder="e.g. example@gmail.com"  >

        <label for="first_name">First Name</label>
        <input type="text" id="first_name" name="first_name" placeholder="First Name" >

        <label for="last_name">Last Name</label>
        <input type="text" id="last_name" name="last_name" placeholder="Last Name" >

        <label for="contact_owner">Contact Owner</label>
        <input type="text" id="contact_owner" name="contact_owner" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" placeholder="Owner's Name">

        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" placeholder="e.g. 123-456-7890">

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
        <button type="submit">Create</button><br><br><br>
    </form>
</div>
