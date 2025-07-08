<?php
$students = [
    ['23891A0549', 'Pranav Bairy', 'Hyderabad', '9876543210', '2005-06-15', 2, 'CSE', 'pranavbairy2@gmail.com', 'pranavbairy2'],
    ['23891A0558', 'Shashank Varma', 'Bheemvaram', '9123456780', '2003-11-22', 3, 'CSE', 'ushashankvarma12@gmail.com', 'shashankvarma'],
    ['23891A0512', 'Devesh Rayudu', 'Guntur', '9988776655', '2004-02-10', 2, 'ECE', 'deveshrayudu@gmail.com', 'deveshrayudu'],
    ['23891A0522', 'Jarubula Aakash', 'Visakhapatnam', '9090909090', '2003-08-30', 3, 'ME', 'aakashjarubula@example.com', 'aakashjarubula'],
    ['23891A0542', 'Palle Chandu Reddy', 'Warangal', '9012345678', '2004-01-01', 2, 'EEE', 'pallechandhureddy1@gmail.com', 'pallechandhureddy1'],
];

foreach ($students as $s) {
    $hash = password_hash($s[8], PASSWORD_DEFAULT);
    $query = sprintf(
        "INSERT INTO students (roll_num, name, address, contact, dob, year, branch, email, password) VALUES ('%s', '%s', '%s', '%s', '%s', %d, '%s', '%s', '%s');",
        $s[0],
        $s[1],
        $s[2],
        $s[3],
        $s[4],
        $s[5],
        $s[6],
        $s[7],
        $hash
    );
    echo $query . "<br>\n";
}
?>