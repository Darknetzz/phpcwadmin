<?php
  # Translate alliance rank
  function translateAllianceRank($rank) {
    if (empty($rank)) {
      $rank = "No alliance rank ($rank)";
    } elseif ($rank == 0) {
      $rank = $rank." - Recruit";
    } elseif ($rank == 5) {
      $rank = $rank." - Major";
    } else {
      $rank = "Unknown ($rank)";
    }
    return $rank;
  }

  function translateDonation($donation) {
    if (empty($donation)) {
      $donation = "None";
    }
    return $donation;
  }

  # Translate a flag, only to set None if player/char has no flags...
  function translateFlags($flags) {
    if (empty($flags)) {
      $flags = "None";
    }
    return $flags;
  }

  function icon($icon, $size = 15) {
    $icon = "<img src='img/icons/$icon.png' width='".$size."px' height='".$size."px'>";
    return $icon;
  }

  # Function to convert array to a simple list.
  # Use json_decode first, then feed it to function.
  function array2Readable($array, $debug = false) {
    $count = count($array);
    $i = 0;
    $array = '';
    while ($count > $i) {
    $array = $array.", ".$array[$i];
    $i++;
  }
    return $array;
  }

  # Get all characters of a player
  function getPlayerChars($sqlc, $steamid) {
    if (!isset($sqlc) || !isset($steamid)) {
      die("getPlayerChars is expecting two parameters.");
    } else {
    $getcharacters = "SELECT * FROM characters WHERE _SteamID = '$steamid'";
    $getcharacters = mysqli_query($sqlc, $getcharacters);
    return $getcharacters;
  }
}

  # Get this character's player
  # Usage example: $playername = getCharPlayer($sqlc, $steamid, "_SteamName");
  function getCharPlayer($sqlc, $steamid, $return) {
    if (!isset($sqlc) || !isset($steamid)) {
      die("getCharPlayer is expecting two parameters.");
    } else {
    $getplayer = "SELECT * FROM players WHERE _SteamID = '$steamid'";
    $getplayer = mysqli_query($sqlc, $getplayer);
    # Make sure this charcter has a player
    if ($getplayer->num_rows < 1) {
      $return = "No player.";
    }
    elseif ($getplayer) {
      while ($row = $getplayer->fetch_assoc()) {
        $return = $row[$return];
      }
      return $return;
    } else {
      die("Something went wrong with getCharPlayer().");
    }
  }
  }

  function getSettings($setting) {
    $settings = "settings.json";
    $settings = file_get_contents($settings);
    $settings = json_decode($settings);
    return $settings[$setting];
  }
 ?>
