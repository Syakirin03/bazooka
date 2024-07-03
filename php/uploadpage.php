<?php
session_start();

// Include database connection
include '../database/db.php';

if (!isset($_SESSION['userid'])) {
    // Redirect to login page
    echo '<script>alert("You need to login first."); window.location.href = "loginpage.php";</script>';
    exit();
}

// Function to fetch PDF files uploaded by the user
function fetchUploadedPDFs($conn) {
    $userId = $_SESSION['userid'];
    $sql = "SELECT * FROM pdf_files WHERE user_id = $userId";
    $result = $conn->query($sql);

    $pdfFiles = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pdfFiles[] = $row;
        }
    }
    return $pdfFiles;
}

// Handle file deletion confirmation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirmDelete'])) {
    $fileId = $_POST['fileId'];
    
    // Confirm deletion
    $deleteSql = "DELETE FROM pdf_files WHERE file_id = $fileId";
    if ($conn->query($deleteSql) === TRUE) {
        // Delete file from upload directory (optional)
        $uploadDir = '../uploaded/';
        $fileName = $_POST['fileName'];
        $filePath = $uploadDir . $fileName;
        
        if (file_exists($filePath)) {
            unlink($filePath); // Delete the file from the directory
        }

        echo '<script>alert("PDF file deleted successfully."); window.location.href = "uploadpage.php";</script>';
    } else {
        echo "Error deleting PDF file: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload PDF</title>
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
        .file-upload-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .custom-file-upload, .uploaded-file-name {
            color: white; /* Ensure the label text is white */
        }
        .pdf-item {
            margin-bottom: 10px;
        }
        .pdf-item a {
            color: white; /* Ensure PDF links are white */
            text-decoration: underline;
            margin-right: 10px;
        }
        .pdf-item button {
            background-color: #EDE6D6; /* Peach color */
            color: black; /* Black text */
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }
        .pdf-item button:hover {
            background-color: #FFE5B4; /* Darker peach color on hover */
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
            background-color: #FFE5B4; /* Darker peach color on hover */
        }
        .confirmation-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
            z-index: 1000;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .confirmation-box {
            background-color: #333;
            padding: 20px;
            border-radius: 8px;
            max-width: 400px;
        }
        .confirmation-box p {
            color: white;
            margin-bottom: 10px;
        }
        .confirmation-buttons {
            margin-top: 20px;
        }
    </style>
    <script>
        function updateFileName() {
            const fileInput = document.getElementById('pdfFile');
            const fileNameDisplay = document.getElementById('fileNameDisplay');
            
            if (fileInput.files.length > 0) {
                fileNameDisplay.textContent = fileInput.files[0].name;
            } else {
                fileNameDisplay.textContent = '';
            }
        }

        function clearFileName() {
            const fileNameDisplay = document.getElementById('fileNameDisplay');
            fileNameDisplay.textContent = '';
        }

        function showConfirmation(fileId, fileName) {
            document.getElementById('fileIdToDelete').value = fileId;
            document.getElementById('fileNameToDelete').value = fileName;
            document.getElementById('confirmationModal').style.display = 'flex';
        }

        function hideConfirmation() {
            document.getElementById('confirmationModal').style.display = 'none';
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
        <h1>Upload PDF File</h1>
        <div class="card">
            <form action="upload.php" method="post" enctype="multipart/form-data" onsubmit="clearFileName()">
                <div class="file-upload-container">
                    <label for="pdfFile" class="custom-file-upload">Choose a PDF file:</label>
                    <input type="file" id="pdfFile" name="pdfFile" accept="application/pdf" required onchange="updateFileName()">
                    <span id="fileNameDisplay" class="uploaded-file-name"></span>
                </div>
                <div>
                    <button type="submit">Upload</button>
                </div>
            </form>
        </div>

        <h1>Your Uploaded PDFs</h1>
        <div class="pdf-list">
            <?php
            // Fetch and display PDFs uploaded by the user
            $pdfFiles = fetchUploadedPDFs($conn);

            if (!empty($pdfFiles)) {
                foreach ($pdfFiles as $file) {
                    echo '<div class="card pdf-item">';
                    echo '<a href="../uploaded/' . $file['file_name'] . '" target="_blank">' . $file['file_name'] . '</a>';
                    echo '<button onclick="showConfirmation(' . $file['file_id'] . ', \'' . $file['file_name'] . '\')">Delete</button>';
                    echo '</div>';
                }
            } else {
                echo '<div class="card">No PDFs uploaded yet.</div>';
            }
            ?>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="confirmation-modal" id="confirmationModal">
        <div class="confirmation-box">
            <p>Are you sure you want to delete this PDF file?</p>
            <form action="upload.php" method="post">
                <input type="hidden" id="fileIdToDelete" name="fileId">
                <input type="hidden" id="fileNameToDelete" name="fileName">
                <div class="confirmation-buttons">
                    <button type="submit" name="confirmDelete">Yes, Delete</button>
                    <button type="button" onclick="hideConfirmation()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
