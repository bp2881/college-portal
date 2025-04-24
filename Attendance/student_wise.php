<?php
session_start();

// Session timeout (30 minutes)
$timeout_duration = 1800;
if (
  !isset($_SESSION['uid']) || !isset($_SESSION['logged_in']) || (time() - $_SESSION['login_time'] > $timeout_duration)
) {
  session_unset();
  session_destroy();
  header("Location: attendance_login.php?message=Session expired");
  exit();
}


// Refresh session time
$_SESSION['login_time'] = time();

// Check form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['roll_number'], $_POST['from_date'], $_POST['to_date'])) {
  $roll_number = $_POST['roll_number'];
  $from_date = $_POST['from_date'];
  $to_date = $_POST['to_date'];
  $year = substr($from_date, 0, 4);
  $month = substr($from_date, 5, 2);
  $day = substr($from_date, 8, 2);
  $from_date = $day . "-" . $month . "-" . $year;
  $year = substr($to_date, 0, 4);
  $month = substr($to_date, 5, 2);
  $day = substr($to_date, 8, 2);
  $to_date = $day . "-" . $month . "-" . $year;
  $from_date = substr($from_date, 0, 10);
  $to_date = substr($to_date, 0, 10);


  // Redirect to the report page with URL parameters
  header('Location: studentwise_report.php?roll_number=' . urlencode($roll_number) . '&from_date=' . urlencode($from_date) . '&to_date=' . urlencode($to_date));
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Individual Attendance</title>
  <link rel="stylesheet" href="./css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar">
    <div class="logo"><img src="./images/vignan_logo.png" alt="Logo"></div>
    <div class="college-name">Vignan Institute of Technology & Science</div>
    <div class="right-space"></div>
    <div class="nav-menu">
      <ul>
        <li><a href="attendance_dashboard.php">Home</a></li>
        <li><a href="/attendance">Attendance</a></li>
        <li><a href="/contact">Contact</a></li>
      </ul>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero">
    <div class="overlay"></div>

    <!-- Attendance Input Card -->
    <div class="login-card">
      <h1>Individual Student Attendance</h1>
      <form action="student_wise.php" method="POST">
        <div class="input-group">
          <label for="rno">Roll Number</label>
          <input type="text" id="rno" name="roll_number" placeholder="Enter Roll Number" required>
        </div>

        <div class="input-group">
          <label for="fdt">From Date</label>
          <input type="date" id="fdt" name="from_date" required>
        </div>

        <div class="input-group">
          <label for="tdt">To Date</label>
          <input type="date" id="tdt" name="to_date" required>
        </div>

        <button type="submit">Show Attendance</button>
      </form>
    </div>
  </section>

  <footer>
    &copy; 2025 Vignan Institute of Technology and Science
  </footer>

</body>

</html>