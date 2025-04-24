<?php
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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['branch'], $_POST['from_date'], $_POST['to_date'], $_POST['year'], $_POST['section'])) {
  // Get form data
  $year = $_POST['year'];
  $section = $_POST['section'];
  $branch = $_POST['branch'];
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
  header('Location: classwise_report.php?branch=' . urlencode($branch) . '&from_date=' . urlencode($from_date) . '&to_date=' . urlencode($to_date) . '&year=' . urlencode($year) . '&section=' . urlencode($section));
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Attendance Dashboard | Vignan ITS</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./css/style.css" />
</head>

<body>
  <!-- Navbar -->
  <header class="navbar">
    <div class=" logo">
      <img src="./images/vignan_logo.png" alt="Vignan Logo">
    </div>
    <nav class="nav-menu">
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="attendance.html">Attendance</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
    </nav>
    <button class="menu-toggle" aria-label="Toggle menu">☰</button>
  </header>

  <!-- Attendance Section -->
  <section class="hero">
    <div class="overlay"></div>
    <div class="login-card" style="max-width: 900px; width: 100%;">
      <h1>Class Wise Student Attendance Dashboard</h1>
      <form action="class_wise.php" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
        <!-- Top row: Branch, Year, Section -->
        <div style="display: flex; flex-wrap: wrap; gap: 1rem; justify-content: center; margin-bottom: 1.5rem;">
          <div class="input-group">
            <label for="branch">Branch</label>
            <select id="branch" name="branch" required>
              <option value="">Select Branch</option>
              <option value="BSH">BSH</option>
              <option value="CSE">CSE</option>
              <option value="ECE">ECE</option>
              <option value="EEE">EEE</option>
              <option value="MECH">MECH</option>
              <option value="EIE">EIE</option>
              <option value="IT">IT</option>
              <option value="CSM">CSE(AIML)</option>
              <option value="CSD">CSE(DS)</option>
              <option value="AIDS">AI&DS</option>
            </select>
          </div>

          <div class="input-group">
            <label for="year">Year</label>
            <select id="year" name="year" required>
              <option value="">Select Year</option>
              <option value="1">I</option>
              <option value="2">II</option>
              <option value="3">III</option>
              <option value="4">IV</option>
            </select>
          </div>

          <div class="input-group">
            <label for="section">Section</label>
            <select id="section" name="section" required>
              <option value="">Select Section</option>
              <option>A</option>
              <option>B</option>
              <option>C</option>
            </select>
          </div>
        </div>

        <!-- Bottom row: From Date, To Date -->
        <div style="display: flex; flex-wrap: wrap; gap: 1rem; justify-content: center; margin-bottom: 1.5rem;">
          <div class="input-group">
            <label for="from">From Date</label>
            <input type="date" id="from" name="from_date" required />
          </div>

          <div class="input-group">
            <label for="to">To Date</label>
            <input type="date" id="to" name="to_date" required />
          </div>
        </div>

        <button type="submit">Enter</button>
      </form>

    </div>
  </section>

  <footer>
    &copy; 2025 Vignan Institute of Technology & Science. All rights reserved.
  </footer>

  <script>
    const menuToggle = document.querySelector('.menu-toggle');
    const navMenu = document.querySelector('.nav-menu ul');
    menuToggle.addEventListener('click', () => {
      navMenu.classList.toggle('open');
    });
  </script>
</body>

</html>