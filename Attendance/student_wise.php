<?php
session_start();
include './templates/student_wise.html';

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