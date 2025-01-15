<?php
// Include any necessary files or initialization code here

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Save settings logic
    $backup_label = $_POST['backup_label'];
    $backup_path = $_POST['backup_path'];
    $rclone_label = $_POST['rclone_label'];
    $rclone_path = $_POST['rclone_path'];

    // Save the settings to a file or database
    file_put_contents('/path/to/settings.json', json_encode([
        'backup_label' => $backup_label,
        'backup_path' => $backup_path,
        'rclone_label' => $rclone_label,
        'rclone_path' => $rclone_path,
    ]));
}

// Load existing settings
$settings = json_decode(file_get_contents('/path/to/settings.json'), true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Backup Status Settings</title>
</head>
<body>
    <h1>Backup Status Settings</h1>
    <form method="POST">
        <label for="backup_label">Backup Label:</label>
        <input type="text" id="backup_label" name="backup_label" value="<?= htmlspecialchars($settings['backup_label']) ?>"><br>

        <label for="backup_path">Backup File Path:</label>
        <input type="text" id="backup_path" name="backup_path" value="<?= htmlspecialchars($settings['backup_path']) ?>"><br>

        <label for="rclone_label">RClone Label:</label>
        <input type="text" id="rclone_label" name="rclone_label" value="<?= htmlspecialchars($settings['rclone_label']) ?>"><br>

        <label for="rclone_path">RClone File Path:</label>
        <input type="text" id="rclone_path" name="rclone_path" value="<?= htmlspecialchars($settings['rclone_path']) ?>"><br>

        <button type="submit">Save Settings</button>
    </form>
</body>
</html>


