<?php
$file = $_GET['file'] ?? '';

// Ensure the file path is within the allowed directory
if (strpos($file, '/mnt/user/') !== 0) {
    http_response_code(400); // Bad request
    echo json_encode(['error' => 'Invalid file path']);
    exit;
}

// Check if the file exists
if (!file_exists($file)) {
    http_response_code(404); // Not found
    echo json_encode(['error' => 'File not found']);
    exit;
}

// Get the file content and last modified date
$content = @file_get_contents($file);
$modifiedDate = date('Y-m-d H:i:s', filemtime($file));

if ($content === false) {
    http_response_code(500); // Internal server error
    echo json_encode(['error' => 'Failed to read file']);
} else {
    echo json_encode([
        'content' => trim($content),
        'modified' => $modifiedDate,
    ]);
}
?>

