<?php
session_start();
include './templates/attendance_dashboard.html';

// Session timeout (30 minutes)
$timeout_duration = 1800;
if (!isset($_SESSION['uid']) || !isset($_SESSION['logged_in']) || (time() - $_SESSION['login_time'] > $timeout_duration)) {
  session_unset();
  session_destroy();
  header("Location: attendace_login.php?message=Session expired");
  exit();
}

// Refresh login time
$_SESSION['login_time'] = time();
?>