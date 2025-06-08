<?php
session_start();
require_once 'config.php';

$error = "";
$msg = "";
$show_otp = false;

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$TABLE_NAME = "students";

if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    die("An error occurred. Please try again later.");
}


function store_session($conn, $email, $roll_num)
{
    $stmt = $conn->prepare("SELECT attendance FROM student_attendance WHERE roll_num=?");
    $attendance = '';
    if ($stmt) {
        $stmt->bind_param("s", $roll_num);
        $stmt->execute();
        $result = $stmt->get_result();
        $attendance = $result->fetch_assoc()['attendance'] ?? '';
        $stmt->close();
    } else {
        error_log("Failed to prepare statement for attendance fetch: " . $conn->error);
    }

    $stmt = $conn->prepare("SELECT name, address, contact, dob, year, branch FROM students WHERE roll_num=?");
    $name = "";
    $address = '';
    $contact = '';
    $dob = '';
    $year = null;
    $branch = "";
    if ($stmt) {
        $stmt->bind_param("s", $roll_num);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($row) {
            $name = $row["Name"] ?? '';
            $address = $row['address'] ?? '';
            $contact = $row['contact'] ?? '';
            $dob = $row['dob'] ?? '';
            $year = $row['year'] ?? null;
            $branch = $row['branch'] ?? '';
        }
        $stmt->close();
    } else {
        error_log("Failed to prepare statement for fetching student details: " . $conn->error);
    }

    // Fetching attendance data
    $jsonFile = "C:\\xampp\\htdocs\\college-portal\\attendance_data.json";

    // Check if file exists before attempting to read
    if (!file_exists($jsonFile)) {
        error_log("Attendance data file not found: $jsonFile");
        $attendanceDetails = [];  // Empty array if file doesn't exist
    } else {
        $jsonContent = file_get_contents($jsonFile);

        // Check if file content is valid
        if ($jsonContent === false) {
            error_log("Failed to read attendance data file: $jsonFile");
            $attendanceDetails = [];  // Empty array if file can't be read
        } else {
            $data = json_decode($jsonContent, true);

            // Check if data was successfully decoded and has the expected structure
            if ($data === null) {
                error_log("Failed to decode JSON from attendance data file");
                $attendanceDetails = [];  // Empty array if JSON is invalid
            } else {
                $attendanceDetails = [];

                // Check if tables key exists and is an array
                if (isset($data['tables']) && is_array($data['tables']) && isset($data['tables'][1]) && is_array($data['tables'][1])) {
                    // Skip the header row (index 0) and only process actual subject data
                    for ($i = 1; $i < count($data['tables'][1]); $i++) {
                        $subject = $data['tables'][1][$i];
                        // Make sure the subject data is complete
                        if (isset($subject[0]) && isset($subject[1]) && isset($subject[2]) && isset($subject[3])) {
                            $attendanceDetails[] = [
                                'subject' => $subject[0],
                                'classes_held' => $subject[1],
                                'classes_attended' => $subject[2],
                                'percentage' => $subject[3]
                            ];
                        }
                    }
                } else {
                    error_log("Attendance data file does not have the expected structure");
                }
            }
        }
    }

    $new_entry = [
        'name' => $name,
        'roll_num' => $roll_num,
        'email' => $email,
        'year' => $year,
        'branch' => $branch,
        'attendance' => $attendance,
        'subjects' => $attendanceDetails,
        'date' => date('d-m-Y'),
        'timestamp' => date('d-m-Y H:i:s'),
        'logged' => time(),
        'address' => $address,
        'contact' => $contact,
        'dob' => $dob
    ];

    $result = file_put_contents('C:\\xampp\\htdocs\\college-portal\\student\\session.json', json_encode($new_entry, JSON_PRETTY_PRINT));
    if ($result === false) {
        error_log("Failed to write session data to session.json. Check file permissions and path.");
    } else {
        error_log("Session data successfully written to session.json: " . json_encode($new_entry));
    }
}
function fetch_attendance($conn, $TABLE_NAME, $email)
{
    $fdt = '20-01-2025';
    $tdt = date("d-m-Y");

    $stmt = $conn->prepare("SELECT roll_num FROM $TABLE_NAME WHERE email = ?");
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        return null;
    }

    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $roll = $result->fetch_assoc()['roll_num'] ?? null;
    $stmt->close();

    if (!$roll) {
        error_log("No roll number found for email: $email");
        store_session($conn, $email, null);
        return null;
    }

    $pythonPath = "C:\\Users\\Pranav\\AppData\\Local\\Programs\\Python\\Python313\\python.exe";
    $pythonScript = "../scripts/studentwise_attendance.py";
    $command = escapeshellcmd("$pythonPath $pythonScript $roll $fdt $tdt true");

    $output = shell_exec($command);
    if ($output === null) {
        error_log("Failed to execute attendance script for roll: $roll");
    } else {
        error_log("Attendance script executed for roll: $roll, output: $output");
    }

    store_session($conn, $email, $roll);
    return $output;
}

function send_otp($email)
{
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;

    error_log("Generated OTP for $email: $otp");

    $pythonPath = "C:\\Users\\Pranav\\AppData\\Local\\Programs\\Python\\Python313\\python.exe";
    $pythonScript = "../scripts/send_otp.py";
    $command = escapeshellcmd("$pythonPath $pythonScript $otp \"$email\" ");

    error_log("Executing command: $command");

    $output = shell_exec($command);
    if ($output === null || strpos($output, "error") !== false || strpos($output, "Error") !== false) {
        error_log("Error executing Python script for OTP sending for email: $email, output: " . ($output ?: 'No output'));
        return "Failed to send OTP. Please try again or check server logs.";
    } else {
        error_log("OTP script executed for email: $email, output: " . ($output ?: 'No output'));
        return "OTP sent successfully.";
    }
}

