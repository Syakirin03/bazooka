<?php
session_start();
include '../../database/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Validate username and email
    $stmt = $conn->prepare('SELECT userid FROM users WHERE username = ? AND email = ?');
    $stmt->bind_param('ss', $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        // Redirect to set new password form
        header('Location: set.php');
        exit;
    } else {
        echo "<script src='../../js/script3.js'></script>";
        echo "<script> showAlert('Invalid username or email.', 'request.php');</script>";
    }
}
