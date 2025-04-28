<?php
session_start();

// Session timeout (30 minutes)
$timeout_duration = 1800;
if (!isset($_SESSION['uid']) || !isset($_SESSION['logged_in']) || (time() - $_SESSION['login_time'] > $timeout_duration)) {
  session_unset();
  session_destroy();
  header("Location: attendance_login.php?message=Session expired");
  exit();
}

// Refresh login time
$_SESSION['login_time'] = time();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard | Vignan ITS</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="./css/style1.css" />
</head>

<body>
  <!-- Navbar -->
  <header class="navbar">
    <div class="logo">
      <img src="./images/vignan_logo.png" alt="Vignan Logo">
    </div>
    <nav class="nav-menu">
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="student_wise.php">Student-Wise Attendance</a></li>
        <li><a href="class_wise.php">Class-Wise Attendance</a></li>
        <li><a href="attendance_logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <!-- Main content -->
  <section class="dashboard-content">
    <h1>Welcome to the Student Attendance Dashboard</h1>
    <p>Here you can view the attendance details of students and classes.</p>
  </section>

  <footer>
    © 2025 Vignan Institute of Technology & Science. All rights reserved.
  </footer>
</body>

</html>