// script4.js

document.addEventListener("DOMContentLoaded", function() {
    var profileSection = document.querySelector('.profile-section');
    var dropdownContent = profileSection.querySelector('.dropdown-content');

    profileSection.addEventListener('mouseenter', function() {
        dropdownContent.style.display = 'block';
    });

    profileSection.addEventListener('mouseleave', function() {
        dropdownContent.style.display = 'none';
    });

    dropdownContent.addEventListener('mouseenter', function() {
        dropdownContent.style.display = 'block';
    });

    dropdownContent.addEventListener('mouseleave', function() {
        dropdownContent.style.display = 'none';
    });
});