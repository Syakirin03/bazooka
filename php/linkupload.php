<?php
session_start();
include '../database/db.php'; // Include database connection

// Check if user is logged in and get the user ID
if (isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid'];
} else {
    // Redirect to login page if user is not logged in
    echo '<script>alert("You need to login first."); window.location.href = "loginpage.php";</script>';
    exit;
}

// Process form submission to add new YouTube video link and description
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['youtubeLink'])) {
    $youtubeLink = $conn->real_escape_string($_POST['youtubeLink']);
    $description = $conn->real_escape_string($_POST['description']);

    // Insert video link and description into database
    $sql = "INSERT INTO youtube_videos (youtube_link, description, user_id) VALUES ('$youtubeLink', '$description', '$userId')";
    if ($conn->query($sql) !== TRUE) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Redirect to clear form submission data
    echo '<script>alert("YouTube video link added successfully."); window.location.href = "' . $_SERVER['PHP_SELF'] . '";</script>';
    exit;
}

// Handle YouTube video deletion
if (isset($_GET['delete_video_id'])) {
    $videoId = $_GET['delete_video_id'];

    // Delete the video entry from the database
    $sql = "DELETE FROM youtube_videos WHERE video_id = $videoId AND user_id = $userId";
    $conn->query($sql);

    // Redirect to clear query parameters
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

// Handle video edit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_video_id'])) {
    $editVideoId = $_POST['edit_video_id'];
    $newYoutubeLink = $conn->real_escape_string($_POST['editYoutubeLink']);
    $newDescription = $conn->real_escape_string($_POST['editDescription']);

    // Update existing video link and description in database
    $sql = "UPDATE youtube_videos SET youtube_link = '$newYoutubeLink', description = '$newDescription' WHERE video_id = $editVideoId AND user_id = $userId";
    if ($conn->query($sql) !== TRUE) {
        echo "Error updating video: " . $conn->error;
    } else {
        // Redirect to clear form submission data
        echo '<script>alert("YouTube video details updated successfully."); window.location.href = "' . $_SERVER['PHP_SELF'] . '";</script>';
        exit;
    }
}

// Query to fetch all YouTube videos uploaded by the user
$sql = "SELECT * FROM youtube_videos WHERE user_id = $userId";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload and Display YouTube Videos</title>
    <link rel="icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/style3.css">
    <style>
        body {
            background-color: black; /* Set the background color to black */
            color: white; /* Ensure all text is white */
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .card {
            background-color: #333;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #EDE6D6;
        }
        .form-group input[type="text"], .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #222;
            color: white;
            box-sizing: border-box; /* Ensure padding is included in width */
        }
        .form-group input[type="text"]:focus, .form-group textarea:focus {
            outline: none;
            border-color: #FFC0A9;
        }
        .form-group textarea {
            resize: vertical;
        }
        button {
            background-color: #EDE6D6; /* Peach color */
            color: black; /* Black text */
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }
        button:hover {
            background-color: #FFC0A9; /* Darker peach color on hover */
        }
        .auth-buttons a button {
            background-color: #EDE6D6; /* Peach color */
            color: black; /* Black text */
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }
        .auth-buttons a button:hover {
            background-color: #FFC0A9; /* Darker peach color on hover */
        }
        .link-preview {
            margin-top: 20px;
        }
        .edit-form {
            display: none;
            margin-bottom: 20px;
        }
        .edit-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.8);
            padding: 20px;
            border-radius: 8px;
            max-width: 80%;
            max-height: 80%;
            overflow: auto;
        }
        .edit-modal-content {
            background-color: #222;
            padding: 20px;
            border-radius: 8px;
        }
        .edit-modal-close {
            color: #aaa;
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 28px;
            cursor: pointer;
        }
        .edit-modal-close:hover {
            color: white;
        }
    </style>
    <script>
        function updateLinkPreview() {
            const youtubeLinkInput = document.getElementById('youtubeLink');
            const previewContainer = document.getElementById('linkPreviewContainer');
            const videoID = youtubeLinkInput.value.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/);

            if (videoID) {
                previewContainer.innerHTML = '<iframe width="560" height="315" src="https://www.youtube.com/embed/' + videoID[1] + '" frameborder="0" allowfullscreen></iframe>';
            } else {
                previewContainer.innerHTML = 'Invalid YouTube link';
            }
        }

        function showEditForm(videoId, youtubeLink, description) {
            const editForm = document.getElementById('editForm');
            const editYoutubeLink = document.getElementById('editYoutubeLink');
            const editDescription = document.getElementById('editDescription');

            editForm.style.display = 'block';
            editYoutubeLink.value = youtubeLink;
            editDescription.value = description;

            // Set the hidden input value for the video ID
            document.getElementById('edit_video_id').value = videoId;
        }

        function hideEditModal() {
            const editModal = document.getElementById('editModal');
            editModal.style.display = 'none'; // Hide the edit modal
        }
    </script>
