<?php
$jsonfile = "settings.json";
$jsonfile = file_get_contents($jsonfile);
$json = json_decode($jsonfile, true);


echo "
<form action='' method='POST'>
";
$i = 0; # index
foreach ($json as $setting=>$value) {
    echo $setting." <input type='text' name='$setting' value='".$value."'";
    $i++;
}
echo "
<input type='submit' value='Save'>
</form>
";
?>