document.addEventListener('DOMContentLoaded', () => {
    // Open sidebar
    document.querySelectorAll('.add-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const targetId = btn.getAttribute('data-target');
            const sidebar = document.getElementById(targetId);
            if (sidebar) {
                sidebar.classList.remove('hidden');  // Make it visible in layout
                setTimeout(() => {
                    sidebar.classList.add('visible'); // Slide it in after layout is ready
                }, 10); // short delay ensures transition kicks in
            }
        });
    });

    // Close sidebar
    const closeSidebar = (btn) => {
        const sidebar = btn.closest('.sidebar');
        if (sidebar) {
            sidebar.classList.remove('visible'); // Slide it out
            setTimeout(() => {
                sidebar.classList.add('hidden');  // Hide it from layout after animation
            }, 300); // Wait for transition to finish
        }
    };

    document.querySelectorAll('.close-sidebar, .cancel-btn').forEach(btn => {
        btn.addEventListener('click', () => closeSidebar(btn));
    });

    // Tab switching
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const tabId = this.dataset.tab;

            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

            this.classList.add('active');
            const targetTab = document.getElementById(tabId);
            if (targetTab) {
                targetTab.classList.add('active');
            }
        });
    });
});
