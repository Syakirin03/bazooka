<?php
include '../database/db.php'; // Include your connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Prepare and bind
    if ($stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)")) {
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            // Registration successful
            echo "<script src='../js/script3.js'></script>";
            echo "<script>
                    showAlert('Registration successful. You can now login.', 'loginpage.php');
                  </script>";
        } else {
            // Registration failed
            echo "<script src='../js/script3.js'></script>";
            echo "<script>
                    showAlert('Error: " . $stmt->error . "', window.history.back());
                  </script>";
        }

        $stmt->close();
    } else {
        echo "<script src='../js/script3.js'></script>";
        echo "<script>
                showAlert('Error: " . $conn->error . "', window.history.back());
              </script>";
    }

    $conn->close();
}
