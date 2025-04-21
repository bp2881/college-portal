<?php
// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
session_start();

$conn = new mysqli('localhost', 'root', '', 'college-data');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Attendance Dashboard | Vignan ITS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <!-- Navbar -->
    <header class="navbar">
        <div class="logo">
            <img src="images/vignan_logo.png" alt="Vignan Logo">
        </div>
        <nav class="nav-menu">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="attendance.html">Attendance</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
        <button class="menu-toggle" aria-label="Toggle menu">☰</button>
    </header>

    <!-- Attendance Section -->
    <section class="hero">
        <div class="overlay"></div>
        <div class="login-card" style="max-width: 900px; width: 100%;">
            <h1>Class Wise Student Attendance Dashboard</h1>
            <form class="form-box" action="classwisereports.php" method="post">
                <div style="display: flex; flex-wrap: wrap; gap: 1rem; justify-content: center;">
                    <div class="input-group">
                        <label for="branch">Branch</label>
                        <select id="branch" required>
                            <option value="">Select Branch</option>
                            <option value="CSE">CSE</option>
                            <option value="ECE">ECE</option>
                            <option value="EEE">EEE</option>
                            <option value="MECH">MECH</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="year">Year</label>
                        <select id="year" required>
                            <option value="">Select Year</option>
                            <option value="1">I</option>
                            <option value="2">II</option>
                            <option value="3">III</option>
                            <option value="4">IV</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="section">Section</label>
                        <select id="section" required>
                            <option value="">Select Section</option>
                            <option>A</option>
                            <option>B</option>
                            <option>C</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="from">From Date</label>
                        <input type="date" id="from" required />
                    </div>

                    <div class="input-group">
                        <label for="to">To Date</label>
                        <input type="date" id="to" required />
                    </div>

                    <button type="submit">Enter</button>
                </div>
            </form>
    </section>

    <footer>
        &copy; 2025 Vignan Institute of Technology & Science. All rights reserved.
    </footer>

    <script>
        const menuToggle = document.querySelector('.menu-toggle');
        const navMenu = document.querySelector('.nav-menu ul');
        menuToggle.addEventListener('click', () => {
            navMenu.classList.toggle('open');
        });
    </script>
</body>

</html>