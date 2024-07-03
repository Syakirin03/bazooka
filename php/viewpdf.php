<?php
include '../database/db.php'; // Include database connection

// Query to fetch all PDF files
$sql = "SELECT * FROM pdf_files";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Uploaded PDFs</title>
    <link rel="stylesheet" href="../css/style3.css">
    <style>
        body {
            background-color: black; /* Set the background color to black */
            color: white; /* Ensure all text is white */
            font-family: Arial, sans-serif;
        }
        .pdf-container {
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
        .pdf-viewer {
            width: 100%;
            height: 400px; /* Adjust height based on your design */
            border: none;
        }
        .pdf-description {
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
        <h1>View Uploaded PDFs</h1>
        <div class="pdf-container">
            <?php
            // PHP code to fetch and display uploaded PDFs with usernames
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $pdfFileName = $row['pdf_file']; // PDF file name from database
                    $pdfFilePath = '../uploaded/' . $pdfFileName; // Path to PDF file

                    // Check if the PDF file exists
                    if (file_exists($pdfFilePath)) {
                        $description = $row['file_name']; // Adjust to display meaningful description
                        $username = getUsername($conn, $row['user_id']);

                        // Generate HTML for embedding PDF viewer
                        echo '<div class="card pdf-item">';
                        echo '<div class="pdf-description">' . $description . '</div>';
                        echo '<div class="publisher">Published by: ' . $username . '</div>';
                        echo '</div>';
                    } else {
                        echo '<div class="card pdf-item">';
                        echo '<p>Error: PDF file not found or inaccessible.</p>';
                        echo '</div>';
                    }
                }
            } else {
                echo '<p>No PDFs uploaded yet.</p>';
            }
            ?>
        </div>
    </div>
</body>
</html>

<?php
$conn->close(); // Close database connection
?>
