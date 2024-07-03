<?php
include '../database/db.php'; // Include database connection

// Query to fetch all YouTube videos
$sql = "SELECT * FROM youtube_videos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Uploaded Videos</title>
    <link rel="stylesheet" href="../css/style3.css">
    <style>
        body {
            background-color: black; /* Set the background color to black */
            color: white; /* Ensure all text is white */
            font-family: Arial, sans-serif;
        }
        .video-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 20px;
        }
        .card {
            background-color: #333;
            border-radius: 8px;
            padding: 20px;
            width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card iframe {
            width: 100%;
            height: 200px;
            border: none;
            border-radius: 8px;
        }
        .video-description {
            color: #ccc;
            margin-top: 10px;
        }
        .publisher {
            color: #ccc;
            margin-top: 10px;
        }
        .card button {
            background-color: #EDE6D6; /* Peach color */
            color: black; /* Black text */
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            margin-top: 10px;
        }
        .card button:hover {
            background-color: #FFC0A9; /* Darker peach color on hover */
        }
    </style>
</head>
    <header>
        <div class="logo">
            <img src="../images/logo.png" alt="Logo">
        </div>
        <div class="auth-buttons">
            <a href="../index.php"><button>Back</button></a>
        </div>
    </header>
<body>
    <!-- Main Content Section -->
    <div class="container">
        <h1>View Uploaded Videos</h1>
        <div class="video-container">
            <?php
            // PHP code to fetch and display uploaded videos with usernames
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $youtubeLink = $row['youtube_link'];
                    $description = $row['description'];
                    $username = getUsername($conn, $row['user_id']);

                    // Extract video ID from YouTube URL
                    preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $youtubeLink, $matches);
                    $videoID = $matches[1];

                    // Generate YouTube embed code with description
                    echo '<div class="card video-item">';
                    echo '<iframe width="100%" height="200" src="https://www.youtube.com/embed/' . $videoID . '" frameborder="0" allowfullscreen></iframe>';
                    echo '<div class="video-description">' . $description . '</div>';
                    echo '<div class="publisher">Published by: ' . $username . '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No videos uploaded yet.</p>';
            }
            ?>
        </div>
    </div>
</body>
</html>

<?php
$conn->close(); // Close database connection
?>


