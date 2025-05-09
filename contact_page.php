<?php
session_start();
function send_message($name, $email, $message)
{
	$pythonPath = "C:\\Users\\Pranav\\AppData\\Local\\Programs\\Python\\Python313\\python.exe";
	$pythonScript = "C:\\xampp\\htdocs\\college-portal\\scripts\\send_otp.py";
	$command = escapeshellcmd("$pythonPath $pythonScript \"$message\" \"$email\" \"$name\" 2>&1");
	error_log("Executing command: $command");
	$output = shell_exec($command);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["message"])) {
		$name = $_POST["name"];
		$email = $_POST["email"];
		$messsage = $_POST["message"];
		send_message($name, $email, $messsage);
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Contact Us - VGNT</title>
	<link rel="shortcut icon" href="images/vignan_logo.png" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
	<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
	<link rel="stylesheet" href="css/contact_style.css" />
</head>

<body>
	<section class="header">
		<nav>
			<a href="index.html"><img src="images/vignan_logo.png" id="logo-img" /></a>
			<h1 style="color: white; font-size: 26px">
				Vignan Institute Of Technology & Science
			</h1>

			<div class="nav-links" id="navLinks">
				<ul>
					<li><a href="index.html">Home</a></li>
					<li><a href="admission_page.php">Admission</a></li>
					<li><a href="index.html#course_call">Course</a></li>
					<li><a href="Contact_page.html">Contact</a></li>
				</ul>
			</div>
		</nav>
		<div class="wrapper">
			<div class="r_form_wrap">
				<div class="title">
					<p>Contact form</p>
				</div>

				<!-- Admission from -->
				<div class="r_form">
					<form method="post" action="Contact_page.php">
						<div class="input_wrap">
							<label for="name">Your Name</label>
							<div class="input_item">
								<i class="fa fa-user" id="icon"></i>
								<input type="text" name="name" class="input" id="name" placeholder="Enter your name"
									required />
							</div>
						</div>
						<div class="input_wrap">
							<label for="email">Email Address</label>
							<div class="input_item">
								<i class="fa fa-envelope" id="icon"></i>
								<input type="email" name="email" class="input" id="email" placeholder="Enter your email"
									required />
							</div>
						</div>

						<div class="input_wrap">
							<label for="message">Your query</label>
							<div class="input_item">
								<i class="fa fa-commenting" id="icon"></i>
								<textarea name="message" class="mess" id="message" placeholder="Write your message..."
									size="500"></textarea>
							</div>
						</div>

						<input type="submit" class="button" value="Send Message" />
						<div></div>
						<input type="reset" class="clear_ad" value="Clear" />
					</form>
				</div>
			</div>
		</div>
	</section>
</body>

</html>