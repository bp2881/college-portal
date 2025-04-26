<?php
$roll = isset($_GET['roll_number']) ? filter_var($_GET['roll_number'], FILTER_SANITIZE_STRING) : '';
$fdt = isset($_GET['from_date']) ? filter_var($_GET['from_date'], FILTER_SANITIZE_STRING) : '';
$tdt = isset($_GET['to_date']) ? filter_var($_GET['to_date'], FILTER_SANITIZE_STRING) : '';

$pythonScript = "C:\\xampp\\htdocs\\college-portal\\scripts\\studentwise_attendance.py";
$command = "python $pythonScript $roll $fdt $tdt attendance";
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
// Delete json file
unlink($jsonFile);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Student‑wise Attendance Report</title>
</head>

<body style="font-family: Arial, sans-serif; background: #f0f4f8; margin: 0; padding: 20px;">

  <!-- College Header -->
  <div
    style="position: relative; text-align: center; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
    <img src="./images/vignan_logo.png" alt="College Logo" width="80">
    <h1 style="color: #d62828; margin: 10px 0;">VIGNAN INSTITUTE OF TECHNOLOGY AND SCIENCE</h1>
    <p style="margin: 5px 0;">Near Ramoji Film City, Deshmukhi Village, Pochampally Mandal, Yadadri Bhuvanagiri Dist.
    </p>
    <p style="color: #023047; font-weight: bold; margin: 5px 0;">(Approved by AICTE, New Delhi, Affiliated to JNTUH,
      Hyderabad)</p>
    <h3 style="color: #d62828; margin: 5px 0;">AN AUTONOMOUS INSTITUTION</h3>

    <div
      style="position: absolute; top: 20px; right: 30px; border: 2px solid #888; padding: 10px; font-weight: bold; border-radius: 5px; background: #fefefe; font-size: 0.9rem;">
      <p style="margin: 0; line-height: 1.2;">
        Eamcet Code<br>
        <span style="color: #d62828;">VGNT</span><br>
        Dist Code: <span style="color: #1d3557;">YBG</span>
      </p>
    </div>
  </div>

  <!-- Report Title & Dates -->
  <div style="text-align: center; margin-top: 30px;">
    <h2 style="color: #264653; margin: 0;">Vignan Student Attendance Portal</h2>
    <h3 style="margin: 8px 0;">Student Attendance Report – AY 2024‑25 I Sem.</h3>
    <?php if (!empty($data['attendance_dates'])): ?>
      <p style="margin: 4px 0;">
        <strong>From:</strong> <?= htmlspecialchars($data['attendance_dates']['from']) ?>
        <strong>To:</strong> <?= htmlspecialchars($data['attendance_dates']['to']) ?>
      </p>
    <?php endif; ?>
  </div>

  <!-- Attendance Table -->
  <div style="overflow-x: auto; margin-top: 30px;">
    <table border="1" cellspacing="0" cellpadding="5"
      style="width: 100%; border-collapse: collapse; background: white; font-size: 14px; text-align: center;">
      <thead style="background: #e63946; color: white;">
        <tr>
          <th>Roll No.</th>
          <th>Name</th>
          <th>Branch</th>
          <th>From Date</th>
          <th>To Date</th>
          <th>Year</th>
          <th>Section</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($data['tables'][0])): ?>
          <?php foreach ($data['tables'][0] as $row): ?>
            <tr>
              <td><?= htmlspecialchars($row[0]) ?></td>
              <td><?= htmlspecialchars($row[1]) ?></td>
              <td><?= htmlspecialchars($row[2]) ?></td>
              <td><?= htmlspecialchars($row[5]) ?></td>
              <td><?= htmlspecialchars($row[6]) ?></td>
              <td><?= htmlspecialchars($row[3]) ?></td>
              <td><?= htmlspecialchars($row[4]) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="7">No data found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Subject-wise Attendance -->
  <?php if (!empty($data['tables'][1])): ?>
    <div style="margin-top: 30px;">
      <h3 style="text-align: center; color: #264653;">Subject-wise Attendance</h3>
      <table border="1" cellspacing="0" cellpadding="5"
        style="width: 100%; border-collapse: collapse; background: white; font-size: 14px; text-align: center;">
        <thead style="background: #457b9d; color: white;">
          <tr>
            <th>Subject</th>
            <th>Total Classes</th>
            <th>Attended</th>
            <th>Percentage</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($data['tables'][1] as $subject): ?>
            <tr>
              <td><?= htmlspecialchars($subject[0]) ?></td>
              <td><?= htmlspecialchars($subject[1]) ?></td>
              <td><?= htmlspecialchars($subject[2]) ?></td>
              <td><?= htmlspecialchars($subject[3]) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>

  <!-- Overall Attendance -->
  <?php if (!empty($data['average_attendance_percentage'])): ?>
    <p style="text-align: center; font-weight: bold; margin-top: 20px; font-size: 16px;">
      Overall Attendance: <?= htmlspecialchars($data['average_attendance_percentage']) ?>%
    </p>
  <?php endif; ?>

  <!-- HOD & Print -->
  <div style="text-align: center; margin: 40px 0 20px; font-size: 14px; color: #343a40;">
    <p style="margin: 0 0 10px;"><b>HOD</b></p>
    <button onclick="window.print()" style="padding: 8px 20px; font-size: 14px; border: 1px solid #343a40; background: none;
                   border-radius: 5px; cursor: pointer; transition: background 0.3s;">
      Print
    </button>
  </div>

</body>

</html>