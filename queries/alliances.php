<?php
  # include("sqlcon.php");
  $query = "SELECT * FROM alliances";
  $query = mysqli_query($sqlc, $query);

 echo  "<table class='table table-striped'>";
 echo "
 <thead class='table-primary'>
 <tr>
 <th>#</th> <th>Alliance name</th>
 <th>Cash</th> <th>Members</th>
 <th>Action</th>
 </tr>
 </thead>";
  # List out a table with characters
  if ($query->num_rows < 1) {
    die("No rows found.");
  }
  while ($row = $query->fetch_assoc()) {

    # Extract alliance data and players
    $alliancedata = json_decode($row['_Data']);
    $allianceplayers = json_decode($row['_Players']);

    # Convert players list from array to readable
    $allianceplayers = array2Readable($allianceplayers);

    # Extract alliance cash data value
    $alliancecash = $alliancedata->cash;

    echo "<tr>
    <td>$row[_Key]</td> <td>$row[_Name]</td>
    <td>$alliancecash</td> <td>$allianceplayers</td>
    <td><button class='btn btn-primary'>View</button></td>
    </tr>";
  }
  echo "</table>";
?>
