<?php
session_start(); // Start the session

include '../../database/db.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve username and email from session
    $username = $_SESSION['username'] ?? '';
    $email = $_SESSION['email'] ?? '';

    // Validate username and email (already validated before reaching this point)
    if (empty($username) || empty($email)) {
        echo "<script src='../../js/script3.js'></script>";
        echo "<script> showAlert('Username or email not found in session.', 'set.php');</script>";
        exit;
    }

    // Retrieve new password from form input
    $new_password = $_POST['new_password'] ?? '';

    // Validate new password (e.g., check length, complexity, etc.)
    if (strlen($new_password) < 8) {
        echo "<script src='../../js/script3.js'></script>";
        echo "<script> showAlert('Password must be at least 8 characters long.', 'set.php');</script>";
        exit;
    }

    // Hash the new password securely
    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

    // Update password in the database
    $stmt = $conn->prepare('UPDATE users SET password = ? WHERE username = ? AND email = ?');
    $stmt->bind_param('sss', $new_password_hash, $username, $email);

    if ($stmt->execute()) {
        // Password updated successfully
        echo "<script src='../../js/script3.js'></script>";
        echo "<script> showAlert('The password has been changed!', '../loginpage.php');</script>";
    } else {
        // Handle database update error
        echo "<script src='../../js/script3.js'></script>";
        echo "<script>";
        echo "showAlert('Error updating password: " . $conn->error . "', '../loginpage.php');";
        echo "</script>";
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();

} else {
    // Handle cases where POST method is not used
    echo "<script src='../../js/script3.js'></script>";
    echo "<script> showAlert('Invalid request.', '../loginpage.php');</script>";
}
