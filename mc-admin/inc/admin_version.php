<?php
// Version
$db = new database\db;
$query = "SELECT * FROM mc_version";
$result = $db->query($query);
$version = $db->fetch_assoc($result);
$major = $version['major'];
$minor = $version['minor'];
$increment = $version['increment'];
$current_version = "$major.$minor.$increment";
?>

<div class="row admin_foot">
  <div class="admin_foot_right"><small>microCMS <?php echo $current_version;?></small></div>
</div>
