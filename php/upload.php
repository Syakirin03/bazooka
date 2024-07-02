<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['pdfFile']) && $_FILES['pdfFile']['error'] == 0) {
        $allowedMimeTypes = ['application/pdf'];
        $fileMimeType = mime_content_type($_FILES['pdfFile']['tmp_name']);
        
        if (in_array($fileMimeType, $allowedMimeTypes)) {
            $uploadDir = '../uploaded/';
            $uploadFile = $uploadDir . basename($_FILES['pdfFile']['name']);
            
            if (move_uploaded_file($_FILES['pdfFile']['tmp_name'], $uploadFile)) {
                // Show a success message using JavaScript alert
                echo '<script>alert("File uploaded successfully."); window.location.href = "uploadpage.php";</script>';
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Invalid file type. Only PDF files are allowed.";
        }
    } else {
        echo "No file was uploaded or there was an error with the upload.";
    }
}
?>
