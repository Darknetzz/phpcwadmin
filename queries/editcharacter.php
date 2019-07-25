<?php

# Get and sanitize ID
$id = mysqli_real_escape_string($sqlc, $_GET['id']);

# Select character from DB
$selectcharacter = "SELECT * FROM characters WHERE _Key = '$_GET[id]'";
$selectcharacter = mysqli_query($sqlc, $selectcharacter);

# Check if character is currently playing (last two minutes), and disallow editing
while ($row = $selectcharacter->fetch_assoc()) {
$charlastplayed = $row['_LastPlayed'];
}
$timelastplayed = strtotime(gmdate("Y-m-d H:i:s", $charlastplayed));
$curtime = time();
if ($curtime - $timelastplayed < 120) {
  die("This character is currently playing and can't be edited.");
}

  # Check if character with id exists
  if ($selectcharacter->num_rows < 1) {
    die("ID doesn't exist.");
  }

# Check if player ID is set, die if not
if (!isset($_GET['id'])) {
  die("No ID given.");
}

# Check if user is being edited
if (isset($_POST['charedit'])) {
  $fields = [
    "charname",
    "chargender",
    "physdesc",
    "charfaction",
    "charflags",
    "health",
    "stamina",
    "honor",
    "charinvcash",
    "safeboxcash",
    "alliance",
    "alliancerank",
  ];
  $fieldindex = 0;
  $fieldcount = count($fields);
  while ($fieldindex < $fieldcount) {
    if (!isset($_POST[$fields[$fieldindex]])) {
      die("Form submitted illegaly.");
    } else {
      ${$fields[$fieldindex]} = $_POST[$fields[$fieldindex]];
    }
    $fieldindex++;
  }
  # echo "You are editing $charname, $chargender with ID $id.";
  # The form is submitted

  $updatechar = "UPDATE characters SET _Name = '$charname', _Gender = '$chargender',
  _Cash = '$charinvcash', _Flags = '$charflags', _Faction = '$charfaction' WHERE _Key = '$id';"; # not finished
  $updatechar = mysqli_query($sqlc, $updatechar);
  if ($updatechar) {
    echo "<div class='alert alert-success'>Character <b>$charname</b> updated!</div>";
  } else {
    echo "<div class='alert alert-danger'>Failed to update character $charname.</div>";
  }
}

# Select updated character from DB
$selectcharacter = "SELECT * FROM characters WHERE _Key = '$_GET[id]'";
$selectcharacter = mysqli_query($sqlc, $selectcharacter);

while ($row = $selectcharacter->fetch_assoc()) {

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

  # Factions
  $factions = [
    "Civilian",
    "Donator",
    "Premium",
  ]; # not yet in use, want to make a dropdown

# Create forms
echo '
<form action="" method="POST">
<input type="hidden" name="charedit">
<input type="hidden" name="id" value="'.$id.'">
<h4>Character</h4>
<table class="table table-primary">
  <tr><td>Name:</td> <td><input type="text" class="form-control" id="charname" name="charname" value="'.$charname.'"></input><a href="#" onClick="randName()" class="btn btn-light">Generate</a></td></tr>
  <tr><td>Gender:</td> <td><input type="text" class="form-control" id="chargender" name="chargender" value="'.$chargender.'"></input></td></tr>
  <tr><td>Physical Description:</td> <td><input type="text" class="form-control" name="physdesc" value="'.$physdesc.'"></input></td></tr>
  <tr><td>Faction:</td> <td><input type="text" class="form-control" name="charfaction" value="'.$charfaction.'"></input></td></tr>
  <tr><td>Flags:</td> <td><input type="text" class="form-control" name="charflags" value="'.$charflags.'"></input></td></tr>
</table>



<table class="table table-primary">
  <tr><td>Health:</td> <td><input type="number" class="form-control" name="health" value="'.$health.'"></input></td></tr>
  <tr><td>Stamina:</td> <td><input type="number" class="form-control" name="stamina" value="'.$stamina.'"></input></td></tr>
  <tr><td>Honor:</td> <td><input type="number" class="form-control" name="honor" value="'.$honor.'"></input></td></tr>
</table>



<h4>Items</h4>
<table class="table table-primary">
  <tr><td>Inventory cash:</td> <td><input type="number" class="form-control" name="charinvcash" value="'.$charinvcash.'"></input></td>
  <tr><td>Safebox cash:</td> <td><input type="number" class="form-control" name="safeboxcash" value="'.$safeboxcash.'"></input></td>
</table>

<h4>Alliance</h4>
<table class="table table-primary">
  <tr><td>Alliance:</td> <td><input type="text" class="form-control" name="alliance" value="'.$alliance.'"></input></td></tr>
  <tr><td>Rank:</td> <td><input type="number" class="form-control" name="alliancerank" value="'.$alliancerank.'"></input></td></tr>
</table>

<input type="submit" class="btn btn-primary" value="Save">
<br><br>
</form>
';
}
?>
<script src="js/namegen.js"></script>
<script>
function randName() {
  var gender = document.getElementById("chargender").value;
  if (gender == "Female") {
    document.getElementById("charname").value = generateFemaleName();
  } else if (gender == "Male") {
    document.getElementById("charname").value = generateMaleName();
  } else {
    document.getElementById("charname").value = "Can't generate name of unknown gender.";
  }
}
</script>
