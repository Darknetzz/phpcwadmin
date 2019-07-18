<?php
  # Select all characters from DB
  $getcharacter = "SELECT * FROM characters";
  $getcharacter = mysqli_query($sqlc, $getcharacter);

 # Create table
 echo  "<table class='table table-striped'>";
 echo "
 <thead class='table-primary'>
 <tr>
 <th>#</th> <th>Name</th> <th>Gender</th>
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
    $safeboxcash = $chardata->safeboxcash;
    $alliance = $chardata->alliance;
    $alliancerank = $chardata->rank;
    $rank = $chardata->FactionRank;
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
    echo '
    <!-- Large modal -->
    <div class="modal" id="charinfo'.$i.'" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">#'.$charkey.' '.$charname.'</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          <h4>Character</h4>
            <p>
            Name: '.$charname.'<br>
            Gender: '.$chargender.'<br>
            Physical Description: '.$physdesc.'<br>
            Faction: '.$charfaction.'<br>
            Flags: '.$charflags.'<br><br>

            Health: '.$health.'<br>
            Stamina: '.$stamina.'<br>
            Honor: '.$honor.'<br><br>

            Last played: '.$charlastplayed.'
            </p>
            <hr>
          <h4>Player</h4>
          Steam name: '.$playername.'<br>
          SteamID: '.$charsteamid.'<br>
            <hr>
          <h4>Items</h4>
            Inventory cash: '.$charinvcash.'<br>
            Safebox cash: '.$safeboxcash.'<br><br>
            <hr>
          <h4>Alliance</h4>
            Alliance: '.$alliance.'<br>
            Rank: '.$alliancerank.'<br>
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
    <td>$charkey</td> <td>$charname</td> <td>$chargender</td>
    <td>Inventory: $charinvcash<br>Safebox: $safeboxcash</td> <td>$charflags</td> <td>$charfaction</td>
    <td><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#charinfo$i'>View</button></td>
    </tr>";
  $i++;
}
  echo "</table>";
?>
