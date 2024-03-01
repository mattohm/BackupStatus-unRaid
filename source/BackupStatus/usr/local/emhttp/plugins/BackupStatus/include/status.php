<?

 $bu_date = shell_exec("/usr/bin/stat  /mnt/user/scripts/backupstatus.txt | grep Modify | awk '{print $2}'");
 $bu_code = shell_exec("/usr/bin/cat  /mnt/user/scripts/backupstatus.txt");
 $bu_color = 'green';
 if ($bu_code != 0)
   $bu_color = 'red';
 $displays[] = "<span title='Borg'><font color='$bu_color'>$bu_date</font><small>Backup</small></span>";

 $rc_date = shell_exec("/usr/bin/stat  /mnt/user/scripts/rclonestatus.txt | grep Modify | awk '{print $2}'");
 $rc_code = shell_exec("/usr/bin/cat  /mnt/user/scripts/rclonestatus.txt");
 $rc_color = 'green';
 if ($rc_code != 0)
   $rc_color = 'red';
 $displays[] = "<span title='RClone'><font color='$rc_color'>$rc_date</font><small>RClone</small></span>";

if ($displays)
    echo "<span id='status' style='margin-right:16px;font-weight: bold;cursor: pointer;'>".implode('&nbsp;', $displays)."</span>";
?>
