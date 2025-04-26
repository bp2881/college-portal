<?php

$new_entry = [
    'name' => trim($_POST['name'] ?? ''),
    'roll_num' => trim($_POST['roll_num'] ?? ''),
    'email' => trim($_POST['email'] ?? ''),
    'attendance' => trim($_POST['attendance'] ?? ''),
    'date' => date('d-m-Y'),
    'timestamp' => date('d-m-Y H:i:s')
];

$file = 'session.json';
$data[] = $new_entry;
file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

?>