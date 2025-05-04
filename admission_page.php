<?php
session_start();

require_once("config.php");

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
	die("Database connection failed: " . $conn->connect_error);
}

$errors = [];
$successMessage = '';
$fileUploadMessage = '';

if (isset($_SESSION['success_message'])) {
	$successMessage = $_SESSION['success_message'];
	unset($_SESSION['success_message']); // Clear the message after displaying
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
	$email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
	$phone = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
	$gender = isset($_POST['gender']) ? htmlspecialchars($_POST['gender']) : '';
	$dob = isset($_POST['dob']) ? htmlspecialchars($_POST['dob']) : '';
	$course = isset($_POST['course']) ? htmlspecialchars($_POST['course']) : '';
	$password = isset($_POST['password']) ? $_POST['password'] : '';
	$confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

	if (empty($name) || empty($email) || empty($phone) || empty($gender) || empty($dob) || empty($course)) {
		$errors[] = "All fields are required.";
	}

	if ($password !== $confirm_password) {
		$errors[] = "Passwords do not match.";
	}

	$tempFilePath = '';
	$filePath = '';
	if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
		$fileTmpPath = $_FILES['file']['tmp_name'];
		$fileName = $_FILES['file']['name'];
		$fileSize = $_FILES['file']['size'];
		$fileNameCmps = explode(".", $fileName);
		$fileExtension = strtolower(end($fileNameCmps));

		// Allowed file extensions and size limit (5MB)
		$allowedExts = ['pdf', 'jpg', 'jpeg', 'png'];
		$maxFileSize = 5 * 1024 * 1024;

		if (!in_array($fileExtension, $allowedExts)) {
			$errors[] = "Invalid file type. Only PDF, JPG, JPEG, and PNG are allowed.";
		} elseif ($fileSize > $maxFileSize) {
			$errors[] = "File size exceeds 5MB limit.";
		} else {
			$uploadFileDir = './Uploads/';
			$tempFilePath = $uploadFileDir . uniqid() . '_' . $fileName;

			if (!is_dir($uploadFileDir)) {
				mkdir($uploadFileDir, 0777, true);
			}

			if (!move_uploaded_file($fileTmpPath, $tempFilePath)) {
				$errors[] = "Error uploading the file.";
			}
		}
	} else {
		$errors[] = "No file uploaded or upload error.";
	}

	// Check for duplicate email before insertion
	if (empty($errors)) {
		$checkSql = "SELECT COUNT(*) FROM registration WHERE email = ?";
		$checkStmt = $conn->prepare($checkSql);
		$checkStmt->bind_param("s", $email);
		$checkStmt->execute();
		$checkStmt->bind_result($emailCount);
		$checkStmt->fetch();
		$checkStmt->close();

		if ($emailCount > 0) {
			$errors[] = "This email address is already registered. Please use a different email.";
		}
	}

	if (empty($errors)) {
		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
		$sql = "INSERT INTO registration (name, email, phone, gender, dob, course, approved, password) VALUES (?, ?, ?, ?, ?, ?, 'no', ?)";
		$stmt = $conn->prepare($sql);
		if (!$stmt) {
			$errors[] = "Database prepare error: " . $conn->error;
		} else {
			$stmt->bind_param("sssssss", $name, $email, $phone, $gender, $dob, $course, $hashedPassword);
			if ($stmt->execute()) {
				$application_no = $conn->insert_id;
				$fileNameCmps = explode(".", $fileName);
				$fileExtension = strtolower(end($fileNameCmps));
				$newFileName = "application_{$application_no}.{$fileExtension}";
				$filePath = $uploadFileDir . $newFileName;

				if (rename($tempFilePath, $filePath)) {
					$fileUploadMessage = "File successfully uploaded as $newFileName.";
				} else {
					$errors[] = "Error renaming the uploaded file.";
				}

				$_SESSION['success_message'] = "Form submitted successfully! Your application number is $application_no.";
				header("Location: admission_page.php");
				exit();
			} else {
				$errors[] = "Database insert error: " . $stmt->error;
			}
			$stmt->close();
		}
	}
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Admission form - VITS</title>
	<link rel="shortcut icon" href="images/vignan_logo.png" />
	<link rel="stylesheet" href="css/admission_style.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
	<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
</head>