</head>
<header>
    <div class="logo">
        <img src="../images/logo.png" alt="Logo">
    </div>
    <div class="auth-buttons">
        <a href="../userpage.php"><button>Back</button></a>
    </div>
</header>
<body>
    <div class="container">
        <h1>Upload YouTube Video Link</h1>
        <div class="card">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-group">
                    <label for="youtubeLink">Enter YouTube Video Link:</label>
                    <input type="text" id="youtubeLink" name="youtubeLink" required oninput="updateLinkPreview()">
                </div>
                <div class="form-group">
                    <label for="description">Brief Description:</label>
                    <textarea id="description" name="description" rows="4" required></textarea>
                </div>
                <div>
                    <button type="submit">Add Video</button>
                </div>
            </form>
            <div id="linkPreviewContainer" class="link-preview"></div>
        </div>

        <h1>Your Uploaded YouTube Videos</h1>
        <div class="video-container">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $youtubeLink = $row['youtube_link'];
                    $description = $row['description'];
                    $videoId = $row['video_id'];

                    // Extract video ID from YouTube URL
                    preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $youtubeLink, $matches);
                    $videoID = $matches[1];

                    // Generate YouTube embed code with description
                    echo '<div class="card video-item">';
                    echo '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . $videoID . '" frameborder="0" allowfullscreen></iframe>';
                    echo '<div class="video-description">' . $description . '</div>';
                    echo '<button onclick="showEditForm(' . $videoId . ', \'' . $youtubeLink . '\', \'' . $description . '\')">Edit</button>';
                    echo '<button class="delete-button" onclick="deleteVideo(' . $videoId . ')">Delete</button>';
                    echo '</div>';

                    echo '<div id="editModal' . $videoId . '" class="edit-modal">';
                    echo '<div class="edit-modal-content">';
                    echo '<span class="edit-modal-close" onclick="hideEditModal(' . $videoId . ')">&times;</span>';
                    echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">';
                    echo '<input type="hidden" name="edit_video_id" value="' . $videoId . '">';
                    echo '<label for="editYoutubeLink">Edit YouTube Link:</label>';
                    echo '<input type="text" id="editYoutubeLink' . $videoId . '" name="editYoutubeLink" value="' . $youtubeLink . '" required><br>';
                    echo '<label for="editDescription">Edit Description:</label>';
                    echo '<textarea id="editDescription' . $videoId . '" name="editDescription" rows="4" required>' . $description . '</textarea><br>';
                    echo '<button type="submit" name="submit_edit">Save Changes</button>';
                    echo '</form>';
                    echo '</div>';
        echo '</div>';
                }
            } else {
                echo '<div class="card">No videos uploaded yet.</div>';
            }
            ?>
        </div>

        <!-- Edit Form -->
        <div id="editForm" class="card edit-form">
            <h2>Edit Video Details</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <input type="hidden" id="edit_video_id" name="edit_video_id">
                <div class="form-group">
                    <label for="editYoutubeLink">Edit YouTube Video Link:</label>
                    <input type="text" id="editYoutubeLink" name="editYoutubeLink" required>
                </div>
                <div class="form-group">
                    <label for="editDescription">Edit Brief Description:</label>
                    <textarea id="editDescription" name="editDescription" rows="4" required></textarea>
                </div>
                <div>
                    <button type="submit">Update Video</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function deleteVideo(videoId) {
            if (confirm("Are you sure you want to delete this video?")) {
                window.location.href = "<?php echo $_SERVER['PHP_SELF']; ?>?delete_video_id=" + videoId;
            }
        }
    </script>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
