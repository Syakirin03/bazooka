<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web_db";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if database exists, if not, create it
$check_database_query = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($check_database_query) === TRUE) {
    // Select database
    $conn->select_db($dbname);

    // Create users table if it doesn't exist
    $create_users_table = "CREATE TABLE IF NOT EXISTS users (
        userid INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL
    )";
    
    if ($conn->query($create_users_table) !== TRUE) {
        die("Error creating users table: " . $conn->error);
    }
} else {
    die("Error creating database: " . $conn->error);
}
