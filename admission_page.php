<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Sanitize and store inputs
	$name = htmlspecialchars($_POST['your_name']);
	$email = htmlspecialchars($_POST['email_address']);
	$phone = htmlspecialchars($_POST['phone']);
	$gender = htmlspecialchars($_POST['gender']);
	$dob = htmlspecialchars($_POST['dob']);
	$course = htmlspecialchars($_POST['course']);
	$password = htmlspecialchars($_POST['password']);
	$confirm_password = htmlspecialchars($_POST['confirm_password']);

	// Handle file upload
	if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
		$fileTmpPath = $_FILES['file']['tmp_name'];
		$fileName = $_FILES['file']['name'];
		$fileSize = $_FILES['file']['size'];
		$fileType = $_FILES['file']['type'];
		$fileNameCmps = explode(".", $fileName);
		$fileExtension = strtolower(end($fileNameCmps));

		// Set upload directory and save
		$uploadFileDir = './uploads/';
		$dest_path = $uploadFileDir . $fileName;

		if (!is_dir($uploadFileDir)) {
			mkdir($uploadFileDir, 0777, true);
		}

		if (move_uploaded_file($fileTmpPath, $dest_path)) {
			$fileUploadMessage = "File is successfully uploaded.";
		} else {
			$fileUploadMessage = "There was an error uploading the file.";
		}
	} else {
		$fileUploadMessage = "No file uploaded or upload error.";
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Admission form- VITS</title>
	<link rel="shortcut icon" href="images/vignan_logo.png" />
	<link rel="stylesheet" href="css/admission_style.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
	<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
</head>

<body>
	<section class="header">
		<nav>
			<a href="index.html"><img src="images/vignan_logo.png" id="logo-img" /></a>
			<h1 style="color: white; font-size: 26px; ">Vignan Institute Of Technology and Science</h1>
			<div class="nav-links" id="navLinks">
				<span class="icon" onclick="hidemenu()">&#10005;</span>
				<ul>
					<li><a href="index.html">Home</a></li>
					<li><a href="admission_page.php">Admission</a></li>
					<li><a href="index.html#course_call">Course</a></li>
					<li><a href="Contact_page.html">Contact</a></li>
				</ul>
			</div>
			<span class="icon" onclick="showmenu()">&#9776;</span>
		</nav>

		<div class="wrapper">
			<div class="r_form_wrap">
				<div class="title">
					<p>Admission form</p>
				</div>

				<!-- Admission from -->
				<div class="r_form">
					<form method="post" action="admission_page.php">
						<div class="input_wrap">
							<label for="yourname">Your Name</label>
							<div class="input_item">
								<i class="fa fa-user" id="icon"></i>
								<input type="text" name="your name" class="input" id="name" placeholder="Enter the name"
									required />
							</div>
						</div>
						<div class="input_wrap">
							<label for="emailaddress">Email Address</label>
							<div class="input_item">
								<i class="fa fa-envelope" id="icon"></i>
								<input type="text" name="email address" class="input" id="email"
									placeholder="Enter the Email ID" required />
							</div>
						</div>

						<div class="input_wrap">
							<label for="phone">Phone</label>
							<div class="input_item">
								<i class="fa fa-phone-square" id="icon"></i>
								<input type="number" name="phone" class="input" id="phone"
									placeholder="Enter the Mobile number" required />
							</div>
						</div>
						<div class="input_wrap">
							<label>Gender</label>
							<div class="input_radio">
								<div class="input_radio_item">
									<input type="radio" id="male" name="gender" class="radio" value="male" checked />
									<label for="male" class="radio_mark">
										<ion-icon class="i" name="male-sharp"></ion-icon>
										Male</label>
								</div>
								<div class="input_radio_item">
									<input type="radio" id="female" name="gender" class="radio" value="female" />
									<label for="female" class="radio_mark">
										<ion-icon class="i" name="female-sharp"></ion-icon>
										Female</label>
								</div>
							</div>
						</div>

						<div class="input_wrap">
							<label for="dob">Date Of Birth</label>
							<div class="input_item">
								<i class="fa fa-calendar" id="icon"></i>
								<input type="date" name="dob" class="input" id="dob" required />
							</div>
						</div>

						<div class="input_wrap">
							<label for="course">Course</label>
							<div class="input_item">
								<i class="fa fa-caret-square-o-down" aria-hidden="true" id="icon"></i>
								<select id="course" name="cars" class="input" required>
									<option value="select">
										Select the Course
									</option>
									<option value="bca">BCA</option>
									<option value="bscit">Bsc IT</option>
									<option value="bscca&it">
										Bsc CA & IT
									</option>
								</select>
							</div>
						</div>

						<div class="input_wrap">
							<label for="file">12th Marksheet</label>
							<div class="input_item">
								<i class="fa fa-file" id="icon"></i>
								<input type="file" name="file" class="input" id="file" required />
							</div>
						</div>

						<div class="input_wrap">
							<label for="password">Password</label>
							<div class="input_item">
								<i class="fa fa-key" id="icon"></i>
								<input type="password" name="password" class="input" id="password"
									placeholder="Enter the password" />
							</div>
						</div>
						<div class="input_wrap">
							<label for="confirmpassword">Confirm Password</label>
							<div class="input_item">
								<i class="fa fa-check-circle" id="icon"></i>
								<input type="password" name="confirm password" class="input" id="confirmpassword"
									placeholder="Enter the confirm password" />
							</div>
						</div>

						<input type="submit" class="button" id="register" value="Register Now" />

						<div></div>
						<input type="reset" class="clear_ad" value="Clear" />
					</form>
				</div>
			</div>
		</div>
	</section>
	<div class="none_div"></div>
</body>
<script>
	var navLinks = document.getElementById("navLinks");

	function showmenu() {
		navLinks.style.right = "0";
	}
	function hidemenu() {
		navLinks.style.right = "-200px";
	}
</script>

</html>