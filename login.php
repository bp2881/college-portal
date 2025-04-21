<?php
// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

$conn = new mysqli('localhost', 'root', '', 'college-data');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['pass'])) {
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $stmt = $conn->prepare('SELECT pass FROM student WHERE email = ?');
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['pass'])) {
            session_start();
            $_SESSION['email'] = $email;
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
            <input type="text" placeholder="Email" name="email" required>
            <input type="password" placeholder="Password" name="pass" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>