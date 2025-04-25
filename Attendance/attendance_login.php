<?php
// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// Start session
session_start();

// Include database configuration
require_once 'config.php';

// Database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$TABLE_NAME = 'faculty_login';
if ($conn->connect_error) {
  error_log("Connection failed: " . $conn->connect_error);
  die("An error occurred. Please try again later.");
}

// Initialize error message
$error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $uid = trim($_POST['uid'] ?? '');
  $password = trim($_POST['upass'] ?? '');

  if (empty($uid) || empty($password)) {
    $error = "Username and password are required.";
  } else {
    $stmt = $conn->prepare("SELECT password FROM $TABLE_NAME WHERE uid = ?");
    if (!$stmt) {
      error_log("Prepare failed: " . $conn->error);
      die("An error occurred. Please try again later.");
    }

    $stmt->bind_param('s', $uid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      if (password_verify($password, $row['password'])) {
        // Regenerate session ID to prevent fixation
        session_regenerate_id(true);
        $_SESSION['uid'] = $uid;
        $_SESSION['logged_in'] = true;
        $_SESSION['login_time'] = time();
        header('Location: attendance_dashboard.php');
        exit;
      } else {
        $error = "Invalid password.";
      }
    } else {
      $error = "User not found.";
    }

    $stmt->close();
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student Attendance | Vignan ITS</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./css/style.css" />
  <style>
    .error {
      color: #d32f2f;
      font-size: 0.9rem;
      margin-bottom: 1rem;
      text-align: center;
    }

    /* Password input group */
    .input-group.password {
      position: relative;
    }

    .input-group .toggle-icon {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      cursor: pointer;
      color: #555;
      font-size: 1rem;
      opacity: 0.6;
      z-index: 10;
      background: none;
      border: none;
      padding: 0;
    }

    .input-group.password input {
      padding-right: 35px;
    }
  </style>
</head>

<body>
  <header class="navbar">
    <div class="logo">
      <img src="./images/vignan_logo.png" alt="Vignan Logo">
    </div>
    <div class="college-name">
      Vignan Institute of Technology and Science
    </div>
    <nav class="nav-menu">
      <ul>
        <li><a href="index.html">Home</a></li>
      </ul>
    </nav>
  </header>

  <section class="hero">
    <div class="overlay"></div>
    <div class="login-card">
      <h1>Student Attendance Portal</h1>
      <h2>LOGIN</h2>
      <?php if (!empty($error))
        echo "<p class='error'>$error</p>"; ?>
      <form id="loginForm" method="POST" action="">
        <div class="input-group">
          <label for="uid">Username</label>
          <input id="uid" name="uid" type="text" placeholder="Enter your username" required />
        </div>
        <div class="input-group password">
          <label for="upass">Password</label>
          <input id="upass" name="upass" type="password" placeholder="Enter your password" required
            aria-describedby="password-toggle" />
          <button type="button" class="toggle-icon" onclick="togglePassword()"
            aria-label="Toggle password visibility">👁️</button>
        </div>
        <button type="submit">Login</button>
      </form>
    </div>
  </section>

  <footer>
    © 2025 Vignan Institute of Technology & Science. All rights reserved.
  </footer>
</body>

</html>