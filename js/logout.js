document.getElementById('logout-btn').addEventListener('click', function() {
    if(confirm("Are you sure you want to logout?")) {
        window.location.href = '../landing-page.php?logout';
    }
});