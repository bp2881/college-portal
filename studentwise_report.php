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

$_SESSION['login_time'] = time();

$roll_number = $_GET['roll_number'] ?? '';
$from_date = $_GET['from_date'] ?? '';
$to_date = $_GET['to_date'] ?? '';
$path = 'C:\xampp\htdocs\college-portal\scripts\studentwise_attendance.py';

$command = "python $path $roll_number $from_date $to_date";
$output = shell_exec($command);
$data_file = 'attendance_data.json';
$attendance_data = [];

if (file_exists($data_file)) {
  $json = file_get_contents($data_file);
  $attendance_data = json_decode($json, true);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Attendance Report</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      margin: 0;
      padding: 20px;
    }

    .container {
      max-width: 1000px;
      margin: 0 auto;
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 25px;
    }

    th,
    td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: center;
    }

    th {
      background-color: #e0e0e0;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2>Attendance Report for <?php echo htmlspecialchars($roll_number); ?></h2>
    <p style="text-align:center;">
      From: <strong><?php echo htmlspecialchars($from_date); ?></strong> to
      <strong><?php echo htmlspecialchars($to_date); ?></strong>
    </p>

    <?php if (!empty($attendance_data)): ?>
      <table>
        <thead>
          <tr>
            <th>Date</th>
            <th>Period</th>
            <th>Subject</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($attendance_data as $entry): ?>
            <tr>
              <td><?php echo htmlspecialchars($entry['date']); ?></td>
              <td><?php echo htmlspecialchars($entry['period']); ?></td>
              <td><?php echo htmlspecialchars($entry['subject']); ?></td>
              <td><?php echo htmlspecialchars($entry['status']); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p style="text-align: center; color: red;">No attendance data found.</p>
    <?php endif; ?>
  </div>
</body>

</html>