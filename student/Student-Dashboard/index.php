<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header("Location: ../student_login.php");
    exit;
}

$jsonFile = "C:\\xampp\\htdocs\\college-portal\\student\\session.json";
$attendance = null;
$name = null;
$roll_number = null;
$error = '';
$email = null;
$address = null;
$contact = null;
$dob = null;
$subjects = [];

if (file_exists($jsonFile)) {
    $json = file_get_contents($jsonFile);
    $data = json_decode($json, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        $logged_in = $data['logged'];
        if ((time() - $logged_in) > 1800) {
            unlink($jsonFile);
            header("Location: ../student_login.php");
        }
        $attendance = htmlspecialchars($data['attendance']);
        $name = htmlspecialchars($data['name']);
        $roll_number = htmlspecialchars($data['roll_num']);
        $email = htmlspecialchars($data['email']);
        $address = htmlspecialchars($data['address']);
        $contact = htmlspecialchars($data['contact']);
        $dob = htmlspecialchars($data['dob']);
        $subjects = $data['subjects'];
    } else {
        $error = "Error decoding JSON: " . json_last_error_msg();
    }
} else {
    header("Location: ../student_login.php");
    $error = "JSON file not found.";
}

$subjectIcons = [
    'DM' => 'calculate', // Discrete Mathematics
    'BEFA' => 'business',
    'OS' => 'memory', // Operating System
    'DBMS' => 'dns', // Database
    'SE' => 'design_services', // Software Engineering
    'OS LAB' => 'developer_board',
    'DBMS LAB' => 'storage',
    'NODE JS' => 'code',
    'COI' => 'settings_input_component',
    'REAL TIME PROJECT' => 'query_builder',
    'CRT' => 'school',
];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="shortcut icon" href="./images/logo.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <a href="../logout.php" class="logo" title="Student-Portal">
            <img src="./images/logo.png" alt="">
            <h2>V<span class="danger">I</span>TS</h2>
        </a>

        <div class="navbar">
            <a href="index.php" class="active">
                <span class="material-icons-sharp">home</span>
                <h3>Home</h3>
            </a>
            <a href="timetable.html" onclick="timeTableAll()">
                <span class="material-icons-sharp">today</span>
                <h3>Time Table</h3>
            </a>
            </a>
            <a href="password.php">
                <span class="material-icons-sharp">password</span>
                <h3>Change Password</h3>
            </a>
            <a href="../logout.php">
                <span class="material-icons-sharp">logout</span>
                <h3>Logout</h3>
            </a>
        </div>
        <div id="profile-btn">
            <span class="material-icons-sharp">person</span>
        </div>
        <div class="theme-toggler">
            <span class="material-icons-sharp active">light_mode</span>
            <span class="material-icons-sharp">dark_mode</span>
        </div>

    </header>
    <div class="container">
        <aside>
            <div class="profile">
                <div class="top">
                    <div class="profile-photo">
                        <img src="./images/profile-1.png" alt="">
                    </div>
                    <div class="info">
                        <p>Welcome, <b><?php echo $name; ?></b> </p>
                        <small class="text-muted"><?php echo $roll_number; ?></small>
                    </div>
                </div>
                <div class="about">
                    <h5>Attendance</h5>
                    <p><?php echo htmlspecialchars($attendance); ?>%</p>
                    <h5>DOB</h5>
                    <p><?php echo $dob; ?></p>

                    <h5>Contact</h5>
                    <p><?php echo $contact; ?></p>

                    <h5>Email</h5>
                    <p><?php echo $email; ?></p>

                    <h5>Address</h5>
                    <p><?php echo $address; ?></p>

                </div>
            </div>
        </aside>

        <main>
            <h1>Attendance</h1>
            <div class="subjects">
                <?php foreach ($subjects as $subject): ?>
                    <?php
                    $subjectName = htmlspecialchars($subject['subject']);
                    $classesHeld = $subject['classes_held'];
                    $classesAttended = $subject['classes_attended'];

                    // Skip if classes held is 0 or classes attended is '--'
                    if ($classesHeld == "0" || $classesAttended == "--") {
                        continue;
                    }

                    $icon = $subjectIcons[$subjectName] ?? 'book'; // default icon
                    ?>
                    <div class="subject-box">
                        <span class="material-icons-sharp"><?php echo $icon; ?></span>
                        <h3><?php echo $subjectName; ?></h3>
                        <h2><?php echo htmlspecialchars($classesAttended) . "/" . htmlspecialchars($classesHeld); ?></h2>
                        <div class="progress">
                            <svg>
                                <circle cx="38" cy="38" r="36"></circle>
                            </svg>
                            <div class="number">
                                <p><?php echo htmlspecialchars($subject['percentage']); ?>%</p>
                            </div>
                        </div>
                        <small class="text-muted">Updated</small>
                    </div>
                <?php endforeach; ?>
            </div>

        </main>

        <div class="right">
            <div class="announcements">
                <h2>Announcements</h2>
                <div class="updates">
                    <div class="message">
                        <p> <b>Academic</b> Summer training internship with Live Projects.</p>
                        <small class="text-muted">2 Minutes Ago</small>
                    </div>
                    <div class="message">
                        <p> <b>Co-curricular</b> Global internship oportunity by Student organization.</p>
                        <small class="text-muted">10 Minutes Ago</small>
                    </div>
                    <div class="message">
                        <p> <b>Examination</b> Instructions for Mid Term Examination.</p>
                        <small class="text-muted">Yesterday</small>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="timeTable.js"></script>
    <script src="app.js"></script>
</body>

</html>