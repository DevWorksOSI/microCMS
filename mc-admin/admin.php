<?php
/*
admin.php
@package microCMS
@sub_package admin
Description: Administrative functional dashboard for the microCMS
*/
/*
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__))
{
	header("Location: /");
}
else
{
*/
   echo '<link rel="stylesheet" href="/mc-admin/css/admin.css">';
   /*
    * Function operatives
    * Set the operation variable for the switch
   */
   if (isset($_GET['op']))
   {
      $d = $_GET['op'];
   }
   elseif (isset($_POST['op']))
   { // Forms
      $d = $_POST['op'];
   } 
   else
   {
      $d = NULL;
   }
   $admin = $_SESSION['admin'];
   if($admin == 0)
   {
      header("Location: /");
   }
   else
   { 
      // Display the page & contents
      echo '<div class="container-fluid">';
      require_once('mc-admin/inc/admin_header.php');
      require_once('mc-admin/inc/admin_menu.php');
      $query = "SELECT * FROM mc_plugins WHERE plugin_type = 1";
      $result = $db->query($query);
      $finished = false;
      while($row = $db->fetch_assoc($result))
      {
         $plugin = $row['plugin_slug'];
         if ($d === $plugin)
         {
            $content = 'mc-content/plugins/'.$plugin.'/admin/'.$plugin.'-admin.php';
            $finished = true;
            break;
         }
         if ($d === 'blogs')
         {
            $content = 'mc-includes/core_plugins/blogs/admin/blogs-admin.php';
            $finished = true;
            break;
         }
         if ($d === 'settings')
         {
            $content = 'mc-includes/core_plugins/settings-admin.php';
            $finished = true;
            break;
         }
         if ($d === 'users')
         {
            $content = 'mc-includes/core_plugins/account/admin/users-admin.php';
            $finished = true;
            break;
         }
      }
      if (!$finished)
      {
         $content = 'mc-admin/admin_page.php';
      }
      echo '<div class="middle">';
      include $content;
      echo '</div>';
      echo '</div>';
      require_once('mc-admin/inc/admin_footer.php');
      echo '</div>';
   }
//}
