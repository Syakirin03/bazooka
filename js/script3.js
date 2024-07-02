function showAlert(message, redirectUrl) {
    alert(message);
    window.location.href = redirectUrl;
}

document.addEventListener("DOMContentLoaded", function() {
    var profileSection = document.querySelector('.profile-section');

    profileSection.addEventListener('click', function() {
        this.classList.toggle('open');
    });

    document.addEventListener('click', function(event) {
        if (!profileSection.contains(event.target)) {
            profileSection.classList.remove('open');
        }
    });
});

function toggleProfileDropdown() {
    var profileSection = document.querySelector('.profile-section');
    profileSection.classList.toggle('open');
}
