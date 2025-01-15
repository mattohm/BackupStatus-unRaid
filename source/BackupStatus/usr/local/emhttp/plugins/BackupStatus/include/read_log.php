<?php
$logFile = $_GET['file'] ?? '';

if (strpos($logFile, '/mnt/user/') !== 0 || !file_exists($logFile)) {
    http_response_code(404);
    echo "Error: Log file not found.";
    exit;
}

header('Content-Type: text/plain');
echo file_get_contents($logFile);

