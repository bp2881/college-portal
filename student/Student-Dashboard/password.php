<?php
session_start();
require_once '../config.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$TABLE_NAME = "students";

$message = '';

$jsonFile = "C:\\xampp\\htdocs\\college-portal\\student\\session.json";
$name = "Pranav";
if (file_exists($jsonFile)) {
    $json = file_get_contents($jsonFile);
    $json = json_decode($json, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        $name = $json["name"];
    }
} else {
    header("Location: /college-portal/student/student_login.php");
    exit();
}

if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    die("An error occurred. Please try again later.");
}

// Handle form submission
if (isset($_POST["Save"])) {
    $password = trim($_POST['currentpass'] ?? '');
    $newPassword = trim($_POST['newpass'] ?? '');
    $confirmPassword = trim($_POST['confirmpass'] ?? '');

    $stmt = $conn->prepare("SELECT password FROM $TABLE_NAME WHERE Name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->bind_result($actual_pass);
    $stmt->fetch();
    $stmt->close();

    if ($actual_pass && password_verify($password, $actual_pass)) {
        if ($newPassword !== $confirmPassword) {
            $message = "New password and confirm password do not match.";
        } else {
            $newPasswordHashed = password_hash($newPassword, PASSWORD_DEFAULT);

            $updateStmt = $conn->prepare("UPDATE $TABLE_NAME SET password = ? WHERE Name = ?");
            $updateStmt->bind_param("ss", $newPasswordHashed, $name);

            if ($updateStmt->execute()) {
                header("Location: ../student_login.php");
                exit();
            } else {
                $message = "Failed to update password.";
            }
            $updateStmt->close();
        }
    } else {
        $message = "Incorrect current password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="shortcut icon" href="./images/logo.png">
    <link rel="stylesheet" href="style.css">

    <style>
        header {
            position: relative;
        }

        .change-password-container {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 90vh;
        }

        .change-password-container form {
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-radius: var(--border-radius-2);
            padding: 3.5rem;
            background-color: var(--color-white);
            box-shadow: var(--box-shadow);
            width: 95%;
            max-width: 32rem;
        }

        .change-password-container form:hover {
            box-shadow: none;
        }

        .change-password-container form input[type=password] {
            border: none;
            outline: none;
            border: 1px solid var(--color-light);
            background: transparent;
            height: 2rem;
            width: 100%;
            padding: 0 .5rem;
        }

        .change-password-container form .box {
            padding: .5rem 0;
        }

        .change-password-container form .box p {
            line-height: 2;
        }

        .change-password-container form h2+p {
            margin: .4rem 0 1.2rem 0;
        }

        .btn {
            background: none;
            border: none;
            border: 2px solid var(--color-primary) !important;
            border-radius: var(--border-radius-1);
            padding: .5rem 1rem;
            color: var(--color-white);
            background-color: var(--color-primary);
            cursor: pointer;
            margin: 1rem 1.5rem 1rem 0;
            margin-top: 1.5rem;
        }

        .btn:hover {
            color: var(--color-primary);
            background-color: transparent;
        }

        .alert {
            margin-bottom: 1rem;
            padding: 1rem;
            border: 1px solid var(--color-primary);
            border-radius: var(--border-radius-1);
            background-color: #f9f9f9;
            color: #333;
            font-weight: bold;
            text-align: center;
        }
    </style>

</head>

<body>

    <header>
        <a href="../logout.php" class="logo" title="Student-Portal">
            <img src="./images/logo.png" alt="">
            <h2>V<span class="danger">I</span>TS</h2>
        </a>
        <div class="navbar">
            <a href="./">
                <span class="material-icons-sharp">home</span>
                <h3>Home</h3>
            </a>
            <a href="timetable.html" onclick="timeTableAll()">
                <span class="material-icons-sharp">today</span>
                <h3>Time Table</h3>
            </a>
            <a href="materials.php">
                <span class="material-icons-sharp">book</span>
                <h3>Materials</h3>
            </a>
            <a href="password.php" class="active">
                <span class="material-icons-sharp">password</span>
                <h3>Change Password</h3>
            </a>
            <a href="../logout.php">
                <span class="material-icons-sharp">logout</span>
                <h3>Logout</h3>
            </a>
        </div>
        <div id="profile-btn" style="display: none;">
            <span class="material-icons-sharp">person</span>
        </div>
    </header>

    <div class="change-password-container">
        <form action="password.php" method="post">
            <h2>Create new password</h2>
            <p class="text-muted">Your new password must be different from previously used passwords.</p>

            <?php if (!empty($message)): ?>
                <div class="alert"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>


            <div class="box">
                <p class="text-muted">Current Password</p>
                <input type="password" id="currentpass" name="currentpass" required>
            </div>
            <div class="box">
                <p class="text-muted">New Password</p>
                <input type="password" id="newpass" name="newpass" required>
            </div>
            <div class="box">
                <p class="text-muted">Confirm Password</p>
                <input type="password" id="confirmpass" name="confirmpass" required>
            </div>
            <div class="button">
                <input type="submit" value="Save" name="Save" class="btn">
                <a href="index.php" class="text-muted">Cancel</a>
            </div>
        </form>
    </div>

</body>
<script src="app.js"> </script>

</html>