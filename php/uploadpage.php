<?php
include 'header.php';
echo'<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload PDF</title>
    <link rel="stylesheet" href="../css/style3.css">

</head>
<body>
    <h1>Upload PDF File</h1>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="pdfFile" class="custom-file-upload">Choose a PDF file:</label>
        <input type="file" id="pdfFile" name="pdfFile" accept="application/pdf" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
';