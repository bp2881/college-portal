<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "college_data";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sample student data
$students = [
    [
        'roll_num' => '23891A0549',
        'name' => 'Pranav Bairy',
        'email' => 'pranavbairy2@gmail.com',
        'address' => 'Nallakunta, Hyderabad',
        'year' => 2,
        'sem' => 2,
        'sem_start' => '2025-01-20',
        'dob' => '2005-08-28',
        'contact' => '9100026483',
        'branch' => 'CSE',
        'password' => 'pranavbairy2'
    ],
    [
        'roll_num' => '23891A0558',
        'name' => 'Shashank Varma',
        'email' => 'ushashankvarma12@gmail.com',
        'address' => 'Yapral, Hyderabad',
        'year' => 2,
        'sem' => 2,
        'sem_start' => '2025-01-20',
        'dob' => '2003-08-22',
        'contact' => '555-234-5678',
        'branch' => 'CSE',
        'password' => 'ushashankvarma12'
    ],
    [
        'roll_num' => '23891A0512',
        'name' => 'Devesh Rayudu',
        'email' => 'deveshrayudu@gmail.com',
        'address' => 'Vanasthalipuram, Hyderabad',
        'year' => 2,
        'sem' => 2,
        'sem_start' => '2025-01-20',
        'dob' => '2001-11-30',
        'contact' => '555-345-6789',
        'branch' => 'CSE',
        'password' => 'deveshrayudu'
    ],
    [
        'roll_num' => '23891A0522',
        'name' => 'Aakash',
        'email' => 'aakashjarubula117@gmail.com',
        'address' => '101 Scholar Street, Chicago, IL',
        'year' => 2,
        'sem' => 2,
        'sem_start' => '2025-01-20',
        'dob' => '2000-02-14',
        'contact' => '555-456-7890',
        'branch' => 'CSE',
        'password' => 'aakashjarubula117'
    ],
    [
        'roll_num' => '23891A0540',
        'name' => 'Chandhu Reddy',
        'email' => 'pallechandhureddy1@gmail.com',
        'address' => '202 Academy Road, Seattle, WA',
        'year' => 2,
        'sem' => 2,
        'sem_start' => '2025-01-20',
        'dob' => '2002-07-08',
        'contact' => '555-567-8901',
        'branch' => 'CSE',
        'password' => 'pallechandhureddy1'
    ]
];

// Prepare and execute the insert statements
$stmt = $conn->prepare("INSERT INTO students (roll_num, name, email, address, year, sem, sem_start, dob, contact, branch, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ssssiiissss", $roll_num, $name, $email, $address, $year, $sem, $sem_start, $dob, $contact, $branch, $hashed_password);

$inserted_count = 0;
foreach ($students as $student) {
    // Hash the password using PHP's password_hash function
    $hashed_password = password_hash($student['password'], PASSWORD_DEFAULT);

    // Bind the parameters
    $roll_num = $student['roll_num'];
    $name = $student['name'];
    $email = $student['email'];
    $address = $student['address'];
    $year = $student['year'];
    $sem = $student['sem'];
    $sem_start = $student['sem_start'];
    $dob = $student['dob'];
    $contact = $student['contact'];
    $branch = $student['branch'];

    // Execute the statement
    if ($stmt->execute()) {
        $inserted_count++;
    } else {
        echo "Error inserting student " . $student['name'] . ": " . $stmt->error . "<br>";
    }
}

echo "Successfully inserted " . $inserted_count . " student records with hashed passwords.";

// Close statement and connection
$stmt->close();
$conn->close();
?>