<?php
session_start();

// Include database connection
include '../database/db.php';

// Function to delete PDF file
function deletePdfFile($fileId, $conn) {
    // Delete file from database
    $sql = "SELECT file_name FROM pdf_files WHERE file_id = $fileId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fileName = $row['file_name'];

        // Delete file from upload directory
        $uploadDir = '../uploaded/';
        $filePath = $uploadDir . $fileName;

        if (file_exists($filePath)) {
            unlink($filePath); // Delete the file from the directory
        }

        // Now delete the record from the database
        $deleteSql = "DELETE FROM pdf_files WHERE file_id = $fileId";
        if ($conn->query($deleteSql) === TRUE) {
            return true; // Deletion successful
        } else {
            return false; // Deletion failed
        }
    } else {
        return false; // File not found
    }
}

// Handle file deletion confirmation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirmDelete'])) {
    $fileId = $_POST['fileId'];
    
    if (deletePdfFile($fileId, $conn)) {
        echo '<script>alert("PDF file deleted successfully."); window.location.href = "uploadpage.php";</script>';
    } else {
        echo "Error deleting PDF file.";
    }
}

// Upload PDF file
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['pdfFile'])) {
    if ($_FILES['pdfFile']['error'] == 0) {
        $allowedMimeTypes = ['application/pdf'];
        $fileMimeType = mime_content_type($_FILES['pdfFile']['tmp_name']);

        if (in_array($fileMimeType, $allowedMimeTypes)) {
            $uploadDir = '../uploaded/';
            $uploadFile = $uploadDir . basename($_FILES['pdfFile']['name']);

            if (move_uploaded_file($_FILES['pdfFile']['tmp_name'], $uploadFile)) {
                // Save the file name and user ID to the database
                $userId = $_SESSION['userid'];
                $fileName = basename($_FILES['pdfFile']['name']);
                $sql = "INSERT INTO pdf_files (file_name, user_id) VALUES ('$fileName', '$userId')";

                if ($conn->query($sql) !== TRUE) {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                } else {
                    echo '<script>alert("File uploaded successfully."); window.location.href = "uploadpage.php";</script>';
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Invalid file type. Only PDF files are allowed.";
        }
    } else {
        echo "Error uploading file.";
    }
}