<?php
// Include database connection
include '../database/db.php';

session_start();

if (!isset($_SESSION['userid'])) {
    // Redirect to login page
    echo '<script>alert("You need to login first."); window.location.href = "loginpage.php";</script>';
    exit();
}

function fetchUploadedPDFs($conn) {
    $userId = $_SESSION['userid'];
    $sql = "SELECT pdf_files.file_name, users.username 
            FROM pdf_files 
            INNER JOIN users ON pdf_files.user_id = users.userid 
            WHERE pdf_files.user_id = $userId";
    $result = $conn->query($sql);

    $pdfFiles = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pdfFiles[] = $row;
        }
    }
    return $pdfFiles;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Uploaded PDFs</title>
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
        .pdf-item {
            margin-bottom: 10px;
        }
        .pdf-item a {
            color: white; /* Ensure PDF links are white */
            text-decoration: underline;
            margin-right: 10px;
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
        <a href="../userpage.php"><button>Back</button></a>
    </div>
</header>
<body>
    <div class="container">
        <h1>View Uploaded PDFs</h1>
        <div class="pdf-container">
            <?php
            // Fetch and display PDFs uploaded by the user
            $pdfFiles = fetchUploadedPDFs($conn);
            if (!empty($pdfFiles)) {
                foreach ($pdfFiles as $file) {
                    
                    echo '<div class="card pdf-item">';
                    echo '<a href="../uploaded/' . $file['file_name'] . '" target="_blank">' . $file['file_name'] . '</a>';
                    echo '<div class="publisher">Uploaded by: ' . $file['username'] . '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="card">No PDFs uploaded yet.</div>';
            }
            ?>
        </div>
    </div>
</body>
</html>

<?php
$conn->close(); // Close database connection
?>
