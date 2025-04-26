<?php
$password = "pallechandureddy1"; // Plain text password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

echo "Hashed Password: " . $hashedPassword;
?>