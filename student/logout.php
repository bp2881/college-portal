<?php
$jsonFile = "C:\\xampp\\htdocs\\college-portal\\student\\session.json";
unlink($jsonFile);
header("Location: student-portal.html");
?>