function check_otp($conn, $TABLE_NAME)
{
    global $error, $show_otp;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_otp'])) {
        $ent_otp = trim($_POST["otp"]);

        if (empty($ent_otp)) {
            $error = "Please enter OTP.";
        } elseif (!isset($_SESSION['otp'])) {
            $error = "Session expired. Please login again.";
            error_log("Session expired: OTP not found in session.");
        } elseif (!isset($_SESSION['email'])) {
            $error = "Session expired. Email not found. Please login again.";
            error_log("Session expired: Email not found in session.");
        } elseif ($ent_otp == $_SESSION['otp']) {
            $_SESSION['otp_verified'] = true;
            error_log("OTP verified successfully for email: " . $_SESSION['email']);
            fetch_attendance($conn, $TABLE_NAME, $_SESSION['email']);
            header("Location: ./Student-Dashboard/");
            exit;
        } else {
            $error = "Incorrect OTP.";
            error_log("Incorrect OTP entered: $ent_otp, expected: " . $_SESSION['otp']);
        }

        $show_otp = true;
    }
}

// === MAIN ===

if (isset($_POST['verify_otp'])) {
    check_otp($conn, $TABLE_NAME);
} elseif (isset($_POST['resend_otp']) && !empty($_SESSION['email'])) {
    $msg = send_otp($_SESSION['email']);
    $show_otp = true;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $error = "Email and password are required.";
    } else {
        $stmt = $conn->prepare("SELECT password FROM $TABLE_NAME WHERE email = ?");
        if (!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            die("An error occurred. Please try again later.");
        }

        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if ($row && (password_verify($password, $row['password']))) {
            session_regenerate_id(true);
            $_SESSION['email'] = $email;
            $_SESSION['logged_in'] = true;
            $_SESSION['login_time'] = time();
            $msg = send_otp($email);
            if (strpos($msg, "Failed") !== false) {
                $error = $msg;
            } else {
                $msg = "OTP sent to your email.";
            }
            $show_otp = true;
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Student Login</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: white;
        }

        .top-line {
            height: 3px;
            background-color: #2d0aa2;
            width: 100%;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 30px;
        }

        .logo-section {
            display: flex;
            align-items: center;
        }

        .logo-section img {
            height: 55px;
            margin-right: 10px;
        }

        .logo-section h1 {
            margin: 0;
            color: #2d0aa2;
            font-weight: 700;
        }

        .logo-section hr {
            margin-left: 0;
            margin-right: 30%;
            height: 3px;
            background-color: #2d0aa2;
            margin-top: 0;
            margin-bottom: 5px;
            border: none;
        }

        .logo-section p {
            margin: 0;
            color: #666;
            font-size: 13px;
        }

        .nav-links {
            display: flex;
            gap: 40px;
        }

        .nav-links a {
            color: #2d0aa2;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px;
            padding-bottom: 3px;
            position: relative;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #2d0aa2;
            display: none;
        }

        .nav-links a:last-child::after {
            display: block;
        }

        .content-wrapper {
            display: flex;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .image-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-section {
            flex: 1;
            padding: 20px;
        }

        .login-header h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }

        .login-header p {
            color: #666;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        .form-control {
            width: 100%;
            padding: 15px;
            border: none;
            background-color: #f0f5fa;
            border-radius: 5px;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background-color: #6c63ff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .error {
            color: #d32f2f;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        .otp-form {
            display: none;
        }

        .success {
            color: #28a745;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="top-line"></div>

    <div class="header-container">
        <div class="logo-section">
            <img src="images/vignan_logo.png" alt="Vignan Logo" />
            <div>
                <h1>VIGNAN</h1>
                <hr />
                <p>INSTITUTE OF TECHNOLOGY AND SCIENCE</p>
            </div>
        </div>
        <div class="nav-links">
            <a href="./">Back</a>
            <a href="student_login.php">Student Login</a>
        </div>
    </div>

    <div class="content-wrapper">
        <div class="image-section">
            <img src="images/undraw_remotely_2j6y.svg" alt="Student" style="max-width: 100%;">
        </div>

        <div class="form-section">
            <div class="login-header">
                <h2>Student Sign In</h2>
                <p>Welcome back! Please login to access your student dashboard.</p>
                <?php if ($error) { ?>
                    <p class="error"><?php echo htmlspecialchars($error); ?></p>
                <?php } ?>
                <?php if ($msg && strpos($msg, "Failed") === false) { ?>
                    <p class="success"><?php echo htmlspecialchars($msg); ?></p>
                <?php } ?>
            </div>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                style="<?php echo $show_otp ? 'display:none' : 'display:block'; ?>">

                <div class="form-group">
                    <label for="username">Email</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>

                <div class="form-group" style="margin-top: 25px;">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <button type="submit" class="btn-login">Log In</button>
            </form>

            <form class="otp-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                style="<?php echo $show_otp ? 'display:block' : 'display:none'; ?>">
                <div class="login-header">
                    <h2>OTP Verification</h2>
                    <p>Please enter the OTP sent to your email</p>
                </div>

                <div class="form-group">
                    <label for="otp">Enter OTP</label>
                    <input type="text" class="form-control" id="otp" name="otp" required>
                </div>

                <div style="display: flex; gap: 15px; margin-top: 20px;">
                    <button type="submit" name="verify_otp" class="btn-login" style="flex: 1;">Verify OTP</button>
                    <button type="submit" name="resend_otp" class="btn-login"
                        style="flex: 1; background-color: #8b86fb;" formnovalidate>
                        Resend OTP
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>