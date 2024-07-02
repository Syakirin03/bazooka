<?php
session_start();

// Check if username and email are set in session
if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    echo "<script src='../../js/script3.js'></script>";
    echo "<script> showAlert('Username or email not found in session.', 'request.php');</script>";
    exit;
}

// Retrieve username and email from session
$username = $_SESSION['username'];
$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style2.css">
    <title>Set New Password</title>
</head>
<body>
    <div class="wrapper">
        <div class="form-box">
            <div class="reset-container">
                <div class="top">
                    <header>Set New Password</header>
                </div>
                <form action="update.php" method="post">
                    <div class="input-box">
                        <input type="password" name="new_password" class="input-field" placeholder="    Enter New Password" required>
                        <i class="bx bx-lock-alt"></i>
                    </div>
                    <div class="input-box">
                        <input type="submit" class="submit" value="Update Password">
                    </div>
                </form>
                <div class="back-button">
                    <a href="request.php">Back</a>
                </div>
            </div>
        </div>
    </div>
    <script src="../../js/script2.js"></script>
</body>
</html>
