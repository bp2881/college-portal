<?php
session_start();

$error = "";
$show_otp = false;
$msg = "";

// Contains DB info
require_once 'config.php';
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$TABLE_NAME = 'student_login';

if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    die("An error occurred. Please try again later.");
}


function store_session($conn, $email, $roll_num)
{
    // Fetching name
    $stmt = $conn->prepare("SELECT Name FROM student_login WHERE email=?");
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        return;
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $name = $row['Name'] ?? '';

    // Fetching Attendance
    $stmt = $conn->prepare("SELECT attendance FROM student_attendance WHERE roll_num=?");
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        return;
    }
    $stmt->bind_param("s", $roll_num);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $attendance = $row['attendance'] ?? '';

    $new_entry = [
        'name' => $name,
        'roll_num' => $roll_num,
        'email' => $email,
        'attendance' => $attendance,
        'date' => date('d-m-Y'),
        'timestamp' => date('d-m-Y H:i:s'),
        'logged' => time(),
    ];

    $file = 'session.json';
    $data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    $data[] = $new_entry;
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}

function fetch_attendance($conn, $TABLE_NAME, $email)
{
    $fdt = '20-01-2025';
    $tdt = date("d-m-Y");

    // Get roll number
    $stmt = $conn->prepare("SELECT roll_num FROM $TABLE_NAME WHERE email = ?");
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        return null;
    }

    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return null;
    }

    $row = $result->fetch_assoc();
    $roll = $row['roll_num'];

    $pythonPath = "C:\\Users\\Pranav\\AppData\\Local\\Programs\\Python\\Python313\\python.exe";
    $pythonScript = "C:\\xampp\\htdocs\\college-portal\\scripts\\studentwise_attendance.py";
    $command = "$pythonPath $pythonScript 2>&1 $roll $fdt $tdt";

    $output = shell_exec($command);
    store_session($conn, $email, $roll);

    return $output;
}

function send_otp($email)
{
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $pythonPath = "C:\\Users\\Pranav\\AppData\\Local\\Programs\\Python\\Python313\\python.exe";
    $pythonScript = "C:\\xampp\\htdocs\\college-portal\\scripts\\send_otp.py";
    $command = "$pythonPath $pythonScript 2>&1 $otp $email";
    $output = shell_exec($command);

    if ($output === null) {
        error_log("Error executing Python script for OTP.");
    }

    return $output;
}

function check_otp($conn, $TABLE_NAME)
{
    global $error, $show_otp;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_otp'])) {
        $ent_otp = trim($_POST["otp"]);

        if ($ent_otp === "") {
            $error = "Please enter OTP.";
        } elseif (!isset($_SESSION['otp'])) {
            $error = "Session expired. Please login again.";
        } elseif ($ent_otp == $_SESSION['otp']) {
            $_SESSION['otp_verified'] = true;

            // Fetch attendance
            $output = fetch_attendance($conn, $TABLE_NAME, $_SESSION['email']);

            header("Location: student_dashboard.php");
            exit;
        } else {
            $error = "Incorrect OTP.";
        }

        $show_otp = true;
    }
}

if (isset($_POST['verify_otp'])) {
    check_otp($conn, $TABLE_NAME);
}

if (isset($_POST['resend_otp'])) {
    if (!empty($_SESSION['email'])) {
        $msg = send_otp($_SESSION['email']);
        $show_otp = true;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['verify_otp']) && !isset($_POST['resend_otp'])) {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['pass'] ?? '');

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

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password'])) {
                session_regenerate_id(true);
                $_SESSION['email'] = $email;
                $_SESSION['logged_in'] = true;
                $_SESSION['login_time'] = time();
                $msg = send_otp($email);
                $show_otp = true;
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "Student not found.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <title>Student Login</title>
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .error {
            color: #d32f2f;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        .otp-form {
            display: none;
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
            color: var(--primary);
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <form class="form-box" action="student_login.php" method="post">
            <h2>Welcome Back</h2>
            <?php if ($error) { ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php } ?>
            <input type="text" placeholder="Email" name="email" required>
            <input type="password" placeholder="Password" name="pass" required>
            <button type="submit">Login</button>
        </form>

        <form class="otp-form" action="student_login.php" method="post"
            style="<?php echo $show_otp ? 'display:block' : 'display:none'; ?>">
            <h2>OTP Verification</h2>
            <input type="text" placeholder="Enter OTP" name="otp" required>
            <button type="submit" name="verify_otp">Verify OTP</button>
            <button type="submit" name="resend_otp">Resend OTP</button>
        </form>
    </div>
</body>

</html>