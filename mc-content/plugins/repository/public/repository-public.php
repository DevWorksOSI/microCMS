<?php
/*
Plugin name: Repository
Text Domain: repository
Author: Scott Cilley <scilley@dwosi.us>
Author URI: https://www.dwosi.us
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Description: Public Repository Plugin for the microCMS, @ microCMS.ORG
Requires at least: Since 1.5
Requires PHP: 7.4.8
Version: 0.1.0
*/

echo '<div class="container">';
echo '<h2>microCMS Repository</h2>';
echo '<p>Click the Category to see what we currently have in our repository</p>';
echo '<div class="row">';
echo '<div class="col-lg">';
/*
    * Data
    * Pull Product information from mc_repository
    * @type
    * @title
    * @content
    * @creator
    * @creator_url
    * @creator_email
    * @pub_date
   */
   
   // Instantiate a new class call for db
   $db = new database\db;
   $query = "SELECT type FROM mc_repository";
   $result = $db->query($query);
   while($products = $db->fetch_assoc($result))
   {
      $product_type = $products['type'];
      if($product_type == 1)
      {
         $link = '<h4><i class="fa fa-plug" aria-hidden="true"></i> <a href="plugins">Plugins</a></h4>';
      }
      else if($product_type == 2)
      {
         $link = '<h4><i class="fa fa-camera-retro"></i> <a href="themes">Themes</a></h4>';
      }
      else
      {
         $link = 'Unknown';
      }
      echo $link;
   }
echo '</div>';
echo '</div>';
echo '</div>';
