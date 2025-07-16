function confirmLogout(e) {
    if (!confirm("Are you sure you want to logout?")) {
        e.preventDefault();
    }
}