<?php
// Session check (optional if needed for this page)
session_start();
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

$fdt = isset($_GET['from_date']) ? filter_var($_GET['from_date'], FILTER_SANITIZE_STRING) : '';
$tdt = isset($_GET['to_date']) ? filter_var($_GET['to_date'], FILTER_SANITIZE_STRING) : '';
$branch = isset($_GET['branch']) ? filter_var($_GET['branch'], FILTER_SANITIZE_STRING) : '';
$year = isset($_GET['year']) ? filter_var($_GET['year'], FILTER_SANITIZE_STRING) : '';
$section = isset($_GET['section']) ? filter_var($_GET['section'], FILTER_SANITIZE_STRING) : '';
$pythonScript = "C:\\xampp\\htdocs\\college-portal\\scripts\\classwise_attendance.py";
$command = "python $pythonScript $branch $fdt $tdt $year $section";
$output = shell_exec($command);

$jsonFile = "C:\\xampp\\htdocs\\college-portal\\class_attendance_data.json";
$data = [];
if (file_exists($jsonFile)) {
  $json = file_get_contents($jsonFile);
  $data = json_decode($json, true);
  if (json_last_error() !== JSON_ERROR_NONE) {
    $data = [];
    $error = "Error decoding JSON: " . json_last_error_msg();
  }
} else {
  $error = "JSON file not found.";
}

include './templates/classwise_report.html';
