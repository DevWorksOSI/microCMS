<?php
$db = new database\db;
// Menu
$query = "SELECT * FROM mc_plugins WHERE plugin_type = 1";
$result = $db->query($query);
?>
<div class="row">

  <div class="left">
  
    <div class="admin_menu">
      <i class="fa fa-dashboard aria-hidden="true"></i> <a href="/manage"><strong>Dashboard</strong></a>
      <ul>
        <li> <strong>Core</strong></li>
      </ul>
      <ul>
        <li> <i class="fas fa-blog"></i> <a href="/?page=manage&op=blogs">Blogs</a></li>
        <li> <i class="fa fa-plug" aria-hidden="true"></i> <a href="#">Plugins</a></li>
        <li> <i class="fa fa-refresh" aria-hidden="true"></i> <a href="#">Updates</a></li>
        <li> <i class="fa fa-users" aria-hidden="true"></i> <a href="/?page=manage&op=users">Users</a></li>
        <li> <i class="fas fa-cog"></i> <a href="/?page=manage&op=settings">Settings</a></li>
        <li> <i class="fa-camera-retro" aria-hidden="true"></i> <a href="#">Themes</a></li>
      </ul>
      <ul>
        <li> <strong>Plugins</strong></li>
      </ul>
      <ul>
        <?php
        while($plugins = $db->fetch_assoc($result))
        {
           $plugin = $plugins['plugin_slug'];
           $plugin_name = $plugins['plugin_name'];
           if(file_exists('mc-content/'.$plugin.'/admin/'.$plugin.'-admin.php'))
           {
              echo '<li> <a href="/?page=manage&op='.$plugin.'">'.$plugin_name.'</a></li>';
           }
        }
        ?>
     </ul>
    </div>
    
  </div>
