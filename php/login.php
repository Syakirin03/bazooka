<?php
include '../database/db.php'; // Include your connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and bind
    if ($stmt = $conn->prepare("SELECT userid, username, email, password FROM users WHERE username = ? OR email = ?")) {
        $stmt->bind_param("ss", $input, $input);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($userid, $username, $email, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                // Password is correct, start a new session
                session_start();
                $_SESSION['userid'] = $userid;
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                // Redirect to the prototype page
                header("Location: ../userpage.php");
                exit();
            } else {
                // Invalid password
                echo "<script src='../js/script3.js'></script>";
                echo "<script>
                        showAlert('Invalid username or password.', 'loginpage.php');
                      </script>";
            }
        } else {
            // No user found
            echo "<script src='../js/script3.js'></script>";
            echo "<script>
                    showAlert('User not found.', 'loginpage.php');
                  </script>";
        }

        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
    
    $conn->close();
}
