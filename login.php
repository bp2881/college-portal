<?php
// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

$conn = new mysqli('localhost', 'root', '', 'college-data');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['uid'], $_POST['upass'])) {
    $uid = $_POST['uid'];
    $password = $_POST['upass'];
    $stmt = $conn->prepare('SELECT upass FROM users WHERE uid = ?');
    $stmt->bind_param('s', $uid);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['upass'])) {
            session_start();
            $_SESSION['uid'] = $uid;
            header('Location: welcome.php');
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <title>Login | Vignan College</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <div class="container">
        <form class="form-box" action="login.php" method="post">
            <h2>Welcome Back</h2>
            <?php if ($error) { ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php } ?>
            <input type="text" placeholder="UserId" name="uid" required>
            <input type="password" placeholder="Password" name="upass" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>