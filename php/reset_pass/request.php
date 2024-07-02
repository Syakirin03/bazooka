<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style2.css">
    <title>Request Password Reset</title>
</head>
<body>
    <div class="wrapper">
        <div class="form-box">
            <div class="reset-container">
                <div class="top">
                    <header>Request Password Reset</header>
                </div>
                <form action="reset.php" method="post">
                    <div class="input-box">
                        <input type="text" name="username" class="input-field" placeholder="Username" required>
                        <i class="bx bx-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="email" name="email" class="input-field" placeholder="Email" required>
                        <i class="bx bx-envelope"></i>
                    </div>
                    <div class="input-box">
                        <input type="submit" class="submit" value="Reset Password">
                    </div>
                </form>
                <div class="back-button">
                    <a href="../loginpage.php">Back</a>
                </div>
            </div>
        </div>
    </div>
    <script src="../../js/script2.js"></script>
</body>
</html>
