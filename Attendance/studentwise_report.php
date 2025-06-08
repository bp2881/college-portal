<?php
$roll = isset($_GET['roll_number']) ? filter_var($_GET['roll_number'], FILTER_SANITIZE_STRING) : '';
$fdt = isset($_GET['from_date']) ? filter_var($_GET['from_date'], FILTER_SANITIZE_STRING) : '';
$tdt = isset($_GET['to_date']) ? filter_var($_GET['to_date'], FILTER_SANITIZE_STRING) : '';

$pythonPath = "C:\\Users\\Pranav\\AppData\\Local\\Programs\\Python\\Python313\\python.exe";
$pythonScript = "C:\\xampp\\htdocs\\college-portal\\scripts\\studentwise_attendance.py";
$command = escapeshellcmd("$pythonPath $pythonScript $roll $fdt $tdt false");
$output = shell_exec($command);

$jsonFile = "C:\\xampp\\htdocs\\college-portal\\attendance_data.json";

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
include './templates/studentwise_report.html';

// Delete json file
?>