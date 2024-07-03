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

    // Create users table if it doesn't exist (Assuming this is needed)
    $create_users_table = "CREATE TABLE IF NOT EXISTS users (
        userid INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL
    )";
    
    if ($conn->query($create_users_table) !== TRUE) {
        die("Error creating users table: " . $conn->error);
    }

    // Create youtube_videos table if it doesn't exist
    $create_youtube_videos_table = "CREATE TABLE IF NOT EXISTS youtube_videos (
        video_id INT AUTO_INCREMENT PRIMARY KEY,
        youtube_link VARCHAR(255) NOT NULL,
        description TEXT,
        user_id INT NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(userid)
    )";
    
    if ($conn->query($create_youtube_videos_table) !== TRUE) {
        die("Error creating youtube_videos table: " . $conn->error);
    }

    // Create pdf_files table if it doesn't exist
    $create_pdf_files_table = "CREATE TABLE IF NOT EXISTS pdf_files (
        pdf_id INT AUTO_INCREMENT PRIMARY KEY,
        pdf_file VARCHAR(255) NOT NULL,
        user_id INT NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(userid)
    )";

    if ($conn->query($create_pdf_files_table) !== TRUE) {
        die("Error creating pdf_files table: " . $conn->error);
    }
} else {
    die("Error creating database: " . $conn->error);
}
