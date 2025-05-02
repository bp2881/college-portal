<?php
$jsonFile = "C:\\xampp\\htdocs\\college-portal\\student\\session.json";
if (file_exists($jsonFile)) {
    unlink($jsonFile);
}
header("Location: ../student/");
?>