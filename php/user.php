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
    </style>
</head>
<body>
<header>
    <div class="logo">
        <img src="images/logo.png" alt="Logo">
    </div>
    <nav>
        <ul>
            <li class="dropdown">Forum
                <ul class="dropdown-content">
                    <li><a href="php/thread.php">Item 1</a></li>
                    <li><a href="#">Item 2</a></li>
                    <li><a href="#">Item 3</a></li>
                </ul>
            </li>
            <li class="dropdown">Researcher
                <ul class="dropdown-content">
                    <li><a href="#">Item 1</a></li>
                    <li><a href="#">Item 2</a></li>
                    <li><a href="#">Item 3</a></li>
                </ul>
            </li>
            <li class="dropdown">Community
                <ul class="dropdown-content">
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