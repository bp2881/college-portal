<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
	header("Location: student_login.php");
	exit;
}

$jsonFile = "C:\\xampp\\htdocs\\college-portal\\attendance_data.json";
$attendance = null;
$error = '';

if (file_exists($jsonFile)) {
	$json = file_get_contents($jsonFile);
	$data = json_decode($json, true);
	if (json_last_error() === JSON_ERROR_NONE) {
		$attendance = htmlspecialchars($data['average_attendance_percentage']);
		unlink($jsonFile);
	} else {
		$error = "Error decoding JSON: " . json_last_error_msg();
	}
} else {
	header("Location: student_login.php");
	$error = "JSON file not found.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Student Dashboard</title>
</head>

<body>

	<?php if ($error): ?>
		<p style="color: red;"><?php echo $error; ?></p>
	<?php elseif ($attendance !== null): ?>
		<h1>The attendance is <?php echo $attendance; ?>%</h1>
	<?php else: ?>
		<p>Attendance data is not available at the moment.</p>
	<?php endif; ?>

</body>

</html>