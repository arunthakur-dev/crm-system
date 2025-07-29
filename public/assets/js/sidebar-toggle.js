// /assets/js/sidebar-toggle.js

document.addEventListener("DOMContentLoaded", () => {
    // Open sidebar
    document.querySelectorAll(".open-sidebar-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            const targetId = btn.getAttribute("data-target");
            const sidebar = document.getElementById(targetId);
            if (sidebar) {
                sidebar.classList.add("visible");
                sidebar.classList.remove("hidden");
            }
        });
    });

    // Close sidebar
    document.querySelectorAll(".close-sidebar-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            const targetId = btn.getAttribute("data-target");
            const sidebar = document.getElementById(targetId);
            if (sidebar) {
                sidebar.classList.remove("visible");
                setTimeout(() => {
                    sidebar.classList.add("hidden");
                }, 300); // CSS transition match
            }
        });
    });
});
