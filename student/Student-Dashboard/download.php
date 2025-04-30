<?php
// Check if file parameter is present
if (!isset($_GET['file']) || !isset($_GET['name'])) {
    die("Error: Required parameters missing");
}

$filePath = urldecode($_GET['file']);
$fileName = urldecode($_GET['name']);

// Security check: Make sure the file is within the allowed directory
$basePath = "C:\\xampp\\htdocs\\college-portal\\vignan-dhara\\books";
$realPath = realpath($filePath);

if ($realPath === false || strpos($realPath, $basePath) !== 0) {
    die("Error: Invalid file path");
}

// Check if file exists
if (!file_exists($filePath)) {
    die("Error: File not found");
}

// Set headers for download
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($filePath));

// Clear output buffer
ob_clean();
flush();

// Read file and output
readfile($filePath);
exit;
