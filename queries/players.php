<?php
  # include("sqlcon.php");
  $getplayers = "SELECT * FROM players";
  $getplayers = mysqli_query($sqlc, $getplayers);

  # List out a table with characters
  if ($getplayers->num_rows < 1) {
    die("No rows found.");
  }

  # Table start
  echo  "<table class='table table-striped'>";
  echo "
  <thead class='table-primary'>
  <tr>
  <th>#</th> <th>Steam name</th>
  <th>IP</th> <th>SteamID</th> <th>User group</th>
  <th>Action</th>
  </tr>
  </thead>";

  $i = 0; # Index
  while ($row = $getplayers->fetch_assoc()) {
    # Define player data as array
    $playerdata = array();

    # JSON decode data array
    $playerdata = json_decode($row['_Data']);

    # Store data values to variables
    $playerlanguage = $playerdata->Language;
    $playerwhitelisted = $playerdata->Whitelisted;
    $playerflags = $playerdata->Flags;

    # Store DB values as variables
    $playersteamname = $row['_SteamName'];
    $playersteamid = $row['_SteamID'];
    $playerlastplayed = $row['_LastPlayed'];
    $playerjoined = $row['_TimeJoined'];
    $playeripaddress = $row['_IPAddress'];
    $playerusergroup = $row['_UserGroup'];
    $playerdonations = $row['_Donations'];

    # Check if user is currently playing (last two minutes)
    $timelastplayed = strtotime(gmdate("Y-m-d H:i:s", $playerlastplayed));
    $curtime = time();
    if ($curtime - $timelastplayed < 120) {
      $playerlastplayed = "<font color='green'><b>Online!</b></font>";
      $online = TRUE; # This will set table row to green
    } else {
      $playerlastplayed = gmdate("Y-m-d H:i:s", $playerlastplayed);
      $online = FALSE; # This will default the table, if not set, default value is TRUE, appearently
    }

    # Get all characters for each player
    $getchars = "SELECT * FROM characters WHERE _SteamID = '$playersteamid'";
    $getchars = mysqli_query($sqlc, $getchars);
    $cindex = 0; # Index for character count
    $ccount = $getchars->num_rows; # Count amount of characters
    while ($chars = $getchars->fetch_assoc()) {
      if ($cindex < $ccount) {
      $pcharkey[$cindex] = $chars['_Key'];
      $pcharname[$cindex] = $chars['_Name'];
      $cindex++;
    }
    }

    # Create a modal for every player
    $modals[$i] = '
    <!-- Large modal -->
    <div class="modal" id="playerinfo'.$i.'" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">#'.$playerkey.' '.$playersteamname.'</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          <h4>Player</h4>
          <table class="table table-hover">
          <tr><td>Name:</td> <td>'.$playersteamname.'</td></tr>
          <tr><td>IP:</td> <td>'.$playeripaddress.'</td></tr>
          <tr><td>User Group:</td> <td>'.$playerusergroup.' '.icon("badge-8x").'</td></tr>
          <tr><td>Flags:</td> <td>'.translateFlags($playerflags).'</td></tr>
          <tr><td>Donations:</td> <td>'.translateDonation($playerdonations).'</td></tr>
          </table>
          <hr>
          <h4>Time</h4>
          <table class="table table-hover">
          <tr><td>Time joined:</td> <td>'.gmdate("Y-m-d H:i:s", $playerjoined).'</td></tr>
          <tr><td>Last played:</td> <td>'.$playerlastplayed.'</td></tr>
          </table>
          <hr>
          <h4>Characters</h4>
          ';
          # List out all characters for player
          # echo '<table class="table table-hover">';
          for($cindex=0;$ccount>$cindex;$cindex++){
            echo '<a href="index.php?page=editcharacter&id='.$pcharkey[$cindex].'">'.$pcharname[$cindex].'</a><br>';
          }
          echo '
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <!--<button type="button" class="btn btn-primary">Save changes</button>-->
          </div>
        </div>
      </div>
    </div>
    ';

    if ($online === TRUE) {
      echo "<tr class='table-success'>";
    } else {
      echo "<tr>";
    }
    echo "
    <td>$row[_Key]</td> <td>$row[_SteamName]</td>
    <td>$row[_IPAddress]</td> <td>$row[_SteamID]</td>
    <td>$row[_UserGroup]</td> <td><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#playerinfo$i'>View</button></td></td>
    </tr>";
    $i++;
  }
  echo "</table>";

  # Initialize modals
  foreach ($modals as $modal) {
    echo $modal;
  }
?>
