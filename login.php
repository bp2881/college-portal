<?php
$host = 'localhost';
$db = 'college-data';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

if (isset($_POST['uid']) && isset($_POST['upass'])) {
    $uid = $_POST['uid'];
    $password = $_POST['upass'];
    $stmt = $conn->prepare('SELECT * FROM users WHERE uid = ?');
    $stmt->bind_param('s', $uid);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['upass'])) {
            session_start();
            $_SESSION['uid'] = $uid;
            header('Location: welcome.php');
            exit();
        } else {
            echo "<script>alert('Invalid Password');</script>";
        }
    } else {
        echo "<script>alert('User not found');</script>";
    }
    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login | Vignan College</title>
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <div class="container">
        <form class="form-box" action="login.php" method="post">
            <h2>Welcome Back</h2>
            <input type="text" placeholder="UserId" name="uid" required />
            <input type="password" placeholder="Password" name="upass" required />
            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>