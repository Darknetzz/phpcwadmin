<?php
# include("/usr/games/log/console/gmodserver-console.log");
$logs = file_get_contents(getSettings("logfile")) or die("Could not get logs. Check your settings.json file.");
echo $logs;
 ?>
