<?php
# Get settings and put in array
$jsonfile = "settings.json";
$jsonfile = file_get_contents($jsonfile);
$json = json_decode($jsonfile, true);

# Check if settings are being updated
if (isset($_POST['changesettings'])) {
    # Replace JSON file with POST array
    $updatesettings = array();
    foreach($_POST as $var=>$val) {
        
    }
}

echo "
<form action='' method='POST'>
";
$i = 0; # index
foreach ($json as $setting=>$value) {
    echo $setting." <input type='text' name='$setting' value='".$value."'";
    $i++;
}
echo "
<input type='hidden' name='changesettings' value='1'>
<input type='submit' value='Save'>
</form>
";
?>