<?php
$jsonfile = "settings.json";
$json = json_decode($jsonfile, true);

$i = 0; # index
foreach ($json as $setting=>$value) {
    echo $setting." <input type='text' name='$setting' value='".$value."'";
    $i++;
}
?>