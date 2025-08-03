<?php
ob_start();

require_once __DIR__ . '/../../controllers/contacts-controller.php';

$contactController = new ContactsController();
$user_id = $_SESSION['user_id']; 

require_once __DIR__ . '/../../controllers/deals-controller.php';
$dealController = new DealsController();
$deals = $dealController->getDealsByUser($user_id);
?>


<!-- Deal Sidebar -->
<div id="dealSidebar" class="sidebar sidebar-form ">
    <div class="sidebar-header blue-header">
        <h3>Add New Deal</h3>
        <button class="close-sidebar">&times;</button>
    </div> 

    <!-- Tab Buttons -->
    <div class="tab-buttons">
        <button type="button" class="tab-btn active" data-tab="new-deal"><strong>Create new</strong></button>
        <button type="button" class="tab-btn" data-tab="existing-deal"><strong>Link existing</strong></button>
    </div>

    <!-- Tab Content Wrapper -->
    <div class="tab-content-wrapper">
        <!-- Create New Deal Form -->
        <form action="/includes/companies/link-company-to-deal.php" method="POST" class="tab-content active" id="new-deal">
            <input type="hidden" name="company_id" value="<?= $company['company_id'] ?>">
            <input type="hidden" name="action" value="create_new">
            
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
            <div class="form-actions">
                    <button type="submit" class="btn">Create Deal</button>
                </div>
            </form>

        <!-- Link Existing Deal Form -->
        <form action="/includes/companies/link-company-to-deal.php" method="POST" class="tab-content" id="existing-deal">
            <input type="hidden" name="company_id" value="<?= $company['company_id'] ?>">
            <input type="hidden" name="action" value="link_existing">


            <label for="existing_deal_id">Select Existing Deal</label>
            <select name="existing_deal_id" required>
                <option value="">Select a deal</option>
                <?php foreach ($deals as $deal): ?>
                    <option value="<?= $deal['deal_id'] ?>">
                        <?= htmlspecialchars($deal['title']) ?> - ₹<?= $deal['amount'] ?> - <?= $deal['close_date'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <div class="form-actions">
                <button type="submit" class="btn">Link Deal</button>
            </div>
        </form>

    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.getElementById("dealSidebar");
    const closeBtn = sidebar.querySelector(".close-sidebar");
    const tabButtons = sidebar.querySelectorAll(".tab-btn");
    const tabContents = sidebar.querySelectorAll(".tab-content");

    // Optional: If you have a button somewhere that triggers opening the sidebar
    document.querySelectorAll(".open-deal-sidebar").forEach(button => {
        button.addEventListener("click", () => {
            sidebar.classList.remove("hidden");
        });
    });

    // Close sidebar
    closeBtn.addEventListener("click", () => {
        sidebar.classList.add("hidden");
    });

    // Tab switching
    tabButtons.forEach(button => {
        button.addEventListener("click", () => {
            // Remove active class from all buttons and contents
            tabButtons.forEach(btn => btn.classList.remove("active"));
            tabContents.forEach(content => content.classList.remove("active"));

            // Activate clicked tab and corresponding content
            button.classList.add("active");
            const tabId = button.getAttribute("data-tab");
            document.getElementById(tabId).classList.add("active");
        });
    });
});
</script>
