<?php
/*
Plugin name: Repository
Text Domain: repository
Author: Scott Cilley <scilley@dwosi.us>
Author URI: https://www.dwosi.us
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Description: Public Repository Plugin for the microCMS, microCMS.ORG
Requires at least: Since 1.5
Requires PHP: 7.4.8
Version: 0.1.0
*/
$db = new database\db;
?>
<link rel="stylesheet" href="mc-content/plugins/repository/public/css/style.css">
<div class="container">
      <h1>Plugins</h1>
      <p>What Plugins we have approved, as always, see the <code>readme.tx</code> that comes with each Plugin to see how they work.</p>
</div>
<div class="container">
   <div class="row">
        <?php
        
        /*
         * Data
         * Pull Product information from mc_repository where type is plugin and approved is yes
         * @type ( 1 = Plugin, 2 = Theme )
         * @title
         * @category ( 1 = Development, 2 = Display )
         * @sub_category ( 1 = Plugins, 2 = Themes )
         * @content
         * @creator
         * @creator_url
         * @creator_email
         * @pub_date
         * @version
         * @approved ( 1 = Yes, 0 = No )
        */
        $query = "SELECT * from mc_repository WHERE type = 1 AND approved = 1";
        $result = $db->query($query);
        while($plugins = $db->fetch_assoc($result))
        //$data = $db->fetch_assoc($result);
        //foreach(array($data) as $plugins)
        {
          $plugin_title = $plugins['title'];
          $plugin_text = $plugins['content'];
          $plugin_category = $plugins['category'];
          $plugin_subcat = $plugins['sub_category'];
          $plugin_creator = $plugins['creator'];
          $plugin_version = $plugins['version'];
          $plugin_slug = $plugins['slug'];
          $file_link = '/files/plugins/'.$plugin_slug.'-'.$plugin_version.'.zip';
          $version_date = date("l, F d, Y",strtotime($plugins['pub_date']));
          if($plugin_category == 1)
          {
             $category = 'Development';
          }
          else if($plugin_category == 2)
          {
             $category = 'Display';
          }
          else
          {
             $category = 'Uncategorized';
          }
          
          // Sub Category
          if($plugin_subcat == 1)
          {
            $sub_cat = 'Plugins';
          }
          else if ($plugin_subcat == 2)
          {
            $sub_cat = 'Themes';
          }
          else
          {
             $sub_cat = 'None';
          }
          echo '<div class="col-lg-6 col-sm-6 col-6">';
          echo '<div class="card">';
          echo '<img src="/mc-includes/images/plugins/'.$plugin_slug.'.png" alt="'.$plugin_title.'" class="card-img-top" height="200" width="100">';
          echo '<div class="card-body">';
          echo '<h4 class="card-title"> '.$plugin_title.'</h4>';
          echo '<p class="card-text">'.$plugin_text.'</p>';
          echo '<div class="card-footer"><p><small><strong>Version:</strong> '.$plugin_version.'<br><strong>Creator:</strong> '.$plugin_creator.'<br><strong>Approved:</strong> '.$version_date.'<br><strong>Category:</strong> '.$category.', '.$sub_cat.'</small></p><p><a href="'.$file_link.'"><button type="button" class="btn btn-secondary">Download</button></a></p></div>';
          echo '</div>';
          echo '</div>';
          echo '<br>';
          echo '</div>';
         }
         if(isset($_SESSION['username']))
         {
            echo '<p><a href="/dev/plugin_upload">Developer Upload</a></p>';
         }
         ?>
   </div>
</div>
