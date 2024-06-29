<?php
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password
$dbname = "website_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$check_database_query = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($check_database_query) === TRUE) {
    echo "Database '$dbname' created or already exists.<br>";

    // Select database
    $conn->select_db($dbname);

    // Array of table creation queries
    $table_creation_queries = [
        "CREATE TABLE IF NOT EXISTS users (
            user_id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) UNIQUE NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL
        )"
    ];

    // Execute table creation queries
    foreach ($table_creation_queries as $query) {
        if ($conn->query($query) === TRUE) {
            echo "Table created or already exists.<br>";
        } else {
            echo "Error creating table: " . $conn->error . "<br>";
        }
    }

} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

$conn->close();
?>
