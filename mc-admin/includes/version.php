<?php
// Version
$mcdb = new database\db;
$query = "SELECT * FROM mc_version";
$result = $mcdb->query($query);
$version = $mcdb->fetch_assoc($result);
$major = $version['major'];
$minor = $version['minor'];
$increment = $version['increment'];
$codename = $version['codename'];
$current_version = "$major.$minor";
?>

microCMS <?php echo $current_version;?>
