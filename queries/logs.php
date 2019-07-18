<?php
# include("/usr/games/log/console/gmodserver-console.log");
$logs = file_get_contents("./usr/games/log/console/gmodserver-console.log") or die("Could not get logs.");
echo $logs;
 ?>
