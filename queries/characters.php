<?php
  # Select all characters from DB
  $getcharacter = "SELECT * FROM characters";
  $getcharacter = mysqli_query($sqlc, $getcharacter);

  # Create table
  echo  "<table class='table table-hover'>";
  echo "
  <thead class='table-primary'>
  <tr>
  <th>#</th> <th>Name</th>
  <th>Player</th> <th>Gender</th>
  <th>Cash</th> <th>Flags</th>
  <th>Faction</th> <th>Action</th>
  </tr>
  </thead>
  ";

  # List out a table with characters
  if ($getcharacter->num_rows < 1) {
    die("No rows found.");
  }
  $i = 0; # Index
  while ($row = $getcharacter->fetch_assoc()) {
    # Define chardata as array
    $chardata = array();

    # JSON decode data column
    $chardata = json_decode($row['_Data']);

    # Store DB values to variables
    $charkey = $row['_Key'];
    $charname = $row['_Name'];
    $chargender = $row['_Gender'];
    $charinvcash = $row['_Cash'];
    $charflags = $row['_Flags'];
    $charfaction = $row['_Faction'];
    $charsteamid = $row['_SteamID'];
    $charlastplayed = $row['_LastPlayed'];

    # Store data values to variables
    $safeboxcash = varIfIsset($chardata->safeboxcash);
    $alliance = varIfIsset($chardata->alliance);
    $alliancerank = $chardata->rank;
    $rank = varIfIsset($chardata->FactionRank);
    $physdesc = $chardata->PhysDesc;
    $health = $chardata->Health;
    $stamina = $chardata->Stamina;
    $honor = $chardata->honor;

    # Arrays
    $safeboxitems = $chardata->safeboxitems;
    $victories = $chardata->victories;
    $traits = $chardata->Traits;
    $clothes = $chardata->Clothes;

    # Number format
    $safeboxcash = number_format($safeboxcash);
    $charinvcash = number_format($charinvcash);

    # Other formats
    $alliancerank = translateAllianceRank($alliancerank);

    # Get player of this character
    $playername = getCharPlayer($sqlc, $charsteamid, "_SteamName");

    # Check if character is currently playing (last two minutes)
    $timelastplayed = strtotime(gmdate("Y-m-d H:i:s", $charlastplayed));
    $curtime = time();
    if ($curtime - $timelastplayed < 120) {
      $charlastplayed = "<font color='green'><b>Online!</b></font>";
      $online = TRUE; # This will set table row to green
    } else {
      $charlastplayed = gmdate("Y-m-d H:i:s", $charlastplayed);
      $online = FALSE; # This will default he table, if not set, default value is TRUE, appearently
    }

    # Set none if blank
    if (empty($alliance)) {
      $alliance = "No alliance";
    }
    # This function is handled in functions.php - translateAllianceRank()
    // if (empty($alliancerank)) {
    //   $alliancerank = "No alliance rank";
    // }
    if (empty($rank)) {
      $rank = "No rank";
    }

    # Get information about player
    // $getplayer = "SELECT * FROM players WHERE _SteamID = '$charsteamid'";
    // $getplayer = mysqli_query($sqlcon, $getplayer);
    // $charactersamt = $getplayer->num_rows; # Amount of characters this player has.
    // while ($prow = $getplayer->fetch_assoc()) {
    //
    // }

    # Create a modal for every character
    $modals[$i] = '
    <!-- Large modal -->
    <div class="modal" id="charinfo'.$i.'" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">#'.$charkey.' '.$charname.'</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          <h4>Character</h4>
            <table class="table table-hover">
            <tr><td>Name:</td> <td>'.$charname.'</td></tr>
            <tr><td>Gender:</td> <td>'.$chargender.'</td></tr>
            <tr><td>Physical Description:</td> <td>'.$physdesc.'</td></tr>
            <tr><td>Faction:</td> <td>'.$charfaction.'</td></tr>
            <tr><td>Flags:</td> <td>'.$charflags.'</td></tr>
            <!--<tr><td><td></td></tr>-->
            <tr><td>Health:</td> <td>'.$health.'</td></tr>
            <tr><td>Stamina:</td> <td>'.$stamina.'</td></tr>
            <tr><td>Honor:</td> <td>'.$honor.'</td></tr>
            <tr><td>Last played:</td> <td>'.$charlastplayed.'</td></tr>
            </table>
          <h4>Player</h4>
            <table class="table table-hover">
            <tr><td>Steam name:</td> <td>'.$playername.'</td></tr>
            <tr><td>SteamID:</td> <td>'.$charsteamid.'</td></tr>
            </table>
          <h4>Items</h4>
            <table class="table table-hover">
            <tr><td>Inventory cash:</td> <td>'.$charinvcash.'</td></tr>
            <tr><td>Safebox cash:</td> <td>'.$safeboxcash.'</td></tr>
            </table>
          <h4>Alliance</h4>
            <table class="table table-hover">
            <tr><td>Alliance:</td> <td>'.$alliance.'</td></tr>
            <tr><td>Rank:</td> <td>'.$alliancerank.'</td></tr>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <a href="index.php?page=editcharacter&id='.$charkey.'" type="button" class="btn btn-primary">Edit</a>
          </div>
        </div>
      </div>
    </div>
    ';

    # Fill table with info
    if ($online === TRUE) {
      echo "<tr class='table-success'>";
    }
    else {
      echo "<tr>";
    }
      echo "
    <td>$charkey</td> <td>$charname</td> <td>$playername</td> <td>$chargender</td>
    <td>Inventory: $charinvcash<br>Safebox: $safeboxcash</td> <td>$charflags</td> <td>$charfaction</td>
    <td>
    <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#charinfo$i'>View</button>
    <a href='?page=editcharacter&id=$charkey' class='btn btn-success'>Edit</a></td>
    </tr>";
  $i++;
}
  echo "</table>";

  # Initialize modals
  foreach($modals as $modal) {
    echo $modal;
  }
?>
