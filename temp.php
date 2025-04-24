<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "college-data";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sample input
$uid = 848;
$plain_password = "vgnt";

// Hash the password
$hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO faculty_login (uid, password) VALUES (?, ?)");
$stmt->bind_param("is", $uid, $hashed_password);

// Execute
if ($stmt->execute()) {
    echo "New record inserted successfully.";
} else {
    echo "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
?>