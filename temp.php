<?php
$password = "vgnt"; // Plain text password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

echo "Hashed Password: " . $hashedPassword;
?>