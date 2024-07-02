<?php
include 'header.php';
// db.php - Database connection and setup
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

    // Create youtube_videos table if it doesn't exist
    $create_youtube_videos_table = "CREATE TABLE IF NOT EXISTS youtube_videos (
        video_id INT AUTO_INCREMENT PRIMARY KEY,
        youtube_link VARCHAR(255) NOT NULL,
        description TEXT
    )";
    
    if ($conn->query($create_youtube_videos_table) !== TRUE) {
        die("Error creating youtube_videos table: " . $conn->error);
    }
} else {
    die("Error creating database: " . $conn->error);
}

// Process form submission to add new video link and description
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['youtubeLink'])) {
    $youtubeLink = $_POST['youtubeLink'];
    $description = $_POST['description'];

    // Insert video link and description into database
    $sql = "INSERT INTO youtube_videos (youtube_link, description) VALUES ('$youtubeLink', '$description')";
    if ($conn->query($sql) !== TRUE) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Redirect to clear form submission data
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

// Query to fetch all YouTube videos from the database
$sql = "SELECT * FROM youtube_videos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload and Display YouTube Videos</title>
    <link rel="stylesheet" href="../css/style3.css">
</head>
<body>
    <h1>Upload and Display YouTube Videos</h1>

    <!-- Form to upload new YouTube video link and description -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="youtubeLink" class="gg" class="custom-file-upload">Enter YouTube Video Link:</label>
        <input type="text" id="youtubeLink" name="youtubeLink" required>
        <br>
        <label for="description"  class="gg">Brief Description:</label>
        <textarea id="description" name="description" rows="4" cols="50" required></textarea>
        <br>
        <button type="submit">Add Video</button>
    </form>

    <!-- Display uploaded YouTube videos -->
    <div class="video-container">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $youtubeLink = $row['youtube_link'];
                $description = $row['description'];

                // Extract video ID from YouTube URL
                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $youtubeLink, $matches);
                $videoID = $matches[1];

                // Generate YouTube embed code with description
                echo '<div class="video-item">';
                echo '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . $videoID . '" frameborder="0" allowfullscreen></iframe>';
                echo '<div class="video-description">' . $description . '</div>';
                echo '</div>';
            }
        } else {
            echo "No videos found.";
        }
        ?>
    </div>

</body>
</html>

<?php
// Close connection
$conn->close();
?>