<body>
	<section class="header">
		<nav>
			<a href="index.html"><img src="images/vignan_logo.png" id="logo-img" /></a>
			<h1 style="color: white; font-size: 26px;">Vignan Institute Of Technology and Science</h1>
			<div class="nav-links" id="navLinks">
				<span class="icon" onclick="hidemenu()">✕</span>
				<ul>
					<li><a href="index.html">Home</a></li>
					<li><a href="admission_page.php">Admission</a></li>
					<li><a href="index.html#course_call">Course</a></li>
					<li><a href="Contact_page.html">Contact</a></li>
				</ul>
			</div>
			<span class="icon" onclick="showmenu()">☰</span>
		</nav>
		<?php if (!empty($successMessage)): ?>
			<div style="color: green; text-align: center; margin-bottom: 20px;"><?php echo $successMessage; ?></div>
		<?php endif; ?>
		<?php if (!empty($errors)): ?>
			<div style="color: red; text-align: center; margin-bottom: 20px;">
				<?php foreach ($errors as $error): ?>
					<p><?php echo $error; ?></p>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<?php if (!empty($fileUploadMessage)): ?>
			<div
				style="color: <?php echo strpos($fileUploadMessage, 'success') !== false ? 'green' : 'red'; ?>; text-align: center; margin-bottom: 20px;">
				<?php echo $fileUploadMessage; ?>
			</div>
		<?php endif; ?>

		<div class="wrapper">
			<!-- Feedback messages -->


			<div class="r_form_wrap">
				<div class="title">
					<p>Admission form</p>
				</div>
				<div class="r_form">
					<form method="post" action="admission_page.php" enctype="multipart/form-data">
						<div class="input_wrap">
							<label for="name">Your Name</label>
							<div class="input_item">
								<i class="fa fa-user" id="icon"></i>
								<input type="text" name="name" class="input" id="name" placeholder="Enter the name"
									value="<?php echo isset($name) ? $name : ''; ?>" required />
							</div>
						</div>
						<div class="input_wrap">
							<label for="email">Email Address</label>
							<div class="input_item">
								<i class="fa fa-envelope" id="icon"></i>
								<input type="email" name="email" class="input" id="email"
									placeholder="Enter the Email ID" value="<?php echo isset($email) ? $email : ''; ?>"
									required />
							</div>
						</div>
						<div class="input_wrap">
							<label for="phone">Phone</label>
							<div class="input_item">
								<i class="fa fa-phone-square" id="icon"></i>
								<input type="tel" name="phone" class="input" id="phone"
									placeholder="Enter the Mobile number"
									value="<?php echo isset($phone) ? $phone : ''; ?>" required />
							</div>
						</div>
						<div class="input_wrap">
							<label>Gender</label>
							<div class="input_radio">
								<div class="input_radio_item">
									<input type="radio" id="male" name="gender" class="radio" value="male" <?php echo (isset($gender) && $gender === 'male') || !isset($gender) ? 'checked' : ''; ?> />
									<label for="male" class="radio_mark">
										<ion-icon class="i" name="male-sharp"></ion-icon>
										Male
									</label>
								</div>
								<div class="input_radio_item">
									<input type="radio" id="female" name="gender" class="radio" value="female" <?php echo (isset($gender) && $gender === 'female') ? 'checked' : ''; ?> />
									<label for="female" class="radio_mark">
										<ion-icon class="i" name="female-sharp"></ion-icon>
										Female
									</label>
								</div>
							</div>
						</div>
						<div class="input_wrap">
							<label for="dob">Date Of Birth</label>
							<div class="input_item">
								<i class="fa fa-calendar" id="icon"></i>
								<input type="date" name="dob" class="input" id="dob"
									value="<?php echo isset($dob) ? $dob : ''; ?>" required />
							</div>
						</div>
						<div class="input_wrap">
							<label for="course">Course</label>
							<div class="input_item">
								<i class="fa fa-caret-square-o-down" aria-hidden="true" id="icon"></i>
								<select id="course" name="course" class="input" required>
									<option value="">Select the Course</option>
									<option value="bca" <?php echo (isset($course) && $course === 'bca') ? 'selected' : ''; ?>>BCA</option>
									<option value="bscit" <?php echo (isset($course) && $course === 'bscit') ? 'selected' : ''; ?>>Bsc IT</option>
									<option value="bscca&it" <?php echo (isset($course) && $course === 'bscca&it') ? 'selected' : ''; ?>>Bsc CA & IT</option>
								</select>
							</div>
						</div>
						<div class="input_wrap">
							<label for="file">12th Marksheet</label>
							<div class="input_item">
								<i class="fa fa-file" id="icon"></i>
								<input type="file" name="file" class="input" id="file" accept=".pdf,.jpg,.jpeg,.png"
									required />
							</div>
						</div>
						<div class="input_wrap">
							<label for="password">Password</label>
							<div class="input_item">
								<i class="fa fa-key" id="icon"></i>
								<input type="password" name="password" class="input" id="password"
									placeholder="Enter the password" required />
							</div>
						</div>
						<div class="input_wrap">
							<label for="confirm_password">Confirm Password</label>
							<div class="input_item">
								<i class="fa fa-check-circle" id="icon"></i>
								<input type="password" name="confirm_password" class="input" id="confirm_password"
									placeholder="Enter the confirm password" required />
							</div>
						</div>
						<input type="submit" class="button" id="register" value="Register Now" />
						<input type="reset" class="clear_ad" value="Clear" />
					</form>
				</div>
			</div>
		</div>
	</section>
	<div class="none_div"></div>

	<script>
		var navLinks = document.getElementById("navLinks");
		function showmenu() {
			navLinks.style.right = "0";
		}
		function hidemenu() {
			navLinks.style.right = "-200px";
		}
	</script>
</body>

</html>