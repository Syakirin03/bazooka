<?php
session_start(); // Start session to access session variables

// Check if user is logged in
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $profilePicture = "images/user1.png";
    echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webpage</title>
    <link rel="icon" href="./images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style3.css"> <!-- Ensure style3.css is correctly linked -->
    <style>
        /* Additional CSS styles specific to this page */
        .profile-section {
            display: flex;
            align-items: center;
            cursor: pointer;
            position: relative;
        }

        .profile-section img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .profile-section span {
            color: white;
            font-weight: bold;
        }

        .profile-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background-color: rgba(0, 0, 0, 0.7);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            white-space: nowrap;
        }

        .profile-section.open .profile-dropdown {
            display: block;
        }

        .profile-dropdown a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
        }

        .profile-dropdown a:hover {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .sub-menu-wrap {
            position: absolute;
            top: 100%;
            right: 10%;
            width: 250px;
            max-height: 250px;
            overflow: hidden;
            transition: max-height 0.5s;
            display: none;
        }

        .sub-menu-wrap.open-menu {
            display: block;
        }

        .sub-menu {
            padding: 10px;
            margin: 5px;
        }

        .user-info {
            color: #525252;
            display: flex;
            align-items: center;
        }

        .user-info img {
            size: 50%;
            width: 40px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .user-info h2 {
            margin: 0;
            font-size: 18px;
        }

        .sub-menu-link {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #525252;
            padding: 8px 0; /* Reduce padding to decrease the gap */
        }

        .sub-menu-link img {
            width: 40px; /* Adjust the image size if needed */
            background: #e5e5e5;
            border-radius: 50%;
            padding: 4px;
            margin-right: 10px; /* Reduce margin to decrease the gap */
        }

        .sub-menu-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .welcome-section,
        .dashboard {
            background-color: rgba(249, 249, 249, 0.8); /* Adjust transparency as needed */
            border-radius: 10px; /* Optional: Add rounded corners for a nicer look */
            padding: 20px;
            margin: 20px auto; /* Optional: Adjust margin for positioning */
        }

        .dashboard {
            background-color: #FFF5EE; /* Peach color */
            display: flex;
            justify-content: space-around;
            align-items: stretch; /* Ensure cards stretch vertically */
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .dashboard .card {
            background-color: rgba(211, 211, 211, 0.8); /* Example: Adjust color for cards */
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin: 10px;
            padding: 20px;
            text-align: center;
            height: 100%; /* Set cards to occupy full height */
            display: flex; /* Ensure content inside card can flex */
            flex-direction: column; /* Arrange content vertically */
        }

        .dashboard .card h3 {
            margin-bottom: 15px;
        }

        .dashboard .card p {
            margin-bottom: 10px;
            flex: 1; /* Allow paragraph to grow and fill remaining space */
        }

        .dashboard .card a {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none; /* Remove underline */
            color: #333; /* Change link color */
            border: 1px solid #ccc; /* Add border */
            border-radius: 5px; /* Optional: Add rounded corners */
            transition: background-color 0.3s, color 0.3s ease; /* Smooth transitions */
        }

        .dashboard .card a:hover {
            background-color: #f0f0f0; /* Change background on hover */
            color: #555; /* Change text color on hover */
        }
    </style>
</head>
<body>
<header>
    <div class="logo">
        <img src="images/logo.png" alt="Logo">
    </div>
    <nav>
        <ul>
            <li class="dropdown">Catalog
                <ul class="dropdown-content">
                    <li><a href="php/uploadpage.php">Upload PDF</a></li>
                    <li><a href="php/linkupload.php">Upload Video</a></li>
                </ul>
            </li>
            <li class="dropdown">Researcher
                <ul class="dropdown-content">
                    <li><a href="php/viewpdflogin.php">View PDF</a></li>
                    <li><a href="php/viewcontentlogin.php">View Video</a></li>
                </ul>
            </li>
            <li class="dropdown">Community
                <ul class="dropdown-content">
                    <li><a href="php/forum/index2.php">Forum</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div class="profile-section" onclick="toggleProfileDropDown(event)">
        <img src="$profilePicture" alt="Profile Picture">
        <span>Hello, $username</span>
        <div class="sub-menu-wrap" id="profileDropdown">
            <div class="sub-menu">
                <div class="user-info">
                    <img src="$profilePicture">
                    <h2>$email</h2>
                </div>
                <hr>
                <a href="php/user/operation.php" class="sub-menu-link">
                    <img src="images/setting.png">
                    <p>Setting</p>
                    <span>></span>
                </a>
                <a href="php/logout.php" class="sub-menu-link">
                    <img src="images/logout.png">
                    <p>Log out</p>
                    <span>></span>
                </a>
            </div>
        </div>
    </div>
</header>

<div class="welcome-section">
    <h2>Welcome to the Educational Page</h2>
    <p>Explore the features and functionalities available to you.</p>
</div>

<div class="dashboard">
    <div class="card">
        <h3>Forum</h3>
        <p>View and start your discussion with others and friends.</p>
        <a href="php/forum/index2.php">Go to Forum</a>
    </div>
    <div class="card">
        <h3>Resources</h3>
        <p>Access and manage your educational resources.</p>
        <a href="php/viewcontentlogin.php">View Resources</a>
    </div>
    <div class="card">
        <h3>Settings</h3>
        <p>Adjust your account settings and preferences.</p>
        <a href="php/user/operation.php">Account Settings</a>
    </div>
</div>

<script>
function toggleProfileDropDown(event) {
    event.stopPropagation();
    var profileDropdown = document.getElementById('profileDropdown');
    profileDropdown.classList.toggle('open-menu');
}

document.addEventListener('click', function(event) {
    var profileDropdown = document.getElementById('profileDropdown');
    if (!profileDropdown.contains(event.target) && profileDropdown.classList.contains('open-menu')) {
        profileDropdown.classList.remove('open-menu');
    }
});
</script>
</body>
</html>
HTML;
} else {
    // Redirect to login page if not logged in
    header('Location: loginpage.php');
    exit();
}