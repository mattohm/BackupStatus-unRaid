<?php
// Path to settings file
$settingsFile = "/boot/config/plugins/BackupStatus/settings.json";

if (!file_exists($settingsFile)) {
    http_response_code(404);
    echo "<span style='color: red;'>Error: Settings file not found</span>";
    exit;
}

$settings = json_decode(file_get_contents($settingsFile), true);
$entries = $settings['entries'] ?? [];

// Start generating HTML
$html = "<span id='status' style='margin-right:16px;font-weight: bold;cursor: pointer;'>";

foreach ($entries as $entry) {
    $statusFile = $entry['status_file'] ?? '';
    $logFile = $entry['log_file'] ?? '';
    $label = $entry['label'] ?? 'Unknown';

    if (file_exists($statusFile)) {
        $content = trim(file_get_contents($statusFile));
        $modifiedDate = date('Y-m-d', filemtime($statusFile));
        $color = ($content === '0') ? 'green' : 'red';
    } else {
        $modifiedDate = 'File not found';
        $color = 'red';
    }

    // Add clickable functionality to show the log file
    $html .= "
        <span title='{$label}' onclick='showLog(\"{$logFile}\")' style='cursor: pointer;'>
          <font color='{$color}'>{$modifiedDate}</font>
          <small>{$label}</small>
        </span>&nbsp;";
}

$html .= "</span>";
echo $html;
?>

