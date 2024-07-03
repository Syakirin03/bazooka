<?php
if (isset($_GET['file'])) {
    $file = $_GET['file'];

    // Check if the file exists
    if (file_exists($file)) {
        // Set headers
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Content-Length: ' . filesize($file));
        header('Cache-Control: private');
        header('Pragma: public');
        ob_clean();
        flush();
        readfile($file);
        exit;
    } else {
        die('File not found');
    }
} else {
    die('Invalid request');
}
