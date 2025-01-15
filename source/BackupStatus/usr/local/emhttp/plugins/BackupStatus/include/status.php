<?php
// Path to settings file
$settingsFile = "/boot/config/plugins/BackupStatus/settings.json";

// Ensure the settings file exists
if (!file_exists($settingsFile)) {
    http_response_code(404);
    echo "<span style='color: red;'>Error: Settings file not found</span>";
    exit;
}

// Load settings
$settings = json_decode(file_get_contents($settingsFile), true);
$entries = $settings['entries'] ?? [];

$html = "<span id='status' style='margin-right:16px;font-weight: bold;cursor: pointer;'>";

// Loop through each entry and generate HTML
foreach ($entries as $entry) {
    $statusFile = $entry['status_file'];
    $label = $entry['label'];

    // Check if the status file exists
    if (file_exists($statusFile)) {
        $content = trim(file_get_contents($statusFile));
        $modifiedDate = date('Y-m-d', filemtime($statusFile));
        $color = ($content === '0') ? 'green' : 'red';
    } else {
        $modifiedDate = 'File not found';
        $color = 'red';
    }

    // Append the status HTML
    $html .= "
        <span title='{$label}'>
          <font color='{$color}'>{$modifiedDate}</font>
          <small>{$label}</small>
        </span>&nbsp;";
}

$html .= "</span>";

// Output the HTML
echo $html;

