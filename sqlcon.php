<?php
  $host = "localhost"; # sql host
  $port = 3306; # port - default 3306
  $user = ""; # sql user
  $pass = ""; # sql password - not encrypted
  $data = "phasefour"; # database
  $sqlc = mysqli_connect($host.":".$port, $user, $pass, $data);
 # $gameserver = "gameserver01"; # name or ip of gameserver - used for serverquery
 # $gameserverport = 27015; # gameserver port - 27015 default
  if (!$sqlc) {
    die("MySQL connection failed. ".mysqli_connect_error());
  }
 ?>
