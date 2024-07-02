<?php
echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webpage</title>
    <link rel="stylesheet" href="css/style3.css">
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
                    <li><a href="#">Item 1</a></li>
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
    <div class="auth-buttons">
        <a href="php/loginpage.php"><button>Login / Register</button></a>
    </div>
</header>';
