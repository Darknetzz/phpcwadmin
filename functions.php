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

  # Function to extract a given setting from json file
  function getSettings($setting) {
    $settings = "settings.json";
    $settings = file_get_contents($settings) or die("Settings.json does not seem to exist.");
    $settings = json_decode($settings, true) or die("Settings.json is not valid! Please fix this.");
    if (empty($settings[$setting])) {
      $settings[$setting] = "None";
    }
    return $settings[$setting];
  }

  # Used to update a given setting in json file
  function changeSetting($setting, $value) {
    $settings = "settings.json";
    $settings = file_get_contents($settings) or die("Settings.json does not seem to exist.");
    $settings = json_decode($settings, true) or die("Settings.json is not valid! Please fix this.");
    if (empty($value)) {
      die("The function changeSetting needs a value to set.");
    } else {
      $settings[$setting] = $value;
      $settings = json_encode($settings);
      $settings = file_put_contents($settings, "settings.json") or die("Failed to save settings.");
      return true;
    }
  }

    # Show icon (for navbar)
    function icon($icon, $filetype = "svg", $size = 15, $isnavicon = false) {
      # make sure icons are enabled
      if (getSettings("navIcons") == false && $isnavicon == false) {
        return false;
      }
      $icon = "<img src='img/icons/$icon.$filetype' width='".$size."px' height='".$size."px'>";
      return $icon;
    }

    # Check if variable isset, then return it or set none
    # Parameter set to false in case given variable not set?
    function varIfIsset($var = false) {
      if (isset($var)) {
        return $var;
      } else {
        return false;
      }
    }
 ?>
