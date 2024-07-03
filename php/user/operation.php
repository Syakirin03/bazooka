<?php
session_start(); // Start session if not already started

include '../../database/db.php'; // Adjust path as per your file structure

// Initialize variables for form fields
$username = $email = '';
$passwordChangeError = $passwordChangeSuccess = '';

// Fetch current user data
$userId = $_SESSION['userid']; // Assuming you store user_id in session

$stmt = $conn->prepare('SELECT username, email FROM users WHERE userid = ?');
$stmt->bind_param('i', $userId);
$stmt->execute();
$stmt->bind_result($username, $email);
$stmt->fetch();
$stmt->close();

// Handle password change request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $repeatPassword = $_POST['repeat_password'];

    // Example validation (you should add more robust validation)
    if ($newPassword !== $repeatPassword) {
        $_SESSION['passwordChangeError'] = "New passwords do not match.";
    } else {
        // Implement your logic to update password in the database
        // Example: Update password for the current user (replace with your actual update query)
        $userId = $_SESSION['userid']; // Assuming you store user_id in session
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT); // Hash the new password

        $stmt = $conn->prepare('UPDATE users SET password = ? WHERE userid = ?');
        $stmt->bind_param('si', $hashedPassword, $userId);

        if ($stmt->execute()) {
            $_SESSION['passwordChangeSuccess'] = "Password changed successfully.";
        } else {
            $_SESSION['passwordChangeError'] = "Error updating password: " . $conn->error;
        }

        $stmt->close();
    }
    header("Location: ".$_SERVER['PHP_SELF']."#account-change-password"); // Redirect to avoid form resubmission
    exit;
}

// Handle profile update request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    // Update $username, $email with form input values
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Example validation and processing for username and email update
    // Update values in the database
    $userId = $_SESSION['userid']; // Assuming you store user_id in session

    $stmt = $conn->prepare('UPDATE users SET username = ?, email = ? WHERE userid = ?');
    $stmt->bind_param('ssi', $username, $email, $userId);

    if ($stmt->execute()) {
        // Optionally, you can update session variables if needed
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
    } else {
        echo "Error updating profile: " . $conn->error;
    }

    $stmt->close();
    header("Location: ".$_SERVER['PHP_SELF']."#account-general"); // Redirect to avoid form resubmission
    exit;
}

$conn->close(); // Close database connection
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Setting</title>
    <link rel="icon" href="../../images/help.png" type="image/x-icon">

    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container light-style flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-4">
            Account settings
        </h4>
        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list"
                            href="#account-general">General</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-change-password">Change password</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="account-general">
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <div class="form-group">
                                        <label class="form-label">Username</label>
                                        <input type="text" class="form-control mb-1" name="username"
                                            value="<?php echo htmlspecialchars($username); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">E-mail</label>
                                        <input type="email" class="form-control mb-1" name="email"
                                            value="<?php echo htmlspecialchars($email); ?>" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="update_profile">Save
                                        changes</button>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-change-password">
                            <div class="card-body pb-2">
                                <?php if (isset($_SESSION['passwordChangeError'])): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php 
                                    echo $_SESSION['passwordChangeError']; 
                                    unset($_SESSION['passwordChangeError']); // Clear message after displaying
                                    ?>
                                </div>
                                <?php endif; ?>
                                <?php if (isset($_SESSION['passwordChangeSuccess'])): ?>
                                <div class="alert alert-success" role="alert">
                                    <?php 
                                    echo $_SESSION['passwordChangeSuccess']; 
                                    unset($_SESSION['passwordChangeSuccess']); // Clear message after displaying
                                    ?>
                                </div>
                                <?php endif; ?>
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <div class="form-group">
                                        <label class="form-label">Current password</label>
                                        <input type="password" class="form-control" name="current_password" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">New password</label>
                                        <input type="password" class="form-control" name="new_password" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Repeat new password</label>
                                        <input type="password" class="form-control" name="repeat_password" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="change_password">Change
                                        password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right mt-3">
            <a href="../../userpage.php" class="btn btn-default" onclick="goBack()">Back</a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
        function goBack() {
            setTimeout(function() {
                window.location.href = '../userpage.php';
            }, 1000); // Adjust the delay time in milliseconds (e.g., 500 for half a second)
        }
    </script>
</body>

</html>
