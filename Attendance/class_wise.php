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

include './templates/class_wise.html';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['branch'], $_POST['from_date'], $_POST['to_date'], $_POST['year'], $_POST['section'])) {
  // Get form data
  $year = $_POST['year'];
  $section = $_POST['section'];
  $branch = $_POST['branch'];
  $from_date = $_POST['from_date'];
  $to_date = $_POST['to_date'];
  $dyear = substr($from_date, 0, 4);
  $month = substr($from_date, 5, 2);
  $day = substr($from_date, 8, 2);
  $from_date = $day . "-" . $month . "-" . $dyear;
  $dyear = substr($to_date, 0, 4);
  $month = substr($to_date, 5, 2);
  $day = substr($to_date, 8, 2);
  $to_date = $day . "-" . $month . "-" . $dyear;
  $from_date = substr($from_date, 0, 10);
  $to_date = substr($to_date, 0, 10);

  header('Location: classwise_report.php?branch=' . urlencode($branch) . '&from_date=' . urlencode($from_date) . '&to_date=' . urlencode($to_date) . '&year=' . urlencode($year) . '&section=' . urlencode($section));
  exit();
}
