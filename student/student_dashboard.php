<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
	header("Location: student_login.php");
	exit;
}

$jsonFile = "C:\\xampp\\htdocs\\college-portal\\student\\session.json";
$attendance = null;
$name = null;
$roll_number = null;
$error = '';

if (file_exists($jsonFile)) {
	$json = file_get_contents($jsonFile);
	$data = json_decode($json, true);
	if (json_last_error() === JSON_ERROR_NONE) {
		$logged_in = $data['logged'];
		if ((time() - $logged_in) > 1800) {
			unlink($jsonFile);
			header("Location: student_login.php");
		}
		$attendance = htmlspecialchars($data['attendance']);
		$name = htmlspecialchars($data['name']);
		$roll_number = htmlspecialchars($data['roll_num']);
	} else {
		$error = "Error decoding JSON: " . json_last_error_msg();
	}
} else {
	header("Location: C:\\xampp\\htdocs\\college-portal\\student\\student_login.php");
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
	<?php else: ?>
		<h1>Welcome <?php echo $name; ?> (<?php echo $roll_number; ?>) </h1>
		<b>The attendance is <?php echo $attendance; ?>%</b>
	<?php endif; ?>

	<a href="logout.php">Logout</a>

</body>

</html>