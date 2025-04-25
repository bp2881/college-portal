<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

session_start();
$error = "";
$show_otp = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['pass'] ?? '');

    if (empty($email) || empty($password)) {
        $error = "Email and password are required.";
    } else {

        if ($password == "vgnt") {
            session_regenerate_id(true);
            $show_otp = true;
            $_SESSION['email'] = $email;
            $_SESSION['logged_in'] = true;
            $_SESSION['login_time'] = time();
        } else {
            $error = "Invalid password.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <title>Studen Login</title>
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .error {
            color: #d32f2f;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        .otp-form {
            display: none;
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
            color: var(--primary);
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <form class="form-box" action="student_login.php" method="post">
            <h2>Welcome Back</h2>
            <?php if ($error) { ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php } ?>
            <input type="text" placeholder="Email" name="email" required>
            <input type="password" placeholder="Password" name="pass" required>
            <button type="submit">Login</button>
        </form>
        <form class="otp-form" action="student_login.php" method="post"
            style="<?php echo $show_otp ? 'display:block' : 'display:none'; ?>">
            <h2>OTP Verification</h2>
            <input type="text" placeholder="Enter OTP" name="otp" required>
            <button type="button">Verify OTP</button>
        </form>
    </div>
</body>

</html>